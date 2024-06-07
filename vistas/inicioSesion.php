<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles/inicioSesion.css">
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<?php 
include_once("../controlador/controladorUsuario.php");
if(isset($_SESSION["rol"])){
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
                <span class="title">Iniciar Sesión</span>
                <?php
                if (isset($_SESSION["mensaje"]) && $_SESSION["mensaje"]) {
                    $mensaje = $_SESSION['mensaje'];
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'. $mensaje . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                    unset($_SESSION["mensaje"]);
                }
                ?>
                <div class="alert-div">
                </div>
                <form action="../controlador/controladorUsuario.php" method="post" onsubmit="return validate()">
                    <div class="input-field">
                        <input type="email" placeholder="Correo Electronico" name="correo"  required>
                        <i class='bx bxs-id-card icon'></i>
                    </div>
                    <div class="input-field">
                        <input type="password" placeholder="Contraseña" name="contraseña_Login" class="password" required>
                        <i class='bx bx-lock-alt icon' id="icon"></i>
                        <i class='bx bx-hide showHipePw' id="icon2"></i>
                    </div>
                    <div class="checkbox-text">
                        <div class="checkbox-content">
                            <input type="checkbox" name="recordar" id="logCheck">
                            <label for="logCheck" class="text">¿Recordar Usuario?</label>  
                        </div>
                        
                    </div>
                    <div class="input-field button">
                        <input type="submit" value="Iniciar Sesión" name="login" name="iniciar">
                        <a href="recovery.php">¿Olvido la contraseña?</a>
                    </div>
                    <div class="input-field button">
                        <a href="../vistas/registrarse.php" class="botton" >Registrarse</a>
                    </div>
                </form>
            </div>
            </div>


        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/show.js"></script>
    <script src="../js/validarIni.js"></script>
</body>
</html>
