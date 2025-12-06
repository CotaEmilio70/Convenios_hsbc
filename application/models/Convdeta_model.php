<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Convdeta_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }

    function Create($Convdeta){
        return $this->db->insert('details_convenios',$Convdeta);
    }

    function Update($Convdeta){
        $this->db->where('Id', $Convdeta['Id']);
        return $this->db->update('details_convenios', $Convdeta);
    }

    function GetLastDateById($Idconv)
    {
        $this->db->select('*');
        $this->db->from('details_convenios');
        $this->db->where('Convenio_id', $Idconv);
        $this->db->where('Cancelado', 0);
        $this->db->order_by("Fecha_pago", "DESC");
        $this->db->limit(1);
        
        $Query = $this->db->get();
        $Result = $Query->row();
        return $Result;
    }

    function GetDetailsById($Idconv)
    {
        $this->db->select('*');
        $this->db->from('details_convenios');
        $this->db->where('Convenio_id', $Idconv);
        $this->db->order_by("Fecha_pago", "ASC");

        $Query = $this->db->get();
        $Result = $Query->result();
        return $Result;
    }

    function GetTotalPagoById($Idconv)
    {
        $this->db->select_sum('Importe_pago');
        $this->db->from('details_convenios');
        $this->db->where('Convenio_id', $Idconv);
        $this->db->where('Cancelado', 0);
        $Query = $this->db->get();
        $Result = $Query->result();
        return $Result[0]->Importe_pago;
    }

    function DeleteByIdConv($Idconv)
    {
        $this->db->where('Convenio_id', $Idconv);
        $this->db->delete('details_convenios');
    }

    function CancelById($CancelDetail)
    {
        $this->db->where('Id', $CancelDetail['Id']);
        return $this->db->update('details_convenios', $CancelDetail);
    }

}
?>