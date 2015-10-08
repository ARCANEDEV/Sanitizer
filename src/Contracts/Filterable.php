<?php namespace Arcanedev\Sanitizer\Contracts;

/**
 * Interface  Filterable
 *
 * @package   Arcanedev\Sanitizer\Contracts
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface Filterable
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Filter the value.
     *
     * @param  mixed  $value
     * @param  array  $options
     *
     * @return mixed
     */
    public function filter($value, array $options = []);
}
