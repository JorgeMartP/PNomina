<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles/modal.css">
</head>

<body>
    <?php
    // Se incluye el archivo DaoEmpresaImp.php
    require('../dao/DaoEmpresaImp.php');
    // Función para validar un archivo PDF
    function validarPDF($archivo, $tamañoMaximo = 1048576, $tiposPermitidos = ["application/pdf"])
    {
        // Se obtienen los datos del archivo enviado
        $nombreArchivo = $archivo['name'];
        $tipoArchivo = $archivo['type'];
        $tamañoArchivo = $archivo['size'];
        $archivoTemp = $archivo['tmp_name'];
        $carpetaDestino = "../form-data/";
        $rutaCompleta = $carpetaDestino . $nombreArchivo;
        // Verifica el tipo de archivo
        if (!in_array($tipoArchivo, $tiposPermitidos)) {
            echo "Tipo de archivo no permitido. Solo se permiten archivos PDF.";
        }
        // Verifica el tamaño del archivo
        if ($tamañoArchivo > $tamañoMaximo) {
            return "El archivo PDF supera el tamaño máximo permitido.";
        }
        // Si pasa las validaciones, se mueve el archivo a la carpeta destino
        if (move_uploaded_file($archivoTemp, $rutaCompleta)) {
            return $rutaCompleta;
        } else {
            echo "Error al mover el archivo PDF.";
        }
    }
    // Función para validar una imagen
    function validarImagen($archivo)
    {
        // Se obtienen los datos de la imagen enviada
        $nombreArchivo = $archivo['name'];
        $tipoArchivo = $archivo['type'];
        $tamañoArchivo = $archivo['size'];
        $archivoTemp = $archivo['tmp_name'];
        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
        $tamañoMaximo = 3 * 1024 * 1024;
        // Verifica el tipo de archivo
        if (!in_array($tipoArchivo, $tiposPermitidos)) {
            echo "Tipo de archivo no permitido.";
        }
        // Verifica el tamaño del archivo
        if ($tamañoArchivo > $tamañoMaximo) {
            echo "El archivo supera el tamaño máximo permitido.";
        }
        // Si pasa las validaciones, se mueve la imagen a la carpeta destino
        $carpetaDestino = '../form-data/';
        $rutaCompleta = $carpetaDestino . $nombreArchivo;
        if (move_uploaded_file($archivoTemp, $rutaCompleta)) {
            return $rutaCompleta;
        }
    }
    // Se crea una instancia del objeto DaoEmpresaImp
    $dao = new DaoEmpresaImp();
    // Si se recibe un parámetro 'id', se busca la empresa correspondiente
    if (isset($_GET['id'])) {
        $nit = $_GET['id'];
        $Actualizar = $dao->traer($nit);
    }
    // Se obtienen los datos del logo y la cámara de comercio de la empresa
    $logoEmpresa = $Actualizar->getLogo();
    $camaraComercio1 = $Actualizar->getCamaraComercio();
    // Si se ha enviado el formulario de actualización
    if (isset($_POST['bottonUp'])) {
        $nombreEmpresa = $_POST['nombreUp'];
        $nitEmpresa = $_POST['nitUp'];
        $direccionEmpresa = $_POST['direccionUp'];
        $telefonoEmpresa = $_POST['telefonoUp'];
        $correoEmpresa = $_POST['correoUp'];
        $tipoContribuyente = $_POST['tipoContribuyenteUp'];
        $digitoVerificacion = $_POST['digitoVerificacionUp'];
        $rut = $_POST['rutUp'];
        // Se crea un objeto Empresa con los datos actualizados
        $a = new Empresa($tipoContribuyente, $digitoVerificacion, $nitEmpresa, $nombreEmpresa, $telefonoEmpresa, $correoEmpresa, $direccionEmpresa, $logoEmpresa, $rut, $camaraComercio1);
        // Se verifica si se han enviado archivos para actualizar dependiendo si el usuario envia o no la imagen o el pdf
        if (!empty($_FILES['imagen']['name']) && !empty($_FILES['pdf']['name'])) {
            $logo = validarImagen($_FILES['imagen']);
            $camaraComercio = validarPDF($_FILES['pdf']);
            $a->setLogo($logo);
            $a->setCamaraComercio($camaraComercio);
        } elseif (!empty($_FILES['imagen']['name']) && empty($_FILES['pdf']['name'])) {
            $logo = validarImagen($_FILES['imagen']);
            $a->setLogo($logo);
        } elseif (empty($_FILES['imagen']['name']) && !empty($_FILES['pdf']['name'])) {
            $camaraComercio = validarPDF($_FILES['pdf']);
            $a->setCamaraComercio($camaraComercio);
        }
        // Se realiza la modificación en la base de datos
        $resultado = $dao->modificar($a);
        // Si la modificación fue exitosa, se redirige a la página principal
        if ($resultado) {
            header("Location: controladorEmpresa.php");
        } else {
            echo "Hubo un problema al modificar los datos.";
        }
    } else {
        echo "No se enviaron los datos correctamente.";
    }
    ?>
</body>
</html>