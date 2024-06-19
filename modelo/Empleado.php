<?php
# clase hija de la clase Persona
require ('Persona.php');

class Empleado extends Persona {
    private $fechaExpedicion;
    private $estadoCivil;
    private $nivelEstudio;
    private $empresa;
    private $departamento;
    private $codEstadoEmpleado;

    public function __construct($nombre, $apellido, $identificacion, $tipoDocumento, $genero, $correo, $fechaNacimiento, $telefono, $direccion, $ciudad, $fechaExpedicion, $estadoCivil, $nivelEstudio, $departamento, $codEstadoEmpleado) {
        parent::__construct($nombre, $apellido, $identificacion, $tipoDocumento, $genero, $correo, $fechaNacimiento, $telefono, $direccion, $ciudad);
        $this->fechaExpedicion = $fechaExpedicion;
        $this->estadoCivil = $estadoCivil;
        $this->nivelEstudio = $nivelEstudio;
        $this->departamento = $departamento;
        $this->codEstadoEmpleado = $codEstadoEmpleado;
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

    public function getDepartamento() {
        return $this->departamento;
    }

    public function getCodEstadoEmpleado() {
        return $this->codEstadoEmpleado;
    }

    public function setFechaExpedicion($fechaExpedicion){
        $this->fechaExpedicion = $fechaExpedicion;
    }

    public function setEstadoCivil($estadoCivil){
        $this->estadoCivil = $estadoCivil;
    }

    public function setNivelEstudio($nivelEstudio){
        $this->nivelEstudio = $nivelEstudio;
    }

    public function setDepartamento($departamento) {
        $this->departamento = $departamento;
    }

    public function setCodEstadoEmpleado($codEstadoEmpleado) {
        $this->codEstadoEmpleado = $codEstadoEmpleado;
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