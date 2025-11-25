<?php if($this->session->flashdata('message_create')){?>
    <div class="alert alert-<?= $this->session->flashdata('class') ?> alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <?= $this->session->flashdata('message_create') ?>
    </div>
<?php } ?>
<?= form_open_multipart('/Users/CreatePost', array("id" => "frmCreate")) ?>

<div class="panel panel-uni">
  <div class="panel-heading">
    <h3 class="panel-title">Crear usuario</h3>
  </div>
  <div class="panel-body">
    <div class="row">
        <div class="col-md-3 col-sm-4 col-xs-12">
            <label class="control-label" for="Name">Nombre:</label>
            <?php echo form_input(array('value' => set_value("Name"), 'name' => 'Name','placeholder' => 'Nombre','id' => 'Name', 'class' => 'form-control required-field', "max-length" => "50")) ?>
            <label class="control-label" style="display:none;">Este campo es obligatorio</label>
        </div>

        <div class="col-md-3 col-sm-4 col-xs-12">
            <label class="control-label" for="UID">Usuario:</label>
            <?php echo form_input(array('value' => set_value("UID"), 'name' => 'UID','placeholder' => 'Usuario','id' => 'UID', 'class' => 'form-control required-field fill', "max-length" => "10")) ?>
            <label class="control-label" style="display:none;">Este campo es obligatorio</label>
        </div>

        <div class="col-md-3 col-sm-4 col-xs-12">
            <label class="control-label" for="PWD">Contraseña:</label>
            <?php echo form_password(array('name' => 'PWD','placeholder' => 'Contraseña','id' => 'PWD', 'class' => 'form-control required-field', "max-length" => "50")) ?>
            <label class="control-label" style="display:none;">Este campo es obligatorio</label>
        </div>

        <div class="col-md-3 col-sm-4 col-xs-12">
            <label class="control-label" for="RepeatPassword">Repetir contraseña:</label>
            <?php echo form_password(array('name' => 'RepeatPassword','placeholder' => 'Repetir contraseña','id' => 'RepeatPassword', 'class' => 'form-control required-field', "max-length" => "50")) ?>
            <label class="control-label" style="display:none;">Las contraseñas no coinciden</label>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <label class="control-label" for="email">E-mail:</label>
            <?php echo form_input(array('value' => set_value("email"), 'name' => 'email','placeholder' => 'email','id' => 'email', 'class' => 'form-control required-field', "max-length" => "100")) ?>
            <label class="control-label" style="display:none;">Este campo es obligatorio</label>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
            <label class="control-label" for="txbClavenivel">Nivel:</label>
             <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <input type="text" id="txbClavenivel" max-length="1" value="<?= set_value("Clavenivel") ?>" class="form-control" placeholder="Clave">
                </div>
                <div class="col-md-8 col-sm-8 col-xs-8">
                    <?php
                        $Options = array(
                            "" => "Seleccionar opción"
                        );
                        foreach($Niveles as $Nivel)
                        {
                            $Options[$Nivel->id] = $Nivel->nombre;
                        }
                    ?>
                    <?= form_dropdown(array('name' => 'Clavenivel','id' => 'Clavenivel', 'class' => 'form-control required-field'),$Options, set_value("Clavenivel")) ?>
                </div>
            </div>
            <label class="control-label" style="display:none;">Este campo es obligatorio</label>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12 col-ms-12 col-xs-12">
            <div class="col-md-12 col-ms-12 col-xs-12">
                <h4>Asignar permisos</h1>
            </div>
            <div class="col-md-12 col-ms-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table" style="font-size: 17px;font-weight: bolder;">
                        <thead>
                            <th>Modulo</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <?php
                                foreach($Permisos as $Item)
                                {
                            ?>
                                    <tr>
                                        <td><label class="label label-warning agregar-todos" style="cursor: pointer;"><?= $Item->Grupo->Nombre ?></label></td>
                                    </tr>
                            <?php
                                    foreach($Item->Modulos as $Modulo)
                                    {
                            ?>
                                    <tr>
                                    <td></td>
                                        <td>
                                            <label class="label label-default agregar-todos-modulo" style="cursor: pointer;"><?= $Modulo->Modulo->Nombre ?></label>
                                        </td>
                            <?php
                                        foreach($Modulo->Opciones as $Item2)
                                        {
                                            $Asignado = false;
                                            if(is_array(set_value("lstPermisos")))
                                            {
                                                $PermisosUsuario = set_value("lstPermisos");
                                                foreach($PermisosUsuario as $Item3)
                                                {
                                                    if($Item3["IdPermiso"] == $Item2->Id)
                                                    {
                                                        $Asignado = true;
                                                    }
                                                }
                                            }
                                            $ClaseSpan = $Asignado ? "glyphicon-ok" : "glyphicon-remove";
                                            $ClaseAgregado = $Asignado ? "agregado" :  "";
                                            $ClaseLabel = $Asignado ? "label-success" : "label-danger";
                            ?>
                                        <td><label class="label <?= $ClaseLabel ?> agregar-permiso <?= $ClaseAgregado ?> <?= str_replace(" ", "-", $Item->Nombre) ?> <?= str_replace(" ", "-", $Modulo->Modulo->Nombre) ?>" id-permiso="<?= $Item2->Id ?>" style="cursor: pointer;"><?= $Item2->Nombre ?> <span class="glyphicon <?= $ClaseSpan ?>"></span></label></td>
                            <?php
                                        }
                                    }
                                ?>
                                    </tr>  
                                <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
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

    <div id="PermisosUsuario">
        
    </div>
<?= form_close() ?>


<script>

    function SelectNivel()
    {
        var vFound = false;
        $("#Clavenivel option").each(function()
        {
            if($(this).val() == $("#txbClavenivel").val())
            {
                $(this).prop("selected", true);
                $("#Clavenivel").parent().parent().parent().removeClass("has-error");
                $("#Clavenivel").parent().removeClass("has-error");
                $("#Clavenivel").parent().parent().next().hide();
                vFound = true;
            }
        })

        if(!vFound)
        {
            $("#Clavenivel").val("");
        }
    }

    $(function()
    {
        $("#txbClavenivel").keypress(function(event)
        {
            if(event.charCode == 13)
            {
                SelectNivel();
            }
        })

        $("#txbClavenivel").change(function()
        {
            SelectNivel();
        })

        $("#Clavenivel").change(function()
        {
            $("#txbClavenivel").val($(this).val());
        })
//        
        $(".agregar-todos").click(function()
        {
            var vClase = $(this).text().replace(/\ /g, "-");
            if($("." + vClase).hasClass("agregado"))
            {
                $("." + vClase).each(function()
                {
                    $(this).find("span").addClass("glyphicon-remove").removeClass("glyphicon-ok");
                    $(this).removeClass("agregado");
                    $(this).addClass("label-danger").removeClass("label-success")
                })
            }else
            {
                $("." + vClase).each(function()
                {
                    $(this).find("span").addClass("glyphicon-ok").removeClass("glyphicon-remove");
                    $(this).addClass("agregado");
                    $(this).addClass("label-success").removeClass("label-danger")
                })
            }
        })

        $(".agregar-todos-modulo").click(function()
        {
            var vClase = $(this).text().replace(/\ /g, "-");
            if($("." + vClase).hasClass("agregado"))
            {
                $("." + vClase).each(function()
                {
                    $(this).find("span").addClass("glyphicon-remove").removeClass("glyphicon-ok");
                    $(this).removeClass("agregado");
                    $(this).addClass("label-danger").removeClass("label-success")
                })
            }else
            {
                $("." + vClase).each(function()
                {
                    $(this).find("span").addClass("glyphicon-ok").removeClass("glyphicon-remove");
                    $(this).addClass("agregado");
                    $(this).addClass("label-success").removeClass("label-danger")
                })
            }
        })

        $(".agregar-permiso").click(function(){
            if($(this).find("span").hasClass("glyphicon-remove"))
            {
                $(this).find("span").addClass("glyphicon-ok").removeClass("glyphicon-remove");
                $(this).addClass("agregado");
                $(this).addClass("label-success").removeClass("label-danger")
            }else
            {
                $(this).find("span").addClass("glyphicon-remove").removeClass("glyphicon-ok");
                $(this).removeClass("agregado");
                $(this).addClass("label-danger").removeClass("label-success")
            }
        })

        $("#RepeatPassword").change(function()
        {
            if($("#hdTriedSave").val() == "true")
            {
                if($("#PWD").val().trim().length > 0 && $("#RepeatPassword").val().trim().length > 0){
                if($("#PWD").val() == $("#RepeatPassword").val())
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

        $("#frmCreate").submit(function()
        {
            $("#hdTriedSave").val("true");
            var vSubmit = true;
            if($("#Name").val().trim().length == 0){
                vSubmit = false;
                $("#Name").parent().addClass("has-error");
                $("#Name").next().show();
            }

            if($("#UID").val().trim().length == 0){
                vSubmit = false;
                $("#UID").parent().addClass("has-error");
                $("#UID").next().show();
            }

            if($("#PWD").val().trim().length == 0){
                vSubmit = false;
                $("#PWD").parent().addClass("has-error");
                $("#PWD").next().show();
            }

            if($("#PWD").val().trim().length > 0 && $("#RepeatPassword").val().trim().length > 0){
                if($("#PWD").val() != $("#RepeatPassword").val())
                {
                    vSubmit = false;
                    $("#RepeatPassword").parent().addClass("has-error");
                    $("#RepeatPassword").next().show();
                }
            }else{
                vSubmit = false;
            }
            if(vSubmit)    
            {
                $("#PermisosUsuario").html("");
                $(".agregado").each(function(index, element)
                {
                    var vInput = '<input type="hidden" name="lstPermisos[' + index + '][IdPermiso]" value="' + $(this).attr("id-permiso") + '">';
                    $("#PermisosUsuario").append(vInput);
                })
                $(".loader-gif").show();
            }
            return vSubmit;
        })
    })
</script>