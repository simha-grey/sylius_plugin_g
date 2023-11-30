<?php

namespace Roma\SyliusProductVariantPlugin\Repository;

use Sylius\Bundle\CoreBundle\Doctrine\ORM\ProductRepository as BaseProductRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
class ProductWithStockRepository extends BaseProductRepository implements ProductWithStockRepositoryInterface
{

    public const PAGINATOR_PER_PAGE = 5;
    public function getProductWithStockPaginator(int $offset, int $status): Paginator
    {
        $qb= $this->createQueryBuilder('p');
        $qb->addSelect('ps')
            ->leftJoin('Roma\SyliusProductVariantPlugin\Entity\ProductStock', 'ps','WITH', 'p.id = ps.product')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->getQuery()
            ->setFirstResult($offset);

        if(!empty($status)){
            $qb->where('ps.stockStatus = :stockStatus')->setParameter('stockStatus', $status);
        }

        return new Paginator($qb);
    }
}
