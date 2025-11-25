<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permisosusuarios_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }

    function Create($PermisoUsuario){
        return $this->db->insert('permisosusuarios',$PermisoUsuario);
    }

    function Update($PermisoUsuario){
        $this->db->where('Id', $PermisoUsuario['Id']);
        return $this->db->update('permisosusuarios', $PermisoUsuario);
    }

    function ObtenerListaPorUsuario($IdUsuario)
    {
        $this->db->select('*');
        $this->db->from('permisosusuarios');
        $this->db->where("Claveusuario", $IdUsuario);
        $this->db->where("Active", true);
        $Query = $this->db->get();
        return $Query->result();
    }

    /*function ObtenerListaPorUsuarioGroup($IdUsuario)
    {
        $this->db->select('*');
        $this->db->from('permisosusuarios');
        $this->db->join("permisos", "permisos.Id = permisosusuarios.Idpermiso");
        $this->db->join("modulospermiso", "modulospermiso.Id = permisos.Idmodulopermiso");
        $this->db->where("permisosusuarios.Claveusuario", $IdUsuario);
        $this->db->where("permisosusuarios.Active", true);
        $this->db->group_by("permisos.Idmodulopermiso");
        $this->db->order_by("modulospermiso.Nombre", "ASC");

        $Query = $this->db->get();
        return $Query->result();
    }*/

    function ObtenerListaPorUsuarioGroup($IdUsuario)
    {
        $this->db->select('*');
        $this->db->from('permisosusuarios');
        $this->db->join("permisosweb", "permisosweb.Id = permisosusuarios.Idpermiso");
        $this->db->join("modulospermiso", "modulospermiso.Id = permisosweb.Idmodulopermiso");
        $this->db->join("grupomodulos", "grupomodulos.Id = modulospermiso.Idgrupomodulo");
        $this->db->where("permisosusuarios.Claveusuario", $IdUsuario);
        $this->db->where("permisosusuarios.Active", true);
        $this->db->group_by("grupomodulos.Id");
        $this->db->order_by("grupomodulos.Nombre", "ASC");

        $Query = $this->db->get();
        return $Query->result();
    }

    function ObtenerPorIdPermisoClaveusuario($IdPermiso, $Claveusuario)
    {
        $this->db->select('*');
        $this->db->from('permisosusuarios');
        $this->db->where("Claveusuario", $Claveusuario);
        $this->db->where("Idpermiso", $IdPermiso);
        $Query = $this->db->get();
        return $Query->row();
    }
}
?>