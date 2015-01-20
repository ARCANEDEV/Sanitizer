<?php namespace Arcanedev\Sanitizer\Laravel;

use Arcanedev\Sanitizer\Sanitizor;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package(
            'arcanedev/sanitizer',
            'sanitizer',
            realpath(__DIR__ . '/..')
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerHelpers();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'arcanedev.sanitizer'
        ];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register Helpers
     *
     * @return void
     */
    private function registerHelpers()
    {
        $this->app->bindShared('arcanedev.sanitizer', function () {
            return new Sanitizor;
        });
    }
}
