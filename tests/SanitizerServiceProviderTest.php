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
        unset($this->provider);

        parent::tearDown();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_provides()
    {
        $expected = [
            'arcanedev.sanitizer'
        ];

        $this->assertEquals($expected, $this->provider->provides());
    }

    /** @test */
    public function it_can_get_base_path()
    {
        $this->assertTrue(is_dir($this->provider->getBasePath()));
    }
}
