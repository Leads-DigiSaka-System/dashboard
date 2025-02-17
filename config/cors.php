<?php

return [
    'paths' => ['*', 'api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'], // You can specify methods like ['GET', 'POST'] if needed

    'allowed_origins' => [
        'http://127.0.0.1:3000',   // Local development URL
        'https://www.digisaka.com', // Your production URL
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // You can specify which headers you want to allow

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true, // Set this to true if you need to allow credentials (cookies or authentication)
];
