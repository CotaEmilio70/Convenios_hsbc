<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pivotnegopdtocarta_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }

    function Create($Tipo){
        return $this->db->insert('Pivot_negopdtocarta',$Tipo);
    }

    function Update($Tipo){
        $this->db->where('id', $Tipo['id']);
        return $this->db->update('Pivot_negopdtocarta', $Tipo);
    }

    function GetByClave($id){
        $this->db->select('*');
        $this->db->from('Pivot_negopdtocarta');
        $this->db->where('id', $id);

        $Query = $this->db->get();
        $Result = $Query->row();
        return $Result;
    }

    function GetList(){
        $this->db->select('*');
        $this->db->from('Pivot_negopdtocarta');
        $Query = $this->db->get();
        return $Query->result();
    }

    function GetAll($Page, $id, $Nombre){
        $PerPage = 10;
        $limit2 = $Page * $PerPage;
        $Start = $limit2 - $PerPage;
        $this->db->select('*');
        $this->db->from('Pivot_negopdtocarta');
        $this->db->like('id', $id);
        $this->db->order_by("id", "ASC");
        $this->db->limit($PerPage, $Start);
        $Query = $this->db->get();
        return $Query->result();
    }

    function GetPages($Page, $id, $Nombre){
        $this->db->select('*');
        $this->db->from('Pivot_negopdtocarta');
        $this->db->like('id', $id);
        $this->db->order_by("id", "desc");
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

    function SearchByid($id){
        $this->db->select('*');
        $this->db->like('id', $id);
        $this->db->limit(10);
        $Query = $this->db->get('Pivot_negopdtocarta');
        if($Query->num_rows() > 0){
            foreach ($Query->result() as $row){
                $new_row['label'] = $row->id;
                $new_row['value'] = $row->id;
                $row_set[] = $new_row;
            }
            return $row_set;
        }
    }

    function GetByNegPdto($idnego,$idpdto){
        $this->db->select('Id_carta');
        $this->db->from('Pivot_negopdtocarta');
        $this->db->where('id_nego', $idnego);
        $this->db->where('id_pdto', $idpdto);

        $Query = $this->db->get();
        $Result = $Query->row('Id_carta');
        return $Result;
    }
    
}
?>