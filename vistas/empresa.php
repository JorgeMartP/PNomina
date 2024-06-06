<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="estilos.css"> -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../styles/estiloCard.css">
    <link rel="stylesheet" href="../styles/modal.css">
    <title>Listar</title>    
</head>
<body>
    <h1>Elige una Empresas</h1>
    <div class="container">
<?php
include_once('../controlador/controladorEmpresa.php');
session_start();
if (!isset($_SESSION['rol'])) {
    header("Location: inicioSesion.php");
    exit();
}else{
    if($_SESSION['rol'] != 2 && $_SESSION['rol'] != 1){
        header("Location: inicioSesion.php");
        exit();
    }
}
    //listar las empresas existentes en la base de datos en una card
    // Se comprueba si hay empresas para listar
    if(count($Empresas) != 0){
        // Se recorren las empresas existentes
    foreach ($Empresas as $key) {?>
    <!-- Se muestra una card para cada empresa -->
        <div class="card">
            <!-- Se muestra el logo de la empresa -->
            <div class="img">
                <img src="<?= $key->getLogo()?>" alt="logo">
            </div>
            <!-- Se muestra el nombre de la empresa traidos desde la clase Empresa -->
            <span><?=$key->getNombreEmpresa()?></span>
            <!-- Se muestran detalles de la empresa -->
            <div class="info">
                <p><span>Nit: </span><?=$key->getNit()?></p>
                <p><span>Dirección: </span><?=$key->getDireccionEmpresa()?></p>
                <p><span>Teléfono: </span><?=$key->getTelefonoEmpresa()?></p>
                <p><span>Correo: </span><?=$key->getCorreoEmpresa()?></p>
            </div>
            <!-- Se muestran los enlaces para editar y eliminar la empresa segun el nit del la empresa seleccionada -->
            <div class="share">
                <a href="../controlador/controladorEmpresa.php?empresa=<?=$key->getNit()?>" onclick="advertencia(event)"><i class='bx bxs-trash'></i></a>
                <a href="../vistas/editarEmpresa.php?id=<?=$key->getNit()?>" class="update" ><i class='bx bxs-edit'></i></a>
            </div>
            <!-- Se muestra un enlace para ingresar a los empleados de la empresa -->
            <a href="../controlador/controladorEmpleado.php?empresa=<?=$key->getNit()?>">Ingresar</a>
        </div>
            <?php  }}?>
        <div class="card">
            <!-- Botón para abrir el modal de registro -->
            <h1>Crear Empresa</h1>
            <div class="img">
                <button id="open-modal-btn" class="add"><i class='bx bxs-add-to-queue'></i></button>
            </div>
        </div>
    </div>
<!--modal con el formulario  para registrar Empresa se abre y cierra con el script modal.js -->
<div id="modal" class="modal">
   <div class="modal-content">
    <span id="close-modal-btn">&times;</span>
    <h1>Registrar Empresa</h1>
    <form action="controladorEmpresa.php" id="registration-form" class="form" method="POST" enctype="multipart/form-data">
        <div class="flex">
            <div class="form-group">
                <input type="text" id="nit" name="nit" class="form-input" required>
                <label for="nit" class="heading">NIT</label>
            </div>
            <div class="form-group">
                <input type="text" id="nombre" name="nombre" class="form-input"  required>
                <label for="nombre" class="heading">Nombre</label>
            </div>
        </div>
        <div class="flex">
            <div class="form-group">
                <input type="text" id="direccion" name="direccion" class="form-input" required>
                <label for="direccion" class="heading">Dirección</label>
            </div>
            <div class="form-group">
                <input type="text" id="telefono" name="telefono" class="form-input" required>
                <label for="telefono" class="heading">Teléfono</label>
            </div>
        </div>
        <div class="flex">
            <div class="form-group">
                <input type="email" id="correo" name="correo" class="form-input" required>
                <label for="correo" class="heading">Correo</label>
            </div>
            <div class="form-group">
                <input type="text" id="tipoContribuyente" name="tipoContribuyente" class="form-input" required>
                <label for="tipoContribuyente" class="heading">Tipo Contribuyente</label>
            </div>
        </div>
        <div class="form-group">
            <input type="text" id="rut" name="rut" class="form-input" required>
            <label for="rut" class="heading">Rut</label>
        </div>
        <div class="form-group">
            <input type="text" id="digitoVerificacion" name="digitoVerificacion" class="form-input" required>
            <label for="digitoVerificacion" class="heading">Dígito Verificación</label>
        </div>
        <div class="form-group">
            <input type="file" id="logo" name="imagen" class="form-input" accept="image/*" required>
            <label for="logo" class="logo">Logo</label>
        </div>
        <div class="form-group">
            <input type="file" id="camaraComercio" name="pdf" class="form-input" accept=".pdf" required >
            <label for="camaraComercio" class="logo">Cámara Comercio</label>
        </div>
        <!-- Botón de envío del formulario -->
        <input type="submit" value="Registrar" class="Boton" name="bottonEm">
    </form>
</div>
</div>
<!-- Se incluyen los scripts -->
<script src="../js/modal.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/empresaAlert.js"></script>
</body>

</html>