<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Sesión</title>
    <link rel="stylesheet" href="../styles/inicioSesion.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="container">
        <div class="forms">
            <div class="form login">
                <span class="title">Iniciar Sesión</span>
            
                <form action="../controlador/controladorUsuario.php" method="post">
                    <div class="input-field">
                        <input type="email" placeholder="Correo Electronico" name="correo" required>
                        <i class='bx bxs-id-card icon'></i>
                    </div>
                    <div class="input-field">
                        <input type="password" placeholder="Contraseña" name="contraseña_Login" class="password" required>
                        <i class='bx bx-lock-alt icon'></i>
                        <i class='bx bx-hide showHipePw'></i>
                    </div>
                    <div class="checkbox-text">
                        <div class="checkbox-content">
                            <input type="checkbox" name="recordar" id="logCheck">
                            <label for="logCheck" class="text">¿Recordar Usuario?</label>  
                        </div>
                        
                    </div>
                    <div class="input-field button">
                        <input type="submit" value="Iniciar Sesión" name="login" name="iniciar">
                        <a href="recuperarContraseña.php">¿Olvido la contraseña?</a>
                    </div>
                    <div class="input-field button">
                        <a href="../vistas/registrarse.php" class="botton">Registrarse</a>
                    </div>
                </form>
            </div>
            </div>


        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/show.js"></script>
</body>
</html>
