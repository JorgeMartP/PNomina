<?php

include ('daoEmpleado.php');
require_once('../conexion/conexion.php');
include('../modelo/empleado.php');
// Definición de la clase DaoEmpleadoImplementacion que implementa la interfaz DaoEmpleado
class DaoEmpleadoImplementacion extends Conexion implements DaoEmpleado{
    // Método para registrar un empleado en la base de datos
    public function registrar(Empleado $e){

        try{
            // Verificar si la conexión no es nula
            if($this->getCnx()!=null){
            // Obtener los atributos del empleado
            $nombre=$e->getNombre();
            $apellido=$e->getApellido();
            $identificacion=$e->getIdentificacion();
            $tipoDocumento=$e->getTipoDocumento();
            $genero=$e->getGenero();
            $correo=$e->getCorreo();
            $fechaNacimiento=$e->getFechaNacimiento();
            $telefono=$e->getTelefono();
            $direccion=$e->getDireccion();
            $ciudad=$e->getCiudad();
            $fechaExpedicion=$e->getFechaExpedicion();
            $estadoCivil=$e->getEstadoCivil();
            $nivelEstudio=$e->getNivelEstudio();
            $empresa = $e->obtenerNitEmpresa();
            // Consulta SQL para insertar el empleado en la base de datos
            $sql="insert into empleado (identificacion, nombre, apellido, tipoDocumento, genero, correo, fechaNacimiento, telefono, direccion, ciudad, fechaExpedicion, estadoCivil, nivelEstudio, nit) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            // Preparar la consulta SQL
            $stmt=$this->getCnx()->prepare($sql);
            // Ejecutar la consulta con los parámetros proporcionados
            $resultado = $stmt->execute([$identificacion, $nombre, $apellido, $tipoDocumento, $genero,
            $correo, $fechaNacimiento, $telefono, $direccion, $ciudad, $fechaExpedicion, $estadoCivil,
            $nivelEstudio, $empresa]);
            //Retorna el resultado de la consulta
            return $resultado;
            }else {
                 // Mensaje de error si la conexión es nula
                echo $this->getCnx().'Es nulo <br>';
            }
        }catch(PDOException $p){
            // Mensaje de error en caso de excepción
            echo $p->getMessage().'***********************';
        }
    }
    // Método para modificar un empleado en la base de datos
    public function modificar(Empleado $e){        
        $nombre=$e->getNombre();    
        $apellido=$e->getApellido();
        $identificacion=$e->getIdentificacion();
        $tipoDocumento=$e->getTipoDocumento();
        $genero=$e->getGenero();
        $correo=$e->getCorreo();
        $fechaNacimiento=$e->getFechaNacimiento();
        $telefono=$e->getTelefono();
        $direccion=$e->getDireccion();
        $ciudad=$e->getCiudad();
        $fechaExpedicion=$e->getFechaExpedicion();
        $estadoCivil=$e->getEstadoCivil();
        $nivelEstudio=$e->getNivelEstudio();
        $empresa = $e->obtenerNitEmpresa();
        // Consulta SQL para actualizar el empleado en la base de datos
        $stmt=$this->getCnx()->prepare("UPDATE empleado " .
        "SET nombre = '$nombre'," .
        "apellido = '$apellido'," .
        "tipoDocumento = '$tipoDocumento'," .
        "genero = '$genero'," .
        "correo = '$correo'," .
        "fechaNacimiento = '$fechaNacimiento'," .
        "telefono = '$telefono'," .
        "direccion = '$direccion'," .
        "ciudad = '$ciudad'," .
        "fechaExpedicion = '$fechaExpedicion'," .
        "estadoCivil= '$estadoCivil'," .
        "nivelEstudio= '$nivelEstudio'" .
        "where identificacion = '$identificacion' and nit = '$empresa'");
        // Ejecutar la consulta
        $stmt->execute();        
    }
    // Método para eliminar un empleado de la base de datos
    public function eliminar(Empleado $e){        
        $identificacion=$e->getIdentificacion();
        // Consulta SQL para eliminar el empleado
        $stmt=$this->getCnx()->prepare("delete from empleado where identificacion=$identificacion");
        // Ejecutar la consulta
        $resultado = $stmt->execute();  
        return $resultado;
    }
    // Método para listar todos los empleados de una empresa
    public function listar($empresa){
        $lista = null;
        try{    
            // Consulta SQL para listar todos los empleados de una empresa
            $stmt = $this->getCnx()->prepare("select * from empleado where nit =  $empresa");
            $lista = array();
            // Ejecutar la consulta
            $stmt->execute();
            // Recorrer el resultado de la consulta y crear objetos Empleado
            foreach ($stmt as $key ) {           
                $e = new Empleado(null,null,null,null,null,null,null,null,null,null,null,null,null);
                $e->setNombre($key['nombre']);
                $e->SetApellido($key['apellido']);
                $e->setIdentificacion($key['identificacion']);
                $e->setTipoDocumento($key['tipoDocumento']);
                $e->setGenero($key['genero']);
                $e->setCorreo($key['correo']);
                $e->setGenero($key['genero']); 
                $e->setFechaNacimiento($key['fechaNacimiento']);
                $e->setTelefono($key['telefono']);
                $e->setDireccion($key['direccion']); 
                $e->setCiudad($key['ciudad']);
                $e->setFechaExpedicion($key['fechaExpedicion']);
                $e->setEstadoCivil($key['estadoCivil']);
                $e->setNivelEstudio($key['nivelEstudio']);
                // Agregar el objeto Empleado al array
                array_push($lista,$e);           
            }        
            //$this->getCnx()->close();
        }catch(PDOException $e){
            // Manejo de excepciones
            $e->getMessage().'error en listar de DaoAprendizImpl';
        }
        // Devolver la lista de empleados
            return $lista;       
        } 
    // Método para obtener un empleado por su identificación y el NIT de la empresa
    public function traer($identificacion, $empresa){
        try{
            // Consulta SQL para obtener un empleado por su identificación y el NIT de la empresa    
            $stmt = $this->getCnx()->prepare("select * from empleado where identificacion = $identificacion and nit =  $empresa");
            // Ejecutar la consulta
            $stmt->execute();
            // Recorrer el resultado de la consulta y crear un objeto Empleado
            foreach ($stmt as $key ) {           
                $e = new Empleado(null,null,null,null,null,null,null,null,null,null,null,null,null);
                $e->setNombre($key['nombre']);
                $e->SetApellido($key['apellido']);
                $e->setIdentificacion($key['identificacion']);
                $e->setTipoDocumento($key['tipoDocumento']);
                $e->setGenero($key['genero']);
                $e->setCorreo($key['correo']);
                $e->setGenero($key['genero']); 
                $e->setFechaNacimiento($key['fechaNacimiento']);
                $e->setTelefono($key['telefono']);
                $e->setDireccion($key['direccion']); 
                $e->setCiudad($key['ciudad']);
                $e->setFechaExpedicion($key['fechaExpedicion']);
                $e->setEstadoCivil($key['estadoCivil']);
                $e->setNivelEstudio($key['nivelEstudio']);
            }        
            //$this->getCnx()->close();
        }catch(PDOException $e){
            // Manejo de excepciones
            $e->getMessage().'error en listar de DaoAprendizImpl';
        } 
            // Devolver el objeto Empleado
            return $e;       
    }
}
?>