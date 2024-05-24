<?php
#clase Padre de empleado
class Persona{
    private $nombre;
    private $apellido;
    private $identificacion;
    private $tipoDocumento;
    private $genero;
    private $correo;
    private $fechaNacimiento;
    private $telefono;
    private $direccion;
    private $ciudad;
    private $empresa;

    public function __construct($nombre, $apellido, $identificacion, $tipoDocumento, $genero, $correo, $fechaNacimiento, $telefono, $direccion, $ciudad) {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->identificacion = $identificacion;
        $this->tipoDocumento = $tipoDocumento;
        $this->genero = $genero;
        $this->correo = $correo;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
        $this->ciudad = $ciudad;
    }
    public function getPersona(){
        return $this->nombre . $this->apellido .  $this->identificacion . $this->tipoDocumento . $this->genero . $this->correo  . $this->fechaNacimiento . $this->telefono . $this->direccion . $this->ciudad;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getApellido(){
        return $this->apellido;
    }
    public function getIdentificacion(){
        return $this->identificacion;
    }
    public function getTipoDocumento(){
        return $this->tipoDocumento;
    }
    public function getGenero(){
        return $this->genero;
    }
    public function getCorreo(){
        return $this->correo;
    }
    public function getFechaNacimiento(){
        return $this->fechaNacimiento;
    }
    public function getTelefono(){
        return $this->telefono;
    }
    public function getDireccion(){
        return $this->direccion;
    }
    public function getCiudad(){
        return $this->ciudad;
    }
    public function setEmpresa($empresa){
        $this->empresa = $empresa;
    }
    public function setNombre($nombre){
        $this-> nombre = $nombre;
    }
    public function SetApellido($apellido){
        $this->apellido = $apellido;
    }
    public function setIdentificacion($identificacion){
        $this->identificacion = $identificacion;
    }
    public function setTipoDocumento($tipoDocumento){
        $this->tipoDocumento= $tipoDocumento;
    }
    public function setGenero($genero){
    $this->genero = $genero;
    }
    public function setCorreo($correo){
        $this->correo = $correo;
    }
    public function setFechaNacimiento($fechaNacimiento){
        $this->fechaNacimiento = $fechaNacimiento;
    }
    public function SetTelefono($telefono){
        $this->telefono = $telefono;
    }
    public function setDireccion($direccion){
        $this->direccion = $direccion;
    }
    public function setCiudad($ciudad){
        return $this->ciudad = $ciudad;
    }
    

}
?>