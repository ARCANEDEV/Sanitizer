<?php namespace Arcanedev\Sanitizer\Tests;

use Arcanedev\Sanitizer\Tests\Stubs\EmptySanitizer;
use Arcanedev\Sanitizer\Tests\Stubs\UserSanitizer;

use Arcanedev\Sanitizer\Sanitizer;

class SanitizerTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @var Sanitizer
     */
    protected $sanitizer;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        $this->sanitizer = new UserSanitizer;
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
        $this->assertInstanceOf(
            'Arcanedev\\Sanitizer\\Sanitizer',
            $this->sanitizer
        );
    }

    /**
     * @test
     */
    public function testCanSetSanitizerStringRules()
    {
        $this->sanitizer->setRules([
            'email' => 'trim|strtolower'
        ]);

        $sanitized = $this->sanitizer->sanitize([
            'email' => 'FOO@BAR.COM '
        ]);

        $this->assertEquals([
            'email' => 'foo@bar.com'
        ], $sanitized);
    }

    /**
     * @test
     */
    public function testCanSkipRulesIfDataNotExists()
    {
        $this->sanitizer->setRules([
            'email' => 'trim|strtolower',
            'url'   => 'url',
        ]);

        $sanitized = $this->sanitizer->sanitize([
            'email' => 'FOO@BAR.COM '
        ]);

        $this->assertEquals([
            'email' => 'foo@bar.com'
        ], $sanitized);
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Sanitizer\Exceptions\InvalidSanitizersException
     */
    public function testMustThrowInvalidSanitizersExceptionOnEmptyString()
    {
        $data = [
            'email' => 'FOO@BAR.COM '
        ];

        $rules = [
            'email' => '',
        ];

        $this->sanitizer->sanitize($data, $rules);
    }

    /**
     * @test
     */
    public function testCanSetSanitizerArrayRules()
    {
        $this->sanitizer->setRules([
            'email' => ['trim', 'strtolower'],
        ]);

        $sanitized = $this->sanitizer->sanitize([
            'email' => 'FOO@BAR.COM '
        ]);

        $this->assertEquals([
            'email' => 'foo@bar.com'
        ], $sanitized);
    }

    /**
     * @test
     */
    public function testCanSanitizeByPhpFunctions()
    {
        $data = [
            'email' => ' hello@GMAIL.com  '
        ];

        $rules = [
            'email' => 'trim|strtolower',
        ];

        $data = $this->sanitizer->sanitize($data, $rules);

        $this->assertEquals(['email' => 'hello@gmail.com'], $data);
    }

    /**
     * @test
     */
    public function testCanSanitizeByClassMethodsOne()
    {
        $data = [
            'message' => 'hElLo !'
        ];

        $rules = [
            'message' => 'helloMessage',
        ];

        $this->assertEquals(['message' => 'Hello !'], $this->sanitizer->sanitize($data, $rules));
    }

    /**
     * @test
     */
    public function testCanSanitizeByClassMethodsTwo()
    {
        $data = [
            'email' => 'hello@GMAIL.com'
        ];

        $rules = [
            'email' => 'email',
        ];

        $this->assertEquals(['email' => 'hello@gmail.com'], $this->sanitizer->sanitize($data, $rules));
    }

	/**
	 * @test
	 */
	public function testCanSanitizeByClassMethodsThree()
	{
		$data = [
			'web' => 'www.inter net.free ¨ù'
		];

		$rules = [
			'web' => 'url',
		];

		$this->assertEquals(['web' => 'http://www.internet.free'], $this->sanitizer->sanitize($data, $rules));
	}

    /**
     * @test
     */
    public function testCanSanitizeByCustomSanitizer()
    {
        $data = [
            'title' => 'Slugify this title',
        ];

        $rules = [
            'title' => 'slug'
        ];

        $this->registerSlugSanitizer();

        $this->assertEquals([
            'title' => 'slugify-this-title'
        ], $this->sanitizer->sanitize($data, $rules));
    }

    /**
     * @test
     * @expectedException \Arcanedev\Sanitizer\Exceptions\InvalidSanitizersException
     */
    public function testMustThrowInvalidSanitizersException()
    {
        $data = [
            'email' => ' hello@GMAIL.com  '
        ];

        $this->sanitizer->sanitize($data, 'trim|ucfirst');
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Sanitizer\Exceptions\InvalidSanitizersException
     */
    public function testMustThrowInvalidSanitizersExceptionOnEmpty()
    {
        $data  = [
            'foo' => 'bar'
        ];

        $rules = [
            'foo' => true
        ];

        $sanitizer = new EmptySanitizer;
        $sanitizer->sanitize($data, $rules);
    }

    /**
     * @test
     * @expectedException \Arcanedev\Sanitizer\Exceptions\SanitizeMethodNotFoundException
     */
    public function testMustThrowSanitizeMethodNotFound()
    {
        $data = [
            'email' => ' hello@GMAIL.com  '
        ];

        $rule = [
            'email' => 'lastname',
        ];

        $this->sanitizer->sanitize($data, $rule);
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Sanitizer\Exceptions\SanitizerMethodAlreadyExistsException
     */
    public function testMustThrowMethodAlreadyExists()
    {
        $this->registerSlugSanitizer();

        $this->registerSlugSanitizer();
    }

    /**
     * @test
     *
     * @expectedException \Arcanedev\Sanitizer\Exceptions\NotCallableException
     */
    public function testMustThrowNotCallableException()
    {
        $this->sanitizer->register('foo', 'bar');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    private function registerSlugSanitizer()
    {
        $this->sanitizer->register('slug', function ($value) {
            return str_replace(' ', '-', strtolower(trim($value)));
        });
    }
}
