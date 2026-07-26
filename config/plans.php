<?php

return [

    'starter' => [
        'label'         => 'Starter',
        'max_products'  => 50,
        'max_users'     => 1, // sirf admin, koi staff add nahi kar sakta
        'reports'       => false,
    ],

    'business' => [
        'label'         => 'Business',
        'max_products'  => null,
        'max_users'     => null, // unlimited staff
        'reports'       => true,
    ],

    'enterprise' => [
        'label'         => 'Enterprise',
        'max_products'  => null,
        'max_users'     => null,
        'reports'       => true,
    ],

];