<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/styles.css" />
    <link rel="stylesheet" href="../styles/modal.css">
    <title>Document</title>
</head>

<body>
    <?php
    require_once('../dao/DaoEmpleadoImplementacion.php');
    require_once('../dao/DaoEmpresaImp.php');
    // Crear instancias de los DAO de Empleado y Empresa
    $dao = new DaoEmpleadoImplementacion();
    $daoEmpre = new DaoEmpresaImp();
    
    // Verificar si se ha enviado el parámetro 'empresa' a través de GET
    if(isset($_GET['empresa'])){
        // Obtener el valor de 'empresa'
        $objEmpresa = $_GET['empresa'];
        // Obtener la información de la empresa correspondiente
        $empresa = $daoEmpre->traer($objEmpresa);
        // Obtener la lista de empleados asociados a la empresa
        $Empleados = $dao->listar($objEmpresa);
    }
    
    // Verificar si se ha enviado el formulario para agregar un empleado
    if (isset($_POST['boton'])) {
        // Obtener los datos del formulario
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
    
        // Crear un objeto Empleado con los datos del formulario
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
            $nivelEstudio,
            $departamento, // Nuevo campo
            $codEstadoEmpleado // Nuevo campo
        );
    
        // Asociar el empleado con la empresa correspondiente
        $e->ingresarEmpresa($empresa);
        // Registrar el empleado en la base de datos
        $resultado = $dao->registrar($e);
    
        // Redireccionar a la página de controlador de empleado
        if($resultado){
            header("Location: controladorEmpleado.php?empresa=". $objEmpresa);
            exit(); // Salir después de redireccionar
        }
    }
    
    // Verificar si se han enviado los parámetros 'idEmp' e 'idEmpresa' a través de GET
    if(isset($_GET['idEmp']) && isset($_GET['idEmpresa'])){
        // Obtener los valores de 'idEmp' e 'idEmpresa'
        $idEmpresa = $_GET['idEmpresa'];
        $idEmpleado = $_GET['idEmp'];
        // Obtener la información del empleado específico
        $Empleado12 = $dao->traer($idEmpleado, $idEmpresa);
        
        if ($Empleado12) {
            // Eliminar el empleado de la base de datos
            $resultado = $dao->eliminar($Empleado12);
    
            // Redireccionar a la página de controlador de empleado
            if($resultado){
                header("Location: controladorEmpleado.php?empresa=". $idEmpresa);
                exit(); // Salir después de redireccionar
            }
        } else {
            echo "Empleado no encontrado.";
        }
    }
    // Incluir la vista de empleado
    include('../vistas/empleado.php');
    ?>
</body>

</html>