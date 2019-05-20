<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InteresJugadorRepository")
 */
class InteresJugador
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", name="codigo_interes_jugador_pk")
     */
    private $codigoInteresJugadorPk;

    /**
     * @ORM\Column(type="integer", name="codigo_jugador_fk")
     */
    private $codigoJugadorFk;

    /**
     * @ORM\Column(type="integer", name="codigo_interes_fk")
     */
    private $codigoInteresFk;

    /**
     * @ORM\ManyToOne(targetEntity="Jugador", inversedBy="interesesPorJugadorRel")
     * @ORM\JoinColumn(name="codigo_jugador_fk", referencedColumnName="codigo_jugador_pk")
     */
    protected $jugadorRel;

    /**
     * @ORM\ManyToOne(targetEntity="Interes", inversedBy="jugadoresPorInteresRel")
     * @ORM\JoinColumn(name="codigo_interes_fk", referencedColumnName="codigo_interes_pk")
     */
    protected $interesRel;



    public function getCodigoInteresJugadorPk(): ?int
    {
        return $this->codigoInteresJugadorPk;
    }

    public function getCodigoJugadorFk(): ?int
    {
        return $this->codigoJugadorFk;
    }

    public function setCodigoJugadorFk(int $codigoJugadorFk): self
    {
        $this->codigoJugadorFk = $codigoJugadorFk;

        return $this;
    }

    public function getCodigoInteresFk(): ?int
    {
        return $this->codigoInteresFk;
    }

    public function setCodigoInteresFk(int $codigoInteresFk): self
    {
        $this->codigoInteresFk = $codigoInteresFk;

        return $this;
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
    public function getInteresRel()
    {
        return $this->interesRel;
    }

    /**
     * @param mixed $interesRel
     */
    public function setInteresRel($interesRel): void
    {
        $this->interesRel = $interesRel;
    }
}
