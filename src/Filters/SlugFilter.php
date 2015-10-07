<?php namespace Arcanedev\Sanitizer\Filters;

use Arcanedev\Sanitizer\Contracts\Filterable;

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
     * @param  string $value
     * @param  array  $options
     *
     * @return string
     */
    public function filter($value, array $options = [])
    {
        return str_slug($value);
    }
}
