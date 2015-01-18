<?php namespace Arcanedev\Sanitizer\Tests\Laravel;

use Arcanedev\Sanitizer\Laravel\Facade as Sanitizer;
use Arcanedev\Sanitizer\Tests\LaravelTestCase;

class FacadeTest extends LaravelTestCase
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
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @test
     */
    public function testCanMakeSanitizer()
    {
        $rules = [
            'lastname'  => 'trim|strtolower|ucfirst',
            'firstname' => 'trim|strtoupper',
            'email'     => 'trim|strtolower'
        ];

        $data = [
            'lastname'  => 'john',
            'firstname' => 'doe',
            'email'     => 'John.DOE@EmAiL.com'
        ];

        $this->assertEquals([
            'lastname' => "John",
            'firstname' => "DOE",
            'email' => "john.doe@email.com",
        ], Sanitizer::make($data, $rules));
    }
}
