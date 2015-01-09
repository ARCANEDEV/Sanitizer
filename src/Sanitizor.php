<?php namespace Arcanedev\Sanitizer;

class Sanitizor extends Sanitizer
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public static function make(array $data, array $rules)
    {
        return (new self)->sanitize($data, $rules);
    }
}
