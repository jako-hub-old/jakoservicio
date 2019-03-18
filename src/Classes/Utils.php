<?php

namespace App\Classes;

/**
 * Esta clase de utilidades sirve de repositorio de funciones útiles en toda la aplicación.
 * Class Utils
 * @package App\Classes
 * @author Jorge Alejandro Quiroz Serna <jakop.box@gmail.com>
 */
final class Utils {
    private $directorioDiccionarios = "";
    private $diccionario = null;
    private $_;

    /**
     * Utils constructor.
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
     * @return Utils|null
     */
    public static function get() {
        static $instance = null;
        if($instance ===  null) {
            $instance = new Utils();
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
    public static function v($codigo) {
        self::get()->cargarDiccionario();
        return self::get()->traduccionSimple("validacion_{$codigo}");
    }

    /**
     * Esta función busca especifícamente claves que empiecen con error_
     * @param $codigo
     * @return mixed
     */
    public static function e($codigo) {
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
}