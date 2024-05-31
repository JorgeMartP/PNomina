<?php
include('daoUsuario.php');
require_once('../conexion/conexion.php');
include('../modelo/Usuario.php');
// Definición de la clase DaoEmpleadoImplementacion que implementa la interfaz DaoEmpleado
class DaoUsuarioImp extends Conexion implements DaoUsuario
{
    public function traer($correoU)
    {
        try {
            $stmt = $this->getCnx()->prepare("SELECT * FROM usuario WHERE correoU = ?");
            $stmt->bindParam(1, $correoU); // Enlazar el valor del parámetro al marcador de posición
            $stmt->execute();
            $numero_registro = $stmt->rowCount();
            if ($numero_registro > 0) {
                foreach ($stmt as $key) {
                    $e = new Usuario($key['idUsuario'], $key['tipoDocumento'], $key['nombreU'], $key['apellidoU'], $key['correoU'], $key['contraseña'], $key['codTipoUsuario']);
                    return $e;
                }
            } else {
                // Si no se encontraron registros, puedes retornar false o algún otro valor indicando que no se encontró nada
                return false;
            }

            //$this->getCnx()->close();
        } catch (PDOException $e) {
            $e->getMessage() . 'error en listar de DaoAprendizImpl';
        }
    }

    public function actualizar()
    {
        $contraseña = 'adso2024';
        $password_hasheada = password_hash($contraseña, PASSWORD_DEFAULT); // Algoritmo de hash predeterminado
        $correo = 'jlmartinezpinto@gmail.com';
        try {
            // Preparar la consulta SQL para actualizar la contraseña de un usuario
            $stmt = $this->getCnx()->prepare("UPDATE usuario SET contraseña = :password WHERE correoU = :correo");

            // Enlazar los valores a los marcadores de posición
            $stmt->bindParam(':password', $password_hasheada);
            $stmt->bindParam(':correo', $correo); // Asigna el valor del correo a actualizar

            // Ejecutar la consulta
            $stmt->execute();

            // Verificar si se realizó la actualización
            if ($stmt->rowCount() > 0) {
                echo "Contraseña actualizada exitosamente.";
            } else {
                echo "No se pudo actualizar la contraseña.";
            }
        } catch (PDOException $e) {
            echo "Error al ejecutar la consulta: " . $e->getMessage();
        }
    }

    public function crear(Usuario $e)
    {
        try {
            $stmt = $this->getCnx()->prepare("INSERT INTO usuario(idUsuario, tipoDocumento, nombreU, apellidoU, correoU, contraseña, codTipoUsuario) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bindValue(1, $e->getIdUsuario());
            $stmt->bindValue(2, $e->getTipoDocumento());
            $stmt->bindValue(3, $e->getNombreU());
            $stmt->bindValue(4, $e->getApellidoU());
            $stmt->bindValue(5, $e->getCorreoU());
            $stmt->bindValue(6, $e->getContraseña());
            $stmt->bindValue(7, $e->getCodTipoUsuario());
            $stmt->execute();
            if ($stmt == true) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            die("Error en la base de datos " . $e);
        }
    }
    public function confirCorreo($correoU)
    {
        try {
            $stmt = $this->getCnx()->prepare("SELECT * FROM usuario WHERE correoU = ?");
            $stmt->bindParam(1, $correoU);
            $stmt->execute();
            $numero_registro = $stmt->rowCount();
            if ($numero_registro > 0) {
                return false;
            } else {
                return true;
            }

            //$this->getCnx()->close();
        } catch (PDOException $e) {
            $e->getMessage() . 'error en listar de DaoAprendizImpl';
        }
    }

    public function actuToken($token, $expires, $email)
    {
        $stmt = $this->getCnx()->prepare("UPDATE usuario SET reset_token = ?, token_expiration = ? WHERE correoU = ?");
        $stmt->bindParam(1, $token);
        $stmt->bindParam(2, $expires);
        $stmt->bindParam(3, $email);
        $stmt->execute();
        return $stmt;
    }

    public function verificarCod($newPassword, $token)
    {
        try {
            $stmt = $this->getCnx()->prepare("SELECT * FROM usuario WHERE reset_token = ? AND token_expiration >= ?");
            $currentDate = date("U");
            $stmt->bindParam(1 , $token) ;
            $stmt->bindParam(2, $currentDate);
            $stmt->execute();
            $result = $stmt->rowCount();

            if ($result >= 1) {
                // Actualizar la contraseña
                $stmt = $this->getCnx()->prepare("UPDATE usuario SET contraseña = ?, reset_token = NULL, token_expiration = NULL WHERE reset_token = ?");
                $stmt->bindParam(1, $newPassword);
                $stmt->bindParam(2, $token);
                $stmt->execute();
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo($e);
        }
    }
}
