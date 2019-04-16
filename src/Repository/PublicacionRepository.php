<?php

namespace App\Repository;

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
        $qb = $em->createQueryBuilder();
        $qb->from(Publicacion::class, "p")
            ->select("p.codigoPublicacionPk as codigo_publicacion")
            ->addSelect("p.tipo")
            ->addSelect('p.codigoJuegoFk')
            ->addSelect('p.texto')
            ->addSelect('p.fecha')
            ->orderBy("p.codigoPublicacionPk", "DESC");
        $arPublicaciones =  $qb->getQuery()->getResult();
        return $arPublicaciones;

    }

}
