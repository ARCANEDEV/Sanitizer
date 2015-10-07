<?php namespace Arcanedev\Sanitizer\Tests;

use Arcanedev\Sanitizer\SanitizerServiceProvider;

/**
 * Class     SanitizerServiceProviderTest
 *
 * @package  Arcanedev\Sanitizer\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class SanitizerServiceProviderTest extends LaravelTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var SanitizerServiceProvider */
    private $provider;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->provider = $this->app->getProvider(SanitizerServiceProvider::class);
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->provider);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_get_what_it_provides()
    {
        // This is for 100% code converge
        $this->assertEquals([
            'arcanedev.sanitizer'
        ], $this->provider->provides());
    }

    /** @test */
    public function it_can_get_base_path()
    {
        $this->assertTrue(is_dir($this->provider->getBasePath()));
    }
}
