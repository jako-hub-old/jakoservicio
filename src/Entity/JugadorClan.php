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
     * @ORM\Column(name="confirmado", type="boolean", nullable=true)
     */
    private $confirmado=false;

    /**
     * @ORM\Column(name="invitacion", type="boolean", nullable=true)
     */
    private $invitacion=false;

    /**
     * @ORM\Column(name="solicitud", type="boolean", nullable=true)
     */
    private $solicitud=false;

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

    /**
     * @return mixed
     */
    public function getConfirmado()
    {
        return $this->confirmado;
    }

    /**
     * @param mixed $confirmado
     */
    public function setConfirmado($confirmado): void
    {
        $this->confirmado = $confirmado;
    }

    /**
     * @return mixed
     */
    public function getInvitacion()
    {
        return $this->invitacion;
    }

    /**
     * @param mixed $invitacion
     */
    public function setInvitacion($invitacion): void
    {
        $this->invitacion = $invitacion;
    }

    /**
     * @return mixed
     */
    public function getSolicitud()
    {
        return $this->solicitud;
    }

    /**
     * @param mixed $solicitud
     */
    public function setSolicitud($solicitud): void
    {
        $this->solicitud = $solicitud;
    }
}
