<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use PDO;

class ProductRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function findAll(): array {
        $stmt = $this->db->query("SELECT * FROM products ORDER BY name ASC");
        $products = [];
        while ($row = $stmt->fetch()) {
            $products[] = new Product((int)$row['id'], $row['name'], $row['description'], (float)$row['unit_price']);
        }
        return $products;
    }

    public function findById(int $id): ?Product {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        if (!$row) return null;
        return new Product((int)$row['id'], $row['name'], $row['description'], (float)$row['unit_price']);
    }

    public function countAll(): int {
        return (int)$this->db->query("SELECT COUNT(*) FROM products")->fetchColumn();
    }
}