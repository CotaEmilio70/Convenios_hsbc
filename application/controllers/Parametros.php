<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Parametros extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set("America/Mexico_City");

        if(!$this->session->Logged){
            $this->session->set_flashdata('error', 'Autenticarse para entrar al sistema');
            redirect("Users/LogIn");
        }
    }

    function Details($Id = 0){
        if(!VerificarPermisos($this->session->UID, "Parametros", "Details")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a esta opcion. Contacte al administrador.');
            redirect("");
        }
        $Parametros = $this->Parametros_model->GetUnique();
        if(!$Parametros){
            $Data['heading'] = "Page Not Found";
            $Data['message'] = "The page you requested was not found.";
            $this->load->view('errors/html/error_general', $Data);
            return;
        }

        $UltimoCode = "Sin conexion al CRM";
        // $UltimoCode = $this->Altitude_model->ObtenerUltimoCode()->easycode;

        $Data["UpdatedBy"] = $this->Users_model->GetByUserName($Parametros->UpdatedBy)->Name;
        $Data["UltimoCode"] = $UltimoCode;
        $Data['title'] = "Detalles de parametros";
        $Data['Parametros'] = $Parametros;
        $this->load->view('layouts/_menu', $Data);
        $this->load->view('Parametros/Details', $Data);
        $this->load->view('layouts/footer');
    }

    function Edit(){
        if(!VerificarPermisos($this->session->UID, "Parametros", "Edit")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a esta opcion. Contacte al administrador.');
            redirect("");
        }
        $Parametros = $this->Parametros_model->GetUnique();

        if(!$Parametros)
        {
            $Data['heading'] = "Page Not Found";
            $Data['message'] = "The page you requested was not found.";
            $this->load->view('errors/html/error_general', $Data);
            return;
        }
        $Data["UpdatedBy"] = $this->Users_model->GetByUserName($Parametros->UpdatedBy)->Name;
        $Data['title'] = "Editar parametros";
        $Data['Parametros'] = $Parametros;

        $this->load->view('layouts/_menu', $Data);
        $this->load->view('Parametros/Edit', $Data);
        $this->load->view('layouts/footer');

    }

    function EditPost(){
        if(!VerificarPermisos($this->session->UID, "Parametros", "Edit")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a esta opcion. Contacte al administrador.');
            redirect("");
        }
        if($this->input->post()){
            $OriginalParametros = $this->Parametros_model->GetUnique();
            $TodayDate = unix_to_human(time(), TRUE, 'mx');
            $LoggedUserId = $this->session->UID;

            // Si cambiaron el archivo con la imagen de la firma la cargamos y actualizamos el dato
            if($_FILES["archivoimagen"]["name"])
            {
                $filename = $_FILES["archivoimagen"]["name"]; //Obtenemos el nombre original del archivo
                $source = $_FILES["archivoimagen"]["tmp_name"]; //Obtenemos un nombre temporal del archivo
                $tipo = $_FILES["archivoimagen"]["type"]; //Obtenemos el tipo del archivo
                
                $directorio = 'img'; //Declaramos un  variable con la ruta donde guardaremos los archivos
                                    
                $dir=opendir($directorio); //Abrimos el directorio de destino
                $destino = $directorio.'/'.$filename; //Indicamos la ruta de destino, así como el nombre del archivo
                
                //Movemos y validamos que el archivo se haya cargado correctamente
                //El primer campo es el origen y el segundo el destino
                //Grabamos el registro en la tabla con el url de la nueva imagen
                if(move_uploaded_file($source, $destino)) { 
                    $UpdatedImage = array(
                        "Clave" => 1,
                        "imagen_firma_ag" => $destino,
                        "UpdatedBy" => $LoggedUserId,
                        "UpdatedDate" => $TodayDate
                    );

                    $result = $this->Parametros_model->Update($UpdatedImage);
                }
                closedir($dir); //Cerramos el directorio de destino
            }          

            $EditParametros = array(
                "Clave" => 1,
                "razon_soc" => $this->input->post("Nombreempresa"),
                "direccion" => $this->input->post("Direccion"),
                "rfc" => $this->input->post("RFC"),
                "entidad_financiera" => $this->input->post("entidad_financiera"),
                "nombrecorto_ef" => $this->input->post("nombrecorto_ef"),
                "direccion_ef" => $this->input->post("direccion_ef"),
                "telefono_ef" => $this->input->post("telefono_ef"),
                "nombrefirma_ag" => $this->input->post("nombrefirma_ef"),
                "cd_edo_expedicion" => $this->input->post("cd_edo_expedicion"),
                "nota_final" => $this->input->post("nota_final"),
                "verconv_usr" => $this->input->post("verconv_usr"),
                "verconv_sup" => $this->input->post("verconv_sup"),
                "UpdatedBy" => $LoggedUserId,
                "UpdatedDate" => $TodayDate
            );

            $result = $this->Parametros_model->Update($EditParametros);
            if($result){
                $this->session->set_flashdata('message_details', 'Se modificaron exitosamente los parametros.');
                $this->session->set_flashdata('class', 'success');
                redirect("Parametros/Details");
            }else{
                $this->session->set_flashdata('message_edit', 'Hubo un error al registrar');
                $this->session->set_flashdata('class', 'danger');
            }
        }
        $Data["UpdatedBy"] = $this->Users_model->GetByUserName($OriginalParametros->UpdatedBy)->Name;
        $Data['title'] = "Editar parametros";
        $Data['Parametros'] = $OriginalParametros;
        set_value("Nombreempresa","Direccion", "Telefono", "RFC");
        $this->load->view('layouts/_menu', $Data);
        $this->load->view('Parametros/Edit', $Data);
        $this->load->view('layouts/footer');
    }

}
