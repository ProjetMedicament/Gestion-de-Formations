<?php

namespace App\Repository;

use App\Entity\Visa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Visa|null find($id, $lockMode = null, $lockVersion = null)
 * @method Visa|null findOneBy(array $criteria, array $orderBy = null)
 * @method Visa[]    findAll()
 * @method Visa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visa::class);
    }

    // /**
    //  * @return Visa[] Returns an array of Visa objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Visa
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
