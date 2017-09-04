<?php

return [

    // Default Icon
    'default_icon' => env('DEFAULT_ICON') ?: '/images/favicon.ico',

    // Meta
    'meta' => [
        'keywords' => 'PJ Blog,blog,pigjian,laravel,vuejs',
        'description' => 'Nothing is impossible in PJ Blog'
    ],

    // Article Page
    'article' => [
        'title'       => 'Nothing is impossible.',
        'description' => 'https://pigjian.com',
        'number'      => 15,
        'sort'        => 'desc',
        'sortColumn'  => 'published_at',
    ],
];
