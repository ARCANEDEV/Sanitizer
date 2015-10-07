<?php namespace Arcanedev\Sanitizer\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class     Sanitizer
 *
 * @package  Arcanedev\Sanitizer\Laravel
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Sanitizer extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'arcanedev.sanitizer'; }
}
