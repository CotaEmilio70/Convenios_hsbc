<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
    function __construct(){
        parent::__construct();
        
        if(!$this->session->Logged){
            $this->session->set_flashdata('error', 'Autenticarse para entrar al sistema');
            redirect("Users/LogIn");
        }
    }

	public function index()
	{
        $Data['title'] = "Bienvenido";
        $this->load->view('layouts/_menu', $Data);
        $this->load->view('index', $Data);
        $this->load->view('layouts/footer', $Data);
	}
}
