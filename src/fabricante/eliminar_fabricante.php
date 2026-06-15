<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit;
}

include("../conexion.php");

$id = $_GET['id'];

$sql = "DELETE FROM fabricante WHERE id = :id";

$consulta = $conexion->prepare($sql);
$consulta->execute([
    "id" => $id
]);

header("Location: fabricantes.php");
exit;

?>