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
     * @ORM\Column(name="fecha_desde" , type="datetime")
     */
    private $fechaDesde;

    /**
     * @ORM\Column(name="fecha_hasta" , type="datetime")
     */
    private $fechaHasta;

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
     * @ORM\Column(name="codigo_jugador_fk", type="integer")
     */
    private $codigoJugadorFk;

    /**
     * @ORM\Column(name="codigo_tipo_juego_fk", type="integer", nullable=true)
     */
    private $codigoTipoJuegoFk;

    /**
     * @ORM\Column(name="acceso", type="string",length=10, nullable=true)
     */
    private $acceso;

    /**
     * @ORM\Column(name="codigo_escenario_fk", type="integer")
     */
    private $codigoEscenarioFk;

    /**
     * @ORM\Column(name="vr_costo", type="float", nullable=true, options={"default" : 0})
     */
    private $vrCosto = 0;

    /**
     * @ORM\Column(name="estado_cerrado", type="boolean",options={"default" : false}, nullable=true)
     */
    private $estadoCerrado = false;

    /**
     * @ORM\ManyToOne(targetEntity="Jugador", inversedBy="juegosJugadorRel")
     * @ORM\JoinColumn(name="codigo_jugador_fk", referencedColumnName="codigo_jugador_pk")
     */
    protected $jugadorRel;

    /**
     * @ORM\ManyToOne(targetEntity="JuegoTipo", inversedBy="tipoJuegoJuegoRel")
     * @ORM\JoinColumn(name="codigo_tipo_juego_fk", referencedColumnName="codigo_juego_tipo_pk")
     */
    protected $tipoJuegoRel;

    /**
     * @ORM\ManyToOne(targetEntity="Escenario", inversedBy="juegosEscenarioRel")
     * @ORM\JoinColumn(name="codigo_escenario_fk", referencedColumnName="codigo_escenario_pk")
     */
    protected $escenarioRel;

    /**
     * @ORM\OneToMany(targetEntity="JuegoInvitacion", mappedBy="juegoRel")
     */
    protected $juegosInvitacionesJuegoRel;

    /**
     * @ORM\OneToMany(targetEntity="JuegoDetalle", mappedBy="juegoRel")
     */
    protected $juegosDetallesJuegoRel;

    /**
     * @ORM\OneToMany(targetEntity="JuegoEquipo", mappedBy="juegoRel")
     */
    protected $juegosEquiposJuegoRel;

    /**
     * @ORM\OneToMany(targetEntity="Comentario", mappedBy="juegoRel")
     */
    protected $comentariosJuegoRel;

    /**
     * @ORM\OneToMany(targetEntity="Publicacion", mappedBy="juegoRel")
     */
    protected $publicacionesJuegoRel;

    /**
     * @return mixed
     */
    public function getCodigoJuegoPk()
    {
        return $this->codigoJuegoPk;
    }

    /**
     * @param mixed $codigoJuegoPk
     */
    public function setCodigoJuegoPk($codigoJuegoPk): void
    {
        $this->codigoJuegoPk = $codigoJuegoPk;
    }

    /**
     * @return \DateTime
     */
    public function getFechaDesde()
    {
        return $this->fechaDesde;
    }

    /**
     * @param mixed $fechaDesde
     */
    public function setFechaDesde($fechaDesde): void
    {
        $this->fechaDesde = $fechaDesde;
    }

    /**
     * @return mixed
     */
    public function getFechaHasta()
    {
        return $this->fechaHasta;
    }

    /**
     * @param mixed $fechaHasta
     */
    public function setFechaHasta($fechaHasta): void
    {
        $this->fechaHasta = $fechaHasta;
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
    public function getJugadores()
    {
        return $this->jugadores;
    }

    /**
     * @param mixed $jugadores
     */
    public function setJugadores($jugadores): void
    {
        $this->jugadores = $jugadores;
    }

    /**
     * @return mixed
     */
    public function getJugadoresConfirmados()
    {
        return $this->jugadoresConfirmados;
    }

    /**
     * @param mixed $jugadoresConfirmados
     */
    public function setJugadoresConfirmados($jugadoresConfirmados): void
    {
        $this->jugadoresConfirmados = $jugadoresConfirmados;
    }

    /**
     * @return mixed
     */
    public function getLatitud()
    {
        return $this->latitud;
    }

    /**
     * @param mixed $latitud
     */
    public function setLatitud($latitud): void
    {
        $this->latitud = $latitud;
    }

    /**
     * @return mixed
     */
    public function getLongitud()
    {
        return $this->longitud;
    }

    /**
     * @param mixed $longitud
     */
    public function setLongitud($longitud): void
    {
        $this->longitud = $longitud;
    }

    /**
     * @return mixed
     */
    public function getCodigoJugadorFk()
    {
        return $this->codigoJugadorFk;
    }

    /**
     * @param mixed $codigoJugadorFk
     */
    public function setCodigoJugadorFk($codigoJugadorFk): void
    {
        $this->codigoJugadorFk = $codigoJugadorFk;
    }

    /**
     * @return mixed
     */
    public function getAcceso()
    {
        return $this->acceso;
    }

    /**
     * @param mixed $acceso
     */
    public function setAcceso($acceso): void
    {
        $this->acceso = $acceso;
    }

    /**
     * @return mixed
     */
    public function getCodigoEscenarioFk()
    {
        return $this->codigoEscenarioFk;
    }

    /**
     * @param mixed $codigoEscenarioFk
     */
    public function setCodigoEscenarioFk($codigoEscenarioFk): void
    {
        $this->codigoEscenarioFk = $codigoEscenarioFk;
    }

    /**
     * @return mixed
     */
    public function getVrCosto()
    {
        return $this->vrCosto;
    }

    /**
     * @param mixed $vrCosto
     */
    public function setVrCosto($vrCosto): void
    {
        $this->vrCosto = $vrCosto;
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
    public function getEscenarioRel()
    {
        return $this->escenarioRel;
    }

    /**
     * @param mixed $escenarioRel
     */
    public function setEscenarioRel($escenarioRel): void
    {
        $this->escenarioRel = $escenarioRel;
    }

    /**
     * @return mixed
     */
    public function getJuegosInvitacionesJuegoRel()
    {
        return $this->juegosInvitacionesJuegoRel;
    }

    /**
     * @param mixed $juegosInvitacionesJuegoRel
     */
    public function setJuegosInvitacionesJuegoRel($juegosInvitacionesJuegoRel): void
    {
        $this->juegosInvitacionesJuegoRel = $juegosInvitacionesJuegoRel;
    }

    /**
     * @return JuegoDetalle[]
     */
    public function getJuegosDetallesJuegoRel()
    {
        return $this->juegosDetallesJuegoRel;
    }

    /**
     * @param mixed $juegosDetallesJuegoRel
     */
    public function setJuegosDetallesJuegoRel($juegosDetallesJuegoRel): void
    {
        $this->juegosDetallesJuegoRel = $juegosDetallesJuegoRel;
    }

    /**
     * @return mixed
     */
    public function getJuegosEquiposJuegoRel()
    {
        return $this->juegosEquiposJuegoRel;
    }

    /**
     * @param mixed $juegosEquiposJuegoRel
     */
    public function setJuegosEquiposJuegoRel($juegosEquiposJuegoRel): void
    {
        $this->juegosEquiposJuegoRel = $juegosEquiposJuegoRel;
    }

    /**
     * @return mixed
     */
    public function getComentariosJuegoRel()
    {
        return $this->comentariosJuegoRel;
    }

    /**
     * @param mixed $comentariosJuegoRel
     */
    public function setComentariosJuegoRel($comentariosJuegoRel): void
    {
        $this->comentariosJuegoRel = $comentariosJuegoRel;
    }

    /**
     * @return mixed
     */
    public function getPublicacionesJuegoRel()
    {
        return $this->publicacionesJuegoRel;
    }

    /**
     * @param mixed $publicacionesJuegoRel
     */
    public function setPublicacionesJuegoRel($publicacionesJuegoRel): void
    {
        $this->publicacionesJuegoRel = $publicacionesJuegoRel;
    }

    /**
     * @return mixed
     */
    public function getEstadoCerrado()
    {
        return $this->estadoCerrado;
    }

    /**
     * @param mixed $estadoCerrado
     */
    public function setEstadoCerrado($estadoCerrado): void
    {
        $this->estadoCerrado = $estadoCerrado;
    }

    /**
     * @return mixed
     */
    public function getCodigoTipoJuegoFk()
    {
        return $this->codigoTipoJuegoFk;
    }

    /**
     * @param mixed $codigoTipoJuegoFk
     */
    public function setCodigoTipoJuegoFk($codigoTipoJuegoFk): void
    {
        $this->codigoTipoJuegoFk = $codigoTipoJuegoFk;
    }

    /**
     * @return mixed
     */
    public function getTipoJuegoRel()
    {
        return $this->tipoJuegoRel;
    }

    /**
     * @param JuegoTipo $tipoJuegoRel
     */
    public function setTipoJuegoRel($tipoJuegoRel): void
    {
        $this->tipoJuegoRel = $tipoJuegoRel;
    }
}
