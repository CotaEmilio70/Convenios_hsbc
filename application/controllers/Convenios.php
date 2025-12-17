<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Convenios extends CI_Controller {

    function __construct(){
        parent::__construct();

        if(!$this->session->Logged){
            $this->session->set_flashdata('error', 'Autenticarse para entrar al sistema');
            redirect("Users/LogIn");
        }
    }

    function Index()
    {
        if(!VerificarPermisos($this->session->UID, "Convenios", "Index")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a este catalogo. Contacte al administrador.');
            redirect("");
        }
        $Parametros = $this->Parametros_model->GetUnique();

        $Page = 1;
        $Cuenta = "";
        $Nombre = "";
        if($this->input->post()){
            $Cuenta = $this->input->post('Cuenta');
            $Nombre = $this->input->post('Nombre');
            $Page = $this->input->post("Page");
        }
        set_value("Cuenta", "Nombre");
        $Pages = $this->Convenios_model->GetPages($Page, $Cuenta, $Nombre, $Parametros->verconv_usr, $Parametros->verconv_sup);
        if( $Pages <= 1){
            $Page = 1;
        }
        $Convenios = $this->Convenios_model->GetAll($Page, $Cuenta, $Nombre);
        $Data['title'] = "Master de convenios";
        $Data['Convenios'] = $Convenios;
        $Data['Pages'] = $Pages;
        $Data['ActualPage'] = $Page;
        $this->load->view('layouts/_menu', $Data);
        $this->load->view('Convenios/Index', $Data);
        $this->load->view('layouts/footer');
    }

    function Create(){
        if(!VerificarPermisos($this->session->UID, "Convenios", "Create")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a este catalogo. Contacte al administrador.');
            redirect("");
        }

        $TodayDate = unix_to_human(time(), TRUE, 'us');
        $TodayDate = date("d/m/Y");

        // $Tiposconv = $this->Tiposconvenios_model->GetList();
        $Tiposnego = $this->Tiposnego_model->GetList();
        $Causasnopago = $this->Causasnopago_model->GetList();
        $Data['fecha_neg']= $TodayDate;
        $Data['title'] = "Crear nuevo convenio";
        $Data['Tiposnego'] = $Tiposnego;
        $Data['Causasnopago'] = $Causasnopago;
        $this->load->view('layouts/_menu', $Data);
        $this->load->view('Convenios/Create', $Data);
        $this->load->view('layouts/footer');
    }

    function CreatePost(){
        if(!VerificarPermisos($this->session->UID, "Convenios", "Create")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a este 
                catalogo. Contacte al administrador.');
            redirect("");
        }
        if($this->input->post()){

                $TodayDate = unix_to_human(time(), TRUE, 'mx');
                $LoggedUserId = $this->session->UID;
                if($this->input->post("Plasticopago")){
                    $Plasticopago=$this->input->post("Plasticopago");
                }else{
                    $Plasticopago='';
                }
                $Cuenta= $this->input->post("Cuenta");
                $Fechatmp= $this->input->post("Fecha_neg");
                $FechaExplode = explode("/", $Fechatmp);
                $Fechaneg = new DateTime($FechaExplode[2]."-".$FechaExplode[1]."-".$FechaExplode[0]);
                $Fec_ape = new DateTime($FechaExplode[2]."-".$FechaExplode[1]."-".$FechaExplode[0]);
                $Folio_pre = "LP".$FechaExplode[1].substr($FechaExplode[2],2,2);
                $Detalle = $this->input->post("lstDetalle");
                $Folio_cons = $this->Convenios_model->CheckLastFolio($Folio_pre)+1;

                $NewConv = array(
                    "Dmssnum" => $this->input->post("Dmssnum"),
                    "Dmacct" => $this->input->post("Cuenta"),
                    "Uxmescast" => $this->input->post("Mes_castigo"),
                    "Nombre" => $this->input->post("Nombre"),
                    "Fecha_neg" => $Fechaneg->format("Y-m-d"),
                    "Fecha_emi" => $TodayDate,
                    "Dmcurbal" => str_replace(',','',$this->input->post("Saldo_curbal")),
                    "Uxtot_adeu" => str_replace(',','',$this->input->post("Saldo_act")),
                    "Dmpayoff" => str_replace(',','',$this->input->post("Saldo_vencido_krn")),
                    "Uxsdo_vi_v" => 0,
                    "Uxcap_cred" => str_replace(',','',$this->input->post("Mto_principal")),
                    "Uxint_cred" => str_replace(',','',$this->input->post("Int_ordinarios")),
                    "Uxmora_cred" => str_replace(',','',$this->input->post("Int_moratorios")),
                    "Uxexig_cre" => str_replace(',','',$this->input->post("Conc_exigibles")),
                    "Dmamtdlq" => str_replace(',','',$this->input->post("Saldo_vencido_tdc")),
                    "U6pag_min" => str_replace(',','',$this->input->post("Pago_minimo")),
                    "U6sdo_cort" => str_replace(',','',$this->input->post("Saldo_corte")),
                    "plastico_pago" => $Plasticopago,
                    "billing" => $this->input->post("Billing"),
                    "Fec_ape" => $Fec_ape->format("Y-m-d"),
                    "Cepa" => $this->input->post("Cepa"),
                    "Modalidad" => $this->input->post("Modalidad"),
                    "Macro_gen" => $this->input->post("Macro_gen"),
                    "Gpo_meta" => $this->input->post("Gpo_meta"),
                    "Spei_num_key" => $this->input->post("Spei_num_key"),
                    "Portafolio" => $this->input->post("Portafolio"),
                    "Mto_principal" => str_replace(',','',$this->input->post("Mto_principal")),
                    "Int_ordinario" => str_replace(',','',$this->input->post("Int_ordinarios")),
                    "Moratorios" => str_replace(',','',$this->input->post("Int_moratorios")),
                    "Comp_exigible" => str_replace(',','',$this->input->post("Conc_exigibles")),
                    "Total_adeudo" => str_replace(',','',$this->input->post("Total_adeudo")),
                    "Saldo_contable" => str_replace(',','',$this->input->post("Saldo_contable")),
                    "Moneda" => $this->input->post("Moneda"),
                    "Cliente" => $this->input->post("Clienteweb"),
                    "Producto" => $this->input->post("Productoweb"),
                    "Plataforma" => $this->input->post("Plataforma"),
                    "Etapa" => $this->input->post("Etapa"),
                    "Restitucion" => $this->input->post("Restitucion"),
                    "Quita_max_st" => $this->input->post("Quita_st"),
                    "Quita_max_sc" => $this->input->post("Quita_sc"),
                    "Quita_neg" => $this->input->post("Quita_neg"),
                    "Estado_conv" => 0,
                    "Folio_pre" => $Folio_pre,
                    "Folio_cons" => $Folio_cons,
                    "Total_pago" => str_replace(',','',$this->input->post("Totalpago")),
                    "Saldo_usado" => $this->input->post("Saldo_usado"),
                    "Observaciones" => $this->input->post("Observaciones"),
                    "Telefono" => $this->input->post("Telefono"),
                    "Tipo_tel" => $this->input->post("Tipo_tel"),
                    "Email" => $this->input->post("Email"),
                    "Cancelado" => 0,
                    "Excepcion" => $this->input->post("hdExcepcion"),
                    "Fechas_esp" => $this->input->post("hdFechasesp"),
                    "Auto_excep" => $this->input->post("hdAutoexcepcion"),
                    "Tipo_negoid" => $this->input->post("Clavenego"),
                    "Tipo_convid" => $this->input->post("Tipo_convid"),
                    "Tipo_convid_alt" => $this->input->post("Tipo_convid_alt"),
                    "Periodicidad" => $this->input->post("Periodicidad"),
                    "Llamada" => $this->input->post("Llamada"),
                    "Causanp" => $this->input->post("Causanopago"),
                    "Accion" => 'CDT',
                    "Resultado" => 'PP',
                    "Peso" => '+A07',
                    "Grupoconv" => $this->input->post("Grupoconv"),
                    "Agente" => $this->input->post("Agente"),
                    "CreatedBy" => $LoggedUserId,
                    "CreatedDate" => $TodayDate,
                    "UpdatedBy" => $LoggedUserId,
                    "UpdatedDate" => $TodayDate
                );

                $Convenio_id = $this->Convenios_model->Create($NewConv);

                $TotalMovimientosAgregados = 0;
                foreach($Detalle as $Item)
                {
                    if($Item["Active"] == "true" || $Item["Active"] == 1)
                    {
                        if(!empty($Item["Fecha"])  && $Item["Pago"] >0 )
                        {               
                            $Fechatmp= $Item["Fecha"];
                            $FechaExplode = explode("/", $Fechatmp);
                            $Fechapag = new DateTime($FechaExplode[2]."-".$FechaExplode[1]."-".$FechaExplode[0]);

                            $DetalleConvenio = array(
                                "Convenio_id" => $Convenio_id,
                                "Fecha_pago" => $Fechapag->format("Y-m-d"),
                                "Importe_pago" => $Item["Pago"]
                            );

                            $resultdet = $this->Convdeta_model->Create($DetalleConvenio);
                            $TotalMovimientosAgregados++;
                        }
                    }
                }

                //Agregar movimiento a bitacora
                $BitacoraMovimiento = array(
                    "Log_modulo" => 1,                  // Convenios
                    "Log_codigoevento" => 11,           // Create
                    "Log_usuario" => $LoggedUserId,
                    "Log_descrip" => "Se creo simulacion de convenio ".$Folio_pre."-".str_pad($Folio_cons, 4, "0", STR_PAD_LEFT)." para la cuenta: ".$this->input->post("Cuenta")."/".$this->input->post("Nombre"),
                    "Log_fechahora" => $TodayDate,
                    "Log_idreferencia" => $Convenio_id
                );
                $result = $this->Bitacora_model->Create($BitacoraMovimiento);

                // si hubo excepcion se loguea la autorizacion
                if($this->input->post("hdAutoexcepcion") != null && $this->input->post("hdAutoexcepcion") != ""){
                    $BitacoraMovimiento = array(
                        "Log_modulo" => 1,                  // Convenios
                        "Log_codigoevento" => 18,           // Autorizacion de excepcion durante la creacion
                        "Log_usuario" => $this->input->post("hdAutoexcepcion"),
                        "Log_descrip" => "Se autorizo excepcion en el convenio ".$Folio_pre."-".str_pad($Folio_cons, 4, "0", STR_PAD_LEFT).". Autorizado por: ".$this->input->post("hdAutoexcepcion"),
                        "Log_fechahora" => $TodayDate,
                        "Log_idreferencia" => $Convenio_id
                    );
                    $result = $this->Bitacora_model->Create($BitacoraMovimiento);
                }                

                if($Convenio_id){
                    $this->session->set_flashdata('message_index', 'Se guardo exitosamente el convenio');
                    $this->session->set_flashdata('Convenio_id', $Convenio_id);
                    $this->session->set_flashdata('class', 'success');
                    redirect("Convenios");
                }else{
                    $this->session->set_flashdata('message_create', 'Hubo un error al registrar');
                    $this->session->set_flashdata('class', 'danger');
                }

        }
    }

    function Details($Id = 0){
        if(!VerificarPermisos($this->session->UID, "Convenios", "Details")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a esta opcion. Contacte al administrador.');
            redirect("");
        }

        $Convenio = $this->Convenios_model->GetById($Id);

        if(!$Convenio){
            $Data['heading'] = "Page Not Found";
            $Data['message'] = "The page you requested was not found.";
            $this->load->view('errors/html/error_general', $Data);
            return;
        }

        $Tblpagos = $this->Convdeta_model->GetDetailsById($Id);
        $Data["Createdby"] = $this->Users_model->GetByUserName($Convenio->CreatedBy)->Name;
        $Data["Updatedby"] = $this->Users_model->GetByUserName($Convenio->UpdatedBy)->Name;
        $Data['title'] = "Detalles del convenio";
        $Data['Convenio'] = $Convenio;
        $Data['Tblpagos'] = $Tblpagos;
        $this->load->view('layouts/_menu', $Data);
        $this->load->view('Convenios/Details', $Data);
        $this->load->view('layouts/footer');
    }

    function Edit($Id = 0){
        if(!VerificarPermisos($this->session->UID, "Convenios", "Edit")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a este catalogo. Contacte al administrador.');
            redirect("");
        }
        $Convenio = $this->Convenios_model->GetById($Id);

        if(!$Convenio)
        {
            $Data['heading'] = "Page Not Found";
            $Data['message'] = "The page you requested was not found.";
            $this->load->view('errors/html/error_general', $Data);
            return;
        }
        
        $Tblpagos = $this->Convdeta_model->GetDetailsById($Id);
        $Totalpago = $this->Convdeta_model->GetTotalPagoById($Id);
        $Tiposnego = $this->Tiposnego_model->GetList();
        $Causasnopago = $this->Causasnopago_model->GetList();
        $Datostiponego = $this->Tiposnego_model->GetByClave($Convenio->Tipo_negoid);

        //color:#FF0000

        if($Convenio->Excepcion ){
            $lblQuitaneg = "% de quita negociada: ".number_format($Convenio->Quita_neg,2)." (EXCEPCION)";
            $styQuitaneg = "color:red;";
        }else{
            $lblQuitaneg = "% de quita negociada: ".number_format($Convenio->Quita_neg,2);
            $styQuitaneg = "";
        }
        $lblImporte = "Importe total del convenio: ".number_format($Convenio->Total_pago,2);

        $Textosaldocontable = "Contable: ".number_format($Convenio->Dmcurbal,2);
        $Textosaldototal = "Total: ".number_format($Convenio->Uxtot_adeu,2);

        $FechaHoraOriginal = $Convenio->Fecha_neg;
        $Hora = substr($FechaHoraOriginal,11,8);
        $Fecha_neg = substr($FechaHoraOriginal,8,2)."/".substr($FechaHoraOriginal,5,2)."/".substr($FechaHoraOriginal,0,4);
        
        $Data["Createdby"] = $this->Users_model->GetByUserName($Convenio->CreatedBy)->Name;
        $Data["Updatedby"] = $this->Users_model->GetByUserName($Convenio->UpdatedBy)->Name;
        $Data['title'] = "Editar/Autorizar convenio";
        $Data['Tiposnego'] = $Tiposnego;
        $Data['Datostiponego'] = $Datostiponego;
        $Data['Causasnopago'] = $Causasnopago;
        $Data['Convenio'] = $Convenio;
        $Data['Tblpagos'] = $Tblpagos;
        $Data['Totalpago'] = $Totalpago;
        $Data['lblQuitaneg'] =  $lblQuitaneg;
        $Data['styQuitaneg'] =  $styQuitaneg;
        $Data['lblImporte'] = $lblImporte;
        $Data['Fecha_neg'] = $Fecha_neg;
        $Data['Textosaldocontable'] = $Textosaldocontable;
        $Data['Textosaldototal'] = $Textosaldototal;
        $this->load->view('layouts/_menu', $Data);
        $this->load->view('Convenios/Edit', $Data);
        $this->load->view('layouts/footer');

    }

    function EditPost(){
        if(!VerificarPermisos($this->session->UID, "Convenios", "Edit")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a este catalogo. Contacte al administrador.');
            redirect("");
        }
        if($this->input->post()){
            $ConvenioOriginal = $this->Convenios_model->GetById($this->input->post("Idconvenio"));
            $TodayDate = unix_to_human(time(), TRUE, 'mx');
            $LoggedUserId = $this->session->UID;
            $Cuenta= $this->input->post("Cuenta");
            $Fechatmp= $this->input->post("Fecha_neg");
            $FechaExplode = explode("/", $Fechatmp);
            $Fechaneg = new DateTime($FechaExplode[2]."-".$FechaExplode[1]."-".$FechaExplode[0]);

            $Detalle = $this->input->post("lstDetalle");

            $Conv_modif = array(
                    "Id" => $this->input->post("Idconvenio"),
                    "Fecha_neg" => $Fechaneg->format("Y-m-d"),
                    "Fecha_emi" => $TodayDate,
                    "Quita_neg" => $this->input->post("Quita_neg"),
                    "Estado_conv" => $this->input->post("hdAutorizado"),
                    "Total_pago" => str_replace(',','',$this->input->post("Totalpago")),
                    "Saldo_usado" => $this->input->post("Saldo_usado"),
                    "Observaciones" => $this->input->post("Observaciones"),
                    "Telefono" => $this->input->post("Telefono"),
                    "Tipo_tel" => $this->input->post("Tipo_tel"),
                    "Email" => $this->input->post("Email"),
                    "Cancelado" => 0,
                    "Fechas_esp" => $this->input->post("hdFechasesp"),
                    "Tipo_negoid" => $this->input->post("Clavenego"),
                    "Tipo_convid" => $this->input->post("Tipo_convid"),
                    "Tipo_convid_alt" => $this->input->post("Tipo_convid_alt"),
                    "Periodicidad" => $this->input->post("Periodicidad"),
                    "Llamada" => $this->input->post("Llamada"),
                    "Causanp" => $this->input->post("Causanopago"),
                    "Accion" => 'CDT',
                    "Resultado" => 'PP',
                    "Peso" => '+A07',
                    "Grupoconv" => $this->input->post("Grupoconv"),
                    "UpdatedBy" => $LoggedUserId,
                    "UpdatedDate" => $TodayDate
            );
          
            $result = $this->Convenios_model->Update($Conv_modif);

            $this->Convdeta_model->DeleteByIdConv($this->input->post("Idconvenio"));

            $TotalMovimientosAgregados = 0;
            foreach($Detalle as $Item)
            {
                if($Item["Active"] == "true" || $Item["Active"] == 1)
                {
                    if(!empty($Item["Fecha"])  && $Item["Pago"] >0 )
                    {               
                        $Fechatmp= $Item["Fecha"];
                        $FechaExplode = explode("/", $Fechatmp);
                        $Fechapag = new DateTime($FechaExplode[2]."-".$FechaExplode[1]."-".$FechaExplode[0]);

                        $DetalleConvenio = array(
                            "Convenio_id" => $this->input->post("Idconvenio"),
                            "Fecha_pago" => $Fechapag->format("Y-m-d"),
                            "Importe_pago" => $Item["Pago"]
                        );

                        $resultdet = $this->Convdeta_model->Create($DetalleConvenio);
                        $TotalMovimientosAgregados++;
                    }
                }
            }

            //Agregar movimiento a bitacora
            $BitacoraMovimiento = array(
                "Log_modulo" => 1,                  // Convenios
                "Log_codigoevento" => 12,           // Edit
                "Log_usuario" => $LoggedUserId,
                "Log_descrip" => "Se modifico simulacion de convenio ".$ConvenioOriginal->Folio_pre."-".str_pad($ConvenioOriginal->Folio_cons, 4, "0", STR_PAD_LEFT)." para la cuenta: ".$this->input->post("Cuenta")."/".$this->input->post("Nombre"),
                "Log_fechahora" => $TodayDate,
                "Log_idreferencia" => $this->input->post("Idconvenio")
            );
            $result = $this->Bitacora_model->Create($BitacoraMovimiento);

            // si hubo excepcion se loguea la autorizacion de la excepcion
            if($this->input->post("hdExcepcion") == 1 || $this->input->post("hdExcepcion") =="1"){

                // Se actualiza la excepcion en el master
                $Conv_modif = array(
                        "Id" => $this->input->post("Idconvenio"),
                        "Excepcion" => $this->input->post("hdExcepcion"),
                        "Auto_excep" => $this->input->post("hdAutoexcepcion")
                );          
                $result = $this->Convenios_model->Update($Conv_modif);
                //

                $BitacoraMovimiento = array(
                    "Log_modulo" => 1,                  // Convenios
                    "Log_codigoevento" => 19,           // Autorizacion de excepcion durante la edicion o autorizacion
                    "Log_usuario" => $this->input->post("hdAutoexcepcion"),
                    "Log_descrip" => "Se autorizo excepcion en el convenio ".$ConvenioOriginal->Folio_pre."-".str_pad($ConvenioOriginal->Folio_cons, 4, "0", STR_PAD_LEFT).". Autorizado por: ".$this->input->post("hdAutoexcepcion")." durante el proceso de autorizacion.",
                    "Log_fechahora" => $TodayDate,
                    "Log_idreferencia" => $this->input->post("Idconvenio")
                );
                $result = $this->Bitacora_model->Create($BitacoraMovimiento);
            }                

            // si el convenio fue autorizado se loguea
            if($this->input->post("hdAutorizado") == 1 || $this->input->post("hdAutorizado") =="1"){
                $BitacoraMovimiento = array(
                    "Log_modulo" => 1,                  // Convenios
                    "Log_codigoevento" => 13,           // Autorizacion del convenio
                    "Log_usuario" => $this->input->post("hdAutoexcepcion"),
                    "Log_descrip" => "Se autorizo el convenio ".$ConvenioOriginal->Folio_pre."-".str_pad($ConvenioOriginal->Folio_cons, 4, "0", STR_PAD_LEFT).". Autorizado por: ".$LoggedUserId,
                    "Log_fechahora" => $TodayDate,
                    "Log_idreferencia" => $this->input->post("Idconvenio")
                );
                $result = $this->Bitacora_model->Create($BitacoraMovimiento);
            }                

            if($result){
                $this->session->set_flashdata('message_index', 'Se modifico exitosamente el convenio');
                $this->session->set_flashdata('class', 'success');
                redirect("Convenios");
            }else{
                $this->session->set_flashdata('message_edit', 'Hubo un error al registrar');
                $this->session->set_flashdata('class', 'danger');
            }
        }

    }

    function Delete(){
        if(!VerificarPermisos($this->session->UID, "Convenios", "Delete")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a esta opción. Contacte al administrador.');
            redirect("");
        }
        if($this->input->post())
        {
            $ConvenioOriginal = $this->Convenios_model->GetById($this->input->post("Idconvenio"));
            $TodayDate = unix_to_human(time(), TRUE, 'mx');
            $LoggedUserId = $this->session->UID;

            $CancelConv = array(
                "Id" => $this->input->post("Idconvenio"),
                "Estado_conv" => 99,
                "Cancelado" => 1,
                "DeletedBy" => $LoggedUserId,
                "DeletedDate" => $TodayDate
            );
          
            $result = $this->Convenios_model->Update($CancelConv);

            $Detalle = $this->Convdeta_model->GetDetailsById($this->input->post("Idconvenio"));

            foreach($Detalle as $Item)
            {
                $CancelDetail = array(
                    "Id" => $Item->Id,
                    "Cancelado" => 1
                );
                $this->Convdeta_model->CancelById( $CancelDetail );
            }

            if($result){
                $this->session->set_flashdata('message_index', 'Se canceló exitosamente el convenio');
                $this->session->set_flashdata('class', 'success');
                redirect("Convenios");
            }else{
                $this->session->set_flashdata('message_details', 'Hubo un error al cancelar');
                $this->session->set_flashdata('class', 'danger');
            }
            $Data["CreatedBy"] = $this->Users_model->GetByUserName($OriginalObra->CreatedBy)->Name;
            $Data["UpdatedBy"] = $this->Users_model->GetByUserName($OriginalObra->UpdatedBy)->Name;
            $Data['title'] = "Cancelar convenio";
            $Data['Convenio'] = $ConvenioOriginal;
            $this->load->view('layouts/_menu', $Data);
            $this->load->view('Convenios/Details', $Data);
            $this->load->view('layouts/footer');   
        }
    }

//
    function AutocompleteClave(){
        $term = $this->input->get("term");
        $result = $this->Convenios_model->SearchByClave($term);
        echo json_encode($result);
    }

    function AutocompleteNombre(){
        $term = $this->input->get("term");
        $result = $this->Convenios_model->SearchByNombre($term);
        echo json_encode($result);
    }

    function Fechaneg(){
        $fechapost = $this->input->get("Fechaneg");
        $fecha = str_replace('/', '-', $fechapost);
        $fechaneg_tmp =  date("d-m-Y",strtotime($fecha));
        $fechaneg = date_create_from_format('d-m-Y', $fechaneg_tmp);

        $hoy_tmp=date("d-m-Y");
        $hoy = date_create_from_format('d-m-Y', $hoy_tmp);

        $ayer_tmp =  date("d-m-Y",strtotime($hoy_tmp."- 1 days"));
        $ayer = date_create_from_format('d-m-Y', $ayer_tmp);

        $diferencia = date_diff($fechaneg, $hoy);
        $diasdif = intval($diferencia->format('%R%a'));        

        $ObjectResponse['errormsg'] ='';

        if($diasdif > 1 || $diasdif <0 ){
            $ObjectResponse['errormsg'] ='Solo se permiten negociaciones con fecha de ayer o de hoy.';
        }

        echo json_encode($ObjectResponse);

    }

    function ValidaFecha(){

        $partida = $this->input->get("Partida");
        $totpart = $this->input->get("Totpart");
        $mismomes = $this->input->get("Mismomes");
        $fechasesp = $this->input->get("Fechasesp");

        $fechaneg_post = $this->input->get("Fechaneg");
        $fecha1 = str_replace('/', '-', $fechaneg_post);
        $fechaneg_tmp =  date("d-m-Y",strtotime($fecha1));
        $fechaneg = date_create_from_format('d-m-Y', $fechaneg_tmp);
        $mes_nego =  date("m",strtotime($fecha1));

        $fechapago_post = $this->input->get("Fechapago");
        $fecha2 = str_replace('/', '-', $fechapago_post);
        $fechapago_tmp =  date("d-m-Y",strtotime($fecha2));
        $fechapago = date_create_from_format('d-m-Y', $fechapago_tmp);
        $mes_pago =  date("m",strtotime($fecha2));

        $mas5dias =  date("d-m-Y",strtotime($fecha1."+ 5 days"));
        $mas5 = date_create_from_format('d-m-Y', $mas5dias);

        $diferencia = date_diff($fechaneg, $fechapago);
        $diasdif = intval($diferencia->format('%R%a'));

        $ObjectResponse['errormsg'] ='';

        // var_dump($fechasesp);

        // $ObjectResponse['errormsg'] ='El numero de partida es: '.$partida;

        if( ($totpart == 1 && $partida == 0) || $partida == 1 ){

            if($mes_pago != $mes_nego && $fechasesp !="1" && $fechasesp !=1){
                $ObjectResponse['errormsg'] ='La fecha de pago inicial debe quedar dentro del mes actual.';
            }

            if($diasdif < 0){
                $ObjectResponse['errormsg'] ='La fecha de pago inicial no puede ser anterior a la fecha de la negociacion.';
            }else{
                if($diasdif > 5 && $fechasesp !="1" && $fechasesp !=1){
                    $ObjectResponse['errormsg'] ='La fecha de pago inicial no debe exceder 5 dias a la fecha de negociacion.';
                }
            }

        }else{
            if($diasdif < 0){
                $ObjectResponse['errormsg'] ='La fecha de pago no puede ser anterior a la fecha de la negociacion.';
            }else{
                if($diasdif > 365){
                    $ObjectResponse['errormsg'] ='La fecha de pago subsecuente no debe exceder los 365 dias a la fecha de negociacion.';
                }
            }            
        }

        if( (($mismomes == 1 || $mismomes == "1") && $mes_pago != $mes_nego && $fechasesp !="1" && $fechasesp !=1 )){
            $ObjectResponse['errormsg'] ='Para este tipo de negociacion, todos los pagos deben quedar dentro del mes actual.';
        }

        echo json_encode($ObjectResponse);

    }
//
    function Datostiponego(){
        $Idnego = $this->input->get("Idnego");
        $Numpdto = $this->input->get("Numpdto");
        $Cuenta = $this->input->get("Cuenta");
        $Moneda = $this->input->get("Moneda");
        $Quitasc = $this->input->get("Quitasc");
        $Quitast = $this->input->get("Quitast");
        $Prefijo = "";
        $Tipodeproducto = "";

        // var_dump($Numpdto, $Moneda);

        // Aplicar criterios para determinar el modelo de carta a usar
        if(strlen($Cuenta) >= 16){                              // Para TDC
            $Cuenta16 = substr($Cuenta,-16);
            $Prefijo = substr($Cuenta16,0,6);
            if($Prefijo == "199199")   {                        // Para CONSUMER
                $Tipodeproducto = "CON";
            }else{
                $Tipodeproducto = "TDC";
            }
        }else{
            $Tipodeproducto = "KRN";                            // Para Kroner
        }

        if(($Numpdto=="45" || $Numpdto=="48") && $Moneda=="44"){      // Para Hipotecario
            $Tipodeproducto = "HIP";
        }

        $ObjectResponse['errormsg'] ='';
        $result_con = $this->Tiposnego_model->GetByClave($Idnego);

        if($result_con){
            if($Quitasc == 0 && $Quitast == 0 && $result_con->Con_descuento == 1){
                $ObjectResponse['errormsg'] ='La cuenta no califica para ninguna negociacion con descuento.';
            }else{
                $ObjectResponse['clavecrm'] = $result_con->Clavecrm;
                $ObjectResponse['solo_parcial'] = $result_con->Solo_parcial;
                $ObjectResponse['plazo_maximo'] = $result_con->Plazo_maximo;
                $ObjectResponse['mismo_mes'] = $result_con->Mismo_mes;
                $ObjectResponse['pct_antpo'] = $result_con->Pct_antpo;
                $ObjectResponse['nombre_nego'] = $result_con->Nombre;
                $ObjectResponse['con_descuento'] = $result_con->Con_descuento;
                $ObjectResponse['con_excepcion'] = $result_con->Con_excepcion;

                switch ($Tipodeproducto) {
                    case "TDC":
                        $ObjectResponse['tipo_convid'] = $result_con->Idcarta_tdc;
                        break;
                    case "KRN":
                        $ObjectResponse['tipo_convid'] = $result_con->Idcarta_krn;
                        break;
                    case "CON":
                        $ObjectResponse['tipo_convid'] = $result_con->Idcarta_con;
                        break;
                    case "HIP":
                        $ObjectResponse['tipo_convid'] = $result_con->Idcarta_hip;
                        break;
                    default:
                        $ObjectResponse['tipo_convid'] = 0;
                }
            }
        }else{
            $ObjectResponse['errormsg'] ='Hubo error al consultar el tipo de negociacion, avise al administrador.'; 
        }
        echo json_encode($ObjectResponse);
    }

//
    function Consultarcuenta(){
        $Cuenta = $this->input->get("Cuenta");
        $Con_activo = false;

        $result_acc = $this->Convenios_model->GetByCuenta($Cuenta);
        if($result_acc){
            $result_date = $this->Convdeta_model->GetLastDateById($result_acc->Id);
            if($result_date){
                    $hoy_tmp=date("Y-m-d");
                    $hoy = date_create_from_format('Y-m-d', $hoy_tmp);
                    $lastdate = date_create_from_format('Y-m-d', $result_date->Fecha_pago);
                    if($lastdate >= $hoy){
                        $Con_activo = true;
                        $ObjectResponse['errormsg'] ='La cuenta '.$Cuenta.' ya tiene un convenio activo.';
                    }
            }
        }

        if(!$Con_activo){
            $ObjectResponse['errormsg'] ='';
            $Cuentas = $this->Altitude_model->GetProfile($Cuenta);
            if($Cuentas){
                foreach($Cuentas as $result) {
                    // Tomamos los datos del result de contact_profile
                    $ObjectResponse['first'] = $result->first;
                    // $ObjectResponse['plasticopago'] = $result->title;
                    $ObjectResponse['status'] = '';
                    $ObjectResponse['plataforma'] = '';


                    // Tomamos el easycode
                    $easycode=$result->code;

                    if($result->directory == 42) // Cuenta de Kroner
                    {
                        $resultkrn = $this->Altitude_model->GetDir42($easycode);
                        if($resultkrn){
                            
                            $ObjectResponse['dmssnum'] = $resultkrn->no_cliente;
                            $ObjectResponse['mes_castigo'] = $resultkrn->mes_castigo;
                            $ObjectResponse['plasticopago'] = $Cuenta;                  // en Kroner la cuenta es la misma para realizar el pago
                            $ObjectResponse['plataforma'] = 'KRN';

                            $Fechatmp= $resultkrn->fecha_apertura;
                            $FechaExplode = explode("/", $Fechatmp);
                            $Fec_ape= new DateTime($FechaExplode[2]."-".$FechaExplode[1]."-".$FechaExplode[0]);
                            $ObjectResponse['fec_ape'] = $Fec_ape->format("d/m/Y");

                            $FechaActual = date('Y-m-d'); // Hoy
                            $datetime1 = date_create($FechaActual);
                            $datetime2 = date_create($Fec_ape->format("Y-m-d"));
                            $intervalo = date_diff($datetime1, $datetime2);                            
                            $Dias_ape = $intervalo->format('%a');

                            $ObjectResponse['saldo_total'] = $resultkrn->total_adeudo_krn;
                            $ObjectResponse['saldo_curbal'] = $resultkrn->saldo_al_dia_o_contable_krn;

                            $ObjectResponse['pago_minimo'] = 0;
                            $ObjectResponse['saldo_corte'] = 0;
                            $ObjectResponse['saldo_vencido_tdc'] = 0;

                            $ObjectResponse['mto_principal'] = $resultkrn->monto_principal_krn;
                            $ObjectResponse['int_ordinarios'] = $resultkrn->interes_ordinario_krn;
                            $ObjectResponse['int_moratorios'] = $resultkrn->moratorios_krn;
                            $ObjectResponse['conc_exigibles'] = $resultkrn->otros_exigibles_krn;
                            $ObjectResponse['saldo_vencido_krn'] = $resultkrn->saldo_vencido_krn;

                            $ObjectResponse['modalidad'] = intval($resultkrn->modalidad);
                            $ObjectResponse['macro_gen'] = $resultkrn->macro_gen;
                            $ObjectResponse['cepa'] = $resultkrn->cepa;
                            $ObjectResponse['moneda'] = $resultkrn->moneda;
                            $ObjectResponse['spei_num_key'] = $resultkrn->spei;
                            $ObjectResponse['gpo_meta'] = '';
                            $ObjectResponse['portafolio'] = $resultkrn->producto;
                            $ObjectResponse['clienteweb'] = $resultkrn->clienteweb;
                            $ObjectResponse['productoweb'] = $resultkrn->productoweb;
                            $ObjectResponse['etapa'] = $resultkrn->etapa;
                            $ObjectResponse['restitucion'] = $resultkrn->restitucion;
                            $ObjectResponse['billing'] = $Cuenta;
                            $ObjectResponse['agente'] = '';

                            $ObjectResponse['status'] = ($resultkrn->activo == 0) ? "INACTIVO" : "ACTIVO";
                            
                        }
                        if($ObjectResponse['status'] == 'ACTIVO'){
                            break;
                        }                                                
                    }

                    if($result->directory = 43) // Cuenta de CYBER (TDC Y OTROS)
                    {
                        $resulttdc = $this->Altitude_model->GetDir43($easycode);
                        if($resulttdc){
                            $ObjectResponse['dmssnum'] = $resulttdc->num_cis;
                            $ObjectResponse['mes_castigo'] = $resulttdc->mes_castig;
                            if(strlen($resulttdc->plastico2) > 16){
                                $ObjectResponse['plasticopago'] = substr($resulttdc->plastico2,-16);    
                            }else{
                                $ObjectResponse['plasticopago'] = $resulttdc->plastico2;
                            }
                            $ObjectResponse['plataforma'] = 'CYB';

                            $Fechatmp= $resulttdc->feape;
                            $FechaExplode = explode("/", $Fechatmp);
                            $Fec_ape= new DateTime($FechaExplode[2]."-".$FechaExplode[1]."-".$FechaExplode[0]);
                            $ObjectResponse['fec_ape'] = $Fec_ape->format("d/m/Y");

                            $FechaActual = date('Y-m-d'); // Hoy
                            $datetime1 = date_create($FechaActual);
                            $datetime2 = date_create($Fec_ape->format("Y-m-d"));
                            $intervalo = date_diff($datetime1, $datetime2);                            
                            $Dias_ape = $intervalo->format('%a');

                            $ObjectResponse['saldo_total'] = $resulttdc->saldototal;
                            $ObjectResponse['saldo_curbal'] = $resulttdc->saldototal;

                            $ObjectResponse['pago_minimo'] = $resulttdc->pagmin;
                            $ObjectResponse['saldo_corte'] = $resulttdc->sdocont;
                            $ObjectResponse['saldo_vencido_tdc'] = $resulttdc->tot_venci;

                            $ObjectResponse['mto_principal'] = $resulttdc->con_mtoprincipal;
                            $ObjectResponse['int_ordinarios'] = $resulttdc->con_intordinario;
                            $ObjectResponse['int_moratorios'] = $resulttdc->con_moratorio;
                            $ObjectResponse['conc_exigibles'] = $resulttdc->con_compexigible;
                            $ObjectResponse['int_moratorios'] = $resulttdc->con_moratorio;
                            $ObjectResponse['conc_exigibles'] = $resulttdc->con_compexigible;
                            $ObjectResponse['total_adeudo'] = $resulttdc->con_totaladeudo;
                            $ObjectResponse['saldo_contable'] = $resulttdc->con_saldocontable;

                            $ObjectResponse['saldo_vencido_krn'] = 0;

                            $ObjectResponse['modalidad'] = 0;
                            $ObjectResponse['macro_gen'] = '';
                            $ObjectResponse['cepa'] = $resulttdc->cepa;
                            $ObjectResponse['moneda'] = 1;
                            $ObjectResponse['spei_num_key'] = $resulttdc->spei;
                            $ObjectResponse['gpo_meta'] = $resulttdc->gpo_meta;
                            $ObjectResponse['portafolio'] = '';
                            $ObjectResponse['clienteweb'] = $resulttdc->clienteweb;
                            $ObjectResponse['productoweb'] = $resulttdc->productoweb;
                            $ObjectResponse['etapa'] = $resulttdc->etapa;
                            $ObjectResponse['restitucion'] = $resulttdc->restitucion;
                            $ObjectResponse['billing'] = $resulttdc->biling;
                            $ObjectResponse['agente'] = $resulttdc->agente;

                            $ObjectResponse['status'] = ($resulttdc->activo == 0) ? "INACTIVO" : "ACTIVO";
                        }
                        if($ObjectResponse['status'] == 'ACTIVO'){
                            break;
                        }                                                                                                            
                    }

                }

                // Excepcion: en caso de la modalidad 130006 SEGUROS DE AUTO, el producto se cambia a 44 para tomar las quita de AUTO
                if( $ObjectResponse['modalidad'] == 130006){
                    $Quita_pdto = 44;
                }else{
                    $Quita_pdto = $ObjectResponse['productoweb'];
                }
                $Quita_mesc = $ObjectResponse['mes_castigo'];

                $Idpdto = 0;
                $ObjectResponse['quita_st'] = 0;
                $ObjectResponse['quita_sc'] = 0;
                $ObjectResponse['quita_liqtot'] = 0;
                $ObjectResponse['quita_2a6'] = 0;
                $ObjectResponse['quita_7a12'] = 0;

                $Rowpdto = $this->Productos_model->GetByNumber($Quita_pdto);
                if($Rowpdto){
                    $Idpdto = $Rowpdto->Id;
                    // Tomamos las quitas normales
                    $Rowdiscount = $this->Quitas_model->GetDiscount($Idpdto, $Quita_mesc);
                    if($Rowdiscount){
                        $ObjectResponse['quita_st'] = $Rowdiscount->Quita_st;
                        $ObjectResponse['quita_sc'] = $Rowdiscount->Quita_sc;
                    }
                    // Tomamos las quitas a plazos
                    $RowdiscountPlazos = $this->Quitas_plazos_model->GetDiscount($Idpdto, $Quita_mesc);
                    if($RowdiscountPlazos){
                        $ObjectResponse['quita_liqtot'] = $RowdiscountPlazos->Quita_liqtot;
                        $ObjectResponse['quita_2a6'] = $RowdiscountPlazos->Quita_2a6;
                        $ObjectResponse['quita_7a12'] = $RowdiscountPlazos->Quita_7a12;
                        $ObjectResponse['quita_vigencia'] = $RowdiscountPlazos->Vigencia;
                    }
                }

                // Excepcion: en caso de TDC donde el campo agente trae estos valores no aplica quita por ser exempleados:
                // 035,326,339,727,729
                if( $ObjectResponse['productoweb'] == 40 && ($ObjectResponse['agente'] == '035' ||$ObjectResponse['agente'] == '326' ||$ObjectResponse['agente'] == '339' || $ObjectResponse['agente'] == '727' || $ObjectResponse['agente'] == '729')){
                    $ObjectResponse['quita_st'] = 0;
                    $ObjectResponse['quita_sc'] = 0;
                }

                if($ObjectResponse['status'] == 'ACTIVO'){

                    // if($ObjectResponse['cuenta_pan'] == '' || $ObjectResponse['cuenta_pan'] == null){
                    //     $Cuentapan = $this->Basepan_model->GetByCuenta12d($Cuenta);
                    //     if($Cuentapan){
                    //         $ObjectResponse['cuenta_pan'] = $Cuentapan->Cuenta_pan;
                    //     }
                    // }

                    $cap_int = intval($ObjectResponse['saldo_total']);

                    if($Dias_ape < 181){
                        $ObjectResponse['errormsg'] = 'Aun no transcurren mas de 180 dias desde la fecha de apertura: '.$ObjectResponse['fec_ape'].', no es posible generarle convenio a esta cuenta';
                    }

                    if($cap_int < 1){
                        $ObjectResponse['errormsg'] = 'El saldo capital de la cuenta es de: '.$ObjectResponse['saldo_cap'].', no es posible generarle convenio.';
                    }

                    echo json_encode($ObjectResponse);
                }else{
                    $ObjectResponse['errormsg'] ='La cuenta se encuentra inactiva en la base de datos';
                    echo json_encode($ObjectResponse);
                }

            }else{
                $ObjectResponse['errormsg'] ='No se encontró la cuenta en la base de datos';
                echo json_encode($ObjectResponse);
            }
        }else{
            echo json_encode($ObjectResponse);
        }
    }

    function GenerarPdf1() {            // TDC PAGO PARCIAL
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        // $pdf->setData($this->session->Empresa, $this->session->Rfc);
        $pdf->setData("LEGAXXI", "RFC999999XXX");
        $pdf->SetCreator('');
        $pdf->SetAuthor('LEGAXXI');
        $pdf->SetTitle('LEGAXXI');
        $pdf->SetSubject('CONVENIOS');
        $pdf->SetKeywords('');
 
        $pdf->SetHeaderData("logo_legaxxi_conv.png", 15, "LEGAXXI", "CONVENIOS", array(0,0,0), array(0,0,0));
        $pdf->setFooterData($tc = array(0, 0, 0), $lc = array(0, 0, 0));

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
 
        // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(10, PDF_MARGIN_TOP, 10);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
 
        // $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetAutoPageBreak(TRUE, 20);
 
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
 
 
        $pdf->setFontSubsetting(true);
 
        $pdf->SetFont('Helvetica', '', 8, '', true);
 
        $pdf->AddPage();

        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

        $Convenioid = $this->input->post("Convenioid");

        // Obtenemos los parametros generales del convenio
        $Parametros = $this->Parametros_model->GetUnique();

        // Datos del convenio y armado de tablas e informacion general
        $Hconvenio = $this->Convenios_model->GetById($Convenioid);
        // var_dump($Convenioid);

        // Este codigo es para subsanar un bug en el helper ConvertirNumeroALetra()
        // ya que no interpreta correctamente valores que no incluyan un entero 
        // es decir, etre entre 0 y .99 
        // if($Quita_cond >= 0 && $Quita_cond <1){
        //     $Quita_str = (string) $Quita_cond;
        //     $Decimals = substr( $Quita_str, strpos( $Quita_str, "." )+1, 2 );
        //     if($Decimals == ''){
        //         $Decimals = '00';
        //     }            
        //     $QC_enletra = 'Cero pesos '.$Decimals.'/100 M.N.';
        // }else{
        //     $QC_enletra = ConvertirNumeroALetra($Quita_cond); 
        // }

        $Nombreconvenio = $this->Tiposnego_model->GetNombreByid($Hconvenio->Tipo_negoid);

        // Detalle y armado de tabla de saldos
        $Tabla_saldos = '<table border=".5" align="center" bordercolor="black" cellspacing="0">';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">SALDO AL DIA</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Uxtot_adeu,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">PAGO MINIMO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->U6pag_min,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">SALDO AL ULTIMO CORTE</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->U6sdo_cort,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">SALDO VENCIDO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Dmamtdlq,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">PAGO ACORDADO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Total_pago,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">DESCUENTO SOBRE SALDO AL DIA</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">N/A</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">% DE DESCUENTO SOBRE TOTAL ADEUDO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">N/A</td>
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '</table>'; 


        //Detalle de pagos y armado de tabla de pagos
        $Tabla_pagos = '<table border=".5" align="center" bordercolor="black" cellspacing="0">';
        $Tabla_pagos = $Tabla_pagos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">Numero de pagos</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">Monto de pago</td>
                            <td style="border: .5px solid #000000; width: 150px; text-align:center">Fecha limite de pago</td>                            
                        </tr>';

        $Dconvenio = $this->Convdeta_model->GetDetailsById($Convenioid);

        $Interlin = 1;
        if($Dconvenio){

            $Totalitems = count($Dconvenio);

            if($Totalitems > 2){
                $Interlin = .5;
            }else{
                $Interlin = 1;
            }

            $Itemnumber = 1;
            foreach($Dconvenio as $Item) {
                    $FechaHoraOriginal = $Item->Fecha_pago;
                    $Hora = substr($FechaHoraOriginal,11,8);
                    $Fechapago = substr($FechaHoraOriginal,8,2).'/'.substr($FechaHoraOriginal,5,2).'/'.substr($FechaHoraOriginal,0,4);

                    if($Itemnumber == 1){
                        $Td_numpagos = '<td style="border: .5px solid #000000; width: 100px; vertical-align:middle; text-align:center; " rowspan="'.$Totalitems.'">'.$Totalitems.'</td>';
                    }else{
                        $Td_numpagos = '';
                    }

                    $Tabla_pagos = $Tabla_pagos . '<tr style="height: 30px; color:#000000;">'.$Td_numpagos.'
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Item->Importe_pago,2).'</td>
                            <td style="border: .5px solid #000000; width: 150px; text-align:center">'.$Fechapago.'</td>
                        </tr>';

                $Itemnumber++;

            }
        } 

        $Tabla_pagos = $Tabla_pagos . '</table>';     

        //Detalle de cabecera para datos generales del convenio
        $Tabla_head = '<table border="0" align="left" bordercolor="white" cellspacing="0">';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">FOLIO: '.$Hconvenio->Folio_pre."-".str_pad($Hconvenio->Folio_cons, 4, "0", STR_PAD_LEFT) .'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">AGENCIA: '.$Parametros->razon_soc.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">NEGOCIACION: '.$Nombreconvenio.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">TARJETA DE CREDITO: '.$Hconvenio->Dmacct.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">NOMBRE: '.$Hconvenio->Nombre.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '</table>';

        $TodayDate = unix_to_human(time(), TRUE, 'us');
        $TodayDate = date("d/m/Y H:i:s A", strtotime($TodayDate));

        $FechaHoraOriginal = $Hconvenio->Fecha_emi;
        $Hora = substr($FechaHoraOriginal,11,8);
        $Dia_emi = substr($FechaHoraOriginal,8,2);
        $Mes_emi = intval(substr($FechaHoraOriginal,5,2));
        $Anio_emi = substr($FechaHoraOriginal,0,4);

        $FechaHoraOriginal = $Hconvenio->Fecha_neg;
        $Hora = substr($FechaHoraOriginal,11,8);
        $Dia_neg = substr($FechaHoraOriginal,8,2);
        $Mes_neg = intval(substr($FechaHoraOriginal,5,2));
        $Anio_neg = substr($FechaHoraOriginal,0,4);        

        $Meses =['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

        //$pdf->SetFontSize(11);
        $image_file1 = 'img\logo_legaxxi_conv.png';
        $image_file2 = 'img\logo_HSBC_conv.png';
        $pdf->Image($image_file1, 10, 5, 0, 15, 'PNG', '', 'T', false, 100, '', false, false, 0, false, false, false);
        $pdf->Image($image_file2, 65, 5, 0, 15, 'PNG', '', 'T', false, 100, '', false, false, 0, false, false, false);
        $pdf->SetFont('Helvetica', '', 8, '', true);
        $pdf->writeHTML($Tabla_head, false, 0, true, 0);

        $pdf->Write(5,"", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->Write(5,"", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->SetFont('Helvetica', 'B', 8, '', true);
        $pdf->Write(5,"Carta Convenio de Pago", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->SetFont('Helvetica', '', 8, '', true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,$Parametros->cd_edo_expedicion." a ".$Dia_neg." de ".$Meses[$Mes_neg-1]. " de ".$Anio_neg.", se acuerda el pago del crédito ".$Hconvenio->Dmacct." entre agencia ".$Parametros->razon_soc." en nombre de HSBC y el Cliente ".$Hconvenio->Nombre, $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"A fin de celebrar el presente CONVENIO DE PAGO las partes pactan las siguientes:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"CLAUSULAS:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"I. El pago será realizado directamente al número de la Tarjeta de Crédito ".substr($Hconvenio->Dmacct,-16)." a nombre de ".$Hconvenio->Nombre." en cualquier sucursal de HSBC MÉXICO, S.A., INSTITUCIÓN DE BANCA MÚLTIPLE, GRUPO FINANCIERO HSBC, en días y horas hábiles como a continuación se detalla:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"II. El monto de Pago acordado y descrito a continuación le permitirá aplicarse como Pago parcial", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->writeHTML($Tabla_pagos, false, 0, true, 0);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"En caso de no poder realizar su pago en sucursal y en efectivo realícelo por transferencia a la clave interbancaria: ".$Hconvenio->Spei_num_key, $enlace="", $fondo=false, $alineacion="L", $nueva_linea=true);
         $pdf->Ln($Interlin);

        $pdf->Write(5,"Desglose del saldo:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->writeHTML($Tabla_saldos, false, 0, true, 0);
        $pdf->Write(5,"", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);

        $pdf->SetFont('Helvetica', '', 8, '', true);
        $pdf->Write(5,"III. En caso de incumplir con el/los pago/s descrito/s anteriormente en la fecha acordada, se dejará sin efecto el descuento o quita solicitada y en consecuencia procederá a aplicar los pagos realizados de acuerdo a los términos establecidos en el contrato de apertura de crédito respectivo y / o convenios modificatorios.", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);

        $pdf->SetFont('Helvetica', '', 8, '', true);
        $pdf->Write(5,"IV. Se acredito previo a la negociación, la identificación del cliente.", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
       
         $pdf->Ln($Interlin);
        $pdf->Write(5,"ATENTAMENTE", $enlace="", $fondo=false, $alineacion="C", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write( 5,$Parametros->cd_edo_expedicion." a ".$Dia_neg." de ".$Meses[$Mes_neg-1]. " de ".$Anio_neg, $enlace="", $fondo=false, $alineacion="C", $nueva_linea=true );
         $pdf->Ln($Interlin);
        $pdf->Write(5,"AGENCIA", $enlace="", $fondo=false, $alineacion="L", $nueva_linea=false);
        $pdf->Write(5,"CLIENTE", $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $sign = '<img src="'.$Parametros->imagen_firma_ag.'"  width="125" height="50">';
        $pdf->writeHTML($sign, false, 0, true, 0);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"_______________________________________", $enlace="", $fondo=false, $alineacion="", $nueva_linea=false);
        $pdf->Write(5,"_______________________________________", $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $pdf->Write(5, $Parametros->nombrefirma_ag, $enlace="", $fondo=false, $alineacion="", $nueva_linea=false);
        $pdf->Write(5,"C. ".$Hconvenio->Nombre, $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $pdf->Write(5,"Apoderado Legal de Legaxxi", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);

        $pdf->SetFont('Helvetica', '', 6, '', true);
        $pdf->writeHTML($Parametros->nota_final, true, 0, true, 0);

        $nombre_archivo = utf8_decode("Convenio_".$Hconvenio->Dmacct.".pdf");
        $pdf->Output($nombre_archivo, 'D');
    }

    function GenerarPdf2() {            // TDC LIQUIDACION PAGO UNICO
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        // $pdf->setData($this->session->Empresa, $this->session->Rfc);
        $pdf->setData("LEGAXXI", "RFC999999XXX");
        $pdf->SetCreator('');
        $pdf->SetAuthor('LEGAXXI');
        $pdf->SetTitle('LEGAXXI');
        $pdf->SetSubject('CONVENIOS');
        $pdf->SetKeywords('');
 
        $pdf->SetHeaderData("logo_legaxxi_conv.png", 15, "LEGAXXI", "CONVENIOS", array(0,0,0), array(0,0,0));
        $pdf->setFooterData($tc = array(0, 0, 0), $lc = array(0, 0, 0));

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
 
        // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(10, PDF_MARGIN_TOP, 10);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
 
        // $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetAutoPageBreak(TRUE, 20);
 
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
 
 
        $pdf->setFontSubsetting(true);
 
        $pdf->SetFont('Helvetica', '', 8, '', true);
 
        $pdf->AddPage();

        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

        $Convenioid = $this->input->post("Convenioid");

        // Obtenemos los parametros generales del convenio
        $Parametros = $this->Parametros_model->GetUnique();

        // Datos del convenio y armado de tablas e informacion general
        $Hconvenio = $this->Convenios_model->GetById($Convenioid);
        // var_dump($Convenioid);

        // Este codigo es para subsanar un bug en el helper ConvertirNumeroALetra()
        // ya que no interpreta correctamente valores que no incluyan un entero 
        // es decir, etre entre 0 y .99 
        // if($Quita_cond >= 0 && $Quita_cond <1){
        //     $Quita_str = (string) $Quita_cond;
        //     $Decimals = substr( $Quita_str, strpos( $Quita_str, "." )+1, 2 );
        //     if($Decimals == ''){
        //         $Decimals = '00';
        //     }            
        //     $QC_enletra = 'Cero pesos '.$Decimals.'/100 M.N.';
        // }else{
        //     $QC_enletra = ConvertirNumeroALetra($Quita_cond); 
        // }

        // Determinar importe de descuento de acuerdo al saldo utilizado
        $Nombreconvenio = $this->Tiposnego_model->GetNombreByid($Hconvenio->Tipo_negoid);

        $Descuento=0;
        if($Hconvenio->Saldo_usado = "T")       // Saldo total
        {
            $Descuento = $Hconvenio->Uxtot_adeu-$Hconvenio->Total_pago;
        }else{                                  // Saldo contable
            $Descuento = $Hconvenio->Dmcurbal-$Hconvenio->Total_pago;
        }
        // Detalle y armado de tabla de saldos
        $Tabla_saldos = '<table border=".5" align="center" bordercolor="black" cellspacing="0">';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">SALDO AL DIA</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Uxtot_adeu,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">PAGO MINIMO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->U6pag_min,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">SALDO AL ULTIMO CORTE</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->U6sdo_cort,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">SALDO VENCIDO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Dmamtdlq,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">PAGO ACORDADO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Total_pago,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">DESCUENTO SOBRE SALDO AL DIA</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Descuento,2).'</td>                          
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">% DE DESCUENTO SOBRE TOTAL ADEUDO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.number_format($Hconvenio->Quita_neg,2).'%</td> 
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '</table>'; 


        //Detalle de pagos y armado de tabla de pagos
        $Tabla_pagos = '<table border=".5" align="center" bordercolor="black" cellspacing="0">';
        $Tabla_pagos = $Tabla_pagos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">Numero de pagos</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">Monto de pago</td>
                            <td style="border: .5px solid #000000; width: 150px; text-align:center">Fecha limite de pago</td>                            
                        </tr>';

        $Dconvenio = $this->Convdeta_model->GetDetailsById($Convenioid);

        $Interlin = 1;
        if($Dconvenio){

            $Totalitems = count($Dconvenio);

            if($Totalitems > 2){
                $Interlin = .5;
            }else{
                $Interlin = 1;
            }

            $Itemnumber = 1;
            foreach($Dconvenio as $Item) {
                    $FechaHoraOriginal = $Item->Fecha_pago;
                    $Hora = substr($FechaHoraOriginal,11,8);
                    $Fechapago = substr($FechaHoraOriginal,8,2).'/'.substr($FechaHoraOriginal,5,2).'/'.substr($FechaHoraOriginal,0,4);

                    if($Itemnumber == 1){
                        $Td_numpagos = '<td style="border: .5px solid #000000; width: 100px; vertical-align:middle; text-align:center; " rowspan="'.$Totalitems.'">'.$Totalitems.'</td>';
                    }else{
                        $Td_numpagos = '';
                    }

                    $Tabla_pagos = $Tabla_pagos . '<tr style="height: 30px; color:#000000;">'.$Td_numpagos.'
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Item->Importe_pago,2).'</td>
                            <td style="border: .5px solid #000000; width: 150px; text-align:center">'.$Fechapago.'</td>
                        </tr>';

                $Itemnumber++;

            }
        } 

        $Tabla_pagos = $Tabla_pagos . '</table>';     

        //Detalle de cabecera para datos generales del convenio
        $Tabla_head = '<table border="0" align="left" bordercolor="white" cellspacing="0">';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">FOLIO: '.$Hconvenio->Folio_pre."-".str_pad($Hconvenio->Folio_cons, 4, "0", STR_PAD_LEFT) .'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">AGENCIA: '.$Parametros->razon_soc.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">NEGOCIACION: '.$Nombreconvenio.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">TARJETA DE CREDITO: '.$Hconvenio->Dmacct.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">NOMBRE: '.$Hconvenio->Nombre.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '</table>';

        $TodayDate = unix_to_human(time(), TRUE, 'us');
        $TodayDate = date("d/m/Y H:i:s A", strtotime($TodayDate));

        $FechaHoraOriginal = $Hconvenio->Fecha_emi;
        $Hora = substr($FechaHoraOriginal,11,8);
        $Dia_emi = substr($FechaHoraOriginal,8,2);
        $Mes_emi = intval(substr($FechaHoraOriginal,5,2));
        $Anio_emi = substr($FechaHoraOriginal,0,4);

        $FechaHoraOriginal = $Hconvenio->Fecha_neg;
        $Hora = substr($FechaHoraOriginal,11,8);
        $Dia_neg = substr($FechaHoraOriginal,8,2);
        $Mes_neg = intval(substr($FechaHoraOriginal,5,2));
        $Anio_neg = substr($FechaHoraOriginal,0,4);        

        $Meses =['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

        //$pdf->SetFontSize(11);
        $image_file1 = 'img\logo_legaxxi_conv.png';
        $image_file2 = 'img\logo_HSBC_conv.png';
        $pdf->Image($image_file1, 10, 5, 0, 15, 'PNG', '', 'T', false, 100, '', false, false, 0, false, false, false);
        $pdf->Image($image_file2, 65, 5, 0, 15, 'PNG', '', 'T', false, 100, '', false, false, 0, false, false, false);
        $pdf->SetFont('Helvetica', '', 8, '', true);
        $pdf->writeHTML($Tabla_head, false, 0, true, 0);

        $pdf->Write(5,"", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->Write(5,"", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->SetFont('Helvetica', 'B', 8, '', true);
        $pdf->Write(5,"Carta Convenio de Pago", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->SetFont('Helvetica', '', 8, '', true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,$Parametros->cd_edo_expedicion." a ".$Dia_neg." de ".$Meses[$Mes_neg-1]. " de ".$Anio_neg.", se acuerda el pago del crédito ".$Hconvenio->Dmacct." entre agencia ".$Parametros->razon_soc." en nombre de HSBC y el Cliente ".$Hconvenio->Nombre, $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"A fin de celebrar el presente CONVENIO DE PAGO las partes pactan las siguientes:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"CLAUSULAS:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"I. El pago será realizado directamente al número de la Tarjeta de Crédito ".substr($Hconvenio->Dmacct,-16)." a nombre de ".$Hconvenio->Nombre." en cualquier sucursal de HSBC MÉXICO, S.A., INSTITUCIÓN DE BANCA MÚLTIPLE, GRUPO FINANCIERO HSBC, en días y horas hábiles como a continuación se detalla:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"II. El monto de Pago acordado y descrito a continuación le permitirá liquidar su adeudo de forma total", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->writeHTML($Tabla_pagos, false, 0, true, 0);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"En caso de no poder realizar su pago en sucursal y en efectivo realícelo por transferencia a la clave interbancaria: ".$Hconvenio->Spei_num_key, $enlace="", $fondo=false, $alineacion="L", $nueva_linea=true);
         $pdf->Ln($Interlin);

        $pdf->Write(5,"Desglose del saldo:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->writeHTML($Tabla_saldos, false, 0, true, 0);
        $pdf->Write(5,"", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);

        $pdf->SetFont('Helvetica', '', 8, '', true);
        $pdf->Write(5,"III. En caso de incumplir con el/los pago/s descrito/s anteriormente en la fecha acordada, se dejará sin efecto el descuento o quita solicitada y en consecuencia procederá a aplicar los pagos realizados de acuerdo a los términos establecidos en el contrato de apertura de crédito respectivo y / o convenios modificatorios.", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);

        $pdf->SetFont('Helvetica', '', 8, '', true);
        $pdf->Write(5,"IV. Se acredito previo a la negociación, la identificación del cliente.", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
       
         $pdf->Ln($Interlin);
        $pdf->Write(5,"ATENTAMENTE", $enlace="", $fondo=false, $alineacion="C", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write( 5,$Parametros->cd_edo_expedicion." a ".$Dia_neg." de ".$Meses[$Mes_neg-1]. " de ".$Anio_neg, $enlace="", $fondo=false, $alineacion="C", $nueva_linea=true );
         $pdf->Ln($Interlin);
        $pdf->Write(5,"AGENCIA", $enlace="", $fondo=false, $alineacion="L", $nueva_linea=false);
        $pdf->Write(5,"CLIENTE", $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $sign = '<img src="'.$Parametros->imagen_firma_ag.'"  width="125" height="50">';
        $pdf->writeHTML($sign, false, 0, true, 0);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"_______________________________________", $enlace="", $fondo=false, $alineacion="", $nueva_linea=false);
        $pdf->Write(5,"_______________________________________", $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $pdf->Write(5, $Parametros->nombrefirma_ag, $enlace="", $fondo=false, $alineacion="", $nueva_linea=false);
        $pdf->Write(5,"C. ".$Hconvenio->Nombre, $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $pdf->Write(5,"Apoderado Legal de Legaxxi", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);

        $pdf->SetFont('Helvetica', '', 6, '', true);
        $pdf->writeHTML($Parametros->nota_final, true, 0, true, 0);

        $nombre_archivo = utf8_decode("Convenio_".$Hconvenio->Dmacct.".pdf");
        $pdf->Output($nombre_archivo, 'D');
    }

    function GenerarPdf3() {            // TDC Liquidacion con descuento en exhibiciones
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        // $pdf->setData($this->session->Empresa, $this->session->Rfc);
        $pdf->setData("LEGAXXI", "RFC999999XXX");
        $pdf->SetCreator('');
        $pdf->SetAuthor('LEGAXXI');
        $pdf->SetTitle('LEGAXXI');
        $pdf->SetSubject('CONVENIOS');
        $pdf->SetKeywords('');

        $pdf->SetHeaderData("logo_legaxxi_conv.png", 15, "LEGAXXI", "CONVENIOS", array(0,0,0), array(0,0,0));
        $pdf->setFooterData($tc = array(0, 0, 0), $lc = array(0, 0, 0));

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(10, PDF_MARGIN_TOP, 10);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetAutoPageBreak(TRUE, 20);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


        $pdf->setFontSubsetting(true);

        $pdf->SetFont('Helvetica', '', 8, '', true);

        $pdf->AddPage();

        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

        $Convenioid = $this->input->post("Convenioid");

        // Obtenemos los parametros generales del convenio
        $Parametros = $this->Parametros_model->GetUnique();

        // Datos del convenio y armado de tablas e informacion general
        $Hconvenio = $this->Convenios_model->GetById($Convenioid);
        // var_dump($Convenioid);

        // Este codigo es para subsanar un bug en el helper ConvertirNumeroALetra()
        // ya que no interpreta correctamente valores que no incluyan un entero 
        // es decir, etre entre 0 y .99 
        // if($Quita_cond >= 0 && $Quita_cond <1){
        //     $Quita_str = (string) $Quita_cond;
        //     $Decimals = substr( $Quita_str, strpos( $Quita_str, "." )+1, 2 );
        //     if($Decimals == ''){
        //         $Decimals = '00';
        //     }            
        //     $QC_enletra = 'Cero pesos '.$Decimals.'/100 M.N.';
        // }else{
        //     $QC_enletra = ConvertirNumeroALetra($Quita_cond); 
        // }

        $Nombreconvenio = $this->Tiposnego_model->GetNombreByid($Hconvenio->Tipo_negoid);

        // Determinar importe de descuento de acuerdo al saldo utilizado
        $Descuento=0;
        if($Hconvenio->Saldo_usado = "T")       // Saldo total
        {
            $Descuento = $Hconvenio->Uxtot_adeu-$Hconvenio->Total_pago;
        }else{                                  // Saldo contable
            $Descuento = $Hconvenio->Dmcurbal-$Hconvenio->Total_pago;
        }

        // Detalle y armado de tabla de saldos
        $Tabla_saldos = '<table border=".5" align="center" bordercolor="black" cellspacing="0">';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">SALDO AL DIA</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Uxtot_adeu,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">PAGO MINIMO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->U6pag_min,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">SALDO AL ULTIMO CORTE</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->U6sdo_cort,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">SALDO VENCIDO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Dmamtdlq,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">PAGO ACORDADO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Total_pago,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">DESCUENTO SOBRE SALDO AL DIA</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Descuento,2).'</td>                          
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">% DE DESCUENTO SOBRE TOTAL ADEUDO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.number_format($Hconvenio->Quita_neg,2).'%</td> 
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '</table>'; 


        //Detalle de pagos y armado de tabla de pagos
        $Tabla_pagos = '<table border=".5" align="center" bordercolor="black" cellspacing="0">';
        $Tabla_pagos = $Tabla_pagos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">Numero de pagos</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">Monto de pago</td>
                            <td style="border: .5px solid #000000; width: 150px; text-align:center">Fecha limite de pago</td>                            
                        </tr>';

        $Dconvenio = $this->Convdeta_model->GetDetailsById($Convenioid);

        $Interlin = 1;
        if($Dconvenio){

            $Totalitems = count($Dconvenio);

            if($Totalitems > 2){
                $Interlin = .5;
            }else{
                $Interlin = 1;
            }

            $Itemnumber = 1;
            foreach($Dconvenio as $Item) {
                    $FechaHoraOriginal = $Item->Fecha_pago;
                    $Hora = substr($FechaHoraOriginal,11,8);
                    $Fechapago = substr($FechaHoraOriginal,8,2).'/'.substr($FechaHoraOriginal,5,2).'/'.substr($FechaHoraOriginal,0,4);

                    if($Itemnumber == 1){
                        $Td_numpagos = '<td style="border: .5px solid #000000; width: 100px; vertical-align:middle; text-align:center; " rowspan="'.$Totalitems.'">'.$Totalitems.'</td>';
                    }else{
                        $Td_numpagos = '';
                    }

                    $Tabla_pagos = $Tabla_pagos . '<tr style="height: 30px; color:#000000;">'.$Td_numpagos.'
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Item->Importe_pago,2).'</td>
                            <td style="border: .5px solid #000000; width: 150px; text-align:center">'.$Fechapago.'</td>
                        </tr>';

                $Itemnumber++;

            }
        } 

        $Tabla_pagos = $Tabla_pagos . '</table>';     

        //Detalle de cabecera para datos generales del convenio
        $Tabla_head = '<table border="0" align="left" bordercolor="white" cellspacing="0">';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">FOLIO: '.$Hconvenio->Folio_pre."-".str_pad($Hconvenio->Folio_cons, 4, "0", STR_PAD_LEFT) .'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">AGENCIA: '.$Parametros->razon_soc.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">NEGOCIACION: '.$Nombreconvenio.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">TARJETA DE CREDITO: '.$Hconvenio->Dmacct.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">NOMBRE: '.$Hconvenio->Nombre.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '</table>';

        $TodayDate = unix_to_human(time(), TRUE, 'us');
        $TodayDate = date("d/m/Y H:i:s A", strtotime($TodayDate));

        $FechaHoraOriginal = $Hconvenio->Fecha_emi;
        $Hora = substr($FechaHoraOriginal,11,8);
        $Dia_emi = substr($FechaHoraOriginal,8,2);
        $Mes_emi = intval(substr($FechaHoraOriginal,5,2));
        $Anio_emi = substr($FechaHoraOriginal,0,4);

        $FechaHoraOriginal = $Hconvenio->Fecha_neg;
        $Hora = substr($FechaHoraOriginal,11,8);
        $Dia_neg = substr($FechaHoraOriginal,8,2);
        $Mes_neg = intval(substr($FechaHoraOriginal,5,2));
        $Anio_neg = substr($FechaHoraOriginal,0,4);        

        $Meses =['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

        //$pdf->SetFontSize(11);
        $image_file1 = 'img\logo_legaxxi_conv.png';
        $image_file2 = 'img\logo_HSBC_conv.png';
        $pdf->Image($image_file1, 10, 5, 0, 15, 'PNG', '', 'T', false, 100, '', false, false, 0, false, false, false);
        $pdf->Image($image_file2, 65, 5, 0, 15, 'PNG', '', 'T', false, 100, '', false, false, 0, false, false, false);
        $pdf->SetFont('Helvetica', '', 8, '', true);
        $pdf->writeHTML($Tabla_head, false, 0, true, 0);

        $pdf->Write(5,"", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->Write(5,"", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->SetFont('Helvetica', 'B', 8, '', true);
        $pdf->Write(5,"Carta Convenio de Pago", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->SetFont('Helvetica', '', 8, '', true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,$Parametros->cd_edo_expedicion." a ".$Dia_neg." de ".$Meses[$Mes_neg-1]. " de ".$Anio_neg.", se acuerda el pago del crédito ".$Hconvenio->Dmacct." entre agencia ".$Parametros->razon_soc." en nombre de HSBC y el Cliente ".$Hconvenio->Nombre, $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"A fin de celebrar el presente CONVENIO DE PAGO las partes pactan las siguientes:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"CLAUSULAS:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"I. El pago será realizado directamente al número de la Tarjeta de Crédito ".substr($Hconvenio->Dmacct,-16)." a nombre de ".$Hconvenio->Nombre." en cualquier sucursal de HSBC MÉXICO, S.A., INSTITUCIÓN DE BANCA MÚLTIPLE, GRUPO FINANCIERO HSBC, en días y horas hábiles como a continuación se detalla:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"II. El monto de Pago acordado y descrito a continuación le permitirá liquidar su adeudo de forma total", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->writeHTML($Tabla_pagos, false, 0, true, 0);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"En caso de no poder realizar su pago en sucursal y en efectivo realícelo por transferencia a la clave interbancaria: ".$Hconvenio->Spei_num_key, $enlace="", $fondo=false, $alineacion="L", $nueva_linea=true);
         $pdf->Ln($Interlin);

        $pdf->Write(5,"Desglose del saldo:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->writeHTML($Tabla_saldos, false, 0, true, 0);
        $pdf->Write(5,"", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);

        $pdf->SetFont('Helvetica', '', 8, '', true);
        $pdf->Write(5,"III. En caso de incumplir con el/los pago/s descrito/s anteriormente en la fecha acordada, se dejará sin efecto el descuento o quita solicitada y en consecuencia procederá a aplicar los pagos realizados de acuerdo a los términos establecidos en el contrato de apertura de crédito respectivo y / o convenios modificatorios.", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);

        $pdf->SetFont('Helvetica', '', 8, '', true);
        $pdf->Write(5,"IV. Se acredito previo a la negociación, la identificación del cliente.", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        
         $pdf->Ln($Interlin);
        $pdf->Write(5,"ATENTAMENTE", $enlace="", $fondo=false, $alineacion="C", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write( 5,$Parametros->cd_edo_expedicion." a ".$Dia_neg." de ".$Meses[$Mes_neg-1]. " de ".$Anio_neg, $enlace="", $fondo=false, $alineacion="C", $nueva_linea=true );
         $pdf->Ln($Interlin);
        $pdf->Write(5,"AGENCIA", $enlace="", $fondo=false, $alineacion="L", $nueva_linea=false);
        $pdf->Write(5,"CLIENTE", $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $sign = '<img src="'.$Parametros->imagen_firma_ag.'"  width="125" height="50">';
        $pdf->writeHTML($sign, false, 0, true, 0);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"_______________________________________", $enlace="", $fondo=false, $alineacion="", $nueva_linea=false);
        $pdf->Write(5,"_______________________________________", $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $pdf->Write(5, $Parametros->nombrefirma_ag, $enlace="", $fondo=false, $alineacion="", $nueva_linea=false);
        $pdf->Write(5,"C. ".$Hconvenio->Nombre, $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $pdf->Write(5,"Apoderado Legal de Legaxxi", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);

        $pdf->SetFont('Helvetica', '', 6, '', true);
        $pdf->writeHTML($Parametros->nota_final, true, 0, true, 0);

        $nombre_archivo = utf8_decode("Convenio_".$Hconvenio->Dmacct.".pdf");
        $pdf->Output($nombre_archivo, 'D');
    }

    function GenerarPdf4() {            // KRONER PAGO PARCIAL
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        // $pdf->setData($this->session->Empresa, $this->session->Rfc);
        $pdf->setData("LEGAXXI", "RFC999999XXX");
        $pdf->SetCreator('');
        $pdf->SetAuthor('LEGAXXI');
        $pdf->SetTitle('LEGAXXI');
        $pdf->SetSubject('CONVENIOS');
        $pdf->SetKeywords('');
 
        $pdf->SetHeaderData("logo_legaxxi_conv.png", 15, "LEGAXXI", "CONVENIOS", array(0,0,0), array(0,0,0));
        $pdf->setFooterData($tc = array(0, 0, 0), $lc = array(0, 0, 0));

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
 
        // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(10, PDF_MARGIN_TOP, 10);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
 
        // $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetAutoPageBreak(TRUE, 20);
 
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
 
 
        $pdf->setFontSubsetting(true);
 
        $pdf->SetFont('Helvetica', '', 9, '', true);
 
        $pdf->AddPage();

        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

        $Convenioid = $this->input->post("Convenioid");

        // Obtenemos los parametros generales del convenio
        $Parametros = $this->Parametros_model->GetUnique();

        // Datos del convenio y armado de tablas e informacion general
        $Hconvenio = $this->Convenios_model->GetById($Convenioid);
        // var_dump($Convenioid);

        // Este codigo es para subsanar un bug en el helper ConvertirNumeroALetra()
        // ya que no interpreta correctamente valores que no incluyan un entero 
        // es decir, etre entre 0 y .99 
        // if($Quita_cond >= 0 && $Quita_cond <1){
        //     $Quita_str = (string) $Quita_cond;
        //     $Decimals = substr( $Quita_str, strpos( $Quita_str, "." )+1, 2 );
        //     if($Decimals == ''){
        //         $Decimals = '00';
        //     }            
        //     $QC_enletra = 'Cero pesos '.$Decimals.'/100 M.N.';
        // }else{
        //     $QC_enletra = ConvertirNumeroALetra($Quita_cond); 
        // }
        $Nombreconvenio = $this->Tiposnego_model->GetNombreByid($Hconvenio->Tipo_negoid);

        // Detalle y armado de tabla de saldos
        $Tabla_saldos = '<table border=".5" align="center" bordercolor="black" cellspacing="0">';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">MONTO PRINCIPAL</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Uxcap_cred,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">INTERESE ORDINARIOS</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Uxint_cred,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">INTERESE MORATORIOS</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Uxmora_cred,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">DEMAS CONCEPTOS EXIGIBLES</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Uxexig_cre,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">TOTAL</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Uxcap_cred+$Hconvenio->Uxint_cred+$Hconvenio->Uxmora_cred+$Hconvenio->Uxexig_cre,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">% DE DESCUENTO SOBRE TOTAL ADEUDO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">N/A</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">PAGO ACORDADO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Total_pago,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '</table>'; 


        //Detalle de pagos y armado de tabla de pagos
        $Tabla_pagos = '<table border=".5" align="center" bordercolor="black" cellspacing="0">';
        $Tabla_pagos = $Tabla_pagos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">Numero de pagos</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">Monto de pago</td>
                            <td style="border: .5px solid #000000; width: 150px; text-align:center">Fecha limite de pago</td>                            
                        </tr>';

        $Dconvenio = $this->Convdeta_model->GetDetailsById($Convenioid);

        $Interlin = 1;
        if($Dconvenio){

            $Totalitems = count($Dconvenio);

            if($Totalitems > 2){
                $Interlin = .5;
            }else{
                $Interlin = 1;
            }

            $Itemnumber = 1;
            foreach($Dconvenio as $Item) {
                    $FechaHoraOriginal = $Item->Fecha_pago;
                    $Hora = substr($FechaHoraOriginal,11,8);
                    $Fechapago = substr($FechaHoraOriginal,8,2).'/'.substr($FechaHoraOriginal,5,2).'/'.substr($FechaHoraOriginal,0,4);

                    if($Itemnumber == 1){
                        $Td_numpagos = '<td style="border: .5px solid #000000; width: 100px; vertical-align:middle; text-align:center; " rowspan="'.$Totalitems.'">'.$Totalitems.'</td>';
                    }else{
                        $Td_numpagos = '';
                    }

                    $Tabla_pagos = $Tabla_pagos . '<tr style="height: 30px; color:#000000;">'.$Td_numpagos.'
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Item->Importe_pago,2).'</td>
                            <td style="border: .5px solid #000000; width: 150px; text-align:center">'.$Fechapago.'</td>
                        </tr>';

                $Itemnumber++;

            }
        } 

        $Tabla_pagos = $Tabla_pagos . '</table>';     

        //Detalle de cabecera para datos generales del convenio
        $Tabla_head = '<table border="0" align="left" bordercolor="white" cellspacing="0">';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">FOLIO: '.$Hconvenio->Folio_pre."-".str_pad($Hconvenio->Folio_cons, 4, "0", STR_PAD_LEFT) .'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">AGENCIA: '.$Parametros->razon_soc.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">NEGOCIACION: '.$Nombreconvenio.'</td>                       
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">CREDITO: '.$Hconvenio->Dmacct.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">NOMBRE: '.$Hconvenio->Nombre.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '</table>';

        $TodayDate = unix_to_human(time(), TRUE, 'us');
        $TodayDate = date("d/m/Y H:i:s A", strtotime($TodayDate));

        $FechaHoraOriginal = $Hconvenio->Fecha_emi;
        $Hora = substr($FechaHoraOriginal,11,8);
        $Dia_emi = substr($FechaHoraOriginal,8,2);
        $Mes_emi = intval(substr($FechaHoraOriginal,5,2));
        $Anio_emi = substr($FechaHoraOriginal,0,4);

        $FechaHoraOriginal = $Hconvenio->Fecha_neg;
        $Hora = substr($FechaHoraOriginal,11,8);
        $Dia_neg = substr($FechaHoraOriginal,8,2);
        $Mes_neg = intval(substr($FechaHoraOriginal,5,2));
        $Anio_neg = substr($FechaHoraOriginal,0,4);        

        $Meses =['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

        //$pdf->SetFontSize(11);
        $image_file1 = 'img\logo_legaxxi_conv.png';
        $image_file2 = 'img\logo_HSBC_conv.png';
        $pdf->Image($image_file1, 10, 5, 0, 15, 'PNG', '', 'T', false, 100, '', false, false, 0, false, false, false);
        $pdf->Image($image_file2, 65, 5, 0, 15, 'PNG', '', 'T', false, 100, '', false, false, 0, false, false, false);
        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->writeHTML($Tabla_head, false, 0, true, 0);

        $pdf->Write(5,"", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->Write(5,"", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->SetFont('Helvetica', 'B', 9, '', true);
        $pdf->Write(5,"Carta Convenio de Pago", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->SetFont('Helvetica', '', 9, '', true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,$Parametros->cd_edo_expedicion." a ".$Dia_neg." de ".$Meses[$Mes_neg-1]. " de ".$Anio_neg.", se acuerda el pago del crédito ".$Hconvenio->Dmacct." entre agencia ".$Parametros->razon_soc." en nombre de HSBC y el Cliente ".$Hconvenio->Nombre, $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"A fin de celebrar el presente CONVENIO DE PAGO las partes pactan las siguientes:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"CLAUSULAS:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"I. El pago será realizado directamente al número del crédito ".$Hconvenio->plastico_pago." a nombre de ".$Hconvenio->Nombre." en cualquier sucursal de HSBC MÉXICO, S.A., INSTITUCIÓN DE BANCA MÚLTIPLE, GRUPO FINANCIERO HSBC, en días y horas hábiles como a continuación se detalla:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"II. El monto de Pago acordado y descrito a continuación le permitirá aplicarse como Pago parcial", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->writeHTML($Tabla_pagos, false, 0, true, 0);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"En caso de no poder realizar su pago en sucursal y en efectivo realícelo por transferencia a la clave interbancaria: ".$Hconvenio->Spei_num_key, $enlace="", $fondo=false, $alineacion="L", $nueva_linea=true);
         $pdf->Ln($Interlin);

        $pdf->Write(5,"Desglose del saldo:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->writeHTML($Tabla_saldos, false, 0, true, 0);
        $pdf->Write(5,"", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);

        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->Write(5,"III. En caso de incumplir con el/los pago/s descrito/s anteriormente en la fecha acordada, se dejará sin efecto el descuento o quita solicitada y en consecuencia procederá a aplicar los pagos realizados de acuerdo a los términos establecidos en el contrato de apertura de crédito respectivo y / o convenios modificatorios.", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);

        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->Write(5,"IV. Se acredito previo a la negociación, la identificación del cliente.", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
       
         $pdf->Ln($Interlin);
        $pdf->Write(5,"ATENTAMENTE", $enlace="", $fondo=false, $alineacion="C", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write( 5,$Parametros->cd_edo_expedicion." a ".$Dia_neg." de ".$Meses[$Mes_neg-1]. " de ".$Anio_neg, $enlace="", $fondo=false, $alineacion="C", $nueva_linea=true );
         $pdf->Ln($Interlin);
        $pdf->Write(5,"AGENCIA", $enlace="", $fondo=false, $alineacion="L", $nueva_linea=false);
        $pdf->Write(5,"CLIENTE", $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $sign = '<img src="'.$Parametros->imagen_firma_ag.'"  width="125" height="50">';
        $pdf->writeHTML($sign, false, 0, true, 0);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"_______________________________________", $enlace="", $fondo=false, $alineacion="", $nueva_linea=false);
        $pdf->Write(5,"_______________________________________", $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $pdf->Write(5, $Parametros->nombrefirma_ag, $enlace="", $fondo=false, $alineacion="", $nueva_linea=false);
        $pdf->Write(5,"C. ".$Hconvenio->Nombre, $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $pdf->Write(5,"Apoderado Legal de Legaxxi", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);

        $pdf->SetFont('Helvetica', '', 7, '', true);
        $pdf->writeHTML($Parametros->nota_final, true, 0, true, 0);

        $nombre_archivo = utf8_decode("Convenio_".$Hconvenio->Dmacct.".pdf");
        $pdf->Output($nombre_archivo, 'D');
    }

    function GenerarPdf5() {            // KRONER LIQUIDACION CON DESCUENTO PAGO UNICO/EXHIBICIONES/PLAZOS
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        // $pdf->setData($this->session->Empresa, $this->session->Rfc);
        $pdf->setData("LEGAXXI", "RFC999999XXX");
        $pdf->SetCreator('');
        $pdf->SetAuthor('LEGAXXI');
        $pdf->SetTitle('LEGAXXI');
        $pdf->SetSubject('CONVENIOS');
        $pdf->SetKeywords('');
 
        $pdf->SetHeaderData("logo_legaxxi_conv.png", 15, "LEGAXXI", "CONVENIOS", array(0,0,0), array(0,0,0));
        $pdf->setFooterData($tc = array(0, 0, 0), $lc = array(0, 0, 0));

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
 
        // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(10, PDF_MARGIN_TOP, 10);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
 
        // $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetAutoPageBreak(TRUE, 20);
 
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
 
 
        $pdf->setFontSubsetting(true);
 
        $pdf->SetFont('Helvetica', '', 9, '', true);
 
        $pdf->AddPage();

        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

        $Convenioid = $this->input->post("Convenioid");

        // Obtenemos los parametros generales del convenio
        $Parametros = $this->Parametros_model->GetUnique();

        // Datos del convenio y armado de tablas e informacion general
        $Hconvenio = $this->Convenios_model->GetById($Convenioid);
        // var_dump($Convenioid);

        // Este codigo es para subsanar un bug en el helper ConvertirNumeroALetra()
        // ya que no interpreta correctamente valores que no incluyan un entero 
        // es decir, etre entre 0 y .99 
        // if($Quita_cond >= 0 && $Quita_cond <1){
        //     $Quita_str = (string) $Quita_cond;
        //     $Decimals = substr( $Quita_str, strpos( $Quita_str, "." )+1, 2 );
        //     if($Decimals == ''){
        //         $Decimals = '00';
        //     }            
        //     $QC_enletra = 'Cero pesos '.$Decimals.'/100 M.N.';
        // }else{
        //     $QC_enletra = ConvertirNumeroALetra($Quita_cond); 
        // }
        $Nombreconvenio = $this->Tiposnego_model->GetNombreByid($Hconvenio->Tipo_negoid);

        $Descuento=0;
        if($Hconvenio->Saldo_usado = "T")       // Saldo total
        {
            $Descuento = $Hconvenio->Uxtot_adeu-$Hconvenio->Total_pago;
        }else{                                  // Saldo contable
            $Descuento = $Hconvenio->Dmcurbal-$Hconvenio->Total_pago;
        }

        // Detalle y armado de tabla de saldos
        $Tabla_saldos = '<table border=".5" align="center" bordercolor="black" cellspacing="0">';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">MONTO PRINCIPAL</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Uxcap_cred,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">INTERESE ORDINARIOS</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Uxint_cred,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">INTERESE MORATORIOS</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Uxmora_cred,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">DEMAS CONCEPTOS EXIGIBLES</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Uxexig_cre,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">TOTAL</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Uxcap_cred+$Hconvenio->Uxint_cred+$Hconvenio->Uxmora_cred+$Hconvenio->Uxexig_cre,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">% DE DESCUENTO SOBRE TOTAL ADEUDO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.number_format($Hconvenio->Quita_neg,2).'%</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">PAGO ACORDADO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Total_pago,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '</table>'; 


        //Detalle de pagos y armado de tabla de pagos
        $Tabla_pagos = '<table border=".5" align="center" bordercolor="black" cellspacing="0">';
        $Tabla_pagos = $Tabla_pagos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">Numero de pagos</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">Monto de pago</td>
                            <td style="border: .5px solid #000000; width: 150px; text-align:center">Fecha limite de pago</td>                            
                        </tr>';

        $Dconvenio = $this->Convdeta_model->GetDetailsById($Convenioid);

        $Interlin = 1;
        if($Dconvenio){

            $Totalitems = count($Dconvenio);

            if($Totalitems > 2){
                $Interlin = .5;
            }else{
                $Interlin = 1;
            }

            $Itemnumber = 1;
            foreach($Dconvenio as $Item) {
                    $FechaHoraOriginal = $Item->Fecha_pago;
                    $Hora = substr($FechaHoraOriginal,11,8);
                    $Fechapago = substr($FechaHoraOriginal,8,2).'/'.substr($FechaHoraOriginal,5,2).'/'.substr($FechaHoraOriginal,0,4);

                    if($Itemnumber == 1){
                        $Td_numpagos = '<td style="border: .5px solid #000000; width: 100px; vertical-align:middle; text-align:center; " rowspan="'.$Totalitems.'">'.$Totalitems.'</td>';
                    }else{
                        $Td_numpagos = '';
                    }

                    $Tabla_pagos = $Tabla_pagos . '<tr style="height: 30px; color:#000000;">'.$Td_numpagos.'
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Item->Importe_pago,2).'</td>
                            <td style="border: .5px solid #000000; width: 150px; text-align:center">'.$Fechapago.'</td>
                        </tr>';

                $Itemnumber++;

            }
        } 

        $Tabla_pagos = $Tabla_pagos . '</table>';     

        //Detalle de cabecera para datos generales del convenio
        $Tabla_head = '<table border="0" align="left" bordercolor="white" cellspacing="0">';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">FOLIO: '.$Hconvenio->Folio_pre."-".str_pad($Hconvenio->Folio_cons, 4, "0", STR_PAD_LEFT) .'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">AGENCIA: '.$Parametros->razon_soc.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">NEGOCIACION: '.$Nombreconvenio.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">CREDITO: '.$Hconvenio->Dmacct.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">NOMBRE: '.$Hconvenio->Nombre.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '</table>';

        $TodayDate = unix_to_human(time(), TRUE, 'us');
        $TodayDate = date("d/m/Y H:i:s A", strtotime($TodayDate));

        $FechaHoraOriginal = $Hconvenio->Fecha_emi;
        $Hora = substr($FechaHoraOriginal,11,8);
        $Dia_emi = substr($FechaHoraOriginal,8,2);
        $Mes_emi = intval(substr($FechaHoraOriginal,5,2));
        $Anio_emi = substr($FechaHoraOriginal,0,4);

        $FechaHoraOriginal = $Hconvenio->Fecha_neg;
        $Hora = substr($FechaHoraOriginal,11,8);
        $Dia_neg = substr($FechaHoraOriginal,8,2);
        $Mes_neg = intval(substr($FechaHoraOriginal,5,2));
        $Anio_neg = substr($FechaHoraOriginal,0,4);        

        $Meses =['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

        //$pdf->SetFontSize(11);
        $image_file1 = 'img\logo_legaxxi_conv.png';
        $image_file2 = 'img\logo_HSBC_conv.png';
        $pdf->Image($image_file1, 10, 5, 0, 15, 'PNG', '', 'T', false, 100, '', false, false, 0, false, false, false);
        $pdf->Image($image_file2, 65, 5, 0, 15, 'PNG', '', 'T', false, 100, '', false, false, 0, false, false, false);
        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->writeHTML($Tabla_head, false, 0, true, 0);

        $pdf->Write(5,"", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->Write(5,"", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->SetFont('Helvetica', 'B', 9, '', true);
        $pdf->Write(5,"Carta Convenio de Pago", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->SetFont('Helvetica', '', 9, '', true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,$Parametros->cd_edo_expedicion." a ".$Dia_neg." de ".$Meses[$Mes_neg-1]. " de ".$Anio_neg.", se acuerda el pago del crédito ".$Hconvenio->Dmacct." entre agencia ".$Parametros->razon_soc." en nombre de HSBC y el Cliente ".$Hconvenio->Nombre, $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"A fin de celebrar el presente CONVENIO DE PAGO las partes pactan las siguientes:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"CLAUSULAS:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"I. El pago será realizado directamente al número del crédito ".$Hconvenio->plastico_pago." a nombre de ".$Hconvenio->Nombre." en cualquier sucursal de HSBC MÉXICO, S.A., INSTITUCIÓN DE BANCA MÚLTIPLE, GRUPO FINANCIERO HSBC, en días y horas hábiles como a continuación se detalla:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"II. El monto de Pago acordado y descrito a continuación le permitirá liquidar su adeudo de forma total", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->writeHTML($Tabla_pagos, false, 0, true, 0);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"En caso de no poder realizar su pago en sucursal y en efectivo realícelo por transferencia a la clave interbancaria: ".$Hconvenio->Spei_num_key, $enlace="", $fondo=false, $alineacion="L", $nueva_linea=true);
         $pdf->Ln($Interlin);

        $pdf->Write(5,"Desglose del saldo:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->writeHTML($Tabla_saldos, false, 0, true, 0);
        $pdf->Write(5,"", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);

        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->Write(5,"III. En caso de incumplir con el/los pago/s descrito/s anteriormente en la fecha acordada, se dejará sin efecto el descuento o quita solicitada y en consecuencia procederá a aplicar los pagos realizados de acuerdo a los términos establecidos en el contrato de apertura de crédito respectivo y / o convenios modificatorios.", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);

        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->Write(5,"IV. Se acredito previo a la negociación, la identificación del cliente.", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
       
         $pdf->Ln($Interlin);
        $pdf->Write(5,"ATENTAMENTE", $enlace="", $fondo=false, $alineacion="C", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write( 5,$Parametros->cd_edo_expedicion." a ".$Dia_neg." de ".$Meses[$Mes_neg-1]. " de ".$Anio_neg, $enlace="", $fondo=false, $alineacion="C", $nueva_linea=true );
         $pdf->Ln($Interlin);
        $pdf->Write(5,"AGENCIA", $enlace="", $fondo=false, $alineacion="L", $nueva_linea=false);
        $pdf->Write(5,"CLIENTE", $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $sign = '<img src="'.$Parametros->imagen_firma_ag.'"  width="125" height="25">';
        $pdf->writeHTML($sign, false, 0, true, 0);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"_______________________________________", $enlace="", $fondo=false, $alineacion="", $nueva_linea=false);
        $pdf->Write(5,"_______________________________________", $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $pdf->Write(5, $Parametros->nombrefirma_ag, $enlace="", $fondo=false, $alineacion="", $nueva_linea=false);
        $pdf->Write(5,"C. ".$Hconvenio->Nombre, $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $pdf->Write(5,"Apoderado Legal de Legaxxi", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);

        $pdf->SetFont('Helvetica', '', 7, '', true);
        $pdf->writeHTML($Parametros->nota_final, true, 0, true, 0);

        $nombre_archivo = utf8_decode("Convenio_".$Hconvenio->Dmacct.".pdf");
        $pdf->Output($nombre_archivo, 'D');
    }

    function GenerarPdf6() {            // KRONER Liquidacion con descuento en exhibiciones
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        // $pdf->setData($this->session->Empresa, $this->session->Rfc);
        $pdf->setData("LEGAXXI", "RFC999999XXX");
        $pdf->SetCreator('');
        $pdf->SetAuthor('LEGAXXI');
        $pdf->SetTitle('LEGAXXI');
        $pdf->SetSubject('CONVENIOS');
        $pdf->SetKeywords('');
 
        $pdf->SetHeaderData("logo_legaxxi_conv.png", 15, "LEGAXXI", "CONVENIOS", array(0,0,0), array(0,0,0));
        $pdf->setFooterData($tc = array(0, 0, 0), $lc = array(0, 0, 0));

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
 
        // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(10, PDF_MARGIN_TOP, 10);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
 
        // $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetAutoPageBreak(TRUE, 20);
 
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
 
 
        $pdf->setFontSubsetting(true);
 
        $pdf->SetFont('Helvetica', '', 9, '', true);
 
        $pdf->AddPage();

        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

        $Convenioid = $this->input->post("Convenioid");

        // Obtenemos los parametros generales del convenio
        $Parametros = $this->Parametros_model->GetUnique();

        // Datos del convenio y armado de tablas e informacion general
        $Hconvenio = $this->Convenios_model->GetById($Convenioid);
        // var_dump($Convenioid);

        // Este codigo es para subsanar un bug en el helper ConvertirNumeroALetra()
        // ya que no interpreta correctamente valores que no incluyan un entero 
        // es decir, etre entre 0 y .99 
        // if($Quita_cond >= 0 && $Quita_cond <1){
        //     $Quita_str = (string) $Quita_cond;
        //     $Decimals = substr( $Quita_str, strpos( $Quita_str, "." )+1, 2 );
        //     if($Decimals == ''){
        //         $Decimals = '00';
        //     }            
        //     $QC_enletra = 'Cero pesos '.$Decimals.'/100 M.N.';
        // }else{
        //     $QC_enletra = ConvertirNumeroALetra($Quita_cond); 
        // }
        $Nombreconvenio = $this->Tiposnego_model->GetNombreByid($Hconvenio->Tipo_negoid);

        // Detalle y armado de tabla de saldos
        $Tabla_saldos = '<table border=".5" align="center" bordercolor="black" cellspacing="0">';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">MONTO PRINCIPAL</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Uxcap_cred,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">INTERESE ORDINARIOS</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Uxint_cred,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">INTERESE MORATORIOS</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Uxmora_cred,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">DEMAS CONCEPTOS EXIGIBLES</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Uxexig_cre,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">TOTAL</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Uxcap_cred+$Hconvenio->Uxint_cred+$Hconvenio->Uxmora_cred+$Hconvenio->Uxexig_cre,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">% DE DESCUENTO SOBRE TOTAL ADEUDO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">N/A</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">PAGO ACORDADO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Total_pago,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '</table>'; 


        //Detalle de pagos y armado de tabla de pagos
        $Tabla_pagos = '<table border=".5" align="center" bordercolor="black" cellspacing="0">';
        $Tabla_pagos = $Tabla_pagos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">Numero de pagos</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">Monto de pago</td>
                            <td style="border: .5px solid #000000; width: 150px; text-align:center">Fecha limite de pago</td>                            
                        </tr>';

        $Dconvenio = $this->Convdeta_model->GetDetailsById($Convenioid);

        $Interlin = 1;
        if($Dconvenio){

            $Totalitems = count($Dconvenio);

            if($Totalitems > 2){
                $Interlin = .5;
            }else{
                $Interlin = 1;
            }

            $Itemnumber = 1;
            foreach($Dconvenio as $Item) {
                    $FechaHoraOriginal = $Item->Fecha_pago;
                    $Hora = substr($FechaHoraOriginal,11,8);
                    $Fechapago = substr($FechaHoraOriginal,8,2).'/'.substr($FechaHoraOriginal,5,2).'/'.substr($FechaHoraOriginal,0,4);

                    if($Itemnumber == 1){
                        $Td_numpagos = '<td style="border: .5px solid #000000; width: 100px; vertical-align:middle; text-align:center; " rowspan="'.$Totalitems.'">'.$Totalitems.'</td>';
                    }else{
                        $Td_numpagos = '';
                    }

                    $Tabla_pagos = $Tabla_pagos . '<tr style="height: 30px; color:#000000;">'.$Td_numpagos.'
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Item->Importe_pago,2).'</td>
                            <td style="border: .5px solid #000000; width: 150px; text-align:center">'.$Fechapago.'</td>
                        </tr>';

                $Itemnumber++;

            }
        } 

        $Tabla_pagos = $Tabla_pagos . '</table>';     

        //Detalle de cabecera para datos generales del convenio
        $Tabla_head = '<table border="0" align="left" bordercolor="white" cellspacing="0">';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">FOLIO: '.$Hconvenio->Folio_pre."-".str_pad($Hconvenio->Folio_cons, 4, "0", STR_PAD_LEFT) .'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">AGENCIA: '.$Parametros->razon_soc.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">NEGOCIACION: '.$Nombreconvenio.'</td>                       
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">CREDITO: '.$Hconvenio->Dmacct.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">NOMBRE: '.$Hconvenio->Nombre.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '</table>';

        $TodayDate = unix_to_human(time(), TRUE, 'us');
        $TodayDate = date("d/m/Y H:i:s A", strtotime($TodayDate));

        $FechaHoraOriginal = $Hconvenio->Fecha_emi;
        $Hora = substr($FechaHoraOriginal,11,8);
        $Dia_emi = substr($FechaHoraOriginal,8,2);
        $Mes_emi = intval(substr($FechaHoraOriginal,5,2));
        $Anio_emi = substr($FechaHoraOriginal,0,4);

        $FechaHoraOriginal = $Hconvenio->Fecha_neg;
        $Hora = substr($FechaHoraOriginal,11,8);
        $Dia_neg = substr($FechaHoraOriginal,8,2);
        $Mes_neg = intval(substr($FechaHoraOriginal,5,2));
        $Anio_neg = substr($FechaHoraOriginal,0,4);        

        $Meses =['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

        //$pdf->SetFontSize(11);
        $image_file1 = 'img\logo_legaxxi_conv.png';
        $image_file2 = 'img\logo_HSBC_conv.png';
        $pdf->Image($image_file1, 10, 5, 0, 15, 'PNG', '', 'T', false, 100, '', false, false, 0, false, false, false);
        $pdf->Image($image_file2, 65, 5, 0, 15, 'PNG', '', 'T', false, 100, '', false, false, 0, false, false, false);
        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->writeHTML($Tabla_head, false, 0, true, 0);

        $pdf->Write(5,"", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->Write(5,"", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->SetFont('Helvetica', 'B', 9, '', true);
        $pdf->Write(5,"Carta Convenio de Pago", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->SetFont('Helvetica', '', 9, '', true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,$Parametros->cd_edo_expedicion." a ".$Dia_neg." de ".$Meses[$Mes_neg-1]. " de ".$Anio_neg.", se acuerda el pago del crédito ".$Hconvenio->Dmacct." entre agencia ".$Parametros->razon_soc." en nombre de HSBC y el Cliente ".$Hconvenio->Nombre, $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"A fin de celebrar el presente CONVENIO DE PAGO las partes pactan las siguientes:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"CLAUSULAS:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"I. El pago será realizado directamente al número del crédito ".$Hconvenio->plastico_pago." a nombre de ".$Hconvenio->Nombre." en cualquier sucursal de HSBC MÉXICO, S.A., INSTITUCIÓN DE BANCA MÚLTIPLE, GRUPO FINANCIERO HSBC, en días y horas hábiles como a continuación se detalla:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"II. El monto de Pago acordado y descrito a continuación le permitirá liquidar su adeudo de forma total", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->writeHTML($Tabla_pagos, false, 0, true, 0);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"En caso de no poder realizar su pago en sucursal y en efectivo realícelo por transferencia a la clave interbancaria: ".$Hconvenio->Spei_num_key, $enlace="", $fondo=false, $alineacion="L", $nueva_linea=true);
         $pdf->Ln($Interlin);

        $pdf->Write(5,"Desglose del saldo:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->writeHTML($Tabla_saldos, false, 0, true, 0);
        $pdf->Write(5,"", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);

        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->Write(5,"III. En caso de incumplir con el/los pago/s descrito/s anteriormente en la fecha acordada, se dejará sin efecto el descuento o quita solicitada y en consecuencia procederá a aplicar los pagos realizados de acuerdo a los términos establecidos en el contrato de apertura de crédito respectivo y / o convenios modificatorios.", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);

        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->Write(5,"IV. Se acredito previo a la negociación, la identificación del cliente.", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
       
         $pdf->Ln($Interlin);
        $pdf->Write(5,"ATENTAMENTE", $enlace="", $fondo=false, $alineacion="C", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write( 5,$Parametros->cd_edo_expedicion." a ".$Dia_neg." de ".$Meses[$Mes_neg-1]. " de ".$Anio_neg, $enlace="", $fondo=false, $alineacion="C", $nueva_linea=true );
         $pdf->Ln($Interlin);
        $pdf->Write(5,"AGENCIA", $enlace="", $fondo=false, $alineacion="L", $nueva_linea=false);
        $pdf->Write(5,"CLIENTE", $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $sign = '<img src="'.$Parametros->imagen_firma_ag.'"  width="125" height="50">';
        $pdf->writeHTML($sign, false, 0, true, 0);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"_______________________________________", $enlace="", $fondo=false, $alineacion="", $nueva_linea=false);
        $pdf->Write(5,"_______________________________________", $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $pdf->Write(5, $Parametros->nombrefirma_ag, $enlace="", $fondo=false, $alineacion="", $nueva_linea=false);
        $pdf->Write(5,"C. ".$Hconvenio->Nombre, $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $pdf->Write(5,"Apoderado Legal de Legaxxi", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);

        $pdf->SetFont('Helvetica', '', 7, '', true);
        $pdf->writeHTML($Parametros->nota_final, true, 0, true, 0);

        $nombre_archivo = utf8_decode("Convenio_".$Hconvenio->Dmacct.".pdf");
        $pdf->Output($nombre_archivo, 'D');
    }

    function GenerarPdf7() {            // CONSUMER PAGO PARCIAL
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        // $pdf->setData($this->session->Empresa, $this->session->Rfc);
        $pdf->setData("LEGAXXI", "RFC999999XXX");
        $pdf->SetCreator('');
        $pdf->SetAuthor('LEGAXXI');
        $pdf->SetTitle('LEGAXXI');
        $pdf->SetSubject('CONVENIOS');
        $pdf->SetKeywords('');
 
        $pdf->SetHeaderData("logo_legaxxi_conv.png", 15, "LEGAXXI", "CONVENIOS", array(0,0,0), array(0,0,0));
        $pdf->setFooterData($tc = array(0, 0, 0), $lc = array(0, 0, 0));

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
 
        // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(10, PDF_MARGIN_TOP, 10);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
 
        // $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetAutoPageBreak(TRUE, 20);
 
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
 
 
        $pdf->setFontSubsetting(true);
 
        $pdf->SetFont('Helvetica', '', 9, '', true);
 
        $pdf->AddPage();

        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

        $Convenioid = $this->input->post("Convenioid");

        // Obtenemos los parametros generales del convenio
        $Parametros = $this->Parametros_model->GetUnique();

        // Datos del convenio y armado de tablas e informacion general
        $Hconvenio = $this->Convenios_model->GetById($Convenioid);
        // var_dump($Convenioid);

        // Este codigo es para subsanar un bug en el helper ConvertirNumeroALetra()
        // ya que no interpreta correctamente valores que no incluyan un entero 
        // es decir, etre entre 0 y .99 
        // if($Quita_cond >= 0 && $Quita_cond <1){
        //     $Quita_str = (string) $Quita_cond;
        //     $Decimals = substr( $Quita_str, strpos( $Quita_str, "." )+1, 2 );
        //     if($Decimals == ''){
        //         $Decimals = '00';
        //     }            
        //     $QC_enletra = 'Cero pesos '.$Decimals.'/100 M.N.';
        // }else{
        //     $QC_enletra = ConvertirNumeroALetra($Quita_cond); 
        // }
        $Nombreconvenio = $this->Tiposnego_model->GetNombreByid($Hconvenio->Tipo_negoid);

        // Detalle y armado de tabla de saldos
        $Tabla_saldos = '<table border=".5" align="center" bordercolor="black" cellspacing="0">';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">MONTO PRINCIPAL</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Mto_principal,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">INTERESES ORDINARIOS</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Int_ordinario,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">MORATORIOS</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Moratorios,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">COMISIONES</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Comp_exigible,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">TOTAL ADEUDO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Total_adeudo,2).'</td>
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">TOTAL VENCIDO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Dmamtdlq,2).'</td>
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">PAGO ACORDADO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Total_pago,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">DESCUENTO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">N/A</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">% DE DESCUENTO SOBRE TOTAL ADEUDO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">N/A</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '</table>'; 


        //Detalle de pagos y armado de tabla de pagos
        $Tabla_pagos = '<table border=".5" align="center" bordercolor="black" cellspacing="0">';
        $Tabla_pagos = $Tabla_pagos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">Numero de pagos</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">Monto de pago</td>
                            <td style="border: .5px solid #000000; width: 150px; text-align:center">Fecha limite de pago</td>                            
                        </tr>';

        $Dconvenio = $this->Convdeta_model->GetDetailsById($Convenioid);

        $Interlin = 1;
        if($Dconvenio){

            $Totalitems = count($Dconvenio);

            if($Totalitems > 2){
                $Interlin = .5;
            }else{
                $Interlin = 1;
            }

            $Itemnumber = 1;
            foreach($Dconvenio as $Item) {
                    $FechaHoraOriginal = $Item->Fecha_pago;
                    $Hora = substr($FechaHoraOriginal,11,8);
                    $Fechapago = substr($FechaHoraOriginal,8,2).'/'.substr($FechaHoraOriginal,5,2).'/'.substr($FechaHoraOriginal,0,4);

                    if($Itemnumber == 1){
                        $Td_numpagos = '<td style="border: .5px solid #000000; width: 100px; vertical-align:middle; text-align:center; " rowspan="'.$Totalitems.'">'.$Totalitems.'</td>';
                    }else{
                        $Td_numpagos = '';
                    }

                    $Tabla_pagos = $Tabla_pagos . '<tr style="height: 30px; color:#000000;">'.$Td_numpagos.'
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Item->Importe_pago,2).'</td>
                            <td style="border: .5px solid #000000; width: 150px; text-align:center">'.$Fechapago.'</td>
                        </tr>';

                $Itemnumber++;

            }
        } 

        $Tabla_pagos = $Tabla_pagos . '</table>';     

        //Detalle de cabecera para datos generales del convenio
        $Tabla_head = '<table border="0" align="left" bordercolor="white" cellspacing="0">';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">FOLIO: '.$Hconvenio->Folio_pre."-".str_pad($Hconvenio->Folio_cons, 4, "0", STR_PAD_LEFT) .'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">AGENCIA: '.$Parametros->razon_soc.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">NEGOCIACION: '.$Nombreconvenio.'</td>                       
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">CREDITO: '.$Hconvenio->Dmacct.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">NOMBRE: '.$Hconvenio->Nombre.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '</table>';

        $TodayDate = unix_to_human(time(), TRUE, 'us');
        $TodayDate = date("d/m/Y H:i:s A", strtotime($TodayDate));

        $FechaHoraOriginal = $Hconvenio->Fecha_emi;
        $Hora = substr($FechaHoraOriginal,11,8);
        $Dia_emi = substr($FechaHoraOriginal,8,2);
        $Mes_emi = intval(substr($FechaHoraOriginal,5,2));
        $Anio_emi = substr($FechaHoraOriginal,0,4);

        $FechaHoraOriginal = $Hconvenio->Fecha_neg;
        $Hora = substr($FechaHoraOriginal,11,8);
        $Dia_neg = substr($FechaHoraOriginal,8,2);
        $Mes_neg = intval(substr($FechaHoraOriginal,5,2));
        $Anio_neg = substr($FechaHoraOriginal,0,4);        

        $Meses =['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

        //$pdf->SetFontSize(11);
        $image_file1 = 'img\logo_legaxxi_conv.png';
        $image_file2 = 'img\logo_HSBC_conv.png';
        $pdf->Image($image_file1, 10, 5, 0, 15, 'PNG', '', 'T', false, 100, '', false, false, 0, false, false, false);
        $pdf->Image($image_file2, 65, 5, 0, 15, 'PNG', '', 'T', false, 100, '', false, false, 0, false, false, false);
        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->writeHTML($Tabla_head, false, 0, true, 0);

        $pdf->Write(5,"", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->Write(5,"", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->SetFont('Helvetica', 'B', 9, '', true);
        $pdf->Write(5,"Carta Convenio de Pago", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->SetFont('Helvetica', '', 9, '', true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,$Parametros->cd_edo_expedicion." a ".$Dia_neg." de ".$Meses[$Mes_neg-1]. " de ".$Anio_neg.", se acuerda el pago del crédito ".$Hconvenio->Dmacct." entre agencia ".$Parametros->razon_soc." en nombre de HSBC y el Cliente ".$Hconvenio->Nombre, $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"A fin de celebrar el presente CONVENIO DE PAGO las partes pactan las siguientes:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"CLAUSULAS:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"I. El pago será realizado directamente al número del crédito ".$Hconvenio->plastico_pago." a nombre de ".$Hconvenio->Nombre." en cualquier sucursal de HSBC MÉXICO, S.A., INSTITUCIÓN DE BANCA MÚLTIPLE, GRUPO FINANCIERO HSBC, en días y horas hábiles como a continuación se detalla:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"II. El monto de Pago acordado y descrito a continuación le permitirá aplicarse como Pago parcial", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->writeHTML($Tabla_pagos, false, 0, true, 0);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"En caso de no poder realizar su pago en sucursal y en efectivo realícelo por transferencia a la clave interbancaria: ".$Hconvenio->Spei_num_key, $enlace="", $fondo=false, $alineacion="L", $nueva_linea=true);
         $pdf->Ln($Interlin);

        $pdf->Write(5,"Desglose del saldo:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->writeHTML($Tabla_saldos, false, 0, true, 0);
        $pdf->Write(5,"", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);

        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->Write(5,"III. En caso de incumplir con el/los pago/s descrito/s anteriormente en la fecha acordada, se dejará sin efecto el descuento o quita solicitada y en consecuencia procederá a aplicar los pagos realizados de acuerdo a los términos establecidos en el contrato de apertura de crédito respectivo y / o convenios modificatorios.", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);

        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->Write(5,"IV. Se acredito previo a la negociación, la identificación del cliente.", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
       
         $pdf->Ln($Interlin);
        $pdf->Write(5,"ATENTAMENTE", $enlace="", $fondo=false, $alineacion="C", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write( 5,$Parametros->cd_edo_expedicion." a ".$Dia_neg." de ".$Meses[$Mes_neg-1]. " de ".$Anio_neg, $enlace="", $fondo=false, $alineacion="C", $nueva_linea=true );
         $pdf->Ln($Interlin);
        $pdf->Write(5,"AGENCIA", $enlace="", $fondo=false, $alineacion="L", $nueva_linea=false);
        $pdf->Write(5,"CLIENTE", $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $sign = '<img src="'.$Parametros->imagen_firma_ag.'"  width="125" height="50">';
        $pdf->writeHTML($sign, false, 0, true, 0);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"_______________________________________", $enlace="", $fondo=false, $alineacion="", $nueva_linea=false);
        $pdf->Write(5,"_______________________________________", $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $pdf->Write(5, $Parametros->nombrefirma_ag, $enlace="", $fondo=false, $alineacion="", $nueva_linea=false);
        $pdf->Write(5,"C. ".$Hconvenio->Nombre, $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $pdf->Write(5,"Apoderado Legal de Legaxxi", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);

        $pdf->SetFont('Helvetica', '', 7, '', true);
        $pdf->writeHTML($Parametros->nota_final, true, 0, true, 0);

        $nombre_archivo = utf8_decode("Convenio_".$Hconvenio->Dmacct.".pdf");
        $pdf->Output($nombre_archivo, 'D');
    }

    function GenerarPdf8() {            // CONSUMER PAGO UNICO PARA LIQUIDAR
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        // $pdf->setData($this->session->Empresa, $this->session->Rfc);
        $pdf->setData("LEGAXXI", "RFC999999XXX");
        $pdf->SetCreator('');
        $pdf->SetAuthor('LEGAXXI');
        $pdf->SetTitle('LEGAXXI');
        $pdf->SetSubject('CONVENIOS');
        $pdf->SetKeywords('');
 
        $pdf->SetHeaderData("logo_legaxxi_conv.png", 15, "LEGAXXI", "CONVENIOS", array(0,0,0), array(0,0,0));
        $pdf->setFooterData($tc = array(0, 0, 0), $lc = array(0, 0, 0));

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
 
        // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(10, PDF_MARGIN_TOP, 10);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
 
        // $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetAutoPageBreak(TRUE, 20);
 
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
 
 
        $pdf->setFontSubsetting(true);
 
        $pdf->SetFont('Helvetica', '', 9, '', true);
 
        $pdf->AddPage();

        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

        $Convenioid = $this->input->post("Convenioid");

        // Obtenemos los parametros generales del convenio
        $Parametros = $this->Parametros_model->GetUnique();

        // Datos del convenio y armado de tablas e informacion general
        $Hconvenio = $this->Convenios_model->GetById($Convenioid);
        // var_dump($Convenioid);

        // Este codigo es para subsanar un bug en el helper ConvertirNumeroALetra()
        // ya que no interpreta correctamente valores que no incluyan un entero 
        // es decir, etre entre 0 y .99 
        // if($Quita_cond >= 0 && $Quita_cond <1){
        //     $Quita_str = (string) $Quita_cond;
        //     $Decimals = substr( $Quita_str, strpos( $Quita_str, "." )+1, 2 );
        //     if($Decimals == ''){
        //         $Decimals = '00';
        //     }            
        //     $QC_enletra = 'Cero pesos '.$Decimals.'/100 M.N.';
        // }else{
        //     $QC_enletra = ConvertirNumeroALetra($Quita_cond); 
        // }
        $Nombreconvenio = $this->Tiposnego_model->GetNombreByid($Hconvenio->Tipo_negoid);

        $Descuento=0;
        if($Hconvenio->Saldo_usado = "T")       // Saldo total
        {
            $Descuento = $Hconvenio->Uxtot_adeu-$Hconvenio->Total_pago;
        }else{                                  // Saldo contable
            $Descuento = $Hconvenio->Dmcurbal-$Hconvenio->Total_pago;
        }

        // Detalle y armado de tabla de saldos
        $Tabla_saldos = '<table border=".5" align="center" bordercolor="black" cellspacing="0">';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">MONTO PRINCIPAL</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Mto_principal,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">INTERESES ORDINARIOS</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Int_ordinario,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">MORATORIOS</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Moratorios,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">COMISIONES</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Comp_exigible,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">TOTAL ADEUDO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Total_adeudo,2).'</td>
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">TOTAL VENCIDO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Dmamtdlq,2).'</td>
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">PAGO ACORDADO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Total_pago,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">DESCUENTO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Descuento,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">% DE DESCUENTO SOBRE TOTAL ADEUDO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.number_format($Hconvenio->Quita_neg,2).'%</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '</table>'; 


        //Detalle de pagos y armado de tabla de pagos
        $Tabla_pagos = '<table border=".5" align="center" bordercolor="black" cellspacing="0">';
        $Tabla_pagos = $Tabla_pagos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">Numero de pagos</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">Monto de pago</td>
                            <td style="border: .5px solid #000000; width: 150px; text-align:center">Fecha limite de pago</td>                            
                        </tr>';

        $Dconvenio = $this->Convdeta_model->GetDetailsById($Convenioid);

        $Interlin = 1;
        if($Dconvenio){

            $Totalitems = count($Dconvenio);

            if($Totalitems > 2){
                $Interlin = .5;
            }else{
                $Interlin = 1;
            }

            $Itemnumber = 1;
            foreach($Dconvenio as $Item) {
                    $FechaHoraOriginal = $Item->Fecha_pago;
                    $Hora = substr($FechaHoraOriginal,11,8);
                    $Fechapago = substr($FechaHoraOriginal,8,2).'/'.substr($FechaHoraOriginal,5,2).'/'.substr($FechaHoraOriginal,0,4);

                    if($Itemnumber == 1){
                        $Td_numpagos = '<td style="border: .5px solid #000000; width: 100px; vertical-align:middle; text-align:center; " rowspan="'.$Totalitems.'">'.$Totalitems.'</td>';
                    }else{
                        $Td_numpagos = '';
                    }

                    $Tabla_pagos = $Tabla_pagos . '<tr style="height: 30px; color:#000000;">'.$Td_numpagos.'
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Item->Importe_pago,2).'</td>
                            <td style="border: .5px solid #000000; width: 150px; text-align:center">'.$Fechapago.'</td>
                        </tr>';

                $Itemnumber++;

            }
        } 

        $Tabla_pagos = $Tabla_pagos . '</table>';     

        //Detalle de cabecera para datos generales del convenio
        $Tabla_head = '<table border="0" align="left" bordercolor="white" cellspacing="0">';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">FOLIO: '.$Hconvenio->Folio_pre."-".str_pad($Hconvenio->Folio_cons, 4, "0", STR_PAD_LEFT) .'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">AGENCIA: '.$Parametros->razon_soc.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">NEGOCIACION: '.$Nombreconvenio.'</td>                       
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">CREDITO: '.$Hconvenio->Dmacct.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">NOMBRE: '.$Hconvenio->Nombre.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '</table>';

        $TodayDate = unix_to_human(time(), TRUE, 'us');
        $TodayDate = date("d/m/Y H:i:s A", strtotime($TodayDate));

        $FechaHoraOriginal = $Hconvenio->Fecha_emi;
        $Hora = substr($FechaHoraOriginal,11,8);
        $Dia_emi = substr($FechaHoraOriginal,8,2);
        $Mes_emi = intval(substr($FechaHoraOriginal,5,2));
        $Anio_emi = substr($FechaHoraOriginal,0,4);

        $FechaHoraOriginal = $Hconvenio->Fecha_neg;
        $Hora = substr($FechaHoraOriginal,11,8);
        $Dia_neg = substr($FechaHoraOriginal,8,2);
        $Mes_neg = intval(substr($FechaHoraOriginal,5,2));
        $Anio_neg = substr($FechaHoraOriginal,0,4);        

        $Meses =['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

        //$pdf->SetFontSize(11);
        $image_file1 = 'img\logo_legaxxi_conv.png';
        $image_file2 = 'img\logo_HSBC_conv.png';
        $pdf->Image($image_file1, 10, 5, 0, 15, 'PNG', '', 'T', false, 100, '', false, false, 0, false, false, false);
        $pdf->Image($image_file2, 65, 5, 0, 15, 'PNG', '', 'T', false, 100, '', false, false, 0, false, false, false);
        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->writeHTML($Tabla_head, false, 0, true, 0);

        $pdf->Write(5,"", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->Write(5,"", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->SetFont('Helvetica', 'B', 9, '', true);
        $pdf->Write(5,"Carta Convenio de Pago", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->SetFont('Helvetica', '', 9, '', true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,$Parametros->cd_edo_expedicion." a ".$Dia_neg." de ".$Meses[$Mes_neg-1]. " de ".$Anio_neg.", se acuerda el pago del crédito ".$Hconvenio->Dmacct." entre agencia ".$Parametros->razon_soc." en nombre de HSBC y el Cliente ".$Hconvenio->Nombre, $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"A fin de celebrar el presente CONVENIO DE PAGO las partes pactan las siguientes:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"CLAUSULAS:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"I. El pago será realizado directamente al número del crédito ".substr($Hconvenio->Dmacct,-16)." a nombre de ".$Hconvenio->Nombre." en cualquier sucursal de HSBC MÉXICO, S.A., INSTITUCIÓN DE BANCA MÚLTIPLE, GRUPO FINANCIERO HSBC, en días y horas hábiles como a continuación se detalla:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"II. El monto de Pago acordado y descrito a continuación le permitirá liquidar su adeudo de forma total", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->writeHTML($Tabla_pagos, false, 0, true, 0);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"En caso de no poder realizar su pago en sucursal y en efectivo realícelo por transferencia a la clave interbancaria: ".$Hconvenio->Spei_num_key, $enlace="", $fondo=false, $alineacion="L", $nueva_linea=true);
         $pdf->Ln($Interlin);

        $pdf->Write(5,"Desglose del saldo:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->writeHTML($Tabla_saldos, false, 0, true, 0);
        $pdf->Write(5,"", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);

        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->Write(5,"III. En caso de incumplir con el/los pago/s descrito/s anteriormente en la fecha acordada, se dejará sin efecto el descuento o quita solicitada y en consecuencia procederá a aplicar los pagos realizados de acuerdo a los términos establecidos en el contrato de apertura de crédito respectivo y / o convenios modificatorios.", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);

        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->Write(5,"IV. Se acredito previo a la negociación, la identificación del cliente.", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
       
         $pdf->Ln($Interlin);
        $pdf->Write(5,"ATENTAMENTE", $enlace="", $fondo=false, $alineacion="C", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write( 5,$Parametros->cd_edo_expedicion." a ".$Dia_neg." de ".$Meses[$Mes_neg-1]. " de ".$Anio_neg, $enlace="", $fondo=false, $alineacion="C", $nueva_linea=true );
         $pdf->Ln($Interlin);
        $pdf->Write(5,"AGENCIA", $enlace="", $fondo=false, $alineacion="L", $nueva_linea=false);
        $pdf->Write(5,"CLIENTE", $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $sign = '<img src="'.$Parametros->imagen_firma_ag.'"  width="125" height="50">';
        $pdf->writeHTML($sign, false, 0, true, 0);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"_______________________________________", $enlace="", $fondo=false, $alineacion="", $nueva_linea=false);
        $pdf->Write(5,"_______________________________________", $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $pdf->Write(5, $Parametros->nombrefirma_ag, $enlace="", $fondo=false, $alineacion="", $nueva_linea=false);
        $pdf->Write(5,"C. ".$Hconvenio->Nombre, $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $pdf->Write(5,"Apoderado Legal de Legaxxi", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);

        $pdf->SetFont('Helvetica', '', 7, '', true);
        $pdf->writeHTML($Parametros->nota_final, true, 0, true, 0);

        $nombre_archivo = utf8_decode("Convenio_".$Hconvenio->Dmacct.".pdf");
        $pdf->Output($nombre_archivo, 'D');
    }

    function GenerarPdf9() {            // CONSUMER PAGO EN EXHIBICIONES O A PLAZOS 
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        // $pdf->setData($this->session->Empresa, $this->session->Rfc);
        $pdf->setData("LEGAXXI", "RFC999999XXX");
        $pdf->SetCreator('');
        $pdf->SetAuthor('LEGAXXI');
        $pdf->SetTitle('LEGAXXI');
        $pdf->SetSubject('CONVENIOS');
        $pdf->SetKeywords('');
 
        $pdf->SetHeaderData("logo_legaxxi_conv.png", 15, "LEGAXXI", "CONVENIOS", array(0,0,0), array(0,0,0));
        $pdf->setFooterData($tc = array(0, 0, 0), $lc = array(0, 0, 0));

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
 
        // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(10, PDF_MARGIN_TOP, 10);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
 
        // $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetAutoPageBreak(TRUE, 20);
 
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
 
 
        $pdf->setFontSubsetting(true);
 
        $pdf->SetFont('Helvetica', '', 9, '', true);
 
        $pdf->AddPage();

        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

        $Convenioid = $this->input->post("Convenioid");

        // Obtenemos los parametros generales del convenio
        $Parametros = $this->Parametros_model->GetUnique();

        // Datos del convenio y armado de tablas e informacion general
        $Hconvenio = $this->Convenios_model->GetById($Convenioid);
        // var_dump($Convenioid);

        // Este codigo es para subsanar un bug en el helper ConvertirNumeroALetra()
        // ya que no interpreta correctamente valores que no incluyan un entero 
        // es decir, etre entre 0 y .99 
        // if($Quita_cond >= 0 && $Quita_cond <1){
        //     $Quita_str = (string) $Quita_cond;
        //     $Decimals = substr( $Quita_str, strpos( $Quita_str, "." )+1, 2 );
        //     if($Decimals == ''){
        //         $Decimals = '00';
        //     }            
        //     $QC_enletra = 'Cero pesos '.$Decimals.'/100 M.N.';
        // }else{
        //     $QC_enletra = ConvertirNumeroALetra($Quita_cond); 
        // }
        $Nombreconvenio = $this->Tiposnego_model->GetNombreByid($Hconvenio->Tipo_negoid);

        $Descuento=0;
        if($Hconvenio->Saldo_usado = "T")       // Saldo total
        {
            $Descuento = $Hconvenio->Uxtot_adeu-$Hconvenio->Total_pago;
        }else{                                  // Saldo contable
            $Descuento = $Hconvenio->Dmcurbal-$Hconvenio->Total_pago;
        }

        // Detalle y armado de tabla de saldos
        $Tabla_saldos = '<table border=".5" align="center" bordercolor="black" cellspacing="0">';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">MONTO PRINCIPAL</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Mto_principal,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">INTERESES ORDINARIOS</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Int_ordinario,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">MORATORIOS</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Moratorios,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">COMISIONES</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Comp_exigible,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">TOTAL ADEUDO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Total_adeudo,2).'</td>
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">TOTAL VENCIDO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Dmamtdlq,2).'</td>
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">PAGO ACORDADO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Total_pago,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">DESCUENTO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Descuento,2).'</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 260px; text-align:left">% DE DESCUENTO SOBRE TOTAL ADEUDO</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.number_format($Hconvenio->Quita_neg,2).'%</td>                           
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '</table>'; 


        //Detalle de pagos y armado de tabla de pagos
        $Tabla_pagos = '<table border=".5" align="center" bordercolor="black" cellspacing="0">';
        $Tabla_pagos = $Tabla_pagos . '<tr style="height: 30px;">
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">Numero de pagos</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">Monto de pago</td>
                            <td style="border: .5px solid #000000; width: 150px; text-align:center">Fecha limite de pago</td>                            
                        </tr>';

        $Dconvenio = $this->Convdeta_model->GetDetailsById($Convenioid);

        $Interlin = 1;
        if($Dconvenio){

            $Totalitems = count($Dconvenio);

            if($Totalitems > 2){
                $Interlin = .5;
            }else{
                $Interlin = 1;
            }

            $Itemnumber = 1;
            foreach($Dconvenio as $Item) {
                    $FechaHoraOriginal = $Item->Fecha_pago;
                    $Hora = substr($FechaHoraOriginal,11,8);
                    $Fechapago = substr($FechaHoraOriginal,8,2).'/'.substr($FechaHoraOriginal,5,2).'/'.substr($FechaHoraOriginal,0,4);

                    if($Itemnumber == 1){
                        $Td_numpagos = '<td style="border: .5px solid #000000; width: 100px; vertical-align:middle; text-align:center; " rowspan="'.$Totalitems.'">'.$Totalitems.'</td>';
                    }else{
                        $Td_numpagos = '';
                    }

                    $Tabla_pagos = $Tabla_pagos . '<tr style="height: 30px; color:#000000;">'.$Td_numpagos.'
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Item->Importe_pago,2).'</td>
                            <td style="border: .5px solid #000000; width: 150px; text-align:center">'.$Fechapago.'</td>
                        </tr>';

                $Itemnumber++;

            }
        } 

        $Tabla_pagos = $Tabla_pagos . '</table>';     

        //Detalle de cabecera para datos generales del convenio
        $Tabla_head = '<table border="0" align="left" bordercolor="white" cellspacing="0">';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">FOLIO: '.$Hconvenio->Folio_pre."-".str_pad($Hconvenio->Folio_cons, 4, "0", STR_PAD_LEFT) .'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">AGENCIA: '.$Parametros->razon_soc.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">NEGOCIACION: '.$Nombreconvenio.'</td>                       
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">CREDITO: '.$Hconvenio->Dmacct.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '<tr style="height: 30px;">
                            <td style="width: 400px; text-align:left">NOMBRE: '.$Hconvenio->Nombre.'</td>                        
                        </tr>';
        $Tabla_head = $Tabla_head . '</table>';

        $TodayDate = unix_to_human(time(), TRUE, 'us');
        $TodayDate = date("d/m/Y H:i:s A", strtotime($TodayDate));

        $FechaHoraOriginal = $Hconvenio->Fecha_emi;
        $Hora = substr($FechaHoraOriginal,11,8);
        $Dia_emi = substr($FechaHoraOriginal,8,2);
        $Mes_emi = intval(substr($FechaHoraOriginal,5,2));
        $Anio_emi = substr($FechaHoraOriginal,0,4);

        $FechaHoraOriginal = $Hconvenio->Fecha_neg;
        $Hora = substr($FechaHoraOriginal,11,8);
        $Dia_neg = substr($FechaHoraOriginal,8,2);
        $Mes_neg = intval(substr($FechaHoraOriginal,5,2));
        $Anio_neg = substr($FechaHoraOriginal,0,4);        

        $Meses =['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

        //$pdf->SetFontSize(11);
        $image_file1 = 'img\logo_legaxxi_conv.png';
        $image_file2 = 'img\logo_HSBC_conv.png';
        $pdf->Image($image_file1, 10, 5, 0, 15, 'PNG', '', 'T', false, 100, '', false, false, 0, false, false, false);
        $pdf->Image($image_file2, 65, 5, 0, 15, 'PNG', '', 'T', false, 100, '', false, false, 0, false, false, false);
        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->writeHTML($Tabla_head, false, 0, true, 0);

        $pdf->Write(5,"", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->Write(5,"", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->SetFont('Helvetica', 'B', 9, '', true);
        $pdf->Write(5,"Carta Convenio de Pago", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->SetFont('Helvetica', '', 9, '', true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,$Parametros->cd_edo_expedicion." a ".$Dia_neg." de ".$Meses[$Mes_neg-1]. " de ".$Anio_neg.", se acuerda el pago del crédito ".$Hconvenio->Dmacct." entre agencia ".$Parametros->razon_soc." en nombre de HSBC y el Cliente ".$Hconvenio->Nombre, $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"A fin de celebrar el presente CONVENIO DE PAGO las partes pactan las siguientes:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"CLAUSULAS:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"I. El pago será realizado directamente al número del crédito ".substr($Hconvenio->Dmacct,-16)." a nombre de ".$Hconvenio->Nombre." en cualquier sucursal de HSBC MÉXICO, S.A., INSTITUCIÓN DE BANCA MÚLTIPLE, GRUPO FINANCIERO HSBC, en días y horas hábiles como a continuación se detalla:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"II. El monto de Pago acordado y descrito a continuación le permitirá liquidar su adeudo de forma total", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->writeHTML($Tabla_pagos, false, 0, true, 0);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"En caso de no poder realizar su pago en sucursal y en efectivo realícelo por transferencia a la clave interbancaria: ".$Hconvenio->Spei_num_key, $enlace="", $fondo=false, $alineacion="L", $nueva_linea=true);
         $pdf->Ln($Interlin);

        $pdf->Write(5,"Desglose del saldo:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->writeHTML($Tabla_saldos, false, 0, true, 0);
        $pdf->Write(5,"", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);

        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->Write(5,"III. En caso de incumplir con el/los pago/s descrito/s anteriormente en la fecha acordada, se dejará sin efecto el descuento o quita solicitada y en consecuencia procederá a aplicar los pagos realizados de acuerdo a los términos establecidos en el contrato de apertura de crédito respectivo y / o convenios modificatorios.", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);

        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->Write(5,"IV. Se acredito previo a la negociación, la identificación del cliente.", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
       
         $pdf->Ln($Interlin);
        $pdf->Write(5,"ATENTAMENTE", $enlace="", $fondo=false, $alineacion="C", $nueva_linea=true);
         $pdf->Ln($Interlin);
        $pdf->Write( 5,$Parametros->cd_edo_expedicion." a ".$Dia_neg." de ".$Meses[$Mes_neg-1]. " de ".$Anio_neg, $enlace="", $fondo=false, $alineacion="C", $nueva_linea=true );
         $pdf->Ln($Interlin);
        $pdf->Write(5,"AGENCIA", $enlace="", $fondo=false, $alineacion="L", $nueva_linea=false);
        $pdf->Write(5,"CLIENTE", $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $sign = '<img src="'.$Parametros->imagen_firma_ag.'"  width="125" height="50">';
        $pdf->writeHTML($sign, false, 0, true, 0);
         $pdf->Ln($Interlin);
        $pdf->Write(5,"_______________________________________", $enlace="", $fondo=false, $alineacion="", $nueva_linea=false);
        $pdf->Write(5,"_______________________________________", $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $pdf->Write(5, $Parametros->nombrefirma_ag, $enlace="", $fondo=false, $alineacion="", $nueva_linea=false);
        $pdf->Write(5,"C. ".$Hconvenio->Nombre, $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $pdf->Write(5,"Apoderado Legal de Legaxxi", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
         $pdf->Ln($Interlin);

        $pdf->SetFont('Helvetica', '', 7, '', true);
        $pdf->writeHTML($Parametros->nota_final, true, 0, true, 0);

        $nombre_archivo = utf8_decode("Convenio_".$Hconvenio->Dmacct.".pdf");
        $pdf->Output($nombre_archivo, 'D');
    }

}
