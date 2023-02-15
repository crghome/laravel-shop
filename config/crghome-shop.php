<?php

return [
    'name' => 'Магазин',

    'prefix' => 'crghome',
    'admin_prefix' => null,
    'domain' => null,

    'views' => false,
    'middleware' => ['web'],
    'middleware_role' => ['superadmin', 'admin', 'manager'],
    'middleware_role_string' => 'superadmin|admin|manager',

    'db' => [
        'tables' => [
            'categories' => 'crgshop_categories',
            'products' => 'crgshop_products',
            'category_products' => 'crgshop_category_products',
            'settings' => 'crgshop_settings',
            'clients' => 'crgshop_clients',
            'carts' => 'crgshop_carts',
            'statuses' => 'crgshop_order_statuses',
            'orders' => 'crgshop_orders',
        ]
    ],
];