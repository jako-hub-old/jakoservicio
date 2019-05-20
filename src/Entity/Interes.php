<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="InteresRepository")
 */
class Interes
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", name="codigo_interes_pk")
     */
    private $codigoInteresPk;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity="InteresJugador", mappedBy="interesRel")
     */
    protected $jugadoresPorInteresRel;

    public function getCodigoInteresPk(): ?int
    {
        return $this->codigoInteresPk;
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
    public function getJugadoresPorInteresRel()
    {
        return $this->jugadoresPorInteresRel;
    }

    /**
     * @param mixed $jugadoresPorInteresRel
     */
    public function setJugadoresPorInteresRel($jugadoresPorInteresRel): void
    {
        $this->jugadoresPorInteresRel = $jugadoresPorInteresRel;
    }
}
