<?php
//Conectar a la base de datos
$config = parse_ini_file('C:\xampp\htdocs\wLogin\config.ini');
    $servername = $config["servername"];
    $username = $config["username"];
    $password = $config["password"];
    $dbName = $config["dbName"];

function getConn(){
    global $servername;
    global $username;
    global $password;
    global $dbName;
    try {
        $db = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        die('Error al conectar con la base de datos: ' . $e->getMessage());
    }
}
?>