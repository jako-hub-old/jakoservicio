<?php

namespace App\Controller;
use App\Classes\ManejadorDeArchivos;
use App\Classes\Utilidades;
use App\Entity\Juego;
use App\Entity\Jugador;
use App\Entity\Usuario;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiJugadorController
 * @package App\Controller}
 */
class ApiJugadorController extends FOSRestController {

    /**
     * @return array
     * @Rest\Post("/v1/jugador/amigos")
     */
    public function amigos(Request $request) {
        try {
            $raw = json_decode($request->getContent(), true);
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository(Jugador::class)->amigos($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }

    /**
     * @return array
     * @Rest\Post("/v1/jugador/buscar")
     */
    public function buscar(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            return $em->getRepository(Jugador::class)->buscar();
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }

    /**
     * @param Request $request
     * @Rest\Post("/v1/jugador/informacion/complementaria")
     * @return array|mixed
     */
    public function guardarPseudonimo(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Jugador::class)->informacionComplementaria($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }

    /**
     * @return array
     * @Rest\Post("/v1/jugador/detalle")
     */
    public function detalle(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Jugador::class)->detalle($raw);
        } catch (\Exception $e) {
            return [
                'error' => true,
            ];
        }
    }

    /**
     * @param Request $request
     * @return array|mixed
     * @Rest\Post("/v1/jugador/guardar/foto")
     */
    public function guardarFoto(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $directorioDestino = realpath(ManejadorDeArchivos::getDirectorioPublico()) . '/fotos_usuario';
            if(!file_exists($directorioDestino)) {
                mkdir($directorioDestino);
            }
            $imagen = ManejadorDeArchivos::get('foto');
            $codigoJugador = $request->get("jugador");
            # Todo: validar extensión del archivo.
            if($imagen->esValido()) {
                $ext = $imagen->getExtension();
                $tiempo = time();
                $nombreImagen = "foto_jugador_{$codigoJugador}_$tiempo";
                $guardado = $imagen->guardar($directorioDestino, $nombreImagen);
                $urlImagen = "{$this->getUrl()}/fotos_usuario/{$nombreImagen}.{$ext}";
                if($guardado) { # todo: Guadar en entidad.
                    $resultado = $em->getRepository(Jugador::class)->guardarFoto($codigoJugador, $urlImagen);
                    if($resultado !== true) { # Si la imagen no se guardó correctamente en la entidad, la borramos.
                        unlink($directorioDestino) . "/{$nombreImagen}.{$ext}";
                        return $resultado;
                    } else {
                        return $urlImagen;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return [
                'message' => $e->getMessage(),
                'error' => true,
            ];
        }
    }

    /**
     * Esta función permite obtener la url base de la aplicación.
     * @return string
     */
    private function getUrl() {
        $basePath = str_replace('/var/www/html', '', dirname($_SERVER['SCRIPT_NAME']));
        $host = $_SERVER['HTTP_HOST'];
        $scheme = $_SERVER['REQUEST_SCHEME'];
        return "{$scheme}://{$host}{$basePath}";
    }
}