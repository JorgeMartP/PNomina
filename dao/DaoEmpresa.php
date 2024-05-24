<?php
// Definición de la interfaz DaoEmpresa
interface DaoEmpresa{
    public function registrar(Empresa $e);
    public function modificar(Empresa $a);
    public function eliminar(Empresa $e);
    public function traer($nit);
    public function eliminarEmpleado(Empresa $e);
    public function listar();
}
?>