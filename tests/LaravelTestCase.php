<?php namespace Arcanedev\Sanitizer\Tests;

abstract class LaravelTestCase extends \Orchestra\Testbench\TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register Service Providers
     *
     * @return array
     */
    protected function getPackageProviders()
    {
        return [
            'Arcanedev\Sanitizer\Laravel\ServiceProvider'
        ];
    }

    /**
     * Register Aliases
     *
     * @return array
     */
    protected function getPackageAliases()
    {
        return [
            'Sanitizer' => 'Arcanedev\Sanitizer\Laravel\Facade'
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
    }
}
