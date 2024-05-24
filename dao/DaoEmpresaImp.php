<?php
include("DaoEmpresa.php");
require_once("../conexion/conexion.php");
include("../modelo/Empresa.php");
// Definición de la clase DaoEmpresaImp que implementa la interfaz DaoEmpresa
class DaoEmpresaImp extends Conexion implements DaoEmpresa
{
    // Método para registrar una empresa en la base de datos
    public function registrar(Empresa $e)
    {
        try {
            // Verificar si la conexión no es nula
            if ($this->getCnx() != null) {
                // Obtener los atributos de la empresa
                $nit = $e->getNit();
                $nombre = $e->getNombreEmpresa();
                $direccion = $e->getDireccionEmpresa();
                $telefono = $e->getTelefonoEmpresa();
                $correo = $e->getCorreoEmpresa();
                $tipoContribuyente = $e->getTipoContribuyente();
                $digitoVerificacion = $e->getDigitoVerificacion();
                $rut = $e->getRut();
                $logo = $e->getLogo();
                $camaraComercio = $e->getCamaraComercio();
                // Consulta SQL para insertar la empresa en la base de datos
                $sql = "insert into empresa values(?,?,?,?,?,?,?,?,?,?)";
                // Preparar la consulta SQL
                $stmt = $this->getCnx()->prepare($sql);
                // Ejecutar la consulta con los parámetros proporcionados
                $stmt->execute([$nit, $tipoContribuyente, $digitoVerificacion, $nombre, $telefono, $correo,  $direccion, $logo, $rut, $camaraComercio]);
                return true;
            } else {
                // Mensaje de error si la conexión es nula
                echo $this->getCnx() . ' Es nulo <br>';
            }
        } catch (PDOException $p) {
            return false;
        }
    }
    // Método para modificar una empresa en la base de datos
    public function modificar(Empresa $a)
{
    try {
        // Obtener los atributos de la empresa del objeto
        $nit = $a->getNit();
        $nombre = $a->getNombreEmpresa();
        $direccion = $a->getDireccionEmpresa();
        $telefono = $a->getTelefonoEmpresa();
        $correo = $a->getCorreoEmpresa();
        $tipoContribuyente = $a->getTipoContribuyente();
        $digitoVerificacion = $a->getDigitoVerificacion();
        $logo = $a->getLogo();
        $camaraComercio = $a->getCamaraComercio();
        $rut = $a->getRut();
        // Consulta SQL para actualizar la empresa en la base de datos
        $stmt = $this->getCnx()->prepare("UPDATE empresa " .
            "SET nit = :nit, " .
            "tipoContribuyente = :tipoContribuyente, " .
            "digitoVerificacion = :digitoVerificacion, " .
            "nombre = :nombre, " .
            "telefono = :telefono, " .
            "correo = :correo, " .
            "direccion = :direccion, " .
            "logo = :logo, " .
            "rut = :rut, " .
            "camaraComercio = :camaraComercio " .
            "WHERE nit = :nitAntiguo");
        // Vincular los parámetros de la consulta
        $stmt->bindParam(':nit', $nit);
        $stmt->bindParam(':tipoContribuyente', $tipoContribuyente);
        $stmt->bindParam(':digitoVerificacion', $digitoVerificacion);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':logo', $logo);
        $stmt->bindParam(':rut', $rut);
        $stmt->bindParam(':camaraComercio', $camaraComercio);
        $stmt->bindParam(':nitAntiguo', $nit);
        // Ejecutar la consulta
        $resultado = $stmt->execute();

        return $resultado;
    } catch (PDOException $e) {
        return $e->getMessage() . '***********************';
    }
}
// Método para eliminar un empleado asociado a una empresa
public function eliminarEmpleado(Empresa $e){
    try{
        // Obtener el NIT de la empresa
        $nit = $e->getNit();
        // Preparar la consulta SQL para eliminar el empleado
        $stmt = $this->getCnx()->prepare("delete from empleado where nit = $nit");
        // Ejecutar la consulta
        $stmt->execute();
        return $stmt;
    }catch(PDOException $e){
        return $e->getMessage() . '***********************';
    }
}
    // Método para eliminar una empresa de la base de datos
    public function eliminar(Empresa $e)
    {
        try{
            // Obtener el NIT de la empresa
            $nit = $e->getNit();
            // Preparar la consulta SQL para eliminar la empresa
            $stmt = $this->getCnx()->prepare("delete from empresa where nit = $nit");
            // Ejecutar la consulta
            $stmt->execute();
            return $stmt;
        }catch(PDOException $e){
            return $e->getMessage() . '***********************';
        }
        
    }
    // Método para listar todas las empresas
    public function listar()
    {
        $lista = null;
        try {
            // Preparar la consulta SQL para listar todas las empresas
            $stmt = $this->getCnx()->prepare("select * from empresa");
            // Inicializar un array para almacenar la lista de empresas
            $lista = array();
            // Ejecutar la consulta
            $stmt->execute();
            // Recorrer el resultado de la consulta y crear objetos Empresa
            foreach ($stmt as $key) {
                $a = new Empresa(null, null, null, null, null, null, null, null, null, null);
                $nit = $a->setNit($key['nit']);
                $direccion = $a->setDireccion($key['direccion']);
                $telefono = $a->setTelefono($key['telefono']);
                $correo = $a->setCorreo($key['correo']);
                $tipoContribuyente = $a->setTipoContribuyente($key['tipoContribuyente']);
                $digitoVerificacion = $a->setDigitoVerificacion($key['digitoVerificacion']);
                $logo = $a->setLogo($key['logo']);
                $rut = $a->setRut($key['rut']);
                $camaraComercio = $a->setCamaraComercio($key['camaraComercio']);
                $nombre = $a->setNombreEmpresa($key['nombre']);
                // Agregar el objeto Empresa al array
                array_push($lista, $a);
            }
            //$this->getCnx()->close();
        } catch (PDOException $e) {
            $e->getMessage() . 'error en listar de DaoAprendizImpl';
        }
        return $lista;
    }
    // Método para traer una empresa por su NIT
    public function traer($nit)
    {
        try {
            // Preparar la consulta SQL para obtener una empresa por su NIT
            $stmt = $this->getCnx()->prepare("select * from empresa where nit = $nit");
            $lista = array();
            // Ejecutar la consulta
            $stmt->execute();
            // Recorrer el resultado de la consulta y crear un objeto Empresa
            foreach ($stmt as $key) {
                $e = new Empresa(null, null, null, null, null, null, null, null, null, null);
                $nit = $e->setNit($key['nit']);
                $direccion = $e->setDireccion($key['direccion']);
                $telefono = $e->setTelefono($key['telefono']);
                $correo = $e->setCorreo($key['correo']);
                $tipoContribuyente = $e->setTipoContribuyente($key['tipoContribuyente']);
                $digitoVerificacion = $e->setDigitoVerificacion($key['digitoVerificacion']);
                $logo = $e->setLogo($key['logo']);
                $rut = $e->setRut($key['rut']);
                $camaraComercio = $e->setCamaraComercio($key['camaraComercio']);
                $nombre = $e->setNombreEmpresa($key['nombre']);
                // Devolver el objeto Empresa
                return $e;
            }
            //$this->getCnx()->close();
        } catch (PDOException $e) {
            $e->getMessage() . 'error en listar de DaoAprendizImpl';
        }
    }
}
