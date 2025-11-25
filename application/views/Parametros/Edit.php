<?php if($this->session->flashdata('message_edit')){?>
    <div class="alert alert-<?= $this->session->flashdata('class') ?> alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <?= $this->session->flashdata('message_edit') ?>
    </div>
<?php } ?>
<?= form_open_multipart('/Parametros/EditPost', array("id" => "frmEdit")) ?>
<?php
    $Parametros->razon_soc = set_value("Nombreempresa") != "" ? set_value("Nombreempresa") : $Parametros->razon_soc;
    $Parametros->direccion = set_value("Direccion") != "" ? set_value("Direccion") : $Parametros->direccion;
    $Parametros->rfc = set_value("RFC") != "" ? set_value("RFC") : $Parametros->rfc;
?>
<div class="panel panel-uni">
  <div class="panel-heading">
    <h3 class="panel-title">Editar parametros</h3>
  </div>
  <div class="panel-body">
    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <label class="control-label" for="Nombreempresa">Nombre despacho:</label>
            <input type="text" name="Nombreempresa" id="Nombreempresa" value="<?= $Parametros->razon_soc ?>" placeholder="Nombre de empresa" class="form-control required-field" max-length="50">
            <label class="control-label" style="display:none;">Este campo es obligatorio</label>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
            <label class="control-label" for="Direccion">Dirección despacho:</label>
            <input type="text" name="Direccion" id="Direccion" value="<?= $Parametros->direccion ?>" placeholder="Dirección" class="form-control required-field" max-length="40">
            <label class="control-label" style="display:none;">Este campo es obligatorio</label>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
            <label class="control-label" for="RFC">RFC despacho:</label>
            <input type="text" name="RFC" id="RFC" value="<?= $Parametros->rfc ?>" placeholder="RFC" class="form-control required-field" max-length="15">
            <label class="control-label" style="display:none;">Este campo es obligatorio</label>
        </div>

        <div class="col-md-8 col-sm-8 col-xs-12">
            <label class="control-label" for="entidad_financiera">Entidad financiera:</label>
            <input type="text" name="entidad_financiera" id="entidad_financiera" value="<?= $Parametros->entidad_financiera ?>" placeholder="Entidad financiera" class="form-control required-field" max-length="100">
            <label class="control-label" style="display:none;">Este campo es obligatorio</label>
        </div>

        <div class="col-md-4 col-sm-4 col-xs-12">
            <label class="control-label" for="nombrecorto_ef">Nombre corto E.F.:</label>
            <input type="text" name="nombrecorto_ef" id="nombrecorto_ef" value="<?= $Parametros->nombrecorto_ef ?>" placeholder="Nombre corto" class="form-control required-field" max-length="10">
            <label class="control-label" style="display:none;">Este campo es obligatorio</label>
        </div>

        <div class="col-md-8 col-sm-8 col-xs-12">
            <label class="control-label" for="direccion_ef">Direccion E.F.:</label>
            <input type="text" name="direccion_ef" id="direccion_ef" value="<?= $Parametros->direccion_ef ?>" placeholder="Direccion E.F." class="form-control required-field" max-length="120">
            <label class="control-label" style="display:none;">Este campo es obligatorio</label>
        </div>

        <div class="col-md-4 col-sm-4 col-xs-12">
            <label class="control-label" for="telefono_ef">Telefono E.F.:</label>
            <input type="text" name="telefono_ef" id="telefono_ef" value="<?= $Parametros->telefono_ef ?>" placeholder="Telefono E.F." class="form-control required-field" max-length="15">
            <label class="control-label" style="display:none;">Este campo es obligatorio</label>
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <label class="control-label" for="nombrefirma_ef">Nombre de quien firma los convenios:</label>
            <input type="text" name="nombrefirma_ef" id="nombrefirma_ag" value="<?= $Parametros->nombrefirma_ag ?>" placeholder="Nombre de quien firma los convenios" class="form-control required-field" max-length="60">
            <label class="control-label" style="display:none;">Este campo es obligatorio</label>
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <label class="control-label" for="cd_edo_expedicion">Cd y Edo de expedicion de los convenios:</label>
            <input type="text" name="cd_edo_expedicion" id="cd_edo_expedicion" value="<?= $Parametros->cd_edo_expedicion ?>" placeholder="Ciudad y estado de expedicion" class="form-control required-field" max-length="50">
            <label class="control-label" style="display:none;">Este campo es obligatorio</label>
        </div>

        <div class="col-md-8 col-sm-8 col-xs-12" style="margin-top:20px;">

            <div class="col-md-8 col-sm-8 col-xs-12">
                
                <div class="col-md-7 col-sm-7 col-xs-12">
                    <label class="control-label" for="imagen_firma">Archivos/Imagen de firma actual:</label>
                    <input readonly type="text" name="imagen_firma" id="imagen_firma" value="<?= $Parametros->imagen_firma_ag ?>" class="form-control">
                </div>
                
                <div class="col-md-5 col-sm-5 col-xs-12">
                    <label class="control-label" for="archivoimagen">Imagen de firma nuevo:</label>
                    <input type="file" name="archivoimagen" id="archivoimagen" accept="image/*" >
                </div>
            </div>

        </div>

        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:20px;">
            <label class="label-control">Nota final convenio (se admite texto normal y codigo html para el texto enriquecido):</label>
         </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <textarea class="form-control" rows="7" name="nota_final" id="nota_final" placeholder="Nota final" required><?= $Parametros->nota_final ?></textarea>
            </div>
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <label class="control-label" for="verconv_usr">Registros a mostrar para usuario:</label>
            <input type="text" name="verconv_usr" id="verconv_usr" value="<?= $Parametros->verconv_usr ?>" class="form-control required-field numeric-field">
            <label class="control-label" style="display:none;">Este campo es obligatorio</label>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <label class="control-label" for="verconv_usr">Registros a mostrar para admin:</label>
            <input type="text" name="verconv_sup" id="verconv_sup" value="<?= $Parametros->verconv_sup ?>" class="form-control required-field numeric-field">
            <label class="control-label" style="display:none;">Este campo es obligatorio</label>
        </div>

    </div>

     <div class="audit-fields" style="margin-top: 15px;">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <label>Modificado por: <?= $UpdatedBy ?></label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <label>Fecha de modificación: <?= $Parametros->UpdatedDate ?></label>
            </div>
        </div>
    </div>

  </div>
</div>
        
<div class="row" style="margin-top:15px;">
    <div class="col-md-2 col-sm-3 col-xs-6">
        <a href="<?= base_url() ?>Parametros/Details" class="btn btn-default" style="width:100%;">Volver</a>
    </div>
    <div class="col-md-offset-8 col-sm-offset-6 col-md-2 col-sm-3 col-xs-6">
        <input class="btn btn-success" id="btnSave" style="float: right;width:100%;'" type="button" value="Guardar">
    </div>
</div>

<!-- Ventana modal para autorizacion-->
<div class="modal fade" id="mAutorizacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #4d4dff;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" style="color: #FFF;">Autorizacion</h4>
      </div>
      <div class="modal-body">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <label class="label-display-name">Autorizado por:</label>
        </div>

        <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12">
                <label class="label-control" for="txbUsuario">Usuario:</label>
                <input type="text" id="txbUsuario" name="txbUsuario" class="form-control" placeholder="Usuario" max-length="10">
            </div>
            <div class="col-md-8 col-sm-6 col-xs-12">
                <label class="label-control" for="txbContrasena">Contraseña:</label>
                <input type="password" id="txbContrasena" class="form-control" placeholder="Contraseña">
            </div>
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Regresar</button>
        <button type="button" class="btn btn-primary" id="btnAutorizar">Autorizar</button>
      </div>

    </div>    
  </div>
</div>

<?= form_close() ?>

<script>

    window.onload=AsignarFunciones();

    function AsignarFunciones()
    {
        $(".numeric-field").keypress(function(event){
            if($(this).val() == "" && event.charCode == 46){
                return false;
            }
            if($(this).val().split('.').length >= 2 && event.charCode == 46 ){
                return false;
            }
            return event.charCode >= 48 && event.charCode <=57 || event.charCode == 46 || event.charCode == 13;
        })
        $(".just-number").keypress(function(event){
            return event.charCode >= 48 && event.charCode <=57 || event.charCode == 13;
        })

        $("[max-length]").keypress(function()
        {
            //event.preventDefault();
            var vMaxLength = $(this).attr("max-length");
            var vSelectedText = document.getSelection().toString();
            if($(this).val().length >= vMaxLength && vSelectedText.length == 0)
            {
                return false;
            }
        })

        $('.datetimepicker').datepicker({
            format: "dd/mm/yyyy",
            clearBtn: true,
            language: "es",
            orientation: "bottom auto",
            autoclose: true,
            todayHighlight: true
        });
    }

    $(function()
    {

        $("#btnSave").click(function()
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

            if(vSubmit){
                $("#mAutorizacion").modal("show");
            }

        })

        $("#btnAutorizar").click(function()
        {
            $("p.loader-gif").text("Verificando...");
            $(".loader-gif").show();
             $.ajax({
                url: $("#url").val() + '/Users/AutorizacionSuperv/',
                dataType: "json",
                data: {
                    Usuario: $("#txbUsuario").val(),
                    Contrasena: $("#txbContrasena").val(),
                },
                type: "GET",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    if(data.length == 0)
                    {
                        vAutorizado = true;
                        $("#mAutorizacion").modal("hide");
                        //$("#AutorizadoPor").val($("#txbUsuario").val());
                        $("#frmEdit").submit();

                    }else
                    {
                        bootbox.alert(data);
                        $(".loader-gif").hide();
                    }
                },
                error: function (error) {
                    bootbox.alert(error.responseText);
                }
            });
        })

        $(".required-field").change(function()
        {
            if($(this).val() != ""){
                $(this).parent().parent().parent().removeClass("has-error");
                $(this).parent().parent().next().hide();
            }
            if($(this).val() == "" && $("#hdTriedSave").val() == "true"){
                $(this).parent().parent().parent().addClass("has-error");
                $(this).parent().parent().next().show();
            }
        })

        $("#frmEdit").submit(function()
        {
            $(".loader-gif").hide();     
            vSubmit = true;
            return vSubmit;
        })
    })
</script>