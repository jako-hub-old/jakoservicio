<?php

namespace App\Controller;
use App\Classes\Utilidades;
use App\Entity\Escenario;
use App\Entity\Juego;
use App\Entity\Jugador;
use App\Entity\Reserva;
use App\Entity\Usuario;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiEscenarioController
 * @package App\Controller}
 */
class ApiReservaController extends FOSRestController {

    /**
     * @return array
     * @Rest\Post("/v1/reserva/nuevo")
     */
    public function nuevo(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Reserva::class)->nuevo($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }

}