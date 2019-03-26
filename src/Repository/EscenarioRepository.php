<?php

namespace App\Repository;

use App\Entity\Escenario;
use App\Entity\Reserva;
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
        $negocio = $datos['negocio']?? false;
        $fecha = $datos['fecha']?? false;
        $qb = $em->createQueryBuilder();
        $qb->from(Escenario::class, "e")
            ->select("e.codigoEscenarioPk as codigo_escenario")
            ->addSelect("e.codigoNegocioFk as codigo_negocio")
            ->addSelect("e.nombre")
            ->addSelect("n.nombre as negocio_nombre")
            ->leftJoin("e.negocioRel", "n");
        if($negocio) {
            $qb->andWhere("e.codigoNegocioFk={$negocio}");
        }
        $arEscenarios =  $qb->getQuery()->getResult();
        $i = 0;
        foreach ($arEscenarios as $arEscenario) {
            $qb = $em->createQueryBuilder();
            $qb->from(Reserva::class, "r")
                ->select("r.codigoReservaPk as codigo_reserva")
                ->addSelect("r.fechaDesde as fecha_desde")
                ->addSelect("r.fechaHasta as fecha_hasta")
                ->addSelect("r.estadoPagado as estado_pagado")
                ->addSelect("j.nombreCorto as jugador_nombre_corto")
                ->addSelect("j.seudonimo as jugador_seudonimo")
                ->leftJoin("r.jugadorRel", "j")
                ->where("r.codigoEscenarioFk = {$arEscenario['codigo_escenario']}")
                ->andWhere("r.fechaDesde >= '$fecha 00:00:00' AND r.fechaDesde <= '$fecha 23:59:59'");
            $arReservas = $qb->getQuery()->getResult();
            $arEscenarios[$i]['reservas'] = $arReservas;
            $i++;
        }

        return $arEscenarios;
    }
}
