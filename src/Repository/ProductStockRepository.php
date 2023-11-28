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
        //TODO createQuery do not work with RIGHT JOIN. For LEFT JOIN I must inject PRODUCT class but I've got strange error

        $where_closure =  ' WHERE TRUE '  . !empty($status) ? ' AND ps.stockStatus = :stockStatus ' : ' ';
        $query = "
        SELECT p.*, ps.*
        FROM sylius_product p
        LEFT JOIN ProductSock ps on ps.product_id = p.id
        $where_closure
        OFFSET $offset
        LIMIT self::PAGINATOR_PER_PAGE";

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($query);
        if(!empty($status))$stmt->bindvalues('stockStatus', $status);

        $stmt->execute();

//        $query = $this->getEntityManager()->createQuery(
//            'SELECT ps, p
//            FROM Roma\SyliusProductVariantPlugin\Entity\ProductStock ps
//            RIGHT JOIN ps.product p
//            '.$where_closure
//        )->setMaxResults(self::PAGINATOR_PER_PAGE)
//        ->setFirstResult($offset);

        return new Paginator($stmt);
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
