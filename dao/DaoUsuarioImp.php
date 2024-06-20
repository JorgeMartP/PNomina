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
            $key = $stmt->fetch(PDO::FETCH_ASSOC); // Obtener el primer resultado como array asociativo

            $usuario = new Usuario(
                $key['idUsuario'],
                $key['tipoDocumento'],
                $key['nombreU'],
                $key['apellidoU'],
                $key['correoU'],
                $key['contraseña'],
                $key['codRol'],
                $key['codEstadoUsuario']
            );

            // Establecer los valores adicionales
            $usuario->setIntentosFallidos($key['intentos_fallidos']);
            $usuario->setCuentaBloqueada($key['cuenta_bloqueada']);
            $usuario->setResetToken($key['reset_token']);
            $usuario->setTokenExpiration($key['token_expiration']);

            return $usuario;
        } else {
            return false; // Si no se encuentra ningún registro con ese correoU
        }

        //$this->getCnx()->close(); // No se cierra la conexión aquí en PDO
    } catch (PDOException $e) {
        echo $e->getMessage(); // Corregido para mostrar el mensaje de error correctamente
        // También se puede lanzar una excepción aquí para manejarla en capas superiores
    }
}

public function actualizarContraseña($correo, $nuevaContraseña)
{
    try {
        // Hash de la nueva contraseña
        $password_hasheada = password_hash($nuevaContraseña, PASSWORD_DEFAULT);

        // Preparar la consulta SQL para actualizar la contraseña de un usuario
        $stmt = $this->getCnx()->prepare("UPDATE usuario SET contraseña = :password WHERE correoU = :correo");

        // Enlazar los valores a los marcadores de posición
        $stmt->bindParam(':password', $password_hasheada);
        $stmt->bindParam(':correo', $correo); // Asignar el valor del correo a actualizar

        // Ejecutar la consulta
        $stmt->execute();

        // Verificar si se realizó la actualización
        if ($stmt->rowCount() > 0) {
            echo "Contraseña actualizada exitosamente.";
        } else {
            echo "No se pudo actualizar la contraseña. El correo no existe en la base de datos.";
        }
    } catch (PDOException $e) {
        echo "Error al ejecutar la consulta: " . $e->getMessage();
    }
}

public function crear(Usuario $e)
{
    try {
        // Comienza una transacción
        $this->getCnx()->beginTransaction();

        // Preparar la consulta SQL para insertar un nuevo usuario
        $stmt = $this->getCnx()->prepare("INSERT INTO usuario (idUsuario, tipoDocumento, nombreU, apellidoU, correoU, contraseña, codRol, codEstadoUsuario, reset_token, token_expiration, intentos_fallidos, cuenta_bloqueada) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Enlazar los valores a los marcadores de posición
        $stmt->bindValue(1, $e->getIdUsuario());
        $stmt->bindValue(2, $e->getTipoDocumento());
        $stmt->bindValue(3, $e->getNombreU());
        $stmt->bindValue(4, $e->getApellidoU());
        $stmt->bindValue(5, $e->getCorreoU());
        $stmt->bindValue(6, $e->getContraseña());
        $stmt->bindValue(7, $e->getCodRol());
        $stmt->bindValue(8, $e->getCodEstadoUsuario());
        $stmt->bindValue(9, $e->getResetToken());
        $stmt->bindValue(10, $e->getTokenExpiration());
        $stmt->bindValue(11, $e->getIntentosFallidos());
        $stmt->bindValue(12, $e->getCuentaBloqueada());

        // Ejecutar la consulta
        $stmt->execute();

        // Finaliza la transacción (confirmar los cambios)
        $this->getCnx()->commit();

        // Verificar si se realizó la inserción correctamente
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        // Revertir la transacción en caso de error
        $this->getCnx()->rollBack();
        die("Error en la base de datos: " . $e->getMessage());
    }
}
public function confirCorreo($correoU)
{
    try {
        // Preparar la consulta SQL para verificar si existe un usuario con el correo especificado
        $stmt = $this->getCnx()->prepare("SELECT COUNT(*) AS count FROM usuario WHERE correoU = ?");
        $stmt->bindParam(1, $correoU);
        $stmt->execute();

        // Obtener el número de filas encontradas
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $numero_registro = $row['count'];

        // Verificar si se encontraron registros
        if ($numero_registro > 0) {
            return false; // El correo ya está registrado
        } else {
            return true; // El correo no está registrado
        }
    } catch (PDOException $e) {
        // Manejo de la excepción: imprimir mensaje de error o lanzar excepción según sea necesario
        echo "Error en la base de datos: " . $e->getMessage();
        // También se puede lanzar una excepción aquí para manejarla en capas superiores
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
                $stmt = $this->getCnx()->prepare("UPDATE usuario SET contraseña = ?, reset_token = NULL, token_expiration = NULL, cuenta_bloqueada = FALSE, intentos_fallidos = 0  WHERE reset_token = ?");
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

    public function actualizarIntentos($correoU){
        $stmt = $this->getCnx()->prepare("UPDATE usuario SET intentos_fallidos = 0 WHERE correoU = ?");
        $stmt->bindParam(1, $correoU);
        $stmt->execute();
    }

    public function bloquearCuenta($correoU){
        try {
            $stmt = $this->getCnx()->prepare("UPDATE usuario SET cuenta_bloqueada = TRUE WHERE correoU = ?");
            $stmt->bindParam(1, $correoU);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            echo("error en la base de datos" . $e);
        }
        
    }

    public function aumentarIntentos(Usuario $e){
        try {
            $stmt = $this->getCnx()->prepare("UPDATE usuario SET intentos_fallidos = ? WHERE correoU = ?");
            $intentos_fallidos = $e->getIntentosFallidos();
            $correo = $e->getCorreoU();
            $stmt->bindParam(1, $intentos_fallidos);
            $stmt->bindParam(2, $correo);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            echo("Error en la base de datos" . $e);
        }
    }

    public function traerUsuario(Usuario $e)
{
    try {
        $stmt = $this->getCnx()->prepare("SELECT * FROM usuario WHERE correoU = ?");
        $correoU = $e->getCorreoU();
        $stmt->bindParam(1, $correoU);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $usuario = new Usuario(
                $row['idUsuario'],
                $row['tipoDocumento'],
                $row['nombreU'],
                $row['apellidoU'],
                $row['correoU'],
                $row['contraseña'],
                $row['codRol'], // Ajustado según el modelo
                $row['codEstadoUsuario'], // Ajustado según el modelo
                $row['reset_token'],
                $row['token_expiration'],
                $row['intentos_fallidos'],
                $row['cuenta_bloqueada']
            );

            return $usuario;
        } else {
            return null; // Usuario no encontrado
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        // Aquí puedes manejar el error según tu estructura de manejo de excepciones
    }
}
}
