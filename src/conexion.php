<?php

$host     = "db";
$puerto   = "3306";
$bd       = "catalogo";
$usuario  = "root";
$password = "root";


try {

    $conexion = new PDO(
        "mysql:host=$host;port=$puerto;dbname=$bd",
        $usuario,
        $password
    );

} catch (PDOException $e) {

    die("Error al conectar con la base de datos: " . $e->getMessage());

}

?>