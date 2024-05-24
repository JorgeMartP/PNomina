<?php
#clase hija de la clase persona
require ('Persona.php');
class Empleado extends Persona {
    private $fechaExpedicion;
    private $estadoCivil;
    private $nivelEstudio;
    private $empresa;
    public function __construct($nombre, $apellido, $identificacion, $tipoDocumento, $genero, $correo, $fechaNacimiento, $telefono, $direccion, $ciudad, $fechaExpedicion, $estadoCivil, $nivelEstudio) {
        parent::__construct($nombre, $apellido, $identificacion, $tipoDocumento, $genero, $correo, $fechaNacimiento, $telefono, $direccion, $ciudad);
        $this->fechaExpedicion = $fechaExpedicion;
        $this->estadoCivil = $estadoCivil;
        $this->nivelEstudio = $nivelEstudio;
}
    public function getFechaExpedicion(){
        return $this->fechaExpedicion;
    }
    public function getEstadoCivil(){
        return $this->estadoCivil;
    }
    public function getNivelEstudio(){
        return $this->nivelEstudio;
    }
    public function setFechaExpedicion($fechaExpedicion){
        $this->fechaExpedicion = $fechaExpedicion;
    }
    public function setEstadoCivil($estadoCivil){
        $this->estadoCivil = $estadoCivil;
    }
    public function setNivelEstudio($nivelEstudio){
        return $this->nivelEstudio = $nivelEstudio;
    }

    public function ingresarEmpresa($empresa){
        $this->empresa = $empresa;
    }
    public function getEmpresa(){
        return $this->empresa;
    }
    public function obtenerNitEmpresa() {
        return $this->empresa->getNit();
    }
}



?>