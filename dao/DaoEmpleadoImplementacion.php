<?php

include ('daoEmpleado.php');
require_once('../conexion/conexion.php');
include('../modelo/empleado.php');
// Definición de la clase DaoEmpleadoImplementacion que implementa la interfaz DaoEmpleado
class DaoEmpleadoImplementacion extends Conexion implements DaoEmpleado{
    // Método para registrar un empleado en la base de datos
    public function registrar(Empleado $e) {
        try {
            // Verificar si la conexión no es nula
            if ($this->getCnx() != null) {
                // Obtener los atributos del empleado
                $identificacion = $e->getIdentificacion();
                $nombre = $e->getNombre();
                $apellido = $e->getApellido();
                $tipoDocumento = $e->getTipoDocumento();
                $genero = $e->getGenero();
                $correo = $e->getCorreo();
                $fechaNacimiento = $e->getFechaNacimiento();
                $telefono = $e->getTelefono();
                $direccion = $e->getDireccion();
                $ciudad = $e->getCiudad();
                $fechaExpedicion = $e->getFechaExpedicion();
                $estadoCivil = $e->getEstadoCivil();
                $nivelEstudio = $e->getNivelEstudio();
                $empresa = $e->obtenerNitEmpresa();
                $departamento = $e->getDepartamento();
                $codEstadoEmpleado = $e->getCodEstadoEmpleado();
    
                // Consulta SQL para insertar el empleado en la base de datos
                $sql = "INSERT INTO empleado (
                            identificacion, nombre, apellido, tipoDocumento, genero, correo, 
                            fechaNacimiento, telefono, direccion, ciudad, fechaExpedicion, 
                            estadoCivil, nivelEstudio, nit, departamento, codEstadoEmpleado
                        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
                // Preparar la consulta SQL
                $stmt = $this->getCnx()->prepare($sql);
    
                // Ejecutar la consulta con los parámetros proporcionados
                $resultado = $stmt->execute([
                    $identificacion, $nombre, $apellido, $tipoDocumento, $genero, $correo,
                    $fechaNacimiento, $telefono, $direccion, $ciudad, $fechaExpedicion,
                    $estadoCivil, $nivelEstudio, $empresa, $departamento, $codEstadoEmpleado
                ]);
    
                // Retornar el resultado de la consulta
                return $resultado;
            } else {
                // Mensaje de error si la conexión es nula
                echo $this->getCnx() . ' Es nulo <br>';
            }
        } catch (PDOException $p) {
            // Mensaje de error en caso de excepción
            echo $p->getMessage() . '***********************';
        }
    }
    // Método para modificar un empleado en la base de datos
    public function modificar(Empleado $e) {
        try {
            // Obtener los atributos del empleado
            $nombre = $e->getNombre();
            $apellido = $e->getApellido();
            $identificacion = $e->getIdentificacion();
            $tipoDocumento = $e->getTipoDocumento();
            $genero = $e->getGenero();
            $correo = $e->getCorreo();
            $fechaNacimiento = $e->getFechaNacimiento();
            $telefono = $e->getTelefono();
            $direccion = $e->getDireccion();
            $ciudad = $e->getCiudad();
            $fechaExpedicion = $e->getFechaExpedicion();
            $estadoCivil = $e->getEstadoCivil();
            $nivelEstudio = $e->getNivelEstudio();
            $empresa = $e->obtenerNitEmpresa();
            $departamento = $e->getDepartamento();
            $codEstadoEmpleado = $e->getCodEstadoEmpleado();
    
            // Consulta SQL para actualizar el empleado en la base de datos
            $sql = "UPDATE empleado SET 
                        nombre = ?, 
                        apellido = ?, 
                        tipoDocumento = ?, 
                        genero = ?, 
                        correo = ?, 
                        fechaNacimiento = ?, 
                        telefono = ?, 
                        direccion = ?, 
                        ciudad = ?, 
                        fechaExpedicion = ?, 
                        estadoCivil = ?, 
                        nivelEstudio = ?, 
                        departamento = ?, 
                        codEstadoEmpleado = ?
                    WHERE identificacion = ? AND nit = ?";
    
            // Preparar la consulta SQL
            $stmt = $this->getCnx()->prepare($sql);
    
            // Ejecutar la consulta con los parámetros proporcionados
            $stmt->execute([
                $nombre, $apellido, $tipoDocumento, $genero, $correo, $fechaNacimiento, 
                $telefono, $direccion, $ciudad, $fechaExpedicion, $estadoCivil, $nivelEstudio, 
                $departamento, $codEstadoEmpleado, $identificacion, $empresa
            ]);
    
        } catch (PDOException $p) {
            // Mensaje de error en caso de excepción
            echo $p->getMessage() . '***********************';
        }
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
    public function listar($empresa) {
        $lista = null;
        try {    
            // Consulta SQL para listar todos los empleados de una empresa
            $stmt = $this->getCnx()->prepare("SELECT * FROM empleado WHERE nit = ?");
            $lista = array();
            // Ejecutar la consulta
            $stmt->execute([$empresa]);
            // Recorrer el resultado de la consulta y crear objetos Empleado
            foreach ($stmt as $key) {           
                $e = new Empleado(
                    $key['nombre'],
                    $key['apellido'],
                    $key['identificacion'],
                    $key['tipoDocumento'],
                    $key['genero'],
                    $key['correo'],
                    $key['fechaNacimiento'],
                    $key['telefono'],
                    $key['direccion'],
                    $key['ciudad'],
                    $key['fechaExpedicion'],
                    $key['estadoCivil'],
                    $key['nivelEstudio'],
                    $key['departamento'],
                    $key['codEstadoEmpleado']
                );
                // Establecer la empresa para el objeto Empleado
                $e->ingresarEmpresa($empresa);
                // Agregar el objeto Empleado al array
                array_push($lista, $e);           
            }        
        } catch(PDOException $e) {
            // Manejo de excepciones
            echo $e->getMessage() . ' error en listar de DaoAprendizImpl';
        }
        // Devolver la lista de empleados
        return $lista;       
    }
    // Método para obtener un empleado por su identificación y el NIT de la empresa
    public function traer($identificacion, $empresa) {
        try {
            // Consulta SQL para obtener un empleado por su identificación y el NIT de la empresa    
            $stmt = $this->getCnx()->prepare("SELECT * FROM empleado WHERE identificacion = ? AND nit = ?");
            // Ejecutar la consulta
            $stmt->execute([$identificacion, $empresa]);
            // Obtener el primer resultado de la consulta
            $key = $stmt->fetch();
    
            if ($key) {
                // Crear un objeto Empleado con los datos obtenidos
                $e = new Empleado(
                    $key['nombre'],
                    $key['apellido'],
                    $key['identificacion'],
                    $key['tipoDocumento'],
                    $key['genero'],
                    $key['correo'],
                    $key['fechaNacimiento'],
                    $key['telefono'],
                    $key['direccion'],
                    $key['ciudad'],
                    $key['fechaExpedicion'],
                    $key['estadoCivil'],
                    $key['nivelEstudio'],
                    $key['departamento'],
                    $key['codEstadoEmpleado']
                );
    
                // Establecer la empresa para el objeto Empleado
                $e->ingresarEmpresa($empresa);
    
                // Devolver el objeto Empleado
                return $e;
            } else {
                return null; // Retornar null si no se encuentra ningún empleado
            }
    
        } catch(PDOException $e) {
            // Manejo de excepciones
            echo $e->getMessage() . ' error en traer de DaoAprendizImpl';
            return null;
        } 
    }
}
?>