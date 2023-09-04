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

    //id is empty
    if (empty($_GET["idProduct"])) {
        exit("No hay id de producto para modificar");
    }
    //id product
    $idProduct= $_GET['idProduct'];

     //data are empty
    if (empty($_POST["description"]) || empty($_POST["price"]) || empty($_POST["img"])) {
        exit("Faltan datos");
    }

    //information of product
    $description= $_POST['description'];
    $price = $_POST['price'];
    $img = $_POST['img'];

    //update product
    $db = databaseConection();
    $sentencia = $db-> prepare("UPDATE stock SET descripcion = ?, precio = ?, img = ? WHERE id = ?");
    $resultado = $sentencia-> execute([$description, $price, $img, $idProduct]);
    echo json_encode($resultado);
}

updateProducts();

?>