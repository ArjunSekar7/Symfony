<?php

namespace App\Repository;

use App\Entity\A;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method A|null find($id, $lockMode = null, $lockVersion = null)
 * @method A|null findOneBy(array $criteria, array $orderBy = null)
 * @method A[]    findAll()
 * @method A[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ARepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, A::class);
    }

    // /**
    //  * @return A[] Returns an array of A objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?A
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
