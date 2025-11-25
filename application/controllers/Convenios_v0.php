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
        $Page = 1;
        $Cuenta = "";
        $Nombre = "";
        if($this->input->post()){
            $Cuenta = $this->input->post('Cuenta');
            $Nombre = $this->input->post('Nombre');
            $Page = $this->input->post("Page");
        }
        set_value("Cuenta", "Nombre");
        $Pages = $this->Convenios_model->GetPages($Page, $Cuenta, $Nombre);
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

        $Data['fecha_neg']= $TodayDate;
        $Data['title'] = "Crear nuevo convenio";
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
                $Cuenta= $this->input->post("Cuenta");
                $Fechatmp= $this->input->post("Fecha_neg");
                $FechaExplode = explode("/", $Fechatmp);
                $Fechaneg = new DateTime($FechaExplode[2]."-".$FechaExplode[1]."-".$FechaExplode[0]);

                $Detalle = $this->input->post("lstDetalle");

                $NewConv = array(
                    "Cuenta_pan" => $this->input->post("Cuenta_pan"),
                    "Cuenta_12d" => $this->input->post("Cuenta"),
                    "Sucursal" => $this->input->post("Sucursal"),
                    "Nombre" => $this->input->post("Nombre"),
                    "Fecha_neg" => $Fechaneg->format("Y-m-d"),
                    "Fecha_emi" => $TodayDate,
                    "Segmento" => $this->input->post("Segmento"),
                    "Nombre" => $this->input->post("Nombre"),
                    "Calle_num" => $this->input->post("Calle_num"),
                    "Colonia" => $this->input->post("Colonia"),
                    "Ciudad" => $this->input->post("Ciudad"),
                    "Estado" => $this->input->post("Estado"),
                    "Cp" => $this->input->post("Cp"),
                    "Saldo_act" => str_replace(',','',$this->input->post("Saldo_act")),
                    "Saldo_cap" => str_replace(',','',$this->input->post("Saldo_cap")),
                    "Intereses" => str_replace(',','',$this->input->post("Intereses")),
                    "Comisiones" => str_replace(',','',$this->input->post("Comisiones")),
                    "Impuestos" => str_replace(',','',$this->input->post("Impuestos")),
                    "Quitamax" => $this->input->post("Quita"),
                    "Total_pago" => str_replace(',','',$this->input->post("Totalpago")),
                    "Cliente" => $this->input->post("Cliente"),
                    "Observaciones" => $this->input->post("Observaciones"),
                    "Cancelado" => 0,
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
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a este catalogo. Contacte al administrador.');
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

        $Data["Createdby"] = $this->Users_model->GetByUserName($Convenio->CreatedBy)->Name;
        $Data["Updatedby"] = $this->Users_model->GetByUserName($Convenio->UpdatedBy)->Name;
        $Data['title'] = "Editar convenio";
        $Data['Convenio'] = $Convenio;
        $Data['Tblpagos'] = $Tblpagos;
        $Data['Totalpago'] = $Totalpago;
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
                "Cuenta_pan" => $this->input->post("Cuenta_pan"),
                "Cuenta_12d" => $this->input->post("Cuenta"),
                "Sucursal" => $this->input->post("Sucursal"),
                "Nombre" => $this->input->post("Nombre"),
                "Fecha_neg" => $Fechaneg->format("Y-m-d"),
                "Fecha_emi" => $TodayDate,
                "Segmento" => $this->input->post("Segmento"),
                "Nombre" => $this->input->post("Nombre"),
                "Calle_num" => $this->input->post("Calle_num"),
                "Colonia" => $this->input->post("Colonia"),
                "Ciudad" => $this->input->post("Ciudad"),
                "Estado" => $this->input->post("Estado"),
                "Cp" => $this->input->post("Cp"),
                "Saldo_act" => str_replace(',','',$this->input->post("Saldo_act")),
                "Saldo_cap" => str_replace(',','',$this->input->post("Saldo_cap")),
                "Intereses" => str_replace(',','',$this->input->post("Intereses")),
                "Comisiones" => str_replace(',','',$this->input->post("Comisiones")),
                "Impuestos" => str_replace(',','',$this->input->post("Impuestos")),
                "Quitamax" => $this->input->post("Quita"),
                "Total_pago" => str_replace(',','',$this->input->post("Totalpago")),
                "Cliente" => $this->input->post("Cliente"),
                "Observaciones" => $this->input->post("Observaciones"),
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
                "Cancelado" => 1,
                "DeletedBy" => $LoggedUserId,
                "DeletedDate" => $TodayDate
            );
          
            $result = $this->Convenios_model->Update($CancelConv);

            $this->Convdeta_model->DeleteByIdConv($this->input->post("Idconvenio"));

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

        $partida = $this->input->get("Row");

        $fechaneg_post = $this->input->get("Fechaneg");
        $fecha1 = str_replace('/', '-', $fechaneg_post);
        $fechaneg_tmp =  date("d-m-Y",strtotime($fecha1));
        $fechaneg = date_create_from_format('d-m-Y', $fechaneg_tmp);

        $fechapago_post = $this->input->get("Fechapago");
        $fecha2 = str_replace('/', '-', $fechapago_post);
        $fechapago_tmp =  date("d-m-Y",strtotime($fecha2));
        $fechapago = date_create_from_format('d-m-Y', $fechapago_tmp);

        $mas7dias =  date("d-m-Y",strtotime($fecha1."+ 15 days"));
        $mas7 = date_create_from_format('d-m-Y', $mas7dias);

        $diferencia = date_diff($fechaneg, $fechapago);
        $diasdif = intval($diferencia->format('%R%a'));

        $ObjectResponse['errormsg'] ='';

        // $ObjectResponse['errormsg'] ='El numero de partida es: '.$partida;

        if($partida == '0' || $partida == 0){
            if($diasdif < 0){
                $ObjectResponse['errormsg'] ='La fecha de pago inicial no puede ser anterior a la fecha de la negociacion.';
            }else{
                if($diasdif > 15){
                    $ObjectResponse['errormsg'] ='La fecha de pago inicial no debe exceder 15 dias a la fecha de negociacion.';
                }
            }
        }else{
            if($diasdif < 0){
                $ObjectResponse['errormsg'] ='La fecha de pago no puede ser anterior a la fecha de la negociacion.';
            }else{
                if($diasdif > 90){
                    $ObjectResponse['errormsg'] ='La fecha de pago subsecuente no debe exceder los 90 dias a la fecha de negociacion.';
                }
            }            
        }

        echo json_encode($ObjectResponse);

    }

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
            $result = $this->Altitude_model->GetProfile($Cuenta);
            if($result){
                $ObjectResponse['first'] = $result->first;
                $ObjectResponse['home_street'] = $result->home_street;
                $ObjectResponse['home_city'] = $result->home_city;
                $ObjectResponse['home_postal_code'] = $result->home_postal_code;

                $ObjectResponse['idcuenta'] = '';
                $ObjectResponse['col_casa'] = '';
                $ObjectResponse['supervisionn'] = '';
                $ObjectResponse['quita'] = 0;
                $ObjectResponse['status'] = '';

                $easycode=$result->code;

                $resultrec = $this->Altitude_model->GetRecovery($easycode);
                if($resultrec){
                    $ObjectResponse['idcuenta'] = $resultrec->idcuenta;
                    $ObjectResponse['col_casa'] = $resultrec->col_casa;
                    $ObjectResponse['supervisionn'] = $resultrec->segmento;
                    $ObjectResponse['quita'] = $resultrec->quita;
                    $ObjectResponse['cliente'] = $resultrec->cliente;
                    $ObjectResponse['saldo_total'] = $resultrec->saldo_total;
                    $ObjectResponse['saldo_cap'] = $resultrec->capital1;
                    $ObjectResponse['intereses'] = $resultrec->interes;
                    $ObjectResponse['impuestos'] = $resultrec->impuestos;
                    $ObjectResponse['comisiones'] = $resultrec->comisiones;
                    $ObjectResponse['cuenta_pan'] = $resultrec->cuenta16;
                    $ObjectResponse['status'] = ($resultrec->activo == 0) ? "INACTIVO" : "ACTIVO";
                }else{
                    $resultback = $this->Altitude_model->GetBackend($easycode);
                    if($resultback){
                        $ObjectResponse['idcuenta'] = $resultback->idcuenta;
                        $ObjectResponse['col_casa'] = $resultback->col_casa;
                        $ObjectResponse['supervisionn'] = $resultback->segmento;
                        $ObjectResponse['quita'] = $resultback->quita;
                        $ObjectResponse['cliente'] = $resultback->cliente;
                        $ObjectResponse['saldo_total'] = $resultback->saldo_total;
                        $ObjectResponse['saldo_cap'] = $resultback->capital1;
                        $ObjectResponse['intereses'] = $resultback->interes;
                        $ObjectResponse['impuestos'] = $resultback->impuestos;
                        $ObjectResponse['comisiones'] = $resultback->comisiones;
                        $ObjectResponse['cuenta_pan'] = $resultback->cuenta16;
                        $ObjectResponse['status'] = ($resultback->activo == 0) ? "INACTIVO" : "ACTIVO";
                    }            
                }

                if($ObjectResponse['status'] == 'ACTIVO'){
                    $ObjectResponse['errormsg'] ='';
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

    function GenerarPdf() {
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        // $pdf->setData($this->session->Empresa, $this->session->Rfc);
        $pdf->setData("CORP MAX", "RFC999999XXX");
        $pdf->SetCreator('');
        $pdf->SetAuthor('LEGAXXI');
        $pdf->SetTitle('LEGAXXI');
        $pdf->SetSubject('CONVENIOS FALABELLA');
        $pdf->SetKeywords('');
 
        $pdf->SetHeaderData("logo1.png", 15, "LEGAXXI", "CONVENIOS", array(0,0,0), array(0,0,0));
        $pdf->setFooterData($tc = array(0, 0, 0), $lc = array(0, 0, 0));

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
 
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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

        // Datos del convenio y armado de tablas e informacion general
        $Hconvenio = $this->Convenios_model->GetById($Convenioid);

        $Quita_capital = ($Hconvenio->Saldo_cap - $Hconvenio->Total_pago) >0 ? ($Hconvenio->Saldo_cap - $Hconvenio->Total_pago) : 0;

        if($Hconvenio->Saldo_cap > 0){
            $Por_quita_Cap = intval(($Quita_capital/$Hconvenio->Saldo_cap)*100);
        }else{
            $Por_quita_Cap = 0;
        }
        $QC_tipo = $Por_quita_Cap > 0 ? "QUITA" : "CONDONACIÓN";

        if( ($Hconvenio->Saldo_cap - $Hconvenio->Total_pago - $Hconvenio->Impuestos) > 0)
        {
            $Quita_cond = $Quita_capital;
        }else{
            $Quita_cond = $Hconvenio->Saldo_act - $Hconvenio->Total_pago;
            if($Quita_cond < 0){
                $Quita_cond = 0;
            }                         
        }

        // Este codigo es para subsanar un bug en el helper ConvertirNumeroALetra()
        // ya que no interpreta correctamente valores que no incluyan un entero 
        // es decir, etre entre 0 y .99 
        if($Quita_cond >= 0 && $Quita_cond <1){
            $Quita_str = (string) $Quita_cond;
            $Decimals = substr( $Quita_str, strpos( $Quita_str, "." )+1, 2 );
            if($Decimals == ''){
                $Decimals = '00';
            }            
            $QC_enletra = 'Cero pesos '.$Decimals.'/100 M.N.';
        }else{
            $QC_enletra = ConvertirNumeroALetra($Quita_cond);
        }
        
        // $QC_enletra = strval($Quita_cond);

        $Tabla_saldos = '<table border=".5" align="center" bordercolor="black" cellspacing="0" valign="middle">';
        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px; background-color:#0e813c;color:#ffffff;">
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">Capital</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">Intereses y comisiones</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">Iva</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">Saldo Total</td>
                        </tr>';

        $Tabla_saldos = $Tabla_saldos . '<tr style="height: 30px; color:#000000;">
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Saldo_cap,2).'</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Intereses+$Hconvenio->Comisiones,2).'</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Impuestos,2).'</td>
                            <td style="border: .5px solid #000000; width: 100px; text-align:center">'.'$'.number_format($Hconvenio->Saldo_act,2).'</td>
                        </tr>';
        $Tabla_saldos = $Tabla_saldos . '</table>';

        // Armado de tabla del descuento aplicado
        $Tabla_descuento = '<table border=".5" align="center" bordercolor="black" cellspacing="0" valign="middle">';
        $Tabla_descuento = $Tabla_descuento . '<tr style="height: 30px; background-color:#0e813c;color:#ffffff;">
                            <td style="border: .5px solid #000000; width: 90px; text-align:center">SEGMENTO</td>
                            <td style="border: .5px solid #000000; width: 90px; text-align:center">% DESCUENTO APLICADO</td>
                            <td style="border: .5px solid #000000; width: 90px; text-align:center">SALDO</td>
                            <td style="border: .5px solid #000000; width: 90px; text-align:center">CAPITAL E IMPUESTOS</td>
                            <td style="border: .5px solid #000000; width: 90px; text-align:center">CAPITAL</td>
                            <td style="border: .5px solid #000000; width: 90px; text-align:center">QUITA CAPITAL</td>
                            <td style="border: .5px solid #000000; width: 90px; text-align:center">PAGO (con iva incluido)</td>
                        </tr>';

        $Tabla_descuento = $Tabla_descuento . '<tr style="height: 30px; color:#000000;">
                            <td style="border: .5px solid #000000; width: 90px; text-align:center">'.$Hconvenio->Segmento.'</td>
                            <td style="border: .5px solid #000000; width: 90px; text-align:center">'.$Por_quita_Cap.'% </td>
                            <td style="border: .5px solid #000000; width: 90px; text-align:center">'.'$'.number_format($Hconvenio->Saldo_act,2).'</td>
                            <td style="border: .5px solid #000000; width: 90px; text-align:center">'.'$'.number_format($Hconvenio->Saldo_cap+$Hconvenio->Impuestos,2).'</td>
                            <td style="border: .5px solid #000000; width: 90px; text-align:center">'.'$'.number_format($Hconvenio->Saldo_cap,2).'</td>
                            <td style="border: .5px solid #000000; width: 90px; text-align:center">'.'$'.number_format($Quita_capital,2).'</td>
                            <td style="border: .5px solid #000000; width: 90px; text-align:center">'.'$'.number_format($Hconvenio->Total_pago,2).'</td>
                        </tr>';
        $Tabla_descuento = $Tabla_descuento . '</table>';

        //Detalle de pagos y armado de tabla de pagos
        $Tabla_pagos = '<table border=".5" align="center" bordercolor="black" cellspacing="0">';
        $Tabla_pagos = $Tabla_pagos . '<tr style="height: 30px; background-color:#9CC663;color:#ffffff;">
                            <td style="border: .5px solid #000000; width: 180px; text-align:center">Fecha de pago</td>
                            <td style="border: .5px solid #000000; width: 180px; text-align:center">Monto a pagar</td>
                        </tr>';

        $Dconvenio = $this->Convdeta_model->GetDetailsById($Convenioid);
        if($Dconvenio){
            foreach($Dconvenio as $Item) {
                    $FechaHoraOriginal = $Item->Fecha_pago;
                    $Hora = substr($FechaHoraOriginal,11,8);
                    $Fechapago = substr($FechaHoraOriginal,8,2).'/'.substr($FechaHoraOriginal,5,2).'/'.substr($FechaHoraOriginal,0,4);

                    $Tabla_pagos = $Tabla_pagos . '<tr style="height: 30px; color:#000000;">
                            <td style="border: .5px solid #000000; width: 180px; text-align:center">'.$Fechapago.'</td>
                            <td style="border: .5px solid #000000; width: 180px; text-align:center">'.'$'.number_format($Item->Importe_pago,2).'</td>
                        </tr>';
            }
        }                        

        $Tabla_pagos = $Tabla_pagos . '</table>';

        // color verde hexa: 0e813c        

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
        $pdf->SetFont('Helvetica', '', 9, '', true);
        // 2 ago 2024 se cambia la fecha de la carta para utilizar la fecha de la negociacion
        //$pdf->Write(5,"Monterrey, Nuevo León a ".$Dia_emi." de ".$Meses[$Mes_emi-1]. " de ".$Anio_emi, $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $pdf->Write(5,"Monterrey, Nuevo León a ".$Dia_neg." de ".$Meses[$Mes_neg-1]. " de ".$Anio_neg, $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        // $pdf->Ln();
        $pdf->Write(5,"Nombre completo ".$Hconvenio->Nombre, $enlace="", $fondo=false, $alineacion="L", $nueva_linea=true);
        $pdf->Write(5,"Calle y Número ".$Hconvenio->Calle_num, $enlace="", $fondo=false, $alineacion="L", $nueva_linea=true);
        $pdf->Write(5,"Colonia ".$Hconvenio->Colonia, $enlace="", $fondo=false, $alineacion="L", $nueva_linea=true);
        $pdf->Write(5,"Edo ".$Hconvenio->Ciudad, $enlace="", $fondo=false, $alineacion="L", $nueva_linea=true);
        $pdf->Write(5,"C.P. ".$Hconvenio->Cp, $enlace="", $fondo=false, $alineacion="L", $nueva_linea=true);    
        // $pdf->Write(5,"", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);

        $pdf->SetFont('Helvetica', 'B', 9, '', true);
        $pdf->Write(5,"No. CTA 16 Digitos ".$Hconvenio->Cuenta_pan, $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $pdf->Write(5,"SAT ".$Hconvenio->Cuenta_12d." SUC ".$Hconvenio->Sucursal, $enlace="", $fondo=false, $alineacion="R", $nueva_linea=true);
        $pdf->SetFont('Helvetica', '', 9, '', true);
        // $pdf->Ln();

        $pdf->Write(5,"Estimado cliente:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->Ln(.5);
        $pdf->Write(5,"Con el presente se confirma su intención de pago acordada el día ".$Dia_neg.". Servicios Financieros Soriana S.A.P.I de C.V. SOFOM E.N.R. (en lo sucesivo “SFS”) le ha autorizado convenio de pago para la liquidación de su TDC terminación ".substr($Hconvenio->Cuenta_pan,12,4).". El cual, fue acordado a través del despacho de cobranza CORP MAX DEL NOROESTE, quedando registrada en nuestros sistemas institucionales bajo las siguientes condiciones:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->Ln();

        // $pdf->SetX(50);
        $pdf->Write(5,"CALENDARIO CON MONTOS Y FECHAS ESPECÍFICAS", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->writeHTML($Tabla_pagos, false, 0, true, 0);
        $pdf->Ln(.5);
        $pdf->Write(5,"La Intención de pago antes descrita representa una ".$QC_tipo." por la cantidad total de $".number_format($Quita_cond,2)." (".$QC_enletra.") ", $enlace="", $fondo=false, $alineacion="L", $nueva_linea=true);
        $pdf->Ln(.5);

        $pdf->Write(5,"A la fecha de negociación su composición de saldo es la siguiente:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->writeHTML($Tabla_saldos, false, 0, true, 0);
        $pdf->Ln(.5);

        $pdf->Write(5,"Así mismo, se informa del descuento aplicado según negociación:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->writeHTML($Tabla_descuento, false, 0, true, 0);
        $pdf->Ln();

        $pdf->SetFont('Helvetica', 'B', 8, '', true);
        $pdf->Write(5,"Es importante mencionar que de no realizar los pagos en las fechas y por los importes antes citados, este acuerdo quedará sin efecto, por lo que el contrato de crédito celebrado con “SFS” conserva su fuerza legal en sus términos originalmente convenidos.", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->Ln(.5);

        $pdf->SetFont('Helvetica', 'B', 9, '', true);
        $pdf->Write(5,"Para su comodidad le hacemos de su conocimiento nuestros canales de pago:", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
       
        $pdf->SetMargins(20, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetFont('Helvetica', '', 9, '', true);
        $bullet1 = '<img src="check.png"  width="17" height="10"> En nuestras cajas de  <img src="logo_soriana_city.png"  width="100" height="15"> de su sucursal mas cercana, con una comisión de $5 pesos.';
        $bullet2 = '<img src="check.png"  width="17" height="10"> Ventanilla de cualquier banco indicando al cajero que hará un pago interbancario.';
        $bullet3 = '<img src="check.png"  width="17" height="10"> Banca en línea de su banco en la opción pagar tarjeta de crédito de otros bancos desde tu <img src="compu_cel.png" width="65" height="20">';
        $bullet4 = '<img src="check.png"  width="17" height="10"> Tiendas OXXO indicando hará un pago a su tarjeta de crédito, con una comisión de $15 pesos.';
        $pdf->writeHTML($bullet1, true, 0, true, 0);
        $pdf->writeHTML($bullet2, true, 0, true, 0);
        $pdf->writeHTML($bullet3, true, 0, true, 0);
        $pdf->writeHTML($bullet4, true, 0, true, 0);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->Ln();
        $pdf->Write(5,"Sin otro particular reciba un cordial saludo.", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->Ln();
        $sign = '<img src="img\firma_falabella.png"  width="100" height="40">';
        $pdf->writeHTML($sign, false, 0, true, 0);
        $pdf->Ln(.5);
        $pdf->Write(5,"_______________________________________", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->Write(5,"ATENTAMENTE", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->Write(5,"OSCAR DAVID I. RESENDIZ TOVAR", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->Write(5,"Alejandro de Rodas número 3102-A, colonia Cumbres 8° Sector, Monterrey, Nuevo León, C.P.64610.Telefono: 55 50894262", $enlace="", $fondo=false, $alineacion="", $nueva_linea=true);
        $pdf->Ln();

        $pdf->SetFont('Helvetica', '', 8, '', true);
        // $pdf->Write(5,"Para cualquier queja y/o aclaración relacionada con la gestión de cobranza de su cuenta con [“SFS” o “FALABELLA SORIANA”] pone a su disposición el siguiente correo electrónico: servicioaclientes@falabella.com.mx  y el teléfono 55 50894262 de Lunes a Viernes de 9:00am a 21:00pm. En caso de necesitar la liberación de carta finiquito ponemos a su disposición el correo electrónico cartasfiniquito@falabella.com.mx , necesario se adjunte este convenio junto con los comprobantes de pago en cumplimiento del acuerdo para seguimiento. Nuestros asesores, empleados y gestores de los despachos de cobranza, no están autorizados a recibir pago en efectivo ni de ninguna especie. Todos los pagos deberá realizarlos a través de los canales de pago que le fueron proporcionados en este documento. ", $enlace="", $fondo=false, $alineacion="", $nueva_linea=false);
        $notafinal = 'Para cualquier queja y/o aclaración relacionada con la gestión de cobranza de su cuenta con [“SFS” o “FALABELLA SORIANA”] pone a su disposición el siguiente correo electrónico: <span style="text-decoration: underline;">servicioaclientes@falabella.com.mx</span>  y el teléfono 55 50894262 de Lunes a Viernes de 9:00am a 21:00pm. En caso de necesitar la liberación de carta finiquito ponemos a su disposición el correo electrónico <span style="text-decoration: underline;">cartasfiniquito@falabella.com.mx</span> , necesario se adjunte este convenio junto con los comprobantes de pago en cumplimiento del acuerdo para seguimiento. Nuestros asesores, empleados y gestores de los despachos de cobranza, no están autorizados a recibir pago en efectivo ni de ninguna especie. Todos los pagos deberá realizarlos a través de los canales de pago que le fueron proporcionados en este documento.';
        $pdf->writeHTML($notafinal, true, 0, true, 0);

        $nombre_archivo = utf8_decode("Convenio_".$Hconvenio->Cuenta_12d.".pdf");
        $pdf->Output($nombre_archivo, 'D');
    }

}
