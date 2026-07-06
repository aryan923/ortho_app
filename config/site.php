<?php

return [
    'name' => env('SITE_NAME', env('APP_NAME', 'OrthoCore Clinic')),
    'full_name' => env('SITE_FULL_NAME', env('SITE_NAME', env('APP_NAME', 'OrthoCore Clinic'))),
    'logo' => env('SITE_LOGO', '/images/logo.svg'),

    'phone' => env('SITE_PHONE', '+1 (212) 555-0192'),
    'phone_link' => env('SITE_PHONE_LINK', 'tel:+12125550192'),
    'email' => env('SITE_EMAIL', 'hello@orthocore.com'),

    'address_line_1' => env('SITE_ADDRESS_LINE_1', '123 Ortho Way, Suite 400'),
    'address_line_2' => env('SITE_ADDRESS_LINE_2', 'New York, NY 10001'),

    'description' => env('SITE_DESCRIPTION', "New York's leading orthopedic and physiotherapy centre. Precision care for bones, joints, and the full musculoskeletal system since 1999."),

    'pagination' => [
        'default' => env('PAGINATION_VALUE', 10),
        'search' => env('PAGINATION_VALUE_SEARCH', 2),
    ],
];
