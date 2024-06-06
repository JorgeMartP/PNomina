<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php
session_start();
echo($_SESSION['rol']);
if (!isset($_SESSION['rol'])) {
    header("Location: inicioSesion.php");
    exit();
}else{
    if($_SESSION['rol'] != 3){
        header("Location: inicioSesion.php");
        exit();
    }
}
?>

<body>
    <h1>Bienvenido administrador</h1>
    <a href="../controlador/controladorUsuario.php?cerrar_sesion=true">cerrar sesión</a>
</body>
</html>