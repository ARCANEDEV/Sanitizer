<?php namespace Arcanedev\Sanitizer\Tests\Filters;

/**
 * Class     EscapeFilterTestCase
 *
 * @package  Arcanedev\Sanitizer\Tests\Filters
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class EscapeFilterTestCase extends FilterTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_escape()
    {
        $sanitized = $this->sanitize([
            'content'  => '<h1 class="page-header">Hello world <small>ĤĕĹĻŌ Ŵŏŕŀđ<small></h1> <script>alert("Hello World");</script>',
            'comments' => true,
        ], [
            'content'  => 'escape',
            'comments' => 'escape',
        ]);

        $this->assertEquals([
            'content'  => 'Hello world ĤĕĹĻŌ Ŵŏŕŀđ alert(&#34;Hello World&#34;);',
            'comments' => true,
        ], $sanitized);
    }
}
