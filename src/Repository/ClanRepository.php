<?php

namespace App\Repository;

use App\Entity\Clan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Clan|null find($id, $lockMode = null, $lockVersion = null)
 * @method Clan|null findOneBy(array $criteria, array $orderBy = null)
 * @method Clan[]    findAll()
 * @method Clan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClanRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Clan::class);
    }

    public function lista() {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->from(Clan::class, "c")
            ->select("c.codigoClanPk")
            ->addSelect("c.foto")
            ->addSelect("c.nombre")
            ->addSelect("c.fechaCreacion")
            ->addSelect("")
            ;
    }

    public function jugador($raw) {

    }
}
