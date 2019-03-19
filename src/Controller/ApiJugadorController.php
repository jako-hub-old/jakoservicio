<?php

namespace App\Controller;
use App\Classes\Utilidades;
use App\Entity\Juego;
use App\Entity\Jugador;
use App\Entity\Usuario;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiJugadorController
 * @package App\Controller}
 */
class ApiJugadorController extends FOSRestController {

    /**
     * @return array
     * @Rest\Post("/v1/jugador/amigos")
     */
    public function amigos(Request $request) {
        try {
            $raw = json_decode($request->getContent(), true);
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository(Jugador::class)->amigos($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }

}