<?php

namespace App\Controller;
use App\Classes\Utilidades;
use App\Entity\Escenario;
use App\Entity\Juego;
use App\Entity\Jugador;
use App\Entity\Negocio;
use App\Entity\Usuario;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiEscenarioController
 * @package App\Controller}
 */
class ApiNegocioController extends FOSRestController {

    /**
     * @return array
     * @Rest\Post("/v1/negocio/buscar")
     */
    public function lista(Request $request) {
        try {
            $raw = json_decode($request->getContent(), true);
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository(Negocio::class)->buscar($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }

}