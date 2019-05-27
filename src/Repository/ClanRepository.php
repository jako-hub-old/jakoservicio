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
                ->groupBy("c.codigoClanPk")
                ->orderBy("c.codigoClanPk", "DESC");
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
                ->groupBy("c.codigoClanPk")
                ->orderBy("c.codigoClanPk" ,"DESC");

            return $qb->getQuery()->getResult();
        } else {
            return [
                'error_controlado' => Utilidades::error(3),
            ];
        }
    }

    /**
     * @param $data
     * @return array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function nuevo($data) {
        $em = $this->getEntityManager();
        $tipoJuego = $data['tipo_juego']?? 0;
        $nombre = $data['nombre']?? null;
        $urlImagen = $data['url_imagen']?? null;
        $urlMiniatura = $data['url_miniatura']?? null;
        $jugador = $data['jugador']?? 0;
        # Todo: upload the image.
        if($jugador && $nombre && $tipoJuego) {
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
            $arClan->setFoto($urlImagen);
            $arClan->setFotoMiniatura($urlMiniatura);
            $arClan->setFechaCreacion(new \DateTime('now'));
            $em->persist($arClan);
            $em->flush();
            return [
                'codigo_clan'           => $arClan->getCodigoClanPk(),
                'clan_fecha'            => $arClan->getFechaCreacion(),
                'clan_foto'             => $arClan->getFotoMiniatura(),
                'clan_nombre'           => $arClan->getNombre(),
                'clan_rating'           => $arClan->getRating(),
                'jugador_foto'          => $arClan->getJugadorRel()->getFotoMiniatura(),
                'jugador_nombre_corto'  => $arClan->getJugadorRel()->getNombreCorto(),
                'jugador_seudonimo'     => $arClan->getJugadorRel()->getSeudonimo(),
                'nombre_tipo_juego'     => $arClan->getTipoJuegoRel()->getNombre(),
                'miembros'              => 0,
            ];
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

    public function detalle($raw) {
        $em = $this->getEntityManager();
        $clan = $raw['clan']?? 0;
        if($clan) {
            $arClan = $em->getRepository(Clan::class)->find($clan);
            if(!$arClan) return ['error_controlado' => Utilidades::error(5)];
            $miembros = $this->getMiembrosClan($clan);
            $infoClan = [
                'codigo_clan' => $arClan->getCodigoClanPk(),
                'nombre' => $arClan->getNombre(),
                'foto' => $arClan->getFoto(),
                'foto_miniatura' => $arClan->getFoto(),
                'rating' => $arClan->getRating(),
                'juego_tipo' => $arClan->getTipoJuegoRel()->getNombre(),
                'miembros' => $miembros,
            ];
            return $infoClan;
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

    private function getMiembrosClan($clan) {
        $em = $this->getEntityManager();
        $qbMiembros = $em->createQueryBuilder();
        $qbMiembros->from(JugadorClan::class, "jc")
            ->select("jc.codigoJugadorFk")
            ->where("jc.codigoClanFk = '{$clan}'")
            ->andWhere("jc.confirmado = 1")
            ->andWhere("jc.invitacion = 0 OR jc.invitacion IS NULL");
        $qbJugadores = $em->createQueryBuilder()
                    ->from(Jugador::class, "j")
                    ->select("j.codigoJugadorPk as codigo_jugador")
                    ->addSelect("j.nombreCorto as jugador_nombre_corto")
                    ->addSelect("j.fotoMiniatura as jugador_foto")
                    ->addSelect("j.seudonimo as jugador_seudonimo")
                    ->where("j.codigoJugadorPk IN ({$qbMiembros})");
        return $qbJugadores->getQuery()->getResult();
    }

    public function invitarJugadores($raw) {
        $jugadores = $raw['jugadores']?? false;
        $clan = $raw['clan']?? false;
        $em = $this->getEntityManager();
        if($jugadores && $clan) {
            $arClan = $em->getRepository(Clan::class)->find($clan);
            if(!$arClan) {
                return ['error_controlado' => Utilidades::validacion(14)];
            }
            $notificarJugadores = [];
            foreach ($jugadores as $jugador) {
                $arJugador = $em->getRepository(Jugador::class)->find($jugador);
                $arJugadorClanExistente = $em->getRepository(JugadorClan::class)->findOneBy(['codigoClanFk' => $clan, 'codigoJugadorFk' => $jugador]);
                if(!$arJugador || !$arJugador instanceof Jugador || $arJugadorClanExistente) {
                    continue;
                }
                $arJugadorClan = new JugadorClan();
                $arJugadorClan->setJugadorRel($arJugador);
                $arJugadorClan->setClanRel($arClan);
                $arJugadorClan->setInvitacion(true);
                $em->persist($arJugadorClan);
                $notificarJugadores[] = $jugador;
            }
            $em->flush();
            if(count($notificarJugadores)){
                return [
                    'notificar_jugadores'   => $notificarJugadores,
                    'jugador_seudonimo'     => $arClan->getJugadorRel()->getSeudonimo(),
                    'codigo_clan'           => $arClan->getCodigoClanPk(),
                ];
            } else {
                return true;
            }
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }
}