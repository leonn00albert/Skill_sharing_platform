<?php

namespace App\Repository;

use App\Entity\CompletedSections;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompletedSections>
 *
 * @method CompletedSections|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompletedSections|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompletedSections[]    findAll()
 * @method CompletedSections[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompletedSectionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompletedSections::class);
    }

//    /**
//     * @return CompletedSections[] Returns an array of CompletedSections objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CompletedSections
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
