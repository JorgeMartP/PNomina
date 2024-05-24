<?php
class Usuario {
    private $idUsuario;
    private $tipoDocumento;
    private $nombreU;
    private $apellidoU;
    private $correoU;
    private $contraseña;
    private $codTipoUsuario;

     public function __construct($idUsuario, $tipoDocumento, $nombreU, $apellidoU, $correoU, $contraseña, $codTipoUsuario) {
        $this->idUsuario = $idUsuario;
        $this->tipoDocumento = $tipoDocumento;
        $this->nombreU= $nombreU;
        $this->apellidoU = $apellidoU;
        $this->correoU = $correoU;
        $this->contraseña = $contraseña;
        $this->codTipoUsuario = $codTipoUsuario;
    }
    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    // Getter y Setter para tipoDocumento
    public function getTipoDocumento() {
        return $this->tipoDocumento;
    }

    public function setTipoDocumento($tipoDocumento) {
        $this->tipoDocumento = $tipoDocumento;
    }

    // Getter y Setter para nombreU
    public function getNombreU() {
        return $this->nombreU;
    }

    public function setNombreU($nombreU) {
        $this->nombreU = $nombreU;
    }

    // Getter y Setter para apellidoU
    public function getApellidoU() {
        return $this->apellidoU;
    }

    public function setApellidoU($apellidoU) {
        $this->apellidoU = $apellidoU;
    }

    // Getter y Setter para correoU
    public function getCorreoU() {
        return $this->correoU;
    }

    public function setCorreoU($correoU) {
        $this->correoU = $correoU;
    }

    // Getter y Setter para contraseña
    public function getContraseña() {
        return $this->contraseña;
    }

    public function setContraseña($contraseña) {
        $this->contraseña = $contraseña;
    }

    // Getter y Setter para codTipoUsuario
    public function getCodTipoUsuario() {
        return $this->codTipoUsuario;
    }

    public function setCodTipoUsuario($codTipoUsuario) {
        $this->codTipoUsuario = $codTipoUsuario;
    }


}