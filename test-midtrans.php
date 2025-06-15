<?php

// Include autoloader.php
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Midtrans\Config;
use Midtrans\Snap;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Set Midtrans configuration
Config::$serverKey = $_ENV['MIDTRANS_SERVER_KEY'] ?? '';
Config::$isProduction = isset($_ENV['MIDTRANS_IS_PRODUCTION']) ? 
    ($_ENV['MIDTRANS_IS_PRODUCTION'] === 'true') : false;
Config::$isSanitized = true;
Config::$is3ds = true;

echo "Midtrans Configuration Test\n";
echo "==========================\n";
echo "Server Key: " . (empty(Config::$serverKey) ? "MISSING" : "CONFIGURED [" . substr(Config::$serverKey, 0, 5) . "...]") . "\n";
echo "Client Key: " . (empty($_ENV['MIDTRANS_CLIENT_KEY']) ? "MISSING" : "CONFIGURED [" . substr($_ENV['MIDTRANS_CLIENT_KEY'], 0, 5) . "...]") . "\n";
echo "Production Mode: " . (Config::$isProduction ? "YES" : "NO (Sandbox)") . "\n";

// Try to create a test transaction
try {
    $params = [
        'transaction_details' => [
            'order_id' => 'TEST-' . rand(100000, 999999),
            'gross_amount' => 10000,
        ],
        'item_details' => [
            [
                'id' => 'test1',
                'price' => 5000,
                'quantity' => 1,
                'name' => 'Test Product 1',
            ],
            [
                'id' => 'test2',
                'price' => 5000,
                'quantity' => 1,
                'name' => 'Test Product 2',
            ],
        ],
        'customer_details' => [
            'first_name' => 'Test Customer',
            'email' => 'test@example.com',
            'phone' => '08123456789',
        ],
    ];

    echo "\nTrying to generate a test Snap Token...\n";
    $snapToken = Snap::getSnapToken($params);
    echo "SUCCESS! Snap Token: " . $snapToken . "\n";
    echo "\nYour Midtrans configuration is working correctly!\n";
} catch (\Exception $e) {
    echo "\nFAILED! Error: " . $e->getMessage() . "\n";
    echo "\nPlease check your Midtrans configuration and try again.\n";
}