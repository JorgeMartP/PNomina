<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Empleados</title>
  <link rel="stylesheet" href="../styles/styles.css" />
  <link rel="stylesheet" href="../styles/modal.css" />
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
  <header class="header" id="responsive">
    <div class="imagen">
      <div class="logo">
        <a href="#">
          <img src="../img/logoSena.png" alt="logo" />
        </a>
      </div>
    </div>
    <div class="search">
      <input type="text" class="search__input" placeholder="Type your text" />
      <button class="search__button">
        <svg class="search__icon" aria-hidden="true" viewBox="0 0 24 24">
          <g>
            <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
          </g>
        </svg>
      </button>
    </div>
    <div class="imagen">
      <label>Nombre Usuario</label>
      <div class="logo-imagen">
        <a href="#">
          <img src="../img/deku.jpg" alt="perfil" />
        </a>
      </div>
    </div>
    <label id="icon">
      <i class="bx bx-menu"></i>
    </label>
  </header>

  <section class="containerTable">
    <div class="button">
      <h1>Empleados</h1>
      <button id="open-modal-btn" class="botton-1">Registrar Empleado</button>
      <a href="../controlador/controladorEmpresa.php" class="botton-2">Regresar</a>
    </div>
    <table>
      <thead>
        <tr>
          <th>Identificación</th>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>Correo</th>
          <th>Teléfono</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
        //llenar la tabla de la informacion de empleados 
        foreach ($Empleados as $key) {
          echo "<tr><td>" . $key->getIdentificacion() . "</td>";
          echo "<td>" . $key->getNombre() . "</td>";
          echo "<td>" . $key->getApellido() . "</td>";
          echo "<td>" . $key->getCorreo() . "</td>";
          echo "<td>" . $key->getTelefono() . "</td>";
          echo "<td><a href='../controlador/controladorEditarEmpleado.php?id=" . urlencode($key->getIdentificacion()) . "&empresa=".urlencode($objEmpresa)."'><i class='bx bxs-edit-alt'></i> </a></td>";
          echo "<td><a href='../controlador/controladorEmpleado.php?idEmp=". $key->getIdentificacion() ."&idEmpresa=".$objEmpresa."' onclick='advertencia(event)'><i class='bx bxs-trash'></i></a></td></tr>";
        } ?>
      </tbody>
    </table>
  </section>
  <!--Modal para registrar empleado se abre y cierra con javascript  -->
  <div id="modal" class="modal">
    <div class="modal-content">
      <span id="close-modal-btn">&times;</span>
      <h1>Registrar Empleado</h1>
      <form action="controladorEmpleado.php?empresa=<?= $objEmpresa ?>" id="registration-form" class="form" method="POST" enctype="multipart/form-data">
    <div class="flex">
        <div class="form-group">
            <input type="number" id="identificacion" name="identificacion" class="form-input" required>
            <label for="identificacion" class="heading">N° Identificacion</label>
        </div>
        <div class="form-group">
            <input type="text" id="nombre" name="nombre" class="form-input" required>
            <label for="nombre" class="heading">Nombre</label>
        </div>
    </div>
    <div class="flex">
        <div class="form-group">
            <input type="text" id="apellido" name="apellido" class="form-input" required>
            <label for="apellido" class="heading">Apellido</label>
        </div>
        <div class="form-group">
            <input type="text" id="tipoDocumento" name="tipoDocumento" class="form-input" required>
            <label for="tipoDocumento" class="heading">Tipo de Documento</label>
        </div>
    </div>
    <div class="flex">
        <div class="form-group">
            <input type="text" id="genero" name="genero" class="form-input" required>
            <label for="genero" class="heading">Genero</label>
        </div>
        <div class="form-group">
            <input type="text" id="ciudad" name="ciudad" class="form-input" required>
            <label for="ciudad" class="heading">Ciudad</label>
        </div>
    </div>
    <div class="flex">
        <div class="form-group">
            <input type="text" id="correo" name="correo" class="form-input" required>
            <label for="correo" class="heading">Correo</label>
        </div>
        <div class="form-group">
            <input type="date" id="fechaNacimiento" name="fechaNacimiento" class="form-input" required>
            <label for="fechaNacimiento" class="heading">Fecha Nacimiento</label>
        </div>
    </div>
    <div class="flex">
        <div class="form-group">
            <input type="date" id="fechaExpedicion" name="fechaExpedicion" class="form-input" required>
            <label for="fechaExpedicion" class="heading">Fecha Expedicion</label>
        </div>
        <div class="form-group">
            <input type="number" id="telefono" name="telefono" class="form-input" required>
            <label for="telefono" class="heading">Telefono</label>
        </div>
    </div>
    <div class="flex">
        <div class="form-group">
            <input type="text" id="direccion" name="direccion" class="form-input" required>
            <label for="direccion" class="heading">Dirección</label>
        </div>
        <div class="form-group">
            <input type="text" id="estadoCivil" name="estadoCivil" class="form-input" required>
            <label for="estadoCivil" class="heading">Estado Civil</label>
        </div>
    </div>
    <div class="flex">
        <div class="form-group">
            <input type="text" id="nivelEstudio" name="nivelEstudio" class="form-input" required>
            <label for="nivelEstudio" class="heading">Nivel de Estudio</label>
        </div>
        <div class="form-group">
            <input type="text" id="departamento" name="departamento" class="form-input" required>
            <label for="departamento" class="heading">Departamento</label>
        </div>
        <div class="form-group">
            <input type="number" id="codEstadoEmpleado" name="codEstadoEmpleado" class="form-input" required>
            <label for="codEstadoEmpleado" class="heading">Código Estado Empleado</label>
        </div>
    </div>
    <input type="submit" value="Registrar" class="Boton" name="boton">
</form>

    </div>
  </div>
  <script src="../js/modal.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../js/alert.js"></script>
  <script>

  </script>
</body>

</html>