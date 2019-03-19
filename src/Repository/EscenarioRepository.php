<?php

namespace App\Repository;

use App\Entity\Escenario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class EscenarioRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Escenario::class);
    }

    public function lista($datos)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->from(Escenario::class, "e")
            ->select("e.codigoEscenarioPk as codigo_escenario")
            ->addSelect("e.codigoNegocioFk as codigo_negocio")
            ->addSelect("e.nombre")
            ->addSelect("n.nombre as negocio_nombre")
            ->leftJoin("e.negocioRel", "n");
        $arEscenarios =  $qb->getQuery()->getResult();
        return $arEscenarios;
    }
}
