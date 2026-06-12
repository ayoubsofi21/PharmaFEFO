<?php
declare(strict_types=1);
namespace App\Repository;

use App\Entity\User;
use PDO;

class UserRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function findByUsername(string $username): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $data = $stmt->fetch();
        if (!$data) return null;
        return new User((int)$data['id'], $data['username'], $data['email'], $data['password'], $data['role']);
    }

    public function findByEmail(string $email): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch();
        if (!$data) return null;
        return new User((int)$data['id'], $data['username'], $data['email'], $data['password'], $data['role']);
    }

    public function create(string $username, string $email, string $password, string $role): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)"
        );
        $ok = $stmt->execute([
            'username' => $username,
            'email'    => $email,
            'password' => $password,
            'role'     => $role,
        ]);

        if (!$ok) return false;

        // Insert into role sub-table
        $userId = (int)$this->db->lastInsertId();
        $table  = match($role) {
            'ADMINISTRATEUR' => 'administrateur',
            'PHARMACIEN'     => 'pharmacien',
            'PREPARATEUR'    => 'preparateur',
        };

        $stmt2 = $this->db->prepare("INSERT INTO {$table} (user_id) VALUES (:user_id)");
        return $stmt2->execute(['user_id' => $userId]);
    }
}