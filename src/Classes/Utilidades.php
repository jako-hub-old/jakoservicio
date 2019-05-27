<?php

namespace App\Classes;

/**
 * Esta clase de utilidades sirve de repositorio de funciones útiles en toda la aplicación.
 * Class Utilidades
 * @package App\Classes
 * @author Jorge Alejandro Quiroz Serna <jakop.box@gmail.com>
 */
final class Utilidades {
    private $directorioDiccionarios = "";
    private $diccionario = null;
    private $_;

    /**
     * Utilidades constructor.
     * El constructor se hace privado para ir de la mano con el patrón singleton.
     */
    private function __construct() {
        $this->init();
    }

    /**
     * Al inicializarse la clase se obtiene la ruta del directorio de traducciones.
     * Es una ruta relativa a partir del directorio en dónde se encuentre este archivo.
     */
    private function init() {
        $this->_ = DIRECTORY_SEPARATOR;
        $this->directorioDiccionarios = realpath(implode($this->_, [__DIR__, "..", "..", "translations"])) . $this->_;
    }

    /**
     * Esta función returna la instancia única de esta clase.
     * @return Utilidades|null
     */
    public static function get() {
        static $instance = null;
        if($instance ===  null) {
            $instance = new Utilidades();
        }
        return $instance;
    }

    /**
     * Esta función permite traducir o resolver cualquier clave dentro del diccionario.
     * @param $aTraducir string|array
     * @return
     */
    public static function t($aTraducir) {
        self::get()->cargarDiccionario();
        return self::get()->traduccionSimple($aTraducir);
    }

    /**
     * Esta función busca especifícamente claves que empiecen con validacion_
     * @param $codigo
     * @return mixed
     */
    public static function validacion($codigo) {
        self::get()->cargarDiccionario();
        return self::get()->traduccionSimple("validacion_{$codigo}");
    }

    /**
     * Esta función busca especifícamente claves que empiecen con error_
     * @param $codigo
     * @return mixed
     */
    public static function error($codigo) {
        self::get()->cargarDiccionario();
        return self::get()->traduccionSimple("error_{$codigo}");
    }

    /**
     * Esta función se encarga de cargar el diccionario de textos en memoria.
     * @return bool
     */
    private function cargarDiccionario() {
        if($this->diccionario !== null) return false;
        $archivoDiccionario = $this->directorioDiccionarios . "textos.php";
        if(!file_exists($archivoDiccionario)) return false;
        $this->diccionario = include $archivoDiccionario;
        return true;
    }

    /**
     * Esta función recupera una clave del diccionario de textos.
     * @param $clave
     * @return mixed
     */
    private function traduccionSimple($clave) {
        return $this->diccionario[$clave]?? $clave;
    }

    /**
     *  Esta función permite generar thumbnails centrados para las imagendes de los usuarios.
     * @param $fuente
     * @param $nombre
     * @param $destino
     * @param $tamanio
     * @return bool|string
     */
    public function generarImagenMiniatura($fuente, $nombre, $destino, $tamanio) {
        $info = pathinfo($fuente);
        $extension = $info['extension'];
        if(!file_exists($fuente)) return false;
        if($extension === 'jpg' || $extension === 'jpeg') $img = imagecreatefromjpeg($fuente);
        $ancho = imagesx($img);
        $alto = imagesy($img);
        $calidad = 100;
        $miniatura = imagecreatetruecolor($tamanio, $tamanio);

        if($ancho > $alto) {
            # Dimensiones para centrar la imagen
            $tamanioCentrado = $alto;
            $diffX = ceil(($ancho / 2) - ($tamanioCentrado / 2));
            $diffY = 0;
        } else if ($alto > $ancho) {
            $tamanioCentrado = $ancho;
            $diffY = ceil(($alto / 2) - ($tamanioCentrado / 2));
            $diffX = 0;
        } else {
            $tamanioCentrado = $ancho;
            $diffX = $diffY = 0;
        }
        $imagenCentrada = imagecreatetruecolor($tamanioCentrado, $tamanioCentrado);
        imagecopy($imagenCentrada, $img, 0, 0, $diffX, $diffY, $tamanioCentrado, $tamanioCentrado);
        imagecopyresampled($miniatura, $imagenCentrada, 0, 0, 0, 0, $tamanio, $tamanio, $tamanioCentrado, $tamanioCentrado);
        $nombreImagen = "{$nombre}_thumb.{$extension}";
        if($extension === 'jpg' || $extension === 'jpeg') imagejpeg($miniatura, "{$destino}/{$nombreImagen}");
        return "/{$destino}/{$nombreImagen}";
    }
}