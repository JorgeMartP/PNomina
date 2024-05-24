<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles/inicioSesion.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <div class="form signup">
        <span class="title">Registrar Usuario</span>
        <form action="../controlador/controladorUsuario.php" method="post">
            <div class="input-field">
                <input type="number" placeholder="N° Identificación" name="numIdentificacion" required>
                <i class='bx bxs-id-card icon'></i>
            </div>
            <div class="input-field">
                <select name="tipo" id="" required>
                    <option value="">Elige Tipo Identificación</option>
                    <option value="CC">CC</option>
                    <option value="TI">TI</option>
                    <option value="CE">CE</option>
                </select>
                <i class='bx bxs-id-card icon'></i>
            </div>
            <div class="input-field">
                <input type="text" placeholder="Nombre" name="nombreR" required>
                <i class='bx bx-user icon'></i>
            </div>
            <div class="input-field">
                <input type="text" placeholder="Apellido" name="apellidoR" required>
                <i class='bx bx-user icon'></i>
            </div>
            <div class="input-field">
                <input type="email" placeholder="Correo Electronico" name="emailR" required>
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
                <input type="password" placeholder="Contraseña" name="contraseñaR" class="password" id="password" required>
                <i class='bx bx-lock-alt icon' id="icon"></i>
                <i class='bx bx-hide showHipePw' id="icon2"></i>
                <p id="massage">La contraseña es <span id="strenght"></span></p>
            </div>
            <div class="input-field">
                <select name="tipoUsuario" id="" required>
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
            <div class="input-field button">
                <a href="inicioSesion.php" class="botton">Iniciar Sesión</a>
            </div>
        </form>
    </div>
    <script src="../js/validar.js"></script>
    <script src="../js/show.js"></script>
</body>

</html>