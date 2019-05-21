<?php

namespace App\Repository;

use App\Entity\JugadorClan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method JugadorClan|null find($id, $lockMode = null, $lockVersion = null)
 * @method JugadorClan|null findOneBy(array $criteria, array $orderBy = null)
 * @method JugadorClan[]    findAll()
 * @method JugadorClan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JugadorClanRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, JugadorClan::class);
    }

    // /**
    //  * @return JugadorClan[] Returns an array of JugadorClan objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?JugadorClan
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
