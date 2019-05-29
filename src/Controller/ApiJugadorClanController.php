<?php

namespace App\Controller;

use App\Entity\JugadorClan;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ApiJugadorClanController extends FOSRestController
{
    /**
     * @Rest\Post("/v1/jugador/clanes")
     * @param Request $request
     * @return array
     */
    public function clanesJugador(Request $request){
        try{
            $em  = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(JugadorClan::class)->clanesJugador($raw);
        } catch (\Exception $e){
            return [
                'error' => true,
                'mensaje' => $e->getMessage(),
            ];
        }
    }

    /**
     * @Rest\Post("/v1/jugador/clanes/rivales")
     * @param Request $request
     * @return array|bool
     */
    public function clanesRivales(Request $request){
        try{
            $em  = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(JugadorClan::class)->clanesRivales($raw);
        } catch (\Exception $e){
            return [
                'error' => true,
                'mensaje' => $e->getMessage(),
            ];
        }
    }

    /**
     * @Rest\Post("/v1/jugadores/clan")
     * @param Request $request
     * @return array
     */
    public function jugadoresClan(Request $request){
        try{
            $em  = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(JugadorClan::class)->jugadoresClan($raw);
        } catch (\Exception $e){
            return [
                'error' => true,
                'mensaje' => $e->getMessage(),
            ];
        }
    }
}
