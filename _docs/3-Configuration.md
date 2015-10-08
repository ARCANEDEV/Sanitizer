# 3. Configuration

Available filters are :

| Filter        | Description                                                                                      |
| ------------- | ------------------------------------------------------------------------------------------------ |
| 'capitalize'  | Capitalize a string.                                                                             |
| 'email'       | Sanitizing email by using php's filter_var (FILTER_SANITIZE_EMAIL).                              |
| 'escape'      | Escapes HTML and special chars using php's filter_var.                                           |
| 'date_format' | Takes two arguments, the date's given format and the target format, following DateTime notation. |
| 'lowercase'   | Converts the given string to all lowercase.                                                      |
| 'slug'        | Using the laravel str_slug() helper.                                                             |
| 'trim'        | Trims a string.                                                                                  |
| 'uppercase'   | Convert the given string to uppercase.                                                           |
| 'url'         | Adding the missing `http://` protocol and sanitize by using filter_var (FILTER_SANITIZE_URL).    |

## For Laravel

After publishing the Sanitizer config file, you can add your own filters or edit the available filters. 

```php
<?php
// config/sanitizer.php

return [
    /* ------------------------------------------------------------------------------------------------
     |  Available filters
     | ------------------------------------------------------------------------------------------------
     */
    'filters' => [
        'capitalize'  => \Arcanedev\Sanitizer\Filters\CapitalizeFilter::class,
        'email'       => \Arcanedev\Sanitizer\Filters\EmailFilter::class,
        'escape'      => \Arcanedev\Sanitizer\Filters\EscapeFilter::class,
        'format_date' => \Arcanedev\Sanitizer\Filters\FormatDateFilter::class,
        'lowercase'   => \Arcanedev\Sanitizer\Filters\LowercaseFilter::class,
        'slug'        => \Arcanedev\Sanitizer\Filters\SlugFilter::class,
        'trim'        => \Arcanedev\Sanitizer\Filters\TrimFilter::class,
        'uppercase'   => \Arcanedev\Sanitizer\Filters\UppercaseFilter::class,
        'url'         => \Arcanedev\Sanitizer\Filters\UrlFilter::class,
    ],
];
```
