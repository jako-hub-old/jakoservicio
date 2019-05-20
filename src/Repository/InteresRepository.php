<?php

namespace App\Repository;

use App\Entity\Interes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Interes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Interes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Interes[]    findAll()
 * @method Interes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InteresRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Interes::class);
    }

    // /**
    //  * @return Interes[] Returns an array of Interes objects
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
    public function findOneBySomeField($value): ?Interes
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
