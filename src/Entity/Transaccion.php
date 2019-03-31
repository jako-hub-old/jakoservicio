<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransaccionRepository")
 */
class Transaccion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="codigo_transaccion_pk",type="integer")
     */
    private $codigoTransaccionPk;

    /**
     * @ORM\Column(name="referencia", type="string",length=255, nullable=true)
     */
    private $referencia;

    /**
     * @ORM\Column(name="valor", type="float", nullable=true, options={"default" : 0})
     */
    private $valor = 0;

    /**
     * @ORM\Column(name="puntos", type="float", nullable=true, options={"default" : 0})
     */
    private $puntos = 0;

    /**
     * @ORM\Column(name="operacion", type="integer", nullable=true, options={"default" : 0})
     */
    private $operacion = 0;

    /**
     * @ORM\Column(name="codigo_usuario_fk", type="integer", nullable=true)
     */
    private $codigoUsuarioFk;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="transaccionesUsuarioRel")
     * @ORM\JoinColumn(name="codigo_usuario_fk", referencedColumnName="codigo_usuario_pk")
     */
    protected $usuarioRel;

    /**
     * @return mixed
     */
    public function getCodigoTransaccionPk()
    {
        return $this->codigoTransaccionPk;
    }

    /**
     * @param mixed $codigoTransaccionPk
     */
    public function setCodigoTransaccionPk($codigoTransaccionPk): void
    {
        $this->codigoTransaccionPk = $codigoTransaccionPk;
    }

    /**
     * @return mixed
     */
    public function getReferencia()
    {
        return $this->referencia;
    }

    /**
     * @param mixed $referencia
     */
    public function setReferencia($referencia): void
    {
        $this->referencia = $referencia;
    }

    /**
     * @return mixed
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param mixed $valor
     */
    public function setValor($valor): void
    {
        $this->valor = $valor;
    }

    /**
     * @return mixed
     */
    public function getPuntos()
    {
        return $this->puntos;
    }

    /**
     * @param mixed $puntos
     */
    public function setPuntos($puntos): void
    {
        $this->puntos = $puntos;
    }

    /**
     * @return mixed
     */
    public function getCodigoUsuarioFk()
    {
        return $this->codigoUsuarioFk;
    }

    /**
     * @param mixed $codigoUsuarioFk
     */
    public function setCodigoUsuarioFk($codigoUsuarioFk): void
    {
        $this->codigoUsuarioFk = $codigoUsuarioFk;
    }

    /**
     * @return mixed
     */
    public function getUsuarioRel()
    {
        return $this->usuarioRel;
    }

    /**
     * @param mixed $usuarioRel
     */
    public function setUsuarioRel($usuarioRel): void
    {
        $this->usuarioRel = $usuarioRel;
    }

    /**
     * @return mixed
     */
    public function getOperacion()
    {
        return $this->operacion;
    }

    /**
     * @param mixed $operacion
     */
    public function setOperacion($operacion): void
    {
        $this->operacion = $operacion;
    }



}
