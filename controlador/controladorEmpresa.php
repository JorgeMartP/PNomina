<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/estiloCard.css">
    <link rel="stylesheet" href="../styles/modal.css">
    <title>Empresa</title>
</head>
<body>
<?php 
require('../dao/DaoEmpresaImp.php');

// Función para validar un archivo PDF
function validarPDF($archivo, $tamañoMaximo = 1048576, $tiposPermitidos = ["application/pdf"]) {
    // Verifica si se ha enviado un archivo
    if ($archivo['error'] === UPLOAD_ERR_OK) {
        // Obtener los detalles del archivo
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

        // Mover el archivo a la carpeta de destino
        if (move_uploaded_file($archivoTemp, $rutaCompleta)) {
            return $rutaCompleta;
        } else {
            return "Error al mover el archivo PDF.";
        }
    } else {
        return "No se ha enviado ningún archivo o ocurrió un error en la carga.";
    }
}

function validarImagen($archivo) {
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

// Listar todas las empresas
$Empresas = $dao->listar();

// Si se envió el formulario para agregar una empresa
if(isset($_POST['bottonEm'])){
    $nombreEmpresa = $_POST['nombre'];
    $nitEmpresa = $_POST['nit'];
    $direccionEmpresa = $_POST['direccion'];
    $telefonoEmpresa = $_POST['telefono'];
    $correoEmpresa = $_POST['correo'];
    $tipoContribuyente = $_POST['tipoContribuyente'];
    $digitoVerificacion = $_POST['digitoVerificacion'];
    $rut = $_POST['rut'];

    // Verificar si se han proporcionado archivos de imagen y PDF
    if (!empty($_FILES['imagen']['name']) && !empty($_FILES['pdf']['name'])){
        // Validar y guardar la imagen y el PDF
        $logo = validarImagen($_FILES['imagen']);
        $camaraComercio = validarPDF($_FILES['pdf']);

        // Verificar si hubo errores en la validación de los archivos
        if (is_string($logo) && is_string($camaraComercio)) {
            // Crear un objeto Empresa con los datos del formulario y los archivos
            $e = new Empresa($tipoContribuyente, $digitoVerificacion, $nitEmpresa, $nombreEmpresa, $telefonoEmpresa, $correoEmpresa, $direccionEmpresa, $logo, $rut, $camaraComercio);
            
            // Registrar la empresa en la base de datos
            $resultado = $dao->registrar($e);
            
            // Redireccionar a la página principal si el registro es exitoso
            if ($resultado == true){
                header("Location: ../vistas/empresa.php");
                exit(); // Importante: terminar la ejecución del script después de redireccionar
            } else {
                echo '<script type="text/javascript">
                        function mostrarAlerta() {
                            Swal.fire({
                                icon: "warning",
                                title: "Error en el registro",
                                text: "La empresa ya está registrada"
                            });
                        }
                        window.onload = mostrarAlerta;
                      </script>';
            }
        } else {
            // Mostrar mensajes de error si la validación de los archivos falló
            echo $logo; // Muestra el mensaje de error de la imagen
            echo $camaraComercio; // Muestra el mensaje de error del PDF
        }
    } else {
        echo "Complete todos los campos y seleccione los archivos.";
    }
}

// Si se envió el ID de una empresa para eliminar
if(isset($_GET['empresa'])){
    $nit = $_GET['empresa'];
    $empresa = $dao->traer($nit);

    // Eliminar todos los empleados asociados a la empresa
    $resultado2 = $dao->eliminarEmpleado($empresa);

    // Eliminar la empresa de la base de datos
    $resultado = $dao->eliminar($empresa);

    // Redireccionar a la página principal si la eliminación es exitosa
    if ($resultado == true && $resultado2 == true){
        header("Location: controladorEmpresa.php");
        exit(); // Importante: terminar la ejecución del script después de redireccionar
    } else {
        echo $resultado; // Mostrar mensaje de error si la eliminación falló
    }
}

?>    
</body>
</html>

