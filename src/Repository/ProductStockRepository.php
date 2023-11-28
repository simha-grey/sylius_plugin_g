<?php

namespace Roma\SyliusProductVariantPlugin\Repository;

use Roma\SyliusProductVariantPlugin\Entity\ProductStock;
//use Doctrine\Persistence\ManagerRegistry;
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
    public function getProductStock(int $offset, int $status): Paginator
    {

        $where_closure = !empty($status) ? ' ps.stockStatus = :stockStatus ' : ' ';
        $query = $this->getEntityManager()->createQuery(
            'SELECT ps, p
            FROM Roma\SyliusProductVariantPlugin\Entity\ProductStock ps
            INNER JOIN ps.product p
            '.$where_closure
        )->setMaxResults(self::PAGINATOR_PER_PAGE)
        ->setFirstResult($offset);

        if(!empty($status))$query->setParameter('stockStatus', $status);

        return new Paginator($query);
    }
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
