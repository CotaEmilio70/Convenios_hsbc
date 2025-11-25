<?php
    $IdUsuario = $this->session->UID;
?>
<?php if($this->session->flashdata('message_details')){?>
    <div class="alert alert-<?= $this->session->flashdata('class') ?> alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <?= $this->session->flashdata('message_details') ?>
    </div>
<?php } ?>


<div class="panel panel-uni">
  <div class="panel-heading">
    <h3 class="panel-title">Detalles de parametros</h3>
  </div>
  <div class="panel-body">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <label class="label-display-name">Nombre del despacho:</label> 
            <label><?= $Parametros->razon_soc ?></label>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <label class="label-display-name">Dirección del despacho:</label> 
            <label><?= $Parametros->direccion ?></label>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <label class="label-display-name">RFC del despacho:</label> 
            <label><?= $Parametros->rfc ?></label>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <label class="label-display-name">Entidad financiera:</label> 
            <label><?= $Parametros->entidad_financiera ?></label>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <label class="label-display-name">Nombre corto E.F.:</label> 
            <label><?= $Parametros->nombrecorto_ef ?></label>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <label class="label-display-name">Direccion E.F.:</label> 
            <label><?= $Parametros->direccion_ef ?></label>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <label class="label-display-name">Telefono E.F.:</label> 
            <label><?= $Parametros->telefono_ef ?></label>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <label class="label-display-name">Nombre de quien firma los convenios:</label> 
            <label><?= $Parametros->nombrefirma_ag ?></label>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <label class="label-display-name">Cd y Edo de expedicion de los convenios:</label> 
            <label><?= $Parametros->cd_edo_expedicion ?></label>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <label class="label-display-name">Archivo con imagen de la firma:</label> 
            <label><?= $Parametros->imagen_firma_ag ?></label>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <label class="label-display-name">Nota final (puede contener codigo html para texto enriquecido):</label> 
            <label><?= $Parametros->nota_final ?></label>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <label class="label-display-name">Registros a mostrar para usuario:</label> 
            <label><?= $Parametros->verconv_usr ?></label>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <label class="label-display-name">Registros a mostrar para admin:</label> 
            <label><?= $Parametros->verconv_sup ?></label>
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
    <?php if(VerificarPermisos($IdUsuario, "Parametros", "Edit")){ ?>
    <div class="col-md-offset-10 col-sm-offset-9 col-xs-offset-8 col-md-2 col-sm-3 col-xs-4">
        <a href="<?= base_url() ?>Parametros/Edit/" class="btn btn-primary" style="float:right;width:100%">Editar</a>
    </div>
    <?php } ?>
</div>