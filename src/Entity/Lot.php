<?php
declare(strict_types=1);

namespace App\Entity;

use App\Enum\LotStatus;

class Lot {
    private ?int $id;
    private int $productId;
    private string $lotNumber;
    private int $quantity;
    private string $expirationDate;

    public function __construct(?int $id, int $productId, string $lotNumber, int $quantity, string $expirationDate) {
        $this->id = $id;
        $this->productId = $productId;
        $this->lotNumber = $lotNumber;
        $this->quantity = $quantity;
        $this->expirationDate = $expirationDate;
    }

    public function getId(): ?int { return $this->id; }
    public function getProductId(): int { return $this->productId; }
    public function getLotNumber(): string { return $this->lotNumber; }
    public function getQuantity(): int { return $this->quantity; }
    public function getExpirationDate(): string { return $this->expirationDate; }
    
    public function getStatus(): LotStatus {
        return LotStatus::fromExpirationDate($this->expirationDate);
    }

    public function setProductId(int $productId): void { $this->productId = $productId; }
    public function setLotNumber(string $lotNumber): void { $this->lotNumber = $lotNumber; }
    public function setQuantity(int $quantity): void { $this->quantity = $quantity; }
    public function setExpirationDate(string $expirationDate): void { $this->expirationDate = $expirationDate; }
}