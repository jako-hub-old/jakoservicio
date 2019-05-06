<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InvitadoRepository")
 */
class Invitado
{
    /**
     * @ORM\Id
     * @ORM\Column(name="codigo_invitado_pk", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $codigoInvitadoPk;

    /**
     * @ORM\Column(name="codigo_jugador_fk", type="integer")
     */
    private $codigoJugadorFk;
    /**
     * @ORM\Column(name="telefono_invitado", type="string", nullable=true)
     */
    private $telefonoInvitado;
    /**
     * @ORM\Column(name="registrado", type="boolean", nullable=true)
     */
    private $registrado=false;
    /**
     * @ORM\Column(name="amigo", type="boolean", nullable=true)
     */
    private $amigo=false;
    /**
     * @ORM\Column(name="fecha_enviado", type="datetime")
     */
    private $fechaEnviado;

    /**
     * @ORM\ManyToOne(targetEntity="Jugador", inversedBy="invitadosJugador")
     * @ORM\JoinColumn(name="codigo_jugador_fk", referencedColumnName="codigo_jugador_pk")
     */
    protected $jugadorRel;

    /**
     * @return mixed
     */
    public function getCodigoInvitadoPk()
    {
        return $this->codigoInvitadoPk;
    }

    /**
     * @param mixed $codigoInvitadoPk
     */
    public function setCodigoInvitadoPk($codigoInvitadoPk): void
    {
        $this->codigoInvitadoPk = $codigoInvitadoPk;
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
    public function getTelefonoInvitado()
    {
        return $this->telefonoInvitado;
    }

    /**
     * @param mixed $telefonoInvitado
     */
    public function setTelefonoInvitado($telefonoInvitado): void
    {
        $this->telefonoInvitado = $telefonoInvitado;
    }

    /**
     * @return mixed
     */
    public function getRegistrado()
    {
        return $this->registrado;
    }

    /**
     * @param mixed $registrado
     */
    public function setRegistrado($registrado): void
    {
        $this->registrado = $registrado;
    }

    /**
     * @return mixed
     */
    public function getAmigo()
    {
        return $this->amigo;
    }

    /**
     * @param mixed $amigo
     */
    public function setAmigo($amigo): void
    {
        $this->amigo = $amigo;
    }

    /**
     * @return mixed
     */
    public function getFechaEnviado()
    {
        return $this->fechaEnviado;
    }

    /**
     * @param mixed $fechaEnviado
     */
    public function setFechaEnviado($fechaEnviado): void
    {
        $this->fechaEnviado = $fechaEnviado;
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

