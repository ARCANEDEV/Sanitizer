<?php namespace Arcanedev\Sanitizer\Tests;

use Arcanedev\Sanitizer\Sanitizer;
use Arcanedev\Sanitizer\Sanitizor;

/**
 * Class     SanitizorTest
 *
 * @package  Arcanedev\Sanitizer\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class SanitizorTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Sanitizor */
    private $sanitizor;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->sanitizor = new Sanitizor;
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->sanitizor);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(Sanitizor::class, $this->sanitizor);
        $this->assertInstanceOf(Sanitizer::class, $this->sanitizor);
    }

    /** @test */
    public function it_can_make_sanitizer()
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

        $this->sanitizor = Sanitizor::make($data, $rules);

        $this->assertEquals([
            'lastname' => "John",
            'firstname' => "DOE",
            'email' => "john.doe@email.com",
        ], $this->sanitizor);
    }
}
