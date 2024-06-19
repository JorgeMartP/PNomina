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
    function validarPDF($archivo, $tamañoMaximo = 1048576, $tiposPermitidos = ["application/pdf"]) {
        // Se obtienen los datos del archivo enviado
        $nombreArchivo = $archivo['name'];
        $tipoArchivo = $archivo['type'];
        $tamañoArchivo = $archivo['size'];
        $archivoTemp = $archivo['tmp_name'];
        $carpetaDestino = "../form-data/";
        $rutaCompleta = $carpetaDestino . $nombreArchivo;
    
        // Verifica el tipo de archivo
        if (!in_array($tipoArchivo, $tiposPermitidos)) {
            return "Tipo de archivo no permitido. Solo se permiten archivos PDF.";
        }
    
        // Verifica el tamaño del archivo
        if ($tamañoArchivo > $tamañoMaximo) {
            return "El archivo PDF supera el tamaño máximo permitido.";
        }
    
        // Si pasa las validaciones, se mueve el archivo a la carpeta destino
        if (move_uploaded_file($archivoTemp, $rutaCompleta)) {
            return $rutaCompleta;
        } else {
            return "Error al mover el archivo PDF.";
        }
    }
    function validarImagen($archivo) {
        // Se obtienen los datos de la imagen enviada
        $nombreArchivo = $archivo['name'];
        $tipoArchivo = $archivo['type'];
        $tamañoArchivo = $archivo['size'];
        $archivoTemp = $archivo['tmp_name'];
        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
        $tamañoMaximo = 3 * 1024 * 1024; // 3 MB
    
        // Verifica el tipo de archivo
        if (!in_array($tipoArchivo, $tiposPermitidos)) {
            return "Tipo de archivo no permitido. Solo se permiten imágenes JPEG, PNG o GIF.";
        }
    
        // Verifica el tamaño del archivo
        if ($tamañoArchivo > $tamañoMaximo) {
            return "El archivo de imagen supera el tamaño máximo permitido.";
        }
    
        // Carpeta de destino para la imagen
        $carpetaDestino = '../form-data/';
        $rutaCompleta = $carpetaDestino . $nombreArchivo;
    
        // Mover el archivo a la carpeta de destino
        if (move_uploaded_file($archivoTemp, $rutaCompleta)) {
            return $rutaCompleta;
        } else {
            return "Error al mover el archivo de imagen.";
        }
    }
    // Crear una instancia de la clase DaoEmpresaImp
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

    // Se verifica si se han enviado archivos para actualizar
    if (!empty($_FILES['imagen']['name']) || !empty($_FILES['pdf']['name'])) {
        // Validar y actualizar los archivos según corresponda
        if (!empty($_FILES['imagen']['name'])) {
            $logo = validarImagen($_FILES['imagen']);
            if (is_string($logo)) {
                $a->setLogo($logo);
            } else {
                echo $logo; // Mostrar mensaje de error si la validación falla
            }
        }

        if (!empty($_FILES['pdf']['name'])) {
            $camaraComercio = validarPDF($_FILES['pdf']);
            if (is_string($camaraComercio)) {
                $a->setCamaraComercio($camaraComercio);
            } else {
                echo $camaraComercio; // Mostrar mensaje de error si la validación falla
            }
        }
    }

    // Se realiza la modificación en la base de datos
    $resultado = $dao->modificar($a);

    // Si la modificación fue exitosa, se redirige a la página principal
    if ($resultado) {
        header("Location: controladorEmpresa.php");
        exit(); // Terminar la ejecución después de redireccionar
    } else {
        echo "Hubo un problema al modificar los datos.";
    }
} else {
    echo "No se enviaron los datos correctamente.";
}

    ?>
</body>
</html>