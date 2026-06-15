<?php
session_start();
include("conexion.php");

$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : "";
$orden = (isset($_GET['orden']) && $_GET['orden'] == "DESC") ? "DESC" : "ASC";
$pagina = (isset($_GET['pagina']) && is_numeric($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
$por_pagina = 3;
$inicio = ($pagina - 1) * $por_pagina;

$sql_total = "SELECT COUNT(*) FROM producto WHERE nombre LIKE :busqueda OR descripcion LIKE :busqueda";
$consulta_total = $conexion->prepare($sql_total);
$consulta_total->execute(["busqueda" => "%" . $busqueda . "%"]);
$total = $consulta_total->fetchColumn();
$total_paginas = max(1, ceil($total / $por_pagina));

$sql = "SELECT * FROM producto WHERE nombre LIKE :busqueda OR descripcion LIKE :busqueda ORDER BY precio $orden LIMIT :inicio, :cantidad";
$consulta = $conexion->prepare($sql);
$consulta->bindValue(":busqueda", "%" . $busqueda . "%");
$consulta->bindValue(":inicio", $inicio, PDO::PARAM_INT);
$consulta->bindValue(":cantidad", $por_pagina, PDO::PARAM_INT);
$consulta->execute();
$productos = $consulta->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Motos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<header class="cabecera">
    <div class="pagina">
        <h1>Catálogo de Motos</h1>
        <nav>
            <?php if (isset($_SESSION['usuario'])): ?>
                <span><?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
                <a href="producto/crear_producto.php">+ Nueva moto</a>
                <a href="fabricante/fabricantes.php">Marcas</a>
                <a href="logout.php">Cerrar sesión</a>
            <?php else: ?>
                <a href="login.php">Iniciar sesión</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<div class="pagina">

    <form class="buscador" method="GET" action="index.php">
        <input type="text" name="busqueda" placeholder="Buscar moto..." value="<?php echo htmlspecialchars($busqueda); ?>">
        <select name="orden">
            <option value="ASC" <?php if ($orden == "ASC") echo "selected"; ?>>Precio: menor a mayor</option>
            <option value="DESC" <?php if ($orden == "DESC") echo "selected"; ?>>Precio: mayor a menor</option>
        </select>
        <button type="submit">Buscar</button>
    </form>

    <?php if (count($productos) == 0): ?>
        <p class="sin-resultados">No se han encontrado motos.</p>
    <?php endif; ?>

    <?php foreach ($productos as $p): ?>
        <div class="tarjeta">
            <?php if ($p['imagen']): ?>
                <img src="uploads/<?php echo htmlspecialchars($p['imagen']); ?>" alt="<?php echo htmlspecialchars($p['nombre']); ?>">
            <?php endif; ?>
            <div class="tarjeta-info">
                <h2><?php echo htmlspecialchars($p['nombre']); ?></h2>
                <p><?php echo htmlspecialchars($p['descripcion']); ?></p>
                <div class="precio"><?php echo htmlspecialchars($p['precio']); ?> €</div>
                <div class="acciones">
                    <a href="producto/detalle_producto.php?id=<?php echo $p['id']; ?>">Ver detalle</a>
                    <?php if (isset($_SESSION['usuario'])): ?>
                        <a href="producto/editar_producto.php?id=<?php echo $p['id']; ?>">Editar</a>
                        <a class="eliminar" href="producto/eliminar_producto.php?id=<?php echo $p['id']; ?>">Eliminar</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="paginacion">
        <span>Páginas:</span>
        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
            <?php if ($i == $pagina): ?>
                <strong><?php echo $i; ?></strong>
            <?php else: ?>
                <a href="index.php?pagina=<?php echo $i; ?>&busqueda=<?php echo urlencode($busqueda); ?>&orden=<?php echo $orden; ?>"><?php echo $i; ?></a>
            <?php endif; ?>
        <?php endfor; ?>
    </div>

</div>
</body>
</html>