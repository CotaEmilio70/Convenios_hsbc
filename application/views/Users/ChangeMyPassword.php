<?php if($this->session->flashdata('message_edit')){?>
    <div class="alert alert-<?= $this->session->flashdata('class') ?> alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <?= $this->session->flashdata('message_edit') ?>
    </div>
<?php } ?>
<?= form_open_multipart('/Users/ChangeMyPasswordPost', array("id" => "frmEdit")) ?>
<input type="hidden" name="UID" id="UID" value="<?= $User->UID ?>">
<div class="panel panel-uni">
  <div class="panel-heading">
    <h3 class="panel-title">Cambiar mi contraseña</h3>
  </div>
  <div class="panel-body">
    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <label class="control-label" for="Name">Nombre:</label>
            <?php echo form_input(array('value' => $User->Name, 'placeholder' => 'Nombre','id' => 'Name', 'class' => 'form-control', 'readonly' => 'readonly')) ?>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
            <label class="control-label" for="UserName">Usuario:</label>
            <?php echo form_input(array('value' => $User->UID, 'name' => 'UserName','placeholder' => 'Nombre de usuario','id' => 'UserName', 'class' => 'form-control', 'readonly' => 'readonly')) ?>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
            <label class="control-label" for="Password">Contraseña:</label>
            <?php echo form_password(array('name' => 'Password','placeholder' => 'Contraseña','id' => 'Password', 'class' => 'form-control required-field', "max-length" => "50")) ?>
            <label class="control-label" style="display:none;">Este campo es obligatorio</label>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
            <label class="control-label" for="RepeatPassword">Repetir contraseña:</label>
            <?php echo form_password(array('name' => 'RepeatPassword','placeholder' => 'Repetir contraseña','id' => 'RepeatPassword', 'class' => 'form-control required-field', "max-length" => "50")) ?>
            <label class="control-label" style="display:none;">Las contraseñas no coinciden</label>
        </div>
    </div>
     <div class="audit-fields" style="margin-top: 15px;">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <label>Creado por: <?= $CreatedBy ?></label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <label>Fecha de creación: <?= $User->CreatedDate ?></label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <label>Modificado por: <?= $UpdatedBy ?></label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <label>Fecha de modificación: <?= $User->UpdatedDate ?></label>
            </div>
        </div>
    </div>
  </div>
</div>
        
    <div class="row" style="margin-top:15px;">
        <div class="col-md-2 col-sm-3 col-xs-6">
            <a href="<?= base_url() ?>Users" class="btn btn-default" style="width:100%;">Volver</a>
        </div>
        <div class="col-md-offset-8 col-sm-offset-6 col-md-2 col-sm-3 col-xs-6">
            <?php echo form_submit(array("value" => "Guardar", "class" => "btn btn-success", 'style' => 'float: right;width:100%;')) ?>
        </div>
    </div>
<?php echo form_close() ?>


<script>
    $(function()
    {
        $("#RepeatPassword").change(function()
        {
            if($("#hdTriedSave").val() == "true")
            {
                if($("#Password").val().trim().length > 0 && $("#RepeatPassword").val().trim().length > 0){
                if($("#Password").val() == $("#RepeatPassword").val())
                {
                    $("#RepeatPassword").parent().removeClass("has-error");
                    $("#RepeatPassword").next().hide();
                }else{
                     $("#RepeatPassword").parent().addClass("has-error");
                     $("#RepeatPassword").next().show();
                }
            }
            }
        })

        $("#frmEdit").submit(function()
        {
            $("#hdTriedSave").val("true");
            var vSubmit = true;

            if($("#Password").val().trim().length == 0){
                vSubmit = false;
                $("#Password").parent().addClass("has-error");
                $("#Password").next().show();
            }

            if($("#Password").val().trim().length > 0 && $("#RepeatPassword").val().trim().length > 0){
                if($("#Password").val() != $("#RepeatPassword").val())
                {
                    vSubmit = false;
                    $("#RepeatPassword").parent().addClass("has-error");
                    $("#RepeatPassword").next().show();
                }
            }else{
                vSubmit = false;
            }
            if(vSubmit)
                $(".loader-gif").show();
            return vSubmit;
        })
    })
</script>