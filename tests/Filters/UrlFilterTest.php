<?php namespace Arcanedev\Sanitizer\Tests\Filters;

/**
 * Class     UrlFilterTestCase
 *
 * @package  Arcanedev\Sanitizer\Tests\Filters
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UrlFilterTestCase extends FilterTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_sanitize_urls()
    {
        $sanitized = $this->sanitize([
            'website'  => 'https://www.goo��gle.co�m',
            'homepage' => 'www.example.com',
            'sfw'      => true,
        ],[
            'website'  => 'url',
            'homepage' => 'url',
            'sfw'      => 'url',
        ]);

        $this->assertEquals([
            'website'  => 'https://www.google.com',
            'homepage' => 'http://www.example.com',
            'sfw'      => true,
        ], $sanitized);
    }
}
