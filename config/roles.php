<?php
return [
    'admin' => [
        'roles' => [
            'name' => 'admin',
        ],
        'permissions' => [
            'list-user',
            'update-user',
            'list-role',
            'update-role',
            'create-role',
            'delete-role',
            'check-url',
        ],
    ],
    'client' => [
        'roles' => [
            'name' => 'client',
        ],
        'permissions' => [
            'check-url',
        ],
    ],
];
