<?php if($this->session->flashdata('message_create')){?>
    <div class="alert alert-<?= $this->session->flashdata('class') ?> alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <?= $this->session->flashdata('message_create') ?>
    </div>
<?php } ?>
<?= form_open_multipart('/Convenios/CreatePost', array("id" => "frmCreate")) ?>

<div class="panel panel-uni">
  <div class="panel-heading">
    <h3 class="panel-title">Crear nuevo convenio</h3>
  </div>
  <div class="panel-body">

    <div class="row">
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="control-label" for="Cuenta">Cuenta:</label>
            <input type="text" name="Cuenta" id="Cuenta" value="<?= set_value("Cuenta") ?>" placeholder="Cuenta" class="form-control input-sm required-field just-number" max-length="19" autofocus>
            <label class="control-label" style="display:none;">Este campo es obligatorio</label>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <label class="control-label" for="Nombre">Nombre:</label>
            <input readonly type="text" name="Nombre" id="Nombre" value="<?= set_value("Nombre") ?>" placeholder="Nombre" class="form-control input-sm" max-length="100">
        </div>

        <div class="col-md-4 col-sm-4 col-xs-12">
            <label class="control-label" for="txbClavenego">Tipo de negociacion:</label>
             <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <input type="hidden" id="txbClavenego" max-length="4" value="<?= set_value("Clavenego") ?>" class="form-control">
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?php
                        $Options = array(
                            "" => "Seleccionar opción"
                        );
                        foreach($Tiposnego as $Tiponego)
                        {
                            $Options[$Tiponego->Id] = $Tiponego->Nombre;
                        }
                    ?>
                    <?= form_dropdown(array('name' => 'Clavenego','id' => 'Clavenego', 'class' => 'form-control required-field'),$Options, set_value("Clavenego")) ?>
                </div>
            </div>
            <label class="control-label" style="display:none;">Este campo es obligatorio</label>
        </div>

        <div class="col-md-2 col-sm-3 col-xs-6" id="botonsimulador" style="margin-top:20px; display: none;">
            <input class="btn btn-info" id="btnSimulador" style="float: right;width:100%;'" type="button" value="Simulador">
        </div>

    </div>

    <div class="row">
        <div class="col-md-1 col-sm-1 col-xs-12">
            <label class="control-label" for="Plataforma">Plataforma:</label>
            <input readonly type="text" name="Plataforma" id="Plataforma" value="<?= set_value("Plataforma") ?>" placeholder="" class="form-control input-sm" max-length="3">
        </div>
        <div class="col-md-1 col-sm-1 col-xs-12">
            <label class="control-label" for="Productoweb">Producto:</label>
            <input readonly type="text" name="Productoweb" id="Productoweb" value="<?= set_value("Productoweb") ?>" placeholder="" class="form-control input-sm" max-length="3">
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="control-label" for="Fec_ape">Fecha apertura:</label>
            <input readonly type="text" name="Fec_ape" id="Fec_ape" value="<?= set_value("Fec_ape") ?>" placeholder="" class="form-control input-sm" max-length="10">
        </div>
        <div class="col-md-1 col-sm-1 col-xs-12">
            <label class="control-label" for="Mes_castigo">M.Castigo:</label>
            <input readonly type="text" name="Mes_castigo" id="Mes_castigo" value="<?= set_value("Mes_castigo") ?>" placeholder="" class="form-control input-sm" max-length="10">
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="control-label" for="Saldo_act">Saldo actual:</label>
            <input readonly type="text" name="Saldo_act" id="Saldo_act" value="<?= set_value("Saldo_act") ?>" placeholder="Saldo actual" class="form-control input-sm text-right" max-length="12">
            <input type="hidden" id="Nsaldototal" name="Nsaldototal" value="" class="form-control">
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="control-label" for="Saldo_curbal">Saldo contable:</label>
            <input readonly type="text" name="Saldo_curbal" id="Saldo_curbal" value="<?= set_value("Saldo_curbal") ?>" placeholder="Saldo contable" class="form-control input-sm text-right" max-length="12">
            <input type="hidden" id="Nsaldocontab" name="Nsaldocontab" value="" class="form-control">
        </div>
        <div class="col-md-1 col-sm-1 col-xs-12">
            <label class="control-label" for="Quita_st">Q.Max.ST:</label>
            <input readonly type="text" name="Quita_st" id="Quita_st" value="<?= set_value("Quita_st") ?>" placeholder="Quita_st" class="form-control input-sm text-right" max-length="5">
        </div>
        <div class="col-md-1 col-sm-1 col-xs-12">
            <label class="control-label" for="Quita_sc">Q.Max.SC:</label>
            <input readonly type="text" name="Quita_sc" id="Quita_sc" value="<?= set_value("Quita_sc") ?>" placeholder="Quita_sc" class="form-control input-sm text-right" max-length="5">
        </div>
    </div>

    <div class="row" id="datostdc" style="display: none;">
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="control-label" for="Pago_minimo">Pago minimo:</label>
            <input readonly type="text" name="Pago_minimo" id="Pago_minimo" value="<?= set_value("Pago_minimo") ?>" placeholder="Pago minimo" class="form-control input-sm text-right" max-length="12">
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="control-label" for="Saldo_corte">Saldo al corte:</label>
            <input readonly type="text" name="Saldo_corte" id="Saldo_corte" value="<?= set_value("Saldo_corte") ?>" placeholder="Saldo_corte" class="form-control input-sm text-right" max-length="12">
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="control-label" for="Saldo_vencido_tdc">Saldo vencido:</label>
            <input readonly type="text" name="Saldo_vencido_tdc" id="Saldo_vencido_tdc" value="<?= set_value("Saldo_vencido_tdc") ?>" placeholder="Saldo vencido" class="form-control input-sm text-right" max-length="12">
        </div>
    </div>

    <div class="row" id="datoskrn" style="display: none;">
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="control-label" for="Mto_principal">Monto principal:</label>
            <input readonly type="text" name="Mto_principal" id="Mto_principal" value="<?= set_value("Mto_principal") ?>" placeholder="Mto. principal" class="form-control input-sm text-right" max-length="12">
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="control-label" for="Saldo_vencido_krn">Saldo vencido:</label>
            <input readonly type="text" name="Saldo_vencido_krn" id="Saldo_vencido_krn" value="<?= set_value("Saldo_vencido_krn") ?>" placeholder="Saldo vencido" class="form-control input-sm text-right" max-length="12">
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="control-label" for="Int_ordinarios">Int. ordinarios:</label>
            <input readonly type="text" name="Int_ordinarios" id="Int_ordinarios" value="<?= set_value("Int_ordinarios") ?>" placeholder="Int. ordinarios" class="form-control input-sm text-right" max-length="12">
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="control-label" for="Int_moratorios">Int. moratorios:</label>
            <input readonly type="text" name="Int_moratorios" id="Int_moratorios" value="<?= set_value("Int_moratorios") ?>" placeholder="Int. moratorios" class="form-control input-sm text-right" max-length="12">
        </div>
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="control-label" for="Conc_exigibles">Conc. exigibles:</label>
            <input readonly type="text" name="Conc_exigibles" id="Conc_exigibles" value="<?= set_value("Conc_exigibles") ?>" placeholder="Conc. exigibles" class="form-control input-sm text-right" max-length="12">
        </div>
    </div>

    <div class="row margin-top" style="margin-top:20px;">
        <!-- <input type="hidden" id="Plataforma" name="Plataforma" value="" class="form-control"> -->
        <input type="hidden" id="Plasticopago" name="Plasticopago" value="" class="form-control">
        <input type="hidden" id="Billing" name="Billing" value="" class="form-control">
        <input type="hidden" id="Dmssnum" name="Dmssnum" value="" class="form-control">
        <input type="hidden" id="Modalidad" name="Modalidad" value="" class="form-control">
        <input type="hidden" id="Macro_gen" name="Macro_gen" value="" class="form-control">
        <input type="hidden" id="Cepa" name="Cepa" value="" class="form-control">
        <input type="hidden" id="Moneda" name="Moneda" value="" class="form-control">
        <input type="hidden" id="Clienteweb" name="Clienteweb" value="" class="form-control">
        <input type="hidden" id="Gpo_meta" name="Gpo_meta" value="" class="form-control">
        <input type="hidden" id="Spei_num_key" name="Spei_num_key" value="" class="form-control">
        <input type="hidden" id="Portafolio" name="Portafolio" value="" class="form-control">
        <input type="hidden" id="Etapa" name="Etapa" value="" class="form-control">
        <input type="hidden" id="Restitucion" name="Restitucion" value="" class="form-control">
        <input type="hidden" id="Saldo_usado" name="Saldo_usado" value="T" class="form-control">
        <input type="hidden" id="Soloparcial" name="Soloparcial" value="" class="form-control">
        <input type="hidden" id="Pct_antpo" name="Pct_antpo" value="" class="form-control">
        <input type="hidden" id="Mismo_mes" name="Mismo_mes" value="" class="form-control">
        <input type="hidden" id="Tipo_convid" name="Tipo_convid" value="" class="form-control">
        <input type="hidden" id="Tipo_convid_alt" name="Tipo_convid_alt" value="" class="form-control">
        <input type="hidden" id="Plazo_maximo" name="Plazo_maximo" value="" class="form-control">
        <input type="hidden" id="Con_descuento" name="Con_descuento" value="" class="form-control">
        <input type="hidden" id="Con_excepcion" name="Con_excepcion" value="" class="form-control">
        <input type="hidden" id="hdAutoexcepcion" name="hdAutoexcepcion" value="" class="form-control">
        <input type="hidden" id="Total_adeudo" name="Total_adeudo" value="" class="form-control">
        <input type="hidden" id="Saldo_contable" name="Saldo_contable" value="" class="form-control">
        <input type="hidden" id="hdPlazosok" name="hdPlazosok" value="0" class="form-control">
        <input type="hidden" id="Grupoconv" name="Grupoconv" value="" class="form-control">
        <input type="hidden" id="Agente" name="Agente" value="" class="form-control">
        <input type="hidden" id="Quita_liqtot" name="Quita_liqtot" value="0" class="form-control">
        <input type="hidden" id="Quita_2a6" name="Quita_2a6" value="0" class="form-control">
        <input type="hidden" id="Quita_7a12" name="Quita_7a12" value="0" class="form-control">

        <div class="col-md-2 col-sm-2 col-xs-12 " id="divfechaneg">
            <label class="control-label" for="Nombre">Fecha negociacion:</label>
            <input readonly type="text" name="Fecha_neg" id="Fecha_neg" value="<?= $fecha_neg ?>" placeholder="Fecha neg." class="form-control input-sm datetimepicker required-field" max-length="10">

            <input class="btn btn-info" id="btnTableEdit" style="float: right; width:100%; margin-top:20px; display: none;" type="button" value="Editar pagos">
            
        </div>

        <div class=" col-md-6 col-sm-6 col-xs-12 table-responsive" id="divtablapagos" style="display: none;">
            <table class="table table-bordered table-condensed" id="tDetalle">
                <thead>
                    <tr>
                        <th width="15%" >Num.</th>
                        <th>Fecha pago</th>
                        <th>Importe</th>
                        <th class="text-center" ><span id="sAddRow" class="glyphicon glyphicon-plus" style="font-size:19px;color:#43ac6a; display: none;"></span></th>
                    </tr>
                </thead>
                <tbody>

                    <!-- <tr id="tr0" row="0" class="active">
                        <td>
                            <input onchange="ValidateDate(this);" type="text" name="lstDetalle[0][Fecha]" class="form-control input-sm datetimepicker" row="0" placeholder="Fecha"  onkeypress="ChangeToPago(this);" id="lstFecha0" />
                            <input type="hidden" name="lstDetalle[0][Active]" value="true" id="lstActive0" />
                        </td>
                        <td>
                            <input onchange="AddNewRow(this);" type="text" name="lstDetalle[0][Pago]" value="0" class="form-control numeric-field input-sm text-right" row="0" max-length="10"  placeholder="Pago" id="lstPago0" />
                        </td>
                        <td align="center"><span onclick="EliminarDetalle(this)" row="0" class="glyphicon glyphicon-remove" style="font-size:19px;color:red;margin-top: 9px;"></span></td>
                    </tr> -->

                </tbody>
            </table>
        </div>

        <div class="col-md-3 col-sm-3 col-xs-12 " id="divtotalapagar" style="display: none;">
            <label class="control-label" style="display:none;" id="lblQuitaneg" >Quita negociada: </label>
            <label class="control-label" style="display:none;" id="lblImporteconvenio" >Importe total del convenio: </label>
            <label class="control-label" for="Nombre">Suma pagos:</label>
            <input readonly type="text" name="Totalpago" id="Totalpago" placeholder="Total" class="form-control input-sm text-right" max-length="12">
            <input type="hidden" id="nTotalpago" name="nTotalpago" value="" class="form-control">
        </div>

    </div>

    <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-12">
            <label class="control-label" for="Llamada">Llamada:</label>
            <select class="form-control" name="Llamada" id="Llamada">
                    <option value="LLE">LLAMADA DE ENTRADA</option>
                    <option value="LLS">LLAMADA SALIDA</option>
                    <option value="LLW">LLAMADA DE ENTRADA WHATSAPP</option>
                </select>
            <label class="control-label" style="display:none;">Este campo es obligatorio</label>
        </div>

        <div class="col-md-4 col-sm-4 col-xs-12">
            <label class="control-label" for="txbClavenego">Causa de no pago:</label>
             <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <input type="hidden" id="txbCausanopago" max-length="4" value="<?= set_value("Causanopago") ?>" class="form-control">
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?php
                        $Options = array(
                            "" => "Seleccionar opción"
                        );
                        foreach($Causasnopago as $Causanp)
                        {
                            $Options[$Causanp->Clave] = $Causanp->Nombre;
                        }
                    ?>
                    <?= form_dropdown(array('name' => 'Causanopago','id' => 'Causanopago', 'class' => 'form-control required-field'),$Options, set_value("Causanopago")) ?>
                </div>
            </div>
            <label class="control-label" style="display:none;">Este campo es obligatorio</label>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="control-label" for="Telefono">Telefono:</label>
            <input type="text" name="Telefono" id="Telefono" value="<?= set_value("Telefono") ?>" placeholder="Tel." class="form-control input-sm required-field" max-length="10">
        </div>

        <div class="col-md-2 col-sm-2 col-xs-12">
            <label class="control-label" for="Tipo_tel">Tipo:</label>
            <select class="form-control" name="Tipo_tel" id="Tipo_tel">
                    <option value="Movil">Movil</option>
                    <option value="Fijo">Fijo</option>
                </select>
            <label class="control-label" style="display:none;">Este campo es obligatorio</label>
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <label class="control-label" for="Email">Correo electrónico:</label>
            <input type="text" name="Email" id="Email" value="<?= set_value("Email") ?>" placeholder="Email" class="form-control input-sm required-field" max-length="100">
            <input type="hidden" name="hdCorreovalido" id="hdCorreovalido" value="0">
        </div>

        <!-- <div class="col-md-2 col-sm-3 col-xs-6" style="margin-top:25px;">
            <input class="btn btn-danger" id="btnExcepcion" style="float: right;width:100%; display:none;" type="button" value="Auto excepcion">
        </div> -->

    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <label class="label-control">Observaciones:</label>
         </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <textarea class="form-control required-field" rows="3" name="Observaciones" id="Observaciones" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Observaciones" max-length="250"></textarea>
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
    <div class="modal-dialog" role="document">¡
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
                            <button type="button" class="btn btn-primary" id="btnAutorizarOtros">Autorizar</button>
                        </div>
                   </div> 
                </div>      
            </div>
        </div>
    </div>
</div>

<!-- Ventana modal para autorizar edicion de pagos-->

<div class="modal fade" id="mEditarpagos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #4d4dff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="color: #FFF;">Autorizacion para editar pagos</h4>
                </div>
                    <div class="row" style="margin-left:10px;margin-bottom:10px;">
                        <div class="col-md-4 col-sm-4 col-xs-12 form-check">
                            <input class="form-check-input" type="checkbox" value="" name="chkFechasesp" id="chkFechasesp">
                            <input type="hidden" id="hdFechasesp" name="hdFechasesp" value="0">
                            <label class="form-check-label" for="chkFechasesp">
                                Permitir fechas especiales
                            </label>
                        </div>
                    </div>
                    <div class="row" style="margin-left:10px;margin-bottom:10px;">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="label-control" for="txbUsuariopag">Usuario:</label>
                            <input type="text" id="txbUsuariopag" class="form-control" placeholder="Usuario" max-length="10">
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <label class="label-control" for="txbContrasenapag">Contraseña:</label>
                            <input type="password" id="txbContrasenapag" class="form-control" placeholder="Contraseña">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnRegresarpag">Regresar</button>
                        <button type="button" class="btn btn-primary" id="btnAutorizarEdtPagos">Autorizar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ventana modal para autorizar excepciones-->

<div class="modal fade" id="mAutoexcep" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #ff0000;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="color: #FFF;">Autorizar excepcion</h4>
                </div>
                    <div class="row" style="margin-left:10px;margin-bottom:10px;">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label class="label-control" for="txbUsuarioexc">Usuario:</label>
                            <input type="text" id="txbUsuarioexc" class="form-control" placeholder="Usuario" max-length="10">
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <label class="label-control" for="txbContrasenaexc">Contraseña:</label>
                            <input type="password" id="txbContrasenaexc" class="form-control" placeholder="Contraseña">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="btnRegresarexc">Regresar</button>
                        <button type="button" class="btn btn-primary" id="btnAutorizarAutoexcep">Autorizar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ventana modal para el simulador-->

<div class="modal fade" id="mSimulador" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #4d4dff;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" style="color: #FFF;">Simulador de convenios</h4>
      </div>
        <div class="modal-body">

            <div class="row" style="margin-bottom:15px;">
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <label class="form-check-label" id="lblTiponegociacion">
                        Tipo de negociacion
                    </label>
                </div>            
                <div class="col-md-4 col-sm-4 col-xs-12 form-check" id="divexcepcion" style="display: none;">
                    <input class="form-check-input" type="checkbox" value="" name="chkExcepcion" id="chkExcepcion">
                    <input type="hidden" id="hdExcepcion" name="hdExcepcion" value="0">
                    <label class="form-check-label" for="chkExcepcion">
                        Excepción
                    </label>
                </div>
            </div>

            <div class="row"  style="margin-bottom:15px;">
                <div id="divsaldos" style="display: none;" class="col-md-4 col-sm-4 col-xs-12">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="radioDefault" id="radioContable">
                        <label class="form-check-label" for="radioContable" id="textoContable">
                            Default radio
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="radioDefault" id="radioTotal" checked>
                        <label class="form-check-label" for="radioTotal" id="textoTotal">
                            Default checked radio
                        </label>
                    </div>
                </div>

                <div id="divquitasespeciales" style="display: none;" class="col-md-6 col-sm-6 col-xs-12">
                    <label id="lblquitaesphasta" class="control-label" style="color:#ff0000" >Quitas especiales vigente al: DD/MMM/AAAA </label>
                    <label id="lblquitaesptotal" class="control-label" style="color:#ff0000" >Quita liquidacion total: 00.00%</label>
                    <label id="lblquitaesp2a6" class="control-label" style="color:#ff0000" >Quita a plazos de 2 a 6 meses: 00.00%</label>
                    <label id="lblquitaesp7a12" class="control-label" style="color:#ff0000" >Quita a plazos de 7 a 12 meses: 00.00%</label>
                </div>

            </div>

            <div class="row">

                <div class="col-md-3 col-sm-3 col-xs-12">
                    <label class="label-control">Total a pagar:</label>
                    <input type="text" name="Importeapagar" id="Importeapagar" class="form-control input-sm importe text-right" max-length="10">
                </div>

                <div class="col-md-2 col-sm-2 col-xs-12">
                    <label class="label-control">% Quita:</label>
                    <input type="text" name="Quita_neg" id="Quita_neg" value="1" class="form-control input-sm importe text-right" max-length="5">
                </div>

                <div class="col-md-2 col-sm-2 col-xs-12">
                    <label class="label-control"># pagos:</label>
                    <input type="text" name="Num_pagos" id="Num_pagos" value="0" class="form-control input-sm just-number text-right" max-length="2">
                </div>

                <div class="col-md-3 col-sm-3 col-xs-12">
                    <label id="lblperiodicidad" class="control-label" for="Periodicidad">Periodicidad:</label>
                    <select class="form-control" name="Periodicidad" id="Periodicidad">
                            <option value="U" style="display:none;" >Pago único</option>
                            <option value="S">Semanal</option>
                            <option value="Q">Quincenal</option>
                            <option value="M">Mensual</option>
                        </select>
                    <label class="control-label" style="display:none;">Este campo es obligatorio</label>
                </div>
                
            </div>

            <div class="row">
                <label class="control-label" id="lblAnticipo" ></label>

                <div class="col-md-3 col-sm-3 col-xs-12 ">
                    <label class="control-label" for="Nombre">Fecha inicial</label>
                    <input type="text" name="Fecha_ini" value="<?= $fecha_neg ?>" id="Fecha_ini"  placeholder="Fecha ini." class="form-control input-sm datetimepicker" max-length="10">
                </div>

                <!-- <button type="button" class="btn btn-primary" id="btnGenerarPlan">Sugerir plan de pagos</button> -->
            </div>

            <div class="modal-footer" style="margin-top:15px;">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="btnSimuladorBack">Regresar</button>
                <button type="button" class="btn btn-primary" id="btnSimuladorOk">Generar simulación</button>
            </div>

        </div>
    </div>
  </div>
</div>

<?php echo form_close() ?>

<!-- // <script>
// document.addEventListener('DOMContentLoaded', () => {
//   document.querySelectorAll('input[type=text]').forEach( node => node.addEventListener('keypress', e => {
//     if(e.keyCode == 13) {
//       e.preventDefault();
//     }
//   }))
// });
// </script>
 -->
<script>

    function parseDDMMYYYY(dateString) {
        const parts = dateString.split('/');
        if (parts.length === 3) {
            const day = parseInt(parts[0], 10);
            const month = parseInt(parts[1], 10) - 1; // Month is 0-indexed in Date objects
            const year = parseInt(parts[2], 10);
            return new Date(year, month, day);
        }
        return null; // Or throw an error for invalid format
    }

    function SelectTiponego()
    {
        var vFound = false;
        $("#Clavenego option").each(function()
        {
            if($(this).val() == $("#txbClavenego").val())
            {
                $(this).prop("selected", true);
                $("#Clavenego").parent().parent().parent().removeClass("has-error");
                $("#Clavenego").parent().removeClass("has-error");
                $("#Clavenego").parent().parent().next().hide();
                vFound = true;
            }
        })

        if(!vFound)
        {
            $("#Clavenego").val("");
        }
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

    window.onload=AsignarFunciones();

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
        var vMismomes = $("#Mismo_mes").val();
        var vFechasesp = $("#hdFechasesp").val();
        var vFechapago = $(vElement).val();
        var vRow = $(vElement).attr("row");
        var vPartida =  $("#lstPartida" + vRow).val();
        var vTotpart = $("#tDetalle > tbody > tr").length;

        $("p.loader-gif").text("Verificando...");
        $(".loader-gif").show();

        $.ajax({
            url: $("#url").val() + '/Convenios/ValidaFecha/',
            dataType: "json",
            data: {
                Fechaneg: vFechaneg,
                Fechapago: vFechapago,
                Partida: vPartida,
                Totpart: vTotpart,
                Mismomes: vMismomes,
                Fechasesp: vFechasesp
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
        var vPlazomaximo = parseInt($("#Plazo_maximo").val());

        var vRow = $(vElement).attr("row");
        $("#tr" + vRow).addClass("active");

        var vTotalRegistros = 0;

        $("#tDetalle > tbody > tr:visible").each(function()
        {
            vTotalRegistros++;
        })

        if( vTotalRegistros < vPlazomaximo ){
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
                                    <input disabled type="text" name="lstDetalle[' + vCount + '][Partida]" value="0" class="form-control numeric-field input-sm text-right" row="' + vCount + '" max-length="10" placeholder="" id="lstPartida' + vCount + '" />\
                                </td>\
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

        var vSaldotot = parseFloat($("#Nsaldototal").val());
        var vSoloparcial = $("#Soloparcial").val();
        var vTotalRegistros = 0;
        var vTotalPago = 0;
        var vPartida = 1;

        $("#tDetalle > tbody > tr.active").each(function()
        {
            var vRow = $(this).attr("row");
            var vActive = $("#lstActive" + vRow).val();
            if(vActive == "true")
            {
                $("#lstPartida" + vRow).val(vPartida);
                vTotalRegistros++;
                var vCantidad = parseFloat($("#lstPago" + vRow).val());
                if (Number.isNaN(vCantidad)) {
                    bootbox.alert("Existen caracteres inválidos en el importe de la partida "+vPartida+". Asegúrese que solo tenga numeros, sin comas, simbolo de pesos ni otro caracter adicional.");
                    $("#lstPago" + vRow).val(0);
                }else{
                    vTotalPago += parseFloat(vCantidad);
                    vPartida++;
                }
            }
        })
        
        if(vTotalPago <=0 ){
            $("#Totalpago").val(0);
            $("#nTotalpago").val(0);
        }else{
            $("#Totalpago").val(addCommas(vTotalPago.toFixed(2)));
            $("#nTotalpago").val(vTotalPago.toFixed(2)); 
        }

        if(vSoloparcial != 1){
            //$("#lblImporteInsuficiente").show();
            //bootbox.alert("Aqui validamos la suma contra el importe a pagar");
        }

        if(vSoloparcial == 1 && vTotalPago >= (vSaldotot)){

            bootbox.alert("El importe del pago puede liquidar el saldo actual, la negociacion cambiará a LIQUIDACION SIN DESCUENTO. Haga click en el boton SIMULADOR para completar el proceso.");
            $("#Clavenego").val(6).change();

            // bootbox.confirm({
            //     message: "El importe del pago podría liquidar el saldo, desea cambiar la negociacion a LIQUIDACION SIN DESCUENTO?",
            //     callback: function(result)
            //     {
            //         if(result)
            //         {
            //             $("#Clavenego").val(6).change();
            //         }
            //     }
            // }); 

        }

    }

    function EliminarDetalle(vElement)
    {
        var vRow = $(vElement).attr("row");

        if( $("#lstPartida" + vRow).val() == 1 || $("#lstPartida" + vRow).val() == '1' ){

            bootbox.confirm({
                message: "Si elimina el pago inicial se borraran los subsecuentes, ¿Desea continuar?",
                callback: function(result)
                {
                    if(result)
                    {
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

        }else{
            bootbox.confirm({
                message: "El registro quedara eliminado, ¿Desea continuar?",
                callback: function(result)
                {
                    if(result)
                    {
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

        $("#chkFechasesp").change(function()
        {
            if( $(this).is(":checked") ){
                $("#hdFechasesp").val("1");
            }else{
                $('#hdFechasesp').val("0");
            }
        })

        $("#chkExcepcion").change(function()
        {
            if( $(this).is(":checked") ){
                // bootbox.alert( "Toda excepción requiere una autorizacion especial antes de guardar el convenio.");
                $("#txbUsuarioexc").val(""),
                $("#txbContrasenaexc").val(""),
                $("#mSimulador").modal("hide");
                $("#mAutoexcep").modal("show");
            }else{
                $('#hdExcepcion').val("0");
            }
            $("#Quita_neg").val(0);
            $("#Importeapagar").val(0);
        })

        $("#txbClavenego").keypress(function(event)
        {
            if(event.charCode == 13)
            {
                SelectTiponego();
            }
        })

        $("#txbClavenego").change(function()
        {
            SelectTiponego();
        })

        $("#Fecha_ini").change(function()
        {
            var vFechaneg = $("#Fecha_neg").val();
            var vMismomes = $("#Mismo_mes").val();
            var vFechasesp = $("#hdFechasesp").val();
            var vFechapago = $(this).val();

            $("p.loader-gif").text("Verificando...");
            $(".loader-gif").show();

            $.ajax({
                url: $("#url").val() + '/Convenios/ValidaFecha/',
                dataType: "json",
                data: {
                    Fechaneg: vFechaneg,
                    Fechapago: vFechapago,
                    Partida: 0,
                    Totpart: 1,
                    Mismomes: vMismomes,
                    Fechasesp: vFechasesp
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
                                    // $(this).val("").focus().select();
                                    $("#Fecha_ini").val("").focus();
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

        $("#Clavenego").change(function()
        {
            $("#txbClavenego").val($(this).val());
            var vIdnego = $(this).val();
            var vPdtoweb = $("#Productoweb").val();
            var vCuenta = $("#Cuenta").val();
            var vMoneda = $("#Moneda").val();
            var vQuitasc = $("#Quita_sc").val();
            var vQuitast = $("#Quita_st").val();
            var vQuitliqtot = $("#Quita_liqtot").val();
// 
            $("p.loader-gif").text("Verificando...");
            $(".loader-gif").show();
            $.ajax({
                url: $("#url").val() + '/Convenios/Datostiponego/',
                dataType: "json",
                data: {
                    Idnego: vIdnego,
                    Numpdto: vPdtoweb,
                    Cuenta: vCuenta,
                    Moneda: vMoneda,
                    Quitasc: vQuitasc,
                    Quitast: vQuitast
                },
                type: "GET",
                contentType: 'text/json',
                success: function (data) {

                    if(data != null && data.errormsg !='')
                    {
                        $("#txbClavenego").val("");
                        $(".loader-gif").hide();
                        bootbox.alert({
                            message: data.errormsg,
                            callback: function () {
                                setTimeout(function()
                                {
                                    $("#Clavenego").focus().select();
                                },100)
                            }
                        })                        
                    }

                    if(data != null && data.errormsg =='')
                    {
                        // console.log(data);

                        $(".loader-gif").hide();
                        $("#lblTiponegociacion").text( data.nombre_nego );
                        $("#Grupoconv").val( data.clavecrm );

                        $("#Soloparcial").val(data.solo_parcial);
                        $("#Plazo_maximo").val(data.plazo_maximo);
                        $("#Mismo_mes").val(data.mismo_mes);
                        $("#Pct_antpo").val(data.pct_antpo);
                        $("#Tipo_convid").val(data.tipo_convid);
                        $("#Con_descuento").val(data.con_descuento);
                        $("#Con_excepcion").val(data.con_excepcion);

                        var vSaldototal = parseFloat($("#Nsaldototal").val());

                        if(data.pct_antpo > 0)
                        {
                            $("#lblAnticipo").text( "Esta negociacion requiere un "+data.pct_antpo+"% como pago inicial." );
                        }else{
                            $("#lblAnticipo").text( "" );
                        }

                        if(data.con_descuento == 1)
                        {
                            $('#divsaldos').show();
                            $("#Quita_neg").val(0).removeAttr('readonly');
                            $("#Importeapagar").val(0).removeAttr('readonly');
                        }else{
                            $('#divsaldos').hide();
                            $("#Quita_neg").val(0).attr('readonly', 'readonly');
                            $("#Importeapagar").val(vSaldototal).attr('readonly', 'readonly');
                        }

                        $('#Totalpago').val(0);

                        if(data.plazo_maximo > 1)
                        {
                            $('#Num_pagos').val(2).removeAttr('readonly');
                            if(vQuitliqtot>0)
                            {
                                 $('#Periodicidad').val('M').attr('readonly', 'readonly');
                                 $('#Periodicidad').hide();
                                 $("#lblperiodicidad").text( "Periodicidad: MENSUAL" );
                            }else{
                                $('#Periodicidad').val('S').removeAttr('readonly');
                                $("#lblperiodicidad").text( "Periodicidad" );
                                $('#Periodicidad').show();
                            }
                        }else{
                            $('#Num_pagos').val(1).attr('readonly', 'readonly');
                            $('#Periodicidad').val('U').attr('readonly', 'readonly');
                            $('#Periodicidad').hide();
                            $("#lblperiodicidad").text( "Periodicidad: PAGO UNICO" );
                        }

                        if(data.solo_parcial == 1){
                            $('#divtablapagos').show();
                            $('#divtotalapagar').show();
                            $('#botonsimulador').hide();

                            $("#tDetalle tbody tr").remove();

                            setTimeout(function()
                            {
                                $("#sAddRow").click();
                            },500)

                        }else{
                            $("#tDetalle tbody tr").remove();
                            $('#divtablapagos').hide();
                            $('#divtotalapagar').hide();
                            $('#botonsimulador').show();
                        }
                        if(data.con_excepcion == 1){
                            $('#divexcepcion').show();
                            $('#hdExcepcion').val(0)
                        }else{
                            $('#hdExcepcion').val(0)
                            $('#divexcepcion').hide();
                        }

                    }
                },
                error: function (error) {
                    bootbox.alert(error.responseText);
                }
            });
        })    

        $("#Num_pagos").change(function()
        {
            var vPlazomaximo = parseInt($("#Plazo_maximo").val()); 
            var vNumpag = parseInt($(this).val());

            var vApagar = parseFloat($("#Importeapagar").val());
            var vQuitaneg = parseFloat($("#Quita_neg").val());
            var vQuita_st = parseFloat($("#Quita_st").val());
            var vQuita_sc = parseFloat($("#Quita_sc").val());
            var vQuita_liqtot = parseFloat($("#Quita_liqtot").val());
            var vQuita_2a6 = parseFloat($("#Quita_2a6").val());
            var vQuita_7a12 = parseFloat($("#Quita_7a12").val());
            var vMismomes = parseInt($("#Mismo_mes").val());

            var vSaldocontab = parseFloat($("#Nsaldocontab").val());
            var vSaldototal = parseFloat($("#Nsaldototal").val());

            var vEnfacultad = true;
            var vCondescuento = parseInt( $("#Con_descuento").val() );
            var vExcepcion = parseInt( $("#hdExcepcion").val() );

            if (vPlazomaximo > 1 && vNumpag == 1 )
            {
                bootbox.alert("Esta negociacion requiere un mínimo de 2 pagos y un máximo de "+vPlazomaximo);
                $("#Num_pagos").val(2).focus();
            }

            if (vNumpag > vPlazomaximo )
            {
                bootbox.alert("El numero máximo de pagos para esta negociacion es de: "+vPlazomaximo);
                $("#Num_pagos").val(vPlazomaximo).focus();
            }

            //bootbox.alert("vApagar: "+vApagar+", vCondescuento: "+vCondescuento+", vQuita_liqtot: "+vQuita_liqtot);

            if(vApagar > 0 && vCondescuento == 1 && vQuita_liqtot > 0){   

                var vQuita_compara = 0;

                if ( vNumpag == 1 || vMismomes ==1){
                    vQuita_compara = vQuita_liqtot;
                }else if( vNumpag >= 2 && vNumpag <= 6 && vMismomes !=1){
                    vQuita_compara = vQuita_2a6;
                }else if( vNumpag >= 7 && vNumpag <= 12 && vMismomes !=1){
                    vQuita_compara = vQuita_7a12;
                }else{
                    vQuita_compara = 0;
                }

                //bootbox.alert("Quita a comparar: "+vQuita_compara);

                if ( $('input[id="radioContable"]').is(':checked') )
                {
                    var vQuitacalc =  (($("#Nsaldocontab").val() - vApagar )/$("#Nsaldocontab").val())*100  ;

                    $("#Saldo_usado").val('C');
                    if(vQuitacalc > vQuita_compara)
                    {
                        vEnfacultad =false;
                    }else{
                        var vPagocalc =  $("#Nsaldocontab").val() - ($("#Nsaldocontab").val() * (vQuita_compara/100))  ;
                        vPagocalc =  Math.ceil(vPagocalc)+1;
                    }

                }else{
                    var vQuitacalc = (($("#Nsaldototal").val() - vApagar )/$("#Nsaldototal").val()) *100 ;
                    $("#Saldo_usado").val('T');
                    if(vQuitacalc > vQuita_compara)
                    {
                        vEnfacultad =false;
                    }else{
                        var vPagocalc =  $("#Nsaldototal").val() - ($("#Nsaldototal").val() * (vQuita_compara/100))  ;
                        vPagocalc =  Math.ceil(vPagocalc)+1;
                    }
                }

                if(vEnfacultad)
                {
                    $("#Quita_neg").val(vQuitacalc.toFixed(2));

                    if(vApagar < vPagocalc )
                    {
                        bootbox.alert("Por regla, el importe se ajustará de acuerdo los criterios del banco.");
                        $("#Importeapagar").val(vPagocalc);
                    }else{
                        $("#Importeapagar").val(Math.ceil(vApagar));
                    }

                }else{
                    if(vExcepcion == 1)
                    {
                        vQuitacalc = parseFloat(vQuitacalc.toFixed(2));
                        if(vQuitacalc > 95){
                            bootbox.alert("La quita otorgada: "+vQuitacalc+", excede el 95% (maximo permitido aun en caso de excepciones).");
                            $("#Quita_neg").val(0);
                        }else{
                            $("#Quita_neg").val(vQuitacalc.toFixed(2));
                        }
                        
                    }else{
                        bootbox.alert("El importe excede el maximo de quita autorizada, revise importe y plazos");
                        $("#Quita_neg").val(0);
                    }
                }
            }

        })  

        $("#Importeapagar").change(function()
        {

            var vApagar = $(this).val();
            var vQuita_st = parseFloat($("#Quita_st").val());
            var vQuita_sc = parseFloat($("#Quita_sc").val());
            var vQuita_liqtot = parseFloat($("#Quita_liqtot").val());
            var vQuita_2a6 = parseFloat($("#Quita_2a6").val());
            var vQuita_7a12 = parseFloat($("#Quita_7a12").val());
            var vNumpagos = parseInt($("#Num_pagos").val());
            var vMismomes = parseInt($("#Mismo_mes").val());

            var vSaldocontab = parseFloat($("#Nsaldocontab").val());
            var vSaldototal = parseFloat($("#Nsaldototal").val());

            var vEnfacultad = true;
            var vCondescuento = parseInt( $("#Con_descuento").val() );
            var vExcepcion = parseInt( $("#hdExcepcion").val() );

            if (vApagar > 0 && vCondescuento == 1 && vQuita_liqtot <= 0)
            {

                if ( $('input[id="radioContable"]').is(':checked') )
                {
                    var vQuitacalc =  (($("#Nsaldocontab").val() - vApagar )/$("#Nsaldocontab").val())*100  ;

                    $("#Saldo_usado").val('C');
                    if(vQuitacalc > vQuita_sc)
                    {
                        vEnfacultad =false;
                    }else{
                        var vPagocalc =  $("#Nsaldocontab").val() - ($("#Nsaldocontab").val() * (vQuita_sc/100))  ;
                        vPagocalc =  Math.ceil(vPagocalc)+1;
                    }

                }else{
                    var vQuitacalc = (($("#Nsaldototal").val() - vApagar )/$("#Nsaldototal").val()) *100 ;
                    $("#Saldo_usado").val('T');
                    if(vQuitacalc > vQuita_st)
                    {
                        vEnfacultad =false;
                    }else{
                        var vPagocalc =  $("#Nsaldototal").val() - ($("#Nsaldototal").val() * (vQuita_st/100))  ;
                        vPagocalc =  Math.ceil(vPagocalc)+1;
                    }
                }

                if(vEnfacultad)
                {
                    $("#Quita_neg").val(vQuitacalc.toFixed(2));

                    if(vApagar < vPagocalc )
                    {
                        bootbox.alert("Por regla, el importe se ajustará de acuerdo los criterios del banco.");
                        $("#Importeapagar").val(vPagocalc);
                    }else{
                        $("#Importeapagar").val(Math.ceil(vApagar));
                    }

                }else{
                    if(vExcepcion == 1)
                    {
                        vQuitacalc = parseFloat(vQuitacalc.toFixed(2));
                        if(vQuitacalc > 95){
                            bootbox.alert("La quita otorgada: "+vQuitacalc+", excede el 95% (maximo permitido aun en caso de excepciones).");
                            $("#Quita_neg").val(0);
                        }else{
                            $("#Quita_neg").val(vQuitacalc.toFixed(2));
                        }
                        
                    }else{
                        bootbox.alert("El importe excede el maximo de quita autorizada.");
                        $("#Quita_neg").val(0);
                    }
                }

            }else if(vApagar > 0 && vCondescuento == 1 && vQuita_liqtot > 0){             
//
                var vQuita_compara = 0;

                if ( vNumpagos == 1 || vMismomes ==1){
                    vQuita_compara = vQuita_liqtot;
                }else if( vNumpagos >= 2 && vNumpagos <= 6 && vMismomes !=1){
                    vQuita_compara = vQuita_2a6;
                }else if( vNumpagos >= 7 && vNumpagos <= 12 && vMismomes !=1){
                    vQuita_compara = vQuita_7a12;
                }else{
                    vQuita_compara = 0;
                }

                if ( $('input[id="radioContable"]').is(':checked') )
                {
                    var vQuitacalc =  (($("#Nsaldocontab").val() - vApagar )/$("#Nsaldocontab").val())*100  ;

                    $("#Saldo_usado").val('C');
                    if(vQuitacalc > vQuita_compara)
                    {
                        vEnfacultad =false;
                    }else{
                        var vPagocalc =  $("#Nsaldocontab").val() - ($("#Nsaldocontab").val() * (vQuita_compara/100))  ;
                        vPagocalc =  Math.ceil(vPagocalc)+1;
                    }

                }else{
                    var vQuitacalc = (($("#Nsaldototal").val() - vApagar )/$("#Nsaldototal").val()) *100 ;
                    $("#Saldo_usado").val('T');
                    if(vQuitacalc > vQuita_compara)
                    {
                        vEnfacultad =false;
                    }else{
                        var vPagocalc =  $("#Nsaldototal").val() - ($("#Nsaldototal").val() * (vQuita_compara/100))  ;
                        vPagocalc =  Math.ceil(vPagocalc)+1;
                    }
                }

                if(vEnfacultad)
                {
                    $("#Quita_neg").val(vQuitacalc.toFixed(2));

                    if(vApagar < vPagocalc )
                    {
                        bootbox.alert("Por regla, el importe se ajustará de acuerdo los criterios del banco.");
                        $("#Importeapagar").val(vPagocalc);
                    }else{
                        $("#Importeapagar").val(Math.ceil(vApagar));
                    }

                }else{
                    if(vExcepcion == 1)
                    {
                        vQuitacalc = parseFloat(vQuitacalc.toFixed(2));
                        if(vQuitacalc > 95){
                            bootbox.alert("La quita otorgada: "+vQuitacalc+", excede el 95% (maximo permitido aun en caso de excepciones).");
                            $("#Quita_neg").val(0);
                        }else{
                            $("#Quita_neg").val(vQuitacalc.toFixed(2));
                        }
                        
                    }else{
                        bootbox.alert("El importe excede el maximo de quita autorizada, revise importe y plazos");
                        $("#Quita_neg").val(0);
                    }
                }
//
            }else{
                $("#Quita_neg").val(0);
            }

        })    

        $("#Quita_neg").change(function()
        {
            var vQuita = parseFloat($(this).val());
            var vQuita_st = parseFloat($("#Quita_st").val());
            var vQuita_sc = parseFloat($("#Quita_sc").val());
            var vCondescuento = parseInt( $("#Con_descuento").val() );
            var vExcepcion = parseInt( $("#hdExcepcion").val() );
            var vQuita_liqtot = parseFloat($("#Quita_liqtot").val());
            var vQuita_2a6 = parseFloat($("#Quita_2a6").val());
            var vQuita_7a12 = parseFloat($("#Quita_7a12").val());
            var vNumpagos = parseInt($("#Num_pagos").val());
            var vMismomes = parseInt($("#Mismo_mes").val());
            var vEnfacultad = true;

            if (vQuita > 0 && vCondescuento == 1 && vQuita_liqtot <= 0)
            {
                if ( $('input[id="radioContable"]').is(':checked') )
                {
                    var vPagocalc =  $("#Nsaldocontab").val() - ($("#Nsaldocontab").val() * (vQuita/100))  ;
                    vPagocalc =  Math.ceil(vPagocalc)+1;

                    $("#Saldo_usado").val('C');
                    if(vQuita > vQuita_sc)
                    {
                        vEnfacultad =false;
                    }
                }else{
                    var vPagocalc = $("#Nsaldototal").val() - ($("#Nsaldototal").val() * (vQuita/100))  ;
                    vPagocalc =  Math.ceil(vPagocalc)+1;

                    $("#Saldo_usado").val('T');
                    if(vQuita > vQuita_st)
                    {
                        vEnfacultad =false;
                    }
                }

                if(vEnfacultad)
                {
                    $("#Importeapagar").val(vPagocalc.toFixed(2));
                }else{
                    if(vExcepcion == 1)
                    {
                        vQuitacalc = parseFloat(vQuita.toFixed(2));
                        if(vQuitacalc > 95){
                            bootbox.alert("La quita otorgada: "+vQuita+", excede el 95% (maximo permitido aun en caso de excepciones).");
                           $("#Importeapagar").val(0);
                        }else{
                            $("#Importeapagar").val(vPagocalc.toFixed(2));
                        }
                    }else{
                        bootbox.alert("El % indicado excede el maximo de quita autorizada.");
                       $("#Importeapagar").val(0);
                    }
                }

                // }else{
                //     bootbox.alert("El % indicado excede el maximo de quita autorizada.");
                //     $("#Importeapagar").val(0);
                // }

            }else if( vQuita > 0 && vCondescuento == 1 && vQuita_liqtot > 0 ){
//
                var vQuita_compara = 0;

                if ( vNumpagos == 1 || vMismomes ==1){
                    vQuita_compara = vQuita_liqtot;
                }else if( vNumpagos >= 2 && vNumpagos <= 6 && vMismomes !=1){
                    vQuita_compara = vQuita_2a6;
                }else if( vNumpagos >= 7 && vNumpagos <= 12 && vMismomes !=1){
                    vQuita_compara = vQuita_7a12;
                }else{
                    vQuita_compara = 0;
                }

                if ( $('input[id="radioContable"]').is(':checked') )
                {
                    var vPagocalc =  $("#Nsaldocontab").val() - ($("#Nsaldocontab").val() * (vQuita/100))  ;
                    vPagocalc =  Math.ceil(vPagocalc)+1;

                    $("#Saldo_usado").val('C');
                    if(vQuita > vQuita_compara)
                    {
                        vEnfacultad =false;
                    }
                }else{
                    var vPagocalc = $("#Nsaldototal").val() - ($("#Nsaldototal").val() * (vQuita/100))  ;
                    vPagocalc =  Math.ceil(vPagocalc)+1;

                    $("#Saldo_usado").val('T');
                    if(vQuita > vQuita_compara)
                    {
                        vEnfacultad =false;
                    }
                }

                if(vEnfacultad)
                {
                    $("#Importeapagar").val(vPagocalc.toFixed(2));
                }else{
                    if(vExcepcion == 1)
                    {
                        vQuitacalc = parseFloat(vQuita.toFixed(2));
                        if(vQuitacalc > 95){
                            bootbox.alert("La quita otorgada: "+vQuita+", excede el 95% (maximo permitido aun en caso de excepciones).");
                           $("#Importeapagar").val(0);
                        }else{
                            $("#Importeapagar").val(vPagocalc.toFixed(2));
                        }
                    }else{
                        bootbox.alert("El % indicado excede el maximo de quita autorizada, revise el % de quita y los plazos");
                       $("#Importeapagar").val(0);
                    }
                }
//
            }else{
                $("#Importeapagar").val(0);
            }

        })    

        $('input[name="radioDefault"]').change(function()
        {
            var vCondescuento = parseInt( $("#Con_descuento").val() );
            var vSaldocontab = parseFloat($("#Nsaldocontab").val());
            var vSaldototal = parseFloat($("#Nsaldototal").val());

            if ( $('input[id="radioContable"]').is(':checked') )
            {
                if(vCondescuento == 0){
                    $("#Importeapagar").val(vSaldocontab);
                    $("#Quita_neg").val(0);
                }else{
                    $("#Importeapagar").val(0);
                    $("#Quita_neg").val(0);
                }
                $("#Saldo_usado").val('C');
            }else{
                if(vCondescuento == 0){
                    $("#Importeapagar").val(vSaldototal);
                    $("#Quita_neg").val(0);
                }else{
                    $("#Importeapagar").val(0);
                    $("#Quita_neg").val(0);
                }
                $("#Saldo_usado").val('T');
            }

        })
//
        $("#Plataforma").change(function()
        {
            if($(this).val() == 'CYB')   
            {
                $('#datoskrn').hide();
                $('#datostdc').show();
                // $('#Cuenta').attr('max-length', 19);
                // $('#Cuenta').addClass('fill');
            }else{
                $('#datoskrn').show();
                $('#datostdc').hide();
                // $('#Cuenta').attr('max-length', 8);
                // $('#Cuenta').removeClass('fill');
            }
            AsignarFunciones();
        })    

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
                        $("#Plasticopago").val(data.plasticopago);
                        $("#Billing").val(data.billing);
                        $("#Fec_ape").val(data.fec_ape);
                        $("#Mes_castigo").val(data.mes_castigo);
                        $("#Plataforma").val(data.plataforma);
                        $("#Agente").val(data.agente);

                        $("#Saldo_act").val( addCommas(data.saldo_total));
                        $("#Saldo_curbal").val( addCommas(data.saldo_curbal));
                        $("#Nsaldototal").val( data.saldo_total );
                        $("#Nsaldocontab").val( data.saldo_curbal );

                        $("#Quita_st").val( data.quita_st );
                        $("#Quita_sc").val( data.quita_sc );

                        $("#Quita_liqtot").val( data.quita_liqtot );
                        $("#Quita_2a6").val( data.quita_2a6 );
                        $("#Quita_7a12").val( data.quita_7a12 );

                        if( parseFloat(data.quita_liqtot) > 0){
                            $("#lblquitaesphasta").text( 'Quitas especiales vigentes al: '+data.quita_vigencia );
                            $("#lblquitaesptotal").text( 'Quita liquidacion total: '+parseFloat(data.quita_liqtot).toFixed(2)+'%' );
                            $("#lblquitaesp2a6").text( 'Quita a plazos de 2 a 6 meses: '+parseFloat(data.quita_2a6).toFixed(2)+'%' );
                            $("#lblquitaesp7a12").text( 'Quita a plazos de 7 a 12 meses: '+parseFloat(data.quita_7a12).toFixed(2)+'%' );
                            $('#divquitasespeciales').show();
                        }else{
                            $("#lblquitaesphasta").text( '' );
                            $("#lblquitaesptotal").text( '' );
                            $("#lblquitaesp2a6").text( '' );
                            $("#lblquitaesp7a12").text( '' );
                            $('#divquitasespeciales').hide();                            
                        }

                        $("#Pago_minimo").val( addCommas(data.pago_minimo));
                        $("#Saldo_corte").val( addCommas(data.saldo_corte));
                        $("#Saldo_vencido_tdc").val( addCommas(data.saldo_vencido_tdc));

                        $("#Mto_principal").val( addCommas(data.mto_principal));
                        $("#Int_ordinarios").val( addCommas(data.int_ordinarios));
                        $("#Int_moratorios").val( addCommas(data.int_moratorios));
                        $("#Conc_exigibles").val( addCommas(data.conc_exigibles));
                        $("#Int_moratorios").val( addCommas(data.int_moratorios));
                        $("#Total_adeudo").val( addCommas(data.total_adeudo));

                        //bootbox.alert("Valor: "+data.total_adeudo);

                        $("#Saldo_contable").val( addCommas(data.saldo_contable));

                        $("#Saldo_vencido_krn").val( addCommas(data.saldo_vencido_krn));

                        $("#Dmssnum").val(data.dmssnum);
                        $("#Modalidad").val(data.modalidad);
                        $("#Macro_gen").val( data.macro_gen);
                        $("#Spei_num_key").val( data.spei_num_key);
                        $("#Gpo_meta").val( data.gpo_meta);
                        $("#Moneda").val( data.moneda);
                        $("#Clienteweb").val( data.clienteweb);
                        $("#Productoweb").val( data.productoweb);
                        $("#Cepa").val( data.cepa);
                        $("#Portafolio").val( data.portafolio);
                        $("#Etapa").val( data.etapa);
                        $("#Restitucion").val( data.restitucion);

                        $("#textoContable").text( "Contable: "+$("#Saldo_curbal").val() );
                        $("#textoTotal").text( "Total: "+$("#Saldo_act").val() );

                        // $("#Status").html('<h4 id="Status">'+data.status+'</h4>');

                        if((data.quita_st == 0 || data.quita_sc == 0) && data.agente != '035' && data.agente != '326' && data.agente != '339' && data.agente != '727' && data.agente != '729'){
                            bootbox.alert("Es posible que las quitas autorizadas ya hayan expirado. Avise al supervisor.");
                            $("#Quita_sc").parent().addClass("has-error");
                            $("#Quita_st").parent().addClass("has-error");
                        }else{
                            $("#Quita_sc").parent().removeClass("has-error");
                            $("#Quita_st").parent().removeClass("has-error");
                        }

                        if((data.quita_st == 0 || data.quita_sc == 0) && (data.agente == '035' || data.agente == '326' || data.agente == '339' || data.agente == '727' || data.agente == '729')){
                            bootbox.alert("Cuenta de exempleado, no aplican las quitas.");
                            $("#Quita_sc").parent().addClass("has-error");
                            $("#Quita_st").parent().addClass("has-error");
                        }else{
                            $("#Quita_sc").parent().removeClass("has-error");
                            $("#Quita_st").parent().removeClass("has-error");
                        }

                        $(".loader-gif").hide();
                        $('#Plataforma').trigger('change');
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

//
        $("#btnSimulador").click(function()
        {
            var vLargocuenta=$("#Cuenta").val().length;
            if(vLargocuenta>0){
                $("#mSimulador").modal("show");
            }else{
                setTimeout(function()
                {
                    bootbox.alert("Debe indicar un numero de cuenta válido");
                    $("#Cuenta").focus();   
                },100)
            }
        })

//
        $("#sAddRow").click(function()
        {
            var vPlazomaximo = parseInt($("#Plazo_maximo").val());

            var vTotalRegistros = 0;
            $("#tDetalle > tbody > tr:visible").each(function()
            {
                vTotalRegistros++;
            })

            if(vTotalRegistros < vPlazomaximo){
                var vAddRow = true;
            }else{
                var vAddRow = false;
            }

            var vCount = $("#tDetalle > tbody > tr").length;
            var vPartida = vCount+1;
            if(vAddRow)
            {
                var vNewRow = '<tr id="tr' + vCount + '" row="' + vCount + '" >\
                                    <td>\
                                        <input disabled type="text" name="lstDetalle[' + vCount + '][Partida]" value="' + vPartida + '" class="form-control numeric-field input-sm text-right" row="' + vCount + '" max-length="10" placeholder="" id="lstPartida' + vCount + '" />\
                                    </td>\
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

        $("#btnRegresarpag").click(function()
        {            
            $("#btnTableEdit").focus();
        })

        $("#btnRegresarexc").click(function()
        {
            $('#chkExcepcion').prop('checked', false);        
            $('#hdExcepcion').val("0");    
            $("#mSimulador").modal("show");
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
                $("#btnAutorizarOtros").trigger("click");
            }
        })

        $("#txbUsuariopag").keypress(function()
        {
            if(event.charCode == 13)
            {
                $("#txbContrasenapag").focus();
            }
        })

        $("#txbContrasenapag").keypress(function()
        {
            if(event.charCode == 13)
            {
                $("#btnAutorizarEdtPagos").trigger("click");
            }
        })

        $("#txbUsuarioexc").keypress(function()
        {
            if(event.charCode == 13)
            {
                $("#txbContrasenaexc").focus();
            }
        })

        $("#txbContrasenaexc").keypress(function()
        {
            if(event.charCode == 13)
            {
                $("#btnAutorizarAutoexcep").trigger("click");
            }
        })
//
        $("#btnAutorizarAutoexcep").click(function()
        {
            $("p.loader-gif").text("Verificando...");
            $(".loader-gif").show();
             $.ajax({
                url: $("#url").val() + '/Users/AutorizacionSuperv/',
                dataType: "json",
                data: {
                    Usuario: $("#txbUsuarioexc").val(),
                    Contrasena: $("#txbContrasenaexc").val(),
                },
                type: "GET",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    if(data.length == 0)
                    {
                        $(".loader-gif").hide();
                        // vAutorizado = true;
                        $("#hdAutoexcepcion").val($("#txbUsuarioexc").val());
                        $('#hdExcepcion').val("1");
                        $("#mAutoexcep").modal("hide");
                        $("#mSimulador").modal("show");
                    }else
                    {
                        $("#hdAutoexcepcion").val("");
                        $('#hdExcepcion').val("0");
                        bootbox.alert(data);
                        $(".loader-gif").hide();
                    }
                },
                error: function (error) {
                    bootbox.alert(error.responseText);
                }
            });
        })
//
        $("#btnAutorizarOtros").click(function()
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

        $("#btnAutorizarEdtPagos").click(function()
        {
            $("p.loader-gif").text("Verificando...");
            $(".loader-gif").show();
             $.ajax({
                url: $("#url").val() + '/Users/AutorizacionSuperv/',
                dataType: "json",
                data: {
                    Usuario: $("#txbUsuariopag").val(),
                    Contrasena: $("#txbContrasenapag").val(),
                },
                type: "GET",
                contentType: 'application/json; charset=utf-8',
                success: function (data) {
                    
                    if(data.length == 0)
                    {
                        $(".loader-gif").hide();
                        vAutorizado = true;
                        var vTextbtn = $("#btnTableEdit").val();
                        if(vTextbtn == "Editar pagos"){

                            $("#tDetalle > tbody > tr.active > td > input").each(function()
                            {
                                $(this).removeAttr('readonly');
                            })
                            $("#tDetalle > tbody > tr.active > td > span").each(function()
                            {
                                $(this).show();
                            })
                            $("#tDetalle > tbody > tr.active > td > input[fechapago]").each(function()
                            {
                                $(this).addClass('datetimepicker');
                            })
                            $('#sAddRow').show();
                            $("#btnTableEdit").val("Proteger pagos");
                            // $('#hdFechasesp').val("1");  

                        }
                        $("#mEditarpagos").modal("hide");
                    }else
                    {
                        $('#chkFechasesp').prop('checked', false);        
                        $('#hdFechasesp').val("0");    
                        bootbox.alert(data);
                        $(".loader-gif").hide();
                    }
                },
                error: function (error) {
                    bootbox.alert(error.responseText);
                }
            });
        })

        $("#btnSimuladorOk").click(function()
        {  
            //var vImporteapagarInt = parseInt($("#Importeapagar").val());
            $("#hdPlazosok").val("0");

            var vImporteapagar = parseFloat($("#Importeapagar").val());
            var vQuitaneg = parseFloat($("#Quita_neg").val());
            var vNumpagos = parseInt($("#Num_pagos").val());
            var vFechainicial = $("#Fecha_ini").val();
            var vPeriodicidad = $("#Periodicidad").val();
            var vPcantpo = parseFloat($("#Pct_antpo").val());
            var vCondescuento = parseInt($("#Con_descuento").val());
            var vMismomes = parseInt($("#Mismo_mes").val());

            if(vImporteapagar <= 0){
              bootbox.alert("Es necesario indicar el importe total a pagar del convenio");  
              $("#Importeapagar").focus();
              return false;
            }

            if( vCondescuento == 1 && vQuitaneg <= 0){
              bootbox.alert("Es necesario indicar el % de quita que se aplicará al convenio");  
              $("#Quita_neg").focus();
              return false;
            }

            if(vNumpagos < 1){
              bootbox.alert("Es necesario indicar el numero de pagos del convenio");  
              $("#Num_pagos").focus();
              return false;
            }

            if($("#Fecha_ini").val().length == 0)
            {
                bootbox.alert("Es necesario indicar le fecha del primer pago.");
                $("#Fecha_ini").focus();
                return false;
            }

            if($("#tDetalle > tbody > tr.active").length > 0 )
            {

                bootbox.confirm({
                    message: "Ya hay informacion en la tabla de pagos, los registros actuales seran eliminados",
                    callback: function(result)
                    {
                        if(result)
                        {
                            $("#tDetalle tbody tr").remove();
                        }
                    }
                }); 
            }

            // Inicia rutina para generar el convenio sugerido

            setTimeout(function()
            {
                var fechapago = parseDDMMYYYY($("#Fecha_ini").val());
                if( vCondescuento == 1 && vQuitaneg > 0){
                    if(vPcantpo > 0){
                        var anticipo = Math.ceil(vImporteapagar*(vPcantpo/100));
                        var pagoparcial = Math.ceil( (vImporteapagar-anticipo)/(vNumpagos-1) );
                    }else{                
                        var pagoparcial = Math.ceil( vImporteapagar/vNumpagos);
                        var anticipo = Math.ceil( pagoparcial );
                    }
                }else{
                    if(vPcantpo > 0){
                        var anticipo = vImporteapagar*(vPcantpo/100);
                        var pagoparcial =  (vImporteapagar-anticipo)/(vNumpagos-1);
                    }else{                
                        var pagoparcial =  vImporteapagar/vNumpagos;
                        var anticipo =  pagoparcial;
                    }
                }

                if( vNumpagos == 1)
                {
                    if(vCondescuento == 1)
                    {
                        anticipo = Math.ceil(vImporteapagar);
                    }else{
                        anticipo = vImporteapagar;
                    }
                }

                var pagorow = 0;
                var acumpagorow = 0;
                var ultimoDia = new Date(fechapago.getFullYear(), fechapago.getMonth() + 1, 0);
                let uday = ultimoDia.getDate();
                let umonth = ultimoDia.getMonth() +1;
                let uyear = ultimoDia.getFullYear();

                for (let i = 0; i <= vNumpagos-1; i++) {
                    // Obtener la diferencia en milisegundos
                    var diferenciaEnMilisegundos = fechapago.getTime() - ultimoDia.getTime();
                    // Convertir a días
                    var diferenciaEnDias = diferenciaEnMilisegundos / (1000 * 60 * 60 * 24);

                    if(vMismomes ==1 && diferenciaEnDias >= 0)
                    {
                        bootbox.alert("Este convenio requiere que todos los pagos queden dentro del mes. Algunas fechas se ajustaron al dia ultimo, revise por favor!");
                        fechapago = ultimoDia;
                    }

                    if(vMismomes ==0 && diferenciaEnDias >= 0)
                    {
                        $("#hdPlazosok").val("1");
                    }

                    let day = fechapago.getDate();
                    let month = fechapago.getMonth() +1;
                    let year = fechapago.getFullYear();

                    if(month < 10){
                        fecharow= `${day}/0${month}/${year}`;
                    }else{
                        fecharow= `${day}/${month}/${year}`;
                    }

                    vCount = i;
                    vPartida = vCount+1;

                    if(vCount == 0 ){
                        pagorow = anticipo.toFixed(2);
                    }else{
                        pagorow = pagoparcial.toFixed(2);
                    }

                    if(i == vNumpagos-1 && vNumpagos>1)
                    {
                        acumpagorow = parseFloat(acumpagorow)+parseFloat(pagorow);
                        vDife = parseFloat(vImporteapagar)-parseFloat(acumpagorow)

                        if(vDife>0){
                            pagorow = parseFloat(pagorow)+parseFloat(vDife); 
                        }else{
                            pagorow = parseFloat(pagorow)-parseFloat(vDife);
                        }
                        pagorow = pagorow.toFixed(2);

                        // bootbox.alert("Diferencia: "+vDife);
                    }


                    var vNewRow = '<tr id="tr' + vCount + '" row="' + vCount + '" class="active" >\
                                        <td>\
                                            <input disabled type="text" name="lstDetalle[' + vCount + '][Partida]" value="'+vPartida+'" class="form-control numeric-field input-sm text-right" row="' + vCount + '" max-length="10" placeholder="" id="lstPartida' + vCount + '" />\
                                        </td>\
                                        <td>\
                                            <input readonly fechapago onchange="ValidateDate(this);" type="text" name="lstDetalle[' + vCount + '][Fecha]" value="'+fecharow+'"class="form-control input-sm" row="' + vCount + '" placeholder="Fecha"  onkeypress="ChangeToPago(this);" id="lstFecha' + vCount + '" />\
                                            <input readonly type="hidden" name="lstDetalle[' + vCount + '][Active]" value="true" id="lstActive' + vCount + '" />\
                                        </td>\
                                        <td>\
                                            <input readonly onchange="AddNewRow(this);" type="text" name="lstDetalle[' + vCount + '][Pago]" value="'+pagorow+'" class="form-control numeric-field input-sm text-right" row="' + vCount + '" max-length="10" placeholder="Pago" id="lstPago' + vCount + '" />\
                                        </td>\
                                        <td align="center"><span onclick="EliminarDetalle(this)" row="' + vCount + '" class="glyphicon glyphicon-remove" style="font-size:19px;color:red;margin-top: 9px;display: none;"></span></td>\
                                    </tr>';
                    $("#tDetalle > tbody").append(vNewRow);

                    acumpagorow = parseFloat(acumpagorow)+parseFloat(pagorow);

                    if(fechapago != ultimoDia)
                    {
                        switch (vPeriodicidad) {
                            case "S":
                                fechapago.setDate(fechapago.getDate() + 7);
                                break;
                            case "Q":
                                fechapago.setDate(fechapago.getDate() + 15);
                                break;
                            case "M":
                                fechapago.setMonth(fechapago.getMonth() + 1);
                                break;
                        }
                    }
                }
            },200)            

            setTimeout(function()
            {
                AsignarFunciones();
                ContarDetalles();
                if( vMismomes ==0 && $("#hdPlazosok").val() != "1" )
                {
                    bootbox.alert("Este no parece un convenio a plazos ya que todos los pagos quedaron dentro del mes, cambie el tipo de negociacion y vuelva a generar la simulación.");
                }
            },400)  


            $("#lblQuitaneg").text( '% de quita negociada: '+vQuitaneg ).show();
            $("#lblImporteconvenio").text( 'Importe total del convenio: '+addCommas(vImporteapagar.toFixed(2))).show();
            $("#mSimulador").modal("hide");
            $('#divtotalapagar').show();
            $('#divtablapagos').show();
            $('#btnTableEdit').show();
            $('#Telefono').show().focus();

        })

        $("#Email").change(function()
        {
            var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

            if (regex.test($('#Email').val().trim())) {
                // bootbox.alert('Correo validado');
                $("#hdCorreovalido").val("1");
            } else {
                alert('La dirección de correo no es válida');
                $("#hdCorreovalido").val("0");
                $("#Correo").focus();
            }            
        })

        // $(\'input[disabled]\') txbUsuariopag

        $("#btnTableEdit").click(function()
        {    
            var vTextbtn = $("#btnTableEdit").val();

            if(vTextbtn == "Editar pagos"){
                $("#txbContrasenapag").val("");
                $("#mEditarpagos").modal("show");
                $("#txbUsuariopag").val("").focus();
            }else{
                $("#tDetalle > tbody > tr.active > td > input").each(function()
                {
                    $(this).attr('readonly', 'readonly');
                })
                $("#tDetalle > tbody > tr.active > td > span").each(function()
                {
                    $(this).hide();
                })
                $("#tDetalle > tbody > tr.active > td > input[fechapago]").each(function()
                {
                    $(this).removeClass('datetimepicker');
                })
                $('#sAddRow').hide();
                $("#btnTableEdit").val("Editar pagos");
            }

        })

        $("#btnSave").click(function()
        {    
            $("#frmCreate").submit();
            
        })

        $("#frmCreate").submit(function()
        {

            $("#hdTriedSave").val("true");
            var vSubmit = true;
            var vSoloparcial = $("#Soloparcial").val();
            var vPagototal = parseFloat($("#nTotalpago").val());
            var vTotalconvenio = parseFloat($("#Importeapagar").val());
            var vMismomes = parseInt($("#Mismo_mes").val());

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

            if(vPagototal != vTotalconvenio && vSoloparcial !=1)
            {
                bootbox.alert("La suma de los pagos debe ser igual al importe total del convenio.");
                //bootbox.alert("vPagototal="+vPagototal+" --- vTotalconvenio="+vTotalconvenio);
                vSubmit = false;
            }

            if($("#tDetalle > tbody > tr.active").length == 0 && vSubmit)
            {
                bootbox.alert("Tiene que agregar al menos un pago para guardar.");
                vSubmit = false;
            }

            if( vMismomes ==0 && $("#hdPlazosok").val() != "1" )
            {
                bootbox.alert("Este no parece un convenio a plazos ya que todos los pagos quedaron dentro del mes, cambie el tipo de negociacion y vuelva a generar la simulación.");
                vSubmit = false;
            }

            if(vSubmit)
                $(".loader-gif").show();
            return vSubmit;
        })
    })
</script>