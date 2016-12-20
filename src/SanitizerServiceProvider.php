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
        $this->registerConfig();
        $this->registerSanitizer();
    }

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        parent::boot();

        $this->publishConfig();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Contracts\Sanitizer::class,
            'arcanedev.sanitizer',
        ];
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
        $this->singleton(Contracts\Sanitizer::class, function ($app) {
            /** @var  \Illuminate\Contracts\Config\Repository  $config */
            $config = $app['config'];

            return new Factory($config->get('sanitizer.filters'));
        });

        $this->singleton('arcanedev.sanitizer', Contracts\Sanitizer::class);
    }
}
