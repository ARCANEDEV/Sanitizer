<?php namespace Arcanedev\Sanitizer;

use Arcanedev\Sanitizer\Contracts\Filterable;
use Arcanedev\Sanitizer\Contracts\SanitizerInterface;
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
     * @var array
     */
    protected $rules = [];

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
        $this->rules = array_merge(
            $this->rules,
            $this->parseRules($rules)
        );

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
     * Parse a rules array.
     *
     * @param  array  $rules
     *
     * @return array
     *
     * @throws Exceptions\InvalidFilterException
     */
    protected function parseRules(array $rules)
    {
        $parsedRules = [];

        foreach ($rules as $attribute => $filters) {
            if (empty($filters)) {
                throw new Exceptions\InvalidFilterException();
            }

            foreach (explode('|', $filters) as $filter) {
                if ($parsedFilter = $this->parseRule($filter)) {
                    $parsedRules[$attribute][] = $parsedFilter;
                }
            }
        }

        return $parsedRules;
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
        if ( ! isset($this->rules[$attribute])) {
            return $value;
        }

        foreach ($this->rules[$attribute] as $rule) {
            $value = $this->applyFilter($rule['name'], $value, $rule['options']);
        }

        return $value;
    }

    /**
     * Parse a rule.
     *
     * @param  string $rule
     *
     * @return array
     */
    protected function parseRule($rule)
    {
        $name    = $rule;
        $options = [];

        if (str_contains($rule, ':')) {
            list($name, $options) = explode(':', $rule, 2);
            $options              = array_map('trim', explode(',', $options));
        }

        return empty($name) ? [] : compact('name', 'options');
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
