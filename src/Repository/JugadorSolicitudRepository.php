<?php

namespace App\Repository;

use App\Classes\Utilidades;
use App\Entity\Jugador;
use App\Entity\JugadorAmigo;
use App\Entity\JugadorSolicitud;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class JugadorSolicitudRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, JugadorSolicitud::class);
    }

    public function pendiente($datos)
    {
        $em = $this->getEntityManager();
        $jugador = $datos['jugador']?? false;
        $tipo = $datos['tipo']?? false;
        if($jugador && $tipo) {
            $qb = $em->createQueryBuilder();
            if($tipo == 'responder') {
                $qb->from(JugadorSolicitud::class, "js")
                    ->select("js.codigoJugadorSolicitudPk as codigo_jugador_solicitud")
                    ->addSelect("j.nombreCorto as jugador_nombre_corto")
                    ->addSelect("j.seudonimo as jugador_seudonimo")
                    ->leftJoin("js.jugadorRel", "j")
                    ->where("js.codigoJugadorSolicitudFk = {$jugador}")
                    ->andWhere("js.estadoRespuesta = 0");
            } else {
                $qb->from(JugadorSolicitud::class, "js")
                    ->select("js.codigoJugadorSolicitudPk as codigo_jugador_solicitud")
                    ->addSelect("j.nombreCorto as jugador_nombre_corto")
                    ->addSelect("j.seudonimo as jugador_seudonimo")
                    ->leftJoin("js.jugadorSolicitudRel", "j")
                    ->where("js.codigoJugadorFk = {$jugador}")
                    ->andWhere("js.estadoRespuesta = 0");
            }

            $arJugadores =  $qb->getQuery()->getResult();
            return $arJugadores;
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

    public function nuevo($datos)
    {
        $em = $this->getEntityManager();
        $jugador = $datos['jugador']?? false;
        $jugadorDestino = $datos['jugador_destino']?? false;
        if($jugador && $jugadorDestino) {
            $arJugadorSolicitud = $em->getRepository(JugadorSolicitud::class)->findOneBy(["codigoJugadorFk" => $jugador, "codigoJugadorSolicitudFk" => $jugadorDestino]);
            if(!$arJugadorSolicitud) {
                $arJugador = $em->getRepository(Jugador::class)->find($jugador);
                $arJugadorDestino = $em->getRepository(Jugador::class)->find($jugadorDestino);
                $arJugadorSolicitud = new JugadorSolicitud();
                $arJugadorSolicitud->setJugadorRel($arJugador);
                $arJugadorSolicitud->setJugadorSolicitudRel($arJugadorDestino);
                $em->persist($arJugadorSolicitud);
                $em->flush();
                return true;
            } else {
                return [
                    'validacion' => Utilidades::validacion(7),
                ];
            }
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

    public function respuesta($datos)
    {
        $em = $this->getEntityManager();
        $solicitud = $datos['solicitud']?? false;
        $respuesta = $datos['respuesta']?? false;
        if($solicitud && $respuesta) {
            $arJugadorSolicitud = $em->getRepository(JugadorSolicitud::class)->find($solicitud);
            if(!$arJugadorSolicitud->getEstadoRespuesta()) {
                $arJugadorSolicitud->setEstadoRespuesta(1);
                if($respuesta == "s") {
                    $arJugadorSolicitud->setEstadoAceptado(1);
                    $arJugadorAmigo = new JugadorAmigo();
                    $arJugadorAmigo->setJugadorRel($arJugadorSolicitud->getJugadorRel());
                    $arJugadorAmigo->setJugadorAmigoRel($arJugadorSolicitud->getJugadorSolicitudRel());
                    $em->persist($arJugadorAmigo);
                    $arJugadorAmigo = new JugadorAmigo();
                    $arJugadorAmigo->setJugadorRel($arJugadorSolicitud->getJugadorSolicitudRel());
                    $arJugadorAmigo->setJugadorAmigoRel($arJugadorSolicitud->getJugadorRel());
                    $em->persist($arJugadorAmigo);
                } else {
                    $arJugadorSolicitud->setEstadoAceptado(0);
                }
                $em->persist($arJugadorSolicitud);
                $em->flush();
                return true;
            } else {
                return [
                    'validacion' => Utilidades::validacion(8),
                ];
            }
        } else {
            return [
                'error_controlado' => Utilidades::error(2),
            ];
        }
    }

}
