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
     * @ORM\GeneratedValue()
     * @ORM\Column(name="codigo_usuario_pk",type="integer")
     */
    private $codigoUsuarioPk;

    /**
     * @ORM\Column(name="usuario", type="string", length=30)
     */
    private $usuario;

    /**
     * @ORM\Column(name="clave", type="string", length=30)
     */
    private $clave;

    /**
     * @ORM\Column(name="seudonimo", type="string", length=30)
     */
    private $seudonimo;

    /**
     * @ORM\Column(name="codigo_jugador_fk", type="integer")
     */
    private $codigoJugadorFk;

    /**
     * @ORM\ManyToOne(targetEntity="Jugador", inversedBy="usuariosJugadorRel")
     * @ORM\JoinColumn(name="codigo_jugador_fk", referencedColumnName="codigo_jugador_pk")
     */
    protected $jugadorRel;

    /**
     * @ORM\OneToMany(targetEntity="Juego", mappedBy="usuarioAdministradorRel")
     */
    protected $juegosUsuarioAdministradorRel;

    /**
     * @ORM\OneToMany(targetEntity="Comentario", mappedBy="usuarioRel")
     */
    protected $comentariosUsuarioRel;

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
    public function getJuegosUsuarioAdministradorRel()
    {
        return $this->juegosUsuarioAdministradorRel;
    }

    /**
     * @param mixed $juegosUsuarioAdministradorRel
     */
    public function setJuegosUsuarioAdministradorRel($juegosUsuarioAdministradorRel): void
    {
        $this->juegosUsuarioAdministradorRel = $juegosUsuarioAdministradorRel;
    }

    /**
     * @return mixed
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * @param mixed $clave
     */
    public function setClave($clave): void
    {
        $this->clave = $clave;
    }

    /**
     * @return mixed
     */
    public function getComentariosUsuarioRel()
    {
        return $this->comentariosUsuarioRel;
    }

    /**
     * @param mixed $comentariosUsuarioRel
     */
    public function setComentariosUsuarioRel($comentariosUsuarioRel): void
    {
        $this->comentariosUsuarioRel = $comentariosUsuarioRel;
    }



}

