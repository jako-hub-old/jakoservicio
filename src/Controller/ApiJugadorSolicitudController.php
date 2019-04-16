<?php

namespace App\Controller;
use App\Classes\Utilidades;
use App\Entity\Juego;
use App\Entity\Jugador;
use App\Entity\JugadorSolicitud;
use App\Entity\Usuario;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiJugadorSolicitudController
 * @package App\Controller}
 */
class ApiJugadorSolicitudController extends FOSRestController {

    /**
     * @return array
     * @Rest\Post("/v1/jugador/solicitud/pendiente")
     */
    public function jugador(Request $request) {
        try {
            $raw = json_decode($request->getContent(), true);
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository(JugadorSolicitud::class)->pendiente($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }

    /**
     * @return array
     * @Rest\Post("/v1/jugador/solicitud/nuevo")
     */
    public function nuevo(Request $request) {
        try {
            $raw = json_decode($request->getContent(), true);
            $em = $this->getDoctrine()->getManager();
            $respuesta = $em->getRepository(JugadorSolicitud::class)->nuevo($raw);
            if(isset($respuesta['codigo_jugador'])) {
                $titulo = "Solicitud de amistad";
                $mensaje = $respuesta['jugador_seudonimo'] . " quiere ser tu amigo";
                $this->get('notificacion')->notificarA($respuesta['codigo_jugador'], $titulo, $mensaje, [
                    'type'      => 'friend-request',
                    'path_data' => $respuesta['codigo_jugador'],
                    'action'    => 'yes',
                ]);
            }
            return $respuesta;
        } catch (\Exception $e) {
            return [
                'mensaje' => $e->getMessage(),
                'linea' => $e->getLine(),
                'error' => true,
            ];
        }
    }

    /**
     * @return array
     * @Rest\Post("/v1/jugador/solicitud/respuesta")
     */
    public function respuesta(Request $request) {
        try {
            $raw = json_decode($request->getContent(), true);
            $em = $this->getDoctrine()->getManager();
            $respuesta = $em->getRepository(JugadorSolicitud::class)->respuesta($raw);
            if(is_array($respuesta) && isset($respuesta['notificar'])) {
                $titulo = "Nuevo amigo";
                $mensaje = "Tu y " . $respuesta['jugador_seudonimo'] . " ahora son amigos";
                $this->get('notificacion')->notificarA($respuesta['codigo_jugador'], $titulo, $mensaje, [
                    'type'      => 'friend-request',
                    'path_data' => $respuesta['codigo_jugador'],
                    'action'    => 'yes',
                ]);
            }
            return $respuesta;
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }

}