<?php

//Create products
function createProducts() {
    //CORS, only localhost:4200 and method POST
    header("Access-Control-Allow-Origin: http://localhost:4200");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type");
    //database connection
    include_once '../bbdd/database.php';
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
        $description = $data['description'];
        $price = $data['price'];
        $img = $data['img'];
    }

    $db = databaseConection();
    $sentencia = $db->prepare("INSERT INTO stock (descripcion, precio, img) VALUES (?, ?, ?)");
    $resultado = $sentencia->execute([$description, $price, $img]);
    if ($resultado) {
        $response = array("message" => "Producto insertado correctamente", "id" => $db->lastInsertId());
        echo json_encode($response);
    } else {
        echo json_encode(array("message" => "Error al insertar el producto"));
    }
}

createProducts();

?>