<?php
defined('BASEPATH') or exit('No direct script access allowed');

class homecare_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_homecare()
    {
        $query = $this->db->get('homecare');
        return $query->result();
    }

    public function get_care_center()
    {
        $query = $this->db->get('care_center');
        return $query->result();
    }

    public function get_homecare_by_id($id)
    {
        $query = $this->db->get_where('homecare', ['id' => $id]);
        return $query->row();
    }

    public function get_patient_by_personal_id($id)
    {
        $query = $this->db->get_where('patients', ['personal_id' => $id]);
        return $query->row();
    }

    public function get_patient_by_record_number($record_number)
    {
        $query = $this->db->get_where('patients', ['record_number' => $record_number]);
        return $query->row();
    }

    public function get_home_care_by_personal_id($id)
    {
        $query = $this->db->get_where('homecare', ['personal_id' => $id]);
        return $query->result();
    }

    public function get_home_care_by_record_number($record_number)
    {
        $query = $this->db->get_where('homecare', ['record_number' => $record_number]);
        return $query->result();
    }

    public function insert_homecare($data)
    {
        $this->db->insert('homecare', $data);
        return $this->db->insert_id();
    }

    public function update_homecare($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('homecare', $data);
        return $this->db->affected_rows();
    }

    public function delete_homecare($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('homecare');
        return $this->db->affected_rows();
    }
}
