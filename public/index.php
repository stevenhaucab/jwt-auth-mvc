<?php

require '../vendor/autoload.php';

use Dotenv\Dotenv;
use Steve\JwtAuthMvc\Controllers\AuthController;

// Cargar variables de entorno
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$requestUri = explode('?', $_SERVER['REQUEST_URI'], 2)[0];

if ($requestUri == '/auth/login' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $authController = new AuthController();
    $authController->login();
} else {
    require '../src/Views/login.php';
}
