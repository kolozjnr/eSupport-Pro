<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'superadministrator' => [
            'users' => 'c,r,u,d',
            'payments' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'administrator' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'qualitycontrol' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'supervisor' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'account' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'businessdeveloper' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'businessmanager' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'businesssupervisor' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'customermanager' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'developer' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'support' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'customer' => [
            'profile' => 'r,u',
        ],
        'user' => [
            'profile' => 'r,u',
        ],
        // 'role_name' => [
        //     'module_1_name' => 'c,r,u,d',
        // ],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ],
];
