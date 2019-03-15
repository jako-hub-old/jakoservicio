<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JuegoInvitacionRepository")
 */
class JuegoInvitacion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="codigo_juego_invitacion_pk",type="integer")
     */
    private $codigoJuegoInvitacionPk;

    /**
     * @ORM\Column(name="codigo_juego_fk" , type="integer")
     */
    private $codigoJuegoFk;

    /**
     * @ORM\Column(name="codigo_jugador_fk", type="integer")
     */
    private $codigoJugadorFk;

    /**
     * @ORM\Column(name="estado_aceptada", type="boolean",options={"default" : false}, nullable=true)
     */
    private $estadoAceptada = false;

    /**
     * @ORM\Column(name="estado_rechazada", type="boolean",options={"default" : false}, nullable=true)
     */
    private $estadoRechazada = false;

    /**
     * @ORM\ManyToOne(targetEntity="Juego", inversedBy="juegosInvitacionesJuegoRel")
     * @ORM\JoinColumn(name="codigo_juego_fk", referencedColumnName="codigo_juego_pk")
     */
    protected $juegoRel;

    /**
     * @ORM\ManyToOne(targetEntity="Jugador", inversedBy="juegosInvitacionesJugadorRel")
     * @ORM\JoinColumn(name="codigo_jugador_fk", referencedColumnName="codigo_jugador_pk")
     */
    protected $jugadorRel;

}
