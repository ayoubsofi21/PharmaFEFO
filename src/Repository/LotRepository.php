<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Lot;
use PDO;

class LotRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    private function mapRowToEntity(array $row): Lot {
        return new Lot(
            (int)$row['id'],
            (int)$row['product_id'],
            $row['lot_number'],
            (int)$row['quantity'],
            $row['expiration_date']
        );
    }

    public function findAll(): array {
        $stmt = $this->db->query("SELECT * FROM lots ORDER BY expiration_date ASC");
        return array_map([$this, 'mapRowToEntity'], $stmt->fetchAll());
    }

    public function findById(int $id): ?Lot {
        $stmt = $this->db->prepare("SELECT * FROM lots WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? $this->mapRowToEntity($row) : null;
    }

    public function findByProduct(int $productId): array {
        $stmt = $this->db->prepare("SELECT * FROM lots WHERE product_id = :product_id ORDER BY expiration_date ASC");
        $stmt->execute(['product_id' => $productId]);
        return array_map([$this, 'mapRowToEntity'], $stmt->fetchAll());
    }

    public function create(Lot $lot): bool {
        $stmt = $this->db->prepare("INSERT INTO lots (product_id, lot_number, quantity, expiration_date) VALUES (:product_id, :lot_number, :quantity, :expiration_date)");
        return $stmt->execute([
            'product_id' => $lot->getProductId(),
            'lot_number' => $lot->getLotNumber(),
            'quantity' => $lot->getQuantity(),
            'expiration_date' => $lot->getExpirationDate()
        ]);
    }

    public function update(Lot $lot): bool {
        $stmt = $this->db->prepare("UPDATE lots SET product_id = :product_id, lot_number = :lot_number, quantity = :quantity, expiration_date = :expiration_date WHERE id = :id");
        return $stmt->execute([
            'id' => $lot->getId(),
            'product_id' => $lot->getProductId(),
            'lot_number' => $lot->getLotNumber(),
            'quantity' => $lot->getQuantity(),
            'expiration_date' => $lot->getExpirationDate()
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM lots WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function countActiveLots(): int {
        return (int)$this->db->query("SELECT COUNT(*) FROM lots WHERE quantity > 0")->fetchColumn();
    }

    public function findCriticalLots(): array {
        $stmt = $this->db->query("SELECT * FROM lots WHERE expiration_date >= CURDATE() AND DATEDIFF(expiration_date, CURDATE()) < 30 AND quantity > 0 ORDER BY expiration_date ASC");
        return array_map([$this, 'mapRowToEntity'], $stmt->fetchAll());
    }

    public function findWarningLots(): array {
        $stmt = $this->db->query("SELECT * FROM lots WHERE DATEDIFF(expiration_date, CURDATE()) >= 30 AND DATEDIFF(expiration_date, CURDATE()) < 90 AND quantity > 0 ORDER BY expiration_date ASC");
        return array_map([$this, 'mapRowToEntity'], $stmt->fetchAll());
    }

    public function findExpiredLots(): array {
        $stmt = $this->db->query("SELECT * FROM lots WHERE expiration_date < CURDATE() AND quantity > 0 ORDER BY expiration_date ASC");
        return array_map([$this, 'mapRowToEntity'], $stmt->fetchAll());
    }

    public function countExpiringInDays(int $days): int {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM lots WHERE expiration_date >= CURDATE() AND DATEDIFF(expiration_date, CURDATE()) <= :days AND quantity > 0");
        $stmt->execute(['days' => $days]);
        return (int)$stmt->fetchColumn();
    }

    public function countExpired(): int {
        return (int)$this->db->query("SELECT COUNT(*) FROM lots WHERE expiration_date < CURDATE() AND quantity > 0")->fetchColumn();
    }

    public function findAvailableLotsForProduct(int $productId): array {
        $stmt = $this->db->prepare("SELECT * FROM lots WHERE product_id = :product_id AND quantity > 0 AND expiration_date >= CURDATE() ORDER BY expiration_date ASC");
        $stmt->execute(['product_id' => $productId]);
        return array_map([$this, 'mapRowToEntity'], $stmt->fetchAll());
    }
}