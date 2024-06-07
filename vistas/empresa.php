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
    if($_SESSION['rol'] != 2 || $_SESSION['rol'] != 1){
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
<div class="card" id="cookieCard">
 <svg version="1.1" id="cookieSvg" x="0px" y="0px" viewBox="0 0 122.88 122.25" xml:space="preserve"><g><path d="M101.77,49.38c2.09,3.1,4.37,5.11,6.86,5.78c2.45,0.66,5.32,0.06,8.7-2.01c1.36-0.84,3.14-0.41,3.97,0.95 c0.28,0.46,0.42,0.96,0.43,1.47c0.13,1.4,0.21,2.82,0.24,4.26c0.03,1.46,0.02,2.91-0.05,4.35h0v0c0,0.13-0.01,0.26-0.03,0.38 c-0.91,16.72-8.47,31.51-20,41.93c-11.55,10.44-27.06,16.49-43.82,15.69v0.01h0c-0.13,0-0.26-0.01-0.38-0.03 c-16.72-0.91-31.51-8.47-41.93-20C5.31,90.61-0.73,75.1,0.07,58.34H0.07v0c0-0.13,0.01-0.26,0.03-0.38 C1,41.22,8.81,26.35,20.57,15.87C32.34,5.37,48.09-0.73,64.85,0.07V0.07h0c1.6,0,2.89,1.29,2.89,2.89c0,0.4-0.08,0.78-0.23,1.12 c-1.17,3.81-1.25,7.34-0.27,10.14c0.89,2.54,2.7,4.51,5.41,5.52c1.44,0.54,2.2,2.1,1.74,3.55l0.01,0 c-1.83,5.89-1.87,11.08-0.52,15.26c0.82,2.53,2.14,4.69,3.88,6.4c1.74,1.72,3.9,3,6.39,3.78c4.04,1.26,8.94,1.18,14.31-0.55 C99.73,47.78,101.08,48.3,101.77,49.38L101.77,49.38z M59.28,57.86c2.77,0,5.01,2.24,5.01,5.01c0,2.77-2.24,5.01-5.01,5.01 c-2.77,0-5.01-2.24-5.01-5.01C54.27,60.1,56.52,57.86,59.28,57.86L59.28,57.86z M37.56,78.49c3.37,0,6.11,2.73,6.11,6.11 s-2.73,6.11-6.11,6.11s-6.11-2.73-6.11-6.11S34.18,78.49,37.56,78.49L37.56,78.49z M50.72,31.75c2.65,0,4.79,2.14,4.79,4.79 c0,2.65-2.14,4.79-4.79,4.79c-2.65,0-4.79-2.14-4.79-4.79C45.93,33.89,48.08,31.75,50.72,31.75L50.72,31.75z M119.3,32.4 c1.98,0,3.58,1.6,3.58,3.58c0,1.98-1.6,3.58-3.58,3.58s-3.58-1.6-3.58-3.58C115.71,34.01,117.32,32.4,119.3,32.4L119.3,32.4z M93.62,22.91c2.98,0,5.39,2.41,5.39,5.39c0,2.98-2.41,5.39-5.39,5.39c-2.98,0-5.39-2.41-5.39-5.39 C88.23,25.33,90.64,22.91,93.62,22.91L93.62,22.91z M97.79,0.59c3.19,0,5.78,2.59,5.78,5.78c0,3.19-2.59,5.78-5.78,5.78 c-3.19,0-5.78-2.59-5.78-5.78C92.02,3.17,94.6,0.59,97.79,0.59L97.79,0.59z M76.73,80.63c4.43,0,8.03,3.59,8.03,8.03 c0,4.43-3.59,8.03-8.03,8.03s-8.03-3.59-8.03-8.03C68.7,84.22,72.29,80.63,76.73,80.63L76.73,80.63z M31.91,46.78 c4.8,0,8.69,3.89,8.69,8.69c0,4.8-3.89,8.69-8.69,8.69s-8.69-3.89-8.69-8.69C23.22,50.68,27.11,46.78,31.91,46.78L31.91,46.78z M107.13,60.74c-3.39-0.91-6.35-3.14-8.95-6.48c-5.78,1.52-11.16,1.41-15.76-0.02c-3.37-1.05-6.32-2.81-8.71-5.18 c-2.39-2.37-4.21-5.32-5.32-8.75c-1.51-4.66-1.69-10.2-0.18-16.32c-3.1-1.8-5.25-4.53-6.42-7.88c-1.06-3.05-1.28-6.59-0.61-10.35 C47.27,5.95,34.3,11.36,24.41,20.18C13.74,29.69,6.66,43.15,5.84,58.29l0,0.05v0h0l-0.01,0.13v0C5.07,73.72,10.55,87.82,20.02,98.3 c9.44,10.44,22.84,17.29,38,18.1l0.05,0h0v0l0.13,0.01h0c15.24,0.77,29.35-4.71,39.83-14.19c10.44-9.44,17.29-22.84,18.1-38l0-0.05 v0h0l0.01-0.13v0c0.07-1.34,0.09-2.64,0.06-3.91C112.98,61.34,109.96,61.51,107.13,60.74L107.13,60.74z M116.15,64.04L116.15,64.04 L116.15,64.04L116.15,64.04z M58.21,116.42L58.21,116.42L58.21,116.42L58.21,116.42z"></path></g></svg>
 <p class="cookieHeading">Usamos cookies.</p>
<p class="cookieDescription">Este sitio web utiliza cookies para asegurarse de que obtenga la mejor experiencia en nuestro sitio.</p>

<div class="buttonContainer">
  <button class="acceptButton" id="acceptButton">Permitir</button>
  <button class="declineButton" id="declineButton" >Rechazar</button>
</div>
  

</div>
<!-- Se incluyen los scripts -->
<script src="../js/modal.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/empresaAlert.js"></script>
<script>
    document.getElementById('acceptButton').addEventListener('click', function() {
  document.getElementById('cookieCard').style.display = 'none';
});
document.getElementById('declineButton').addEventListener('click', function() {
  document.getElementById('cookieCard').style.display = 'none';
});
</script>
</body>

</html>