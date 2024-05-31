<?php
interface DaoUsuario{
    public function traer(Usuario $correU);
    public function crear(Usuario $e);
    public function confirCorreo($correoU);
}
