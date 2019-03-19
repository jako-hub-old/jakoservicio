<?php

namespace App\Repository;

use App\Entity\Comentario;
use App\Entity\Escenario;
use App\Entity\Juego;
use App\Entity\JuegoDetalle;
use App\Entity\JuegoJugador;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class JuegoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Juego::class);
    }

    public function listaJugador($filtros)
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
                ->addSelect("j.fecha as juego_fecha")
                ->addSelect("j.acceso as juego_acceso")
                ->addSelect("e.nombre as escenario_nombre")
                ->addSelect("n.nombre as negocio_nombre")
                ->addSelect("ua.seudonimo as usuario_administrador_seudonimo")
                ->leftJoin("jd.juegoRel", "j")
                ->leftJoin("j.escenarioRel", "e")
                ->leftJoin("e.negocioRel", "n")
                ->leftJoin("j.usuarioAdministradorRel", "ua")
            ->where("jd.codigoJugadorFk ={$jugador}");
            $arJuegosJugadores =  $qb->getQuery()->getResult();
            $juegos = array();
            foreach ($arJuegosJugadores as $arJuegoJugador) {
                $qb = $em->createQueryBuilder();
                $qb->from(Comentario::class, "c")
                    ->select("c.codigoComentarioPk as codigo_comentario")
                    ->addSelect("c.fecha")
                    ->addSelect("c.comentario")
                    ->addSelect("u.seudonimo as usuario_seudonimo")
                    ->leftJoin("c.usuarioRel", "u")
                    ->where("c.codigoJuegoFk ={$arJuegoJugador['codigo_juego']}")
                ->orderBy("c.fecha", "ASC")
                ->setMaxResults(2);
                $arComentarios = $qb->getQuery()->getResult();

                $juegos = [
                    'codigo_juego_detalle' => $arJuegoJugador['codigo_juego_detalle'],
                    'codigo_juego' => $arJuegoJugador['codigo_juego'],
                    'juego_nombre' => $arJuegoJugador['juego_nombre'],
                    'juego_jugadores' => $arJuegoJugador['juego_jugadores'],
                    'juego_jugadores_confirmados' => $arJuegoJugador['juego_jugadores_confirmados'],
                    'juego_fecha' => $arJuegoJugador['juego_fecha'],
                    'juego_acceso' => $arJuegoJugador['juego_acceso'],
                    'escenario_nombre' => $arJuegoJugador['escenario_nombre'],
                    'negocio_nombre' => $arJuegoJugador['negocio_nombre'],
                    'usuario_administrador_seudonimo' => $arJuegoJugador['usuario_administrador_seudonimo'],
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

}
