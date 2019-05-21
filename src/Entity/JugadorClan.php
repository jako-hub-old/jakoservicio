<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JugadorClanRepository")
 */
class JugadorClan
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="codigo_jugador_clan_pk", type="integer")
     */
    private $codigoJugadorClanPk;

    /**
     * @ORM\Column(name="codigo_jugador_fk", type="integer")
     */
    private $codigoJugadorFk;

    /**
     * @ORM\Column(name="codigo_clan_fk", type="integer")
     */
    private $codigoClanFk;

    /**
     * @ORM\ManyToOne(targetEntity="Jugador", inversedBy="clanJugadorClanRel")
     * @ORM\JoinColumn(name="codigo_jugador_fk", referencedColumnName="codigo_jugador_pk")
     */
    protected $jugadorRel;
    /**
     * @ORM\ManyToOne(targetEntity="Clan", inversedBy="clanJugadorClanRel")
     * @ORM\JoinColumn(name="codigo_clan_fk", referencedColumnName="codigo_clan_pk")
     */
    protected $clanRel;

    public function getCodigoJugadorClanPk(): ?int
    {
        return $this->codigoJugadorClanPk;
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

    public function getCodigoClanFk(): ?int
    {
        return $this->codigoClanFk;
    }

    public function setCodigoClanFk(int $codigoClanFk): self
    {
        $this->codigoClanFk = $codigoClanFk;

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
    public function getClanRel()
    {
        return $this->clanRel;
    }

    /**
     * @param mixed $clanRel
     */
    public function setClanRel($clanRel): void
    {
        $this->clanRel = $clanRel;
    }
}
