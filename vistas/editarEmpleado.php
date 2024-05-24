<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <!--Formulario para actualizar empleado -->
<div id="modal2" class="modal2">
    <div class="modal-content">
      <h1>Registrar Empleado</h1>
      <!--mostrar en el formulario la informacion del empleado-->
      <form action="controladorEditarEmpleado.php?empresa=<?=$objEmpresa?>&id=<?= $Empleados->getIdentificacion()?>" id="registration-form" class="form" method="POST">
        <div class="flex">
          <div class="form-group">
            <input type="number" id="identificacion" name="identificacion" class="form-input" value="<?= $Empleados->getIdentificacion()?>" readonly required>
            <label for="identificacion" class="heading">N° Identificacion</label>
          </div>
          <div class="form-group">
            <input type="text" id="nombre" name="nombre" class="form-input" value="<?= $Empleados->getNombre()?>" required>
            <label for="nombre" class="heading">Nombre</label>
          </div>
        </div>
        <div class="flex">
          <div class="form-group">
            <input type="text" id="apellido" name="apellido" class="form-input" value="<?= $Empleados->getApellido()?>" required>
            <label for="direccion" class="heading">Apellido</label>
          </div>
          <div class="form-group">
            <input type="text" id="tipoDocumento" name="tipoDocumento" class="form-input" value="<?= $Empleados->getTipoDocumento()?>" required>
            <label for="tipoDocumento" class="heading">Tipo de Documento</label>
          </div>
        </div>
        <div class="flex">
          <div class="form-group">
            <input type="text" id="genero" name="genero" class="form-input" value="<?= $Empleados->getGenero()?>" required>
            <label for="genero" class="heading">Genero</label>
          </div>
          <div class="form-group">
            <input type="text" id="ciudad" name="ciudad" class="form-input" value="<?= $Empleados->getCiudad()?>" required>
            <label for="ciudad" class="heading">Ciudad</label>
          </div>
        </div>
        <div class="flex">
          <div class="form-group">
            <input type="text" id="correo" name="correo" class="form-input" value="<?= $Empleados->getCorreo()?>" required>
            <label for="correo" class="heading">Correo</label>
          </div>
          <div class="form-group">
            <input type="date" id="fechaNacimiento" name="fechaNacimiento" class="form-input" value="<?= $Empleados->getFechaNacimiento()?>" required>
            <label for="fechaNacimiento" class="logo">Fecha Nacimiento</label>
          </div>
        </div>
        <div class="flex">
          <div class="form-group">
            <input type="date" id="fechaExpedicion" name="fechaExpedicion" class="form-input" value="<?= $Empleados->getFechaExpedicion()?>" required>
            <label for="fechaExpedicion" class="logo">Fecha Nacimiento</label>
          </div>
          <div class="form-group">
            <input type="number" id="telefono" name="telefono" class="form-input" value="<?= $Empleados->getTelefono()?>" required>
            <label for="telefono" class="heading">Telefono</label>
          </div>
        </div>
        <div class="flex">
          <div class="form-group">
            <input type="text" id="direccion" name="direccion" class="form-input" value="<?= $Empleados->getDireccion()?>" required>
            <label for="direccion" class="heading">Dirección</label>
          </div>
          <div class="form-group">
            <input type="estadoCivil" id="estadoCivil" name="estadoCivil" class="form-input" value="<?= $Empleados->getEstadoCivil()?>" required>
            <label for="estadoCivil" class="heading">Estado Civil</label>
          </div>
        </div>
        <div class="form-group">
          <input type="text" id="nivelEstudio" name="nivelEstudio" class="form-input" value="<?= $Empleados->getNivelEstudio()?>" required>
          <label for="nivelEstudio" class="heading">Nivel de Estudio</label>
        </div>
        <input type="submit" value="Actualizar" class="Boton" name="boton">
      </form>
    </div>
  </div>
</body>
</html>