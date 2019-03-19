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

    /**
     * @return mixed
     */
    public function getCodigoNegocioPk()
    {
        return $this->codigoNegocioPk;
    }

    /**
     * @param mixed $codigoNegocioPk
     */
    public function setCodigoNegocioPk($codigoNegocioPk): void
    {
        $this->codigoNegocioPk = $codigoNegocioPk;
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
    public function getEscenariosNegocioRel()
    {
        return $this->escenariosNegocioRel;
    }

    /**
     * @param mixed $escenariosNegocioRel
     */
    public function setEscenariosNegocioRel($escenariosNegocioRel): void
    {
        $this->escenariosNegocioRel = $escenariosNegocioRel;
    }



}
