<?php

return [
    'admin.users' => [
        'index' => 'user::permissions.users.index',
        'create' => 'user::permissions.users.create',
        'edit' => 'user::permissions.users.edit',
        'destroy' => 'user::permissions.users.destroy',
    ],
    'admin.verify' => [
        'index' => 'user::permissions.verify.index',
        'edit' => 'user::permissions.verify.edit',
    ],
    'admin.roles' => [
        'index' => 'user::permissions.roles.index',
        'create' => 'user::permissions.roles.create',
        'edit' => 'user::permissions.roles.edit',
        'destroy' => 'user::permissions.roles.destroy',
    ],
    'admin.log' => [
        'index' => 'user::permissions.log.index'
    ],
    'vendor.users' => [
        'index' => 'user::permissions.users.index',
        'create' => 'user::permissions.users.create',
        'edit' => 'user::permissions.users.edit',
    ],
];
