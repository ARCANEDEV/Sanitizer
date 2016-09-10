<?php namespace Arcanedev\Sanitizer\Filters;

use Arcanedev\Sanitizer\Contracts\Filterable;
use Illuminate\Support\Str;

/**
 * Class     SlugFilter
 *
 * @package  Arcanedev\Sanitizer\Filters
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class SlugFilter implements Filterable
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Function
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Filter the value.
     *
     * @param  mixed  $value
     * @param  array  $options
     *
     * @return string|mixed
     */
    public function filter($value, array $options = [])
    {
        return is_string($value) ? Str::slug($value) : $value;
    }
}
