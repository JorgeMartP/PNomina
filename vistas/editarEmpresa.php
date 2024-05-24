<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empresa</title>
    <link rel="stylesheet" href="../styles/modal.css">
</head>
<?php
require('../dao/DaoEmpresaImp.php');
$dao = new DaoEmpresaImp();
//codigo para saber si se manda un parametro por GET y capturarlo 
if (isset($_GET['id'])) {
    $nit = $_GET['id'];
    //variable para traer la informacion de la empresa seleccionada 
    $Actualizar = $dao->traer($nit);
}
?>
<body>
    <!--Formulario para actualizar empresa -->
    <div id="modal2" class="modal2">
        <div class="modal-content2">
            <h1>Actualizar Empresa</h1>
            <!--mostrar en el formulario la informacion de la empresa elegida-->
                    <form action="../controlador/controladorEditarEmpresa.php?id=<?php echo $Actualizar->getNit()?>" id="registration-form" class="form" method="POST" enctype="multipart/form-data">
                        <div class="flex">
                            <div class="form-group">
                                <input type="text" id="nit" name="nitUp" class="form-input" value="<?php echo $Actualizar->getNit() ?>" readonly required>
                                <label for="nit" class="logo">NIT</label>
                            </div>
                            <div class="form-group">
                                <input type="text" id="nombre" name="nombreUp" class="form-input" value="<?= $Actualizar->getNombreEmpresa() ?>" required>
                                <label for="nombre" class="heading">Nombre</label>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="form-group">
                                <input type="text" id="direccion" name="direccionUp" class="form-input" value="<?= $Actualizar->getDireccionEmpresa() ?>" required>
                                <label for="direccion" class="heading">Dirección</label>
                            </div>
                            <div class="form-group">
                                <input type="text" id="telefono" name="telefonoUp" class="form-input" value="<?= $Actualizar->getTelefonoEmpresa() ?>" required>
                                <label for="telefono" class="heading">Teléfono</label>
                            </div>
                        </div>
                        <div class="flex">
                            <div class="form-group">
                                <input type="email" id="correo" name="correoUp" class="form-input" value="<?= $Actualizar->getCorreoEmpresa() ?>" required>
                                <label for="correo" class="heading">Correo</label>
                            </div>
                            <div class="form-group">
                                <input type="text" id="tipoContribuyente" name="tipoContribuyenteUp" class="form-input" value="<?= $Actualizar->getTipoContribuyente() ?>" required>
                                <label for="tipoContribuyente" class="heading">Tipo Contribuyente</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" id="rut" name="rutUp" class="form-input" value="<?= $Actualizar->getRut() ?>" required>
                            <label for="rut" class="heading">Rut</label>
                        </div>
                        <div class="form-group">
                            <input type="text" id="digitoVerificacion" name="digitoVerificacionUp" class="form-input" value="<?= $Actualizar->getDigitoVerificacion() ?>" required>
                            <label for="digitoVerificacion" class="heading">Dígito Verificación</label>
                        </div>
                        <div class="form-group">
                            <input type="file" id="logo" name="imagen" class="form-input">
                            <label for="logo" class="logo">Logo</label>
                        </div>
                        <div class="form-group">
                            <input type="file" id="camaraComercio" name="pdf" class="form-input">
                            <label for="camaraComercio" class="camaraComercio">Cámara Comercio</label>
                        </div>
                <input type="submit" value="Actualizar" class="Boton" name="bottonUp">
                    </form>
        </div>
    </div>
</body>
</html>