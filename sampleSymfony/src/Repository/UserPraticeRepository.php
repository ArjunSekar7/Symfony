<?php

namespace App\Repository;

use App\Entity\UserPratice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserPratice|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserPratice|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserPratice[]    findAll()
 * @method UserPratice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserPraticeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserPratice::class);
    }

    // /**
    //  * @return UserPratice[] Returns an array of UserPratice objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserPratice
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
