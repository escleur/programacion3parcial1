<?php

class FileManager{
    public static function save($dato, $file){
        $archivo = fopen($file, 'a+');
        $fwrite = fwrite($archivo, $dato);
        $close = fclose($archivo);
    }


    public static function read($file){
        $archivo = fopen($file, 'r');
        $listaDeAutos = array();
        
        while(!feof($archivo)){
            $linea = fgets($archivo);
            $datos = explode('*', $linea);
            if(count($datos) > 1){
                array_push($listaDeAutos, $datos);
            } 
        }
        $close = fclose($archivo);
      
        return $listaDeAutos;
    }
    
    public static function readJson($file){
        
        if(file_exists($file)){
            $archivo = fopen($file, 'r');
            $size = filesize($file);
            if($size > 0){
                $fread = fread($archivo, $size);
            }else{
                $fread = "{}";
            }
            $close = fclose($archivo);
            $array = array();
            $array = json_decode($fread);
        }else{
            $array = array();
        }
        return $array;
    }
    public static function saveJson($file, $array){
        $archivo = fopen($file, 'w');
        $fwhite = fwrite($archivo, json_encode($array));
        $close = fclose($archivo);
    }
    public static function readSerialize($file){
        
        if(file_exists($file)){
            $archivo = fopen($file, 'r');
            $size = filesize($file);
            if($size > 0){
                $fread = fread($archivo, $size);
            }else{
                $fread = "{}";
            }
            $close = fclose($archivo);
            $array = array();
            $array = unserialize($fread);
        }else{
            $array = array();
        }
        return $array;
    }
    public static function saveSerialize($file, $array){
        $archivo = fopen($file, 'w');
        $fwhite = fwrite($archivo, serialize($array));
        $close = fclose($archivo);
    }

}