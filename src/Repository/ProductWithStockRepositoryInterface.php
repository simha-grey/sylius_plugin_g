<?php

namespace Roma\SyliusProductVariantPlugin\Repository;

use Sylius\Component\Core\Repository\ProductRepositoryInterface as BaseProductRepositoryInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
interface ProductWithStockRepositoryInterface extends BaseProductRepositoryInterface
{
    public function getProductWithStockPaginator(int $offset, int $status): Paginator;
}
