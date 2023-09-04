<?php

//Create products
function createProducts() {
    //CORS, only localhost:4200 and method POST
    header("Access-Control-Allow-Origin: http://localhost:4200");
    header("Access-Control-Allow-Methods: POST");
    //database connection
    include_once '../bbdd/database.php';
    $metodo = $_SERVER["REQUEST_METHOD"];
    if ($metodo != "POST" && $metodo != "OPTIONS") {
        exit("Solo se permite método POST");
    }

    //data are empty
    if (empty($_POST["description"]) || empty($_POST["price"]) || empty($_POST["img"])) {
        exit("Faltan datos");
    }
    //information of product
    $description= $_POST['description'];
    $price = $_POST['price'];
    $img = $_POST['img'];

    $db = databaseConection();
    $sentencia = $db->prepare("INSERT INTO stock (descripcion, precio, img) VALUES (?, ?, ?)");
    $resultado = $sentencia->execute([$description, $price, $img]);
    echo json_encode($resultado);
}

createProducts();

?>