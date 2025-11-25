<?php if($this->session->flashdata('message_edit')){?>
    <div class="alert alert-<?= $this->session->flashdata('class') ?> alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <?= $this->session->flashdata('message_edit') ?>
    </div>
<?php } ?>
<?= form_open_multipart('/Productos/EditPost', array("id" => "frmEdit")) ?>
<?php
    $Producto->Nombre = set_value("Nombre") != "" ? set_value("Nombre") : $Producto->Nombre;
?>
<input type="hidden" name="Id" id="Id" value="<?= $Producto->Id ?>">
<div class="panel panel-uni">
  <div class="panel-heading">
    <h3 class="panel-title">Editar Producto</h3>
  </div>
  <div class="panel-body">
    <div class="row">
        <div class="col-md-2 col-sm-6 col-xs-12">
            <label class="control-label" for="Id">Id:</label>
            <input type="text" value="<?= $Producto->Id ?>" placeholder="Id" class="form-control" disabled>
            <label class="control-label" style="display:none;">Este campo es obligatorio</label>
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <label class="control-label" for="Nombre">Nombre:</label>
            <input type="text" name="Nombre" id="Nombre" value="<?= $Producto->Nombre ?>" placeholder="Nombre" class="form-control required-field" max-length="60">
            <label class="control-label" style="display:none;">Este campo es obligatorio</label>
        </div>

        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="control-label" for="Nombre">Num. Gweb:</label>
            <input type="text" name="Numero" id="Numero" value="<?= $Producto->Numero ?>" placeholder="Num." class="form-control required-field" max-length="3">
            <label class="control-label" style="display:none;">Este campo es obligatorio</label>
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
        <div class="col-md-2 col-sm-3 col-xs-6">
            <a href="<?= base_url() ?>Productos" class="btn btn-default" style="width:100%;">Volver</a>
        </div>
        <div class="col-md-offset-8 col-sm-offset-6 col-md-2 col-sm-3 col-xs-6">
            <?php echo form_submit(array("value" => "Guardar", "class" => "btn btn-success", 'style' => 'float: right;width:100%;')) ?>
        </div>
    </div>
<?php echo form_close() ?>


<script>


    $(function()
    {        
        $("#frmEdit").submit(function()
        {
            $("#hdTriedSave").val("true");
            var vSubmit = true;
            $(".required-field").each(function()
            {
                if($(this).val().trim().length == 0)
                {
                    vSubmit = false;
                    $(this).parent().addClass("has-error");
                    $(this).next().show();
                }
            })

            if(vSubmit)
                $(".loader-gif").show();
            return vSubmit;
        })
    })
</script>