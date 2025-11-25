<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Niveles_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }

    function Create($Nivel){
        return $this->db->insert('niveles',$Nivel);
    }

    function Update($Nivel){
        $this->db->where('id', $Nivel['id']);
        return $this->db->update('niveles', $Nivel);
    }

    function GetByClave($id){
        $this->db->select('*');
        $this->db->from('niveles');
        $this->db->where('id', $id);

        $Query = $this->db->get();
        $Result = $Query->row();
        return $Result;
    }

    function CheckIfExists($id)
    {
        $this->db->select('*');
        $this->db->from('niveles');
        $this->db->where('id', $id);

        $Query = $this->db->get();
        $Result = $Query->row();
        return $Result;
    }

    function GetList(){
        $this->db->select('*');
        $this->db->from('niveles');
        $Query = $this->db->get();
        return $Query->result();
    }

    function GetAll($Page, $id, $Nombre){
        $PerPage = 10;
        $limit2 = $Page * $PerPage;
        $Start = $limit2 - $PerPage;
        $this->db->select('*');
        $this->db->from('niveles');
        $this->db->like('id', $id);
        $this->db->like('Nombre', $Nombre);
        $this->db->order_by("id", "ASC");
        $this->db->limit($PerPage, $Start);
        $Query = $this->db->get();
        return $Query->result();
    }

    function GetPages($Page, $id, $Nombre){
        $this->db->select('*');
        $this->db->from('niveles');
        $this->db->like('id', $id);
        $this->db->like('Nombre', $Nombre);
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
        $Query = $this->db->get('niveles');
        if($Query->num_rows() > 0){
            foreach ($Query->result() as $row){
                $new_row['label'] = $row->id;
                $new_row['value'] = $row->id;
                $row_set[] = $new_row;
            }
            return $row_set;
        }
    }

    function SearchByNombre($Nombre){
        $this->db->select('*');
        $this->db->like('Nombre', $Nombre);
        $this->db->limit(10);
        $Query = $this->db->get('niveles');
        if($Query->num_rows() > 0){
            foreach ($Query->result() as $row){
                $new_row['label'] = $row->Nombre;
                $new_row['value'] = $row->Nombre;
                $new_row['id'] = $row->id;
                $row_set[] = $new_row;
            }
            return $row_set;
        }
    }

    function GetNombreByid($id){
        $this->db->select('Nombre');
        $this->db->from('niveles');
        $this->db->where('id', $id);

        $Query = $this->db->get();
        $Result = $Query->row('Nombre');
        return $Result;
    }
    
}
?>