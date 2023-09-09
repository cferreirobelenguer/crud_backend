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

    if (!isset($_POST['username'], $_POST['password'])) {
        //No data in body
        exit('Not found data');
    }

    if ($sentencia = $db->prepare('SELECT * FROM `usuarios` WHERE usuario = ?')) {
        if ($sentencia->execute([$_POST['username']])) {
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            if ($resultado) {
                // User found
                echo json_encode($resultado);
            } else {
                // User not found
                echo 'User not found';
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
