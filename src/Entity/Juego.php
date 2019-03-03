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


}
