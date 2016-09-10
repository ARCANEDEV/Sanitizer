<?php namespace Arcanedev\Sanitizer\Filters;

use Arcanedev\Sanitizer\Contracts\Filterable;
use Illuminate\Support\Str;

/**
 * Class     EmailFilter
 *
 * @package  Arcanedev\Sanitizer\Filters
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class EmailFilter implements Filterable
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Sanitize email of the given string.
     *
     * @param  mixed  $value
     * @param  array  $options
     *
     * @return string|mixed
     */
    public function filter($value, array $options = [])
    {
        return is_string($value)
            ? filter_var(Str::lower(trim($value)), FILTER_SANITIZE_EMAIL)
            : $value;
    }
}
