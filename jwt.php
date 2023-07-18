<?php
require 'vendor/autoload.php';
use Firebase\JWT\JWT;
$secretKey = '52874jk6482'; // Puedes cambiar esto por una clave más segura

// Función para generar un nuevo token JWT
function generateJWT($brand, $client_id, $secret_id) {
    global $secretKey;
    $payload = array(
        "user_id" => $brand,
        "brand" => $client_id,
        "secret_id" => $secret_id,
    );
    $token = JWT::encode($payload, $secretKey, 'HS256');
    return $token;
}

// Función para validar un token JWT
function validateJWT($token) {
    global $secretKey;
    try {
        $decoded = JWT::decode($token, $secretKey, array('HS256'));
        return $decoded;
    } catch (Exception $e) {
        return false;
    }
}
?>