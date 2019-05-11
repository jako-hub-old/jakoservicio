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
use App\Entity\Publicacion;
use Doctrine\ORM\EntityManager;
use phpDocumentor\Reflection\Types\String_;

class Publicador
{
    const TIPO_JUEGO = 'JUE';
    const TIPO_NOTICIA = 'NOT';

    private $em;
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function publicarNoticia($texto, $tipo, $jugadorRel=null, $juegoRel=null, $plataforma=false, $personal=false) {
        try {
            $em = $this->em;
            $arPublicacion = new Publicacion();
            $arPublicacion->setTipo($tipo);
            $arPublicacion->setFecha(new \DateTime("now"));
            $arPublicacion->setTexto($texto);
            $arPublicacion->setJugadorRel($jugadorRel);
            $arPublicacion->setJuegoRel($juegoRel);
            $arPublicacion->setPlataforma($plataforma);
            $arPublicacion->setPersonal($personal);
            $em->persist($arPublicacion);
            $em->flush();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}