Sanitizer Helper
==============
[![Travis Status](http://img.shields.io/travis/ARCANEDEV/Sanitizer.svg?style=flat-square)](https://travis-ci.org/ARCANEDEV/Sanitizer)
[![Coverage Status](http://img.shields.io/coveralls/ARCANEDEV/Sanitizer.svg?style=flat-square)](https://coveralls.io/r/ARCANEDEV/Sanitizer?branch=master)
[![Github Release](http://img.shields.io/github/release/ARCANEDEV/Sanitizer.svg?style=flat-square)](https://github.com/ARCANEDEV/Sanitizer/releases)
[![Packagist License](http://img.shields.io/packagist/l/arcanedev/sanitizer.svg?style=flat-square)](https://github.com/ARCANEDEV/Sanitizer/blob/master/LICENSE)
[![Packagist Downloads](https://img.shields.io/packagist/dt/arcanedev/sanitizer.svg?style=flat-square)](https://packagist.org/packages/arcanedev/sanitizer)
[![Github Issues](http://img.shields.io/github/issues/ARCANEDEV/Sanitizer.svg?style=flat-square)](https://github.com/ARCANEDEV/Sanitizer/issues)

This library helps you to sanitize your data.

*By [ARCANEDEV&copy;](http://www.arcanedev.net/)*

### Requirements

    - PHP >= 5.4.0
    
## Installation

### Composer

You can install the package via [Composer](https://getcomposer.org/). Add this to your composer.json:

```json
{
    "require": {
        "arcanedev/sanitizer": "~1.0"
    }
}
```

And install it via `composer install` or `composer update`.

### Laravel
Coming Soon...

## USAGE
Now simply extend the Sanitizer class :

```php
// UserSanitizer.php
use Arcanedev\Sanitizer\Sanitizer;

class UserSanitizer extends Sanitizer
{
    protected $rules = [
        'lastname'  => 'trim|strtolower|ucfirst',
        'firstname' => 'trim|strtoupper',
        'email'     => 'trim|strtolower'
    ];
}

// Somewhere in your project (Controllers, Models ...)

// After receiving data from outer space
$data = [
    'lastname'  => 'john',
    'firstname' => 'doe',
    'email'     => 'John.DOE@EmAiL.com'
];

// Sanitize E.T.
$sanitizer = new UserSanitizer;
$user      = $sanitizer->sanitize($data);
var_dump($user);
```

Check the examples/tests folder to learn some tricks.

## Contributing
If you have any suggestions or improvements feel free to create an issue or create a Pull Request.

## License
The Sanitizer Helper is open-sourced software licensed under the [MIT license](https://github.com/ARCANEDEV/Sanitizer/blob/master/LICENSE)
