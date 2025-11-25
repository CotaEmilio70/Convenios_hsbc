<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set("America/Mexico_City");
    }

    function Index()
    {
        if(!$this->session->Logged){
            $this->session->set_flashdata('error', 'Autenticarse para entrar al sistema');
            redirect("Users/LogIn");
        }
        if(!VerificarPermisos($this->session->UID, "Users", "Index")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a este catalogo. Contacte al administrador.');
            redirect("");
        }
        $Page = 1;
        $Name = "";
        $UserName = "";
        if($this->input->post()){
            $Name = $this->input->post('Name');
            $UserName = $this->input->post('UserName');
            $Page = $this->input->post("Page");
        }
        set_value("Name", "UserName");
        $Pages = $this->Users_model->GetPages($Page, $Name, $UserName);
        if( $Pages <= 1){
            $Page = 1;
        }
        $Users = $this->Users_model->GetAll($Page, $Name, $UserName);
        $Data['title'] = "Usuarios";
        $Data['Users'] = $Users;
        $Data['Pages'] = $Pages;
        $Data['ActualPage'] = $Page;
        $this->load->view('layouts/_menu', $Data);
        $this->load->view('Users/Index', $Data);
        $this->load->view('layouts/footer');
    }

    function Create(){
        if(!$this->session->Logged){
            $this->session->set_flashdata('error', 'Autenticarse para entrar al sistema');
            redirect("Users/LogIn");
        }
        if(!VerificarPermisos($this->session->UID, "Users", "Create")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a este catalogo. Contacte al administrador.');
            redirect("");
        }

        $Permisos = $this->Permisos_model->ObtenerListaPermisosGroup();
        foreach($Permisos as $Item)
        {
            $Item->Modulos = $this->Permisos_model->ObtenerListaPorIdGrupoModulo($Item->Idgrupomodulo);
            $Item->Grupo = $this->Permisos_model->ObtenerGrupoModuloPorId($Item->Idgrupomodulo);
            foreach($Item->Modulos as $Modulo)
            {
                $Modulo->Opciones = $this->Permisos_model->ObtenerListaPermisosPorIdModulo($Modulo->Id);
                $Modulo->Modulo = $this->Permisos_model->ObtenerModuloPorId($Modulo->Id);
            }
        }
        $Data["Permisos"] = $Permisos;
        $Data["Niveles"] = $this->Niveles_model->GetList();        
        $Data['title'] = "Crear usuario";
        $this->load->view('layouts/_menu', $Data);
        $this->load->view('Users/Create', $Data);
        $this->load->view('layouts/footer');
    }

    function CreatePost(){
        if(!$this->session->Logged){
            $this->session->set_flashdata('error', 'Autenticarse para entrar al sistema');
            redirect("Users/LogIn");
        }
        if(!VerificarPermisos($this->session->UID, "Users", "Create")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a este catalogo. Contacte al administrador.');
            redirect("");
        }
        if($this->input->post()){
            $User = $this->Users_model->GetByUserName($this->input->post("UID"));
            if($User){
                $Message = "Ya existe un usuario con el mismo nombre de usuario";
                $this->session->set_flashdata('message_create', $Message);
                $this->session->set_flashdata('class', 'danger');
            }else{
                $TodayDate = unix_to_human(time(), TRUE, 'mx');
                $LoggedUserId = $this->session->UID;
                $Passwtmp = md5($this->input->post("PWD"));
                $Password = strtoupper($Passwtmp);                
                $NewUser = array(
                    "Name" => $this->input->post("Name"),
                    "UID" => $this->input->post("UID"),
                    "PWD" => $Password,
                    "Level" => $this->input->post("Clavenivel"),
                    "Active" => 1,
                    "email" => $this->input->post("email"),
                    "Createdby" => $LoggedUserId,
                    "Createddate" => $TodayDate,
                    "Updatedby" => $LoggedUserId,
                    "Updateddate" => $TodayDate
                );
                $result = $this->Users_model->Create($NewUser);
                if($result)
                {
                    $Permisos = $this->input->post("lstPermisos");
                    if (isset($Permisos) && !empty($Permisos)) {
                        foreach($Permisos as $Item)
                        {
                            $NuevoPermiso = array(
                                "IdPermiso" => $Item["IdPermiso"],
                                "Active" => true,
                                "Claveusuario" => $this->input->post("UID")
                            );
                            $result = $this->Permisosusuarios_model->Create($NuevoPermiso);
                        }
                    }
                }

                if($result){
                    $this->session->set_flashdata('message_index', 'Se guardo exitosamente el usuario');
                    $this->session->set_flashdata('class', 'success');
                    redirect("Users");
                }else{
                    $this->session->set_flashdata('message_create', 'Hubo un error al registrar');
                    $this->session->set_flashdata('class', 'danger');
                }
            }
             $Permisos = $this->Permisos_model->ObtenerListaPermisosGroup();
            foreach($Permisos as $Item)
            {
                $Item->Modulos = $this->Permisos_model->ObtenerListaPorIdGrupoModulo($Item->Idgrupomodulo);
                $Item->Grupo = $this->Permisos_model->ObtenerGrupoModuloPorId($Item->Idgrupomodulo);
                foreach($Item->Modulos as $Modulo)
                {
                    $Modulo->Opciones = $this->Permisos_model->ObtenerListaPermisosPorIdModulo($Modulo->Id);
                    $Modulo->Modulo = $this->Permisos_model->ObtenerModuloPorId($Modulo->Id);
                }
            }
            $Data["Permisos"] = $Permisos;
            $Data["Niveles"] = $this->Niveles_model->GetList();        
            $Data['title'] = "Crear usuario";
            set_value("Name", "UID", "lstPermisos");
            $this->load->view('layouts/_menu', $Data);
            $this->load->view('Users/Create', $Data);
            $this->load->view('layouts/footer');
        }
    }

    function Details($Id = 0){
        if(!$this->session->Logged){
            $this->session->set_flashdata('error', 'Autenticarse para entrar al sistema');
            redirect("Users/LogIn");
        }
        if(!VerificarPermisos($this->session->UID, "Users", "Details")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a este catalogo. Contacte al administrador.');
            redirect("");
        }
        $User = $this->Users_model->GetByUserName($Id);
        if(!$User){
            $Data['heading'] = "Page Not Found";
            $Data['message'] = "The page you requested was not found.";
            $this->load->view('errors/html/error_general', $Data);
            return;
        }
        $Data["CreatedBy"] = $this->Users_model->GetByUserName($User->CreatedBy)->Name;
        $Data["UpdatedBy"] = $this->Users_model->GetByUserName($User->UpdatedBy)->Name;
        if($User->InactivatedBy != null)
        {
            $Data["InactivatedBy"] = $this->Users_model->GetByUserName($User->InactivatedBy)->Name;
        }

        $Permisos = $this->Permisosusuarios_model->ObtenerListaPorUsuarioGroup($Id);
        foreach($Permisos as $Item)
        {
            $Item->Modulos = $this->Permisos_model->ObtenerListaPorIdGrupoModulo($Item->Idgrupomodulo);
            $Item->Grupo = $this->Permisos_model->ObtenerGrupoModuloPorId($Item->Idgrupomodulo);

            foreach($Item->Modulos as $Modulo)
            {
                $Modulo->Opciones = $this->Permisos_model->ObtenerListaPermisosPorIdModulo($Modulo->Id);
                $Modulo->Modulo = $this->Permisos_model->ObtenerModuloPorId($Modulo->Id);
            }
        }
        $DatosNivel = $this->Niveles_model->GetByClave($User->Level);
        $NombreNivel = $DatosNivel->nombre;
        $Data["Permisos"] = $Permisos;
        $Data["NombreNivel"] = $NombreNivel;
        $Data["PermisosUsuario"] = $this->Permisosusuarios_model->ObtenerListaPorUsuario($Id);
        $Data['title'] = "Detalles de usuario";
        $Data['User'] = $User;
        $this->load->view('layouts/_menu', $Data);
        $this->load->view('Users/Details', $Data);
        $this->load->view('layouts/footer');
    }

    function Edit($Id = 0){
        if(!$this->session->Logged){
            $this->session->set_flashdata('error', 'Autenticarse para entrar al sistema');
            redirect("Users/LogIn");
        }
        if(!VerificarPermisos($this->session->UID, "Users", "Edit")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a este catalogo. Contacte al administrador.');
            redirect("");
        }

        $User = $this->Users_model->GetByUserName($Id);

        if(!$User  || $User->Active == 0)
        {
            $Data['heading'] = "Page Not Found";
            $Data['message'] = "The page you requested was not found.";
            $this->load->view('errors/html/error_general', $Data);
            return;
        }
        $Permisos = $this->Permisos_model->ObtenerListaPermisosGroup();
        foreach($Permisos as $Item)
        {
            $Item->Modulos = $this->Permisos_model->ObtenerListaPorIdGrupoModulo($Item->Idgrupomodulo);
            $Item->Grupo = $this->Permisos_model->ObtenerGrupoModuloPorId($Item->Idgrupomodulo);
            foreach($Item->Modulos as $Modulo)
            {
                $Modulo->Opciones = $this->Permisos_model->ObtenerListaPermisosPorIdModulo($Modulo->Id);
                $Modulo->Modulo = $this->Permisos_model->ObtenerModuloPorId($Modulo->Id);
            }
        }
        $Data["PermisosUsuario"] = $this->Permisosusuarios_model->ObtenerListaPorUsuario($Id);
        $Data["Permisos"] = $Permisos;
        $Data["Niveles"] = $this->Niveles_model->GetList();        
        $Data["CreatedBy"] = $this->Users_model->GetByUserName($User->CreatedBy)->Name;
        $Data["UpdatedBy"] = $this->Users_model->GetByUserName($User->UpdatedBy)->Name;
        $Data['title'] = "Editar usuario";
        $Data['User'] = $User;
        set_value("Name", "UserName");
        $this->load->view('layouts/_menu', $Data);
        $this->load->view('Users/Edit', $Data);
        $this->load->view('layouts/footer');

    }

    function EditPost(){
        if(!$this->session->Logged){
            $this->session->set_flashdata('error', 'Autenticarse para entrar al sistema');
            redirect("Users/LogIn");
        }
        if(!VerificarPermisos($this->session->UID, "Users", "Edit")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a este catalogo. Contacte al administrador.');
            redirect("");
        }
        if($this->input->post()){
            $OriginalUser = $this->Users_model->GetByUserName($this->input->post("UID"));
            $TodayDate = unix_to_human(time(), TRUE, 'mx');
            $LoggedUserId = $this->session->UID;

            $User = array(
                "UID" => $this->input->post("UID"),
                "Name" => $this->input->post("Name"),
                "Level" => $this->input->post("Clavenivel"),
                "Active" => 1,
                "email" => $this->input->post("email"),
                "Updatedby" => $LoggedUserId,
                "Updateddate" => $TodayDate
            );
          
            $result = $this->Users_model->Update($User);

            if($result)
            {
                $Permisos = $this->input->post("lstPermisos");
                $PermisosUsuario = $this->Permisosusuarios_model->ObtenerListaPorUsuario($this->input->post("UID"));
                foreach($PermisosUsuario as $Item)
                {
                    $Eliminar = true;
                    if (isset($Permisos) && !empty($Permisos))
                    {
                        foreach($Permisos as $Item2)
                        {
                            if($Item->Idpermiso === $Item2["IdPermiso"])
                            {
                                $Eliminar = false;
                            }
                        }
                    }
                    if($Eliminar)
                    {
                        $EliminarPermiso = array(
                            "Id" => $Item->Id,
                            "Active" => false
                        );
                        $result = $this->Permisosusuarios_model->Update($EliminarPermiso);
                    }
                }
                foreach($Permisos as $Item)
                {
                    $Existe = false;

                    foreach($PermisosUsuario as $Item2)
                    {
                        if($Item["IdPermiso"] == $Item2->Idpermiso)
                        {
                            $Existe = true;
                        }
                    }

                    if(!$Existe)
                    {
                        $ExisteEliminado = $this->Permisosusuarios_model->ObtenerPorIdPermisoClaveusuario($Item["IdPermiso"], $this->input->post("UID"));
                        if($ExisteEliminado)
                        {
                            $ModificarPermiso = array(
                                "Id" => $ExisteEliminado->Id,
                                "Active" => true
                            );
                            $result = $this->Permisosusuarios_model->Update($ModificarPermiso);
                        }else
                        {
                            $NuevoPermiso = array(
                                "IdPermiso" => $Item["IdPermiso"],
                                "Active" => true,
                                "Claveusuario" => $this->input->post("UID")
                            );
                            $result = $this->Permisosusuarios_model->Create($NuevoPermiso);
                        }
                    }
                }
            }

            if($result){
                $this->session->set_flashdata('message_index', 'Se modifico exitosamente el usuario');
                $this->session->set_flashdata('class', 'success');
                redirect("Users");
            }else{
                $this->session->set_flashdata('message_edit', 'Hubo un error al registrar');
                $this->session->set_flashdata('class', 'danger');
            }

            $Data["PermisosUsuario"] = $this->Permisosusuarios_model->ObtenerListaPorUsuario($Id);
            $Data["Permisos"] = $Permisos;
            $Data["CreatedBy"] = $this->Users_model->GetByUserName($OriginalUser->CreatedBy)->Name;
            $Data["UpdatedBy"] = $this->Users_model->GetByUserName($OriginalUser->UpdatedBy)->Name;
            $Data['title'] = "Editar usuario";
            $Data['User'] = $OriginalUser;
            set_value("Name", "UID");
            $this->load->view('layouts/_menu', $Data);
            $this->load->view('Users/Edit', $Data);
            $this->load->view('layouts/footer');   
        }
    }

    function ChangePassword($Id = 0){
        if(!$this->session->Logged){
            $this->session->set_flashdata('error', 'Autenticarse para entrar al sistema');
            redirect("Users/LogIn");
        }
        if(!VerificarPermisos($this->session->UID, "Users", "ChangePassword")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a este catalogo. Contacte al administrador.');
            redirect("");
        }

        $User = $this->Users_model->GetByUserName($Id);

        if(!$User || $User->Active == 0)
        {
            $Data['heading'] = "Page Not Found";
            $Data['message'] = "The page you requested was not found.";
            $this->load->view('errors/html/error_general', $Data);
            return;
        }
        $Data["CreatedBy"] = $this->Users_model->GetByUserName($User->CreatedBy)->Name;
        $Data["UpdatedBy"] = $this->Users_model->GetByUserName($User->UpdatedBy)->Name;
        $Data['title'] = "Cambiar contraseña a usuario";
        $Data['User'] = $User;
        $this->load->view('layouts/_menu', $Data);
        $this->load->view('Users/ChangePassword', $Data);
        $this->load->view('layouts/footer');

    }

    function ChangePasswordPost(){
        if(!$this->session->Logged){
            $this->session->set_flashdata('error', 'Autenticarse para entrar al sistema');
            redirect("Users/LogIn");
        }
        if(!VerificarPermisos($this->session->UID, "Users", "ChangePassword")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a este catalogo. Contacte al administrador.');
            redirect("");
        }
        if($this->input->post()){
            $OriginalUser = $this->Users_model->GetByUserName($this->input->post("UID"));
            $TodayDate = unix_to_human(time(), TRUE, 'mx');
            $LoggedUserId = $this->session->UID;
            $Passwtmp = md5($this->input->post("Password"));
            $Password = strtoupper($Passwtmp);                

            $User = array(
                "UID" => $this->input->post("UID"),
                "PWD" => $Password,
                "Updatedby" => $LoggedUserId,
                "Updateddate" => $TodayDate
            );
          
            $result = $this->Users_model->Update($User);
            if($result){
                $this->session->set_flashdata('message_index', 'Se modifico exitosamente el usuario');
                $this->session->set_flashdata('class', 'success');
                redirect("Users");
            }else{
                $this->session->set_flashdata('message_edit', 'Hubo un error al registrar');
                $this->session->set_flashdata('class', 'danger');
            }
            $Data["CreatedBy"] = $this->Users_model->GetByUserName($OriginalUser->CreatedBy)->Name;
            $Data["UpdatedBy"] = $this->Users_model->GetByUserName($OriginalUser->UpdatedBy)->Name;
            $Data['title'] = "Cambiar contraseña a usuario";
            $Data['User'] = $OriginalUser;
            $this->load->view('layouts/_menu', $Data);
            $this->load->view('Users/ChangePassword', $Data);
            $this->load->view('layouts/footer');   
        }
    }

    function ChangeMyPassword(){
        if(!$this->session->Logged){
            $this->session->set_flashdata('error', 'Autenticarse para entrar al sistema');
            redirect("Users/LogIn");
        }

        $User = $this->Users_model->GetByUserName($this->session->UID);

        if(!$User || $User->Active == 0)
        {
            $Data['heading'] = "Page Not Found";
            $Data['message'] = "The page you requested was not found.";
            $this->load->view('errors/html/error_general', $Data);
            return;
        }
        $Data["CreatedBy"] = $this->Users_model->GetByUserName($User->CreatedBy)->Name;
        $Data["UpdatedBy"] = $this->Users_model->GetByUserName($User->UpdatedBy)->Name;
        $Data['title'] = "Cambiar mi contraseña";
        $Data['User'] = $User;
        $this->load->view('layouts/_menu', $Data);
        $this->load->view('Users/ChangeMyPassword', $Data);
        $this->load->view('layouts/footer');

    }

    function ChangeMyPasswordPost(){
        if(!$this->session->Logged){
            $this->session->set_flashdata('error', 'Autenticarse para entrar al sistema');
            redirect("Users/LogIn");
        }
        if($this->input->post()){
            $OriginalUser = $this->Users_model->GetByUserName($this->input->post("UID"));
            $TodayDate = unix_to_human(time(), TRUE, 'mx');
            $LoggedUserId = $this->session->UID;
            $Passwtmp = md5($this->input->post("Password"));
            $Password = strtoupper($Passwtmp);                

            $User = array(
                "UID" => $this->input->post("UID"),
                "PWD" => $Password,
                "Updatedby" => $LoggedUserId,
                "Updateddate" => $TodayDate
            );
          
            $result = $this->Users_model->Update($User);
            if($result){
                $this->session->set_flashdata('message_edit', 'Se modifico exitosamente el usuario');
                $this->session->set_flashdata('class', 'success');
                redirect("Users/ChangeMyPassword");
            }else{
                $this->session->set_flashdata('message_edit', 'Hubo un error al registrar');
                $this->session->set_flashdata('class', 'danger');
            }
            $Data["CreatedBy"] = $this->Users_model->GetByUserName($OriginalUser->CreatedBy)->Name;
            $Data["UpdatedBy"] = $this->Users_model->GetByUserName($OriginalUser->UpdatedBy)->Name;
            $Data['title'] = "Cambiar mi contraseña";
            $Data['User'] = $OriginalUser;
            $this->load->view('layouts/_menu', $Data);
            $this->load->view('Users/ChangeMyPassword', $Data);
            $this->load->view('layouts/footer');   
        }
    }

    function MyData(){
        if(!$this->session->Logged){
            $this->session->set_flashdata('error', 'Autenticarse para entrar al sistema');
            redirect("Users/LogIn");
        }

        $User = $this->Users_model->GetByUserName($this->session->UID);

        if(!$User || $User->Active == 0)
        {
            $Data['heading'] = "Page Not Found";
            $Data['message'] = "The page you requested was not found.";
            $this->load->view('errors/html/error_general', $Data);
            return;
        }
        $Data["CreatedBy"] = $this->Users_model->GetByUserName($User->CreatedBy)->Name;
        $Data["UpdatedBy"] = $this->Users_model->GetByUserName($User->UpdatedBy)->Name;
        $Data['title'] = "Mis datos";
        $Data['User'] = $User;
        set_value("Name", "Surnames", "UserName");
        $this->load->view('layouts/_menu', $Data);
        $this->load->view('Users/MyData', $Data);
        $this->load->view('layouts/footer');

    }

    function MyDataPost(){
        if(!$this->session->Logged){
            $this->session->set_flashdata('error', 'Autenticarse para entrar al sistema');
            redirect("Users/LogIn");
        }
        if($this->input->post()){
            $OriginalUser = $this->Users_model->GetByUserName($this->input->post("UID"));
            $TodayDate = unix_to_human(time(), TRUE, 'mx');
            $LoggedUserId = $this->session->UID;

            $User = array(
                "UID" => $this->input->post("UID"),
                "Name" => $this->input->post("Name"),
                "Updatedby" => $LoggedUserId,
                "Updateddate" => $TodayDate
            );
          
            $result = $this->Users_model->Update($User);
            if($result){
                $aUsuario = array(
                    "Name" => $this->input->post("Name")
                );

                $this->session->set_userdata($aUsuario);
                $this->session->set_flashdata('message_edit', 'Se modifico exitosamente el usuario');
                $this->session->set_flashdata('class', 'success');
                redirect("Users/MyData");
            }else{
                $this->session->set_flashdata('message_edit', 'Hubo un error al registrar');
                $this->session->set_flashdata('class', 'danger');
            }
            $Data["CreatedBy"] = $this->Users_model->GetByUserName($OriginalUser->Createdby)->Name;
            $Data["UpdatedBy"] = $this->Users_model->GetByUserName($OriginalUser->Updatedby)->Name;
            $Data['title'] = "Mis datos";
            $Data['User'] = $OriginalUser;
            set_value("Name", "Surnames", "UserName");
            $this->load->view('layouts/_menu', $Data);
            $this->load->view('Users/MyData', $Data);
            $this->load->view('layouts/footer');   
        }
    }

    function Delete(){
        if(!$this->session->Logged){
            $this->session->set_flashdata('error', 'Autenticarse para entrar al sistema');
            redirect("Users/LogIn");
        }
        if(!VerificarPermisos($this->session->UID, "Users", "Delete")){
            $this->session->set_flashdata('logged-message', 'No tiene permisos para entrar a este catalogo. Contacte al administrador.');
            redirect("");
        }
        if($this->input->post())
        {
            $OriginalUser = $this->Users_model->GetByUserName($this->input->post("UID"));
            $TodayDate = unix_to_human(time(), TRUE, 'mx');
            $LoggedUserId = $this->session->UID;

            $User = array(
                "UID" => $this->input->post("UID"),
                "Active" => 0,
                "Inactivatedby" => $LoggedUserId,
                "Inactivateddate" => $TodayDate
            );
          
            $result = $this->Users_model->Update($User);
            if($result){
                $this->session->set_flashdata('message_index', 'Se inactivo exitosamente el usuario');
                $this->session->set_flashdata('class', 'success');
                redirect("Users");
            }else{
                $this->session->set_flashdata('message_details', 'Hubo un error al registrar');
                $this->session->set_flashdata('class', 'danger');
            }
            $Data["CreatedBy"] = $this->Users_model->GetByUserName($OriginalUser->Createdby)->Name;
            $Data["UpdatedBy"] = $this->Users_model->GetByUserName($OriginalUser->Updatedby)->Name;
            $Data['title'] = "Detalles de usuario";
            $Data['User'] = $OriginalUser;
            $this->load->view('layouts/_menu', $Data);
            $this->load->view('Users/Details', $Data);
            $this->load->view('layouts/footer');   
        }
    }

    function LogIn(){
        if($this->session->Logged){
            redirect("");
        }
        $Data["Parametros"] = $this->Parametros_model->GetUnique();
        if(!$this->input->post())
        {
            $Data['title'] = "Iniciar sesión";
            $this->load->view('layouts/_menu', $Data);
            $this->load->view('Users/Login', $Data);
            $this->load->view('layouts/footer');
        }else
        {
            $UserName = $this->input->post("UserName");
            $Passwtmp = md5($this->input->post("Password"));
            $Password = strtoupper($Passwtmp);
            $User = $this->Users_model->GetByUserNameLogin($UserName);
            set_value("UserName","Name","Level");
            if($User){
                if($User->PWD == $Password)
                {
                    $aUsuario = array(
                        "Logged" => true,
                        "Name" => $User->Name,
                        "UID" => $User->UID,
                        "Level" => $User->Level
                    );
                    $this->session->set_userdata($aUsuario);
                    // die($this->session->Name);
                    redirect("Welcome");
                }
                else
                {

                    $this->session->set_flashdata('error', 'La contraseña no coincide.');
                    $Data['title'] = "Iniciar sesión";
                    $this->load->view('layouts/_menu', $Data);
                    $this->load->view('Users/Login', $Data);
                    $this->load->view('layouts/footer');
                }
            }
            else
            {
                $this->session->set_flashdata('error', 'El usuario no existe.');
                $Data['title'] = "Iniciar sesión";
                $this->load->view('layouts/_menu', $Data);
                $this->load->view('Users/Login', $Data);
                $this->load->view('layouts/footer');
            }
        }
    }

    function LogOut(){
        $this->session->sess_destroy();
        redirect("Users/LogIn");
    }

    function AutocompleteName(){
        $term = strtolower($this->input->get("term"));
        $result = $this->Users_model->SearchByName($term);
        echo json_encode($result);
    }

    function AutocompleteUserName(){
        $term = strtolower($this->input->get("term"));
        $result = $this->Users_model->SearchByUserName($term);
        echo json_encode($result);
    }

    function GetByUserName(){
        $UserName = strtolower($this->input->get("UserName"));
        $result = $this->Users_model->GetByUserNameLogIn($UserName);
        echo json_encode($result);
    }

    function GetLogin()
    {
        $Data["Title"] = "titulo";
        $this->load->view('Users/Login', $Data);
    }

    function VerificarAutorizacion(){
        $NombreUsuario = $this->input->get("Usuario");
        $Passwtmp = md5($this->input->get("Contrasena"));
        $Password = strtoupper($Passwtmp);        
        $Controlador = $this->input->get("Controlador");
        $Accion = $this->input->get("Accion");
        $Usuario = $this->Users_model->GetByUserNameLogIn($NombreUsuario);
        $Mensaje = "";
        if($Usuario)
        {
            if($Usuario->PWD != $Password)
            {
                $Mensaje = "La contraseña no coincide.";
            }else if($Usuario->PWD == $Password)
            {
                $TienePermiso = VerificarPermisos($Usuario->UID, $Controlador, $Accion);
                $Mensaje = $TienePermiso ? "" : "No tiene los permisos para realizar esta acción.";
            }
        }else
        {
            $Mensaje = "El usuario no existe.";
        }
        echo json_encode($Mensaje);
    }

    function AutorizacionSuperv(){
        $NombreUsuario = $this->input->get("Usuario");
        $Passwtmp = md5($this->input->get("Contrasena"));
        $Password = strtoupper($Passwtmp);        
        $Usuario = $this->Users_model->GetByUserNameLogIn($NombreUsuario);
        $Mensaje = "";
        if($Usuario)
        {
            if($Usuario->Level != 0)
            {
                $Mensaje = "No tiene los permisos para realizar esta acción.";
            }else if($Usuario->PWD != $Password)
            {
                $Mensaje = "La contraseña no coincide.";
            }
        }else
        {
            $Mensaje = "El usuario no existe.";
        }
        echo json_encode($Mensaje);
    }
}
