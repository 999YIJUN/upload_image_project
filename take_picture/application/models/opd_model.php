<?php
defined('BASEPATH') or exit('No direct script access allowed');

class opd_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_opd()
    {
        $query = $this->db->get('opd');
        return $query->result();
    }

    public function get_opd_by_id($id)
    {
        $query = $this->db->get_where('opd', ['opd_id' => $id]);
        return $query->row();
    }

    public function get_unique_department()
    {
        $this->db->distinct();
        $this->db->select('department');
        $query = $this->db->get('opd');
        return $query->result();
    }

    public function insert_opd($data)
    {
        $this->db->insert('opd', $data);
        return $this->db->insert_id();
    }

    public function update_opd($data, $id)
    {
        $this->db->where('opd_id', $id);
        $this->db->update('opd', $data);
        return $this->db->affected_rows();
    }

    public function delete_opd($id)
    {
        $this->db->where('opd_id', $id);
        $this->db->delete('opd');
        return $this->db->affected_rows();
    }
}
