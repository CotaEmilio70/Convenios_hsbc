<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class causasnopago_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }

    function Create($Record){
        return $this->db->insert('causas_nopago',$Record);
    }

    function Update($Record){
        $this->db->where('Id', $Record['Id']);
        return $this->db->update('causas_nopago', $Record);
    }

    function GetById($Id){
        $this->db->select('*');
        $this->db->from('causas_nopago');
        $this->db->where('Id', $Id);

        $Query = $this->db->get();
        $Result = $Query->row();
        return $Result;
    }

    function GetByClave($Numero){
        $this->db->select('*');
        $this->db->from('causas_nopago');
        $this->db->where('Clave', $Numero);
        $this->db->limit(1);

        $Query = $this->db->get();
        $Result = $Query->row();
        return $Result;
    }

    function GetList(){
        $this->db->select('*');
        $this->db->from('causas_nopago');
        $this->db->where('Active', 1);
        $this->db->order_by("Nombre", "ASC");

        $Query = $this->db->get();
        return $Query->result();
    }

    function GetAll($Page, $Name){
        $PerPage = 10;
        $limit2 = $Page * $PerPage;
        $Start = $limit2 - $PerPage;
        $this->db->select('*');
        $this->db->from('causas_nopago');
        $this->db->like('Nombre', $Name);
        $this->db->where('Active', 1);
        $this->db->order_by("Nombre", "ASC");
        $this->db->limit($PerPage, $Start);
        $Query = $this->db->get();
        return $Query->result();
    }

    function GetPages($Page, $Name){
        $this->db->select('*');
        $this->db->from('causas_nopago');
        $this->db->like('Nombre', $Name);
        $this->db->where('Active', 1);
        $this->db->order_by("Nombre", "ASC");
        $Query = $this->db->get();
        $RegisterNumber = $Query->num_rows();
        $Pages = $RegisterNumber/10;
        $arrPages = explode('.',$Pages);
        $Pages = $arrPages[0];
        if(count($arrPages) > 1){
            $Pages = $Pages + 1;
        }
        return $Pages;
    }

    function SearchByName($Name){
        $this->db->select('*');
        $this->db->like('Nombre', $Name);
        $this->db->where('Active', 1);
        $this->db->limit(10);
        $Query = $this->db->get('causas_nopago');
        if($Query->num_rows() > 0){
            foreach ($Query->result() as $row){
                $new_row['label'] = $row->Nombre;
                $new_row['value'] = $row->Nombre;
                $row_set[] = $new_row;
            }
            return $row_set;
        }
    }
}
?>