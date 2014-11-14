<?php

include_once __DIR__ . "/../vendor/autoload.php";

class UserSanitizer extends \Arcanedev\Sanitizer\Sanitizer
{
    protected $rules = [
        'lastname'  => 'trim|strtolower|ucfirst',
        'firstname' => 'trim|strtoupper',
        'email'     => 'trim|strtolower'
    ];
}

$data = [
    'lastname'  => 'john',
    'firstname' => 'doe',
    'email'     => 'John.DOE@GMAIL.com'
];

$user = (new UserSanitizer)->sanitize($data);
var_dump($user);
