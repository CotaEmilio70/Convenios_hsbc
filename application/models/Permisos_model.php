<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permisos_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }

    /*function ObtenerListaPermisosGroup()
    {
        $this->db->select('*');
        $this->db->from('permisosweb');
        $this->db->join("modulospermiso", "modulospermiso.Id = permisosweb.Idmodulopermiso");
        $this->db->order_by("modulospermiso.Nombre", "ASC");
        $this->db->group_by("permisosweb.Idmodulopermiso");
        $Query = $this->db->get();
        return $Query->result();
    }*/

    function ObtenerListaPermisosGroup()
    {
        $this->db->select('*');
        $this->db->from('permisosweb');
        $this->db->join("modulospermiso", "modulospermiso.Id = permisosweb.Idmodulopermiso");
        $this->db->join("grupomodulos", "grupomodulos.Id = modulospermiso.Idgrupomodulo");
        $this->db->order_by("grupomodulos.Nombre", "ASC");
        $this->db->group_by("modulospermiso.Idgrupomodulo");
        $Query = $this->db->get();
        return $Query->result();
    }

    function ObtenerModuloPorId($IdModulo)
    {
        $this->db->select('*');
        $this->db->from('modulospermiso');
        $this->db->where("Id", $IdModulo);
        $Query = $this->db->get();
        return $Query->row();
    }

    function ObtenerListaPermisosPorIdModulo($IdModulo)
    {
        $this->db->select('*');
        $this->db->from('permisosweb');
        $this->db->where("Idmodulopermiso", $IdModulo);
        $this->db->order_by("Id", "ASC");
        $Query = $this->db->get();
        return $Query->result();
    }

    function ObtenerPorId($Id)
    {
        $this->db->select('*');
        $this->db->from('permisosweb');
        $this->db->where("Id", $Id);
        $Query = $this->db->get();
        return $Query->row();
    }

    function ObtenerListaPorIdGrupoModulo($IdGrupoModulo)
    {
        $this->db->select('*');
        $this->db->from('modulospermiso');
        $this->db->where("Idgrupomodulo", $IdGrupoModulo);
        $Query = $this->db->get();
        return $Query->result();
    }

    function ObtenerGrupoModuloPorId($IdGrupoModulo)
    {
        $this->db->select('*');
        $this->db->from('grupomodulos');
        $this->db->where("Id", $IdGrupoModulo);
        $Query = $this->db->get();
        return $Query->row();
    }
}
?>