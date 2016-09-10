<?php namespace Arcanedev\Sanitizer\Filters;

use Arcanedev\Sanitizer\Contracts\Filterable;
use Illuminate\Support\Str;

/**
 * Class     UppercaseFilter
 *
 * @package  Arcanedev\Sanitizer\Filters
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UppercaseFilter implements Filterable
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
        return is_string($value) ? Str::upper($value) : $value;
    }
}
