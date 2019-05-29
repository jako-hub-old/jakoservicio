<?php

namespace App\Controller;
use App\Classes\ManejadorDeArchivos;
use App\Classes\Utilidades;
use App\Entity\Clan;
use App\Entity\Jugador;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiEscenarioController
 * @package App\Controller
 * @author Jorge Alejandro Quiroz Serna <jakop.box@gmail.com>
 */
class ApiClanController extends FOSRestController {

    /**
     * @return array
     * @Rest\Post("/v1/clan/buscar")
     */
    public function buscar() {
        try {
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository(Clan::class)->buscar();
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * @return array
     * @Rest\Post("/v1/clan/admin")
     * @param Request $request
     */
    public function admin(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Clan::class)->admin($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }


    /**
     * @return array
     * @Rest\Post("/v1/clan/jugador")
     * @param Request $request
     */
    public function jugador(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Clan::class)->jugador($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }

    /**
     * @param Request $request
     * @Rest\Post("/v1/clan/nuevo")
     * @return array
     */
    public function nuevo(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            // $raw = json_decode($request->getContent(), true);
            $raw = [
                'jugador'       => $request->get('jugador'),
                'tipo_juego'    => $request->get('tipo_juego'),
                'nombre'        => $request->get('nombre'),
                'jugador'       => $request->get('jugador'),
            ];
            $datosImagen = $this->guardarImagenClan($raw['nombre']);
            if($datosImagen === false) {
               return [
                   'error_controlado' => Utilidades::error(6),
               ];
            } else {
                $raw['url_imagen'] = $datosImagen['url']?? null;
                $raw['url_miniatura'] = $datosImagen['url_miniatura']?? null;
            }
            return $em->getRepository(Clan::class)->nuevo($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'mensaje' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ];
        }
    }

    /**
     * Esta función permite guardar la imagen de los clanes y generar una imagen miniatura de la misma.
     * @author Jorge Alejandro Quiroz Serna <jakop.box@gmail.com>
     * @param $codigoJugador
     * @return array|bool
     */
    private function guardarImagenClan($nombreClan) {
        $dirFotos = '/fotos_clanes';
        $directorioDestino = realpath(ManejadorDeArchivos::getDirectorioPublico()) . $dirFotos;
        if(!file_exists($directorioDestino)) {
            mkdir($directorioDestino);
        }
        $imagen = ManejadorDeArchivos::get('foto');
        if($imagen !== false && $imagen->esValido()) {
            $ext = $imagen->getExtension();
            $tiempo = time();
            $nombreImagen = "foto_clan_{$nombreClan}_$tiempo";
            $guardado = $imagen->guardar($directorioDestino, $nombreImagen, true);
            $urlImagen = "{$dirFotos}/{$nombreImagen}.{$ext}";

            if($guardado) {
                $origenImagen = "{$directorioDestino}/{$nombreImagen}.{$ext}";
                $urlMiniatura = "{$dirFotos}/" . Utilidades::get()
                                        ->generarImagenMiniatura(
                                            $origenImagen,
                                            $nombreImagen,
                                            $directorioDestino,
                                            100,
                                            "jpg"
                                        );
                return [
                    'url'           => $urlImagen,
                    'url_miniatura' => $urlMiniatura,
                ];
            } else {
                return false;
            }
        }
    }

    /**
     * @param Request $request
     * @return array|mixed
     * @Rest\Post("/v1/clan/detalle")
     */
    public function detalle(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Clan::class)->detalle($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'mensaje' => $e->getMessage(),
            ];
        }
    }

    /**
     * @Rest\Post("/v1/clan/invitar/amigos")
     */
    public function invitarAmigos(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            $respuesta = $em->getRepository(Clan::class)->invitarJugadores($raw);
            if (isset($respuesta['notificar_jugadores'])) {
                $jugador = $respuesta['jugador_seudonimo'];
                $titulo = "Invitación a clan";
                $mensaje = "{$jugador} Te invita a hacer parte de su clan";
                $this->get('notificacion')->notificarAJugadores($respuesta['notificar_jugadores'] ?? [], $titulo, $mensaje, [
                    'type'      => 'clan-invitation',
                    'path_data' => $respuesta['codigo_clan'],
                    'action'    => 'yes',
                ]);
                return true;
            } else {
                return $respuesta;
            }
        } catch (\Exception $e) {
            return [
                'error' => true,
                'mensaje' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
        }
    }

    /**
     * @Rest\Post("/v1/clan/invitaciones")
     */
    public function listarInvitaciones(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Clan::class)->listarInvitacionesJugador($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'mensaje' => $e->getMessage(),
            ];
        }
    }

    /**
     * @Rest\Post("/v1/clan/invitacion/aceptar")
     * @param Request $request
     * @return array|mixed
     */
    public function aceptarInvitacion(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Clan::class)->aceptarInvitacion($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'mensaje' => $e->getMessage(),
            ];
        }
    }

    /**
     * @Rest\Post("/v1/clan/invitacion/rechazar")
     * @param Request $request
     * @return array|mixed
     */
    public function cancelarInvitacion(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Clan::class)->rechazarInvitacion($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'mensaje' => $e->getMessage(),
            ];
        }
    }

    /**
     * @Rest\Post("/v1/clan/invitacion/aprobar")
     * @param Request $request
     * @return array|mixed
     */
    public function aprobarSolicitud(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Clan::class)->aprobarSolicitud($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'mensaje' => $e->getMessage(),
            ];
        }
    }

    /**
     * @param Request $request
     * @return array|mixed
     * @Rest\Post("/v1/clan/unirse")
     */
    public function unirse(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Clan::class)->unirse($raw, $this->get('notificacion'));
        } catch (\Exception $e) {
            return [
                'error' => true,
                'mensaje' => $e->getMessage(),
            ];
        }
    }

    /**
     * @param Request $request
     * @return array|mixed
     * @Rest\Post("/v1/clan/solicitudes/enviadas")
     */
    public function solicitudesAClan(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Clan::class)->solicitudesEnviadas($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'mensaje' => $e->getMessage(),
            ];
        }
    }

    /**
     * @param Request $request
     * @return array|mixed
     * @Rest\Post("/v1/clan/solicitudes/recibidas")
     */
    public function solicitudesRecibidas(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Clan::class)->solicitudesRecibidas($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'mensaje' => $e->getMessage(),
            ];
        }
    }

    /**
     * @param Request $request
     * @return array|mixed
     * @Rest\Post("/v1/clan/solicitudes/rechazar")
     * @Rest\Post("/v1/clan/solicitudes/cancelar")
     */
    public function rechazarSolicitud(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Clan::class)->cancelarSolicitud($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'mensaje' => $e->getMessage(),
            ];
        }
    }

    /**
     * @param Request $request
     * @return array|mixed
     * @Rest\Post("/v1/clan/abandonar")
     */
    public function abandonar(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Clan::class)->abandonar($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'mensaje' => $e->getMessage(),
            ];
        }
    }

    /**
     * @Rest\Post("/v1/clanes/jugador")
     * @param Request $request
     * @return array
     */
    public function clanesJugador(Request $request){
        try{
            $em  = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Clan::class)->clanesJugador($raw);
        } catch (\Exception $e){
            return [
                'error' => true,
                'mensaje' => $e->getMessage(),
            ];
        }
    }

    /**
     * @Rest\Post("/v1/clanes/rivales")
     * @param Request $request
     * @return array|bool
     */
    public function clanesRivales(Request $request){
        try{
            $em  = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Clan::class)->clanesRivales($raw);
        } catch (\Exception $e){
            return [
                'error' => true,
                'mensaje' => $e->getMessage(),
            ];
        }
    }
}