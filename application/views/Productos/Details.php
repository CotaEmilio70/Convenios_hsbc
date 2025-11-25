<?php 
    $IdUsuario = $this->session->UID;
?>
<?php if($this->session->flashdata('message_details')){?>
    <div class="alert alert-<?php echo $this->session->flashdata('class') ?> alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <?php echo $this->session->flashdata('message_details') ?>
    </div>
<?php } ?>
<div class="panel panel-uni">
  <div class="panel-heading">
    <h3 class="panel-title">Detalles de Producto</h3>
  </div>
  <div class="panel-body">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <label class="label-display-name">Id:</label> 
            <label><?= $Producto->Id ?></label>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <label class="label-display-name">Nombre:</label> 
            <label><?= $Producto->Nombre?></label>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="label-display-name">Num. Gweb:</label> 
            <label><?= $Producto->Numero?></label>
        </div>
    </div>
     <div class="audit-fields" style="margin-top: 15px;">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <label>Creado por: <?= $Createdby ?></label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <label>Fecha de creación: <?= $Producto->CreatedDate ?></label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <label>Modificado por: <?= $Updatedby ?></label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <label>Fecha de modificación: <?= $Producto->UpdatedDate ?></label>
            </div>
        </div>
    </div>
  </div>
</div>

<div class="row" style="margin-top:15px;">
    <div class="col-md-2 col-sm-3 col-xs-4">
            <a href="<?= base_url() ?>Productos" class="btn btn-default" style="width:100%;">Volver</a>
    </div>
    <div class="col-md-offset-6 col-sm-offset-3 col-md-2 col-sm-3 col-xs-4">
        <?php if(VerificarPermisos($IdUsuario, "Productos", "Edit")){ ?>
        <a href="<?= base_url() ?>Productos/Edit/<?= $Producto->Id ?>" class="btn btn-primary" style="float:right;width:100%">Editar</a>
        <?php } ?>
    </div>
    <div class="col-md-2 col-sm-3 col-xs-4">
        <?php if(VerificarPermisos($IdUsuario, "Productos", "Delete")){ ?>
        <a class="btn btn-danger" style="float:right;width:100%" data-message-delete="El registro se eliminara, ¿Desea continuar?">Eliminar</a>
        <?php } ?>
    </div>
</div>

<?= form_open_multipart('/Productos/Delete', array("id" => "frmDelete")) ?>
    <input type="hidden" name="Id" id="Id" value="<?= $Producto->Id ?>">
<?php echo form_close() ?>