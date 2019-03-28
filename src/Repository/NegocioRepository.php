<?php

namespace App\Repository;

use App\Entity\Escenario;
use App\Entity\Negocio;
use App\Entity\Reserva;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class NegocioRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Negocio::class);
    }

    public function buscar($raw)
    {
        $em = $this->getEntityManager();
        $nombre = $filtros['nombre']?? false;
        $qb = $em->createQueryBuilder();
        $qb->from(Negocio::class, "n")
            ->select("n.codigoNegocioPk as codigo_negocio")
            ->addSelect("n.nombre")
            ->addSelect("n.direccion")
            ->addSelect("n.telefono")
            ->addSelect("n.puntuacion")
            ->addSelect("c.nombre as ciudad_nombre")
            ->addSelect("d.nombre as departamento_nombre")
        ->leftJoin("n.ciudadRel", "c")
        ->leftJoin("c.departamentoRel", "d");
        if($nombre) {
            $qb->andWhere("n.nombre LIKE '%{$nombre}%'");
        }
        $arNegocios =  $qb->getQuery()->getResult();
        return $arNegocios;

    }

}
