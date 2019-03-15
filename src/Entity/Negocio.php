<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NegocioRepository")
 */
class Negocio
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="codigo_negocio_pk",type="integer")
     */
    private $codigoNegocioPk;

    /**
     * @ORM\Column(name="nombre", type="string",length=255, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="Escenario", mappedBy="negocioRel")
     */
    protected $escenariosNegocioRel;

}
