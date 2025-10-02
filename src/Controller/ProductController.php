<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Controller;

use Exception;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Raketa\BackendTestTask\Entity\Product;
use Raketa\BackendTestTask\Infrastructure\Response\JsonResponse;
use Raketa\BackendTestTask\Repository\ProductRepository;

use Raketa\BackendTestTask\View\ProductView;

class ProductController
{
    public function getByCategory(RequestInterface $request): ResponseInterface
    {
        $response = new JsonResponse();

        $rawRequest = json_decode($request->getBody()->getContents(), true);

        $data = [
            'status' => 'success',
            'message' => 'success',
            'data' => []
        ];

        try {
            $products = new ProductRepository();
            $products = $products->getByCategory($rawRequest['category']);
            $data = array_map(
                fn(Product $product) => new ProductView($product)->toArray(),
                $products
            );
        } catch (Exception $e) {
            $data['status'] = 'error';
            $data['message'] = $e->getMessage();
            $response = $response->withStatus(400);
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
