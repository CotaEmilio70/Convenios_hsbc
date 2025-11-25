<div class="row">
    <div class="col-md-7">
        <h2>Módulo de generación de convenios.</h2>
        <h3>Inicio de sesión.</h3>
        <?php if($this->session->flashdata('error')){?>
            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php } ?>
        <?= form_open_multipart('/Users/LogIn', array("id" => "frmLogin")) ?>
        <div class="form-group">
            Usuario:
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <input type="text" id="UserName" autofocus max-length="10" value="<?= set_value("UserName") ?>" name="UserName" class="form-control keyup" placeholder="Clave">
                </div>
            </div>
        </div>

        <div class="form-group">
            Contraseña:
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <input type="password" id="Password" name="Password" class="form-control keyup" placeholder="Contrase&ntilde;a">
                </div>
            </div>
        </div>

        <p class="form-group">
            <input class="btn btn-primary btnLogin" type="button" value="Iniciar sesión">
        </p>
         <?php echo form_close() ?>
    </div>
</div>
<input type="hidden" id="url" value="<?php echo base_url(); ?>">
</div>
<script>

    $(function()
    {
        $(".btnLogin").click(function()
        {
            $("#frmLogin").submit();
        })
        $("#Password").keypress(function()
        {
            if(event.charCode == 13)
            {
                $("#frmLogin").submit();
            }
        })
        $("#frmLogin").submit(function()
        {
            if($("#UserName").val() == "" || $("#Password").val() == "" || $("#Name").val() == "")
            {
                bootbox.alert({ 
                    title: "Notificación",
                    message: "Los campos son obligatorios", 
                    callback: function(){}
                })
                return false;
            }
            else
            {
                return true;
            }
        })

        $("#UserName").keypress(function(event)
        {
            if(event.charCode == 13)
            {
               //SearchUser();
               $("#UserName").trigger("blur");
            }
        })

        $("#UserName").change(function(event)
        {
            SearchUser();
        })

    })

    function SearchUser()
    {
         if($("#UserName").val() != "")
         {
            $.ajax({
                url: $("#url").val() + '/Users/GetByUserName/',
                dataType: "json",
                data: {
                    UserName: $("#UserName").val()
                },
                type: "GET",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    if(data == null)
                    {
                        bootbox.alert("No se encontro el usuario");
                        $("#Name").val("");
                        return;
                    }
                    $("#Password").focus();
                },
                error: function (error) {
                    alert(error.responseText);
                }
            });
         }
    }
</script>