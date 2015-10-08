<?php namespace Arcanedev\Sanitizer;

use Arcanedev\Sanitizer\Contracts\Filterable;
use Closure;

/**
 * Class     Factory
 *
 * @package  Arcanedev\Sanitizer
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Factory
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     *  List of custom filters
     *
     *  @var array
     */
    protected $filters = [];

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Create a new instance.
     *
     * @param  array  $filters
     */
    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make a sanitizer
     *
     * @param  array  $data
     * @param  array  $rules
     *
     * @return array
     */
    public function make(array $data, array $rules)
    {
        $sanitizer = new Sanitizer($this->filters);

        return $sanitizer->sanitize($data, $rules);
    }

    /**
     *  Add a custom filters to all Sanitizers created with this Factory.
     *
     *  @param  string                      $name
     *  @param  \Closure|Filterable|string  $filter
     *
     *  @throws Exceptions\InvalidFilterException
     */
    public function extend($name, $filter)
    {
        $this->checkName($name);

        if ( ! $filter instanceof Closure) {
            $this->isFilterable($filter);
        }

        $this->filters[$name] = $filter;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check the filter name.
     *
     * @param  string  $name
     *
     * @throws Exceptions\InvalidFilterException
     */
    private function checkName($name)
    {
        if (empty($name) || ! is_string($name)) {
            throw new Exceptions\InvalidFilterException(
                'The Sanitizer filter name must be a non empty string.'
            );
        }
    }

    /**
     * Check if filter is filterable.
     *
     * @param  mixed  $filter
     *
     * @throws Exceptions\InvalidFilterException
     */
    private function isFilterable($filter)
    {
        if (is_string($filter) && ! class_exists($filter)) {
            throw new Exceptions\InvalidFilterException(
                "The [$filter] class does not exits."
            );
        }

        if ( ! in_array(Filterable::class, class_implements($filter))) {
            throw new Exceptions\InvalidFilterException(
                'The filter must be a Closure or a class implementing the Filterable interface.'
            );
        }
    }
}