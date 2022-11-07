<?php

return [
    'admin.products' => [
        'index' => 'product::permissions.index',
        'create' => 'product::permissions.create',
        'edit' => 'product::permissions.edit',
        'preview' => 'product::permissions.preview',
        'destroy' => 'product::permissions.destroy',
    ],
];
