<?php
//Delete product
function delete() {
    header("Access-Control-Allow-Origin: http://localhost:4200");
    header("Access-Control-Allow-Methods: DELETE");
    include_once '../bbdd/database.php';

    $metodo = $_SERVER["REQUEST_METHOD"];
    if ($metodo != "DELETE" && $metodo != "OPTIONS") {
        exit("Solo se permite método DELETE");
    }

    if (empty($_GET["idProduct"])) {
        exit("No hay id de producto para eliminar");
    }

    $idProduct= $_GET['idProduct'];

    $db = databaseConection();
    $sentencia = $db->prepare("DELETE FROM stock WHERE id = ?");
    $resultado = $sentencia->execute([$idProduct]);
    echo json_encode($resultado);
}

delete();

?>