<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservaRepository")
 */
class Reserva
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="codigo_juego_pk",type="integer")
     */
    private $codigoReservaPk;

    /**
     * @ORM\Column(name="codigo_escenario_fk", type="integer")
     */
    private $codigoEscenarioFk;

    /**
     * @ORM\Column(name="fecha_desde" , type="datetime")
     */
    private $fechaDesde;

    /**
     * @ORM\Column(name="fecha_hasta" , type="datetime")
     */
    private $fechaHasta;

    /**
     * @ORM\Column(name="codigo_jugador_fk", type="integer", nullable=true)
     */
    private $codigoJugadorFk;

    /**
     * @ORM\Column(name="estado_pagado", type="boolean", options={"default" : false}, nullable=true)
     */
    private $estadoPagado = false;

    /**
     * @ORM\ManyToOne(targetEntity="Escenario", inversedBy="reservasEscenarioRel")
     * @ORM\JoinColumn(name="codigo_escenario_fk", referencedColumnName="codigo_escenario_pk")
     */
    protected $escenarioRel;

    /**
     * @ORM\ManyToOne(targetEntity="Jugador", inversedBy="reservasJugadorRel")
     * @ORM\JoinColumn(name="codigo_jugador_fk", referencedColumnName="codigo_jugador_pk")
     */
    protected $jugadorRel;

    /**
     * @return mixed
     */
    public function getCodigoReservaPk()
    {
        return $this->codigoReservaPk;
    }

    /**
     * @param mixed $codigoReservaPk
     */
    public function setCodigoReservaPk($codigoReservaPk): void
    {
        $this->codigoReservaPk = $codigoReservaPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoEscenarioFk()
    {
        return $this->codigoEscenarioFk;
    }

    /**
     * @param mixed $codigoEscenarioFk
     */
    public function setCodigoEscenarioFk($codigoEscenarioFk): void
    {
        $this->codigoEscenarioFk = $codigoEscenarioFk;
    }

    /**
     * @return mixed
     */
    public function getFechaDesde()
    {
        return $this->fechaDesde;
    }

    /**
     * @param mixed $fechaDesde
     */
    public function setFechaDesde($fechaDesde): void
    {
        $this->fechaDesde = $fechaDesde;
    }

    /**
     * @return mixed
     */
    public function getFechaHasta()
    {
        return $this->fechaHasta;
    }

    /**
     * @param mixed $fechaHasta
     */
    public function setFechaHasta($fechaHasta): void
    {
        $this->fechaHasta = $fechaHasta;
    }

    /**
     * @return mixed
     */
    public function getCodigoJugadorFk()
    {
        return $this->codigoJugadorFk;
    }

    /**
     * @param mixed $codigoJugadorFk
     */
    public function setCodigoJugadorFk($codigoJugadorFk): void
    {
        $this->codigoJugadorFk = $codigoJugadorFk;
    }

    /**
     * @return mixed
     */
    public function getEscenarioRel()
    {
        return $this->escenarioRel;
    }

    /**
     * @param mixed $escenarioRel
     */
    public function setEscenarioRel($escenarioRel): void
    {
        $this->escenarioRel = $escenarioRel;
    }

    /**
     * @return mixed
     */
    public function getJugadorRel()
    {
        return $this->jugadorRel;
    }

    /**
     * @param mixed $jugadorRel
     */
    public function setJugadorRel($jugadorRel): void
    {
        $this->jugadorRel = $jugadorRel;
    }

    /**
     * @return mixed
     */
    public function getEstadoPagado()
    {
        return $this->estadoPagado;
    }

    /**
     * @param mixed $estadoPagado
     */
    public function setEstadoPagado($estadoPagado): void
    {
        $this->estadoPagado = $estadoPagado;
    }



}
