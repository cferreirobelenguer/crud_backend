<?php
    //CORS, only localhost:4200 and method POST
    header("Access-Control-Allow-Origin: http://localhost:4200");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Content-Type");
    $metodo = $_SERVER["REQUEST_METHOD"];
    if ($metodo != "GET" && $metodo != "OPTIONS") {
        exit("Solo se permite método GET");
    }
    session_start();
    session_destroy();
    $response = array("message" => "Sesión cerrada");
    echo json_encode($response);
?>