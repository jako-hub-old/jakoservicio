<?php

namespace App\Controller;
use App\Entity\Interes;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

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

}