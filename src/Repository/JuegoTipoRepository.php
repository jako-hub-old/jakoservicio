<?php

namespace App\Repository;

use App\Entity\JuegoTipo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method JuegoTipo|null find($id, $lockMode = null, $lockVersion = null)
 * @method JuegoTipo|null findOneBy(array $criteria, array $orderBy = null)
 * @method JuegoTipo[]    findAll()
 * @method JuegoTipo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JuegoTipoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, JuegoTipo::class);
    }

    // /**
    //  * @return JuegoTipo[] Returns an array of JuegoTipo objects
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
    public function findOneBySomeField($value): ?JuegoTipo
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
