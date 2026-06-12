<?php
declare(strict_types=1);

function requireAuth(array $allowedRoles = []): void
{
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php?route=login");
        exit;
    }

    if ($allowedRoles && !in_array($_SESSION['user_role'], $allowedRoles, true)) {
        header("Location: index.php?route=dashboard&error=unauthorized");
        exit;
    }
}