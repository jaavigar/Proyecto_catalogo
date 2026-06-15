<?php
session_start();
if (!isset($_SESSION['usuario'])) { header("Location: ../login.php"); exit; }
include("../conexion.php");

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $sql = "UPDATE fabricante SET nombre = :nombre WHERE id = :id";
    $consulta = $conexion->prepare($sql);
    $consulta->execute(["nombre" => $_POST['nombre'], "id" => $id]);
    header("Location: fabricantes.php");
    exit;
}

$consulta = $conexion->prepare("SELECT * FROM fabricante WHERE id = :id");
$consulta->execute(["id" => $id]);
$fabricante = $consulta->fetch();
if (!$fabricante) { header("Location: fabricantes.php"); exit; }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar marca</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>

<header class="cabecera">
    <div class="pagina">
        <h1>🏍️ Catálogo de Motos</h1>
    </div>
</header>

<div class="pagina">
    <h1>Editar marca</h1>

    <div class="formulario">
        <form method="POST" action="editar_fabricante.php?id=<?php echo $fabricante['id']; ?>">
            <label>Nombre de la marca:</label>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($fabricante['nombre']); ?>">
            <button type="submit">Actualizar</button>
        </form>
    </div>

    <a class="boton-volver" href="fabricantes.php">← Volver a marcas</a>
</div>

</body>
</html>