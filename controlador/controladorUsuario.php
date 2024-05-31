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
        header("Location: inicioSesion.php");
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
            text: "Usuario no registrado. Pidele al administrador que te registre"
        })
        }
        window.onload = miFuncion;
        </script>';
        } else {
            if (isset($_POST["recordar"])) {
                setcookie("cookiesRol", $traer->getCodTipoUsuario(), time() + 259200);
                setcookie("cookiesId", $traer->getIdUsuario(), time() + 259200);
            }
            if (password_verify($contraseña, $traer->getContraseña()) && $correo == $traer->getCorreoU()) {
                $_SESSION['rol'] = $traer->getCodTipoUsuario();
                $_SESSION['idUsuario'] = $traer->getContraseña();
                sesion($_SESSION['rol']);
                ## SI LO INGRESADO POR EL USUARIO NO COICIDEN CON LO QUE HAY EN LA BASE DE DATOS LE INFORMACION QUE LOS DATOS ESTAN INCORRECTOS
            } else {
                switch ($_COOKIE['intentos']) {
                    case 0:
                        $_COOKIE['intentos'] = 1;
                        echo ('Tienes Dos intentos');
                        break;
                    case 1:
                        $_COOKIE['intentos'] = 2;
                        echo ('Tienes 1 intento');
                        break;
                    case 2:
                        $_COOKIE['intentos'] = 3;
                        echo ('No tiene mas intentos vuelve intentarlo mas tarde');
                    default:
                        break;
                }
                echo '<script type="text/javascript">
            function miFuncion() {
            Swal.fire({
                icon: "warning",
                text: "Contraseña o Usuario incorrectos  intente nuevamente"
            })
        }
        window.onload = miFuncion;
        </script>';
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
                $resetLink = "http://localhost/vistas/recuperarContraseña.php?token=" . $token;
                require '../vendor/autoload.php';

                $mail = new PHPMailer(true);

                try {
                    // Configuración del servidor SMTP
                    $mail->isSMTP();
                    $mail->Host = 'smtp-mail.outlook.com'; // Servidor SMTP
                    $mail->SMTPAuth = true;
                    $mail->Username = 'sena_pruebas@outlook.com'; // Usuario SMTP
                    $mail->Password = 'adso2024'; // Contraseña SMTP
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    // Recipientes
                    $mail->setFrom('sena_pruebas@outlook.com', 'Mailer');
                    $mail->addAddress($correoR);

                    // Contenido del correo
                    $mail->isHTML(true);
                    $mail->Subject = 'Recuperación de Contraseña';
                    $mail->Body = "Haga clic en el siguiente enlace para restablecer su contraseña: <a href='$resetLink'>$resetLink</a>";

                    $mail->send();
                    echo 'El mensaje ha sido enviado';
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
    include('../vistas/inicioSesion.php')
    ?>
</body>

</html>