<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container">
        <div class="forms">
            <div class="form login">
                <span class="title">Iniciar Sesión</span>
            
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