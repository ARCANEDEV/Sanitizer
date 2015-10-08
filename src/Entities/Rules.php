<?php namespace Arcanedev\Sanitizer\Entities;

use Arcanedev\Sanitizer\Exceptions\InvalidFilterException;

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
     * @throws InvalidFilterException
     */
    protected function parseRules(array $rules)
    {
        $parsedRules = [];

        foreach ($rules as $attribute => $filters) {
            if (empty($filters)) {
                throw new InvalidFilterException;
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
}
