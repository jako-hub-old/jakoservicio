<?php

namespace App\Repository;

use App\Entity\Escenario;
use App\Entity\Posicion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PosicionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Posicion::class);
    }
    public function lista($datos)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->from(Posicion::class, "p")
            ->select("p.codigoPosicionPk as codigo_posicion")
            ->addSelect("p.nombre");
        $arPosiciones =  $qb->getQuery()->getResult();
        return $arPosiciones;
    }
}
