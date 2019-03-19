<?php

namespace App\Controller;
use App\Classes\Utilidades;
use App\Entity\Usuario;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiUsuariosController
 * @package App\Controller}
 */
class ApiUsuarioController extends FOSRestController {

    /**
     * @return array
     * @Rest\Post("/v1/usuario/lista")
     */
    public function lista(Request $request) {
        try {
            $raw = json_decode($request->getContent(), true);
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository(Usuario::class)->lista($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }

    /**
     * @return array
     * @Rest\Post("/v1/usuario/nuevo")
     */
    public function nuevo(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Usuario::class)->nuevo($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }


    /**
     * @return array
     * @Rest\Post("/v1/usuario/validar")
     */
    public function validar(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Usuario::class)->validar($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }
}