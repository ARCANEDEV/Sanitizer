<?php namespace Arcanedev\Sanitizer\Tests\Laravel;

use Arcanedev\Sanitizer\Laravel\ServiceProvider;
use Arcanedev\Sanitizer\Tests\LaravelTestCase;

class ServiceProviderTest extends LaravelTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var ServiceProvider */
    private $serviceProvider;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->serviceProvider = new ServiceProvider($this->app);
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->serviceProvider);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @test
     */
    public function testCanGetWhatHeProvides()
    {
        // This is for 100% code converge
        $this->assertEquals([
            'arcanedev.sanitizer'
        ], $this->serviceProvider->provides());
    }
}
