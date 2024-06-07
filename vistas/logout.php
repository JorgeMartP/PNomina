<?php
session_start();
session_unset();
session_destroy();

setcookie("cookiesrol", "", time() - 2592000, '/'); // Tiempo en el pasado para eliminar la cookie

setcookie("cookiesid", "", time() - 2592000, '/');

header("Location: ../vistas/inicioSesion.php");
exit();


?>