<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NegocioTipoRepository")
 */
class NegocioTipo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="codigo_negocio_tipo_pk",type="integer")
     */
    private $codigoNegocioTipoPk;

    /**
     * @ORM\Column(name="nombre", type="string",length=255, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="Negocio", mappedBy="negocioTipoRel")
     */
    protected $negociosNegocioTipoRel;

    /**
     * @return mixed
     */
    public function getCodigoNegocioTipoPk()
    {
        return $this->codigoNegocioTipoPk;
    }

    /**
     * @param mixed $codigoNegocioTipoPk
     */
    public function setCodigoNegocioTipoPk($codigoNegocioTipoPk): void
    {
        $this->codigoNegocioTipoPk = $codigoNegocioTipoPk;
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
    public function getNegociosNegocioTipoRel()
    {
        return $this->negociosNegocioTipoRel;
    }

    /**
     * @param mixed $negociosNegocioTipoRel
     */
    public function setNegociosNegocioTipoRel($negociosNegocioTipoRel): void
    {
        $this->negociosNegocioTipoRel = $negociosNegocioTipoRel;
    }



}
