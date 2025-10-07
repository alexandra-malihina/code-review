<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\View;

use Raketa\BackendTestTask\Entity\Cart;
use Raketa\BackendTestTask\Repository\ProductRepository;

readonly class CartView
{
    public function __construct(
        private Cart $cart
    ) {}

    public function toArray(): array
    {
        $data = [
            'uuid' => $this->cart->getUuid(),
            'customer' => [
                'id' => $this->cart->getCustomer()->getId(),
                'name' => implode(' ', [
                    $this->cart->getCustomer()->getLastName(),
                    $this->cart->getCustomer()->getFirstName(),
                    $this->cart->getCustomer()->getMiddleName(),
                ]),
                'email' => $this->cart->getCustomer()->getEmail(),
            ],
            'payment_method' => $this->cart->getPaymentMethod(),
        ];


        $total = 0;
        $data['items'] = [];

        $productRepository = new ProductRepository();
        foreach ($this->cart->getItems() as $item) {
            $product = $productRepository->getByUuid($item->getProductUuid());
            // общая сумма товара с учетом кол-ва
            $totalItem = 0;
            // стоимость товара в корзине 
            // заменила на полдучение текущей реальной стоимости товара
            // сохраненные цены в корзине могут быть не актуальными 
            $itemPrice =  $product->getPrice();
            if (! $product->getIsActive()) {
                $itemPrice = 0;
            }
            $totalItem = $itemPrice * $item->getQuantity();
            $total += $totalItem;

            $data['items'][] = [
                'uuid' => $item->getUuid(),
                'price' => number_format($itemPrice, 2, '.', ''),
                'total' => number_format($totalItem, 2, '.', ''),
                'quantity' => $item->getQuantity(),
                'product' => [
                    'id' => $product->getId(),
                    'uuid' => $product->getUuid(),
                    'name' => $product->getName(),
                    'thumbnail' => $product->getThumbnail(),
                    'price' =>  number_format($product->getPrice(), 2, '.', ''),
                ],
            ];
        }

        $data['total'] =  number_format($total, 2, '.', '');

        return $data;
    }
}
