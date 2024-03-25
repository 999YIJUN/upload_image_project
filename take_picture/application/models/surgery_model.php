<?php
defined('BASEPATH') or exit('No direct script access allowed');

class surgery_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_surgery()
    {
        $query = $this->db->get('surgery');
        return $query->result();
    }

    public function get_surgery_by_id($id)
    {
        $query = $this->db->get_where('surgery', ['patient_id' => $id]);
        return $query->row();
    }

    public function insert_surgery($data)
    {
        $this->db->insert('surgery', $data);
        return $this->db->insert_id();
    }

    public function update_surgery($data, $id)
    {
        $this->db->where('patient_id', $id);
        $this->db->update('surgery', $data);
        return $this->db->affected_rows();
    }

    public function delete_surgery($id)
    {
        $this->db->where('patient_id', $id);
        $this->db->delete('surgery');
        return $this->db->affected_rows();
    }
}
