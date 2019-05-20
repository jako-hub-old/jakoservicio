<?php

namespace App\Controller;
use App\Entity\Interes;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiEscenarioController
 * @package App\Controller}
 */
class ApiInteresController extends FOSRestController {

    /**
     * @return array
     * @Rest\Post("/v1/interes/lista")
     */
    public function lista() {
        try {
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository(Interes::class)->lista();
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }

    /**
     * @return array
     * @Rest\Post("/v1/interes/jugador")
     * @param Request $request
     */
    public function jugador(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Interes::class)->jugador($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }

    /**
     * @return array
     * @Rest\Post("/v1/interes/jugador/actualizar")
     * @param Request $request
     */
    public function jugadorActualizar(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Interes::class)->jugadorActualizar($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }

}