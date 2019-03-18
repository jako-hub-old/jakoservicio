<?php

/**
 * Created by PhpStorm.
 * User: desarrollo
 * Date: 17/03/19
 * Time: 06:58 PM
 */

namespace App\Controller;
use App\Entity\Usuario;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiUsuariosController
 * @package App\Controller}
 */
class ApiUsuariosController extends FOSRestController {

    /**
     * @return array
     * @Rest\Post("/v1/usuario/listar")
     */
    public function lista(Request $request) {
        try {
            $raw = json_decode($request->getContent(), true);
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository(Usuarioa::class)->lista($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }

    /**
     * @return array
     * @Rest\Post("/v1/usuario/registrar")
     */
    public function registrar(Request $request) {
        try {
            $raw = json_decode($request->getContent(), true);
            $em = $this->getDoctrine()->getManager();
            $usuarioExiste = $em->getRepository(Usuario::class)->validarUsuarioExistente();
            if(!$usuarioExiste) {
                return $em->getRepository(Usuarioa::class)->registrar($raw);
            } else {
                return [
                    'validacion' => Utils::validacion('1'),
                ];
            }

        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }
}