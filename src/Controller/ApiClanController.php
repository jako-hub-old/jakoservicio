<?php

namespace App\Controller;
use App\Entity\Clan;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiEscenarioController
 * @package App\Controller
 * @author Jorge Alejandro Quiroz Serna <jakop.box@gmail.com>
 */
class ApiClanController extends FOSRestController {

    /**
     * @return array
     * @Rest\Post("/v1/clan/lista")
     */
    public function lista() {
        try {
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository(Clan::class)->lista();
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * @return array
     * @Rest\Post("/v1/clan/admin")
     * @param Request $request
     */
    public function admin(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Clan::class)->admin($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }


    /**
     * @return array
     * @Rest\Post("/v1/clan/jugador")
     * @param Request $request
     */
    public function jugador(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Clan::class)->jugador($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }

    /**
     * @param Request $request
     * @Rest\Post("/v1/clan/nuevo")
     * @return array
     */
    public function nuevo(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Clan::class)->nuevo($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'mensaje' => $e->getMessage(),
            ];
        }
    }

    /**
     * @param Request $request
     * @return array|mixed
     * @Rest\Post("/v1/clan/detalle")
     */
    public function detalle(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Clan::class)->detalle($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'mensaje' => $e->getMessage(),
            ];
        }
    }
}