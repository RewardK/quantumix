<?php
return [
    'db' => [
        'host' => 'localhost',
        'name' => 'quantumix',
        'user' => 'root',
        'pass' => '',
        'charset' => 'utf8mb4',
    ],
    'site' => [
        'name' => 'Quantumix',
        'base_url' => '',
        'email' => 'office@quantumix.com',
        'timezone' => 'Europe/Bucharest',
    ],
    'security' => [
        'csrf_key' => 'change-this-key',
        'api_token' => 'change-this-api-token',
        'session_name' => 'quantumix_session',
    ],
    'mail' => [
        'from' => 'no-reply@quantumix.com',
    ],
];
