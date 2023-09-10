<?php

function registerUser() {
    // CORS, only localhost:4200 and method POST
    header("Access-Control-Allow-Origin: http://localhost:4200");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type");


     // Database connection
    include_once '../bbdd/database.php';
    $db = databaseConection();

    $metodo = $_SERVER["REQUEST_METHOD"];
    if ($metodo != "POST" && $metodo != "OPTIONS") {
        exit("Solo se permite método POST");
    }

    // json file
    $inputJSON = file_get_contents('php://input');

    $data = json_decode($inputJSON, true);

    if ($data === null) {
        echo json_encode(array("error" => "Error al decodificar el JSON"));
    } else {
        $name = $data['name'];
        $username = $data['username'];
        $password = $data['password'];
        $email = $data['email'];
    }

    //search if we have results
    $search = $db->prepare('SELECT id, contraseña FROM `usuarios` WHERE usuario = ?');
    $search->execute([$username]);
    $data = $search->fetch(PDO::FETCH_ASSOC);
    if ($data) {
        echo json_encode($data);
    } else {
        //register user if we haven´t got results 
        $sentencia = $db->prepare("INSERT INTO usuarios (nombre, usuario, contraseña, email) VALUES (?, ?, ?, ?)");
        $resultado = $sentencia->execute([$name, $username, $password, $email]);
        if ($resultado) {
            echo json_encode(array("message" => "Registro exitoso"));
        } else {
            echo json_encode(array("message" => "Error al insertar el producto"));
        }
    }
    
}

registerUser();

?>