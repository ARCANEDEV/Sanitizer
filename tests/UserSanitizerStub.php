<?php namespace Arcanedev\Sanitizer\Tests;

use Arcanedev\Sanitizer\Sanitizer;

class UserSanitizerTest extends Sanitizer
{
	public function sanitizeHelloMessage($value)
	{
		return ucfirst(strtolower(trim($value)));
	}
}