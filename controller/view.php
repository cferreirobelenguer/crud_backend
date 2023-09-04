<?php

//get all the products
function getProducts() {
    // CORS, only localhost:4200 and method GET
    header("Access-Control-Allow-Origin: http://localhost:4200");
    header("Access-Control-Allow-Methods: GET");
    header("Content-Type: application/json");

    // database connection
    include_once '../bbdd/database.php';
    $db = databaseConection();
    $metodo = $_SERVER["REQUEST_METHOD"];
    if ($metodo != "GET" && $metodo != "OPTIONS") {
        http_response_code(405); 
        echo json_encode(["error" => "Solo se permite el método GET"]);
        exit();
    }

    // get data
    $sentencia = $db->query("SELECT * FROM stock");
    if ($sentencia === false) {
        http_response_code(500); // Error server 500
        echo json_encode(["error" => "Error al ejecutar la consulta"]);
        exit();
    }

    // results in JSON
    $result = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
}

getProducts();

?>