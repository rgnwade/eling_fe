<?php

return [
    'admin.products' => [
        'index_vendor' => 'product::permissions.index_vendor',
        'edit_vendor' => 'product::permissions.edit_vendor',
        'index' => 'product::permissions.index',
        'create' => 'product::permissions.create',
        'edit' => 'product::permissions.edit',
        'preview' => 'product::permissions.preview',
        'destroy' => 'product::permissions.destroy',
    ],
    'vendor.products' => [
        'index' => 'product::permissions.index',
        'create' => 'product::permissions.create',
        'create_videotron' => 'product::permissions.create_videotron',
        'edit' => 'product::permissions.edit',
        'preview' => 'product::permissions.preview',
        'destroy' => 'product::permissions.destroy',
    ],
];
