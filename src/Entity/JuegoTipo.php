<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JuegoTipoRepository")
 */
class JuegoTipo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", name ="codigo_juego_tipo_pk")
     */
    private $codigoJuegoTipoPk;

    /**
     * @ORM\Column(type="string", length=255, name="nombre")
     */
    private $nombre;

    /**
     * @ORM\Column(type="text", nullable=true, name="descripcion")
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity="Juego", mappedBy="tipoJuegoRel")
     */
    protected $tipoJuegoJuegoRel;

    /**
     * @ORM\OneToMany(targetEntity="Posicion", mappedBy="tipoJuegoRel")
     */
    protected  $posicionesTipoRel;

    /**
     * @ORM\OneToMany(targetEntity="Clan", mappedBy="tipoJuegoRel")
     */
    protected $tipoJuegoClanRel;

    public function getCodigoJuegoTipoPk(): ?int
    {
        return $this->codigoJuegoTipoPk;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTipoJuegoJuegoRel()
    {
        return $this->tipoJuegoJuegoRel;
    }

    /**
     * @param Juego[] $tipoJuegoJuegoRel
     */
    public function setTipoJuegoJuegoRel($tipoJuegoJuegoRel): void
    {
        $this->tipoJuegoJuegoRel = $tipoJuegoJuegoRel;
    }

    /**
     * @return mixed
     */
    public function getPosicionesTipoRel()
    {
        return $this->posicionesTipoRel;
    }

    /**
     * @param mixed $posicionesTipoRel
     */
    public function setPosicionesTipoRel($posicionesTipoRel): void
    {
        $this->posicionesTipoRel = $posicionesTipoRel;
    }

    /**
     * @return mixed
     */
    public function getTipoJuegoClanRel()
    {
        return $this->tipoJuegoClanRel;
    }

    /**
     * @param mixed $tipoJuegoClanRel
     */
    public function setTipoJuegoClanRel($tipoJuegoClanRel): void
    {
        $this->tipoJuegoClanRel = $tipoJuegoClanRel;
    }
}
