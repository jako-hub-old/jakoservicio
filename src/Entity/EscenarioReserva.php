<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EscenarioReservaRepository")
 */
class EscenarioReserva
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="codigo_escenario_reserva_pk",type="integer")
     */
    private $codigoEscenarioReservaPk;

    /**
     * @ORM\Column(name="codigo_escenario_fk" , type="integer")
     */
    private $codigoEscenarioFk;

    /**
     * @ORM\ManyToOne(targetEntity="Escenario", inversedBy="escenariosReservasEscenarioRel")
     * @ORM\JoinColumn(name="codigo_escenario_fk", referencedColumnName="codigo_escenario_pk")
     */
    protected $escenarioRel;

}
