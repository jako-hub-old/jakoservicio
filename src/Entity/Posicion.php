<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PosicionRepository")
 */
class Posicion
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="codigo_posicion_pk", type="string", length=10)
     */
    private $codigoPosicionPk;

    /**
     * @ORM\Column(name="nombre", type="string",length=50, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_tipo_juego_fk", type="integer", nullable=true)
     */
    private $codigoTipoJuegoFk;

    /**
     * @ORM\OneToMany(targetEntity="JuegoDetalle", mappedBy="posicionRel")
     */
    protected $juegosDetallesPosicionRel;

    /**
     * @ORM\ManyToOne(targetEntity="JuegoTipo", inversedBy="posicionesTipoRel")
     * @ORM\JoinColumn(name="codigo_tipo_juego_fk", referencedColumnName="codigo_juego_tipo_pk")
     */
    protected $tipoJuegoRel;


    /**
     * @return mixed
     */
    public function getCodigoPosicionPk()
    {
        return $this->codigoPosicionPk;
    }

    /**
     * @param mixed $codigoPosicionPk
     */
    public function setCodigoPosicionPk($codigoPosicionPk): void
    {
        $this->codigoPosicionPk = $codigoPosicionPk;
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
    public function getJuegosDetallesPosicionRel()
    {
        return $this->juegosDetallesPosicionRel;
    }

    /**
     * @param mixed $juegosDetallesPosicionRel
     */
    public function setJuegosDetallesPosicionRel($juegosDetallesPosicionRel): void
    {
        $this->juegosDetallesPosicionRel = $juegosDetallesPosicionRel;
    }

    /**
     * @return mixed
     */
    public function getCodigoTipoJuegoFk()
    {
        return $this->codigoTipoJuegoFk;
    }

    /**
     * @param mixed $codigoTipoJuegoFk
     */
    public function setCodigoTipoJuegoFk($codigoTipoJuegoFk): void
    {
        $this->codigoTipoJuegoFk = $codigoTipoJuegoFk;
    }

    /**
     * @return mixed
     */
    public function getTipoJuegoRel()
    {
        return $this->tipoJuegoRel;
    }

    /**
     * @param mixed $tipoJuegoRel
     */
    public function setTipoJuegoRel($tipoJuegoRel): void
    {
        $this->tipoJuegoRel = $tipoJuegoRel;
    }
}
