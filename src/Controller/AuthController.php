<?php
declare(strict_types=1);

namespace App\Controller;

use App\Repository\UserRepository;

class AuthController {
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function login(): void {
        startSessionIfNeeded();
        if (isset($_SESSION['user_id'])) {
            header("Location: /index.php?route=dashboard");
            exit;
        }

        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $user = $this->userRepository->findByUsername($username);
            if ($user && password_verify($password, $user->getPassword())) {
                $_SESSION['user_id'] = $user->getId();
                $_SESSION['user_username'] = $user->getUsername();
                $_SESSION['user_role'] = $user->getRole();
                header("Location: /index.php?route=dashboard");
                exit;
            } else {
                $error = "Invalid username or password credentials.";
            }
        }
        require __DIR__ . '/../../templates/auth/login.php';
    }

    public function logout(): void {
        startSessionIfNeeded();
        $_SESSION = [];
        session_destroy();
        header("Location: /index.php?route=login");
        exit;
    }
}