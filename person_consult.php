<?php
function getCredential($client_id){
    try {
        $conneccion = getConn();
        $query= "SELECT * FROM credenciales WHERE client_id = :client_id";
        $stmt= $conneccion->prepare($query);
        $stmt->bindParam(':client_id', $client_id, PDO::PARAM_INT);
        $stmt->execute();
        $result= $stmt->fetch(PDO::FETCH_ASSOC);
        //cierro a coneccion
        $conneccion = null;
        return json_encode($result);
    } catch (PDOException $e) {
        die("Error al conectar: ".$e->getMessage());
    }
}
function getUpdatePerson($client_id, $nombre, $apellido, $edad, $telefono){
    try {
        $conneccion = getConn();
        $query= "UPDATE personas SET nombre = :nombre, apellido = :apellido, edad = :edad, telefono = :telefono WHERE client_id = :client_id";
        
        $stmt= $conneccion->prepare($query);
        $stmt->bindParam(':nombre', $nombre,':apellido', $apellido,':telefono', $telefono,':edad', $edad,':client_id', $client_id, PDO::PARAM_INT);
        $stmt->execute();
        //cierro a coneccion
        $conneccion = null;
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Error al conectar: ".$e->getMessage());
    }
}
?>