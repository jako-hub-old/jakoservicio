<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JugadorAmigoRepository")
 */
class JugadorAmigo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="codigo_jugador_amigo_pk",type="integer")
     */
    private $codigoJugadorAmigoPk;

    /**
     * @ORM\Column(name="codigo_jugador_fk", type="integer")
     */
    private $codigoJugadorFk;

    /**
     * @ORM\Column(name="codigo_jugador_amigo_fk", type="integer")
     */
    private $codigoJugadorAmigoFk;

    /**
     * @ORM\ManyToOne(targetEntity="Jugador", inversedBy="jugadoresAmigosJugadorRel")
     * @ORM\JoinColumn(name="codigo_jugador_fk", referencedColumnName="codigo_jugador_pk")
     */
    protected $jugadorRel;

    /**
     * @ORM\ManyToOne(targetEntity="Jugador", inversedBy="jugadoresAmigosJugadorAmigoRel")
     * @ORM\JoinColumn(name="codigo_jugador_amigo_fk", referencedColumnName="codigo_jugador_pk")
     */
    protected $jugadorAmigoRel;

}

