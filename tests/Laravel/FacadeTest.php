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
    /**
     * @test
     */
    public function it_can_make_sanitizer()
    {
        $rules = [
            'lastname'  => 'trim|strtolower|ucfirst',
            'firstname' => 'trim|strtoupper',
            'email'     => 'trim|strtolower'
        ];

        $data = [
            'lastname'  => 'john',
            'firstname' => 'doe',
            'email'     => 'John.DOE@EmAiL.com'
        ];

        $this->assertEquals([
            'lastname' => "John",
            'firstname' => "DOE",
            'email' => "john.doe@email.com",
        ], Sanitizer::make($data, $rules));
    }
}
