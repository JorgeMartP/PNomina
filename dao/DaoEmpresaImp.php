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
            $tipoContribuyente = $e->getTipoContribuyente();
            $digitoVerificacion = $e->getDigitoVerificacion();
            $nombre = $e->getNombreEmpresa();
            $telefono = $e->getTelefonoEmpresa();
            $correo = $e->getCorreoEmpresa();
            $direccion = $e->getDireccionEmpresa();
            $logo = $e->getLogo();
            $rut = $e->getRut();
            $camaraComercio = $e->getCamaraComercio();

            // Consulta SQL para insertar la empresa en la base de datos
            $sql = "INSERT INTO empresa (nit, tipoContribuyente, digitoVerificacion, nombre, telefono, correo, direccion, logo, rut, camaraComercio) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            // Preparar la consulta SQL
            $stmt = $this->getCnx()->prepare($sql);

            // Ejecutar la consulta con los parámetros proporcionados
            $stmt->execute([$nit, $tipoContribuyente, $digitoVerificacion, $nombre, $telefono, $correo, $direccion, $logo, $rut, $camaraComercio]);

            return true;
        } else {
            // Mensaje de error si la conexión es nula
            echo "La conexión es nula";
            return false;
        }
    } catch (PDOException $p) {
        // Manejo de excepciones
        echo "Error en la inserción: " . $p->getMessage();
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
        $sql = "UPDATE empresa 
                SET nit = :nit, 
                    tipoContribuyente = :tipoContribuyente, 
                    digitoVerificacion = :digitoVerificacion, 
                    nombre = :nombre, 
                    telefono = :telefono, 
                    correo = :correo, 
                    direccion = :direccion, 
                    logo = :logo, 
                    rut = :rut, 
                    camaraComercio = :camaraComercio 
                WHERE nit = :nitAntiguo";

        // Preparar la consulta SQL
        $stmt = $this->getCnx()->prepare($sql);

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
        // Manejo de excepciones
        echo $e->getMessage();
        return false;
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
        $stmt = $this->getCnx()->prepare("SELECT * FROM empresa");
        // Inicializar un array para almacenar la lista de empresas
        $lista = array();
        // Ejecutar la consulta
        $stmt->execute();
        // Recorrer el resultado de la consulta y crear objetos Empresa
        foreach ($stmt as $key) {
            // Crear un nuevo objeto Empresa con los datos del resultado de la consulta
            $a = new Empresa(
                $key['nit'],
                $key['tipoContribuyente'],
                $key['digitoVerificacion'],
                $key['nombre'],
                $key['telefono'],
                $key['correo'],
                $key['direccion'],
                $key['logo'],
                $key['rut'],
                $key['camaraComercio']
            );
            // Agregar el objeto Empresa al array
            array_push($lista, $a);
        }
        //$this->getCnx()->close();
    } catch (PDOException $e) {
        // Manejo de excepciones
        echo $e->getMessage() . ' error en listar de DaoAprendizImpl';
    }
    return $lista;
}
    // Método para traer una empresa por su NIT
    public function traer($nit)
{
    try {
        // Preparar la consulta SQL para obtener una empresa por su NIT
        $stmt = $this->getCnx()->prepare("SELECT * FROM empresa WHERE nit = ?");
        // Vincular el parámetro de la consulta
        $stmt->bindParam(1, $nit);
        // Ejecutar la consulta
        $stmt->execute();
        
        // Obtener el resultado de la consulta
        $key = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($key) {
            // Crear un nuevo objeto Empresa con los datos del resultado de la consulta
            $e = new Empresa(
                $key['nit'],
                $key['tipoContribuyente'],
                $key['digitoVerificacion'],
                $key['nombre'],
                $key['telefono'],
                $key['correo'],
                $key['direccion'],
                $key['logo'],
                $key['rut'],
                $key['camaraComercio']
            );
            // Devolver el objeto Empresa
            return $e;
        } else {
            // Si no se encontró ninguna empresa con ese NIT, devolver null o manejar el caso según tu lógica de negocio
            return null;
        }
        
        //$this->getCnx()->close();
    } catch (PDOException $e) {
        // Manejo de excepciones
        echo $e->getMessage() . ' error en traer de DaoAprendizImpl';
        return null;
    }
}
}
