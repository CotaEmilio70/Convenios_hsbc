<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }

    function Create($User){
        return $this->db->insert('usuarios',$User);
    }

    function Update($User){
        $this->db->where('UID', $User['UID']);
        return $this->db->update('usuarios', $User);
    }

    function GetByUserNameLogin($Username){
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->where('UID', $Username);
        $this->db->where('Active', 1);

        $Query = $this->db->get();
        $Result = $Query->row();
        return $Result;
    }

    function GetByUserName($Username){
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->where('UID', $Username);

        $Query = $this->db->get();
        $Result = $Query->row();
        return $Result;
    }

    function GetList(){
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->where('Active', 1);
        $this->db->order_by("Name", "ASC");

        $Query = $this->db->get();
        return $Query->result();
    }

    function GetAll($Page, $Name, $UserName){
        $PerPage = 10;
        $limit2 = $Page * $PerPage;
        $Start = $limit2 - $PerPage;
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->like('Name', $Name);
        $this->db->like('UID', $UserName);
        //$this->db->where('Active', 1);
        $this->db->order_by("UID", "ASC");
        $this->db->limit($PerPage, $Start);
        $Query = $this->db->get();
        return $Query->result();
    }

    function GetPages($Page, $Name, $UserName){
        $this->db->select('*');
        $this->db->from('usuarios');
        $this->db->like('Name', $Name);
        $this->db->like('UID', $UserName);
        //$this->db->where('Active', 1);
        $this->db->order_by("UID", "desc");
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
        $this->db->like('Name', $Name);
        $this->db->limit(10);
        $Query = $this->db->get('usuarios');
        if($Query->num_rows() > 0){
            foreach ($Query->result() as $row){
                $new_row['label'] = $row->Name;
                $new_row['value'] = $row->Name;
                $row_set[] = $new_row;
            }
            return $row_set;
        }
    }

    function SearchByUserName($UserName){
        $this->db->select('*');
        $this->db->like('UID', $UserName);
        $this->db->limit(10);
        $query = $this->db->get('usuarios');
        if($query->num_rows() > 0){
            foreach ($query->result() as $row){
                $new_row['label'] = $row->UID;
                $new_row['value'] = $row->UID;
                $row_set[] = $new_row;
            }
            return $row_set;
        }
    }

    function GetName($Username)
    {
        $this->db->select('name');
        $this->db->from('usuarios');
        $this->db->where('UID', $Username);
        $Query = $this->db->get();
        $Result = $Query->row();
        $Name = $Result ? $Result->name : "";
        return $Name;
    }

}
?>