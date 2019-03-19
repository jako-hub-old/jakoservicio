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
     * @ORM\Column(name="clave", type="string", length=30)
     */
    private $clave;

    /**
     * @ORM\ManyToOne(targetEntity="Jugador", inversedBy="usuariosJugadorRel")
     * @ORM\JoinColumn(name="codigo_jugador_fk", referencedColumnName="codigo_jugador_pk")
     */
    protected $jugadorRel;

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



}

