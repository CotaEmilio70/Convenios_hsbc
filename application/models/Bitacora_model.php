<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bitacora_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }

    function Create($Movimiento){
        return $this->db->insert('bitacora',$Movimiento);
    }

    function Update($Movimiento){
        $this->db->where('Id', $Movimiento['Id']);
        return $this->db->update('bitacora', $Movimiento);
    }

}
?>