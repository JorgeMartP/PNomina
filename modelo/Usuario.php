<?php
class Usuario {
    private $idUsuario;
    private $tipoDocumento;
    private $nombreU;
    private $apellidoU;
    private $correoU;
    private $contraseña;
    private $codRol;
    private $codEstadoUsuario;
    private $resetToken;
    private $tokenExpiration;
    private $intentosFallidos;
    private $cuentaBloqueada;

    public function __construct(
        $idUsuario,
        $tipoDocumento,
        $nombreU,
        $apellidoU,
        $correoU,
        $contraseña,
        $codRol,
        $codEstadoUsuario,
        $resetToken = null,
        $tokenExpiration = null,
        $intentosFallidos = 0,
        $cuentaBloqueada = 0
    ) {
        $this->idUsuario = $idUsuario;
        $this->tipoDocumento = $tipoDocumento;
        $this->nombreU = $nombreU;
        $this->apellidoU = $apellidoU;
        $this->correoU = $correoU;
        $this->contraseña = $contraseña;
        $this->codRol = $codRol;
        $this->codEstadoUsuario = $codEstadoUsuario;
        $this->resetToken = $resetToken;
        $this->tokenExpiration = $tokenExpiration;
        $this->intentosFallidos = $intentosFallidos;
        $this->cuentaBloqueada = $cuentaBloqueada;
    }

    // Métodos getters y setters
    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function getTipoDocumento() {
        return $this->tipoDocumento;
    }

    public function setTipoDocumento($tipoDocumento) {
        $this->tipoDocumento = $tipoDocumento;
    }

    public function getNombreU() {
        return $this->nombreU;
    }

    public function setNombreU($nombreU) {
        $this->nombreU = $nombreU;
    }

    public function getApellidoU() {
        return $this->apellidoU;
    }

    public function setApellidoU($apellidoU) {
        $this->apellidoU = $apellidoU;
    }

    public function getCorreoU() {
        return $this->correoU;
    }

    public function setCorreoU($correoU) {
        $this->correoU = $correoU;
    }

    public function getContraseña() {
        return $this->contraseña;
    }

    public function setContraseña($contraseña) {
        $this->contraseña = $contraseña;
    }

    public function getCodRol() {
        return $this->codRol;
    }

    public function setCodRol($codRol) {
        $this->codRol = $codRol;
    }

    public function getCodEstadoUsuario() {
        return $this->codEstadoUsuario;
    }

    public function setCodEstadoUsuario($codEstadoUsuario) {
        $this->codEstadoUsuario = $codEstadoUsuario;
    }

    public function getResetToken() {
        return $this->resetToken;
    }

    public function setResetToken($resetToken) {
        $this->resetToken = $resetToken;
    }

    public function getTokenExpiration() {
        return $this->tokenExpiration;
    }

    public function setTokenExpiration($tokenExpiration) {
        $this->tokenExpiration = $tokenExpiration;
    }

    public function getIntentosFallidos() {
        return $this->intentosFallidos;
    }

    public function setIntentosFallidos($intentosFallidos) {
        $this->intentosFallidos = $intentosFallidos;
    }

    public function getCuentaBloqueada() {
        return $this->cuentaBloqueada;
    }

    public function setCuentaBloqueada($cuentaBloqueada) {
        $this->cuentaBloqueada = $cuentaBloqueada;
    }
}
?>