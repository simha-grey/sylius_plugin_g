<?php

namespace Roma\SyliusProductVariantPlugin\Repository;

use Sylius\Component\Core\Repository\ProductRepositoryInterface as BaseProductRepositoryInterface;
interface ProductWithStockRepositoryInterface extends BaseProductRepositoryInterface
{
    public function findAllProductWithStock(int $offset, int $status): array;
}
