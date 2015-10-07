<?php namespace Arcanedev\Sanitizer\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

/**
 * Class     LaravelTestCase
 *
 * @package  Arcanedev\Sanitizer\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class LaravelTestCase extends BaseTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Arcanedev\Sanitizer\SanitizerServiceProvider::class
        ];
    }

    /**
     * Get package aliases.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Sanitizer' => \Arcanedev\Sanitizer\Facades\Sanitizer::class
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getEnvironmentSetUp($app)
    {
        //
    }
}
