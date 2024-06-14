<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<?php
if(isset($_SESSION["rol"])){
    echo($_SESSION["rol"]);
    sesion2($_SESSION["rol"]);
}
if (isset($_SESSION["rol"])) {
    $rol = intval($_SESSION["rol"]); // Convertir a entero
    sesion2($rol);
} elseif (isset($_COOKIE["cookiesrol"])) {
    // Evitar iniciar sesión automáticamente si la sesión ya se ha cerrado
    if (!isset($_GET['cerrar_sesion'])) {
        $rolC = intval($_COOKIE["cookiesrol"]); // Convertir a entero
        $_SESSION['rol'] = $rolC;
        sesion2($rolC);
    }
}
function sesion2($sesion)
{
    switch ($sesion) {
        case 1:
            header("Location: ./vistas/empresa.php");
            break;
        case 2:
            header("Location: ./vistas/Empresa.php");
            break;
        case 3:
            header("Location: ./vistas/administrador.php");
            break;
        default:
    }
}
?>
<body>
    <section class="section section1">
        <h1 class ="section-h1"> BIENVENIDO AL SISTEMA DE NOMINA</h1>        
    </section>
    <section section class="section section2">
    <form action="#">
        <input type="submit" value="Ingresar" class="btn btn-primary" formaction="vistas/inicioSesion.php">
        
    </form>
    </section>
</body>
</html>