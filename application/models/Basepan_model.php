<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Basepan_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }

    function Create($Basepan){
        return $this->db->insert('base_pan',$Basepan);
    }

    function Update($Basepan){
        $this->db->where('Id', $Basepan['Id']);
        return $this->db->update('base_pan', $Basepan);
    }

    function GetByCuenta12d($Cuenta){
        $this->db->select('*');
        $this->db->from('base_pan');
        $this->db->where('Cuenta_12d', $Cuenta);

        $Query = $this->db->get();
        $Result = $Query->row();
        return $Result;
    }

}
?>