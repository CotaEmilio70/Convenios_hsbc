<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Parametros_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }

    function Update($Parametros){
        $this->db->where('Clave', $Parametros['Clave']);
        return $this->db->update('parametros', $Parametros);
    }

    function GetUnique(){
        $this->db->select('*');
        $this->db->from('parametros');

        $Query = $this->db->get();
        $Result = $Query->row();
        return $Result;
    }
}
?>