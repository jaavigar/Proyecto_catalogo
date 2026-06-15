<?php
session_start();
if (!isset($_SESSION['usuario'])) { header("Location: ../login.php"); exit; }
include("../conexion.php");

$fabricantes = $conexion->query("SELECT * FROM fabricante")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nombre        = $_POST['nombre'];
    $descripcion   = $_POST['descripcion'];
    $precio        = $_POST['precio'];
    $id_fabricante = $_POST['id_fabricante'];
    $nombre_imagen = null;

    if ($_FILES['imagen']['name'] != "") {
        $nombre_imagen = $_FILES['imagen']['name'];
        move_uploaded_file($_FILES['imagen']['tmp_name'], "../uploads/" . $nombre_imagen);
    }

    $sql = "INSERT INTO producto (nombre, descripcion, precio, imagen, id_fabricante) VALUES (:nombre, :descripcion, :precio, :imagen, :id_fabricante)";
    $consulta = $conexion->prepare($sql);
    $consulta->execute(["nombre" => $nombre, "descripcion" => $descripcion, "precio" => $precio, "imagen" => $nombre_imagen, "id_fabricante" => $id_fabricante]);

    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear moto</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>

<header class="cabecera">
    <div class="pagina">
        <h1>🏍️ Catálogo de Motos</h1>
    </div>
</header>

<div class="pagina">
    <h1>Crear nueva moto</h1>

    <div class="formulario">
        <form method="POST" action="crear_producto.php" enctype="multipart/form-data">
            <label>Nombre:</label>
            <input type="text" name="nombre">

            <label>Descripción:</label>
            <textarea name="descripcion"></textarea>

            <label>Precio (€):</label>
            <input type="number" step="0.01" name="precio">

            <label>Imagen:</label>
            <input type="file" name="imagen">

            <label>Marca:</label>
            <select name="id_fabricante">
                <?php foreach ($fabricantes as $f): ?>
                    <option value="<?php echo $f['id']; ?>"><?php echo htmlspecialchars($f['nombre']); ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Guardar</button>
        </form>
    </div>

    <a class="boton-volver" href="../index.php">← Volver al catálogo</a>
</div>

</body>
</html>