<?php

namespace App\Repository;

use App\Entity\Transaccion;
use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TransaccionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Transaccion::class);
    }

    public function aplicar($valor, $puntos, $codigoUsuario, $operacion, $referencia) {
        $em = $this->getEntityManager();
        $puntos = $puntos * $operacion;
        $arUsuario = $em->getRepository(Usuario::class)->find($codigoUsuario);
        $arUsuario->setPuntos($arUsuario->getPuntos() + $puntos);
        $em->persist($arUsuario);

        $arTransaccion = new Transaccion();
        $arTransaccion->setUsuarioRel($arUsuario);
        $arTransaccion->setValor($valor);
        $arTransaccion->setPuntos($puntos);
        $arTransaccion->setOperacion($operacion);
        $arTransaccion->setReferencia($referencia);
        $em->persist($arTransaccion);
        $em->flush();
    }

}
