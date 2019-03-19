<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ComentarioRepository")
 */
class Comentario
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="codigo_comentario_pk",type="integer")
     */
    private $codigoComentarioPk;

    /**
     * @ORM\Column(name="fecha" , type="datetime")
     */
    private $fecha;

    /**
     * @ORM\Column(name="comentario", type="string", length=500, nullable=true)
     */
    private $comentario;

    /**
     * @ORM\Column(name="codigo_juego_fk", type="integer")
     */
    private $codigoJuegoFk;

    /**
     * @ORM\Column(name="codigo_jugador_fk", type="integer")
     */
    private $codigoJugadorFk;

    /**
     * @ORM\ManyToOne(targetEntity="Jugador", inversedBy="comentariosJugadorRel")
     * @ORM\JoinColumn(name="codigo_jugador_fk", referencedColumnName="codigo_jugador_pk")
     */
    protected $jugadorRel;

    /**
     * @ORM\ManyToOne(targetEntity="Juego", inversedBy="comentariosJuegoRel")
     * @ORM\JoinColumn(name="codigo_juego_fk", referencedColumnName="codigo_juego_pk")
     */
    protected $juegoRel;

    /**
     * @return mixed
     */
    public function getCodigoComentarioPk()
    {
        return $this->codigoComentarioPk;
    }

    /**
     * @param mixed $codigoComentarioPk
     */
    public function setCodigoComentarioPk($codigoComentarioPk): void
    {
        $this->codigoComentarioPk = $codigoComentarioPk;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha): void
    {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * @param mixed $comentario
     */
    public function setComentario($comentario): void
    {
        $this->comentario = $comentario;
    }

    /**
     * @return mixed
     */
    public function getCodigoJuegoFk()
    {
        return $this->codigoJuegoFk;
    }

    /**
     * @param mixed $codigoJuegoFk
     */
    public function setCodigoJuegoFk($codigoJuegoFk): void
    {
        $this->codigoJuegoFk = $codigoJuegoFk;
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

    /**
     * @return mixed
     */
    public function getJuegoRel()
    {
        return $this->juegoRel;
    }

    /**
     * @param mixed $juegoRel
     */
    public function setJuegoRel($juegoRel): void
    {
        $this->juegoRel = $juegoRel;
    }


}
