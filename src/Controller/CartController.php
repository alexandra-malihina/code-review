<?php

namespace Raketa\BackendTestTask\Controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Raketa\BackendTestTask\Entity\CartItem;
use Raketa\BackendTestTask\Helper\CurrentCustomer;
use Raketa\BackendTestTask\Infrastructure\Manager\CartManager;


use Raketa\BackendTestTask\Infrastructure\Response\JsonResponse;
use Raketa\BackendTestTask\Repository\ProductRepository;
use Raketa\BackendTestTask\View\CartView;
use Ramsey\Uuid\Uuid;

class CartController
{
    public function __construct() {}

    public function addCartItem(RequestInterface $request): ResponseInterface
    {

        $rawRequest = json_decode($request->getBody()->getContents(), true);

        $productRepository = new ProductRepository();
        $cartManager = new CartManager();
        $currentCustomer = CurrentCustomer::getCustomer();

        $product = $productRepository->getByUuid($rawRequest['productUuid']);

        $data = [
            'status' => 'success',
            'message' => 'success',
            'data' => []
        ];

        $cart = $cartManager->getCart($currentCustomer);

        if (! empty($cart)) {
            // ПРоверка на наличие товара в корзине?
            $cart->addItem(new CartItem(
                Uuid::uuid4()->toString(),
                $product->getUuid(),
                $product->getPrice(),
                $rawRequest['quantity']
            ));

            $cartSave = $cartManager->saveCart($cart);
            if (! empty($cartSave)) {
                $data['data'] = (new CartView($cartSave))->toArray();
            } else {
                $data['status'] = 'error';
                $data['message'] = 'Ошибка в сохранении корзины';
            }

        } else {
            $data['status'] = 'error';
            $data['message'] = 'Ошибка в получении корзины для сохранения';
        }

        $response = new JsonResponse();
        // можно заменить на withbody
        $response->getBody()->write(
            json_encode(
                $data,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
            )
        );

        return $response;
    }


    public function getCart(RequestInterface $request): ResponseInterface
    {
        $response = new JsonResponse();

        $rawRequest = json_decode($request->getBody()->getContents(), true);
        $currentCustomer = CurrentCustomer::getCustomer();

        $data = [
            'status' => 'success',
            'message' => 'success',
            'data' => []
        ];
        $cartManager = new CartManager();

        $cart = $cartManager->getCart($currentCustomer);

        if (empty($cart)) {
            $data['status'] = 'error';
            $data['message'] = 'Ошибка в получении корзины';
            $response = $response->withStatus(400);
        } else {
            $data['data'] = (new CartView($cart))->toArray();
        }

        // можно заменить на withbody
        $response->getBody()->write(
            json_encode(
                $data,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
            )
        );

        return $response;
    }
}
