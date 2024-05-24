<?php
//$para      = 'jlmartinezpinto@gmail.com';
//$titulo    = 'cambio contraseña';
//$mensaje   = 'Cambio de contraseña http://localhost/proyectoNomina/vistas/inicioSesion.php  ';
//$cabeceras = 'From: jlmartinezpinto@gmail.com' . "\r\n" .
//   'Reply-To: jlmartinezpinto@gmail.com' . "\r\n" .
// 'X-Mailer: PHP/' . phpversion();
//mail($para, $titulo, $mensaje, $cabeceras);
?>
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
    <div class="container">
        <div class="forms">
            <div class="form login">
                <span class="title">Cambiar Contraseña</span>
                <form action="../controlador/controladorUsuario.php" method="post">
                    <div class="input-field">
                        <input type="email" placeholder="Correo Electronico" name="correo" required>
                        <i class='bx bxs-id-card icon'></i>
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
                    <div class="input-field button">
                        <input type="submit" value="Cambiar" name="login" name="iniciar">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="../js/validar.js"></script>
</body>

</html>