<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JugadorSolicitudRepository")
 */
class JugadorSolicitud
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="codigo_jugador_solicitud_pk",type="integer")
     */
    private $codigoJugadorSolicitudPk;

    /**
     * @ORM\Column(name="codigo_jugador_fk", type="string", length=25)
     */
    private $codigoJugadorFk;

    /**
     * @ORM\Column(name="codigo_jugador_solicitud_fk", type="string", length=25)
     */
    private $codigoJugadorSolicitudFk;

    /**
     * @ORM\Column(name="estado_aceptada", type="boolean",options={"default" : false}, nullable=true)
     */
    private $estadoAceptada = false;

    /**
     * @ORM\Column(name="estado_rechazada", type="boolean",options={"default" : false}, nullable=true)
     */
    private $estadoRechazada = false;

    /**
     * @ORM\ManyToOne(targetEntity="Jugador", inversedBy="jugadoresSolicitudesJugadorRel")
     * @ORM\JoinColumn(name="codigo_jugador_fk", referencedColumnName="codigo_jugador_pk")
     */
    protected $jugadorRel;

    /**
     * @ORM\ManyToOne(targetEntity="Jugador", inversedBy="jugadoresSolicitudesJugadorSolicitudRel")
     * @ORM\JoinColumn(name="codigo_jugador_solicitud_fk", referencedColumnName="codigo_jugador_pk")
     */
    protected $jugadorSolicitudRel;

}

