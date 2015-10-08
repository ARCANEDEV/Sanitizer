<?php namespace Arcanedev\Sanitizer\Tests\Filters;

/**
 * Class     EmailFilterTestCase
 *
 * @package  Arcanedev\Sanitizer\Tests\Filters
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class EmailFilterTestCase extends FilterTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_sanitize_email()
    {
        $sanitized = $this->sanitize([
            'email'  => '  (My@eMaIl.CoM) ',
            'active' => true,
        ], [
            'email'  => 'email',
            'active' => 'email',
        ]);

        $this->assertEquals([
            'email'  => 'my@email.com',
            'active' => true,
        ], $sanitized);
    }
}
