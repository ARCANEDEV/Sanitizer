<?php namespace Arcanedev\Sanitizer\Tests;

use PHPUnit_Framework_TestCase as BaseTestCase;

/**
 * Class     TestCase
 *
 * @package  Arcanedev\Sanitizer\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class TestCase extends BaseTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Sanitizer filters.
     *
     * @var array
     */
    protected $filters = [
        'capitalize'  => \Arcanedev\Sanitizer\Filters\CapitalizeFilter::class,
        'email'       => \Arcanedev\Sanitizer\Filters\EmailFilter::class,
        'escape'      => \Arcanedev\Sanitizer\Filters\EscapeFilter::class,
        'format_date' => \Arcanedev\Sanitizer\Filters\FormatDateFilter::class,
        'lowercase'   => \Arcanedev\Sanitizer\Filters\LowercaseFilter::class,
        'trim'        => \Arcanedev\Sanitizer\Filters\TrimFilter::class,
        'uppercase'   => \Arcanedev\Sanitizer\Filters\UppercaseFilter::class,
        'url'         => \Arcanedev\Sanitizer\Filters\UrlFilter::class,
    ];

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
}
