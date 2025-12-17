<?php $IdUsuario = $this->session->UID; ?>
    <?php if($this->session->flashdata('message_index')){?>
        <div class="alert alert-<?php echo $this->session->flashdata('class') ?> alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <?php echo $this->session->flashdata('message_index') ?>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <h2>Productos y quitas</h2>
        </div>
        <?php if(VerificarPermisos($IdUsuario, "Productos", "Create")){ ?>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <a href="<?= base_url() ?>Productos/Create" class="btn btn-success" style="float: right;margin-top:24px;">Crear producto</a>
        </div>
        <?php } ?>
    </div>
    <div class="row">
        <?= form_open('/Productos/') ?>
        <input type="hidden" name="Page" id="Page" value="<?= $ActualPage ?>" >
        <div class="col-md-4 col-sm-4 col-xs-12">
            <input type="text" id="Nombre" name="Nombre" class="form-control" placeholder="Nombre" value="<?= set_value("Nombre") ?>" />
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12">
            <input type="submit" id="btnFilter" class="btn btn-default" style="width:100%" value="Filtrar" />
        </div>
        <div class="col-md-2 col-sm-4 col-xs-12">
            <a href="<?= base_url() ?>Productos" class="btn btn-info" style="width:100%">Limpiar</a>
        </div>
        <?= form_close() ?>
    </div>
    <div class="row" style="margin-top:15px;">
        <div class="table-responsive">
        <table id="tblUsers" class="table table-hover">
        <thead class="thead-style">
        <tr>
            <th>Id</th>
            <th>Num.</th>
            <th>Nombre</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
            foreach($Productos as $Producto){
        ?>
        <tr>
            <td><?= $Producto->Id ?></td>
            <td><?= $Producto->Numero ?></td>
            <td><?= $Producto->Nombre ?></td>
            <td>
                <?php if(VerificarPermisos($IdUsuario, "Productos", "Edit")){ ?>
                <a href="<?= base_url() ?>Productos/Edit/<?= $Producto->Id ?>" style="color: #000">Editar</a>
                <?php } ?>
            </td>
            <td>
                <?php if(VerificarPermisos($IdUsuario, "Productos", "Details")){ ?>
                <a href="<?= base_url() ?>Productos/Details/<?= $Producto->Id ?>" style="color: #000">Detalles</a>
                <?php } ?>
            </td>
            <td>
                <?php if(VerificarPermisos($IdUsuario, "Productos", "Edit")){ ?>
                <a href="<?= base_url() ?>Productos/Quitas/<?= $Producto->Id ?>">Quitas</a>
                <?php } ?>
            </td>
            <td>
                <?php if(VerificarPermisos($IdUsuario, "Productos", "Edit")){ ?>
                <a href="<?= base_url() ?>Productos/QuitasPlazos/<?= $Producto->Id ?>">Quitas plazos</a>
                <?php } ?>
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

    <script>
        $(function()
        {
            $('#Clave').autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: $("#url").val() + '/Productos/AutocompleteClave/',
                        dataType: "json",
                        data: {
                            term: $("#Clave").val()
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
                        url: $("#url").val() + '/Productos/AutocompleteNombre/',
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
        })
    </script>