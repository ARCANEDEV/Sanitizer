<?php namespace Arcanedev\Sanitizer\Filters;

use Arcanedev\Sanitizer\Contracts\Filterable;

/**
 * Class     LowercaseFilter
 *
 * @package  Arcanedev\Sanitizer\Filters
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class LowercaseFilter implements Filterable
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Lowercase the given string.
     *
     * @param  mixed  $value
     * @param  array  $options
     *
     * @return string|mixed
     */
    public function filter($value, array $options = [])
    {
        if ( ! is_string($value)) {
            return $value;
        }

        return strtolower($value);
    }
}
