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
    <h3 class="panel-title">Detalles de usuario</h3>
  </div>
  <div class="panel-body">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <label class="label-display-name">Nombre:</label> 
            <label><?= $User->Name ?></label>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <label class="label-display-name">Usuario:</label> 
            <label><?= $User->UID ?></label>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <label class="label-display-name">Email:</label> 
            <label><?= $User->email ?></label>
        </div>        
        <div class="col-md-3 col-sm-6 col-xs-12">
            <label class="label-display-name">Nivel:</label> 
            <label><?= $User->Level." ".$NombreNivel ?></label>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12 col-ms-12 col-xs-12">
                <h4>Permisos asignados</h4>
            </div>
            <div class="col-md-12 col-ms-12 col-xs-12">
                <div class="col-md-12 col-ms-12 col-xs-12">
                    Modulo
                </div>
                <?php
                    foreach($Permisos as $Item)
                    {
                ?>
                        <div class="col-md-12 col-ms-12 col-xs-12" style="margin: 5px;font-size: 17px;">
                            <div class="col-md-12 col-ms-12 col-xs-12" style="padding:5px;">
                                <label class="label label-warning" title="<?= $Item->Grupo->Nombre ?>"><?= $Item->Grupo->Nombre ?></label>
                            </div>

                <?php
                        foreach($Item->Modulos as $Modulo)
                        {
                            $puntitos = strlen($Modulo->Nombre) > 20 ? "..." : "";
                ?>
                <div class="col-md-12 col-ms-12 col-xs-12 contenedor-permisos" style="margin: 5px;font-size: 17px;">
                                <div class="col-md-2 col-ms-4 col-xs-12" style="padding:5px;">
                                    <label class="label label-default" title="<?= $Modulo->Nombre ?>"><?= substr($Modulo->Nombre, 0, 20).$puntitos ?></label>
                                </div>
                <?php
                            foreach($Modulo->Opciones as $Item2)
                            {
                                $Asignado = false;
                                foreach($PermisosUsuario as $Item3)
                                {
                                    if($Item3->Idpermiso == $Item2->Id)
                                    {
                                        $Asignado = true;
                                    }
                                }
                                if($Asignado){
                ?>
                                <div class="col-md-2 col-sm-4 col-xs-4" style="padding: 5px;">
                                    <label class="label label-success"><?= $Item2->Nombre ?> <span class="glyphicon glyphicon-ok"></span></label>
                                </div>
                <?php
                                }
                            }
                            ?>
                            </div>
                            <?php
                        }
                    ?>
                        </div>  
                    <?php
                    }
                ?>
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
        <?php
            if($User->InactivatedBy != null)
            {
        ?>
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <label>Inactivado por: <?= $InactivatedBy ?></label>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <label>Fecha de inactivación: <?= $User->UpdatedDate ?></label>
                    </div>
                </div>
        <?php
            }
        ?>
    </div>
  </div>
</div>

<div class="row" style="margin-top:15px;">
    <div class="col-md-2 col-sm-3 col-xs-4">
            <a href="<?= base_url() ?>Users" class="btn btn-default" style="width:100%;">Volver</a>
    </div>
    <div class="col-md-offset-6 col-sm-offset-3 col-md-2 col-sm-3 col-xs-4">
        <?php
            if($User->Active == 1 && VerificarPermisos($IdUsuario, "Users", "Edit"))
            {
        ?>
                <a href="<?= base_url() ?>Users/Edit/<?= $User->UID ?>" class="btn btn-primary" style="float:right;width:100%">Editar</a>
        <?php
            }
        ?>
    </div>
    <div class="col-md-2 col-sm-3 col-xs-4">
        <?php
            if($User->Active == 1 && VerificarPermisos($IdUsuario, "Users", "Delete"))
            {
        ?>
                <a class="btn btn-danger" style="float:right;width:100%" data-message-delete="El usuario quedara inactivo, ¿Desea continuar?">Inactivar</a>
        <?php
            }
        ?>
    </div>
</div>

<?= form_open_multipart('/Users/Delete', array("id" => "frmDelete")) ?>
    <input type="hidden" name="UID" id="UID" value="<?= $User->UID ?>">
<?php echo form_close() ?>


<script>

    $(document).ready(function(){
        $(':checkbox[readonly=readonly]').click(function(){
            return false;        
        });
    });

    $(function()
    {
        $(".contenedor-permisos").each(function(index, element)
        {
            if($(element).children().length == 1)
            {
                $(element).remove();
            }
        })
    })
</script>