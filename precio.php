<?php
require_once './filemanager.php';

class Precio extends FileManager{
    public $_hora;
    public $_estadia;
    public $_mensual;

    public function __construct($hora, $estadia, $mensual){
        $this->_hora = $hora;
        $this->_estadia = $estadia;
        $this->_mensual = $mensual;
    }

//    public function saveAuto(){
//        $this->save($this.PHP_EOL, "auto.txt");
//    }

    public static function savePrecioJson($array){
        FileManager::saveJson("precio.json", $array);

    }


    public static function readPrecioJson(){
        $lista = parent::readJson("precio.json");
        $listaDeMaterias = array();
        //var_dump($lista);
        foreach($lista as $datos){
            //var_dump($datos);
            if(count((array)$datos) == 3){
                $precioNuevo = new Precio($datos->_hora,$datos->_estadia,$datos->_mensual);
                array_push($listaDePrecios, $precioNuevo);
            }
        }
        return $listaDeMaterias;

    }


    public function __set($name, $value){
        $this->$name = $value;
    }

    public function __get($name){
        return $this->$name;
    }

    public function __toString(){
        return $this->_id.', '.$this->_nombre.', '.$this->_cuatrimestre;
    }
}


