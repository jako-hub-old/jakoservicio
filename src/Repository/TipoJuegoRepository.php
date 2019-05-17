<?php

namespace App\Repository;

use App\Entity\TipoJuego;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TipoJuego|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoJuego|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoJuego[]    findAll()
 * @method TipoJuego[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoJuegoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TipoJuego::class);
    }

    // /**
    //  * @return TipoJuego[] Returns an array of TipoJuego objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TipoJuego
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
