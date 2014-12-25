<?php namespace Arcanedev\Sanitizer\Tests;

use Arcanedev\Sanitizer\Sanitizer;

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