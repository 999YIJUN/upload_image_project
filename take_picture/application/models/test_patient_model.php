<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Test_patient_model extends CI_Model
{
    private $test_db;

    public function __construct()
    {
        parent::__construct();
        $this->test_db = $this->load->database('test', TRUE);
    }

    public function get_patient()
    {
        $query = $this->test_db->query('SELECT * FROM patients');
        return $query->result();
    }

    public function get_patient_by_record_number($record_number)
    {
        $query = $this->test_db->query("SELECT * FROM patients WHERE record_number = '$record_number'");
        return $query->row();
    }

    public function get_patient_by_personal_id($id)
    {
        $query = $this->test_db->query("SELECT * FROM patients WHERE personal_id = '$id'");
        return $query->row();
    }

    public function insert_patient($data)
    {
        $this->test_db->insert('patients', $data);
        return $this->test_db->insert_id();
    }

    public function update_patient($data, $id)
    {
        $this->test_db->where('p_id', $id);
        $this->test_db->update('patients', $data);
        return $this->test_db->affected_rows();
    }

    public function delete_patient($id)
    {
        $this->test_db->where('p_id', $id);
        $this->test_db->delete('patients');
        return $this->test_db->affected_rows();
    }
}
