<?php namespace Arcanedev\Sanitizer\Tests\Stubs;

use Arcanedev\Sanitizer\Sanitizer;

/**
 * Class     UserSanitizer
 *
 * @package  Arcanedev\Sanitizer\Tests\Stubs
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UserSanitizer extends Sanitizer
{
    /* ------------------------------------------------------------------------------------------------
     |  Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function sanitizeHelloMessage($value)
    {
        return ucfirst(strtolower(trim($value)));
    }
}