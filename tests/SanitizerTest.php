<?php namespace Arcanedev\Sanitizer\Tests;

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
    /** @var Sanitizer  */
    private $sanitizer;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->sanitizer = new Sanitizer($this->filters);
    }

    public function tearDown()
    {
        unset($this->sanitizer);

        parent::tearDown();
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
    public function it_can_sanitize()
    {
        $sanitized = $this->sanitizer->sanitize([
            'last_name'  => 'john  ',
            'first_name' => '  doe',
            'email'      => 'John.DOE@EmAiL.com  '
        ], [
            'last_name'  => 'trim|uppercase',
            'first_name' => 'trim|capitalize',
            'email'      => 'email'
        ]);

        $this->assertEquals([
            'last_name'  => 'JOHN',
            'first_name' => 'Doe',
            'email'      => 'john.doe@email.com',
        ], $sanitized);
    }

    /** @test */
    public function it_can_sanitize_with_default_filters()
    {
        $this->sanitizer = new Sanitizer;

        $sanitized = $this->sanitizer->sanitize([
            'last_name'  => 'john  ',
            'first_name' => '  doe',
            'email'      => 'John.DOE@EmAiL.com  '
        ], [
            'last_name'  => 'trim|uppercase',
            'first_name' => 'trim|capitalize',
            'email'      => 'email'
        ]);

        $this->assertEquals([
            'last_name'  => 'JOHN',
            'first_name' => 'Doe',
            'email'      => 'john.doe@email.com',
        ], $sanitized);
    }

    /** @test */
    public function it_can_sanitize_with_extra_pipe()
    {
        $sanitized = $this->sanitizer->sanitize([
            'email'      => 'John.DOE@EmAiL.com  '
        ], [
            'email'      => 'email|'
        ]);

        $this->assertEquals([
            'email'      => 'john.doe@email.com',
        ], $sanitized);
    }

    /** @test */
    public function it_can_set_sanitizer_rules()
    {
        $sanitized = $this->sanitizer
            ->setRules(['user_email' => 'email'])
            ->sanitize([
                'user_email' => 'FOO@BAR.COM '
            ]);

        $this->assertEquals([
            'user_email' => 'foo@bar.com'
        ], $sanitized);
    }

    /** @test */
    public function it_can_skip_rules_if_data_not_exists()
    {
        $sanitized = $this->sanitizer->sanitize([
            'email' => 'FOO@BAR.COM '
        ],[
            'email' => 'email',
            'url'   => 'url',
        ]);

        $this->assertEquals([
            'email' => 'foo@bar.com'
        ], $sanitized);
    }

    /**
     * @test
     *
     * @expectedException  \Arcanedev\Sanitizer\Exceptions\InvalidFilterException
     */
    public function it_must_throw_invalid_filter_exception_on_empty_filters()
    {
        $this->sanitizer->sanitize([
            'email' => 'FOO@BAR.COM '
        ],[
            'email' => '',
        ]);
    }

    /** @test */
    public function it_can_sanitize_by_custom_sanitizer()
    {
        $data = [
            'title'     => 'Slugify this title',
        ];

        $rules = [
            'title' => 'slug'
        ];

        $this->registerSlugSanitizer();

        $this->assertEquals([
            'title' => 'slugify-this-title'
        ], $this->sanitizer->sanitize($data, $rules));
    }

    /** @test */
    public function it_can_sanitize_with_missing_rules()
    {
        $data = [
            'slug'     => 'Slugify this title',
            'content'  => 'Hello world',
        ];

        $rules = [
            'slug' => 'slug'
        ];

        $this->registerSlugSanitizer();

        $this->assertEquals([
            'slug'      => 'slugify-this-title',
            'content'   => 'Hello world',
        ], $this->sanitizer->sanitize($data, $rules));
    }

    /** @test */
    public function it_can_sanitize_with_options()
    {
        $sanitized = $this->sanitizer->sanitize([
            'date' => '21/12/1991',
        ], [
            'date' => 'format_date:d/m/Y, Y-m-d',
        ]);

        $this->assertEquals([
            'date' => '1991-12-21'
        ], $sanitized);
    }

    /**
     * @test
     *
     * @expectedException         \Arcanedev\Sanitizer\Exceptions\FilterNotFoundException
     * @expectedExceptionMessage  No filter found by the name of sterilize
     */
    public function it_must_throw_sanitize_method_not_found()
    {
        $this->sanitizer->sanitize([
            'email' => ' hello@GMAIL.com  '
        ], [
            'email' => 'sterilize',
        ]);
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
        $this->sanitizer->setFilters([
            'slug'  => function ($value) {
                return str_replace(' ', '-', strtolower(trim($value)));
            }
        ]);
    }
}
