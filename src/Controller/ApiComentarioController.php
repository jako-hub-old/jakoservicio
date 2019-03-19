<?php

namespace App\Controller;
use App\Classes\Utilidades;
use App\Entity\Comentario;
use App\Entity\Usuario;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiUsuariosController
 * @package App\Controller}
 */
class ApiComentarioController extends FOSRestController {

    /**
     * @return array
     * @Rest\Post("/v1/comentario/nuevo")
     */
    public function nuevo(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Comentario::class)->nuevo($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }


}