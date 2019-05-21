<?php

namespace App\Repository;

use App\Classes\Utilidades;
use App\Entity\Clan;
use App\Entity\Jugador;
use App\Entity\JugadorClan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Clan|null find($id, $lockMode = null, $lockVersion = null)
 * @method Clan|null findOneBy(array $criteria, array $orderBy = null)
 * @method Clan[]    findAll()
 * @method Clan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @author Jorge Alejandro Quiroz Serna <jakop.box@gmail.com>
 */
class ClanRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Clan::class);
    }

    /**
     * Esta función lista todos los clanes de la aplicación.
     * @author Jorge Alejandro Quiroz Serna <jakop.box@gmail.com>
     * @return mixed
     */
    public function lista() {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->from(Clan::class, "c")
            ->select("c.codigoClanPk")
            ->addSelect("c.foto as clan_foto")
            ->addSelect("c.nombre as clan_nombre")
            ->addSelect("c.fechaCreacion as clan_fecha")
            ->addSelect("j.nombreCorto as jugador_nombre_corto")
            ->addSelect("j.fotoMiniatura as jugador_foto")
            ->addSelect("j.seudonimo as jugador_seudonimo")
            ->leftJoin("c.jugadorRel", "j");
        return $qb->getQuery()->getResult();
    }

    /**
     * @param $raw
     * @return array|mixed
     * @author Jorge Alejandro Quiroz Serna <jakop.box@gmail.com>
     */
    public function admin($raw) {
        $em = $this->getEntityManager();
        $jugador = $raw['jugador']?? 0;
        $arJugador = $em->getRepository(Jugador::class)->find($jugador);
        if($arJugador && $arJugador instanceof Jugador) {
            $qb = $em->createQueryBuilder();
            $qb->from(Clan::class, "c")
                ->select("c.codigoClanPk")
                ->addSelect("c.foto as clan_foto")
                ->addSelect("c.nombre as clan_nombre")
                ->addSelect("c.fechaCreacion as clan_fecha")
                ->addSelect("j.nombreCorto as jugador_nombre_corto")
                ->addSelect("j.fotoMiniatura as jugador_foto")
                ->addSelect("j.seudonimo as jugador_seudonimo")
                ->leftJoin("c.jugadorRel", "j")
                ->where("c.codigoJugadorFk = '{$jugador}'");
            return $qb->getQuery()->getResult();
        } else {
            return [
                'error_controlado' => Utilidades::error(3),
            ];
        }
    }

    /**
     * Esta función lista los clanes a los que pertenece un jugador.
     * @param $raw
     * @return array|mixed
     */
    public function jugador($raw) {
        $em = $this->getEntityManager();
        $jugador = $raw['jugador']?? 0;
        $arJugador = $em->getRepository(Jugador::class)->find($jugador);
        if($arJugador && $arJugador instanceof Jugador) {
            $qbJugadorClan = $em->createQueryBuilder();

            $qbJugadorClan->from(JugadorClan::class, "jc")
                ->select("jc.codigoClanFk")
                ->where("jc.codigoJugadorFk = '{$jugador}'");

            $qb = $em->createQueryBuilder();

            $qb->from(Clan::class, "c")
                ->select("c.codigoClanPk")
                ->addSelect("c.foto as clan_foto")
                ->addSelect("c.nombre as clan_nombre")
                ->addSelect("c.fechaCreacion as clan_fecha")
                ->addSelect("j.nombreCorto as jugador_nombre_corto")
                ->addSelect("j.fotoMiniatura as jugador_foto")
                ->addSelect("j.seudonimo as jugador_seudonimo")
                ->leftJoin("c.jugadorRel", "j")
                ->where("c.codigoClanPk IN ({$qbJugadorClan})");

            return $qb->getQuery()->getResult();
        } else {
            return [
                'error_controlado' => Utilidades::error(3),
            ];
        }
    }
}