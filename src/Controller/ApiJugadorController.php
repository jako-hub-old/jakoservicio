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

    /**
     * @return array
     * @Rest\Post("/v1/jugador/buscar")
     */
    public function buscar(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository(Jugador::class)->buscar();
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }

    /**
     * @param Request $request
     * @Rest\Post("/v1/jugador/informacion/complementaria")
     * @return array|mixed
     */
    public function guardarPseudonimo(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Jugador::class)->informacionComplementaria($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }

    /**
     * @return array
     * @Rest\Post("/v1/jugador/detalle")
     */
    public function detalle(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Jugador::class)->detalle($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }

}