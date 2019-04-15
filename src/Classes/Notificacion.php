<?php

namespace App\Classes;


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
        foreach ($arrAmigos as $amigo) {
            if(!$token = $amigo['fcmToken']) continue;
            $log[$jugador] = $this->enviarNotificacion($token, $titulo, $mensaje, $datos);
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