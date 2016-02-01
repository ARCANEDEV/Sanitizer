<?php namespace Arcanedev\Sanitizer\Tests\Http;

use Arcanedev\Sanitizer\Tests\LaravelTestCase;
use Arcanedev\Sanitizer\Tests\Stubs\DummyRequest;

/**
 * Class     FormRequestTest
 *
 * @package  Arcanedev\Sanitizer\Tests\Http
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class FormRequestTest extends LaravelTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->registerRoutes();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_sanitize_form_request()
    {
        $this->call('POST', 'dummy', [
            'email'  => '  (My@eMaIl.CoM) ',
        ]);

        $this->assertEquals([
            'email' => 'my@email.com'
        ], json_decode($this->response->content(), true));
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    private function registerRoutes()
    {
        /** @var \Illuminate\Routing\Router $router */
        $router = app('router');

        $router->post('dummy', [
            'as'    => 'dummy',
            'uses'  => function (DummyRequest $request) {
                return $request->all();
            },
        ]);
    }
}
