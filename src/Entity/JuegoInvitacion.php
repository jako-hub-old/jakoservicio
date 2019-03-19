<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JuegoInvitacionRepository")
 */
class JuegoInvitacion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="codigo_juego_invitacion_pk",type="integer")
     */
    private $codigoJuegoInvitacionPk;

    /**
     * @ORM\Column(name="codigo_juego_fk" , type="integer")
     */
    private $codigoJuegoFk;

    /**
     * @ORM\Column(name="codigo_jugador_fk", type="integer")
     */
    private $codigoJugadorFk;

    /**
     * @ORM\Column(name="estado_aceptada", type="boolean",options={"default" : false}, nullable=true)
     */
    private $estadoAceptada = false;

    /**
     * @ORM\Column(name="estado_rechazada", type="boolean",options={"default" : false}, nullable=true)
     */
    private $estadoRechazada = false;

    /**
     * @ORM\ManyToOne(targetEntity="Juego", inversedBy="juegosInvitacionesJuegoRel")
     * @ORM\JoinColumn(name="codigo_juego_fk", referencedColumnName="codigo_juego_pk")
     */
    protected $juegoRel;

    /**
     * @ORM\ManyToOne(targetEntity="Jugador", inversedBy="juegosInvitacionesJugadorRel")
     * @ORM\JoinColumn(name="codigo_jugador_fk", referencedColumnName="codigo_jugador_pk")
     */
    protected $jugadorRel;

    /**
     * @return mixed
     */
    public function getCodigoJuegoInvitacionPk()
    {
        return $this->codigoJuegoInvitacionPk;
    }

    /**
     * @param mixed $codigoJuegoInvitacionPk
     */
    public function setCodigoJuegoInvitacionPk($codigoJuegoInvitacionPk): void
    {
        $this->codigoJuegoInvitacionPk = $codigoJuegoInvitacionPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoJuegoFk()
    {
        return $this->codigoJuegoFk;
    }

    /**
     * @param mixed $codigoJuegoFk
     */
    public function setCodigoJuegoFk($codigoJuegoFk): void
    {
        $this->codigoJuegoFk = $codigoJuegoFk;
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
    public function getEstadoAceptada()
    {
        return $this->estadoAceptada;
    }

    /**
     * @param mixed $estadoAceptada
     */
    public function setEstadoAceptada($estadoAceptada): void
    {
        $this->estadoAceptada = $estadoAceptada;
    }

    /**
     * @return mixed
     */
    public function getEstadoRechazada()
    {
        return $this->estadoRechazada;
    }

    /**
     * @param mixed $estadoRechazada
     */
    public function setEstadoRechazada($estadoRechazada): void
    {
        $this->estadoRechazada = $estadoRechazada;
    }

    /**
     * @return mixed
     */
    public function getJuegoRel()
    {
        return $this->juegoRel;
    }

    /**
     * @param mixed $juegoRel
     */
    public function setJuegoRel($juegoRel): void
    {
        $this->juegoRel = $juegoRel;
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



}
