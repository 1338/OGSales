<?php

namespace App\Repository\Order;

use App\Entity\Order\OrderDeadDrop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderDeadDrop>
 *
 * @method OrderDeadDrop|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderDeadDrop|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderDeadDrop[]    findAll()
 * @method OrderDeadDrop[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderDeadDropRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderDeadDrop::class);
    }

    public function add(OrderDeadDrop $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(OrderDeadDrop $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return OrderDeadDrop[] Returns an array of OrderDeadDrop objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OrderDeadDrop
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
