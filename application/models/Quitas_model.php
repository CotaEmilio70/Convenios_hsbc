<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quitas_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }

    function Create($Quitas){
        return $this->db->insert('tabla_quitas',$Quitas);
    }

    function Update($Quitas){
        $this->db->where('Id', $Quitas['Id']);
        return $this->db->update('tabla_quitas', $Quitas);
    }

    function GetByProducto($Producto){
        $this->db->select('*');
        $this->db->from('tabla_quitas');
        $this->db->where('Producto_hsbc', $Producto);

        $Query = $this->db->get();
        return $Query->result();
    }

    function GetDiscount($Idproducto, $Mescastigo){
        $TodayDate = unix_to_human(time(), TRUE, 'mx');
        $this->db->select('*');
        $this->db->from('tabla_quitas');
        $this->db->where('Producto_hsbc', $Idproducto);
        $this->db->where('Limite_inf <=', $Mescastigo);
        $this->db->where('Limite_sup >=', $Mescastigo);
        $this->db->where('Vigencia >=', $TodayDate);
        $this->db->limit(1);

        $Query = $this->db->get();
        $Result = $Query->row();
        return $Result;
    }

    function DeleteByIdPdto($Idpdto)
    {
        $this->db->where('Producto_hsbc', $Idpdto);
        $this->db->delete('tabla_quitas');
    }

}
?>