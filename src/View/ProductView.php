<?php

namespace Raketa\BackendTestTask\View;

use Raketa\BackendTestTask\Entity\Product;


readonly class ProductView
{
    public function __construct(
        private Product $product
    ) {}
    public function toArray(): array
    {
        return [
            'id' => $this->product->getId(),
            'uuid' => $this->product->getUuid(),
            'name' => $this->product->getName(),
            'is_active' => $this->product->getIsActive(),
            'category' => $this->product->getCategory(),
            'description' => $this->product->getDescription(),
            'thumbnail' => $this->product->getThumbnail(),
            'price' => $this->product->getPrice(),
        ];
    }
}
