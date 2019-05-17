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
 * Class ApiJuegoController
 * @package App\Controller}
 */
class ApiJuegoController extends FOSRestController {

    /**
     * @return array
     * @Rest\Post("/v1/juego/nuevo")
     */
    public function nuevo(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            $respuesta = $em->getRepository(Juego::class)->nuevo($raw);
            if(isset($respuesta['codigo_juego'])) {
                $titulo = "Nuevo juego";
                $mensaje = $respuesta['jugador_seudonimo'] . " ha creado un juego";
                if(isset($raw['invitar_amigos'])) {
                    $this->get('notificacion')->notificarAmigos($raw['jugador'], $titulo, $mensaje, [
                        'type'      => 'new-game',
                        'path_data' => $respuesta['codigo_juego'],
                        'action'    => 'yes',
                    ]);
                }
            }
            return $respuesta;
        } catch (\Exception $e) {
            return [
                'error' => true,
                'mensaje' => $e->getMessage(),
            ];
        }
    }

    /**
     * @return array
     * @Rest\Post("/v1/juego/buscar")
     */
    public function buscar(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Juego::class)->buscar($raw);
        } catch (\Exception $e) {
            return [
                'message' => $e->getMessage(),
                'error' => true,
            ];
        }
    }

    /**
     * @return array
     * @Rest\Post("/v1/juego/detalle")
     */
    public function detalle(Request $request) {
        try {
            $raw = json_decode($request->getContent(), true);
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository(Juego::class)->detalle($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }

    /**
     * @return array
     * @Rest\Post("/v1/juego/jugador")
     */
    public function jugador(Request $request) {
        try {
            $raw = json_decode($request->getContent(), true);
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository(Juego::class)->jugador($raw);
        } catch (\Exception $e) {
            return [
                'message' => $e->getMessage(),
                'error' => true,
            ];
        }
    }

    /**
     * @return array
     * @Rest\Post("/v1/juego/unir")
     */
    public function unir(Request $request) {
        try {
            $raw = json_decode($request->getContent(), true);
            $em = $this->getDoctrine()->getManager();
            $respuesta = $em->getRepository(Juego::class)->unir($raw);
            if($respuesta['codigo_juego'] && isset($respuesta['completo'])){
                $titulo = "¡Tu juego está completo!";
                $mensaje = $respuesta['jugador_seudonimo'] . " ya se han unido todos los jugadores";
                $this->get('notificacion')->notificarA($respuesta['codigo_jugador'], $titulo, $mensaje, [
                    'type'      => 'new-game',
                    'path_data' => $respuesta['codigo_juego'],
                    'action'    => 'yes',
                ]);
                $fecha = $respuesta['fecha']?? '';
                $mensaje2 = "Prepárate para tu juego el {$fecha}";
                $this->get('notificacion')->notificarAMiembrosJuego($respuesta['codigo_juego'], "!Juego completo!", $mensaje2, [
                    'type'      => 'new-game',
                    'path_data' => $respuesta['codigo_juego'],
                    'action'    => 'yes',
                ]);
            }
            return $respuesta;
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * @return array
     * @Rest\Post("/v1/juego/retirar")
     */
    public function retirar(Request $request) {
        try {
            $raw = json_decode($request->getContent(), true);
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository(Juego::class)->retirar($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }

    /**
     * @return array
     * @Rest\Post("/v1/juego/invitar")
     */
    public function invitar(Request $request) {
        try {
            $raw = json_decode($request->getContent(), true);
            $em = $this->getDoctrine()->getManager();
            $respuesta = $em->getRepository(Juego::class)->invitar($raw);
            if(is_array($respuesta) && $respuesta['codigo_juego'] && $respuesta['jugador_seudonimo']) {
                $jugador = $respuesta['jugador_seudonimo'];
                $titulo = "¿Quieres jugar?";
                $mensaje = "{$jugador} Te invita a hacer parte de un juego";
                $this->get('notificacion')->notificarAJugadores($raw['jugadores']?? [], $titulo, $mensaje, [
                    'type'      => 'game-invitation',
                    'path_data' => $respuesta['codigo_juego'],
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

    /**
     * @return array
     * @Rest\Post("/v1/juego/cerrar")
     */
    public function cerrar(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Juego::class)->cerrar($raw);
        } catch (\Exception $e) {
            return [
                'message' => $e->getMessage(),
                'error' => true,
            ];
        }
    }

    /**
     * @return array
     * @Rest\Post("/v1/juego/compartir/amigos")
     */
    public function compartir(Request $request) {
        try {
            $raw = json_decode($request->getContent(), true);
            $em = $this->getDoctrine()->getManager();
            if($raw['juego'] && $raw['jugador']) {
                $titulo = "¿Quieres jugar?";
                $arJugador = $em->getRepository(Jugador::class)->find($raw['jugador']);
                $mensaje = $arJugador->getSeudonimo()  . " te invita a su juego";
                $this->get('notificacion')->notificarAmigos($raw['jugador'], $titulo, $mensaje, [
                    'type'      => 'new-game',
                    'path_data' => $raw['juego'],
                    'action'    => 'yes',
                ]);
            }
            return true;
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }

    /**
     * @return array
     * @Rest\Post("/v1/juego/invitaciones")
     */
    public function invitaciones(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Juego::class)->invitaciones($raw);
        } catch (\Exception $e) {
            return [
                'message' => $e->getMessage(),
                'error' => true,
            ];
        }
    }

    /**
     * @return array
     * @Rest\Post("/v1/juego/invitaciones/rechazar")
     */
    public function rechazarInvitacion(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Juego::class)->rechazarInvitacion($raw);
        } catch (\Exception $e) {
            return [
                'message' => $e->getMessage(),
                'error' => true,
            ];
        }
    }

}