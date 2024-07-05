<?php

namespace Steve\JwtAuthMvc\Models;

use PDO;

class User {
    private $db;

    public function __construct() {
        $host = $_ENV['DB_HOST'];
        $dbname = $_ENV['DB_NAME'];
        $username = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASS'];

        $this->db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    }

    public function getUserByEmail($email) {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
