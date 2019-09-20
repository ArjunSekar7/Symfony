<?php

namespace App\Repository;

use App\Entity\MainCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MainCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method MainCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method MainCategory[]    findAll()
 * @method MainCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MainCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MainCategory::class);
    }

    // /**
    //  * @return MainCategory[] Returns an array of MainCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MainCategory
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
