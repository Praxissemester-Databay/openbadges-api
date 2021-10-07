<?php

namespace App\Repository;

use App\Entity\Issuer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Issuer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Issuer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Issuer[]    findAll()
 * @method Issuer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IssuerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Issuer::class);
    }

    // /**
    //  * @return Issuer[] Returns an array of Issuer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Issuer
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
