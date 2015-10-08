<?php namespace Arcanedev\Sanitizer\Tests\Filters;

/**
 * Class     LowercaseFilterTestCase
 *
 * @package  Arcanedev\Sanitizer\Tests\Filters
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class LowercaseFilterTestCase extends FilterTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_lowercase_strings()
    {
        $sanitized = $this->sanitize([
            'message'   => 'HellO WoRld',
            'users'     => ['james', 'lora', 'karl'],
        ],[
            'message'   => 'lowercase',
            'users'     => 'lowercase',
        ]);

        $this->assertEquals([
            'message'   => 'hello world',
            'users'     => ['james', 'lora', 'karl'],
        ], $sanitized);
    }
}
