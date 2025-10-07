<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Entity;

use Raketa\BackendTestTask\Repository\ProductRepository;

final readonly class CartItem
{
    private ?Product $product;
    public function __construct(
        private string $uuid,
        private string $productUuid,
        private float $price,
        private int $quantity,
    ) {
        $this->product = (new ProductRepository())->getByUuid($productUuid);
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getProductUuid(): string
    {
        return $this->productUuid;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getProduct(): Product {
        return $this->product;
    }
}
