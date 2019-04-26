<?php

namespace App\Classes;


use App\Entity\Juego;
use App\Entity\JuegoDetalle;
use App\Entity\Jugador;
use App\Entity\JugadorAmigo;
use App\Entity\Usuario;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;

class Notificacion
{
    private $em;
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function notificarAmigos($jugador, $titulo="Notificación", $mensaje="", $datos=[]) {
        $em = $this->em;
        $arJugador = $em->getRepository(Jugador::class)->find($jugador);
        if(!$arJugador) return false;
        $arrAmigos = $em->getRepository(JugadorAmigo::class)->getAmigosJugador($jugador);
        $log = [];
        $tokens = [];

        foreach ($arrAmigos as $amigo) {
            $token = $amigo['fcmToken'];
            if(empty($token) || in_array($token, $tokens)) continue;
            $log[$jugador] = $this->enviarNotificacion($token, $titulo, $mensaje, $datos);
            $tokens[] = $amigo['fcmToken'];
        }
        return $log;
    }

    public function notificarA($jugador, $titulo="Notificación", $mensaje="", $datos=[]) {
        $em = $this->em;
        $arUsuario = $em->getRepository(Usuario::class)->find($jugador);
        if(!$arUsuario) return false;
        $token = $arUsuario->getFcmToken();
        return $this->enviarNotificacion($token, $titulo, $mensaje, $datos);
    }

    public function notificarAJugadores($jugadores=[], $titulo, $mensaje, $datos) {
        $qb = $this->em->createQueryBuilder();
        $ids = implode(',', $jugadores);
        $qb->from(Jugador::class, "j")
            ->select("j")
            ->where("j.codigoJugadorPk IN ({$ids})");
        $arrJugadores = $qb->getQuery()->getResult();
        foreach ($arrJugadores as $arJugador) {
            $arUsuario = $arJugador->getUsuariosJugadorRel()[0];
            $token = $arUsuario->getFcmToken();
            $this->enviarNotificacion($token, $titulo, $mensaje, $datos);
        }
    }

    public function notificarAMiembrosJuego($juego, $titulo, $mensaje, $datos) {
        $em = $this->em;
        $arJuego = $em->getRepository(Juego::class)->find($juego);
        if(!$arJuego) return false;
        /**
         * @var $detalles JuegoDetalle[]
         */
        $detalles= $arJuego->getJuegosDetallesJuegoRel();
        foreach ($detalles as $detalle) {
            $arJugador = $detalle->getJugadorRel();
            $arUsuario = $arJugador->getUsuariosJugadorRel()[0];
            $token = $arUsuario->getFcmToken();
            $this->enviarNotificacion($token, $titulo, $mensaje, $datos);
        }
        return true;
    }

    public function enviarNotificacion($token, $titulo, $mensaje, $datos) {
        try {
            $payload = [
                'token' => $token,
                'title' => $titulo,
                'message' => $mensaje,
                'data' => $datos,
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, getenv("FIREBASE_CLOUD_MESSAGING_FUNCTION"));
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            return $response;
        } catch (\Exception $exception) {
            return false;
        }
    }
}