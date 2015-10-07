<?php namespace Arcanedev\Sanitizer;

use Arcanedev\Sanitizer\Contracts\Filterable;
use Closure;
use InvalidArgumentException;

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
     *  @param  string  $name
     *  @param  mixed   $filter
     *
     *  @throws InvalidArgumentException
     */
    public function extend($name, $filter)
    {
        $this->checkName($name);
        $this->isFilterable($filter);

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
     */
    private function checkName($name)
    {
        if (empty($name) || ! is_string($name)) {
            throw new InvalidArgumentException('The Sanitizer filter name must be a non empty string.');
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
        if ( ! ($filter instanceof Closure || $filter instanceof Filterable)) {
            throw new Exceptions\InvalidFilterException(
                'The filter must be a Closure or a class implementing the Filterable interface.'
            );
        }
    }
}