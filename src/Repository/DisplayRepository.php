<?php

namespace App\Repository;

use App\Entity\Display;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Display|null find($id, $lockMode = null, $lockVersion = null)
 * @method Display|null findOneBy(array $criteria, array $orderBy = null)
 * @method Display[]    findAll()
 * @method Display[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DisplayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Display::class);
    }

    // /**
    //  * @return Display[] Returns an array of Display objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Display
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
