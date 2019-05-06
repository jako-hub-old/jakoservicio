<?php
/**
 * Created by PhpStorm.
 * User: alejandro
 * Date: 24/04/19
 * Time: 08:43 PM
 */

namespace App\Classes;


use App\Entity\Invitado;
use App\Entity\Jugador;
use Doctrine\ORM\EntityManager;
use phpDocumentor\Reflection\Types\String_;

class MensajeTexto
{
    private $em;
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function invitarAInstalar($jugador, $telefonos) {
        $em = $this->em;
        $arJugador = $em->getRepository(Jugador::class)->find($jugador);
        if(!$arJugador) return false;
        $nombre = $arJugador->getNombreCorto();
        $url = getenv("URL_APP_INSTALATION");
        $mensaje = "Tu amigo {$nombre} esta organizando un juego y te quiere invitar, unete a Jako {$url}";
        foreach ($telefonos as $telefono) {
            $arInvitado = new Invitado();
            $arInvitado->setJugadorRel($arJugador);
            $arInvitado->setTelefonoInvitado($telefono);
            $arInvitado->setFechaEnviado(new \DateTime("now"));
            $em->persist($arInvitado);
            $this->enviarMensajeDeTexto($telefono, $mensaje);
        }
        $em->flush();
        return true;
    }

    public function enviarMensajeDeTexto($telefono, $mensaje) {
        $basic  = new \Nexmo\Client\Credentials\Basic(getenv('NEXMO_KEY'), getenv('NEXMO_SECRET'));
        $client = new \Nexmo\Client($basic);
        if(strlen($telefono) > 10) {
            $telefono = strrev(substr(strrev($telefono), 0, 10));
        }
        $message = $client->message()->send([
            'to' => "57{$telefono}",
            'from' => 'Jako App',
            'text' => $mensaje,
        ]);
    }
}