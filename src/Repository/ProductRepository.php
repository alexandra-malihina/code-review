<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Repository;

use Doctrine\DBAL\Connection;
use Exception;
use Raketa\BackendTestTask\Entity\Product;

class ProductRepository
{
    private Connection $connection;

    public function __construct(Connection $connection = null)
    {
        $this->connection = $connection;
    }

    public function getByUuid(string $uuid): Product
    {
        //TODO сделать отлов ошибок/логирование и механику обработки
        try {
            $row = $this->connection->fetchOne(
                "SELECT * FROM products WHERE uuid = \"$uuid\"",
            );
        } catch (Exception $e) {
            return throw new Exception('Product getByUuid error');
        }

        if (empty($row)) {
            return throw new Exception('Product not found');
        }

        return $this->make($row);
    }

    public function getByCategory(string $category, int $isActive = 1, int $limit = 10, int $page = 0): array
    {
        $limit = $limit > 0 ? $limit : 10;
        $page = $page > 0 ? $page : 0;
        $offset = $page * $limit;
        //TODO сделать отлов ошибок/логирование
        try {
            $data = $this->connection->fetchAllAssociative(
                "SELECT
                            *
                        FROM
                            products
                        WHERE
                            is_active = $isActive
                            AND category = \"$category\"
                        ORDER BY name
                        LIMIT $limit OFFSET $offset",
            );
        } catch (Exception $e) {
            return throw new Exception('Product getByCategory error:' . $e->getMessage());
        }

        return array_map(
            function (array $row) {
                return new Product(...$row);
            },
            $data
        );
    }

    public function make(array $row): Product
    {
        return new Product(
            $row['id'],
            $row['uuid'],
            $row['is_active'],
            $row['category'],
            $row['name'],
            $row['description'],
            $row['thumbnail'],
            $row['price'],
        );
    }
}
