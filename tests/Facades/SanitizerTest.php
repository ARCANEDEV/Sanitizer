<?php namespace Arcanedev\Sanitizer\Tests\Facades;

use Arcanedev\Sanitizer\Facades\Sanitizer;
use Arcanedev\Sanitizer\Tests\LaravelTestCase;

/**
 * Class     SanitizerTest
 *
 * @package  Arcanedev\Sanitizer\Tests\Laravel
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class SanitizerTest extends LaravelTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated_with_contract()
    {
        $this->assertInstanceOf(
            \Arcanedev\Sanitizer\Factory::class,
            $this->app->make(\Arcanedev\Sanitizer\Contracts\Sanitizer::class)
        );
    }

    /** @test */
    public function it_can_be_instantiated_via_helper()
    {
        $this->assertInstanceOf(\Arcanedev\Sanitizer\Factory::class, sanitizer());
    }

    /** @test */
    public function it_can_make_sanitizer()
    {
        $sanitized = Sanitizer::make([
            'last_name'  => 'john',
            'first_name' => 'doe',
            'email'      => 'John.DOE@EmAiL.com'
        ], [
            'last_name'  => 'trim|uppercase',
            'first_name' => 'trim|capitalize',
            'email'      => 'email'
        ]);

        $this->assertSame([
            'last_name'  => 'JOHN',
            'first_name' => 'Doe',
            'email'      => 'john.doe@email.com',
        ], $sanitized);
    }

    /** @test */
    public function it_can_extend_sanitizer()
    {
        Sanitizer::extend('rekt', function ($value) {
            return strtoupper($value) . ' ! GET REKT !';
        });

        $sanitized = Sanitizer::make([
            'last_name'  => 'john',
            'first_name' => 'doe',
            'email'      => 'John.DOE@EmAiL.com',
            'status'     => 'wasted',
        ], [
            'last_name'  => 'trim|uppercase',
            'first_name' => 'trim|capitalize',
            'email'      => 'email',
            'status'     => 'rekt',
        ]);

        $this->assertSame([
            'last_name'  => 'JOHN',
            'first_name' => 'Doe',
            'email'      => 'john.doe@email.com',
            'status'     => 'WASTED ! GET REKT !',
        ], $sanitized);
    }

    /** @test */
    public function it_can_extend_filter_from_string()
    {
        Sanitizer::extend('slug', \Arcanedev\Sanitizer\Filters\SlugFilter::class);

        $sanitized = Sanitizer::make(['slug' => 'Hello world'], ['slug' => 'slug']);

        $this->assertSame(['slug' => 'hello-world'], $sanitized);
    }

    /**
     * @test
     *
     * @expectedException         \Arcanedev\Sanitizer\Exceptions\InvalidFilterException
     * @expectedExceptionMessage  The Sanitizer filter name must be a non empty string.
     */
    public function it_must_throw_invalid_filter_exception_on_empty_name()
    {
        Sanitizer::extend('', function ($value) {
            return 'Empty name';
        });
    }

    /**
     * @test
     *
     * @expectedException         \Arcanedev\Sanitizer\Exceptions\InvalidFilterException
     * @expectedExceptionMessage  The Sanitizer filter name must be a non empty string.
     */
    public function it_must_throw_invalid_filter_exception_on_invalid_name_type()
    {
        Sanitizer::extend(true, function ($value) {
            return 'What ??';
        });
    }

    /**
     * @test
     *
     * @expectedException         \Arcanedev\Sanitizer\Exceptions\InvalidFilterException
     * @expectedExceptionMessage  The [Vendor\Package\Filters\NotRealFilter] class does not exits.
     */
    public function it_must_throw_invalid_filter_exception_on_filterable()
    {
        Sanitizer::extend('real', 'Vendor\\Package\\Filters\\NotRealFilter');
    }

    /**
     * @test
     *
     * @expectedException         \Arcanedev\Sanitizer\Exceptions\InvalidFilterException
     * @expectedExceptionMessage  The filter must be a Closure or a class implementing the Filterable interface.
     */
    public function it_must_throw_invalid_filter_exception_on_filterable_two()
    {
        Sanitizer::extend('filterable', \Arcanedev\Sanitizer\Tests\Stubs\NotFilterable::class);
    }
}
