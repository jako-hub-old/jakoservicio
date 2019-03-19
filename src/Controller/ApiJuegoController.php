<?php

namespace App\Controller;
use App\Classes\Utilidades;
use App\Entity\Juego;
use App\Entity\Usuario;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiJuegoController
 * @package App\Controller}
 */
class ApiJuegoController extends FOSRestController {

    /**
     * @return array
     * @Rest\Post("/v1/juego/listajugador")
     */
    public function listaJugador(Request $request) {
        try {
            $raw = json_decode($request->getContent(), true);
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository(Juego::class)->listaJugador($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }


}