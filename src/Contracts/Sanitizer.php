<?php namespace Arcanedev\Sanitizer\Contracts;

/**
 * Interface  Sanitizer
 *
 * @package   Arcanedev\Sanitizer\Contracts
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface Sanitizer
{
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
    public function setFilters(array $filters);

    /**
     * Set rules.
     *
     * @param  array  $rules
     *
     * @return self
     */
    public function setRules(array $rules);

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
    public function sanitize(array $data, array $rules = [], array $filters = []);
}
