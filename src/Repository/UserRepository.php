<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use PDO;

class UserRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function findByUsername(string $username): ?User {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        $data = $stmt->fetch();

        if (!$data) return null;
        return new User((int)$data['id'], $data['username'], $data['password'], $data['role']);
    }
}