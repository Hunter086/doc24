<?php
require 'vendor/autoload.php';
require 'jwt.php';
require 'connection.php';
require 'person_consult.php';

use GuzzleHttp\guzzle;
use GuzzleHttp\Client;
//Ruta api.php?route=login
if($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['route'] === 'login') {

    $client_id= $_POST['client_id'];
    $secret_id= $_POST['secret_id'];

    $db_credentials = getCredential($client_id);
    if ($client_id === $db_credentials['client_id'] && $secret_id === $db_credentials['secret_id']) {
        $userData = array('secret_id' => $db_credentials['secret_id']);
        $token = generateJWT($db_credentials['brand'],$db_credentials['client_id'],$db_credentials['secret_id']);
        return json_encode(array('token' => $token));
    } else {
        return json_encode(array('estado' => 0, 'mensaje'=> 'Token no valido'));
    }
}
//Ruta api.php/update-persona/{id}/{brand}
if($_SERVER['REQUEST_METHOD'] === 'POST' && preg_match('/\/update-persona\/(\d+)\/([a-zA-Z]+)/', $_SERVER['REQUEST_URI'], $matches)) {
    
    $id= $matches[1];
    $brand= $matches[2];
        // Leer los datos enviados por POST
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $edad = $_POST['edad'];
        $telefono = $_POST['telefono'];
    //traemos el token 
    $post_token = $_SERVER['HTTP_AUTHENTICATION_TOKEN'];
    if($post_token!= null){

        //traemos los datos
        $db_credentials = getCredential($id);
        //validar token
        if($object_token= validateJWT($post_token)){
            if(getUpdatePerson($id, $nombre, $apellido, $edad, $telefono)){
                return json_encode(array('estado' => 1, 'mensaje'=> 'Datos actualizados correctamente'));
            }else{
                return json_encode(array('estado' => 0, 'mensaje'=> 'Ha ocurrido un error al procesar la solicitud'));
            }
        }else{
            return json_encode(array('estado' => 0, 'mensaje'=> 'Ha ocurrido un error al procesar la solicitud'));
        }
    }
}
/**
 * Realiza una solicitud al webservice https://example.com/webservice utilizando el JWT como
 * parte de la autorización.
 */
function example_resquest($token, $nombre, $apellido, $edad, $telefono){
    $url= 'https://example.com/webservice';
    $client = new Client();
    $array= array('nombre'=>''.$nombre,'apellido'=>''.$apellido,'edad'=>''.$edad,'telefono'=>''.$telefono);
    $json= json_encode($array);
    $response = $client->request('POST',$url,[ 
        'headers' => [
            'accept' => 'application/json',
            'Authorization' => 'Bearer '.$token,
            'Content-Type' => 'application/json',
        ],
        'body' => $json
    ]);
    return $response;
}
?>