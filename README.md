Sanitizer Helper [![Packagist License](http://img.shields.io/packagist/l/arcanedev/sanitizer.svg?style=flat-square)](https://github.com/ARCANEDEV/Sanitizer/blob/master/LICENSE)
==============
[![Travis Status](http://img.shields.io/travis/ARCANEDEV/Sanitizer.svg?style=flat-square)](https://travis-ci.org/ARCANEDEV/Sanitizer)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/ARCANEDEV/Sanitizer.svg?style=flat-square)](https://scrutinizer-ci.com/g/ARCANEDEV/Sanitizer/?branch=master)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/ARCANEDEV/Sanitizer.svg?style=flat-square)](https://scrutinizer-ci.com/g/ARCANEDEV/Sanitizer/?branch=master)
[![Github Release](http://img.shields.io/github/release/ARCANEDEV/Sanitizer.svg?style=flat-square)](https://github.com/ARCANEDEV/Sanitizer/releases)
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
Once the package is installed, you can register the service provider in `app/config/app.php` in the `providers` array:

```php
'providers' => [
    ...
    'Arcanedev\Sanitizer\Laravel\ServiceProvider',
],
```

And the facade in the `aliases` array:

```php
'aliases' => [
    ...
    'Sanitizor' => 'Arcanedev\Sanitizer\Laravel\Facade',
],
```

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

### Laravel USAGE

You can use Sanitizer like Laravel Validator Facade :

```php
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

$sanitizor = Sanitizor::make($data, $rules);

var_dump($sanitizor);
```

Check the `examples` or `tests` folder to learn some tricks.

## Contributing

If you have any suggestions or improvements feel free to create an issue or create a Pull Request.

## TODO

  - [ ] Documentation
  - [ ] More Examples
  - [x] More tests and code coverage
  - [x] Laravel support (v4.2)
  - [ ] Laravel support (v5.0)
  - [ ] Registering sanitizers in IoC Container (only Laravel)
  - [ ] Refactoring

## License

The Sanitizer Helper is open-sourced software licensed under the [MIT license](https://github.com/ARCANEDEV/Sanitizer/blob/master/LICENSE)
