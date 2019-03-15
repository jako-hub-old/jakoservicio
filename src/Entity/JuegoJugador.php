<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JuegoJugadorRepository")
 */
class JuegoJugador
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="codigo_juego_jugador_pk",type="integer")
     */
    private $codigoJuegoJugadorPk;

    /**
     * @ORM\Column(name="codigo_juego_fk" , type="integer")
     */
    private $codigoJuegoFk;

    /**
     * @ORM\Column(name="codigo_jugador_fk", type="integer")
     */
    private $codigoJugadorFk;

    /**
     * @ORM\ManyToOne(targetEntity="Juego", inversedBy="juegosJugadoresJuegoRel")
     * @ORM\JoinColumn(name="codigo_juego_fk", referencedColumnName="codigo_juego_pk")
     */
    protected $juegoRel;

    /**
     * @ORM\ManyToOne(targetEntity="Jugador", inversedBy="juegosJugadoresJugadorRel")
     * @ORM\JoinColumn(name="codigo_jugador_fk", referencedColumnName="codigo_jugador_pk")
     */
    protected $jugadorRel;

}
