<?php namespace Arcanedev\Sanitizer\Filters;

use Arcanedev\Sanitizer\Contracts\Filterable;
use Illuminate\Support\Str;

/**
 * Class     UrlFilter
 *
 * @package  Arcanedev\Sanitizer\Filters
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UrlFilter implements Filterable
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Sanitize url of the given string.
     *
     * @param  mixed  $value
     * @param  array  $options
     *
     * @return string|mixed
     */
    public function filter($value, array $options = [])
    {
        if ( ! is_string($value)) return $value;

        $value = trim($value);

        if ( ! Str::startsWith($value, ['http://', 'https://'])) {
            $value = "http://$value";
        }

        return filter_var($value, FILTER_SANITIZE_URL);
    }
}
