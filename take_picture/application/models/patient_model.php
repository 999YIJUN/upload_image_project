<?php
defined('BASEPATH') or exit('No direct script access allowed');

class patient_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_patient()
    {
        $query = $this->db->get('patients');
        return $query->result();
    }

    public function get_patient_by_record_number($record_number)
    {
        $query = $this->db->get_where('patients', ['record_number' => $record_number]);
        return $query->row();
    }

    public function insert_patient($data)
    {
        $this->db->insert('patients', $data);
        return $this->db->insert_id();
    }

    public function update_patient($data, $id)
    {
        $this->db->where('patient_id', $id);
        $this->db->update('patients', $data);
        return $this->db->affected_rows();
    }

    public function delete_patient($id)
    {
        $this->db->where('patient_id', $id);
        $this->db->delete('patients');
        return $this->db->affected_rows();
    }
}
