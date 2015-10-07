<?php namespace Arcanedev\Sanitizer\Tests\Laravel;

use Arcanedev\Sanitizer\Facades\Sanitizer;
use Arcanedev\Sanitizer\Tests\LaravelTestCase;

/**
 * Class     FacadeTest
 *
 * @package  Arcanedev\Sanitizer\Tests\Laravel
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class FacadeTest extends LaravelTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_make_sanitizer()
    {
        $sanitized = Sanitizer::make([
            'last_name'  => 'john',
            'first_name' => 'doe',
            'email'      => 'John.DOE@EmAiL.com'
        ], [
            'last_name'  => 'trim|uppercase',
            'first_name' => 'trim|capitalize',
            'email'      => 'email'
        ]);

        $this->assertEquals([
            'last_name'  => "JOHN",
            'first_name' => "Doe",
            'email'      => "john.doe@email.com",
        ], $sanitized);
    }
}
