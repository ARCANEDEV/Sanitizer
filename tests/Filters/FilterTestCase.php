<?php namespace Arcanedev\Sanitizer\Tests\Filters;

use Arcanedev\Sanitizer\Contracts\Filterable;
use Arcanedev\Sanitizer\Sanitizer;
use Arcanedev\Sanitizer\Tests\TestCase;

/**
 * Class     FilterTestCase
 *
 * @package  Arcanedev\Sanitizer\Tests\Filters
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class FilterTestCase extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var Sanitizer */
    protected $sanitizer;

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
    public function it_assert_filters_are_filterable()
    {
        foreach ($this->filters as $filter) {
            $this->assertArrayHasKey(Filterable::class, class_implements($filter));
        }
    }

    /* ------------------------------------------------------------------------------------------------
     |  Common Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Sanitize data.
     *
     * @param  array  $data
     * @param  array  $rules
     *
     * @return array
     */
    protected function sanitize($data, $rules)
    {
        return $this->sanitizer->sanitize($data, $rules);
    }
}
