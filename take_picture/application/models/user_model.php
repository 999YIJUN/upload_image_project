<?php
defined('BASEPATH') or exit('No direct script access allowed');

class user_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_user()
    {
        $query = $this->db->get('users');
        return $query->result();
    }

    public function get_user_by_id($id)
    {
        $query = $this->db->get_where('users', ['user_id' => $id]);
        return $query->row();
    }

    public function get_user_by_account($account)
    {
        $query = $this->db->get_where('users', ['account' => $account]);
        return $query->row();
    }

    public function insert_user($data)
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    public function update_user($data, $id)
    {
        $this->db->where('user_id', $id);
        $this->db->update('users', $data);
        return $this->db->affected_rows();
    }

    public function delete_user($id)
    {
        $this->db->where('user_id', $id);
        $this->db->delete('users');
        return $this->db->affected_rows();
    }
}
