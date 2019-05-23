<?php

namespace App\Repository;

use App\Classes\Utilidades;
use App\Entity\Clan;
use App\Entity\JuegoTipo;
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
            ->select("c.codigoClanPk as codigo_clan")
            ->addSelect("c.foto as clan_foto")
            ->addSelect("c.nombre as clan_nombre")
            ->addSelect("c.fechaCreacion as clan_fecha")
            ->addSelect("c.rating as clan_rating")
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
                ->select("c.codigoClanPk as codigo_clan")
                ->addSelect("c.foto as clan_foto")
                ->addSelect("c.nombre as clan_nombre")
                ->addSelect("c.fechaCreacion as clan_fecha")
                ->addSelect("j.nombreCorto as jugador_nombre_corto")
                ->addSelect("j.fotoMiniatura as jugador_foto")
                ->addSelect("j.seudonimo as jugador_seudonimo")
                ->addSelect("c.rating as clan_rating")
                ->addSelect("COUNT(c.codigoClanPk) as miembros")
                ->leftJoin("c.jugadorRel", "j")
                ->leftJoin("c.clanJugadorClanRel", "jp")
                ->where("c.codigoJugadorFk = '{$jugador}'")
                ->groupBy("c.codigoClanPk");
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
                ->select("c.codigoClanPk as codigo_clan")
                ->addSelect("c.foto as clan_foto")
                ->addSelect("c.nombre as clan_nombre")
                ->addSelect("c.fechaCreacion as clan_fecha")
                ->addSelect("j.nombreCorto as jugador_nombre_corto")
                ->addSelect("j.fotoMiniatura as jugador_foto")
                ->addSelect("j.seudonimo as jugador_seudonimo")
                ->addSelect("COUNT(c.codigoClanPk) as miembros")
                ->leftJoin("c.jugadorRel", "j")
                ->leftJoin("c.clanJugadorClanRel", "jp")
                ->where("c.codigoClanPk IN ({$qbJugadorClan})")
                ->groupBy("c.codigoClanPk");

            return $qb->getQuery()->getResult();
        } else {
            return [
                'error_controlado' => Utilidades::error(3),
            ];
        }
    }

    public function nuevo($data) {
        $em = $this->getEntityManager();
        $tipoJuego = $data['tipo_juego']?? 0;
        $nombre = $data['nombre']?? null;
        # Todo: upload the image.
        $jugador = $data['jugador']?? 0;
        if(!$jugador || !$nombre || !$tipoJuego) {
            $arJugador = $em->getRepository(Jugador::class)->find($jugador);
            $arTipoJuego = $em->getRepository(JuegoTipo::class)->find($tipoJuego);
            if(!$arJugador) {
                return ['error_controlado' => Utilidades::error(3)];
            }
            if(!$arTipoJuego) {
                return ['error_controlado' => Utilidades::error(4)];
            }
            $arClan = new Clan();
            $arClan->setNombre($nombre);
            $arClan->setJugadorRel($arJugador);
            $arClan->setRating(1);
            $arClan->setTipoJuegoRel($arTipoJuego);
            $em->persist($arClan);
            $em->flush();
            return [
                'codigo_clan' => $arClan->getCodigoClanPk(),
                'nombre' => $arClan->getNombre(),
                'nombre_tipo_juego' => $arClan->getTipoJuegoRel()->getNombre(),
                'codigo_tipo_juego' => $arClan->getTipoJuegoRel()->getCodigoJuegoTipoPk(),
                'foto' => $arClan->getFoto(),
                'rating' => $arClan->getRating(),
            ];
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }
}