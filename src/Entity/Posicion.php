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
     * @ORM\OneToMany(targetEntity="JuegoDetalle", mappedBy="posicionRel")
     */
    protected $juegosDetallesPosicionRel;

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



}
