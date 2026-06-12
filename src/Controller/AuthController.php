<?php
declare(strict_types=1);
namespace App\Controller;

use App\Repository\UserRepository;

class AuthController
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(): void
    {
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php?route=dashboard");
            exit;
        }

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = strtolower(trim($_POST['username'] ?? ''));
            $password = trim($_POST['password'] ?? '');

            $user = $this->userRepository->findByEmail($email);

            if ($user && password_verify($password, $user->getPassword())) {
                $_SESSION['user_id']       = $user->getId();
                $_SESSION['user_username'] = $user->getUsername();
                $_SESSION['user_role']     = $user->getRole();

                header("Location: index.php?route=dashboard");
                exit;
            }

            $error = "Invalid credentials.";
        }

        require __DIR__ . '/../../templates/auth/login.php';
    }

    public function register(): void
    {
        if (isset($_SESSION['user_id'])) {
            header("Location: index.php?route=dashboard");
            exit;
        }

        $errors  = [];
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = strtolower(trim($_POST['username'] ?? ''));
            $email    = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $confirm  = trim($_POST['confirm_password'] ?? '');
            $role     = $_POST['role'] ?? '';

            // Validation
            if (empty($username) || strlen($username) < 3) {
                $errors['username'] = "Username must be at least 3 characters.";
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Please enter a valid email address.";
            }

            if (strlen($password) < 6) {
                $errors['password'] = "Password must be at least 6 characters.";
            }

            if ($password !== $confirm) {
                $errors['confirm_password'] = "Passwords do not match.";
            }

            $allowedRoles = ['ADMINISTRATEUR', 'PHARMACIEN', 'PREPARATEUR'];
            if (!in_array($role, $allowedRoles, true)) {
                $errors['role'] = "Please select a valid role.";
            }

            // Check username/email not already taken
            if (empty($errors)) {
                if ($this->userRepository->findByUsername($username)) {
                    $errors['username'] = "This username is already taken.";
                }
                if ($this->userRepository->findByEmail($email)) {
                    $errors['email'] = "This email is already registered.";
                }
            }

            if (empty($errors)) {
                $hashed = password_hash($password, PASSWORD_BCRYPT);
                if ($this->userRepository->create($username, $email, $hashed, $role)) {
                    $success = true;
                } else {
                    $errors['global'] = "Registration failed. Please try again.";
                }
            }
        }

        require __DIR__ . '/../../templates/auth/register.php';
    }

    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
        header("Location: index.php?route=login");
        exit;
    }
}