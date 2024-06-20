<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles/inicioSesion.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
</head>
<?php
session_start();

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

if (isset($_SESSION["rol"]) || isset($_COOKIE["cookiesRol"])) {
    if(isset($_SESSION["rol"])){
        $rol = $_SESSION["rol"];
        sesion2($rol);
    }else{
        $_SESSION['rol'] = $_COOKIE['cookiesRol'];
        $_SESSION['idUsuario'] = $_COOKIE['cookiesId'];
        $rolC = $_COOKIE['cookiesRol'];
        sesion2($rolC);
    }
}
?>
<body>
    <div class="form signup">
        <span class="title">Registrar Usuario</span>
        <form action="../controlador/controladorUsuario.php" method="post" onsubmit="return validateFormR()">
            <div id="alert-div"></div>
            <div class="input-field">
                <input type="text" placeholder="N° Identificación" name="numIdentificacion" id="num">
                <i class='bx bxs-id-card icon'></i>
            </div>
            <div class="input-field">
                <select name="tipo" id="ident">
                    <option value="">Elige Tipo Identificación</option>
                    <option value="CC">CC</option>
                    <option value="TI">TI</option>
                    <option value="CE">CE</option>
                </select>
                <i class='bx bxs-id-card icon'></i>
            </div>
            <div class="input-field">
                <input type="text" placeholder="Nombre" name="nombreR" id="nombre">
                <i class='bx bx-user icon'></i>
            </div>
            <div class="input-field">
                <input type="text" placeholder="Apellido" name="apellidoR" id="apellido">
                <i class='bx bx-user icon'></i>
            </div>
            <div class="input-field">
                <input type="text" placeholder="Correo Electronico" id="email" name="emailR">
                <i class='bx bx-envelope icon'></i>
            </div>
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
                <input type="password" placeholder="Contraseña" name="contraseñaR" class="password" id="password">
                <i class='bx bx-lock-alt icon' id="icon"></i>
                <i class='bx bx-hide showHipePw' id="icon2"></i>
                <p id="massage">La contraseña es <span id="strenght"></span></p>
            </div>
            <div class="input-field">
                <select name="tipoUsuario" id="tipoUsu">
                    <option value="">Elige Tipo Usuario</option>
                    <option value="1">Jefe RH</option>
                    <option value="2">Contador</option>
                    <option value="3">Administrador</option>
                </select>
                <i class='bx bx-user icon'></i>
            </div>
            <div class="input-field button">
                <input type="submit" value="Registrar" name="registrar">
            </div>
        </form>
    </div>
    <script src="../js/validar.js"></script>
    <script src="../js/show.js"></script>
</body>
</html>
