# 4. Usage

You know that users can post anything via form and it's a little bit a mess (and they don't care) :

```php
$data = [
    'first_name' => 'john',
    'last_name'  => '<h1>doe</h1>',
    'email'      => '  J.DoE@EmAiL.Com',
    'dob'        => '12/21/1991',
];
```

So, our job is to clean the mess by sanitizing and formatting the input by using our `Sanitizer`:

```php
<?php

use \Arcanedev\Sanitizer\Sanitizer;

$sanitizer  = new Sanitizer;

$data = [
    'first_name' => 'john',
    'last_name'  => '<h1>doe</h1>',
    'email'      => '  J.DoE@EmAiL.Com',
    'dob'        => '12/21/1991',
];

$rules = [
    'first_name' => 'trim|escape|capitalize',
    'last_name'  => 'trim|escape|uppercase',
    'email'      => 'trim|email',
    'dob'        => 'trim|format_date:m/d/Y, Y-m-d'
];

var_dump($sanitizer->sanitize($data, $rules));
```

The result: 

```php
array [
    'first_name' => 'John',
    'last_name'  => 'DOE',
    'email'      => 'j.doe@email.com',
    'dob'        => '1991-12-21',
]
```

**Note : Filters are applied in the same order they're defined in the $rules array.** 
 
For each attribute, filters are separated by a pipe `|` and options are specified by suffixing a comma `,` separated list of arguments (see `format_date` for example).

## Adding custom filters

You can add your own filters by passing a custom filters array to `Sanitizer` constructor. 

```php
use \Arcanedev\Sanitizer\Sanitizer;

$filters    = [
    'custom'     => function ($value, $options) {
        // Cleaning stuff
        return $value;
    },
    'filterable' => \App\Filters\CustomFilter::class, // This class implements the Arcanedev\Sanitizer\Contracts\Filterable interface.  
]; 

$sanitizer  = new Sanitizer($filters);
```

Or by passing the filters array as a third parameter in the `sanitize()` method.

```php
use \Arcanedev\Sanitizer\Sanitizer;

$sanitizer  = new Sanitizer;

$data = [
    //...
];

$rules = [
    //...
];

$filters    = [
    'custom'     => function ($value, $options) {
        // Cleaning stuff
        return $value;
    },
    'filterable' => \App\Filters\CustomFilter::class,  
]; 

var_dump($sanitizer->sanitize($data, $rules, $filters));
```

**NOTE : Closures must always accept two parameters: $value and an $options array**

More cool stuff coming soon...
