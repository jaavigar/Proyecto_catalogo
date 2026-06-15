<?php
session_start();
include("../conexion.php");

$id = $_GET['id'];
$sql = "SELECT producto.*, fabricante.nombre AS nombre_fabricante
        FROM producto
        LEFT JOIN fabricante ON producto.id_fabricante = fabricante.id
        WHERE producto.id = :id";
$consulta = $conexion->prepare($sql);
$consulta->execute(["id" => $id]);
$producto = $consulta->fetch();

if (!$producto) { header("Location: ../index.php"); exit; }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($producto['nombre']); ?></title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>

<header class="cabecera">
    <div class="pagina">
        <h1>🏍️ Catálogo de Motos</h1>
    </div>
</header>

<div class="pagina">
    <h1><?php echo htmlspecialchars($producto['nombre']); ?></h1>

    <div class="detalle">
        <?php if ($producto['imagen']): ?>
            <img src="../uploads/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
        <?php endif; ?>

        <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
        <p><strong>Precio:</strong> <?php echo htmlspecialchars($producto['precio']); ?> €</p>
        <p><strong>Marca:</strong> <?php echo $producto['nombre_fabricante'] ? htmlspecialchars($producto['nombre_fabricante']) : "Sin marca"; ?></p>
    </div>

    <a class="boton-volver" href="../index.php">← Volver al catálogo</a>
</div>

</body>
</html>