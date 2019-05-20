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

    public function lista() {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder()
                ->from(Interes::class, "i")
                ->select("i.codigoInteresPk as codigo_interes")
                ->addSelect("i.nombre")
                ->addSelect("i.descripcion")
                ->addSelect("i.icono");
        return $qb->getQuery()->getResult();
    }
}
