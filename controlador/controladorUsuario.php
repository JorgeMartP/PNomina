<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>controlador</title>
</head>

<body>
    <?php
    require_once('../dao/DaoUsuarioImp.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    setcookie("intentos", 0, time() + 3600);
session_start();
#VERIFICAMOS QUE SI EXISTE LA VARIABLE CERRAR_SESION SI EXISTE CERRAMOS LA SESION ACTUAL Y ELIMINAMOS LAS COOKIES 
if (isset($_GET['cerrar_sesion'])) {
    setcookie("cookiesRol", "jorgelm65@gmail.com", time() - 1);
    setcookie("cookiesId", "1232323", time() - 1);
    session_unset();
    session_destroy();
    header("Location: ../vistas/inicioSesion.php");
    exit();
}

#VERIFICAMOS QUE ROL TIENE EL USUARIO INGRESADO Y LO ENVIAMOS A LA PAGINA DESEADA
function sesion($sesion)
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

    $dao = new DaoUsuarioImp();
    if (isset($_POST['correo'])) {
        $correo = $_POST['correo'];
        $contraseña = $_POST['contraseña_Login'];
        $traer = $dao->traer($correo);

        if ($traer == false) {
            echo '<script type="text/javascript">
        function miFuncion() {
        Swal.fire({
            icon: "warning",
            text: "Usuario no registrado. Registrese"
        })
        }
        window.onload = miFuncion;
        </script>';
        } else {
            if (isset($_POST["recordar"])) {
                setcookie("cookiesRol", $traer->getCodTipoUsuario(), time() + 259200);
                setcookie("cookiesId", $traer->getCorreoU(), time() + 259200);
            }
            if (password_verify($contraseña, $traer->getContraseña()) && $correo == $traer->getCorreoU()) {
                if ($traer->getCuenta_bloqueada()) {
                    echo "Tu cuenta está bloqueada. Por favor, recupera tu contraseña.";
                }else{
                    $_SESSION['rol'] = $traer->getCodTipoUsuario();
                    $_SESSION['idUsuario'] = $traer->getCorreoU();
                    $dao->actualizarIntentos($traer->getCorreoU());
                    sesion($_SESSION['rol']);
                }
            } else {
                $intentos = $traer->getIntentos_fallidos();
                $intentosT = $intentos + 1;
                $traer->setIntentos_fallidos($intentosT);
                if($intentosT >= 3){
                    $dao->bloquearCuenta($traer->getCorreoU());
                }else{
                    $dao->aumentarIntentos($traer);
                }
            }
        }
    }

    ##REGISTRAR

    if (isset($_POST['numIdentificacion'])) {
        $tipoIdent = $_POST['tipo'];
        $numDoc = $_POST['numIdentificacion'];
        $nombre = $_POST['nombreR'];
        $apellido = $_POST['apellidoR'];
        $correo = $_POST['emailR'];
        $contraseña = $_POST['contraseñaR'];
        $tipoUsu = $_POST['tipoUsuario'];
        $password_hasheada = password_hash($contraseña, PASSWORD_DEFAULT);
        $usuario = new Usuario($numDoc, $tipoIdent, $nombre, $apellido, $correo, $password_hasheada, $tipoUsu);
        $confir = $dao->confirCorreo($correo);
        if ($confir == false) {
            echo '<script type="text/javascript">
            function miFuncion() {
            Swal.fire({
                icon: "warning",
                text: "Usuario ya registrado, ¡Inicie Sesión!"
            })
        }
        window.onload = miFuncion;
        </script>';
        } else {
            $respuesta = $dao->crear($usuario);
            if ($respuesta == true) {
                header("Location: ../vistas/inicioSesion.php");
            } else {
                echo '<script type="text/javascript">
            function miFuncion() {
            Swal.fire({
                icon: "warning",
                text: "Usuario ya registrado, ¡Inicie Sesión!"
            })
        }
        window.onload = miFuncion;
        </script>';
            }
        }
    }

    if (isset($_POST['correoRecu'])) {
        $correoR = $_POST['correoRecu'];
        $confirmar = $dao->confirCorreo($correoR);
        if ($confirmar == false) {
            $token = bin2hex(random_bytes(50));
            $expires = date("U") + 1800;
            $con = $dao->actuToken($token, $expires, $correoR);
            if ($con == true) {
                $resetLink = "http://localhost/proyectoNomina/vistas/recuperarContraseña.php?token=" . $token;
                require '../vendor/autoload.php';

                $mail = new PHPMailer(true);

                try {
                    // Configuración del servidor SMTP
                    $mail->isSMTP();
                    $mail->Host = 'smtp-mail.outlook.com'; // Servidor SMTP
                    $mail->SMTPAuth = true;
                    $mail->Username = 'sena_pruebas@outlook.com'; 
                    $mail->Password = 'adso2024'; 
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    // Recipientes
                    $mail->setFrom('sena_pruebas@outlook.com', 'Recuperación de contraseña');
                    $mail->addAddress($correoR);

                    // Contenido del correo
                    $mail->isHTML(true);
                    $mail->Subject = 'Recuperación de Contraseña';
                    $mail->Body = "Haga clic en el siguiente enlace para restablecer su contraseña: <a href='$resetLink'>$resetLink</a>";

                    $mail->send();
                    echo 'El mensaje ha sido enviado';
                    header("Location: ../vistas/inicioSesion.php");
                } catch (Exception $e) {
                    echo "El mensaje no pudo ser enviado. Error: {$mail->ErrorInfo}";
                }
            } else {
                echo ("Correo Errado");
            }
        } else {
            echo '<script type="text/javascript">
            function miFuncion() {
            Swal.fire({
                icon: "warning",
                text: "Usuario no registrado, ¡Por favor Registrese!"
            }).then(() => {
                window.location.href = "../vistas/registrarse.php"; 
            });
        }
        window.onload = miFuncion;
        </script>';
        }
    }

    #Recuperar Contraseña
    if (isset($_POST['token'])) {
        $tokenR = $_POST['token'];
        $newPassword = password_hash($_POST['contraseñaR'], PASSWORD_DEFAULT);
        $resulRC = $dao->verificarCod($newPassword, $tokenR);
        header("Location: ../vistas/inicioSesion.php");
        if ($resulRC == true) {
            echo'<script type="text/javascript">
            function mostrarAlertaYRecargar() {
            Swal.fire({
                icon: "success",
                text: "Su contraseña ha sido actualizada."
        }).then(() => {
            window.location.href = "../vistas/inicioSesion.php"; 
        });
        }
        window.onload = miFuncion;
        </script>
        ';
        header("Location: ../vistas/inicioSesion.php");
        }else{
            echo '<script type="text/javascript">
            function miFuncion() {
            Swal.fire({
                icon: "warning",
                text: "El token es inválido o ha expirado."
            })
        }
        window.onload = miFuncion;
        </script>';
        }
    }
    ?>
</body>

</html>