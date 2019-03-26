<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JuegoDetalleRepository")
 */
class JuegoDetalle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="codigo_juego_detalle_pk",type="integer")
     */
    private $codigoJuegoDetallePk;

    /**
     * @ORM\Column(name="codigo_juego_fk", type="integer")
     */
    private $codigoJuegoFk;

    /**
     * @ORM\Column(name="codigo_jugador_fk", type="integer")
     */
    private $codigoJugadorFk;

    /**
     * @ORM\Column(name="numero", type="integer", nullable=true, options={"default" : null})
     */
    private $numero;

    /**
     * @ORM\Column(name="codigo_posicion_fk", type="string", length=10)
     */
    private $codigoPosicionFk;

    /**
     * @ORM\Column(name="codigo_juego_equipo_fk", type="integer", nullable=true, options={"default" : null})
     */
    private $codigoJuegoEquipoFk;

    /**
     * @ORM\ManyToOne(targetEntity="Juego", inversedBy="juegosDetallesJuegoRel")
     * @ORM\JoinColumn(name="codigo_juego_fk", referencedColumnName="codigo_juego_pk")
     */
    protected $juegoRel;

    /**
     * @ORM\ManyToOne(targetEntity="Jugador", inversedBy="juegosDetallesJugadorRel")
     * @ORM\JoinColumn(name="codigo_jugador_fk", referencedColumnName="codigo_jugador_pk")
     */
    protected $jugadorRel;

    /**
     * @ORM\ManyToOne(targetEntity="Posicion", inversedBy="juegosDetallesPosicionRel")
     * @ORM\JoinColumn(name="codigo_posicion_fk", referencedColumnName="codigo_posicion_pk")
     */
    protected $posicionRel;

    /**
     * @ORM\ManyToOne(targetEntity="JuegoEquipo", inversedBy="juegosDetallesJuegoEquipoRel")
     * @ORM\JoinColumn(name="codigo_juego_equipo_fk", referencedColumnName="codigo_juego_equipo_pk")
     */
    protected $juegoEquipoRel;

    /**
     * @return mixed
     */
    public function getCodigoJuegoDetallePk()
    {
        return $this->codigoJuegoDetallePk;
    }

    /**
     * @param mixed $codigoJuegoDetallePk
     */
    public function setCodigoJuegoDetallePk($codigoJuegoDetallePk): void
    {
        $this->codigoJuegoDetallePk = $codigoJuegoDetallePk;
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
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero): void
    {
        $this->numero = $numero;
    }

    /**
     * @return mixed
     */
    public function getCodigoPosicionFk()
    {
        return $this->codigoPosicionFk;
    }

    /**
     * @param mixed $codigoPosicionFk
     */
    public function setCodigoPosicionFk($codigoPosicionFk): void
    {
        $this->codigoPosicionFk = $codigoPosicionFk;
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

    /**
     * @return mixed
     */
    public function getPosicionRel()
    {
        return $this->posicionRel;
    }

    /**
     * @param mixed $posicionRel
     */
    public function setPosicionRel($posicionRel): void
    {
        $this->posicionRel = $posicionRel;
    }

    /**
     * @return mixed
     */
    public function getCodigoJuegoEquipoFk()
    {
        return $this->codigoJuegoEquipoFk;
    }

    /**
     * @param mixed $codigoJuegoEquipoFk
     */
    public function setCodigoJuegoEquipoFk($codigoJuegoEquipoFk): void
    {
        $this->codigoJuegoEquipoFk = $codigoJuegoEquipoFk;
    }

    /**
     * @return mixed
     */
    public function getJuegoEquipoRel()
    {
        return $this->juegoEquipoRel;
    }

    /**
     * @param mixed $juegoEquipoRel
     */
    public function setJuegoEquipoRel($juegoEquipoRel): void
    {
        $this->juegoEquipoRel = $juegoEquipoRel;
    }



}
