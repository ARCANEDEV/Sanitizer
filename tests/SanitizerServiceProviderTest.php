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
            \Arcanedev\Sanitizer\Contracts\Sanitizer::class,
            'arcanedev.sanitizer',
        ];

        $this->assertEquals($expected, $this->provider->provides());
    }
}
