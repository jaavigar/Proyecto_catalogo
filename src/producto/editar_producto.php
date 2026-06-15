<?php
session_start();
if (!isset($_SESSION['usuario'])) { header("Location: ../login.php"); exit; }
include("../conexion.php");

$id = $_GET['id'];
$fabricantes = $conexion->query("SELECT * FROM fabricante")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nombre        = $_POST['nombre'];
    $descripcion   = $_POST['descripcion'];
    $precio        = $_POST['precio'];
    $id_fabricante = $_POST['id_fabricante'];

    $c = $conexion->prepare("SELECT imagen FROM producto WHERE id = :id");
    $c->execute(["id" => $id]);
    $actual = $c->fetch();
    $nombre_imagen = $actual['imagen'];

    if ($_FILES['imagen']['name'] != "") {
        $nombre_imagen = $_FILES['imagen']['name'];
        move_uploaded_file($_FILES['imagen']['tmp_name'], "../uploads/" . $nombre_imagen);
    }

    $sql = "UPDATE producto SET nombre=:nombre, descripcion=:descripcion, precio=:precio, imagen=:imagen, id_fabricante=:id_fabricante WHERE id=:id";
    $consulta = $conexion->prepare($sql);
    $consulta->execute(["nombre" => $nombre, "descripcion" => $descripcion, "precio" => $precio, "imagen" => $nombre_imagen, "id_fabricante" => $id_fabricante, "id" => $id]);

    header("Location: ../index.php");
    exit;
}

$consulta = $conexion->prepare("SELECT * FROM producto WHERE id = :id");
$consulta->execute(["id" => $id]);
$producto = $consulta->fetch();
if (!$producto) { header("Location: ../index.php"); exit; }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar moto</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>

<header class="cabecera">
    <div class="pagina">
        <h1>🏍️ Catálogo de Motos</h1>
    </div>
</header>

<div class="pagina">
    <h1>Editar moto</h1>

    <div class="formulario">
        <form method="POST" action="editar_producto.php?id=<?php echo $producto['id']; ?>" enctype="multipart/form-data">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>">

            <label>Descripción:</label>
            <textarea name="descripcion"><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>

            <label>Precio (€):</label>
            <input type="number" step="0.01" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>">

            <?php if ($producto['imagen']): ?>
                <label>Imagen actual:</label>
                <img src="../uploads/<?php echo htmlspecialchars($producto['imagen']); ?>" style="width:120px;border-radius:6px;margin-bottom:12px;display:block;">
            <?php endif; ?>

            <label>Cambiar imagen (opcional):</label>
            <input type="file" name="imagen">

            <label>Marca:</label>
            <select name="id_fabricante">
                <?php foreach ($fabricantes as $f): ?>
                    <option value="<?php echo $f['id']; ?>" <?php if ($f['id'] == $producto['id_fabricante']) echo "selected"; ?>>
                        <?php echo htmlspecialchars($f['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Actualizar</button>
        </form>
    </div>

    <a class="boton-volver" href="../index.php">← Volver al catálogo</a>
</div>

</body>
</html>