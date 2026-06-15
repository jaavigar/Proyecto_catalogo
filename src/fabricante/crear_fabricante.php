<?php
session_start();
if (!isset($_SESSION['usuario'])) { header("Location: ../login.php"); exit; }
include("../conexion.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $sql = "INSERT INTO fabricante (nombre) VALUES (:nombre)";
    $consulta = $conexion->prepare($sql);
    $consulta->execute(["nombre" => $_POST['nombre']]);
    header("Location: fabricantes.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear marca</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>

<header class="cabecera">
    <div class="pagina">
        <h1>🏍️ Catálogo de Motos</h1>
    </div>
</header>

<div class="pagina">
    <h1>Crear nueva marca</h1>

    <div class="formulario">
        <form method="POST" action="crear_fabricante.php">
            <label>Nombre de la marca:</label>
            <input type="text" name="nombre">
            <button type="submit">Guardar</button>
        </form>
    </div>

    <a class="boton-volver" href="fabricantes.php">← Volver a marcas</a>
</div>

</body>
</html>