<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Importar extends CI_Controller {

    function __construct(){
        parent::__construct();

        if(!$this->session->Logged){
            $this->session->set_flashdata('error', 'Autenticarse para entrar al sistema');
            redirect("Users/LogIn");
        }
    }

    function Panes($Id = 0){
        if(!VerificarPermisos($this->session->UID, "Importar", "Panes")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a esta opcion. Contacte al administrador.');
            redirect("");
        }

        $Data['title'] = "Importar cuentas PAN";
        $this->load->view('layouts/_menu', $Data);
        $this->load->view('Importar/Panes', $Data);
        $this->load->view('layouts/footer');
    }

    function PanesPost(){
        if(!$this->session->Logged){
            $this->session->set_flashdata('error', 'Autenticarse para entrar al sistema');
            redirect("Users/LogIn");
        }

        if(!VerificarPermisos($this->session->UID, "Importar", "Panes")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a esta opcion. Contacte al administrador.');
            redirect("");
        }

        // die(  $_FILES['Archivo']['name'] );

        if($this->input->post())
        {

            $this->load->library('Excel');
            $name   = $_FILES['Archivo']['name'];
            $tname  = $_FILES['Archivo']['tmp_name'];
            $obj_excel = PHPExcel_IOFactory::load($tname);       
            $sheetData = $obj_excel->getActiveSheet()->toArray(null,true,true,true);

            $count = 0;
            foreach ($sheetData as $index => $value) {            
                if($count > 0)
                {
                    $Cuenta12d = $value["A"];
                    $Cuentapan = $value["B"];
                    
                    $recordexist = $this->Basepan_model->GetByCuenta12d($Cuenta12d);

                    if($recordexist){
                        $Registro = array(
                            "Id" => $recordexist->Id,
                            "Cuenta_12d" => $Cuenta12d,
                            "Cuenta_pan" => $Cuentapan,
                        );                        
                        $result = $this->Basepan_model->Update($Registro);
                    }else{
                        $Registro = array(
                            "Cuenta_12d" => $Cuenta12d,
                            "Cuenta_pan" => $Cuentapan,
                        );                        
                       $result = $this->Basepan_model->Create($Registro); 
                    }     
                }
                $count++;
            }
            $count--;

            // $result = $this->Importar_model->Update($EditImportar);
            $result = true;
            if($result){
                $this->session->set_flashdata('message_import', 'Se importaron y/o actualizaron exitosamente '.$count.' registros.');
                $this->session->set_flashdata('class', 'success');
                redirect("Importar/Panes");
            }else{
                $this->session->set_flashdata('message_import', 'Hubo un error al importar');
                $this->session->set_flashdata('class', 'danger');
            }
        }else{

            redirect("Importar/Panes");

        }

    }

}
