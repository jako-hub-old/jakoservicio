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

    /**
     * @return array
     * @Rest\Post("/v1/reserva/escenario")
     */
    public function escenario(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Reserva::class)->escenario($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }

    /**
     * Este endpoint permite validar si un escenario está ya reservado
     * para determinada hora
     * data : {
     *      "escenario" : 1,
     *      "desde" : "yyyy-mm-dd h:i:s",
     *      "hasta" : "yyyy-mm-dd h:i:s"
     * }
     * @Rest\Post("/v1/reserva/validar")
     */
    public function validarReserva(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Reserva::class)
                        ->validarDisponibilidad(
                            $raw['desde']?? null,
                            $raw['hasta']?? null,
                            $raw['escenario']?? 0
                        );
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }

}