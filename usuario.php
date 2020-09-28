<?php
require_once './filemanager.php';

class Usuario extends FileManager{
    public $_email;
    public $_tipo;
    public $_clave;

    public function __construct($email,$tipo, $clave){
        $this->_email = $email;
        $this->_tipo = $tipo;
        $this->_clave = $clave;
    }


    public static function saveUsuarioJson($array){
        FileManager::saveJson("usuario.json", $array);

    }


    public static function readUsuarioJson(){
        $lista = parent::readJson("usuario.json");
        $listaDeUsuarios = array();
        //var_dump($lista);
        foreach($lista as $datos){
            //var_dump($datos);
            if(count((array)$datos) == 3){
                $usuarioNuevo = new Usuario($datos->_email,$datos->_tipo, $datos->_clave);
                array_push($listaDeUsuarios, $usuarioNuevo);
            }
        }
        return $listaDeUsuarios;

    }

    public function esUnico($array){
        $unico = true;
        foreach($array as $item){
            if($item->_email == $this->_email ){
                $unico = false;
            }
        }
        return $unico;
    }


    public function verificar($array){
        $login = false;
        foreach($array as $item){
            if($item->_email == $this->_email){
                if($item->_clave == $this->_clave){
                    $this->_tipo = $item->_tipo;
                    $login = true;
                }
            }
        }
        return $login;
    }

    public function __set($name, $value){
        $this->$name = $value;
    }

    public function __get($name){
        return $this->$name;
    }

    public function __toString(){
        return $this->_email.', '.$this->_clave;
    }
}


