<?php if($this->session->flashdata('message_create')){?>
    <div class="alert alert-<?= $this->session->flashdata('class') ?> alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <?= $this->session->flashdata('message_create') ?>
    </div>
<?php } ?>
<div class="panel panel-uni">
  <div class="panel-heading">
    <h3 class="panel-title"><?= $title ?></h3>
  </div>
  <div class="panel-body">

    <div class="row">
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="control-label" for="FechaI">Fecha inicial:</label>
            <input type="text" name="FechaI" id="FechaI" value="<?= $Fechadefault ?>" placeholder="Fecha" class="form-control datetimepicker required-field" max-length="10">
            <label class="control-label" style="display:none;">Este campo es obligatorio</label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="control-label" for="FechaF">Fecha final:</label>
            <input type="text" name="FechaF" id="FechaF" value="<?= $Fechadefault ?>" placeholder="Fecha" class="form-control datetimepicker required-field" max-length="10">
            <label class="control-label" style="display:none;">Este campo es obligatorio</label>
        </div>
    </div>

     <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <label class="control-label" for="Cliente">Cliente:</label>
            <?php
                $Optionsv = array(
                    '000' => "AMBOS",
                    "122" => "RECOVERY (122)",
                    "129" => "BACKEND (129)",
                );
            ?>
            <?= form_dropdown(array('name' => 'Cliente','id' => 'Cliente', 'class' => 'form-control input-sm required-field'),$Optionsv, "00") ?>
        </div>
    </div>

  </div>


</div>
        
<div class="row" style="margin-top:15px;">
    <div class="col-md-2 col-sm-3 col-xs-6">
        <button class="btn btn-success" id="iDescargarExcelConvenios">Descargar excel</button>
    </div>
</div>

<?= form_open_multipart('/Reportes/ExcelConvenios', array("id" => "frmDescargarExcelConvenios")) ?>
    <input type="hidden" name="Cliente" class="cliente" value="00">
    <input type="hidden" name="FechaInicial" class="dato-fechai" value="<?= $Fechadefault ?>">
    <input type="hidden" name="FechaFinal" class="dato-fechaf" value="<?= $Fechadefault ?>">
<?= form_close() ?>

<script>
    $(function()
    {

        $("#Cliente").change(function()
        {
            $(".cliente").val($(this).val());
        })

        $("#FechaI").change(function()
        {
            $(".dato-fechai").val($(this).val());
        })

        $("#FechaF").change(function()
        {
            $(".dato-fechaf").val($(this).val());
        })

        $("#iDescargarExcelConvenios").click(function()
        {
            //
            // Validamos campos vacios y fechas
            //
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

            $("#frmDescargarExcelConvenios").submit();
            bootbox.alert("El archivo se descargara en un momento.");
        })
    })
</script>