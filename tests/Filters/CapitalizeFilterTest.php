<?php namespace Arcanedev\Sanitizer\Tests\Filters;

/**
 * Class     CapitalizeFilterTestCase
 *
 * @package  Arcanedev\Sanitizer\Tests\Filters
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CapitalizeFilterTestCase extends FilterTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_capitalize()
    {
        $sanitized = $this->sanitize([
            'msg'    => 'HeLlO WoRlD',
            'active' => true,
        ], [
            'msg'    => 'capitalize',
            'active' => 'capitalize',
        ]);

        $this->assertEquals([
            'msg'    => 'Hello World',
            'active' => true,
        ], $sanitized);
    }
}
