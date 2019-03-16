<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PosicionRepository")
 */
class Posicion
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="codigo_posicion_pk", type="string", length=10)
     */
    private $codigoPosicionPk;

    /**
     * @ORM\Column(name="nombre", type="string",length=50, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="JuegoDetalle", mappedBy="posicionRel")
     */
    protected $juegosDetallesPosicionRel;

}
