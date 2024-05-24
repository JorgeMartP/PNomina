<?php 
// Definición de la clase Conexion
class Conexion{    
    private $dsn='mysql:host=localhost;dbname=baseNomina';
    private $usr='root';
    private $psw='';  
    private $cnx;
public function __construct(){
    try {
        $this->cnx=new PDO($this->dsn,$this->usr,$this->psw); 
        
    } catch (PDOException $th) {
        echo $th->getMessage();
    }
}
// Método para desconectar la base de datos
public function desconectar(){
    $this->cnx=null;
}
// Métodos getter y setter para el atributo $cnx
public function getCnx(){
    return $this->cnx;
}
public function setCnx($cnx){
    $this->cnx=$cnx;
}
}
?>