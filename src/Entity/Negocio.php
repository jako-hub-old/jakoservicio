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
     * @ORM\Column(name="direccion", type="string",length=255, nullable=true)
     */
    private $direccion;

    /**
     * @ORM\Column(name="telefono", type="string",length=255, nullable=true)
     */
    private $telefono;

    /**
     * @ORM\Column(name="puntuacion", type="float", nullable=true)
     */
    private $puntuacion;

    /**
     * @ORM\Column(name="latitud", type="float", nullable=true, options={"default" : 0})
     */
    private $latitud = 0;

    /**
     * @ORM\Column(name="longitud", type="float", nullable=true, options={"default" : 0})
     */
    private $longitud = 0;

    /**
     * @ORM\Column(name="codigo_ciudad_fk", type="integer", nullable=true)
     */
    private $codigoCiudadFk;

    /**
     * @ORM\Column(name="codigo_negocio_tipo_fk", type="integer", nullable=true)
     */
    private $codigoNegocioTipoFk;

    /**
     * @ORM\ManyToOne(targetEntity="Ciudad", inversedBy="negociosCiudadRel")
     * @ORM\JoinColumn(name="codigo_ciudad_fk", referencedColumnName="codigo_ciudad_pk")
     */
    protected $ciudadRel;

    /**
     * @ORM\ManyToOne(targetEntity="NegocioTipo", inversedBy="negociosNegocioTipoRel")
     * @ORM\JoinColumn(name="codigo_negocio_tipo_fk", referencedColumnName="codigo_negocio_tipo_pk")
     */
    protected $negocioTipoRel;

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
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed $direccion
     */
    public function setDireccion($direccion): void
    {
        $this->direccion = $direccion;
    }

    /**
     * @return mixed
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param mixed $telefono
     */
    public function setTelefono($telefono): void
    {
        $this->telefono = $telefono;
    }

    /**
     * @return mixed
     */
    public function getPuntuacion()
    {
        return $this->puntuacion;
    }

    /**
     * @param mixed $puntuacion
     */
    public function setPuntuacion($puntuacion): void
    {
        $this->puntuacion = $puntuacion;
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
    public function getCodigoCiudadFk()
    {
        return $this->codigoCiudadFk;
    }

    /**
     * @param mixed $codigoCiudadFk
     */
    public function setCodigoCiudadFk($codigoCiudadFk): void
    {
        $this->codigoCiudadFk = $codigoCiudadFk;
    }

    /**
     * @return mixed
     */
    public function getCodigoNegocioTipoFk()
    {
        return $this->codigoNegocioTipoFk;
    }

    /**
     * @param mixed $codigoNegocioTipoFk
     */
    public function setCodigoNegocioTipoFk($codigoNegocioTipoFk): void
    {
        $this->codigoNegocioTipoFk = $codigoNegocioTipoFk;
    }

    /**
     * @return mixed
     */
    public function getCiudadRel()
    {
        return $this->ciudadRel;
    }

    /**
     * @param mixed $ciudadRel
     */
    public function setCiudadRel($ciudadRel): void
    {
        $this->ciudadRel = $ciudadRel;
    }

    /**
     * @return mixed
     */
    public function getNegocioTipoRel()
    {
        return $this->negocioTipoRel;
    }

    /**
     * @param mixed $negocioTipoRel
     */
    public function setNegocioTipoRel($negocioTipoRel): void
    {
        $this->negocioTipoRel = $negocioTipoRel;
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
