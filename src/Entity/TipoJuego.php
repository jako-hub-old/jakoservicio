<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TipoJuegoRepository")
 */
class TipoJuego
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", name ="codigo_tipo_juego_pk")
     */
    private $codigoTipoJuegoPk;

    /**
     * @ORM\Column(type="string", length=255, name="nombre")
     */
    private $nombre;

    /**
     * @ORM\Column(type="text", nullable=true, name="descripcion")
     */
    private $descripcion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $no;

    /**
     * @ORM\OneToMany(targetEntity="Juego", mappedBy="tipoJuegoRel")
     */
    protected $tipoJuegoJuegoRel;

    public function getCodigoTipoJuegoPk(): ?int
    {
        return $this->codigoTipoJuegoPk;
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

    public function getNo(): ?string
    {
        return $this->no;
    }

    public function setNo(string $no): self
    {
        $this->no = $no;

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
}
