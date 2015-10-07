<?php namespace Arcanedev\Sanitizer\Tests;

use Arcanedev\Sanitizer\Tests\Stubs\EmptySanitizer;
use Arcanedev\Sanitizer\Tests\Stubs\UserSanitizer;

use Arcanedev\Sanitizer\Sanitizer;

/**
 * Class     SanitizerTest
 *
 * @package  Arcanedev\Sanitizer\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
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
    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(Sanitizer::class, $this->sanitizer);
    }

    /** @test */
    public function it_can_set_sanitizer_string_rules()
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

    /** @test */
    public function it_can_skip_rules_if_data_not_exists()
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
     * @expectedException  \Arcanedev\Sanitizer\Exceptions\InvalidSanitizersException
     */
    public function it_must_throw_invalid_sanitizers_exception_on_empty_string()
    {
        $data = [
            'email' => 'FOO@BAR.COM '
        ];

        $rules = [
            'email' => '',
        ];

        $this->sanitizer->sanitize($data, $rules);
    }

    /** @test */
    public function it_can_set_sanitizer_array_rules()
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

    /** @test */
    public function it_can_sanitize_by_php_functions()
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

    /** @test */
    public function it_can_sanitize_by_class_methods_one()
    {
        $data = [
            'message' => 'hElLo !'
        ];

        $rules = [
            'message' => 'helloMessage',
        ];

        $this->assertEquals(['message' => 'Hello !'], $this->sanitizer->sanitize($data, $rules));
    }

    /** @test */
    public function it_can_sanitize_by_class_methods_two()
    {
        $data = [
            'email' => 'hello@GMAIL.com'
        ];

        $rules = [
            'email' => 'email',
        ];

        $this->assertEquals(['email' => 'hello@gmail.com'], $this->sanitizer->sanitize($data, $rules));
    }

    /** @test */
    public function it_can_sanitize_by_class_methods_three()
    {
        $data = [
            'web' => 'www.inter net.free ¨ù'
        ];

        $rules = [
            'web' => 'url',
        ];

        $this->assertEquals(['web' => 'http://www.internet.free'], $this->sanitizer->sanitize($data, $rules));
    }

    /** @test */
    public function it_can_sanitize_by_custom_sanitizer()
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
     *
     * @expectedException  \Arcanedev\Sanitizer\Exceptions\InvalidSanitizersException
     */
    public function it_must_throw_invalid_sanitizers_exception()
    {
        $data = [
            'email' => ' hello@GMAIL.com  '
        ];

        $this->sanitizer->sanitize($data, 'trim|ucfirst');
    }

    /**
     * @test
     *
     * @expectedException  \Arcanedev\Sanitizer\Exceptions\InvalidSanitizersException
     */
    public function it_must_throw_invalid_sanitizers_exception_on_empty()
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
     *
     * @expectedException  \Arcanedev\Sanitizer\Exceptions\SanitizeMethodNotFoundException
     */
    public function it_must_throw_sanitize_method_not_found()
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
     * @expectedException  \Arcanedev\Sanitizer\Exceptions\SanitizerMethodAlreadyExistsException
     */
    public function it_must_throw_method_already_exists()
    {
        $this->registerSlugSanitizer();
        $this->registerSlugSanitizer();
    }

    /**
     * @test
     *
     * @expectedException  \Arcanedev\Sanitizer\Exceptions\NotCallableException
     */
    public function it_must_throw_not_callable_exception()
    {
        $this->sanitizer->register('foo', 'bar');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register slug sanitizer.
     */
    private function registerSlugSanitizer()
    {
        $this->sanitizer->register('slug', function ($value) {
            return str_replace(' ', '-', strtolower(trim($value)));
        });
    }
}
