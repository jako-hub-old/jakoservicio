<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JuegoDetalleRepository")
 */
class JuegoDetalle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="codigo_juego_detalle_pk",type="integer")
     */
    private $codigoJuegoDetallePk;

    /**
     * @ORM\Column(name="codigo_juego_fk", type="integer")
     */
    private $codigoJuegoFk;

    /**
     * @ORM\Column(name="codigo_jugador_fk", type="integer")
     */
    private $codigoJugadorFk;

    /**
     * @ORM\Column(name="numero", type="integer", nullable=true, options={"default" : null})
     */
    private $numero;

    /**
     * @ORM\Column(name="codigo_posicion_fk", type="string", length=10)
     */
    private $codigoPosicionFk;

    /**
     * @ORM\ManyToOne(targetEntity="Juego", inversedBy="juegosDetallesJuegoRel")
     * @ORM\JoinColumn(name="codigo_juego_fk", referencedColumnName="codigo_juego_pk")
     */
    protected $juegoRel;

    /**
     * @ORM\ManyToOne(targetEntity="Jugador", inversedBy="juegosDetallesJugadorRel")
     * @ORM\JoinColumn(name="codigo_jugador_fk", referencedColumnName="codigo_jugador_pk")
     */
    protected $jugadorRel;

    /**
     * @ORM\ManyToOne(targetEntity="Posicion", inversedBy="juegosDetallesPosicionRel")
     * @ORM\JoinColumn(name="codigo_posicion_fk", referencedColumnName="codigo_posicion_pk")
     */
    protected $posicionRel;

}
