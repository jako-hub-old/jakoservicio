<?php

namespace App\Repository;

use App\Entity\JugadorAmigo;
use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\RegistryInterface;

class JugadorAmigoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, JugadorAmigo::class);
    }

    public function getAmigosJugador($jugador) {
        try {
            $em = $this->getEntityManager();
            $qb = $em->createQueryBuilder()
                ->from(JugadorAmigo::class, "ja")
                ->select("usuario.codigoUsuarioPk")
                ->addSelect("usuario.fcmToken")
                ->leftJoin("ja.jugadorAmigoRel", "jugadorAmigoRel")
                ->leftJoin(Usuario::class, "usuario", Join::WITH, 'ja.codigoJugadorAmigoFk = usuario.codigoJugadorFk')
                ->where("ja.codigoJugadorFk = '{$jugador}'");
            return $qb->getQuery()->getResult();
        } catch (\Exception $e) {
            return [];
        }
    }

}
