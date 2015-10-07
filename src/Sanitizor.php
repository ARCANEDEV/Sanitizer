<?php namespace Arcanedev\Sanitizer;

/**
 * Class     Sanitizor
 *
 * @package  Arcanedev\Sanitizer
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Sanitizor extends Sanitizer
{
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
    public static function make(array $data, array $rules)
    {
        return (new self)->sanitize($data, $rules);
    }
}
