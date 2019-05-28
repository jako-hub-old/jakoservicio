<?php

namespace App\Controller;
use App\Entity\Clan;
use App\Entity\JuegoTipo;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiJuegoTipoController
 * @package App\Controller
 * @author Jorge Alejandro Quiroz Serna <jakop.box@gmail.com>
 */
class ApiJuegoTipoController extends FOSRestController {

    /**
     * @return array
     * @Rest\Post("/v1/juego/tipo/lista")
     */
    public function lista() {
        try {
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository(JuegoTipo::class)->lista();
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }
}