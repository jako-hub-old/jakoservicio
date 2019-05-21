<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClanRepository")
 * @author Jorge Alejandro Quiroz Serna <jakop.box@gmail.com>
 */
class Clan
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="codigo_clan_pk", type="integer")
     */
    private $codigoClanPk;

    /**
     * @ORM\Column(name="codigo_jugador_fk", type="integer")
     */
    private $codigoJugadorFk;

    /**
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_tipo_juego_fk", type="integer")
     */
    private $codigoTipoJuegoFk;

    /**
     * @ORM\Column(name="foto", type="string", length=500, nullable=true)
     */
    private $foto;

    /**
     * @ORM\Column(name="fecha_creacion", type="datetime", nullable=true)
     */
    private $fechaCreacion;

    /**
     * @ORM\OneToMany(targetEntity="JugadorClan", mappedBy="clanRel")
     */
    protected $clanJugadorClanRel;

    /**
     * @ORM\ManyToOne(targetEntity="Jugador", inversedBy="jugadorClanRel")
     * @ORM\JoinColumn(name="codigo_jugador_fk", referencedColumnName="codigo_jugador_pk")
     */
    protected $jugadorRel;

    /**
     * @ORM\ManyToOne(targetEntity="JuegoTipo", inversedBy="tipoJuegoClanRel")
     * @ORM\JoinColumn(name="codigo_tipo_juego_fk", referencedColumnName="codigo_juego_tipo_pk")
     */
    protected $tipoJuegoRel;

    public function getCodigoClanPk(): ?int
    {
        return $this->codigoClanPk;
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

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getCodigoTipoJuegoFk(): ?int
    {
        return $this->codigoTipoJuegoFk;
    }

    public function setCodigoTipoJuegoFk(int $codigoTipoJuegoFk): self
    {
        $this->codigoTipoJuegoFk = $codigoTipoJuegoFk;

        return $this;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(?string $foto): self
    {
        $this->foto = $foto;

        return $this;
    }

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->fechaCreacion;
    }

    public function setFechaCreacion(?\DateTimeInterface $fechaCreacion): self
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getClanJugadorClanRel()
    {
        return $this->clanJugadorClanRel;
    }

    /**
     * @param mixed $clanJugadorClanRel
     */
    public function setClanJugadorClanRel($clanJugadorClanRel): void
    {
        $this->clanJugadorClanRel = $clanJugadorClanRel;
    }

    /**
     * @return Jugador
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
