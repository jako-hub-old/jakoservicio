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
     * @ORM\Column(name="nombre_corto", type="string",length=255, nullable=true)
     */
    private $nombreCorto;

    /**
     * @ORM\Column(name="correo", type="string", length=120, nullable=true)
     */
    private $correo;

    /**
     * @ORM\Column(name="seudonimo", type="string", length=30, nullable=true)
     */
    private $seudonimo;

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

    /**
     * @ORM\OneToMany(targetEntity="Comentario", mappedBy="jugadorRel")
     */
    protected $comentariosJugadorRel;

    /**
     * @ORM\OneToMany(targetEntity="Juego", mappedBy="jugadorRel")
     */
    protected $juegosJugadorRel;

    /**
     * @ORM\OneToMany(targetEntity="Reserva", mappedBy="jugadorRel")
     */
    protected $reservasJugadorRel;

    /**
     * @ORM\OneToMany(targetEntity="Publicacion", mappedBy="jugadorRel")
     */
    protected $publicacionesJugadorRel;

    /**
     * @ORM\OneToMany(targetEntity="Actividad", mappedBy="jugadorRel")
     */
    protected $actividadesJugadorRel;

    /**
     * @return mixed
     */
    public function getCodigoJugadorPk()
    {
        return $this->codigoJugadorPk;
    }

    /**
     * @param mixed $codigoJugadorPk
     */
    public function setCodigoJugadorPk($codigoJugadorPk): void
    {
        $this->codigoJugadorPk = $codigoJugadorPk;
    }

    /**
     * @return mixed
     */
    public function getIdentificacion()
    {
        return $this->identificacion;
    }

    /**
     * @param mixed $identificacion
     */
    public function setIdentificacion($identificacion): void
    {
        $this->identificacion = $identificacion;
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
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * @param mixed $apellido
     */
    public function setApellido($apellido): void
    {
        $this->apellido = $apellido;
    }

    /**
     * @return mixed
     */
    public function getNombreCorto()
    {
        return $this->nombreCorto;
    }

    /**
     * @param mixed $nombreCorto
     */
    public function setNombreCorto($nombreCorto): void
    {
        $this->nombreCorto = $nombreCorto;
    }

    /**
     * @return mixed
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * @param mixed $correo
     */
    public function setCorreo($correo): void
    {
        $this->correo = $correo;
    }

    /**
     * @return mixed
     */
    public function getSeudonimo()
    {
        return $this->seudonimo;
    }

    /**
     * @param mixed $seudonimo
     */
    public function setSeudonimo($seudonimo): void
    {
        $this->seudonimo = $seudonimo;
    }

    /**
     * @return mixed
     */
    public function getJuegosInvitacionesJugadorRel()
    {
        return $this->juegosInvitacionesJugadorRel;
    }

    /**
     * @param mixed $juegosInvitacionesJugadorRel
     */
    public function setJuegosInvitacionesJugadorRel($juegosInvitacionesJugadorRel): void
    {
        $this->juegosInvitacionesJugadorRel = $juegosInvitacionesJugadorRel;
    }

    /**
     * @return mixed
     */
    public function getJugadoresAmigosJugadorRel()
    {
        return $this->jugadoresAmigosJugadorRel;
    }

    /**
     * @param mixed $jugadoresAmigosJugadorRel
     */
    public function setJugadoresAmigosJugadorRel($jugadoresAmigosJugadorRel): void
    {
        $this->jugadoresAmigosJugadorRel = $jugadoresAmigosJugadorRel;
    }

    /**
     * @return mixed
     */
    public function getJugadoresAmigosJugadorAmigoRel()
    {
        return $this->jugadoresAmigosJugadorAmigoRel;
    }

    /**
     * @param mixed $jugadoresAmigosJugadorAmigoRel
     */
    public function setJugadoresAmigosJugadorAmigoRel($jugadoresAmigosJugadorAmigoRel): void
    {
        $this->jugadoresAmigosJugadorAmigoRel = $jugadoresAmigosJugadorAmigoRel;
    }

    /**
     * @return mixed
     */
    public function getJugadoresSolicitudesJugadorRel()
    {
        return $this->jugadoresSolicitudesJugadorRel;
    }

    /**
     * @param mixed $jugadoresSolicitudesJugadorRel
     */
    public function setJugadoresSolicitudesJugadorRel($jugadoresSolicitudesJugadorRel): void
    {
        $this->jugadoresSolicitudesJugadorRel = $jugadoresSolicitudesJugadorRel;
    }

    /**
     * @return mixed
     */
    public function getJugadoresSolicitudesJugadorSolicitudRel()
    {
        return $this->jugadoresSolicitudesJugadorSolicitudRel;
    }

    /**
     * @param mixed $jugadoresSolicitudesJugadorSolicitudRel
     */
    public function setJugadoresSolicitudesJugadorSolicitudRel($jugadoresSolicitudesJugadorSolicitudRel): void
    {
        $this->jugadoresSolicitudesJugadorSolicitudRel = $jugadoresSolicitudesJugadorSolicitudRel;
    }

    /**
     * @return mixed
     */
    public function getUsuariosJugadorRel()
    {
        return $this->usuariosJugadorRel;
    }

    /**
     * @param mixed $usuariosJugadorRel
     */
    public function setUsuariosJugadorRel($usuariosJugadorRel): void
    {
        $this->usuariosJugadorRel = $usuariosJugadorRel;
    }

    /**
     * @return mixed
     */
    public function getJuegosDetallesJugadorRel()
    {
        return $this->juegosDetallesJugadorRel;
    }

    /**
     * @param mixed $juegosDetallesJugadorRel
     */
    public function setJuegosDetallesJugadorRel($juegosDetallesJugadorRel): void
    {
        $this->juegosDetallesJugadorRel = $juegosDetallesJugadorRel;
    }

    /**
     * @return mixed
     */
    public function getComentariosJugadorRel()
    {
        return $this->comentariosJugadorRel;
    }

    /**
     * @param mixed $comentariosJugadorRel
     */
    public function setComentariosJugadorRel($comentariosJugadorRel): void
    {
        $this->comentariosJugadorRel = $comentariosJugadorRel;
    }

    /**
     * @return mixed
     */
    public function getJuegosJugadorRel()
    {
        return $this->juegosJugadorRel;
    }

    /**
     * @param mixed $juegosJugadorRel
     */
    public function setJuegosJugadorRel($juegosJugadorRel): void
    {
        $this->juegosJugadorRel = $juegosJugadorRel;
    }

    /**
     * @return mixed
     */
    public function getReservasJugadorRel()
    {
        return $this->reservasJugadorRel;
    }

    /**
     * @param mixed $reservasJugadorRel
     */
    public function setReservasJugadorRel($reservasJugadorRel): void
    {
        $this->reservasJugadorRel = $reservasJugadorRel;
    }

    /**
     * @return mixed
     */
    public function getPublicacionesJugadorRel()
    {
        return $this->publicacionesJugadorRel;
    }

    /**
     * @param mixed $publicacionesJugadorRel
     */
    public function setPublicacionesJugadorRel($publicacionesJugadorRel): void
    {
        $this->publicacionesJugadorRel = $publicacionesJugadorRel;
    }

    /**
     * @return mixed
     */
    public function getActividadesJugadorRel()
    {
        return $this->actividadesJugadorRel;
    }

    /**
     * @param mixed $actividadesJugadorRel
     */
    public function setActividadesJugadorRel($actividadesJugadorRel): void
    {
        $this->actividadesJugadorRel = $actividadesJugadorRel;
    }




}

