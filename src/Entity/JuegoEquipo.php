<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JuegoEquipoRepository")
 */
class JuegoEquipo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="codigo_juego_equipo_pk",type="integer")
     */
    private $codigoJuegoEquipoPk;

    /**
     * @ORM\Column(name="codigo_juego_fk", type="integer")
     */
    private $codigoJuegoFk;

    /**
     * @ORM\Column(name="nombre", type="string",length=100, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="jugadores", type="integer", nullable=true, options={"default" : 0})
     */
    private $jugadores = 0;

    /**
     * @ORM\Column(name="jugadores_confirmados", type="integer", nullable=true, options={"default" : 0})
     */
    private $jugadoresConfirmados = 0;

    /**
     * @ORM\ManyToOne(targetEntity="Juego", inversedBy="juegosEquiposJuegoRel")
     * @ORM\JoinColumn(name="codigo_juego_fk", referencedColumnName="codigo_juego_pk")
     */
    protected $juegoRel;

    /**
     * @ORM\OneToMany(targetEntity="JuegoDetalle", mappedBy="juegoEquipoRel")
     */
    protected $juegosDetallesJuegoEquipoRel;

    /**
     * @return mixed
     */
    public function getCodigoJuegoEquipoPk()
    {
        return $this->codigoJuegoEquipoPk;
    }

    /**
     * @param mixed $codigoJuegoEquipoPk
     */
    public function setCodigoJuegoEquipoPk($codigoJuegoEquipoPk): void
    {
        $this->codigoJuegoEquipoPk = $codigoJuegoEquipoPk;
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
    public function getJugadores()
    {
        return $this->jugadores;
    }

    /**
     * @param mixed $jugadores
     */
    public function setJugadores($jugadores): void
    {
        $this->jugadores = $jugadores;
    }

    /**
     * @return mixed
     */
    public function getJuegosDetallesJuegoEquipoRel()
    {
        return $this->juegosDetallesJuegoEquipoRel;
    }

    /**
     * @param mixed $juegosDetallesJuegoEquipoRel
     */
    public function setJuegosDetallesJuegoEquipoRel($juegosDetallesJuegoEquipoRel): void
    {
        $this->juegosDetallesJuegoEquipoRel = $juegosDetallesJuegoEquipoRel;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getJugadoresConfirmados()
    {
        return $this->jugadoresConfirmados;
    }

    /**
     * @param mixed $jugadoresConfirmados
     */
    public function setJugadoresConfirmados($jugadoresConfirmados): void
    {
        $this->jugadoresConfirmados = $jugadoresConfirmados;
    }



}
