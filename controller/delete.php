<?php

//Delete product
function deleteProducts() {
    //CORS, only localhost:4200 and method DELETE
    header("Access-Control-Allow-Origin: http://localhost:4200");
    header("Access-Control-Allow-Methods: DELETE");
    //database connection
    include_once '../bbdd/database.php';
    $metodo = $_SERVER["REQUEST_METHOD"];
    if ($metodo != "DELETE" && $metodo != "OPTIONS") {
        exit("Solo se permite método DELETE");
    }

    //id is empty
    if (empty($_GET["idProduct"])) {
        exit("No hay id de producto para eliminar");
    }
    //id product
    $idProduct= $_GET['idProduct'];
    //delete product
    $db = databaseConection();
    $sentencia = $db->prepare("DELETE FROM stock WHERE id = ?");
    $resultado = $sentencia->execute([$idProduct]);
    echo json_encode($resultado);
}

deleteProducts();

?>