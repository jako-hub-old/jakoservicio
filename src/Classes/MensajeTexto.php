<?php
/**
 * Created by PhpStorm.
 * User: alejandro
 * Date: 24/04/19
 * Time: 08:43 PM
 */

namespace App\Classes;


use App\Entity\Jugador;
use Doctrine\ORM\EntityManager;

class MensajeTexto
{
    private $em;
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function invitarAInstalar($jugador, $telefonos) {
        $arJugador = $this->em->getRepository(Jugador::class)->find($jugador);
        if(!$arJugador) return false;
        $nombre = $arJugador->getNombreCorto();
        $url = getenv("URL_APP_INSTALATION");
        $mensaje = "Tu amigo {$nombre} te ha invitado a que pruebes Jako {$url}";
        foreach ($telefonos as $telefono) {
            $this->enviarMensajeDeTexto($telefono, $mensaje);
        }
        return true;
    }

    public function enviarMensajeDeTexto($telefono, $mensaje) {
        $basic  = new \Nexmo\Client\Credentials\Basic(getenv('NEXMO_KEY'), getenv('NEXMO_SECRET'));
        $client = new \Nexmo\Client($basic);
        $message = $client->message()->send([
            'to' => "57{$telefono}",
            'from' => 'Jako App',
            'text' => $mensaje,
        ]);
    }
}