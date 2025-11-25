<?php if($this->session->flashdata('message_edit')){?>
    <div class="alert alert-<?= $this->session->flashdata('class') ?> alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <?= $this->session->flashdata('message_create') ?>
    </div>
<?php } ?>
<?= form_open_multipart('/Productos/QuitasPost', array("id" => "frmEdit")) ?>

<div class="panel panel-uni">
  <div class="panel-heading">
    <h3 class="panel-title"><?= $title ?></h3>
  </div>

  <div class="panel-body">

    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <label class="control-label" for="Producto">Producto:( <?= $Producto->Numero ?> )</label>
            <input type="hidden" name="hdProducto" value="<?= $Producto->Id ?>" id="hdProducto">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <input readonly type="text" id="NombreProducto" max-length="60" value="<?= $Producto->Nombre ?>" class="form-control" placeholder="">
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top:20px;">

        <div class="table-responsive">
            <table class="table table-bordered" id="tDetalle">
                <thead>
                    <tr>
                        <th>Desde</th>
                        <th>Hasta</th>
                        <th>% Quita Sdo. Tot.</th>
                        <th>% Quita Sdo. Con.</th>
                        <th class="text-center"><span id="sAddRow" class="glyphicon glyphicon-plus" style="font-size:19px;color:#43ac6a;"></span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Valores iniciales para la tabla
                        $Index = 0;

                        // Convertimos a formato de fecha la fecha por default que viene del controlador
                        $FechaHoraOriginal = $Fecha_vig;
                        $Hora = substr($FechaHoraOriginal,11,8);
                        $Fecha_vig = substr($FechaHoraOriginal,8,2)."/".substr($FechaHoraOriginal,5,2)."/".substr($FechaHoraOriginal,0,4);

                        //
                        // Formamos la tabla con los registros del Detalles
                        //
                        foreach($Quitas as $Detalle){
                            
                            // Si hay registros cambiamos la vigencia
                            $FechaHoraOriginal = $Detalle->Vigencia;
                            $Hora = substr($FechaHoraOriginal,11,8);
                            $Fecha_vig = substr($FechaHoraOriginal,8,2)."/".substr($FechaHoraOriginal,5,2)."/".substr($FechaHoraOriginal,0,4);
                    ?>
                        <tr id="tr<?= $Index ?>" row="<?= $Index ?>" class="active">
                        <td>
                            <input type="text" name="lstDetalle[<?= $Index ?>][Desde]" class="form-control numeric-field" value="<?= $Detalle->Limite_inf ?>" row="<?= $Index ?>" max-length="10" id="lstDesde<?= $Index ?>" />
                            <input type="hidden" name="lstDetalle[<?= $Index ?>][Id]" class="form-control" value="<?= $Detalle->Id ?>" row="<?= $Index ?>" id="lstId<?= $Index ?>" />
                            <input type="hidden" name="lstDetalle[<?= $Index ?>][Active]" value="1" id="lstActive<?= $Index ?>" />
                        </td>
                        <td>
                            <input type="text" name="lstDetalle[<?= $Index ?>][Hasta]" class="form-control numeric-field" value="<?= $Detalle->Limite_sup ?>" row="<?= $Index ?>" max-length="10" id="lstHasta<?= $Index ?>" />
                        </td>
                        <td>
                            <input type="text" name="lstDetalle[<?= $Index ?>][Quita_st]" class="form-control numeric-field"  value="<?= $Detalle->Quita_st ?>" row="<?= $Index ?>" max-length="10" id="lstQuitast<?= $Index ?>" />
                        </td>
                        <td>
                            <input type="text" name="lstDetalle[<?= $Index ?>][Quita_sc]" class="form-control numeric-field"  value="<?= $Detalle->Quita_sc ?>" row="<?= $Index ?>" max-length="10" id="lstQuitasc<?= $Index ?>" />
                        </td>
                        <td align="center"><span onclick="EliminarDetalle(this)" row="<?= $Index ?>" class="glyphicon glyphicon-remove" style="font-size:19px;color:#FF0000;margin-top: 9px;"></span></td>
                        </tr>
                    <?php 
                            $Index++;
                        } 
                    ?>
                </tbody>
            </table>

            <div class="col-md-2 col-sm-2 col-xs-12 ">
                <label class="control-label" for="Nombre">Fecha vigencia::</label>
                <input type="text" name="Vigencia" id="Vigencia" value="<?= $Fecha_vig ?>"  class="form-control datetimepicker" max-length="10">
            </div>

        </div>
    
    </div>

 </div>
</div>

<div class="row" style="margin-top:15px;">
    <div class="col-md-2 col-sm-3 col-xs-6">
            <a href="<?= base_url() ?>Productos/" class="btn btn-default" style="width:100%">Volver</a>
        </div>
        <div class="col-md-offset-8 col-sm-offset-6 col-md-2 col-sm-3 col-xs-6">
            <input class="btn btn-success" id="btnSave" style="float: right;width:100%;'" type="button" value="Guardar">
        </div>
    </div>
<?= form_close() ?>

<script>

    function AsignarQuitas()
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
        })
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

                    setTimeout(function()
                    {
                        $("#tDetalle > tbody > tr:visible").last().find("input").eq(0).focus();
                    },100);
                }
            }
        }); 
    }

    $(function()
    {

        $('#iColor').on('shown.bs.modal', function () {
            //$("#tDetalles > tbody > tr").last().find("input").eq(0).focus();
            $('.datetimepicker').datepicker({
                format: "dd/mm/yyyy",
                clearBtn: true,
                language: "es",
                orientation: "bottom auto",
                autoclose: true,
                todayHighlight: true
            });
        })
        
        $('#iColor').on('hiden.bs.modal', function () {
           //ContarDetalles();
        })

        $("#sAddRow").click(function()
        {
            
            var vCount = $("#tDetalle > tbody > tr").length;

            var vNewRow = '<tr id="tr' + vCount + '" row="' + vCount + ' class="active" >\
                                <td>\
                                    <input type="text" name="lstDetalle[' + vCount + '][Desde]" class="form-control numeric-field" value="" max-length="10" id="lstDesde' + vCount + '" />\
                                    <input type="hidden" name="lstDetalle[' + vCount + '][Id]" class="form-control" value="0" id="lstId' + vCount + '" />\
                                    <input type="hidden" name="lstDetalle[' + vCount + '][Active]" class="form-control" value="1" id="lstActive' + vCount + '" />\
                                </td>\
                                <td>\
                                    <input type="text" name="lstDetalle[' + vCount + '][Hasta]" class="form-control numeric-field" row="' + vCount + '" max-length="10" id="lstHasta' + vCount + '" />\
                                </td>\
                                <td>\
                                    <input type="text" name="lstDetalle[' + vCount + '][Quita_st]" class="form-control numeric-field" row="' + vCount + '" max-length="10" id="lstQuitast' + vCount + '" />\
                                </td>\
                                <td>\
                                    <input type="text" name="lstDetalle[' + vCount + '][Quita_sc]" class="form-control numeric-field" row="' + vCount + '" max-length="10" id="lstQuitasc' + vCount + '" />\
                                </td>\
                                <td align="center"><span onclick="EliminarDetalle(this)" row="' + vCount + '" class="glyphicon glyphicon-remove" style="font-size:19px;color:red;margin-top: 9px;"></span></td>\
                            </tr>';

            $("#tDetalle > tbody").append(vNewRow);
            $("#tDetalle > tbody > tr").last().find("input").eq(0).focus();
            AsignarQuitas();
        })

        $(".required-field").change(function()
        {
            if($(this).val() != ""){
                $(this).parent().removeClass("has-error");
                $(this).next().hide();
            }
            if($(this).val() == "" && $("#hdTriedSave").val() == "true"){
                $(this).parent().addClass("has-error");
                $(this).next().show();
            }
        })

        $("#btnSave").click(function()
        {
            $("#frmEdit").submit();
        })

        $("#frmEdit").submit(function()
        {
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

            if(!vSubmit)
            {
                bootbox.alert("Llene todos los campos obligatorios de la tabla y/o formulario para guardar");
            }
            if($("#tDetalle > tbody > tr").length == 0 && vSubmit)
            {
                bootbox.alert("Tiene que agregar al menos una Quita para guardar.");
                vSubmit = false;
            }

            if(vSubmit)
            {
                $("p.loader-gif").text("Guardando...");
                $(".loader-gif").show();
            }
            return vSubmit;
        })
    })
</script>
