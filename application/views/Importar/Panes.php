<?php if($this->session->flashdata('message_import')){?>

    <div class="alert alert-<?= $this->session->flashdata('class') ?> alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <?= $this->session->flashdata('message_import') ?>
    </div>
<?php } ?>

<?= form_open_multipart('/Importar/PanesPost', array("id" => "frmCreate", "enctype" => "multipart/form-data")) ?>

<div class="panel panel-uni">

  <div class="panel-heading">
    <h3 class="panel-title">Importar archivo PAN</h3>
  </div>

  <div class="panel-body">
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <label class="control-label" for="Archivo">Archivo excel:</label>
            <input type="file" accept=".xls,.xlsx" name="Archivo" id="Archivo" class="form-control required-field">
            <label class="control-label" style="display:none;">Este campo es obligatorio</label>
        </div>
        <input type="hidden" name="hdcontrol" value="true" id="hdcontrol" />
    </div>
  </div>

</div>
        
<div class="row" style="margin-top:15px;">
    <div class="col-md-offset-10 col-sm-offset-9 col-xs-offset-6 col-md-2 col-sm-3 col-xs-6">
        <button type="button" id="btnSave" class="btn btn-success" style="float: right;width:100%;">Importar archivo</button>
    </div>
</div>

<?= form_close() ?>

<script>
    $(function()
    {
        $("#btnSave").click(function()
        {
            $("#frmCreate").submit();    
        })
        $("#frmCreate").submit(function()
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
            if(vSubmit)
            {
                $("p.loader-gif").text("Espere, Importando archivo...");
                $(".loader-gif").show();
            }
            return vSubmit;
        })
    })
</script>