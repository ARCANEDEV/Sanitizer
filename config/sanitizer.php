<?php

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
        'trim'        => \Arcanedev\Sanitizer\Filters\TrimFilter::class,
        'uppercase'   => \Arcanedev\Sanitizer\Filters\UppercaseFilter::class,
        'url'         => \Arcanedev\Sanitizer\Filters\UrlFilter::class,
    ],
];
