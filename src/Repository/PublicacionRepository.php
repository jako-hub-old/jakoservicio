<?php

namespace App\Repository;

use App\Entity\JugadorAmigo;
use App\Entity\Publicacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PublicacionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Publicacion::class);
    }

    /**
     * @param $filtros
     * @return array
     */
    public function lista($raw)
    {
        $em = $this->getEntityManager();
        $jugador = $raw['jugador']?? 0;
        $qbAmigos = $em->createQueryBuilder()
            ->from(JugadorAmigo::class, "a")
            ->select("a.codigoJugadorAmigoFk")
            ->where("a.codigoJugadorFk = {$jugador}");
        $qb = $em->createQueryBuilder();
        $qb->from(Publicacion::class, "p")
            ->select("p.codigoPublicacionPk as codigo_publicacion")
            ->addSelect("p.tipo")
            ->addSelect('p.codigoJuegoFk')
            ->addSelect('p.texto')
            ->addSelect('p.fecha')
            ->addSelect("p.plataforma")
            ->addSelect("j.fotoMiniatura as foto")
            ->leftJoin("p.jugadorRel", "j")
            ->orderBy("p.codigoPublicacionPk", "DESC")
            ->where("p.codigoJugadorFk IN ({$qbAmigos})")
            ->andWhere("p.personal IS NULL or p.personal = 0")
            ->orWhere("p.codigoJugadorFk = '{$jugador}'");
        $arPublicaciones =  $qb->getQuery()->getResult();
        return $arPublicaciones;

    }

    /**
     * @param $filtros
     * @return array
     */
    public function jugador($raw)
    {
        $em = $this->getEntityManager();
        $jugador = $raw['jugador']?? 0;
        $qb = $em->createQueryBuilder();
        $qb->from(Publicacion::class, "p")
            ->select("p.codigoPublicacionPk as codigo_publicacion")
            ->addSelect("p.tipo")
            ->addSelect('p.codigoJuegoFk')
            ->addSelect('p.texto')
            ->addSelect('p.fecha')
            ->orderBy("p.codigoPublicacionPk", "DESC")
            ->where("p.codigoJugadorFk = '{$jugador}'");
        $arPublicaciones =  $qb->getQuery()->getResult();
        return $arPublicaciones;

    }
}
