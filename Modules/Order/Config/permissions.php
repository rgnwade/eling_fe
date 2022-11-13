<?php

return [
    'admin.orders' => [
        'index' => 'order::permissions.index',
        'show' => 'order::permissions.show',
        'edit' => 'order::permissions.edit',
    ],
    'vendor.orders' => [
        'index' => 'order::permissions.index',
        'show' => 'order::permissions.show',
        'edit' => 'order::permissions.edit',
    ]
];
