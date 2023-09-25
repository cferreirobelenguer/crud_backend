<?php

function loginUser() {
    session_start();
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
        $username = $data['username'];
        $password = $data['password'];
    }

    if ($sentencia = $db->prepare('SELECT * FROM `usuarios` WHERE usuario = ? and contraseña = ?')) {
        if ($sentencia->execute([$username, $password])) {
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            if ($resultado) {
                // User found
                echo json_encode(array("data" => $resultado));
            } else {
                // User not found
                echo json_encode(array("error" => "Inicio de sesión fallido"));
            }
        } else {
            echo 'Error executing the SQL statement';
        }
    } else {
        echo 'Error preparing the SQL statement';
    }
    // Close the cursor
    $sentencia->closeCursor();
}

loginUser();

?>
