<?php namespace Arcanedev\Sanitizer\Tests;

use Arcanedev\Sanitizer\Sanitizor;

class SanitizorTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Sanitizor */
    private $sanitizor;

    const SANITIZOR_CLASS = 'Arcanedev\Sanitizer\Sanitizor';

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
    /**
     * @test
     */
    public function testCanBeInstantiated()
    {
        $this->assertInstanceOf(self::SANITIZOR_CLASS, $this->sanitizor);
    }

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

        $this->sanitizor = Sanitizor::make($data, $rules);

        $this->assertEquals([
            'lastname' => "John",
            'firstname' => "DOE",
            'email' => "john.doe@email.com",
        ], $this->sanitizor);
    }
}
