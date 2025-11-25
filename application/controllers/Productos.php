<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set("US/Arizona");

        if(!$this->session->Logged){
            $this->session->set_flashdata('error', 'Autenticarse para entrar al sistema');
            redirect("Users/LogIn");
        }
    }

    function Index()
    {
        if(!VerificarPermisos($this->session->UID, "Productos", "Index")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a este catalogo. Contacte al administrador.');
            redirect("");
        }
        $Page = 1;
        $Nombre = "";
        if($this->input->post()){
            $Nombre = $this->input->post('Nombre');
            $Page = $this->input->post("Page");
        }
        set_value("Nombre");
        $Pages = $this->Productos_model->GetPages($Page, $Nombre);
        if( $Pages <= 1){
            $Page = 1;
        }
        $Productos = $this->Productos_model->GetAll($Page, $Nombre);
        $Data['title'] = "Productos y quitas";
        $Data['Productos'] = $Productos;
        $Data['Pages'] = $Pages;
        $Data['ActualPage'] = $Page;
        $this->load->view('layouts/_menu', $Data);
        $this->load->view('Productos/Index', $Data);
        $this->load->view('layouts/footer');
    }

    function Create(){
        if(!VerificarPermisos($this->session->UID, "Productos", "Create")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a este catalogo. Contacte al administrador.');
            redirect("");
        }
        $Data['title'] = "Crear producto";
        $this->load->view('layouts/_menu', $Data);
        $this->load->view('Productos/Create', $Data);
        $this->load->view('layouts/footer');
    }

    function CreatePost(){
        if(!VerificarPermisos($this->session->UID, "Productos", "Create")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a este catalogo. Contacte al administrador.');
            redirect("");
        }
        if($this->input->post()){

            $TodayDate = unix_to_human(time(), TRUE, 'mx');
            $LoggedUserId = $this->session->UID;
            $NewProducto = array(
                "Nombre" => $this->input->post("Nombre"),
                "Numero" => $this->input->post("Numero"),
                "Active" => 1,
                "CreatedBy" => $LoggedUserId,
                "CreatedDate" => $TodayDate,
                "UpdatedBy" => $LoggedUserId,
                "UpdatedDate" => $TodayDate
            );
            $result = $this->Productos_model->Create($NewProducto);
            if($result){
                $this->session->set_flashdata('message_index', 'Se guardo exitosamente el registro');
                $this->session->set_flashdata('class', 'success');
                redirect("Productos");
            }else{
                $this->session->set_flashdata('message_create', 'Hubo un error al registrar');
                $this->session->set_flashdata('class', 'danger');
            }
            
            $Data['title'] = "Crear producto";
            $this->load->view('layouts/_menu', $Data);
            $this->load->view('Productos/Create', $Data);
            $this->load->view('layouts/footer');
        }
    }

    function Details($Id = 0){
        if(!VerificarPermisos($this->session->UID, "Productos", "Details")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a este catalogo. Contacte al administrador.');
            redirect("");
        }
        $Producto = $this->Productos_model->GetById($Id);
        if(!$Producto){
            $Data['heading'] = "Page Not Found";
            $Data['message'] = "The page you requested was not found.";
            $this->load->view('errors/html/error_general', $Data);
            return;
        }

        $Data["Createdby"] = $this->Users_model->GetByUserName($Producto->CreatedBy)->Name;
        $Data["Updatedby"] = $this->Users_model->GetByUserName($Producto->UpdatedBy)->Name;
        $Data['title'] = "Detalles de Productos";
        $Data['Producto'] = $Producto;
        $this->load->view('layouts/_menu', $Data);
        $this->load->view('Productos/Details', $Data);
        $this->load->view('layouts/footer');
    }

    function Edit($Id = 0){
        if(!VerificarPermisos($this->session->UID, "Productos", "Edit")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a este catalogo. Contacte al administrador.');
            redirect("");
        }
        $Producto = $this->Productos_model->GetById($Id);

        if(!$Producto)
        {
            $Data['heading'] = "Page Not Found";
            $Data['message'] = "The page you requested was not found.";
            $this->load->view('errors/html/error_general', $Data);
            return;
        }
        
        $Data["Createdby"] = $this->Users_model->GetByUserName($Producto->CreatedBy)->Name;
        $Data["Updatedby"] = $this->Users_model->GetByUserName($Producto->UpdatedBy)->Name;
        $Data['title'] = "Editar Producto";
        $Data['Producto'] = $Producto;
        set_value("Nombre");
        $this->load->view('layouts/_menu', $Data);
        $this->load->view('Productos/Edit', $Data);
        $this->load->view('layouts/footer');

    }

    function EditPost(){
        if(!VerificarPermisos($this->session->UID, "Productos", "Edit")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a este catalogo. Contacte al administrador.');
            redirect("");
        }
        if($this->input->post()){
            $OriginalProducto = $this->Productos_model->GetById($this->input->post("Id"));

            $TodayDate = unix_to_human(time(), TRUE, 'mx');
            $LoggedUserId = $this->session->UID;

            $EditProducto = array(
                "Id" => $this->input->post("Id"),
                "Nombre" => $this->input->post("Nombre"),
                "Numero" => $this->input->post("Numero"),
                "Updatedby" => $LoggedUserId,
                "Updateddate" => $TodayDate
            );
          
            $result = $this->Productos_model->Update($EditProducto);
            if($result){
                $this->session->set_flashdata('message_index', 'Se modifico exitosamente el registro');
                $this->session->set_flashdata('class', 'success');
                redirect("Productos");
            }else{
                $this->session->set_flashdata('message_edit', 'Hubo un error al registrar');
                $this->session->set_flashdata('class', 'danger');
            }
        }
        $Data["Createdby"] = $this->Users_model->GetByUserName($OriginalProducto->CreatedBy)->Name;
        $Data["Updatedby"] = $this->Users_model->GetByUserName($OriginalProducto->UpdatedBy)->Name;
        $Data['title'] = "Editar Producto";
        $Data['Producto'] = $OriginalProducto;
        set_value("Nombre");
        $this->load->view('layouts/_menu', $Data);
        $this->load->view('Productos/Edit', $Data);
        $this->load->view('layouts/footer');
    }

    function Delete(){
        if(!VerificarPermisos($this->session->UID, "Productos", "Delete")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a este catalogo. Contacte al administrador.');
            redirect("");
        }
        if($this->input->post())
        {
            $OriginalProducto = $this->Productos_model->GetById($this->input->post("Id"));
            $TodayDate = unix_to_human(time(), TRUE, 'mx');
            $LoggedUserId = $this->session->UID;

            $DeleteProducto = array(
                "Id" => $this->input->post("Id"),
                "Active" => false,
                "DeletedBy" => $LoggedUserId,
                "DeletedDate" => $TodayDate
            );
          
            $result = $this->Productos_model->Update($DeleteProducto);
            if($result){
                $this->session->set_flashdata('message_index', 'Se elimino exitosamente el registro');
                $this->session->set_flashdata('class', 'success');
                redirect("Productos");
            }else{
                $this->session->set_flashdata('message_details', 'Hubo un error al registrar');
                $this->session->set_flashdata('class', 'danger');
            }
            $Data["Createdby"] = $this->Users_model->GetByUserName($OriginalProducto->CreatedBy)->Name;
            $Data["Updatedby"] = $this->Users_model->GetByUserName($OriginalProducto->UpdatedBy)->Name;
            $Data['title'] = "Detalles del Producto";
            $Data['Producto'] = $OriginalProducto;
            $this->load->view('layouts/_menu', $Data);
            $this->load->view('Productos/Details', $Data);
            $this->load->view('layouts/footer');   
        }
    }

    function Quitas($Id = 0){
        if(!VerificarPermisos($this->session->UID, "Productos", "Edit")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a esta opcion. Contacte al administrador.');
            redirect("");
        }
        $Producto = $this->Productos_model->GetById($Id);

        if(!$Producto)
        {
            $Data['heading'] = "Page Not Found";
            $Data['message'] = "The page you requested was not found.";
            $this->load->view('errors/html/error_general', $Data);
            return;
        }

        $Quitas = $this->Quitas_model->GetByProducto($Id);

        $Fecha_vig = unix_to_human(time(), TRUE, 'mx');

        $Data["Quitas"] = $Quitas;
        $Data['title'] = "Definir quitas";
        $Data['Producto'] = $Producto;
        $Data['Fecha_vig'] = $Fecha_vig;
        set_value("Nombre");
        $this->load->view('layouts/_menu', $Data);
        $this->load->view('Productos/Quitas', $Data);
        $this->load->view('layouts/footer');

    }

    function QuitasPost(){
        if(!VerificarPermisos($this->session->UID, "Productos", "Edit")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a esta opcion. Contacte al administrador.');
            redirect("");
        }

        if($this->input->post()){
            //
            // Tomar la informacion por metodo post
            //
            $Vigencia = $this->input->post("Vigencia");
            $Producto = $this->input->post("hdProducto");
            $Detalle = $this->input->post("lstDetalle");

            $TodayDate = unix_to_human(time(), TRUE, 'mx');
            $LoggedUserId = $this->session->UID;

            // Eliminar todas las Quitas
            $result = $this->Quitas_model->DeleteByIdPdto($Producto);

            // actualizamos los registros del detalle

            foreach($Detalle as $Item)
            { 
                if($Item["Active"] == 1)
                {
                    $Fechatmp= $Vigencia;
                    $FechaExplode = explode("/", $Fechatmp);
                    $Fechahora = new DateTime($FechaExplode[2]."-".$FechaExplode[1]."-".$FechaExplode[0]);
                    $Detalle = array(
                        "Producto_hsbc" => $Producto,
                        "Limite_inf" => $Item["Desde"],
                        "Limite_sup" => $Item["Hasta"],
                        "Quita_st" => $Item["Quita_st"],
                        "Quita_sc" => $Item["Quita_sc"],
                        "Vigencia" => $Fechahora->format("Y-m-d"),
                        "CreatedBy" => $LoggedUserId,
                        "CreatedDate" => $TodayDate,
                        "UpdatedBy" => $LoggedUserId,
                        "UpdatedDate" => $TodayDate                    
                    );
                    $result = $this->Quitas_model->Create($Detalle);
                }
            }

            // $this->session->set_flashdata('Producto', $Producto);
            $this->session->set_flashdata('message_index', 'Se guardaron exitosamente las quitas del producto ');
            $this->session->set_flashdata('class', 'success');
            redirect("Productos");
        }
    }

    function AutocompleteClave(){
        $term = strtolower($this->input->get("term"));
        $result = $this->Productos_model->SearchByClave($term);
        echo json_encode($result);
    }

    function AutocompleteNombre(){
        $term = strtolower($this->input->get("term"));
        $result = $this->Productos_model->SearchByNombre($term);
        echo json_encode($result);
    }

    function GetByClave(){
        $ClaveProducto = strtolower($this->input->get("ClaveProducto"));
        $result = $this->Productos_model->GetByClave($ClaveProducto);
        if($result && !$result->Active)
        {
            $result = null;
        }
        echo json_encode($result);
    }

}
