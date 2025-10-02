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
        private int $quantity,
    ) {
        $this->product = new ProductRepository()->getByUuid($uuid);
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
        return $this->product->getPrice();
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getProduct(): Product {
        return $this->product;
    }
}
