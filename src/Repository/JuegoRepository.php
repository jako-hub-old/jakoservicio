<?php

namespace App\Repository;

use App\Classes\Utilidades;
use App\Entity\Comentario;
use App\Entity\Escenario;
use App\Entity\Juego;
use App\Entity\JuegoDetalle;
use App\Entity\JuegoEquipo;
use App\Entity\JuegoInvitacion;
use App\Entity\JuegoJugador;
use App\Entity\Jugador;
use App\Entity\Posicion;
use App\Entity\Publicacion;
use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class JuegoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Juego::class);
    }

    public function nuevo($datos) {
        $em = $this->getEntityManager();
        $jugador = $datos['jugador']?? '';
        $escenario = $datos['escenario']?? '';
        $fechaDesde = $datos['fecha_desde']?? '';
        $fechaHasta = $datos['fecha_hasta']?? '';
        $nombre = $datos['nombre']?? '';
        $acceso = $datos['acceso']?? '';
        $arrEquipos = $codigoJuego = $datos['equipos']?? 0;
        if($jugador && $escenario && $fechaDesde && $fechaHasta && $nombre && $acceso) {
            $arJugador = $em->getRepository(Jugador::class)->find($jugador);
            $arEscenario = $em->getRepository(Escenario::class)->find($escenario);
            $fechaDesde = date_create($fechaDesde);
            $fechaHasta = date_create($fechaHasta);
            $arJuego = new Juego();
            $arJuego->setJugadorRel($arJugador);
            $arJuego->setEscenarioRel($arEscenario);
            $arJuego->setFechaDesde($fechaDesde);
            $arJuego->setFechaHasta($fechaHasta);
            $arJuego->setNombre($nombre);
            $arJuego->setAcceso($acceso);
            $arJuego->setVrCosto(0.05);
            $em->persist($arJuego);
            $jugadores = 0;
            if($arrEquipos) {
                foreach ($arrEquipos as $arrEquipo) {
                    $arJuegoEquipo = new JuegoEquipo();
                    $arJuegoEquipo->setJuegoRel($arJuego);
                    $arJuegoEquipo->setNombre($arrEquipo['nombre']);
                    $arJuegoEquipo->setJugadores($arrEquipo['jugadores']);
                    $em->persist($arJuegoEquipo);
                    $jugadores += $arrEquipo['jugadores'];
                }
            }
            $arJuego->setJugadores($jugadores);
            $em->persist($arJuego);

            $arPublicacion = new Publicacion();
            $arPublicacion->setJugadorRel($arJugador);
            $arPublicacion->setJuegoRel($arJuego);
            $em->persist($arPublicacion);

            $em->flush();
            return [
                'codigo_juego' => $arJuego->getCodigoJuegoPk(),
            ];
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

    /**
     * @param $filtros
     * @return array
     */
    public function buscar()
    {
        $em = $this->getEntityManager();
        $fecha = new \DateTime('now');
        $qb = $em->createQueryBuilder();
        $qb->from(Juego::class, "j")
            ->select("j.codigoJuegoPk as codigo_juego")
            ->addSelect("j.nombre as nombre")
            ->addSelect("j.jugadores as jugadores")
            ->addSelect("j.jugadoresConfirmados as jugadores_confirmados")
            ->addSelect("j.fechaDesde as fecha_desde")
            ->addSelect("j.fechaHasta as fecha_hasta")
            ->addSelect("j.acceso")
            ->addSelect("e.nombre as escenario_nombre")
            ->addSelect("n.nombre as negocio_nombre")
            ->addSelect("ju.seudonimo as jugador_seudonimo")
            ->leftJoin("j.escenarioRel", "e")
            ->leftJoin("e.negocioRel", "n")
            ->leftJoin("j.jugadorRel", "ju")
        ->where("j.fechaDesde >= '".$fecha->format('Y-m-d H:i')."'");
        $arJuegos =  $qb->getQuery()->getResult();
        return $arJuegos;

    }

    /**
     * @param $filtros
     * @return array
     */
    public function jugador($filtros)
    {
        $em = $this->getEntityManager();
        $jugador = $filtros['jugador']?? false;
        if($jugador) {
            $qb = $em->createQueryBuilder();
            $qb->from(JuegoDetalle::class, "jd")
                ->select("jd.codigoJuegoDetallePk as codigo_juego_detalle")
                ->addSelect("jd.codigoJuegoFk as codigo_juego")
                ->addSelect("j.nombre as juego_nombre")
                ->addSelect("j.jugadores as juego_jugadores")
                ->addSelect("j.jugadoresConfirmados as juego_jugadores_confirmados")
                ->addSelect("j.fechaDesde as juego_fecha_desde")
                ->addSelect("j.fechaHasta as juego_fecha_hasta")
                ->addSelect("j.acceso as juego_acceso")
                ->addSelect("e.nombre as escenario_nombre")
                ->addSelect("n.nombre as negocio_nombre")
                ->addSelect("ju.seudonimo as jugador_seudonimo")
                ->leftJoin("jd.juegoRel", "j")
                ->leftJoin("j.escenarioRel", "e")
                ->leftJoin("e.negocioRel", "n")
                ->leftJoin("jd.jugadorRel", "ju")
            ->where("jd.codigoJugadorFk ={$jugador}");
            $arJuegosJugadores =  $qb->getQuery()->getResult();
            $juegos = array();
            foreach ($arJuegosJugadores as $arJuegoJugador) {
                $qb = $em->createQueryBuilder();
                $qb->from(Comentario::class, "c")
                    ->select("c.codigoComentarioPk as codigo_comentario")
                    ->addSelect("c.fecha")
                    ->addSelect("c.comentario")
                    ->addSelect("j.seudonimo as jugador_seudonimo")
                    ->leftJoin("c.jugadorRel", "j")
                    ->where("c.codigoJuegoFk ={$arJuegoJugador['codigo_juego']}")
                ->orderBy("c.fecha", "ASC")
                ->setMaxResults(2);
                $arComentarios = $qb->getQuery()->getResult();

                $juegos[] = [
                    'codigo_juego_detalle' => $arJuegoJugador['codigo_juego_detalle'],
                    'codigo_juego' => $arJuegoJugador['codigo_juego'],
                    'juego_nombre' => $arJuegoJugador['juego_nombre'],
                    'juego_jugadores' => $arJuegoJugador['juego_jugadores'],
                    'juego_jugadores_confirmados' => $arJuegoJugador['juego_jugadores_confirmados'],
                    'juego_fecha_desde' => $arJuegoJugador['juego_fecha_desde'],
                    'juego_fecha_hasta' => $arJuegoJugador['juego_fecha_hasta'],
                    'juego_acceso' => $arJuegoJugador['juego_acceso'],
                    'escenario_nombre' => $arJuegoJugador['escenario_nombre'],
                    'negocio_nombre' => $arJuegoJugador['negocio_nombre'],
                    'jugador_seudonimo' => $arJuegoJugador['jugador_seudonimo'],
                    'comentarios' => array($arComentarios)
                ];
            }
            return $juegos;
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

    /**
     * @param $datos
     * @return array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function unir($datos)
    {
        $em = $this->getEntityManager();
        $jugador = $datos['jugador']?? false;
        $juego = $datos['juego']?? false;
        $posicion = $datos['posicion']?? false;
        $numero = $datos['numero']?? false;
        $equipo = $datos['equipo']?? false;
        if($jugador && $juego && $posicion && $numero && $equipo) {
            $arUsuario = $em->getRepository(Usuario::class)->find($jugador);
            $arJugador = $em->getRepository(Jugador::class)->find($jugador);
            $arJuego = $em->getRepository(Juego::class)->find($juego);
            $arPosicion = $em->getRepository(Posicion::class)->find($posicion);
            $arEquipo = $em->getRepository(JuegoEquipo::class)->find($equipo);
            if($arJugador && $arJuego && $arPosicion && $arEquipo) {
                $arJuegoDetalle = $em->getRepository(JuegoDetalle::class)->findOneBy(['codigoJuegoFk' => $juego, 'codigoJugadorFk' => $jugador]);
                if(!$arJuegoDetalle) {
                    if($arJuego->getJugadoresConfirmados() < $arJuego->getJugadores()) {
                        if($arUsuario->getPuntos() >= $arJuego->getVrCosto()) {
                            $arJuegoDetalle = new JuegoDetalle();
                            $arJuegoDetalle->setJuegoRel($arJuego);
                            $arJuegoDetalle->setJugadorRel($arJugador);
                            $arJuegoDetalle->setPosicionRel($arPosicion);
                            $arJuegoDetalle->setNumero($numero);
                            $arJuegoDetalle->setJuegoEquipoRel($arEquipo);
                            $em->persist($arJuegoDetalle);
                            $arJuego->setJugadoresConfirmados($arJuego->getJugadoresConfirmados() + 1);
                            $em->persist($arJuego);
                            $arEquipo->setJugadoresConfirmados($arEquipo->getJugadoresConfirmados() + 1);

                            $em->flush();
                            return true;
                        } else {
                            return [
                                'validacion' => Utilidades::validacion(11),
                            ];
                        }
                    } else {
                        return [
                            'validacion' => Utilidades::validacion(4),
                        ];
                    }
                } else {
                    return [
                        'validacion' => Utilidades::validacion(3),
                    ];
                }
            } else {
                return [
                    'validacion' => Utilidades::validacion(2),
                ];
            }
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

    /**
     * @param $datos
     * @return array|bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function retirar($datos)
    {
        $em = $this->getEntityManager();
        $juegoDetalle = $datos['juegoDetalle']?? false;
        if($juegoDetalle) {
            $arJuegoDetalle = $em->getRepository(JuegoDetalle::class)->find($juegoDetalle);
            if($arJuegoDetalle) {
                $arJuego = $em->getRepository(Juego::class)->find($arJuegoDetalle->getCodigoJuegoFk());
                $arJuego->setJugadoresConfirmados($arJuego->getJugadoresConfirmados() - 1);
                $em->persist($arJuego);

                $em->remove($arJuegoDetalle);
                $em->flush();
                return true;
            } else {
                return [
                    'validacion' => Utilidades::validacion(5),
                ];
            }
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

    /**
     * @param $filtros
     * @return array
     */
    public function detalle($datos)
    {
        $em = $this->getEntityManager();
        $juego = $datos['juego']?? false;
        if($juego) {
            $qb = $em->createQueryBuilder();
            $qb->from(Juego::class, "j")
                ->select("j.codigoJuegoPk as codigo_juego")
                ->addSelect("j.nombre as nombre")
                ->addSelect("j.jugadores as jugadores")
                ->addSelect("j.jugadoresConfirmados as jugadores_confirmados")
                ->addSelect("j.fechaDesde as fecha_desde")
                ->addSelect("j.fechaHasta as fecha_hasta")
                ->addSelect("j.acceso as acceso")
                ->addSelect("e.nombre as escenario_nombre")
                ->addSelect("n.nombre as negocio_nombre")
                ->addSelect("ju.seudonimo as jugador_seudonimo")
                ->leftJoin("j.escenarioRel", "e")
                ->leftJoin("e.negocioRel", "n")
                ->leftJoin("j.jugadorRel", "ju")
                ->where("j.codigoJuegoPk ={$juego}");
            $arJuego =  $qb->getQuery()->getResult();
            if($arJuego && count($arJuego) > 0) {
                $arJuego = $arJuego[0];
                $qb = $em->createQueryBuilder();
                $fotoUsuarioTemporal = "https://i0.wp.com/www.winhelponline.com/blog/wp-content/uploads/2017/12/user.png?fit=256%2C256&quality=100&ssl=1";
                $qb->from(Comentario::class, "c")
                    ->select("c.codigoComentarioPk as codigo_comentario")
                    ->addSelect("c.fecha")
                    ->addSelect("c.comentario")
                    ->addSelect("j.seudonimo as jugador_seudonimo")
                    ->addSelect("'{$fotoUsuarioTemporal}' as foto_usuario")
                    ->leftJoin("c.jugadorRel", "j")
                    ->where("c.codigoJuegoFk ={$juego}")
                    ->orderBy("c.fecha", "ASC");
                $arComentarios = $qb->getQuery()->getResult();

                $qb = $em->createQueryBuilder();
                $qb->from(JuegoDetalle::class, "jd")
                    ->select("jd.codigoJuegoDetallePk as codigo_juego_detalle")
                    ->addSelect("jd.codigoJugadorFk as codigo_jugador")
                    ->addSelect("jd.codigoPosicionFk as codigo_posicion")
                    ->addSelect("jd.numero")
                    ->addSelect("p.nombre as posicion_nombre")
                    ->addSelect("j.nombreCorto as jugador_nombre_corto")
                    ->addSelect("jd.codigoJuegoEquipoFk as codigo_equipo")
                    ->leftJoin("jd.jugadorRel", "j")
                    ->leftJoin("jd.posicionRel", "p")
                    ->where("jd.codigoJuegoFk ={$juego}");
                $arJuegoDetalles = $qb->getQuery()->getResult();

                $qb = $em->createQueryBuilder();
                $qb->from(JuegoEquipo::class, "je")
                    ->select("je.codigoJuegoEquipoPk as codigo_juego_equipo")
                    ->addSelect("je.nombre")
                    ->addSelect("je.jugadores as jugadores")
                    ->addSelect("je.jugadoresConfirmados as jugadores_confirmados")
                    ->where("je.codigoJuegoFk ={$juego}");
                $arJuegoEquipos = $qb->getQuery()->getResult();

                $juego = [
                    'codigo_juego' => $arJuego['codigo_juego'],
                    'nombre' => $arJuego['nombre'],
                    'jugadores' => $arJuego['jugadores'],
                    'jugadores_confirmados' => $arJuego['jugadores_confirmados'],
                    'fecha_desde' => $arJuego['fecha_desde'],
                    'fecha_hasta' => $arJuego['fecha_hasta'],
                    'acceso' => $arJuego['acceso'],
                    'escenario_nombre' => $arJuego['escenario_nombre'],
                    'negocio_nombre' => $arJuego['negocio_nombre'],
                    'jugador_seudonimo' => $arJuego['jugador_seudonimo'],
                    'comentarios' => $arComentarios,
                    'detalles' => $arJuegoDetalles,
                    'equipos' => $arJuegoEquipos
                ];
                return $juego;
            } else {
                return [
                    'validacion' => Utilidades::validacion(6),
                ];
            }
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

    /**
     * @param $datos
     * @return array|bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function invitar($datos)
    {
        $em = $this->getEntityManager();
        $juego = $datos['juego']?? false;
        $jugadores = $datos['jugadores']?? false;
        if($juego && $jugadores) {
            $arJuego = $em->getRepository(Juego::class)->find($juego);
            if($arJuego) {
                foreach ($jugadores as $jugador) {
                    $arJugador = $em->getRepository(Jugador::class)->find($jugador);
                    if($arJugador) {
                        $arJuegoDetalle = $em->getRepository(JuegoDetalle::class)->findOneBy(["codigoJuegoFk" => $juego, "codigoJugadorFk" => $jugador]);
                        if(!$arJuegoDetalle) {
                            $arJuegoInvitacion = $em->getRepository(JuegoInvitacion::class)->findOneBy(["codigoJuegoFk" => $juego, "codigoJugadorFk" => $jugador]);
                            if(!$arJuegoInvitacion) {
                                $arJuegoInvitacion = new JuegoInvitacion();
                                $arJuegoInvitacion->setJuegoRel($arJuego);
                                $arJuegoInvitacion->setJugadorRel($arJugador);
                                $em->persist($arJuegoInvitacion);
                            }
                        }
                    }
                }
                $em->flush();
                return true;
            }
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

}
