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
     * @ORM\OneToMany(targetEntity="JuegoJugador", mappedBy="juegoRel")
     */
    protected $juegosJugadoresJuegoRel;

    /**
     * @ORM\OneToMany(targetEntity="JuegoInvitacion", mappedBy="juegoRel")
     */
    protected $juegosInvitacionesJuegoRel;

}
