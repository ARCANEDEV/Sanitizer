<?php namespace Arcanedev\Sanitizer\Tests\Filters;

/**
 * Class     FormatDateFilterTestCase
 *
 * @package  Arcanedev\Sanitizer\Tests\Filters
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class FormatDateFilterTestCase extends FilterTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_format_date()
    {
        $sanitized = $this->sanitize([
            'dob' => '21/12/1991',
        ], [
            'dob' => 'format_date:d/m/Y, Y-m-d',
        ]);

        $this->assertEquals([
            'dob' => '1991-12-21'
        ], $sanitized);
    }

    /** @test */
    public function it_can_format_date_with_empty_data()
    {
        $sanitized = $this->sanitize([
            'dob'  => '21/12/1991',
            'dead' => true,
        ], [
            'dob'  => 'format_date:d/m/Y, Y-m-d',
            'dead' => 'format_date:d/m/Y, Y-m-d',
        ]);

        $this->assertEquals([
            'dob'  => '1991-12-21',
            'dead' => true,
        ], $sanitized);
    }

    /**
     * @test
     *
     * @expectedException         \InvalidArgumentException
     * @expectedExceptionMessage  The Sanitizer Format Date filter requires both the current date format as well as the target format.
     */
    public function it_must_fail_date_format_that_requires_two_args()
    {
        $this->sanitize([
            'dob' => '21/12/1991',
        ],[
            'dob' => 'format_date:d/m/Y',
        ]);
    }
}
