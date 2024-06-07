<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/inicioSesion.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<?php 
if(!isset($_GET['token'])){
    header('Location: inicioSesion.php');
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
                <span class="title">Cambiar Contraseña</span>
                <div id="alert-div"></div>
                <form action="../controlador/controladorUsuario.php" method="post" onsubmit="return validateForm()">
                    <div class="input-field">
                        <div class="tooltip">
                            <h4>La contraseña debe cumplir con: </h4>
                            <ul>
                                <li>Al menos 8 caracteres</li>
                                <li>Al menos un número</li>
                                <li>Al menos una letra minúscula</li>
                                <li>Al menos una letra mayúscula</li>
                                <li>Al menos un carácter especial</li>
                            </ul>
                        </div>
                        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>" required>
                        <input type="password" placeholder="Contraseña" name="contraseñaR" class="password" id="password" required>
                        <i class='bx bx-lock-alt icon' id="icon"></i>
                        <i class='bx bx-hide showHipePw' id="icon2"></i>
                        <p id="massage">La contraseña es <span id="strenght"></span></p>
                    </div>
                    <div class="input-field button">
                        <input type="submit" value="Cambiar" name="login">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="../js/validarPass.js"></script>
    <script src="../js/show.js"></script>
</body>
</html>
