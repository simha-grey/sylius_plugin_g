<?php

namespace Roma\SyliusProductVariantPlugin\Repository;

use Sylius\Component\Core\Repository\ProductRepositoryInterface as BaseProductRepositoryInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
interface ProductWithStockRepositoryInterface extends BaseProductRepositoryInterface
{
    public function findAllProductWithStock(int $offset, int $status): Paginator;
}
