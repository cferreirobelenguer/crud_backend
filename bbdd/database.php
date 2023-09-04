<?php

//database conection
function databaseConection() {
    $servername = 'localhost';
    $database = 'productos';
    $username = 'root';
    $password = '';

    try {
        $dsn = "mysql:host=$servername;dbname=$database;charset=utf8mb4";
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;

    } catch (Exception $e) {
        echo 'Error';
    }
}


?>