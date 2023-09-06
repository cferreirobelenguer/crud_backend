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

    if (!isset($_POST['name'], $_POST['username'], $_POST['password'], $_POST['email'])) {
        //No data in body
        exit('Not found data');
    }
    //search if we have results
    $search = $db->prepare('SELECT id, contraseña FROM `usuarios` WHERE usuario = ?');
    $search->execute([$_POST['username']]);
    $data = $search->fetch(PDO::FETCH_ASSOC);
    if ($data) {
        echo json_encode($data);
    } else {
        //register user if we haven´t got results 
        $sentencia = $db->prepare("INSERT INTO usuarios (nombre, usuario, contraseña, email) VALUES (?, ?, ?, ?)");
        $resultado = $sentencia->execute([$_POST['name'],$_POST['username'], $_POST['password'], $_POST['email']]);
        if ($resultado) {
            $response = array("message" => "Producto insertado correctamente", "id" => $db->lastInsertId());
            echo json_encode($response);
        } else {
            echo json_encode(array("message" => "Error al insertar el producto"));
        }
    }
    
}

registerUser();

?>