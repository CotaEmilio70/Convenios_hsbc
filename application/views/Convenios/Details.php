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
    <h3 class="panel-title">Detalles del convenio</h3>
  </div>

  <div class="panel-body">
    <div class="row">
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="label-display-name">Cuenta:</label> 
            <label><?= $Convenio->Dmacct ?></label>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <label class="label-display-name">Nombre:</label> 
            <label><?= $Convenio->Nombre ?></label>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <label class="label-display-name">Negociacion:</label> 
            <label><?=  $this->Tiposnego_model->GetNombreByid($Convenio->Tipo_negoid) ?></label>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="label-display-name">Plataforma:</label> 
            <label><?= $Convenio->Plataforma ?></label>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="label-display-name">Producto:</label> 
            <label><?= $Convenio->Producto ?></label>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="label-display-name">F. apertura:</label> 
            <label><?= $Convenio->Fec_ape ?></label>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="label-display-name">M. castigo:</label> 
            <label><?= $Convenio->Uxmescast ?></label>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="label-display-name">Saldo actual:</label> 
            <label><?= number_format($Convenio->Uxtot_adeu,2) ?></label>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="label-display-name">Saldo contable:</label> 
            <label><?= number_format($Convenio->Dmcurbal,2) ?></label>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="label-display-name">Pago_minimo:</label> 
            <label><?= number_format($Convenio->U6pag_min,2) ?></label>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="label-display-name">Saldo al corte:</label> 
            <label><?= number_format($Convenio->U6sdo_cort,2) ?></label>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="label-display-name">Saldo vencido:</label> 
            <label><?= number_format($Convenio->Dmamtdlq,2) ?></label>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="label-display-name">Monto principal:</label> 
            <label><?= number_format($Convenio->Uxcap_cred,2) ?></label>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="label-display-name">Saldo vencido:</label> 
            <label><?= number_format($Convenio->Dmpayoff,2) ?></label>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="label-display-name">Int. Ordinarios:</label> 
            <label><?= number_format($Convenio->Uxint_cred,2) ?></label>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="label-display-name">Int. Moratorios:</label> 
            <label><?= number_format($Convenio->Uxmora_cred,2) ?></label>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="label-display-name">Conc. exigibles:</label> 
            <label><?= number_format($Convenio->Uxexig_cre,2) ?></label>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="label-display-name">Folio conv.:</label> 
            <label><?= $Convenio->Folio_pre."-".str_pad($Convenio->Folio_cons, 4, "0", STR_PAD_LEFT) ?></label>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="label-display-name">Fecha neg.:</label> 
            <label><?= $Convenio->Fecha_neg ?></label>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="label-display-name">Quita negociada:</label> 
            <label><?= $Convenio->Quita_neg ?></label>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="label-display-name">Excepcion:</label> 
            <label><?= $Convenio->Excepcion ?></label>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="label-display-name">Autorizacion:</label> 
            <label><?= $Convenio->Auto_excep ?></label>
        </div>

        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="label-display-name">Estatus:</label> 
            <label><?= $Convenio->Estado_conv ?></label>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="label-display-name">Negociado con:</label> 
            <label><?= $Convenio->Saldo_usado ?></label>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="label-display-name">Plastico/pago:</label> 
            <label><?= $Convenio->plastico_pago ?></label>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="label-display-name">Telefono.:</label> 
            <label><?= $Convenio->Telefono ?></label>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="label-display-name">Tipo tel.:</label> 
            <label><?= $Convenio->Tipo_tel ?></label>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="label-display-name">Email:</label> 
            <label><?= $Convenio->Email ?></label>
        </div>
    </div>

    <div class="row">
        <div class="col-md-offset-4 col-sm-offset-4 col-xs-offset-2 col-md-4 col-sm-4 col-xs-8">
            <h4>Tabla de pagos</h4>
            <div class="table-responsive" style="max-height: 400px;overflow-x: hidden;">
                <table id="tblPagos" class="table table-hover table-scroll">
                    <thead class="thead-style">
                        <tr>
                            <th>Fecha</th>
                            <th>Importe</th>
                        </tr>
                    </thead>
                    <tbody class="boletos">
                    <?php
                        $Totalpago = 0;
                        foreach($Tblpagos as $Movimiento){
                            $Totalpago += $Movimiento->Importe_pago;
                    ?>
                        <tr>
                            <td><?= $Movimiento->Fecha_pago ?></td>
                            <td><?= number_format($Movimiento->Importe_pago,2) ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12 ">
            <label class="label-display-name">Total a pagar:</label> 
            <label><?= number_format($Totalpago,2) ?></label>
        </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <label class="label-display-name">Observaciones:</label> 
            <label><?= $Convenio->Observaciones ?></label>
        </div>
    </div>


     <div class="audit-fields" style="margin-top: 15px;">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <label>Creado por: <?= $Createdby ?></label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <label>Fecha de creación: <?= $Convenio->CreatedDate ?></label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <label>Modificado por: <?= $Updatedby ?></label>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <label>Fecha de modificación: <?= $Convenio->UpdatedDate ?></label>
            </div>
        </div>
    </div>
  </div>
</div>

<div class="row" style="margin-top:15px;">
    <div class="col-md-2 col-sm-3 col-xs-4">
            <a href="<?= base_url() ?>Convenios" class="btn btn-default" style="width:100%;">Volver</a>
    </div>
    <div class="col-md-offset-6 col-sm-offset-3 col-md-2 col-sm-3 col-xs-4">
        <?php if(VerificarPermisos($IdUsuario, "Convenios", "Edit") && $Convenio->Cancelado ==0){ ?>
        <a href="<?= base_url() ?>Convenios/Edit/<?= $Convenio->Id ?>" class="btn btn-primary" style="float:right;width:100%">Editar</a>
        <?php } ?>
    </div>
    <div class="col-md-2 col-sm-3 col-xs-4">
        <?php if(VerificarPermisos($IdUsuario, "Convenios", "Delete") && $Convenio->Cancelado ==0 && $Convenio->Estado_conv ==0){ ?>
        <!-- <a class="btn btn-danger" style="float:right;width:100%" data-message-delete="El covenio se cancelará, ¿Desea continuar?">Cancelar</a> -->
        <a class="btn btn-danger" style="float:right;width:100%" id="btnCancel">Cancelar</a>
        <?php } ?>
    </div>

</div>

<?= form_open_multipart('/Convenios/Delete', array("id" => "frmDelete")) ?>
    <input type="hidden" name="Idconvenio" id="Idconvenio" value="<?= $Convenio->Id ?>">
<?php echo form_close() ?>

<!-- Modal -->
<div class="modal fade" id="mAutorizacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #4d4dff;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" style="color: #FFF;">Autorización</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12">
                <label class="label-control" for="txbUsuario">Usuario:</label>
                <input type="text" id="txbUsuario" class="form-control" placeholder="Usuario" max-length="10">
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

<script>
    var vAutorizado = false;
    $(function()
    {
        $("#txbUsuario").keypress(function()
        {
            if(event.charCode == 13)
            {
                $("#txbContrasena").focus();
            }
        })

        $("#txbContrasena").keypress(function()
        {
            if(event.charCode == 13)
            {
                $("#btnAutorizar").trigger("click");
            }
        })

        $("#btnCancel").click(function()
        {
            bootbox.confirm({
                message: "El convenio se cancelara, ¿Acepta continuar?",
                callback: function(result)
                {
                    if(result)
                    {
                        $("#mAutorizacion").modal("show");
                        setTimeout(function()
                        {
                            $("#txbUsuario").focus();
                        },500)
                    }
                }
            }); 
        })

        $("#btnAutorizar").click(function()
        {
            $("p.loader-gif").text("Verificando...");
            $(".loader-gif").show();
             $.ajax({
                url: $("#url").val() + '/Users/VerificarAutorizacion/',
                dataType: "json",
                data: {
                    Usuario: $("#txbUsuario").val(),
                    Contrasena: $("#txbContrasena").val(),
                    Controlador: "Convenios",
                    Accion: "Delete"
                },
                type: "GET",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    if(data.length == 0)
                    {
                        vAutorizado = true;
                        $("#mAutorizacion").modal("hide");
                        $("#AutorizadoPor").val($("#txbUsuario").val());
                        $("#frmDelete").submit();

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

        $("#frmDelete").submit(function()
        {
            return vAutorizado;
        })

    })
</script>