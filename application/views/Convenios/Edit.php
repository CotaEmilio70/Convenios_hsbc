<?php if($this->session->flashdata('message_edit')){?>
    <div class="alert alert-<?= $this->session->flashdata('class') ?> alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <?= $this->session->flashdata('message_edit') ?>
    </div>
<?php } ?>
<?= form_open_multipart('/Convenios/EditPost', array("id" => "frmEdit")) ?>

<?php
    $FechaHoraOriginal = $Convenio->Fecha_neg;
    $Formatofechaneg = substr($FechaHoraOriginal,8,2)."/".substr($FechaHoraOriginal,5,2)."/".substr($FechaHoraOriginal,0,4);

    $Convenio->Nombre = set_value("Nombre") != "" ? set_value("Nombre") : $Convenio->Nombre;
?>

<input type="hidden" name="Idconvenio" id="Idconvenio" value="<?= $Convenio->Id ?>">
<div class="panel panel-uni">
  <div class="panel-heading">
    <h3 class="panel-title">Editar convenio</h3>
  </div>
  <div class="panel-body">

    <div class="row">
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="control-label" for="Cuenta">Cuenta:</label>
            <input readonly type="text" autofocus name="Cuenta" id="Cuenta" value="<?= $Convenio->Cuenta_12d ?>" placeholder="Cuenta" class="form-control input-sm required-field fill" max-length="12">
            <label class="control-label" style="display:none;">Este campo es obligatorio</label>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <label class="control-label" for="Nombre">Nombre:</label>
            <input readonly type="text" name="Nombre" id="Nombre" value="<?= $Convenio->Nombre ?>" placeholder="Nombre" class="form-control input-sm" max-length="100">
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <label class="control-label" for="Nombre">Calle y num:</label>
            <input readonly type="text" name="Calle_num" id="Calle_num" value="<?= $Convenio->Calle_num ?>" placeholder="Calle y num" class="form-control input-sm" max-length="100">
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <label class="control-label" for="Nombre">Colonia:</label>
            <input readonly type="text" name="Colonia" id="Colonia" value="<?= $Convenio->Colonia ?>" placeholder="Colonia" class="form-control input-sm" max-length="100">
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <label class="control-label" for="Nombre">Ciudad:</label>
            <input readonly type="text" name="Ciudad" id="Ciudad" value="<?= $Convenio->Ciudad ?>" placeholder="Ciudad" class="form-control input-sm" max-length="100">
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <label class="control-label" for="Nombre">Estado:</label>
            <input readonly type="text" name="Estado" id="Estado" value="<?= $Convenio->Estado ?>" placeholder="Estado" class="form-control input-sm" edtclass="todo" onkeyup = "Editvalue(event,this)" max-length="100">
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-12">
            <label class="control-label" for="Nombre">PAN:</label>
            <input readonly type="text" name="Cuenta_pan" id="Cuenta_pan" value="<?= $Convenio->Cuenta_pan ?>" placeholder="PAN" class="form-control input-sm required-field" edtclass="solo-numeros" onkeyup = "Editvalue(event,this)" max-length="20">
        </div>
        <div class="col-md-1 col-sm-1 col-xs-12">
            <label class="control-label" for="Nombre">C.P.:</label>
            <input readonly type="text" name="Cp" id="Cp" value="<?= $Convenio->Cp ?>" placeholder="C.P." class="form-control input-sm" max-length="5">
        </div>
        <div class="col-md-1 col-sm-1 col-xs-12">
            <label class="control-label" for="Nombre">Suc:</label>
            <input readonly type="text" name="Sucursal" id="Sucursal" value="<?= $Convenio->Sucursal ?>" placeholder="Suc." class="form-control input-sm fill" max-length="4">
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="control-label" for="Nombre">Segmento:</label>
            <input readonly type="text" name="Segmento" id="Segmento" value="<?= $Convenio->Segmento ?>" placeholder="Seg." class="form-control input-sm" onkeyup = "Editvalue(event,this)" max-length="20">
        </div>
        <div class="col-md-1 col-sm-2 col-xs-12">
            <label class="control-label" for="Nombre">Q. max.:</label>
            <input readonly type="text" name="Quita" id="Quita" value="<?= $Convenio->Quitamax ?>" placeholder="Quita" class="form-control input-sm" onkeyup = "Editvalue(event,this)" max-length="5">
        </div>
        <div class="col-md-1 col-sm-1 col-xs-12">
            <label class="control-label" for="Nombre">Cliente:</label>
            <input readonly type="text" name="Cliente" id="Cliente" value="<?= $Convenio->Cliente ?>" placeholder="Cliente" class="form-control input-sm" max-length="3">
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="control-label" for="Nombre">Saldo actual:</label>
            <input readonly type="text" name="Saldo_act" id="Saldo_act" value="<?= $Convenio->Saldo_act ?>" placeholder="Saldo actual" class="form-control input-sm text-right" max-length="12">
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="control-label" for="Nombre">Capital:</label>
            <input readonly type="text" name="Saldo_cap" id="Saldo_cap" value="<?= $Convenio->Saldo_cap ?>" placeholder="Capital" class="form-control input-sm text-right" edtclass="importe" onkeyup = "Editvalue(event,this)" max-length="12">
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="control-label" for="Nombre">Intereses:</label>
            <input readonly type="text" name="Intereses" id="Intereses" value="<?= $Convenio->Intereses ?>" placeholder="Intereses" class="form-control input-sm text-right" max-length="12">
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="control-label" for="Nombre">Comisiones:</label>
            <input readonly type="text" name="Comisiones" id="Comisiones" value="<?= $Convenio->Comisiones ?>" placeholder="Comisiones" class="form-control input-sm text-right" max-length="12">
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12 ">
            <label class="control-label" for="Nombre">Impuestos:</label>
            <input readonly type="text" name="Impuestos" id="Impuestos" value="<?= $Convenio->Impuestos ?>" placeholder="Impuestos" class="form-control input-sm text-right" max-length="12">
        </div>
    </div>

    <div class="row margin-top" style="margin-top:20px;">
        <div class="col-md-2 col-sm-2 col-xs-12 ">
            <label class="control-label" for="Nombre">Fecha neg::</label>
            <input type="text" name="Fecha_neg" id="Fecha_neg" value="<?= $Formatofechaneg ?>" placeholder="Fecha neg." class="form-control input-sm datetimepicker" max-length="10">
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12 table-responsive">
            <table class="table table-bordered table-condensed" id="tDetalle">
                <thead>
                    <tr>
                        <th>Fecha pago</th>
                        <th>Importe</th>
                        <th class="text-center"><span id="sAddRow" class="glyphicon glyphicon-plus" style="font-size:19px;color:#43ac6a;"></span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $Index = 0;
                        foreach($Tblpagos as $Movimiento){
                            $FechaHoraOriginal = $Movimiento->Fecha_pago;
                            $Formatofechapag = substr($FechaHoraOriginal,8,2)."/".substr($FechaHoraOriginal,5,2)."/".substr($FechaHoraOriginal,0,4);
                    ?>
                        <tr id="tr<?= $Index ?>" row="<?= $Index ?>" class="active">
                            <td>
                                <input onchange="ValidateDate(this);" type="text" name="lstDetalle[<?= $Index ?>][Fecha]" value="<?= $Formatofechapag ?>" class="form-control input-sm datetimepicker" row="<?= $Index ?>" placeholder="Fecha"  onkeypress="ChangeToPago(this);" id="lstFecha<?= $Index ?>" />
                                <input type="hidden" name="lstDetalle[<?= $Index ?>][Active]" row="<?= $Index ?>" value="true" id="lstActive<?= $Index ?>" />
                            </td>
                            <td>
                                <input onchange="AddNewRow(this);" type="text" name="lstDetalle[<?= $Index ?>][Pago]" value="<?= $Movimiento->Importe_pago ?>" class="form-control numeric-field input-sm text-right" row="<?= $Index ?>" max-length="10"  placeholder="Pago" id="lstPago<?= $Index ?>" />
                            </td>
                            <td align="center"><span onclick="EliminarDetalle(this)" row="<?= $Index ?>" class="glyphicon glyphicon-remove" style="font-size:19px;color:red;margin-top: 9px;"></span></td>
                        </tr>
                    <?php 

                        $Index++;
                        } 
                    ?>                        
                </tbody>
            </table>
        </div>

        <div class="col-md-2 col-sm-2 col-xs-12 ">
            <label class="control-label" for="Nombre">Total a pagar:</label>
            <input readonly type="text" name="Totalpago" id="Totalpago"  value="0" placeholder="Total" class="form-control input-sm text-right" max-length="12">
        </div>

    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <label class="label-control">Observaciones:</label>
         </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <textarea class="form-control" rows="3" name="Observaciones" id="Observaciones" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Observaciones" max-length="250"><?= $Convenio->Observaciones ?></textarea>
            </div>
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
        <div class="col-md-2 col-sm-3 col-xs-6">
            <a href="<?= base_url() ?>Convenios" class="btn btn-default" style="width:100%;">Volver</a>
        </div>
        <div class="col-md-offset-8 col-sm-offset-6 col-md-2 col-sm-3 col-xs-6">
            <input class="btn btn-success" id="btnSave" style="float: right;width:100%;'" type="button" value="Guardar">
        </div>
    </div>

<!-- Ventana modal para edicion de datos-->

<div class="modal fade" id="mEditarvalor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #4d4dff;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" style="color: #FFF;">Editar datos</h4>
      </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-10 col-sm-10 col-xs-12">
                    <label class="label-control">Ingrese el nuevo dato:</label>
                    <input type="text" id="Nuevodato" class="form-control">
                    <input type="hidden" id="Itemid">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <label class="label-control" for="txbUsuario">Usuario:</label>
                    <input type="text" id="txbUsuario" class="form-control" placeholder="Usuario" max-length="10">
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <label class="label-control" for="txbContrasena">Contraseña:</label>
                    <input type="password" id="txbContrasena" class="form-control" placeholder="Contraseña">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="btnRegresar">Regresar</button>
                <button type="button" class="btn btn-primary" id="btnAutorizar">Autorizar</button>
            </div>
        </div>
    </div>
  </div>
</div>

<?php echo form_close() ?>

<script>

    window.onload=CargarFunciones();

    function CargarFunciones() {
        AsignarFunciones();
        ContarDetalles();
    }    

    function AsignarClasesEdit()
    {

        $(".importe").keypress(function(event){
            if($(this).val() == "" && event.charCode == 46){
                return false;
            }
            if($(this).val().split('.').length >= 2 && event.charCode == 46 ){
                return false;
            }
            return event.charCode >= 48 && event.charCode <=57 || event.charCode == 46 || event.charCode == 13;
        })
        $(".solo-numeros").keypress(function(event){
            return event.charCode >= 48 && event.charCode <=57 || event.charCode == 13;
        })

        $(".todo").keypress(function(event){
            return event.charCode >= 3 && event.charCode <=255;
        })

    }

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

    function addCommas(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    function Editvalue(e,vElement) { 
      tecla = document.all ? e.keyCode : e.which; 
      if(tecla==113){
        $("#Nuevodato").val("");

        $("#Nuevodato").removeClass("importe");
        $("#Nuevodato").removeClass("solo-numeros");
        $("#Nuevodato").removeClass("todo");
        $("#Nuevodato").off("keypress");

        vEdtclass = $(vElement).attr("edtclass");
        $("#Nuevodato").addClass(vEdtclass);
        AsignarClasesEdit(); 

        $("#txbUsuario").val("");
        $("#txbContrasena").val("");        
        $("#mEditarvalor").modal("show");
        setTimeout(function()
        {
            vItemid = "#"+$(vElement).attr("id");
            $("#Itemid").val($(vElement).attr("id"));
            $("#Nuevodato").val( $(vItemid).val() );
            $("#Nuevodato").focus();
        },500)

      }  
    } 

    function ValidateDate(vElement)
    {
        // bootbox.alert("Si entro al validate.");

        var vFechaneg = $("#Fecha_neg").val();
        var vFechapago = $(vElement).val();
        var vRow = $(vElement).attr("row");

        $("p.loader-gif").text("Verificando...");
        $(".loader-gif").show();

        $.ajax({
            url: $("#url").val() + '/Convenios/ValidaFecha/',
            dataType: "json",
            data: {
                Fechaneg: vFechaneg,
                Fechapago: vFechapago,
                Row: vRow
            },
            type: "GET",
            contentType: 'text/json',
            success: function (data) {

                if(data != null && data.errormsg !='')
                {
                    $(".loader-gif").hide();
                    bootbox.alert({
                        message: data.errormsg,
                        callback: function () {
                            setTimeout(function()
                            {
                                $(vElement).val("").focus().select();
                            },100)
                        }
                    })  
                }

                $(".loader-gif").hide();
                
            },

            error: function (error) {
                bootbox.alert(error.responseText);
            }

        });

    }


    function AddNewRow(vElement)
    {
        var vRow = $(vElement).attr("row");
        $("#tr" + vRow).addClass("active");

        var vTotalRegistros = 0;

        // $("#tDetalle > tbody > tr.active").each(function()
        // {
        //     var vRow = $(this).attr("row");
        //     var vActive = $("#lstActive" + vRow).val();
        //     if(vActive == "true")
        //     {
        //         vTotalRegistros++;
        //     }
        // })

        $("#tDetalle > tbody > tr:visible").each(function()
        {
            vTotalRegistros++;
        })

        if(vTotalRegistros <3){
            var vAddRow = true;
        }else{
            var vAddRow = false;
        }

        var vRowActual = $(vElement).attr("row");
        var vUltimoRow = $("#tDetalle > tbody > tr:visible").last().attr("row");

        if(vRowActual == vUltimoRow && vAddRow)
        {
            // var vRow = $(vElement).attr("row");
            // $("#tr" + vRow).addClass("active");

            var vCount = $("#tDetalle > tbody > tr").length;

            var vNewRow = '<tr id="tr' + vCount + '" row="' + vCount + '"  >\
                                <td>\
                                    <input onchange="ValidateDate(this);" type="text" name="lstDetalle[' + vCount + '][Fecha]" class="form-control input-sm datetimepicker" row="' + vCount + '" placeholder="Fecha"  onkeypress="ChangeToPago(this);" id="lstFecha' + vCount + '" />\
                                    <input type="hidden" name="lstDetalle[' + vCount + '][Active]" value="true" id="lstActive' + vCount + '" />\
                                </td>\
                                <td>\
                                    <input onchange="AddNewRow(this);" type="text" name="lstDetalle[' + vCount + '][Pago]" value="0" class="form-control numeric-field input-sm text-right" row="' + vCount + '" max-length="10" placeholder="Pago" id="lstPago' + vCount + '" />\
                                </td>\
                                <td align="center"><span onclick="EliminarDetalle(this)" row="' + vCount + '" class="glyphicon glyphicon-remove" style="font-size:19px;color:red;margin-top: 9px;"></span></td>\
                            </tr>';

            $("#tDetalle > tbody").append(vNewRow);
            $("#tDetalle > tbody > tr:visible").last().find("input").eq(0).focus();
            AsignarFunciones();
            ContarDetalles();

        }else if(vAddRow)
        {
            $("#tDetalle > tbody > tr:visible").last().find("input").eq(0).focus();
        }
        ContarDetalles();
    }

    function ContarDetalles()
    {
        var vTotalRegistros = 0;
        var vTotalPago = 0;

        $("#tDetalle > tbody > tr.active").each(function()
        {
            var vRow = $(this).attr("row");
            var vActive = $("#lstActive" + vRow).val();
            if(vActive == "true")
            {
                vTotalRegistros++;
                var vCantidad = parseFloat($("#lstPago" + vRow).val());
                vTotalPago += parseFloat(vCantidad);
            }
        })
        // vTotalRegistros = vTotalRegistros == 0 ? "" : vTotalRegistros;
        vTotalPago = vTotalPago == 0 ? "" : vTotalPago;
        // $("#txbTotalRegistros").val(vTotalRegistros);
        $("#Totalpago").val(addCommas(vTotalPago.toFixed(2)));
    }

    function EliminarDetalle(vElement)
    {
        bootbox.confirm({
            message: "El registro quedara eliminado, ¿Desea continuar?",
            callback: function(result)
            {
                if(result)
                {
                    var vRow = $(vElement).attr("row");

                    $("#tr" + vRow).removeClass("active").hide();
                    $("#lstActive"+vRow).val("0");

                    ContarDetalles();
                    setTimeout(function()
                    {
                        $("#tDetalle > tbody > tr:visible").last().find("input").eq(0).focus();
                    },100);
                }
            }
        }); 
    }

    function ChangeToPago(vElement)
    {
        if(event.charCode == 13 && $(vElement).val() != "")
        // if(event.charCode == 13 || event.charCode == 9)
        {
            var vRow = $(vElement).attr("row");
            $("#lstPago" + vRow).focus().select();

            // $(vElement).trigger("blur");
        }
    }

    $(function()
    {
        $("#Cuenta").change(function()
        {
            var vCuenta = $(this).val();

            $("p.loader-gif").text("Verificando...");
            $(".loader-gif").show();
            $.ajax({
                url: $("#url").val() + '/Convenios/Consultarcuenta/',
                dataType: "json",
                data: {
                    Cuenta: vCuenta,
                },
                type: "GET",
                // contentType: 'application/json; charset=utf-8',
                contentType: 'text/json',
                success: function (data) {
                    // if(data == null)
                    // {
                    //     $(this).val("");
                    //     $(".loader-gif").hide();
                    //     bootbox.alert({
                    //         message: "No se encontró la cuenta o esta inactiva.",
                    //         callback: function () {
                    //             setTimeout(function()
                    //             {

                    //             },100)
                    //         }
                    //     })
                    // }

                    if(data != null && data.errormsg !='')
                    {
                        $("#Cuenta").val("");
                        $(".loader-gif").hide();
                        bootbox.alert({
                            message: data.errormsg,
                            callback: function () {
                                setTimeout(function()
                                {
                                    $("#Cuenta").val("").focus().select();
                                },100)
                            }
                        })                        
                    }

                    if(data != null && data.errormsg =='')
                    {
                        // console.log(data);
                        var vSegmento = data.supervisionn;
                        if(vSegmento != null){
                            vSegmento = vSegmento.substr(0,20);
                            // console.log(vSegmento);
                        }

                        $("#Nombre").val(data.first);
                        $("#Calle_num").val(data.home_street);
                        $("#Ciudad").val(data.home_city);
                        $("#Colonia").val(data.col_casa);
                        $("#Cp").val(data.home_postal_code);
                        $("#Sucursal").val(data.idcuenta);
                        $("#Segmento").val(vSegmento);
                        $("#Quita").val(data.quita);
                        $("#Cliente").val(data.cliente);
                        $("#Cuenta_pan").val(data.cuenta_pan);

                        $("#Saldo_act").val( addCommas(data.saldo_total) );
                        $("#Saldo_cap").val( addCommas(data.saldo_cap) );
                        $("#Intereses").val( addCommas(data.intereses) );
                        $("#Comisiones").val( addCommas(data.comisiones) );
                        $("#Impuestos").val( addCommas(data.impuestos) );

                        // $("#Saldo_act").val(data.saldo_total);

                        $("#Status").html('<h4 id="Status">'+data.status+'</h4>');
                        $(".loader-gif").hide();
                    }
                },
                error: function (error) {
                    bootbox.alert(error.responseText);
                }
            });
        })

//
        $("#Fecha_neg").change(function()
        {
            var vFechaneg = $(this).val();

            $("p.loader-gif").text("Verificando...");
            $(".loader-gif").show();
            $.ajax({
                url: $("#url").val() + '/Convenios/Fechaneg/',
                dataType: "json",
                data: {
                    Fechaneg: vFechaneg,
                },
                type: "GET",
                contentType: 'text/json',
                success: function (data) {

                    if(data != null && data.errormsg !='')
                    {
                        // $("#Cuenta").val("");
                        $(".loader-gif").hide();

                        bootbox.alert({
                            message: data.errormsg,
                            callback: function () {
                                setTimeout(function()
                                {
                                    $("#Fecha_neg").val("").focus().select();
                                },100)
                            }
                        })                        
                    }

                    $(".loader-gif").hide();
                },
                error: function (error) {
                    bootbox.alert(error.responseText);
                }
            });
        })
//
        $("#Cuenta").keypress(function()
        {
            if(event.charCode == 13)
            {
                $(this).trigger("blur");
            }
        })

        $("#sAddRow").click(function()
        {
            var vTotalRegistros = 0;

            // $("#tDetalle > tbody > tr.active").each(function()
            // {
            //     var vRow = $(this).attr("row");
            //     var vActive = $("#lstActive" + vRow).val();
            //     if(vActive == "true")
            //     {
            //         vTotalRegistros++;
            //     }
            // })

            $("#tDetalle > tbody > tr:visible").each(function()
            {
                vTotalRegistros++;
            })

            if(vTotalRegistros <3){
                var vAddRow = true;
            }else{
                var vAddRow = false;
            }

            var vCount = $("#tDetalle > tbody > tr").length;
            if(vAddRow)
            {
                var vNewRow = '<tr id="tr' + vCount + '" row="' + vCount + '" >\
                                    <td>\
                                        <input onchange="ValidateDate(this);" type="text" name="lstDetalle[' + vCount + '][Fecha]" class="form-control input-sm datetimepicker" row="' + vCount + '" placeholder="Fecha"  onkeypress="ChangeToPago(this);" id="lstFecha' + vCount + '" />\
                                        <input type="hidden" name="lstDetalle[' + vCount + '][Active]" value="true" id="lstActive' + vCount + '" />\
                                    </td>\
                                    <td>\
                                        <input onchange="AddNewRow(this);" type="text" name="lstDetalle[' + vCount + '][Pago]" value="0" class="form-control numeric-field input-sm text-right" row="' + vCount + '" max-length="10" placeholder="Pago" id="lstPago' + vCount + '" />\
                                    </td>\
                                    <td align="center"><span onclick="EliminarDetalle(this)" row="' + vCount + '" class="glyphicon glyphicon-remove" style="font-size:19px;color:red;margin-top: 9px;"></span></td>\
                                </tr>';

                $("#tDetalle > tbody").append(vNewRow);
                $("#tDetalle > tbody > tr").last().find("input").eq(1).focus();
                AsignarFunciones();
                ContarDetalles();
            }
        })

        $("#btnRegresar").click(function()
        {
            var vItemid = "#"+$("#Itemid").val();
            $(vItemid).focus();
        })

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
                        $(".loader-gif").hide();
                        vAutorizado = true;
                        $("#mEditarvalor").modal("hide");
                        var vItemid = "#"+$("#Itemid").val();
                        $(vItemid).val($("#Nuevodato").val());
                        $(vItemid).trigger("change");
                        $(vItemid).focus();
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

        $("#btnSave").click(function()
        {            
            $("#frmEdit").submit();
        })

        $("#frmEdit").submit(function()
        {
            $("#hdTriedSave").val("true");
            var vSubmit = true;
            var vCapital_sc = $("#Saldo_cap").val().replace(/,/g, "");
            var vCapital = parseFloat(vCapital_sc);

            var vQuitamax = parseFloat($("#Quita").val());

            var vImpuestos_sc = $("#Impuestos").val().replace(/,/g, "");
            var vImpuestos = parseFloat(vImpuestos_sc);

            var vPagototal_sc = $("#Totalpago").val().replace(/,/g, "");
            var vPagototal = parseFloat(vPagototal_sc);

            var vPorpagocap = 100-vQuitamax;
            var vPagocap = vCapital*(vPorpagocap/100);
            var vPagominimo = vPagocap + vImpuestos;
            vPagominimo = vPagominimo.toFixed(2);

            // bootbox.alert("Resta: "+ (vPagominimo-vPagototal) ) ;
            // vSubmit = false;


            $(".required-field").each(function()
            {
                if($(this).val().trim().length == 0)
                {
                    vSubmit = false;
                    $(this).parent().addClass("has-error");
                    $(this).next().show();
                }
            })


            $("#tDetalle > tbody > tr.active").each(function()
            {
                var vRow = $(this).attr("row");
                var vFecha = $("#lstFecha" + vRow).val();
                var vPago = parseFloat($("#lstPago" + vRow).val());

                if( vFecha.length == 0 || vPago == 0 || isNaN(vPago) )
                {
                    vSubmit = false;
                }

                if(vFecha.length == 0 && vPago == 0 )
                {
                    $("#lstActive"+vRow).val(false);
                }

            })

            if(!vSubmit)
            {
                bootbox.alert("Hay informacion incompleta en la tabla de pagos o en el formulario, revise por favor");
            }

            if($("#Cuenta_pan").val().trim().length < 16)
            {
                bootbox.alert("El dato del PAN debe contener 16 numeros.");
                vSubmit = false;
            }

            if(vPagominimo > vPagototal)
            {
                bootbox.alert("El pago con quita maxima no debe ser inferior a: "+vPagominimo);
                vSubmit = false;
            }

            if($("#tDetalle > tbody > tr.active").length == 0 && vSubmit)
            {
                bootbox.alert("Tiene que agregar al menos un pago para guardar.");
                vSubmit = false;
            }

            if(vSubmit)
                $(".loader-gif").show();
            return vSubmit;
        })
    })
</script>