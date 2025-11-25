<?php
require __DIR__ . '/vendor/autoload.php';

if (class_exists('Dotenv\Dotenv')) {
    echo "✅ phpdotenv está instalado y funcionando.\n";
} else {
    echo "❌ phpdotenv no está instalado.\n";
}
