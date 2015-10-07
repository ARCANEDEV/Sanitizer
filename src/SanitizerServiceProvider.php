<?php namespace Arcanedev\Sanitizer;

use Arcanedev\Support\PackageServiceProvider as ServiceProvider;

/**
 * Class     SanitizerServiceProvider
 *
 * @package  Arcanedev\Sanitizer
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class SanitizerServiceProvider extends ServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Vendor name.
     *
     * @var string
     */
    protected $vendor  = 'arcanedev';

    /**
     * Package name.
     *
     * @var string
     */
    protected $package = 'sanitizer';

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the base path of the package.
     *
     * @return string
     */
    public function getBasePath()
    {
        return dirname(__DIR__);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerSanitizer();
    }

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['arcanedev.sanitizer'];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register Helpers.
     */
    private function registerSanitizer()
    {
        $this->singleton('arcanedev.sanitizer', Sanitizor::class);
    }
}
