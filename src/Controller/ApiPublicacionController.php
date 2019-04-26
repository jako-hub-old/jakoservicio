<?php

namespace App\Controller;
use App\Classes\Utilidades;
use App\Entity\Juego;
use App\Entity\Publicacion;
use App\Entity\Usuario;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiPublicacionController
 * @package App\Controller}
 */
class ApiPublicacionController extends FOSRestController {

    /**
     * @return array
     * @Rest\Post("/v1/publicacion/lista")
     */
    public function lista(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Publicacion::class)->lista($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }

    /**
     * @return array
     * @Rest\Post("/v1/publicacion/jugador")
     */
    public function jugador(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Publicacion::class)->jugador($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }

}