<?php
defined('BASEPATH') or exit('No direct script access allowed');

class inpatient_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_inpatient()
    {
        $query = $this->db->get('inpatient');
        return $query->result();
    }

    public function get_inpatient_by_id($id)
    {
        $query = $this->db->get_where('inpatient', ['patient_id' => $id]);
        return $query->row();
    }

    public function insert_inpatient($data)
    {
        $this->db->insert('inpatient', $data);
        return $this->db->insert_id();
    }

    public function update_inpatient($data, $id)
    {
        $this->db->where('patient_id', $id);
        $this->db->update('inpatient', $data);
        return $this->db->affected_rows();
    }

    public function delete_inpatient($id)
    {
        $this->db->where('patient_id', $id);
        $this->db->delete('inpatient');
        return $this->db->affected_rows();
    }
}
