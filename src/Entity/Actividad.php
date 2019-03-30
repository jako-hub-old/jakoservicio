<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActividadRepository")
 */
class Actividad
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="codigo_actividad_pk",type="integer")
     */
    private $codigoActividadPk;

    /**
     * @ORM\Column(name="texto", type="string",length=500, nullable=true)
     */
    private $texto;

    /**
     * @ORM\Column(name="codigo_jugador_fk", type="integer", nullable=true)
     */
    private $codigoJugadorFk;

    /**
     * @ORM\ManyToOne(targetEntity="Jugador", inversedBy="actividadesJugadorRel")
     * @ORM\JoinColumn(name="codigo_jugador_fk", referencedColumnName="codigo_jugador_pk")
     */
    protected $jugadorRel;

    /**
     * @return mixed
     */
    public function getCodigoActividadPk()
    {
        return $this->codigoActividadPk;
    }

    /**
     * @param mixed $codigoActividadPk
     */
    public function setCodigoActividadPk($codigoActividadPk): void
    {
        $this->codigoActividadPk = $codigoActividadPk;
    }

    /**
     * @return mixed
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * @param mixed $texto
     */
    public function setTexto($texto): void
    {
        $this->texto = $texto;
    }

    /**
     * @return mixed
     */
    public function getCodigoJugadorFk()
    {
        return $this->codigoJugadorFk;
    }

    /**
     * @param mixed $codigoJugadorFk
     */
    public function setCodigoJugadorFk($codigoJugadorFk): void
    {
        $this->codigoJugadorFk = $codigoJugadorFk;
    }

    /**
     * @return mixed
     */
    public function getJugadorRel()
    {
        return $this->jugadorRel;
    }

    /**
     * @param mixed $jugadorRel
     */
    public function setJugadorRel($jugadorRel): void
    {
        $this->jugadorRel = $jugadorRel;
    }



}
