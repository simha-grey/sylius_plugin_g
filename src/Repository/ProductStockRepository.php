<?php

namespace Roma\SyliusProductVariantPlugin\Repository;

use Roma\SyliusProductVariantPlugin\Entity\ProductStock;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @extends EntityRepository<ProductStock>
 *
 * @method ProductStock|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductStock|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductStock[]    findAll()
 * @method ProductStock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductStockRepository extends EntityRepository
{
    public const PAGINATOR_PER_PAGE = 5;
    public const PRODUCT_MISSING = 2;
    public const PRODUCT_AVAILABLE = 1;
    public const PRODUCT_ALL = 0;

    public function findByProduct($id): ?ProductStock
    {
        $result= $this->createQueryBuilder('p')
            ->where('p.product=:product')
            ->setParameter('product', $id)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

        return $result;

    }

//    public function disable(ProductStock $entity, bool $flush)
//    {
//
//        $entity
//            ->setStockStatus(self::PRODUCT_MISSING)
//            ->setRestockDate((new \DateTime())
//                ->modify('+2 week'));
//
//        $this->getEntityManager()->persist($entity);
//
//        if ($flush) {
//            $this->getEntityManager()->flush();
//        }
//    }
//
//    public function enable(ProductStock $entity, bool $flush)
//    {
//
//        $entity->setStockStatus(self::PRODUCT_AVAILABLE);
//        $this->getEntityManager()->persist($entity);
//
//        if ($flush) {
//            $this->getEntityManager()->flush();
//        }
//    }

//    public function __construct(ManagerRegistry $registry)
//    {
//        parent::__construct($registry, ProductStock::class);
//    }
//
//    public function add(ProductStock $entity, bool $flush = false): void
//    {
//        $this->getEntityManager()->persist($entity);
//
//        if ($flush) {
//            $this->getEntityManager()->flush();
//        }
//    }
//
//    public function remove(ProductStock $entity, bool $flush = false): void
//    {
//        $this->getEntityManager()->remove($entity);
//
//        if ($flush) {
//            $this->getEntityManager()->flush();
//        }
//    }

//    /**
//     * @return ProductStock[] Returns an array of ProductStock objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ProductStock
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
