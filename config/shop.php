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
    'low_stock_threshold' => env('SHOP_LOW_STOCK_THRESHOLD', 5),
];
