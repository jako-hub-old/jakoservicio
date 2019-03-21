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
     * @ORM\Column(name="latitud", type="float", nullable=true, options={"default" : 0})
     */
    private $latitud = 0;

    /**
     * @ORM\Column(name="longitud", type="float", nullable=true, options={"default" : 0})
     */
    private $longitud = 0;

    /**
     * @ORM\ManyToOne(targetEntity="Negocio", inversedBy="escenariosNegocioRel")
     * @ORM\JoinColumn(name="codigo_negocio_fk", referencedColumnName="codigo_negocio_pk")
     */
    protected $negocioRel;

    /**
     * @ORM\OneToMany(targetEntity="EscenarioReserva", mappedBy="escenarioRel")
     */
    protected $escenariosReservasEscenarioRel;

    /**
     * @ORM\OneToMany(targetEntity="Juego", mappedBy="escenarioRel")
     */
    protected $juegosEscenarioRel;

    /**
     * @ORM\OneToMany(targetEntity="Reserva", mappedBy="escenarioRel")
     */
    protected $reservasEscenarioRel;

    /**
     * @return mixed
     */
    public function getCodigoEscenarioPk()
    {
        return $this->codigoEscenarioPk;
    }

    /**
     * @param mixed $codigoEscenarioPk
     */
    public function setCodigoEscenarioPk($codigoEscenarioPk): void
    {
        $this->codigoEscenarioPk = $codigoEscenarioPk;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getCodigoNegocioFk()
    {
        return $this->codigoNegocioFk;
    }

    /**
     * @param mixed $codigoNegocioFk
     */
    public function setCodigoNegocioFk($codigoNegocioFk): void
    {
        $this->codigoNegocioFk = $codigoNegocioFk;
    }

    /**
     * @return mixed
     */
    public function getLatitud()
    {
        return $this->latitud;
    }

    /**
     * @param mixed $latitud
     */
    public function setLatitud($latitud): void
    {
        $this->latitud = $latitud;
    }

    /**
     * @return mixed
     */
    public function getLongitud()
    {
        return $this->longitud;
    }

    /**
     * @param mixed $longitud
     */
    public function setLongitud($longitud): void
    {
        $this->longitud = $longitud;
    }

    /**
     * @return mixed
     */
    public function getNegocioRel()
    {
        return $this->negocioRel;
    }

    /**
     * @param mixed $negocioRel
     */
    public function setNegocioRel($negocioRel): void
    {
        $this->negocioRel = $negocioRel;
    }

    /**
     * @return mixed
     */
    public function getEscenariosReservasEscenarioRel()
    {
        return $this->escenariosReservasEscenarioRel;
    }

    /**
     * @param mixed $escenariosReservasEscenarioRel
     */
    public function setEscenariosReservasEscenarioRel($escenariosReservasEscenarioRel): void
    {
        $this->escenariosReservasEscenarioRel = $escenariosReservasEscenarioRel;
    }

    /**
     * @return mixed
     */
    public function getJuegosEscenarioRel()
    {
        return $this->juegosEscenarioRel;
    }

    /**
     * @param mixed $juegosEscenarioRel
     */
    public function setJuegosEscenarioRel($juegosEscenarioRel): void
    {
        $this->juegosEscenarioRel = $juegosEscenarioRel;
    }

    /**
     * @return mixed
     */
    public function getReservasEscenarioRel()
    {
        return $this->reservasEscenarioRel;
    }

    /**
     * @param mixed $reservasEscenarioRel
     */
    public function setReservasEscenarioRel($reservasEscenarioRel): void
    {
        $this->reservasEscenarioRel = $reservasEscenarioRel;
    }



}
