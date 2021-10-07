<?php

namespace App\Repository;

use App\Entity\Assignment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Assignment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Assignment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Assignment[]    findAll()
 * @method Assignment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssignmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Assignment::class);
    }

    public function joinedFind($id) {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery('
            SELECT a, b, i, r FROM App\Entity\Assignment a JOIN App\Entity\Badge b JOIN App\Entity\Issuer i JOIN App\Entity\Recipient r
            WHERE a.id = :id AND a.badge = b.id AND a.recipient = r.id AND b.issuer = i.id')
        ->setParameter('id', $id);
        return $query->getResult();
    }

    // /**
    //  * @return Assignment[] Returns an array of Assignment objects
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
    public function findOneBySomeField($value): ?Assignment
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
