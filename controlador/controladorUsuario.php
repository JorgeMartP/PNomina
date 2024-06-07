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
            header("Location: ../vistas/empresa.php");
            break;
        case 3:
            header("Location: ../vistas/administrador.php");
            break;
        default:
    }
}
## Inicio de Sesión 
    $dao = new DaoUsuarioImp();
    if (isset($_POST['correo'])) {
        $correo = $_POST['correo'];
        $contraseña = $_POST['contraseña_Login'];
        $traer = $dao->traer($correo);
        echo($_POST['recordar']);
        if (isset($_POST["recordar"])) {
            setcookie("cookiesrol", $traer->getCodTipoUsuario(), time() + 259200, "/", ".localhost", true, true);
            setcookie("cookiesid", $traer->getCorreoU(), time() + 259200, "/", ".localhost", true, true);
        }
        if ($traer == false) {
            
            $massaje = "Usuario no registrado. Registrese";
            $_SESSION['mensaje'] = $massaje;
            header("Location: ../vistas/inicioSesion.php");
        } else {
            if (password_verify($contraseña, $traer->getContraseña()) && $correo == $traer->getCorreoU()) {
                if ($traer->getCuenta_bloqueada()) {
                    $massaje = "Tu cuenta está bloqueada. Por favor, recupera tu contraseña.";
                    $_SESSION['mensaje'] = $massaje;
                    header("Location: ../vistas/inicioSesion.php");
                }else{
                    
                    $_SESSION['rol'] = $traer->getCodTipoUsuario();
                    $_SESSION['idUsuario'] = $traer->getCorreoU();
                    $dao->actualizarIntentos($traer->getCorreoU());
                    sesion($_SESSION['rol']);
                }
            } else {
                $intentos = $traer->getIntentos_fallidos();
                $intentosT = $intentos + 1;
                $intentosRes = 3 - $intentosT;
                $traer->setIntentos_fallidos($intentosT);
                if($intentosT >= 3){
                    $respuestas = $dao->bloquearCuenta($traer->getCorreoU());
                    if($respuestas == true){
                        $mensaje = "Cuenta Bloqueada por favor Cambie la contraseña";
                        $_SESSION['mensaje2'] = $mensaje;
                        header("Location: ../vistas/recovery.php");
                    }
                }else{
                    $respuesta2 =  $dao->aumentarIntentos($traer);
                    if($respuesta2 == true){
                        $mensaje = "Contraseña incorrecta, Tienes " . $intentosRes . " Restantes". $_POST['recordar'] . $_COOKIE['cookiesRol'];
                        $_SESSION['mensaje'] = $mensaje;
                        header("Location: ../vistas/inicioSesion.php");
                    }
                    
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
            $massaje = "Usuario registrado correctamente. Por favor, inicie sesión.";
            $_SESSION['mensaje'] = $massaje;
            header("Location: ../vistas/inicioSesion.php");
        } else {
            $respuesta = $dao->crear($usuario);
            if ($respuesta == true) {
                $massaje = "Usuario registrado correctamente. Por favor, inicie sesión.";
                $_SESSION['mensaje'] = $massaje;
                header("Location: ../vistas/inicioSesion.php");
            } else {
                
                $massaje = "Usuario ya registrado, ¡Inicie Sesión!.";
                $_SESSION['mensaje'] = $massaje;
                header("Location: ../vistas/inicioSesion.php");
                
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
                    $mail->setFrom('sena_pruebas@outlook.com', 'PayRoll');
                    $mail->addAddress($correoR);

                    // Contenido del correo
                    $mail->isHTML(true);
                    $mail->Subject = 'Recuperación de Contraseña';
                    $mail->Body = "Haga clic en el siguiente enlace para restablecer su contraseña: <a href='$resetLink'>click Aqui</a>";

                    $mail->send();
                    $mess = "Hemos enviado un correo a su dirección. Por favor, revise su bandeja de entrada o carpeta de spam.";
                    $_SESSION['mensaje'] = $mess;
                    header("Location: ../vistas/inicioSesion.php");
                } catch (Exception $e) {
                    echo "El mensaje no pudo ser enviado. Error: {$mail->ErrorInfo}";
                }
            } else {
                echo ("Correo Errado");
            }
        } else {
            $mensaje = "Correo Incorrecto vuelve a Intentar";
            $_SESSION['mensaje2'] = $mensaje;
            header("Location: ../vistas/recovery.php");
        }
    }

    #Recuperar Contraseña
    if (isset($_POST['token'])) {
        $tokenR = $_POST['token'];
        $newPassword = password_hash($_POST['contraseñaR'], PASSWORD_DEFAULT);
        $resulRC = $dao->verificarCod($newPassword, $tokenR);
        if ($resulRC == true) {
            $massaje = "Su contraseña ha sido actualizada.";
            $_SESSION['mensaje'] = $massaje;
            header("Location: ../vistas/inicioSesion.php");
        }else{
            
            $massaje = "El token es inválido o ha expirado. Por favor, solicita el correo nuevamente.";
            $_SESSION['mensaje'] = $massaje;
            header("Location: ../vistas/recovery.php");
        }
    }

    #Traer los usuario 

    ?>
</body>

</html>