<?php

include_once __DIR__ . "/../vendor/autoload.php";

use Arcanedev\Sanitizer\Sanitizer;

class UserSanitizer extends Sanitizer
{
    protected $rules = [
        'lastname'  => 'trim|strtolower|ucfirst',
        'firstname' => 'trim|strtoupper',
        'email'     => 'trim|strtolower'
    ];
}

// After receiving data from outer space
$data = [
    'lastname'  => 'john',
    'firstname' => 'doe',
    'email'     => 'John.DOE@EmAiL.com'
];

// Sanitize E.T.
$user = (new UserSanitizer)->sanitize($data);
var_dump($user);
