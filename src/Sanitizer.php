<?php namespace Arcanedev\Sanitizer;

use Arcanedev\Sanitizer\Contracts\Filterable;
use Arcanedev\Sanitizer\Contracts\SanitizerInterface;
use Arcanedev\Sanitizer\Entities\Rules;
use Closure;

/**
 * Class     Sanitizer
 *
 * @package  Arcanedev\Sanitizer
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Sanitizer implements SanitizerInterface
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Available filters.
     *
     * @var array
     */
    protected $filters = [];

    /**
     * Rules to sanitize.
     *
     * @var Rules
     */
    protected $rules;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Create a new sanitizer instance.
     *
     * @param  array  $filters
     */
    public function __construct(array $filters = [])
    {
        $this->setFilters($filters);
        $this->rules = new Rules;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Set filters.
     *
     * @param  array  $filters
     *
     * @return self
     */
    public function setFilters(array $filters)
    {
        $this->filters = array_merge(
            $this->filters,
            $filters
        );

        return $this;
    }

    /**
     * Set rules.
     *
     * @param  array  $rules
     *
     * @return self
     */
    public function setRules(array $rules)
    {
        $this->rules->set($rules);

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Sanitize the given data.
     *
     * @param  array  $data
     * @param  array  $rules
     * @param  array  $filters
     *
     * @return array
     */
    public function sanitize(array $data, array $rules = [], array $filters = [])
    {
        $this->setRules($rules);
        $this->setFilters($filters);

        foreach ($data as $name => $value) {
            $data[$name] = $this->sanitizeAttribute($name, $value);
        }

        return $data;
    }

    /**
     * Sanitize the given attribute
     *
     * @param  string  $attribute
     * @param  mixed   $value
     *
     * @return mixed
     */
    protected function sanitizeAttribute($attribute, $value)
    {
        foreach ($this->rules->get($attribute) as $rule) {
            $value = $this->applyFilter($rule['name'], $value, $rule['options']);
        }

        return $value;
    }

    /**
     * Apply the given filter by its name.
     *
     * @param  string  $name
     * @param  mixed   $value
     * @param  array   $options
     *
     * @return mixed
     */
    protected function applyFilter($name, $value, $options = [])
    {
        $this->hasFilter($name);

        if (empty($value)) return $value;

        $filter = $this->filters[$name];

        if ($filter instanceof Closure) {
            return call_user_func_array($filter, compact('value', 'options'));
        }

        /** @var Filterable $filterable */
        $filterable = new $filter;

        return $filterable->filter($value, $options);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check has filter, if does not exist, throw an Exception.
     *
     * @param  string  $name
     *
     * @throws Exceptions\FilterNotFoundException
     */
    private function hasFilter($name)
    {
        if ( ! isset($this->filters[$name])) {
            throw new Exceptions\FilterNotFoundException(
                "No filter found by the name of $name"
            );
        }
    }
}
