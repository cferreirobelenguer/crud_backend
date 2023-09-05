<?php
//Create products
function updateProducts() {
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

    //id is empty
    if (empty($_GET["idProduct"])) {
        exit("No hay id de producto para modificar");
    }
    //id product
    $idProduct= $_GET['idProduct'];

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

    //update product
    $db = databaseConection();
    $sentencia = $db-> prepare("UPDATE stock SET descripcion = ?, precio = ?, img = ? WHERE id = ?");
    $resultado = $sentencia-> execute([$description, $price, $img, $idProduct]);
    if ($resultado) {
        $response = array("message" => "Producto insertado correctamente", "id" => $db->lastInsertId());
        echo json_encode($response);
    } else {
        echo json_encode(array("message" => "Error al insertar el producto"));
    }
}

updateProducts();

?>