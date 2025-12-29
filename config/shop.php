<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Shop Configuration
    |--------------------------------------------------------------------------
    |
    | This file is for storing the configuration settings for the e-commerce
    | shop, such as admin email for notifications.
    |
    */
    'admin_email' => env('SHOP_ADMIN_EMAIL', 'trustfactory@example.com'),
    'low_stock_threshold' => (int) env('SHOP_LOW_STOCK_THRESHOLD', 5),
    'pagination_size' => (int) env('SHOP_PAGINATION_SIZE', 20),
];
