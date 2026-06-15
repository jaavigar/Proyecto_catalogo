<?php
session_start();
if (!isset($_SESSION['usuario'])) { header("Location: ../login.php"); exit; }
include("../conexion.php");

$fabricantes = $conexion->query("SELECT * FROM fabricante")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Marcas de motos</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>

<header class="cabecera">
    <div class="pagina">
        <h1>🏍️ Catálogo de Motos</h1>
        <nav>
            <a href="../index.php">← Catálogo</a>
            <a href="crear_fabricante.php">+ Nueva marca</a>
        </nav>
    </div>
</header>

<div class="pagina">
    <h1>Marcas de motos</h1>

    <?php if (count($fabricantes) == 0): ?>
        <p class="sin-resultados">No hay marcas creadas todavía.</p>
    <?php endif; ?>

    <?php foreach ($fabricantes as $f): ?>
        <div class="marca-item">
            <span><?php echo htmlspecialchars($f['nombre']); ?></span>
            <div class="acciones">
                <a href="editar_fabricante.php?id=<?php echo $f['id']; ?>">Editar</a>
                <a class="eliminar" href="eliminar_fabricante.php?id=<?php echo $f['id']; ?>">Eliminar</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>