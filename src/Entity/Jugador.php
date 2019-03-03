<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JugadorRepository")
 */
class Jugador
{
    /**
     * @ORM\Column(name="codigo_jugador_pk", type="string", length=25)
     * @ORM\Id()
     */
    private $codigoJugadorPk;

    /**
     * @ORM\Column(name="nombre", type="string",length=255, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="correo", type="string", length=120)
     */
    private $correo;

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



}

