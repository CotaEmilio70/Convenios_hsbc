<?php $IdUsuario = $this->session->UID; ?>
    <?php if($this->session->flashdata('message_index')){?>
        <div class="alert alert-<?php echo $this->session->flashdata('class') ?> alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <?php echo $this->session->flashdata('message_index') ?>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <h2>Master de convenios</h2>
        </div>
        <?php if(VerificarPermisos($IdUsuario, "Convenios", "Create")){ ?>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <a href="<?= base_url() ?>Convenios/Create" class="btn btn-success" style="float: right;margin-top:24px;">Crear nuevo convenio</a>
        </div>
        <?php } ?>
    </div>
    <div class="row">
        <?= form_open('/Convenios/') ?>
        <input type="hidden" name="Page" id="Page" value="<?= $ActualPage ?>" >
        <div class="col-md-2 col-sm-4 col-xs-12">
            <input type="text" id="Cuenta" name="Cuenta" class="form-control" placeholder="Cuenta" value="<?= set_value("Cuenta") ?>" />
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <input type="text" id="Nombre" name="Nombre" class="form-control" placeholder="Nombre" value="<?= set_value("Nombre") ?>" />
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12">
            <input type="submit" id="btnFilter" class="btn btn-default" style="width:100%" value="Filtrar" />
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12">
            <a href="<?= base_url() ?>Convenios" class="btn btn-info" style="width:100%">Limpiar</a>
        </div>
        <?= form_close() ?>
    </div>
    <div class="row" style="margin-top:15px;">
        <div class="table-responsive">
        <table id="tblUsers" class="table table-hover">
        <thead class="thead-style">
        <tr>
            <th>Folio</th>
            <th>Cuenta</th>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>Fecha</th>
            <th>Creado por</th>
            <th>Estado</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
            foreach($Convenios as $Convenio){
            switch ($Convenio->Estado_conv) {
                case 0:
                    $Estadotext= 'Simulador';
                    $Coloredotext = 'color: #000';
                    break;
                case 1:
                    $Estadotext= 'Autorizado';
                    $Coloredotext = 'color: #12a14b';
                    break;
                case 99:
                    $Estadotext= 'Cancelado';
                    $Coloredotext = 'color: #ff0000';
                    break;
                default:
                    $Estadotext= '';
            }

        ?>
        <tr>
            <td><?= $Convenio->Folio_pre."-".str_pad($Convenio->Folio_cons, 4, "0", STR_PAD_LEFT) ?></td>
            <td><?= $Convenio->Dmacct ?></td>
            <td><?= $Convenio->Nombre ?></td>
            <td><?= $this->Tiposnego_model->GetNombreByid($Convenio->Tipo_negoid) ?></td>
            <td><?= $Convenio->Fecha_emi ?></td>
            <td><?= $Convenio->CreatedBy ?></td>
            <td style="<?= $Coloredotext ?>"><?= $Estadotext ?></td>
            <td>
                <?php if(VerificarPermisos($IdUsuario, "Convenios", "Details")){ ?>
                <a href="<?= base_url() ?>Convenios/Details/<?= $Convenio->Id ?>" style="color: #000">Detalles</a>
                <?php } ?>
            </td>

            <td>

                <?php if(VerificarPermisos($IdUsuario, "Convenios", "Edit") && $Convenio->Cancelado == 0 && $Convenio->Estado_conv == 0){ ?>
                    <a href="<?= base_url() ?>Convenios/Edit/<?= $Convenio->Id ?>" style="color: #000">Autorizar</a>
                <?php }else{ ?>

                    <?php
                        if($Convenio->Cancelado == 0 && $Convenio->Estado_conv == 1)
                        {
                    ?>
                            <a href="#" class="descargar-recibo" folio="<?= $Convenio->Id ?>" tipo="<?= $Convenio->Tipo_convid ?>" style="color: #000">Descargar Pdf</a>
                    <?php
                        }
                    }?>

            </td>

        </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php
        $Previous = $ActualPage - 1;
        $Next = $ActualPage + 1;
        $DisabledPrevious = "";
        $DisabledNext = "";
        if($Previous <= 0){
            $Previous = "";
            $DisabledPrevious = "disabled";
        }

        if($Next > $Pages){
            $Next = "";
            $DisabledNext = "disabled";
        }
    ?>
    <nav>
        <ul class="pagination pagination-sm">
            <li class="<?= $DisabledPrevious ?>">
                <a data-href="<?= $Previous ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php
                for($i = 1; $i <= $Pages; $i++){
                    $ActiveClass = "";
                    $cursor = "";
                    if($i == $ActualPage){
                        $ActiveClass = "class='active'";
                        $cursor = "cursor: not-allowed;";
                    }
            ?>
                    <li <?= $ActiveClass ?>><a style="<?= $cursor ?>" data-href="<?= $i ?>"><?= $i ?></a></li>
            <?php } ?>
            <li class="<?= $DisabledNext ?>">
                <a data-href="<?= $Next ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>

<input type="hidden" id="url" value="<?= base_url() ?>">
</div>

<?= form_open_multipart('/Convenios/GenerarPdf1', array("id" => "frmGenerarPdf1")) ?>
    <input type="hidden" name="Convenioid" id="Convenioid" class="folioid">
<?= form_close() ?>

<?= form_open_multipart('/Convenios/GenerarPdf2', array("id" => "frmGenerarPdf2")) ?>
    <input type="hidden" name="Convenioid" id="Convenioid" class="folioid">
<?= form_close() ?>

<?= form_open_multipart('/Convenios/GenerarPdf3', array("id" => "frmGenerarPdf3")) ?>
    <input type="hidden" name="Convenioid" id="Convenioid" class="folioid">
<?= form_close() ?>

<?= form_open_multipart('/Convenios/GenerarPdf4', array("id" => "frmGenerarPdf4")) ?>
    <input type="hidden" name="Convenioid" id="Convenioid" class="folioid">
<?= form_close() ?>

<?= form_open_multipart('/Convenios/GenerarPdf5', array("id" => "frmGenerarPdf5")) ?>
    <input type="hidden" name="Convenioid" id="Convenioid" class="folioid">
<?= form_close() ?>

<?= form_open_multipart('/Convenios/GenerarPdf6', array("id" => "frmGenerarPdf6")) ?>
    <input type="hidden" name="Convenioid" id="Convenioid" class="folioid">
<?= form_close() ?>

<?= form_open_multipart('/Convenios/GenerarPdf7', array("id" => "frmGenerarPdf7")) ?>
    <input type="hidden" name="Convenioid" id="Convenioid" class="folioid">
<?= form_close() ?>

<?= form_open_multipart('/Convenios/GenerarPdf8', array("id" => "frmGenerarPdf8")) ?>
    <input type="hidden" name="Convenioid" id="Convenioid" class="folioid">
<?= form_close() ?>

<?= form_open_multipart('/Convenios/GenerarPdf9', array("id" => "frmGenerarPdf9")) ?>
    <input type="hidden" name="Convenioid" id="Convenioid" class="folioid">
<?= form_close() ?>

    <script>
        $(function()
        {
            $('#Cuenta').autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: $("#url").val() + '/Convenios/AutocompleteClave/',
                        dataType: "json",
                        data: {
                            term: $("#Cuenta").val()
                        },
                        type: "GET",
                        contentType: 'application/json; charset=utf-8',
                        success: function (data) {
                            response($.map(data, function (item) {
                                return {
                                    value: item.value,
                                    label: item.label
                                }
                            }));
                        },
                        error: function (error) {
                            alert(error.responseText);
                        }
                    });
                },
                select: function (event, ui) {
                    $(this).val(ui.item.label);
                    return false;
                }
            });

            $('#Nombre').autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: $("#url").val() + '/Convenios/AutocompleteNombre/',
                        dataType: "json",
                        data: {
                            term: $("#Nombre").val()
                        },
                        type: "GET",
                        contentType: 'application/json; charset=utf-8',
                        success: function (data) {
                            response($.map(data, function (item) {
                                return {
                                    value: item.value,
                                    label: item.label
                                }
                            }));
                        },
                        error: function (error) {
                            alert(error.responseText);
                        }
                    });
                },
                select: function (event, ui) {
                    $(this).val(ui.item.label);
                    return false;
                }
            });

            $(".descargar-recibo").click(function(){
                event.preventDefault();
                $(".folioid").val($(this).attr("folio"));
                // $("#Tipoconvid").val($(this).attr("tipo"));

                formulario = "#frmGenerarPdf"+$(this).attr("tipo");
                // formulario = "#frmGenerarPdf"+"4";

                // bootbox.alert("El formulario es: "+formulario);

                $(formulario).submit();        
                bootbox.alert("El convenio se descargara en un momento. "+formulario);
            })

        })
    </script>

    <!-- <?php
    if($this->session->flashdata('Convenio_id'))
    {
        $Convenio_id = $this->session->flashdata('Convenio_id');
    ?>

    <script>
        $("#Convenioid").val("<?= $Convenio_id ?>");
        $("#frmGenerarPdf").submit();        
        bootbox.alert("El convenio se descargara en un momento.");
    </script>

    <?php
        }
    ?> -->