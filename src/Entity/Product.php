<?php
declare(strict_types=1);

namespace App\Entity;

class Product {
    private ?int $id;
    private string $name;
    private string $description;
    private float $unitPrice;

    public function __construct(?int $id, string $name, string $description, float $unitPrice = 0.00) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->unitPrice = $unitPrice;
    }

    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }
    public function getUnitPrice(): float { return $this->unitPrice; }

    public function setName(string $name): void { $this->name = $name; }
    public function setDescription(string $description): void { $this->description = $description; }
    public function setUnitPrice(float $unitPrice): void { $this->unitPrice = $unitPrice; }
}