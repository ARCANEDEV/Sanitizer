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
     * @param  string  $value
     * @param  array   $options
     *
     * @return string
     */
    public function filter($value, array $options = []);
}
