<?php
namespace App\Classes;

class ManejadorDeArchivos
{
    const MB = 'mb';
    const KB = 'kb';

    private $nombreArchivo;
    private $extensionArchivo;
    private $ubicacionArchivo;
    private $tipoArchivo;
    private $error;
    private $tamanioArchivo;
    private $ubicacionAlmacenamiento;

    public function getNombreArchivo() {
        return $this->nombreArchivo;
    }

    public function getExtension() {
        return $this->extensionArchivo;
    }

    public function getUbicacion() {
        return $this->ubicacionArchivo;
    }

    public function getTipo() {
        return $this->tipoArchivo;
    }

    public function getCodigoError() {
        return $this->error;
    }

    public static function getDirectorioPublico() {
        return realpath(__DIR__ . '/../../public');
    }

    public function getTamanioArchivo($type = null) {
        switch ($type) {
            case self::KB: return $this->tamanioArchivo / 1024;
            case self::MB: return ($this->tamanioArchivo / 1024) / 1024;
            default: $this->tamanioArchivo;
        }
    }

    /**
     * @param $name
     * @return ManejadorDeArchivos|bool
     */
    public static function get($name) {
        if(!isset($_FILES[$name])) return false;
        $file = $_FILES[$name];
        $nuevoArchivo = new ManejadorDeArchivos();
        $nuevoArchivo->extractFileName($file['name']);
        $nuevoArchivo->tipoArchivo = $file['type'];
        $nuevoArchivo->ubicacionArchivo = $file['tmp_name'];
        $nuevoArchivo->error = $file['error'];
        $nuevoArchivo->tamanioArchivo = $file['size'];
        return $nuevoArchivo;
    }

    public function guardar($destination, $name = false) {
        if(!file_exists($destination)) {
            return false;
        }
        $ds = DIRECTORY_SEPARATOR;
        if(!$name) $name = $this->nombreArchivo;
        else $this->nombreArchivo = $name;
        $ubicacionFinal = "{$destination}{$ds}{$name}.{$this->extensionArchivo}";
        $this->ubicacionAlmacenamiento = $ubicacionFinal;
        return move_uploaded_file($this->ubicacionArchivo, $ubicacionFinal);
    }

    public function getUbicacionAlmacenamiento() {
        return $this->ubicacionAlmacenamiento;
    }

    public function getFullName() {
        return "{$this->nombreArchivo}.{$this->extensionArchivo}";
    }

    private function extractFileName($fileName) {
        $dot = strrpos($fileName, '.');
        $this->nombreArchivo = substr($fileName, 0, $dot);
        $this->extensionArchivo = substr($fileName, $dot + 1);
    }

    public function esValido() {
        return $this->error === UPLOAD_ERR_OK;
    }
}