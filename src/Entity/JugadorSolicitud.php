<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JugadorSolicitudRepository")
 */
class JugadorSolicitud
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="codigo_jugador_solicitud_pk",type="integer")
     */
    private $codigoJugadorSolicitudPk;

    /**
     * @ORM\Column(name="codigo_jugador_fk", type="integer")
     */
    private $codigoJugadorFk;

    /**
     * @ORM\Column(name="codigo_jugador_solicitud_fk", type="integer")
     */
    private $codigoJugadorSolicitudFk;

    /**
     * @ORM\Column(name="estado_aceptado", type="boolean",options={"default" : false}, nullable=true)
     */
    private $estadoAceptado = false;

    /**
     * @ORM\Column(name="estado_respuesta", type="boolean",options={"default" : false}, nullable=true)
     */
    private $estadoRespuesta = false;

    /**
     * @ORM\ManyToOne(targetEntity="Jugador", inversedBy="jugadoresSolicitudesJugadorRel")
     * @ORM\JoinColumn(name="codigo_jugador_fk", referencedColumnName="codigo_jugador_pk")
     */
    protected $jugadorRel;

    /**
     * @ORM\ManyToOne(targetEntity="Jugador", inversedBy="jugadoresSolicitudesJugadorSolicitudRel")
     * @ORM\JoinColumn(name="codigo_jugador_solicitud_fk", referencedColumnName="codigo_jugador_pk")
     */
    protected $jugadorSolicitudRel;

    /**
     * @return mixed
     */
    public function getCodigoJugadorSolicitudPk()
    {
        return $this->codigoJugadorSolicitudPk;
    }

    /**
     * @param mixed $codigoJugadorSolicitudPk
     */
    public function setCodigoJugadorSolicitudPk($codigoJugadorSolicitudPk): void
    {
        $this->codigoJugadorSolicitudPk = $codigoJugadorSolicitudPk;
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
    public function getCodigoJugadorSolicitudFk()
    {
        return $this->codigoJugadorSolicitudFk;
    }

    /**
     * @param mixed $codigoJugadorSolicitudFk
     */
    public function setCodigoJugadorSolicitudFk($codigoJugadorSolicitudFk): void
    {
        $this->codigoJugadorSolicitudFk = $codigoJugadorSolicitudFk;
    }

    /**
     * @return mixed
     */
    public function getEstadoAceptado()
    {
        return $this->estadoAceptado;
    }

    /**
     * @param mixed $estadoAceptado
     */
    public function setEstadoAceptado($estadoAceptado): void
    {
        $this->estadoAceptado = $estadoAceptado;
    }

    /**
     * @return mixed
     */
    public function getEstadoRespuesta()
    {
        return $this->estadoRespuesta;
    }

    /**
     * @param mixed $estadoRespuesta
     */
    public function setEstadoRespuesta($estadoRespuesta): void
    {
        $this->estadoRespuesta = $estadoRespuesta;
    }

    /**
     * @return Jugador
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
     * @return Jugador
     */
    public function getJugadorSolicitudRel()
    {
        return $this->jugadorSolicitudRel;
    }

    /**
     * @param mixed $jugadorSolicitudRel
     */
    public function setJugadorSolicitudRel($jugadorSolicitudRel): void
    {
        $this->jugadorSolicitudRel = $jugadorSolicitudRel;
    }



}

