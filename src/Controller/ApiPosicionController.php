<?php

namespace App\Controller;
use App\Classes\Utilidades;
use App\Entity\Escenario;
use App\Entity\Juego;
use App\Entity\Jugador;
use App\Entity\Posicion;
use App\Entity\Usuario;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiPosicionController
 * @package App\Controller}
 */
class ApiPosicionController extends FOSRestController {

    /**
     * @return array
     * @Rest\Post("/v1/posicion/lista")
     */
    public function lista(Request $request) {
        try {
            $raw = json_decode($request->getContent(), true);
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository(Posicion::class)->lista($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }


}