<?php
require_once './filemanager.php';

class Ingreso extends FileManager{
    public $_patente;
    public $_fecha_ingreso;
    public $_tipo;
    public $_email;

    public function __construct($patente, $fecha_ingreso, $tipo, $email){
        $this->_patente = $patente;
        $this->_fecha_ingreso = $fecha_ingreso;
        $this->_tipo = $tipo;
        $this->_email = $email;
    }

    public static function saveIngresoJson($array){
        FileManager::saveJson("ingreso.json", $array);

    }


    public static function readIngresoJson(){
        $lista = parent::readJson("ingreso.json");
        $listaDeIngreso = array();
        //var_dump($lista);
        foreach($lista as $datos){
            //var_dump($datos);
            if(count((array)$datos) == 4){
                $ingresoNuevo = new Ingreso($datos->_patente, $datos->_fecha_ingreso,$datos->_tipo, $datos->_email);
                array_push($listaDeIngreso, $ingresoNuevo);
            }
        }
        return $listaDeIngreso;

    }

    public function __set($name, $value){
        $this->$name = $value;
    }

    public function __get($name){
        return $this->$name;
    }

    public function __toString(){
        return $this->_patente.', '.$this->_fecha_ingreso.', '.$this->_tipo.', '.$this->_email;
    }
}


