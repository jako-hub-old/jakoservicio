<?php

namespace App\Classes;


use App\Entity\Jugador;
use App\Entity\JugadorAmigo;
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
        foreach ($arrAmigos as $amigo) {
            if(!$token = $amigo['fcmToken']) continue;
            $this->enviarNotificacion($token, $titulo, $mensaje, $datos);
        }
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
            curl_exec($ch);
            curl_close($ch);
        } catch (\Exception $exception) {
            return false;
        }
    }
}