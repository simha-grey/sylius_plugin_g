<?php

namespace Roma\SyliusProductVariantPlugin\Repository;

use Sylius\Bundle\CoreBundle\Doctrine\ORM\ProductRepository as BaseProductRepository;

class ProductWithStockRepository extends BaseProductRepository implements ProductWithStockRepositoryInterface
{

    public const PAGINATOR_PER_PAGE = 5;
    public function findAllProductWithStock(int $offset, int $status): array
    {
        $query= $this->createQueryBuilder('p')
            ->addSelect('ps')
            ->leftJoin('ProductStock','ps')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->getQuery()
            ->setFirstResult($offset);

//        if(!empty($status))$query->setParameter('stockStatus', $status);
//        $where_closure =  ' WHERE TRUE '  . !empty($status) ? ' AND ps.stockStatus = :stockStatus ' : ' ';
//        $query = $this->getEntityManager()->createQuery(
//            'SELECT ps, p
//            FROM Roma\SyliusProductVariantPlugin\Repository\ProductStock ps
//            RIGHT JOIN ps.product p
//            '.$where_closure
//        )->setMaxResults(self::PAGINATOR_PER_PAGE)
//            ->setFirstResult($offset);

        if(!empty($status)){
            $query->setParameter('stockStatus', $status)->where('ps.stockStatus > :stockStatus');
        }

        return new Paginator($query);
    }
}
