<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Convenios_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }

    function Create($Convenio){
        $this->db->insert('master_convenios',$Convenio);
        return $this->db->insert_id();
    }

    function Update($Convenio){
        $this->db->where('Id', $Convenio['Id']);
        return $this->db->update('master_convenios', $Convenio);
    }

    function GetByCuenta($Clave){
        $this->db->select('*');
        $this->db->from('master_convenios');
        $this->db->where('Dmacct', $Clave);
        $this->db->order_by("UpdatedDate", "DESC");

        $Query = $this->db->get();
        $Result = $Query->row();
        return $Result;
    }

    function GetById($Id){
        $this->db->select('*');
        $this->db->from('master_convenios');
        $this->db->where('Id', $Id);

        $Query = $this->db->get();
        $Result = $Query->row();
        return $Result;
    }

    function CheckIfExists($Clave)
    {
        $this->db->select('*');
        $this->db->from('master_convenios');
        $this->db->where('Dmacct', $Clave);

        $Query = $this->db->get();
        $Result = $Query->row();
        return $Result;
    }

    function GetList(){
        $this->db->select('*');
        $this->db->from('master_convenios');
        // $this->db->where('Active', true);
        $this->db->order_by("Id", "ASC");
        $Query = $this->db->get();
        return $Query->result();
    }

    function GetAll($Page, $Clave, $Nombre){
        $PerPage = 10;
        $limit2 = $Page * $PerPage;
        $Start = $limit2 - $PerPage;
        $this->db->select('*');
        $this->db->from('master_convenios');
        if( $this->session->Level > 0 ){
            $this->db->where('CreatedBy', $this->session->UID);
        }
        $this->db->like('Dmacct', $Clave);
        $this->db->like('Nombre', $Nombre);
        // $this->db->where('Active', true);
        $this->db->order_by("Id", "DESC");
        $this->db->limit($PerPage, $Start);
        $Query = $this->db->get();
        return $Query->result();
    }

    function GetPages($Page, $Clave, $Nombre, $Verconv_usr, $Verconv_sup){
        $this->db->select('*');
        $this->db->from('master_convenios');
        if( $this->session->Level > 0 ){
            $this->db->where('CreatedBy', $this->session->UID);
        }
        $this->db->like('Dmacct', $Clave);
        $this->db->like('Nombre', $Nombre);
        // $this->db->where('Active', true);
        $this->db->order_by("Id", "DESC");

        if( $this->session->Level > 0 ){
            if($Verconv_usr > 0){
                $this->db->limit($Verconv_usr);
            }
        }else{
            if($Verconv_sup > 0){
                $this->db->limit($Verconv_sup);
            }
        }
        
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

    function SearchByClave($Clave){
        $this->db->select('*');
        $this->db->like('Dmacct', $Clave);
        // $this->db->where('Active', true);
        $this->db->limit(10);
        $Query = $this->db->get('master_convenios');
        if($Query->num_rows() > 0){
            foreach ($Query->result() as $row){
                $new_row['label'] = $row->Dmacct;
                $new_row['value'] = $row->Dmacct;
                $row_set[] = $new_row;
            }
            return $row_set;
        }
    }

    function SearchByNombre($Nombre){
        $this->db->select('*');
        $this->db->like('Nombre', $Nombre);
        // $this->db->where('Active', true);
        $this->db->limit(10);
        $Query = $this->db->get('master_convenios');
        if($Query->num_rows() > 0){
            foreach ($Query->result() as $row){
                $new_row['label'] = $row->Nombre;
                $new_row['value'] = $row->Nombre;
                $new_row['Dmacct'] = $row->Dmacct;
                $row_set[] = $new_row;
            }
            return $row_set;
        }
    }

    function GetByDateCustom($FechaI,$FechaF,$Producto){
        $this->db->select('*');
        $this->db->from('master_convenios');
        $this->db->where('Fecha_neg >=', $FechaI);
        $this->db->where('Fecha_neg <=', $FechaF);
        if($Producto !=0){
            $this->db->where('Producto', $Producto);
        }
        $this->db->where('Cancelado', 0);
        $this->db->order_by("Id", "ASC");
        $Query = $this->db->get();
        return $Query->result();
    }

    function CheckLastFolio($Prefix)
    {
        $this->db->select('max(Folio_cons) as Maxfolio');
        $this->db->from('master_convenios');
        $this->db->where('Folio_pre', $Prefix);

        $Query = $this->db->get();
        $Result = $Query->row();
        return $Result->Maxfolio;
    }

}
?>