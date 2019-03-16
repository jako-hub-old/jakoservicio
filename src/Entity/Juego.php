<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JuegoRepository")
 */
class Juego
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="codigo_juego_pk",type="integer")
     */
    private $codigoJuegoPk;

    /**
     * @ORM\Column(name="fecha" , type="datetime")
     */
    private $fecha;

    /**
     * @ORM\Column(name="nombre", type="string",length=100, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="jugadores", type="integer", nullable=true, options={"default" : 0})
     */
    private $jugadores = 0;

    /**
     * @ORM\Column(name="jugadores_confirmados", type="integer", nullable=true, options={"default" : 0})
     */
    private $jugadoresConfirmados = 0;

    /**
     * @ORM\Column(name="latitud", type="float", nullable=true, options={"default" : 0})
     */
    private $latitud = 0;

    /**
     * @ORM\Column(name="longitud", type="float", nullable=true, options={"default" : 0})
     */
    private $longitud = 0;

    /**
     * @ORM\Column(name="codigo_usuario_administrador_fk", type="integer")
     */
    private $codigoUsuarioAdministradorFk;

    /**
     * @ORM\Column(name="acceso", type="string",length=10, nullable=true)
     */
    private $acceso;

    /**
     * @ORM\Column(name="codigo_escenario_fk", type="integer")
     */
    private $codigoEscenarioFk;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="juegosUsuarioAdministradorRel")
     * @ORM\JoinColumn(name="codigo_usuario_administrador_fk", referencedColumnName="codigo_usuario_pk")
     */
    protected $usuarioAdministradorRel;

    /**
     * @ORM\ManyToOne(targetEntity="Escenario", inversedBy="juegosEscenarioRel")
     * @ORM\JoinColumn(name="codigo_escenario_fk", referencedColumnName="codigo_escenario_pk")
     */
    protected $escenarioRel;

    /**
     * @ORM\OneToMany(targetEntity="JuegoJugador", mappedBy="juegoRel")
     */
    protected $juegosJugadoresJuegoRel;

    /**
     * @ORM\OneToMany(targetEntity="JuegoInvitacion", mappedBy="juegoRel")
     */
    protected $juegosInvitacionesJuegoRel;

    /**
     * @ORM\OneToMany(targetEntity="JuegoDetalle", mappedBy="juegoRel")
     */
    protected $juegosDetallesJuegoRel;

}
