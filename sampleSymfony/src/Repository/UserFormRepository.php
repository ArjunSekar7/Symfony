<?php

namespace App\Repository;

use App\Entity\UserForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method UserForm|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserForm|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserForm[]    findAll()
 * @method UserForm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserFormRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserForm::class);
    }

     /**
     *
     * @return UserDetails[] Returns an array of UserDetails objects
     */
    public function getAllUserDetails($page)
    {
        $query = $this->createQueryBuilder('u')
        ->orderBy('u.name', 'ASC')
        ->getQuery();

        $paginator = $this->paginate($query, $page);

        return $paginator;
    }

    public function paginate($dql, $page, $limit = 1)
    {
        $paginator = new Paginator($dql);

        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit);

        return $paginator;
    }

    // /**
    //  * @return UserForm[] Returns an array of UserForm objects
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
    public function findOneBySomeField($value): ?UserForm
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
