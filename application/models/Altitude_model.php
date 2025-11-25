<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Altitude_model extends CI_Model {
    
    private $dbAltitude;

    function __construct(){
        parent::__construct();
        $this->dbAltitude = $this->load->database('altitude_db', true);
    }


    function GetProfile($Cuenta){
        
        $this->dbAltitude->select('*');
        $this->dbAltitude->from('ph_contact_profile');
        $this->dbAltitude->where('unique_id', $Cuenta);
        // $this->dbAltitude->limit(1);
        $this->dbAltitude->order_by("last_update", "desc");

        $Query = $this->dbAltitude->get();
        // $Result = $Query->row();
        $Result = $Query->result();
        return $Result;

    }

    function GetDir42($Code){
        
        $this->dbAltitude->select('*');
        $this->dbAltitude->from('dir_HSBC_full');
        $this->dbAltitude->where('easycode', $Code);
        // $this->dbAltitude->where('activo', 1);
        $this->dbAltitude->limit(1);

        $Query = $this->dbAltitude->get();
        $Result = $Query->row();
        return $Result;
    }

    function GetDir43($Code){
        
        $this->dbAltitude->select('*');
        $this->dbAltitude->from('dir_HSBC_tdc');
        $this->dbAltitude->where('easycode', $Code);
        // $this->dbAltitude->where('activo', 1);
        $this->dbAltitude->limit(1);

        $Query = $this->dbAltitude->get();
        $Result = $Query->row();
        return $Result;
    }

}
?>