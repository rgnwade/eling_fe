<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Define which assets will be available through the asset manager
    | These assets are registered on the asset manager.
    |--------------------------------------------------------------------------
    */
    'all_assets' => [
        'admin.media.css' => ['module' => 'media:admin/css/media.css'],
        'admin.media.js' => ['module' => 'media:admin/js/media.js'],
        'vendor.media.css' => ['module' => 'media:vendor/css/media.css'],
        'vendor.media.js' => ['module' => 'media:vendor/js/media.js'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Define which default assets will always be included in all pages
    | through the asset pipeline.
    |--------------------------------------------------------------------------
    */
    'required_assets' => [],
];
