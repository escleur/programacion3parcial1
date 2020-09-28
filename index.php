<?php

require_once './usuario.php';
require_once './precio.php';
require_once './ingreso.php';
//require_once './asignacion.php';

require __DIR__.'/vendor/autoload.php';

use \Firebase\JWT\JWT;

$method = $_SERVER['REQUEST_METHOD'];
$path_info = $_SERVER['PATH_INFO'] ?? '';

$token = $_SERVER['HTTP_TOKEN'] ?? '';
$key = 'primerparcial';
$status = 'no logueado';
try{
    $decoded = JWT::decode($token, $key, array('HS256'));
    //print_r($decoded);
    $tokenTipo = $decoded->data->tipo ?? '';
    $tokenEmail = $decoded->data->email ?? '';
}catch(Throwable $th){
    echo 'No logueado<br/>';
}

switch($path_info){
    case '/registro':
        switch($method){
            case 'POST': // AGREGA RECURSOS
                $email = $_POST['email'] ?? '';
                $tipo = $_POST['tipo'] ?? '';
                $clave = $_POST['clave'] ?? '';
                if($tipo == "admin" || $tipo == "user"){
                    $usuario = new Usuario($email,$tipo, hash('sha256', $clave));

                    $lista = Usuario::readUsuarioJson();
                    $unico = $usuario->esUnico($lista);
                    if($unico){
                        array_push($lista, $usuario);
                        Usuario::saveUsuarioJson($lista);

                    }else{
                        echo "El mail ya esta registrado";
                    }

                }else{
                    echo "Tipo de usuario incorrecto";
                }
    
            break;
        }
    break;
    case '/login':
        switch($method){
            case 'POST': // AGREGA RECURSOS
                $email = $_POST['email'] ?? '';
                $clave = $_POST['clave'] ?? '';
                
                $usuario = new Usuario($email, '', hash('sha256', $clave));

                $lista = Usuario::readUsuarioJson();

                $login = $usuario->verificar($lista);

                $payload = array(
                    'data' => [
                        'email' => $email,
                        'tipo' => $usuario->_tipo
                    ]
                    );

                if($login){
                    $jwt = JWT::encode($payload, $key);
                    echo "Logueando...";
                    print_r($jwt);

                }else{
                    echo 'No se pudo logear';
                }

            break;
        }
    break;
    case '/precio':
        if($tokenTipo == 'admin'){
            switch($method){
                case 'POST': // AGREGA RECURSOS
                    $precio_hora = $_POST['precio_hora'] ?? '';
                    $precio_estadia = $_POST['precio_estadia'] ?? '';
                    $precio_mensual = $_POST['precio_mensual'] ?? '';
                    $precio = new Precio($precio_hora, $precio_estadia, $precio_mensual);


                    $lista = [];
                    array_push($lista, $precio);
                    Precio::savePrecioJson($lista);
                break;

            }
        }
    break;
    case '/ingreso':
        switch($method){
            case 'POST': // AGREGA RECURSOS
                if($tokenTipo == 'user'){
                    $patente = $_POST['patente'] ?? '';
                    $tipo = $_POST['tipo'] ?? '';
                    $ingreso = new Ingreso($patente, date("Y-m-d H:i:s"), $tipo, $tokenEmail);

                    $lista = Ingreso::readIngresoJson();
                    array_push($lista, $ingreso);
                    Ingreso::saveIngresoJson($lista);
                }
            break;
            case 'GET': // LISTA RECURSOS
                $patente = $_GET['patente'] ?? '';

                if($patente == ""){
                    $lista = Ingreso::readIngresoJson();
    
                    foreach($lista as $item){
                        if($item->_tipo == "hora")
                            echo $item->__toString()."<br/>";
                    }
                    foreach($lista as $item){
                        if($item->_tipo == "estadia")
                            echo $item->__toString()."<br/>";
                    }
                    foreach($lista as $item){
                        if($item->_tipo == "mensual")
                            echo $item->__toString()."<br/>";
                    }

                }else{
                    $lista = Ingreso::readIngresoJson();
                    foreach($lista as $item){
                        if($item->_patente == $patente)
                            echo $item->__toString()."<br/>";
                    }

                }
            break;
        }
    break;
    

}



