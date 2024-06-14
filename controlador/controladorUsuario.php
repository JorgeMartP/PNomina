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
    setcookie("cookiesrol", "", time() - 2592000, '/'); // Tiempo en el pasado para eliminar la cookie
    setcookie("cookiesid", "", time() - 2592000, '/');
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
function iniciarSesion($correo, $contraseña, $recordar) {
    $dao = new DaoUsuarioImp();
    $traer = $dao->traer($correo);

    if ($recordar) {
        setcookie("cookiesrol", $traer->getCodTipoUsuario(), time() + 259200, "/", ".localhost", true, true);
        setcookie("cookiesid", $traer->getCorreoU(), time() + 259200, "/", ".localhost", true, true);
    }

    if (!$traer) {
        $_SESSION['mensaje'] = "Usuario no registrado. Registrese";
        header("Location: ../vistas/inicioSesion.php");
    } else {
        if (password_verify($contraseña, $traer->getContraseña()) && $correo == $traer->getCorreoU()) {
            if ($traer->getCuenta_bloqueada()) {
                $_SESSION['mensaje'] = "Tu cuenta está bloqueada. Por favor, recupera tu contraseña.";
                header("Location: ../vistas/inicioSesion.php");
            } else {
                $_SESSION['rol'] = $traer->getCodTipoUsuario();
                $_SESSION['idUsuario'] = $traer->getCorreoU();
                $dao->actualizarIntentos($traer->getCorreoU());
                sesion($_SESSION['rol']);
            }
        } else {
            manejarIntentosFallidos($traer);
        }
    }
}

function manejarIntentosFallidos($traer) {
    $dao = new DaoUsuarioImp();
    $intentos = $traer->getIntentos_fallidos();
    $intentosT = $intentos + 1;
    $intentosRes = 3 - $intentosT;
    $traer->setIntentos_fallidos($intentosT);

    if ($intentosT >= 3) {
        if ($dao->bloquearCuenta($traer->getCorreoU())) {
            $_SESSION['mensaje2'] = "Cuenta Bloqueada por favor Cambie la contraseña";
            header("Location: ../vistas/inicioSesion.php");
        }
    } else {
        if ($dao->aumentarIntentos($traer)) {
            $_SESSION['mensaje'] = "Contraseña incorrecta, Tienes $intentosRes Restantes";
            header("Location: ../vistas/inicioSesion.php");
        }
    }
}

function registrarUsuario($tipoIdent, $numDoc, $nombre, $apellido, $correo, $contraseña, $tipoUsu) {
    $dao = new DaoUsuarioImp();
    $password_hasheada = password_hash($contraseña, PASSWORD_DEFAULT);
    $usuario = new Usuario($numDoc, $tipoIdent, $nombre, $apellido, $correo, $password_hasheada, $tipoUsu);

    if (!$dao->confirCorreo($correo)) {
        $_SESSION['mensaje'] = "Usuario registrado correctamente. Por favor, inicie sesión.";
        header("Location: ../vistas/inicioSesion.php");
    } else {
        if ($dao->crear($usuario)) {
            $_SESSION['mensaje'] = "Usuario registrado correctamente. Por favor, inicie sesión.";
            header("Location: ../vistas/inicioSesion.php");
        } else {
            $_SESSION['mensaje'] = "Usuario ya registrado, ¡Inicie Sesión!.";
            header("Location: ../vistas/inicioSesion.php");
        }
    }
}

function enviarCorreoRecuperacion($correoR) {
    $dao = new DaoUsuarioImp();
    if (!$dao->confirCorreo($correoR)) {
        $token = bin2hex(random_bytes(50));
        $expires = date("U") + 1800;

        if ($dao->actuToken($token, $expires, $correoR)) {
            $resetLink = "http://localhost/proyectoNomina/vistas/recuperarContraseña.php?token=" . $token;
            enviarCorreo($correoR, $resetLink);
        } else {
            echo "Correo Errado";
        }
    } else {
        $_SESSION['mensaje2'] = "Correo Incorrecto vuelve a Intentar";
        header("Location: ../vistas/recovery.php");
    }
}

function enviarCorreo($correoR, $resetLink) {
    require '../vendor/autoload.php';

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp-mail.outlook.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'sena_pruebas@outlook.com';
        $mail->Password = 'adso2024';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('sena_pruebas@outlook.com', 'PayRoll');
        $mail->addAddress($correoR);

        $mail->isHTML(true);
        $mail->Subject = 'Recuperación de Contraseña';
        $mail->Body = "Haga clic en el siguiente enlace para restablecer su contraseña: <a href='$resetLink'>click Aqui</a>";

        $mail->send();
        $_SESSION['mensaje'] = "Hemos enviado un correo a su dirección. Por favor, revise su bandeja de entrada o carpeta de spam.";
        header("Location: ../vistas/inicioSesion.php");
    } catch (Exception $e) {
        echo "El mensaje no pudo ser enviado. Error: {$mail->ErrorInfo}";
    }
}

function recuperarContraseña($tokenR, $nuevaContraseña) {
    $dao = new DaoUsuarioImp();
    $newPassword = password_hash($nuevaContraseña, PASSWORD_DEFAULT);

    if ($dao->verificarCod($newPassword, $tokenR)) {
        $_SESSION['mensaje'] = "Su contraseña ha sido actualizada.";
        header("Location: ../vistas/inicioSesion.php");
    } else {
        $_SESSION['mensaje'] = "El token es inválido o ha expirado. Por favor, solicita el correo nuevamente.";
        header("Location: ../vistas/recovery.php");
    }
}

if (isset($_POST['correo'])) {
    iniciarSesion($_POST['correo'], $_POST['contraseña_Login'], isset($_POST['recordar']));
}

if (isset($_POST['numIdentificacion'])) {
    registrarUsuario($_POST['tipo'], $_POST['numIdentificacion'], $_POST['nombreR'], $_POST['apellidoR'], $_POST['emailR'], $_POST['contraseñaR'], $_POST['tipoUsuario']);
}

if (isset($_POST['correoRecu'])) {
    enviarCorreoRecuperacion($_POST['correoRecu']);
}

if (isset($_POST['token'])) {
    recuperarContraseña($_POST['token'], $_POST['contraseñaR']);
}

    ?>
</body>

</html>