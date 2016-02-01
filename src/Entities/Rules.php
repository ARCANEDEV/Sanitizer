<?php namespace Arcanedev\Sanitizer\Entities;

use Arcanedev\Sanitizer\Exceptions\InvalidFilterException;

/**
 * Class     Rules
 *
 * @package  Arcanedev\Sanitizer\Entities
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Rules
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var array */
    protected $items = [];

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Rules constructor.
     */
    public function __construct()
    {
        $this->items = [];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Set multiple rules.
     *
     * @param  array  $rules
     *
     * @return $this
     */
    public function set(array $rules)
    {
        $this->items = array_merge(
            $this->items,
            $this->parseRules($rules)
        );

        return $this;
    }

    /**
     * Check attribute if has a rule.
     *
     * @param  string  $attribute
     *
     * @return bool
     */
    public function has($attribute)
    {
        return isset($this->items[$attribute]);
    }

    /*
     * Get the attribute filters.
     *
     * @param  string  $attribute
     *
     * @return array
     */
    public function get($attribute)
    {
        return $this->has($attribute) ? $this->items[$attribute] : [];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Parse a rules array.
     *
     * @param  array  $rules
     *
     * @return array
     *
     * @throws \Arcanedev\Sanitizer\Exceptions\InvalidFilterException
     */
    protected function parseRules(array $rules)
    {
        $parsedRules = [];

        foreach ($rules as $attribute => $filters) {
            if (empty($filters)) {
                throw new InvalidFilterException(
                    "The attribute [$attribute] must contain at least one filter."
                );
            }

            $this->parseAttributeFilters($parsedRules, $attribute, $filters);
        }

        return $parsedRules;
    }

    /**
     * Parse attribute's filters.
     *
     * @param  array   $parsedRules
     * @param  string  $attribute
     * @param  string  $filters
     */
    protected function parseAttributeFilters(array &$parsedRules, $attribute, $filters)
    {
        foreach (explode('|', $filters) as $filter) {
            $parsedFilter = $this->parseRule($filter);

            if ( ! empty($parsedFilter)) {
                $parsedRules[$attribute][] = $parsedFilter;
            }
        }
    }

    /**
     * Parse a rule.
     *
     * @param  string  $rule
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
}
