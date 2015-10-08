<?php namespace Arcanedev\Sanitizer\Tests\Filters;

/**
 * Class     SlugFilterTestCase
 *
 * @package  Arcanedev\Sanitizer\Tests\Filters
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class SlugFilterTestCase extends FilterTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_slugs_strings()
    {
        $sanitized = $this->sanitize([
            'slug'      => 'Hello world',
            'published' => true,
        ],[
            'slug'      => 'slug',
            'published' => 'slug',
        ]);

        $this->assertEquals([
            'slug'      => 'hello-world',
            'published' => true,
        ], $sanitized);
    }
}
