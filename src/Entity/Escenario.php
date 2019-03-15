<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EscenarioRepository")
 */
class Escenario
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="codigo_escenario_pk",type="integer")
     */
    private $codigoEscenarioPk;

    /**
     * @ORM\Column(name="nombre", type="string",length=255, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="codigo_negocio_fk" , type="integer")
     */
    private $codigoNegocioFk;

    /**
     * @ORM\ManyToOne(targetEntity="Negocio", inversedBy="escenariosNegocioRel")
     * @ORM\JoinColumn(name="codigo_negocio_fk", referencedColumnName="codigo_negocio_pk")
     */
    protected $negocioRel;

    /**
     * @ORM\OneToMany(targetEntity="EscenarioReserva", mappedBy="escenarioRel")
     */
    protected $escenariosReservasEscenarioRel;

}
