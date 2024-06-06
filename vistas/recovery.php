<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles/inicioSesion.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<?php
if(isset($_SESSION["rol"])){
    echo($_SESSION["rol"]);
    sesion2($_SESSION["rol"]);
}

function sesion2($sesion)
{
    switch ($sesion) {
        case 1:
            header("Location: ../vistas/empresa.php");
            break;
        case 2:
            header("Location: ../vistas/Empresa.php");
            break;
        case 3:
            header("Location: ../vistas/administrador.php");
            break;
        default:
    }
}
?>
<body>
<div class="container">
        <div class="forms">
            <div class="form login">
                <span class="title">Recuperacion De Contraseña</span>
                <form action="../controlador/controladorUsuario.php" method="post">
                    <div class="input-field">
                        <input type="email" placeholder="Correo Electronico" name="correoRecu" required>
                        <i class='bx bxs-id-card icon'></i>
                    </div>
                    <div class="input-field button">
                        <input type="submit" value="Recuperar Contraseña" name="login" name="iniciar">
                    </div>
                    <div class="input-field button">
                        <a href="../vistas/registrarse.php" class="botton">Registrarse</a>
                    </div>
                </form>
            </div>
            </div>


        </div>
    </div>
</body>
</html>