<?php

namespace App\Repository;

use App\Entity\JuegoTipo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method JuegoTipo|null find($id, $lockMode = null, $lockVersion = null)
 * @method JuegoTipo|null findOneBy(array $criteria, array $orderBy = null)
 * @method JuegoTipo[]    findAll()
 * @method JuegoTipo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JuegoTipoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, JuegoTipo::class);
    }

    public function lista() {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->from(JuegoTipo::class, "jt")
            ->select("jt.codigoJuegoTipoPk as codigo_juego_tipo")
            ->addSelect("jt.nombre")
            ->addSelect("jt.descripcion");
        return $qb->getQuery()->getResult();
    }
}
