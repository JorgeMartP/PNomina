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
require_once('../dao/DaoEmpleadoImplementacion.php');
    require_once('../dao/DaoEmpresaImp.php');
    // Se crea una instancia de la clase DaoEmpleadoImplementacion
$dao = new DaoEmpleadoImplementacion();
// Se crea una instancia de la clase DaoEmpresaImp
$daoEmpre = new DaoEmpresaImp();

// Se comprueba si se recibieron los parámetros 'empresa' e 'id' por GET
if(isset($_GET['empresa']) && isset($_GET['id'])){
    // Se obtiene el valor del parámetro 'empresa'
    $objEmpresa = $_GET['empresa'];
    // Se obtiene el valor del parámetro 'id'
    $identificacionE = $_GET['id'];
} else {
    echo "No se enviaron todos los parámetros necesarios.";
    exit; // Terminar la ejecución si no se reciben todos los parámetros necesarios
}

// Se obtiene el objeto Empresa correspondiente a la empresa seleccionada
$empresa = $daoEmpre->traer($objEmpresa);
// Se obtienen los datos del empleado a editar
$empleado = $dao->traer($identificacionE, $objEmpresa);

// Verificar si se envió el formulario para actualizar el empleado
if (isset($_POST['boton'])) {
    // Se obtienen los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $identificacion = $_POST['identificacion'];
    $tipoDocumento = $_POST['tipoDocumento'];
    $genero = $_POST['genero'];
    $correo = $_POST['correo'];
    $fechaNacimiento = $_POST['fechaNacimiento'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $fechaExpedicion = $_POST['fechaExpedicion'];
    $estadoCivil = $_POST['estadoCivil'];
    $nivelEstudio = $_POST['nivelEstudio'];
    $departamento = $_POST['departamento']; // Nuevo campo
    $codEstadoEmpleado = $_POST['codEstadoEmpleado']; // Nuevo campo

    // Actualizar los datos del objeto Empleado con los datos del formulario
    $empleado->setNombre($nombre);
    $empleado->setApellido($apellido);
    $empleado->setIdentificacion($identificacion);
    $empleado->setTipoDocumento($tipoDocumento);
    $empleado->setGenero($genero);
    $empleado->setCorreo($correo);
    $empleado->setFechaNacimiento($fechaNacimiento);
    $empleado->setTelefono($telefono);
    $empleado->setDireccion($direccion);
    $empleado->setCiudad($ciudad);
    $empleado->setFechaExpedicion($fechaExpedicion);
    $empleado->setEstadoCivil($estadoCivil);
    $empleado->setNivelEstudio($nivelEstudio);
    $empleado->setDepartamento($departamento); // Nuevo campo
    $empleado->setCodEstadoEmpleado($codEstadoEmpleado); // Nuevo campo

    // Asignar la empresa al objeto Empleado
    $empleado->ingresarEmpresa($empresa);

    // Actualizar los datos del empleado en la base de datos
    $resultado = $dao->modificar($empleado);

    // Si la actualización fue exitosa, redirigir a la página de controladorEmpleado.php
    if($resultado){
        header("Location: controladorEmpleado.php?empresa=". $objEmpresa);
        exit; // Terminar la ejecución después de redirigir
    } else {
        echo "Error al actualizar el empleado.";
    }
}
    // Se incluye el archivo de la vista para editar empleado
    include('../vistas/editarEmpleado.php');
    ?>
</body>
</html>