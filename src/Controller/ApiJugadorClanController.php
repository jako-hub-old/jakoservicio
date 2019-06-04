<?php

namespace App\Controller;

use App\Entity\JugadorClan;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ApiJugadorClanController extends FOSRestController
{
    /**
     * Función utilizada para listar los jugadores por clan
     * Recibe como parámetro por body (clan)
     * @Rest\Post("/v1/clan/jugadores")
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
