<?php
//Create products
function updateProducts() {
    //CORS, only localhost:4200 and method POST
    header("Access-Control-Allow-Origin: http://localhost:4200");
    header("Access-Control-Allow-Methods: POST");
    //database connection
    include_once '../bbdd/database.php';
    $metodo = $_SERVER["REQUEST_METHOD"];
    if ($metodo != "POST" && $metodo != "OPTIONS") {
        exit("Solo se permite método POST");
    }
}

updateProducts();

?>