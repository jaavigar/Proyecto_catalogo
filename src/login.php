<?php
session_start();
include("conexion.php");

$error = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $login    = $_POST['login'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuario WHERE login = :login";
    $consulta = $conexion->prepare($sql);
    $consulta->execute(["login" => $login]);
    $usuario = $consulta->fetch();

    if ($usuario && $password == $usuario['password']) {
        $_SESSION['usuario'] = $usuario['login'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<header class="cabecera">
    <div class="pagina">
        <h1>🏍️ Catálogo de Motos</h1>
    </div>
</header>

<div class="pagina">
    <h1>Iniciar sesión</h1>

    <?php if ($error != ""): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="formulario">
        <form method="POST" action="login.php">
            <label>Usuario:</label>
            <input type="text" name="login">

            <label>Contraseña:</label>
            <input type="password" name="password">

            <button type="submit">Entrar</button>
        </form>
    </div>

    <a class="boton-volver" href="index.php">← Volver al catálogo</a>
</div>

</body>
</html>