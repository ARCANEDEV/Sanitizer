<?php namespace Arcanedev\Sanitizer\Tests\Filters;

/**
 * Class     TrimFilterTestCase
 *
 * @package  Arcanedev\Sanitizer\Tests\Filters
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class TrimFilterTestCase extends FilterTestCase
{
   /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_trim_strings()
    {
        $sanitized = $this->sanitize([
            'name'   => '  James BROWN  ',
            'signer' => true,
        ],[
            'name'   => 'trim',
            'signer' => 'trim',
        ]);

        $this->assertEquals([
            'name'   => 'James BROWN',
            'signer' => true,
        ], $sanitized);
    }
}
