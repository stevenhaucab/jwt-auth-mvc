<?php

namespace Steve\JwtAuthMvc\Controllers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Steve\JwtAuthMvc\Models\User;

class AuthController {
    private $secretKey;

    public function __construct() {
        $this->secretKey = $_ENV['JWT_SECRET'];
    }

    public function login() {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = new User();
        $userData = $user->getUserByEmail($email);

        if ($userData && password_verify($password, $userData['password'])) {
            $token = $this->generateJWT($userData);
            echo json_encode(['token' => $token]);
        } else {
            http_response_code(401);
            echo json_encode(['message' => 'Invalid credentials']);
        }
    }

    private function generateJWT($userData) {
        $payload = [
            'iss' => 'your_domain.com', // Emisor del token
            'aud' => 'your_domain.com', // Receptor del token
            'iat' => time(), // Hora de emisión
            'nbf' => time(), // Hora a partir de la cual el token es válido
            'exp' => time() + (60*60), // Expiración del token (1 hora)
            'data' => [
                'id' => $userData['id'],
                'email' => $userData['email']
            ]
        ];

        return JWT::encode($payload, $this->secretKey, 'HS256');
    }
}
