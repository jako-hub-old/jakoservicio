<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JugadorRepository")
 */
class Jugador
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="codigo_jugador_pk",type="integer")
     */
    private $codigoJugadorPk;

    /**
     * @ORM\Column(name="identificacion", type="string",length=20, nullable=true)
     */
    private $identificacion;

    /**
     * @ORM\Column(name="nombre", type="string",length=255, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="apellido", type="string",length=255, nullable=true)
     */
    private $apellido;

    /**
     * @ORM\Column(name="correo", type="string", length=120)
     */
    private $correo;

    /**
     * @ORM\OneToMany(targetEntity="JuegoJugador", mappedBy="jugadorRel")
     */
    protected $juegosJugadoresJugadorRel;

    /**
     * @ORM\OneToMany(targetEntity="JuegoInvitacion", mappedBy="jugadorRel")
     */
    protected $juegosInvitacionesJugadorRel;

    /**
     * @ORM\OneToMany(targetEntity="JugadorAmigo", mappedBy="jugadorRel")
     */
    protected $jugadoresAmigosJugadorRel;

    /**
     * @ORM\OneToMany(targetEntity="JugadorAmigo", mappedBy="jugadorAmigoRel")
     */
    protected $jugadoresAmigosJugadorAmigoRel;

    /**
     * @ORM\OneToMany(targetEntity="JugadorSolicitud", mappedBy="jugadorRel")
     */
    protected $jugadoresSolicitudesJugadorRel;

    /**
     * @ORM\OneToMany(targetEntity="JugadorSolicitud", mappedBy="jugadorSolicitudRel")
     */
    protected $jugadoresSolicitudesJugadorSolicitudRel;

    /**
     * @ORM\OneToMany(targetEntity="Usuario", mappedBy="jugadorRel")
     */
    protected $usuariosJugadorRel;

    /**
     * @ORM\OneToMany(targetEntity="JuegoDetalle", mappedBy="jugadorRel")
     */
    protected $juegosDetallesJugadorRel;

}

