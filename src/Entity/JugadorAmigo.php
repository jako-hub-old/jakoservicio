<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JugadorAmigoRepository")
 */
class JugadorAmigo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="codigo_jugador_amigo_pk",type="integer")
     */
    private $codigoJugadorAmigoPk;

    /**
     * @ORM\Column(name="codigo_jugador_fk", type="integer")
     */
    private $codigoJugadorFk;

    /**
     * @ORM\Column(name="codigo_jugador_amigo_fk", type="integer")
     */
    private $codigoJugadorAmigoFk;

    /**
     * @ORM\ManyToOne(targetEntity="Jugador", inversedBy="jugadoresAmigosJugadorRel")
     * @ORM\JoinColumn(name="codigo_jugador_fk", referencedColumnName="codigo_jugador_pk")
     */
    protected $jugadorRel;

    /**
     * @ORM\ManyToOne(targetEntity="Jugador", inversedBy="jugadoresAmigosJugadorAmigoRel")
     * @ORM\JoinColumn(name="codigo_jugador_amigo_fk", referencedColumnName="codigo_jugador_pk")
     */
    protected $jugadorAmigoRel;

    /**
     * @return mixed
     */
    public function getCodigoJugadorAmigoPk()
    {
        return $this->codigoJugadorAmigoPk;
    }

    /**
     * @param mixed $codigoJugadorAmigoPk
     */
    public function setCodigoJugadorAmigoPk($codigoJugadorAmigoPk): void
    {
        $this->codigoJugadorAmigoPk = $codigoJugadorAmigoPk;
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
    public function getCodigoJugadorAmigoFk()
    {
        return $this->codigoJugadorAmigoFk;
    }

    /**
     * @param mixed $codigoJugadorAmigoFk
     */
    public function setCodigoJugadorAmigoFk($codigoJugadorAmigoFk): void
    {
        $this->codigoJugadorAmigoFk = $codigoJugadorAmigoFk;
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

    /**
     * @return mixed
     */
    public function getJugadorAmigoRel()
    {
        return $this->jugadorAmigoRel;
    }

    /**
     * @param mixed $jugadorAmigoRel
     */
    public function setJugadorAmigoRel($jugadorAmigoRel): void
    {
        $this->jugadorAmigoRel = $jugadorAmigoRel;
    }


}

