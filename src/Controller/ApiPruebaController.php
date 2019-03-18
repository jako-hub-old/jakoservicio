<?php

namespace App\Controller;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiPruebaController
 * @package App\Controller}
 */
class ApiPruebaController extends FOSRestController {

    /**
     * @return array
     * @Rest\Get("/v1/prueba")
     */
    public function prueba(Request $request) {
        try {
            return ['prueba' => "Prueba de capa controladora"];
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }
}