<?php

namespace App\Repository;

use App\Classes\Utilidades;
use App\Entity\Comentario;
use App\Entity\Escenario;
use App\Entity\Juego;
use App\Entity\JuegoDetalle;
use App\Entity\JuegoEquipo;
use App\Entity\JuegoInvitacion;
use App\Entity\JuegoJugador;
use App\Entity\Jugador;
use App\Entity\Posicion;
use App\Entity\Reserva;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ReservaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Juego::class);
    }

    public function nuevo($datos) {
        $em = $this->getEntityManager();
        $fechaDesde = $datos['fecha_desde']?? '';
        $fechaHasta = $datos['fecha_hasta']?? '';
        $escenario = $datos['escenario']?? '';
        $jugador = $datos['jugador']?? '';
        if($fechaDesde && $fechaHasta && $escenario) {
            $fechaDesde = date_create($fechaDesde);
            $fechaHasta = date_create($fechaHasta);
            $arEscenario = $em->getRepository(Escenario::class)->find($escenario);

            $arReserva = new Reserva();
            $arReserva->setFechaDesde($fechaDesde);
            $arReserva->setFechaHasta($fechaHasta);
            $arReserva->setEscenarioRel($arEscenario);
            if($jugador) {
                $arJugador = $em->getRepository(Jugador::class)->find($jugador);
                $arReserva->setJugadorRel($arJugador);
            }
            $em->persist($arReserva);
            $em->flush();
            return true;
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

    public function escenario($raw) {
        $em = $this->getEntityManager();
        $fecha = $raw['fecha']?? '';
        $escenario = $raw['escenario']?? '';
        if($fecha && $escenario) {
            $qb = $em->createQueryBuilder();
            $qb->from(Reserva::class, "r")
                ->select("r.codigoReservaPk as codigo_reserva")
                ->addSelect("r.fechaDesde as fecha_desde")
                ->addSelect("r.fechaHasta as fecha_hasta")
                ->addSelect("r.estadoPagado as estado_pagado")
                ->addSelect("j.nombreCorto as jugador_nombre_corto")
                ->addSelect("j.seudonimo as jugador_seudonimo")
                ->leftJoin("r.jugadorRel", "j")
                ->where("r.codigoEscenarioFk = {$escenario}")
                ->andWhere("r.fechaDesde >= '$fecha 00:00:00' AND r.fechaDesde <= '$fecha 23:59:59'");
            $arReservas = $qb->getQuery()->getResult();
            return $arReservas;
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

}
