<?php
declare(strict_types=1);

namespace Config;

use PDO;
use PDOException;

class Database {
    public static function getConnection(): PDO {
        $host = 'localhost';
        $db   = 'pharma_fefo';
        $user = 'root';
        $pass = ''; 

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
            echo"connected with successfully";
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}
// $result=new Database();
// echo $result->getConnection();