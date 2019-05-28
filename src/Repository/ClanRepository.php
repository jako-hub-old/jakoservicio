<?php

namespace App\Repository;

use App\Classes\Notificacion;
use App\Classes\Utilidades;
use App\Entity\Ciudad;
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
    public function buscar() {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qbCount = $em->createQueryBuilder()
            ->from(JugadorClan::class, "jc")
            ->select("COUNT(jc.codigoJugadorClanPk)")
            ->where("jc.codigoClanFk = c.codigoClanPk");

        $qb->from(Clan::class, "c")
            ->select("c.codigoClanPk as codigo_clan")
            ->addSelect("c.fotoMiniatura as clan_foto")
            ->addSelect("c.nombre as clan_nombre")
            ->addSelect("c.fechaCreacion as clan_fecha")
            ->addSelect("({$qbCount}) as miembros")
            ->addSelect("c.rating as clan_rating")
            ->addSelect("ciudadRel.nombre as clan_ciudad")
            ->addSelect("tj.icono as tipo_juego_icono")
            ->addSelect("tj.nombre as tipo_juego_nombre")
            ->addSelect("j.nombreCorto as jugador_nombre_corto")
            ->addSelect("j.fotoMiniatura as jugador_foto")
            ->addSelect("j.seudonimo as jugador_seudonimo")
            ->leftJoin("c.jugadorRel", "j")
            ->leftJoin("c.tipoJuegoRel", "tj")
            ->leftJoin("c.ciudadRel", "ciudadRel")
            ->groupBy("c.codigoClanPk");
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
                ->where("jc.codigoJugadorFk = '{$jugador}'")
                ->andWhere("jc.confirmado = 1");

            $qb = $em->createQueryBuilder();

            $qb->from(Clan::class, "c")
                ->select("c.codigoClanPk as codigo_clan")
                ->addSelect("c.fotoMiniatura as clan_foto")
                ->addSelect("c.nombre as clan_nombre")
                ->addSelect("c.rating as clan_rating")
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
            $arCiudad = $em->getRepository(Ciudad::class)->find(1);
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
            $arClan->setCiudadRel($arCiudad);
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

    public function listarInvitacionesJugador($raw) {
        $jugador = $raw['jugador']?? 0;
        $em = $this->getEntityManager();
        if($jugador) {
            $arJugador = $em->getRepository(Jugador::class)->find($jugador);
            if($arJugador && $arJugador instanceof Jugador) {
                $qb = $em->createQueryBuilder();
                $qb->from(JugadorClan::class, "jc")
                    ->select("jc.codigoJugadorClanPk as codigo_jugador_clan")
                    ->addSelect("c.nombre as clan_nombre")
                    ->addSelect("j.seudonimo as jugador_seudonimo")
                    ->addSelect("c.fotoMiniatura as foto")
                    ->addSelect("jc.codigoClanFk as codigo_clan")
                    ->join("jc.clanRel", "c")
                    ->join("c.jugadorRel", "j")
                    ->where("jc.codigoJugadorFk = '{$jugador}'")
                    ->andWhere("jc.confirmado = 0")
                    ->andWhere("jc.invitacion = 1");
                return $qb->getQuery()->getResult();
            } else {
                return ['error_controlado' => Utilidades::validacion(15)];
            }
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

    public function aceptarInvitacion($raw) {
        $em = $this->getEntityManager();
        $invitacion = $raw['invitacion']?? 0;
        if($invitacion) {
            $arJugadorClan = $em->getRepository(JugadorClan::class)->find($invitacion);
            if($arJugadorClan) {
                $arJugadorClan->setConfirmado(true);
                $arJugadorClan->setInvitacion(false);
                $em->persist($arJugadorClan);
                $em->flush();
                return true;
            } else {
                return ['error_controlado' => Utilidades::validacion(16)];
            }
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

    public function rechazarInvitacion($raw) {
        $em = $this->getEntityManager();
        $invitacion = $raw['invitacion']?? 0;
        if($invitacion) {
            $arJugadorClan = $em->getRepository(JugadorClan::class)->find($invitacion);
            if($arJugadorClan) {
                $em->remove($arJugadorClan);
                $em->flush();
                return true;
            } else {
                return ['error_controlado' => Utilidades::validacion(16)];
            }
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

    public function aprobarSolicitud($raw) {
        $em = $this->getEntityManager();
        $invitacion = $raw['solicitud']?? 0;
        if($invitacion) {
            $arJugadorClan = $em->getRepository(JugadorClan::class)->find($invitacion);
            if($arJugadorClan) {
                $arJugadorClan->setConfirmado(1);
                $em->flush();
                return true;
            } else {
                return ['error_controlado' => Utilidades::validacion(16)];
            }
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

    /**
     * @param $raw
     * @param $notificacion Notificacion
     */
    public function unirse($raw, $notificacion) {
        $jugador = $raw['jugador']?? 0;
        $clan = $raw['clan']?? 0;
        if($clan && $jugador) {
            $em = $this->getEntityManager();
            $arJugador = $em->getRepository(Jugador::class)->find($jugador);
            $arClan = $em->getRepository(Clan::class)->find($clan);
            $esAdmin = $arClan->getCodigoJugadorFk() === $jugador;
            if($arJugador && $arClan) {
                $arJugadorClan = $em->getRepository(JugadorClan::class)->findOneBy(['codigoJugadorFk' => $jugador, 'codigoClanFk' => $clan]);
                if(!$arJugadorClan) {
                    $arJugadorClan = new JugadorClan();
                    $arJugadorClan->setJugadorRel($arJugador);
                    $arJugadorClan->setClanRel($arClan);
                    if($arClan->getCodigoJugadorFk() === $jugador) {
                        $arJugadorClan->setConfirmado(true);
                    } else {
                        $arJugadorClan->setSolicitud(true);
                    }
                    $em->persist($arJugadorClan);
                    $em->flush();
                    $titulo = "Solicitud a clan";
                    $mensaje = "{$arJugador->getSeudonimo()} solicita unirse a tu clan";
                    $notificacion->notificarAJugadores([$arJugador->getCodigoJugadorPk()] ?? [], $titulo, $mensaje, [
                        'type'      => 'clan-request',
                        'path_data' => $arClan->getCodigoClanPk(),
                        'action'    => 'yes',
                    ]);
                } else if($arJugadorClan && $arJugadorClan->getInvitacion()) {
                    $arJugadorClan->setInvitacion(false);
                    $arJugadorClan->setConfirmado(true);
                    $em->persist($arJugadorClan);
                    $em->flush();
                    return "Ahora haces parte de {$arClan->getNombre()}";
                }
                if($esAdmin) {
                    return "Ahora haces parte de {$arClan->getNombre()}";
                } else {
                    return "Se ha enviado tu solicitud";
                }
            } else {
                return ['error_controlado' => Utilidades::validacion(17)];
            }
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

    public function solicitudesEnviadas($raw) {
        $jugador = $raw['jugador']?? 0;
        if($jugador) {
            $em = $this->getEntityManager();
            $arJugador = $em->getRepository(Jugador::class)->find($jugador);
            if($arJugador) {
                $qb = $em->createQueryBuilder();
                $qb->from(JugadorClan::class, "jc")
                    ->select("jc.codigoClanFk as codigo_clan")
                    ->addSelect("jc.codigoJugadorClanPk as codigo_jugador_clan")
                    ->addSelect("c.nombre as clan_nombre")
                    ->join("jc.clanRel", "c")
                    ->where("jc.codigoJugadorFk = '{$jugador}'")
                    ->andWhere("jc.confirmado IS NULL OR jc.confirmado = 0")
                    ->andWhere("jc.solicitud = 1");
                return $qb->getQuery()->getResult();
            } else {
                return ['error_controlado' => Utilidades::validacion(17)];
            }
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

    public function solicitudesRecibidas($raw) {
        $clan = $raw['clan']?? 0;
        if($clan) {
            $em = $this->getEntityManager();
            $arClan = $em->getRepository(Clan::class)->find($clan);
            if($arClan) {
                $qb = $em->createQueryBuilder();
                $qb->from(JugadorClan::class, "jc")
                    ->select("jc.codigoClanFk as codigo_clan")
                    ->addSelect("c.nombre as clan_nombre")
                    ->addSelect("jc.codigoJugadorClanPk as codigo_solicitud")
                    ->addSelect("j.seudonimo as jugador_seudonimo")
                    ->addSelect("j.nombreCorto as jugador_nombre_corto")
                    ->addSelect("j.codigoJugadorPk as jugador_codigo")
                    ->addSelect("j.fotoMiniatura as foto")
                    ->join("jc.clanRel", "c")
                    ->join("jc.jugadorRel", "j")
                    ->where("jc.codigoClanFk= '{$clan}'")
                    ->andWhere("jc.confirmado IS NULL OR jc.confirmado = 0")
                    ->andWhere("jc.solicitud = 1");
                return $qb->getQuery()->getResult();
            } else {
                return ['error_controlado' => Utilidades::validacion(17)];
            }
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

    public function cancelarSolicitud($raw) {
        $solicitud = $raw['solicitud']?? 0;
        if($solicitud) {
            $em = $this->getEntityManager();
            $arJugadorClan = $em->getRepository(JugadorClan::class)->find($solicitud);
            if($arJugadorClan) {
                $em->remove($arJugadorClan);
                $em->flush();
            }
            return true;
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

    public function abandonar($raw) {
        $jugador = $raw['jugador']?? 0;
        $clan = $raw['clan']?? 0;
        if($jugador && $clan) {
            $em = $this->getEntityManager();
            $arJugadorClan = $em->getRepository(JugadorClan::class)->findOneBy(['codigoClanFk' => $clan, 'codigoJugadorFk' => $jugador]);
            if($arJugadorClan) {
                $em->remove($arJugadorClan);
                $em->flush();
            }
            return true;
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }
}