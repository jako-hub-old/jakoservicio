<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsuarioRepository")
 */
class Usuario
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="codigo_usuario_pk", type="integer")
     */
    private $codigoUsuarioPk;

    /**
     * @ORM\Column(name="codigo_jugador_fk", type="integer")
     */
    private $codigoJugadorFk;

    /**
     * @ORM\Column(name="usuario", type="string", length=30)
     */
    private $usuario;

    /**
     * @ORM\Column(name="estado_verificado", type="boolean",options={"default" : false}, nullable=true)
     */
    private $estadoVerificado = false;

    /**
     * @ORM\Column(name="imei", type="string", length=30, nullable=true)
     */
    private $imei;

    /**
     * @ORM\Column(name="codigo_verificacion", type="string", length=10, nullable=true)
     */
    private $codigoVerificacion;

    /**
     * @ORM\Column(name="crear_juego", type="boolean", options={"default" : false}, nullable=true)
     */
    private $crearJuego = false;

    /**
     * @ORM\Column(name="puntos", type="float", nullable=true, options={"default" : 0})
     */
    private $puntos = 0;

    /**
     * @ORM\Column(name="fcm_token", type="string", nullable=true)
     */
    private $fcmToken;

    /**
     * @ORM\Column(name="fecha_registro", type="datetime", nullable=true)
     */
    private $fechaRegistro;

    /**
     * @ORM\ManyToOne(targetEntity="Jugador", inversedBy="usuariosJugadorRel")
     * @ORM\JoinColumn(name="codigo_jugador_fk", referencedColumnName="codigo_jugador_pk")
     */
    protected $jugadorRel;

    /**
     * @ORM\OneToMany(targetEntity="Transaccion", mappedBy="usuarioRel")
     */
    protected $transaccionesUsuarioRel;

    /**
     * @return mixed
     */
    public function getCodigoUsuarioPk()
    {
        return $this->codigoUsuarioPk;
    }

    /**
     * @param mixed $codigoUsuarioPk
     */
    public function setCodigoUsuarioPk($codigoUsuarioPk): void
    {
        $this->codigoUsuarioPk = $codigoUsuarioPk;
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
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario): void
    {
        $this->usuario = $usuario;
    }

    /**
     * @return mixed
     */
    public function getEstadoVerificado()
    {
        return $this->estadoVerificado;
    }

    /**
     * @param mixed $estadoVerificado
     */
    public function setEstadoVerificado($estadoVerificado): void
    {
        $this->estadoVerificado = $estadoVerificado;
    }

    /**
     * @return mixed
     */
    public function getImei()
    {
        return $this->imei;
    }

    /**
     * @param mixed $imei
     */
    public function setImei($imei): void
    {
        $this->imei = $imei;
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
    public function getCodigoVerificacion()
    {
        return $this->codigoVerificacion;
    }

    /**
     * @param mixed $codigoVerificacion
     */
    public function setCodigoVerificacion($codigoVerificacion): void
    {
        $this->codigoVerificacion = $codigoVerificacion;
    }

    /**
     * @return mixed
     */
    public function getCrearJuego()
    {
        return $this->crearJuego;
    }

    /**
     * @param mixed $crearJuego
     */
    public function setCrearJuego($crearJuego): void
    {
        $this->crearJuego = $crearJuego;
    }

    /**
     * @return mixed
     */
    public function getPuntos()
    {
        return $this->puntos;
    }

    /**
     * @param mixed $puntos
     */
    public function setPuntos($puntos): void
    {
        $this->puntos = $puntos;
    }

    /**
     * @return mixed
     */
    public function getTransaccionesUsuarioRel()
    {
        return $this->transaccionesUsuarioRel;
    }

    /**
     * @param mixed $transaccionesUsuarioRel
     */
    public function setTransaccionesUsuarioRel($transaccionesUsuarioRel): void
    {
        $this->transaccionesUsuarioRel = $transaccionesUsuarioRel;
    }

    /**
     * @return mixed
     */
    public function getFcmToken()
    {
        return $this->fcmToken;
    }

    /**
     * @param mixed $fcmToken
     */
    public function setFcmToken($fcmToken): void
    {
        $this->fcmToken = $fcmToken;
    }

    /**
     * @return mixed
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * @param mixed $fechaRegistro
     */
    public function setFechaRegistro($fechaRegistro): void
    {
        $this->fechaRegistro = $fechaRegistro;
    }
}

