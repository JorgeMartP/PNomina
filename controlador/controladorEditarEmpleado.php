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
    // Se comprueba si se recibió el parámetro 'empresa' por GET
    if(isset($_GET['empresa'])){
        // Se obtiene el valor del parámetro 'empresa'
        $objEmpresa = $_GET['empresa'];
         // Se obtiene el valor del parámetro 'id'
        $identificacionE = $_GET['id'];
    }
    // Si no se recibe el parámetro 'empresa', se muestra un mensaje de error
    else{
        echo "no se envio el nit empresa";
    }
    // Se obtiene el objeto Empresa correspondiente a la empresa seleccionada
    $empresa = $daoEmpre->traer($objEmpresa);
    // Se obtienen los datos del empleado a editar
    $Empleados=$dao->traer($identificacionE, $objEmpresa);
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
        // Se crea un objeto Empleado con los datos del formulario
        $e = new Empleado(
            $nombre,
            $apellido,
            $identificacion,
            $tipoDocumento,
            $genero,
            $correo,
            $fechaNacimiento,
            $telefono,
            $direccion,
            $ciudad,
            $fechaExpedicion,
            $estadoCivil,
            $nivelEstudio
        );
        // Se asigna la empresa al empleado
        $e->ingresarEmpresa($empresa);
        // Se actualizan los datos del empleado en la base de datos
        $dao->modificar($e);
        // Si la actualización fue exitosa, se redirige a la página de controladorEmpleado.php
        if($dao == true){
            header("Location: controladorEmpleado.php?empresa=". $objEmpresa);
        }
    }
    // Se incluye el archivo de la vista para editar empleado
    include('../vistas/editarEmpleado.php');
    ?>
</body>
</html>