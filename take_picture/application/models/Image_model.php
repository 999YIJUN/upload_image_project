<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Image_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_image()
    {
        $query = $this->db->get('images');
        return $query->result();
    }

    public function get_image_by_id($id)
    {
        $query = $this->db->get_where('images', ['image_id' => $id]);
        return $query->row();
    }

    public function get_image_by_record_number($record_number)
    {
        $query = $this->db->get_where('images', ['record_number' => $record_number]);
        return $query->result();
    }

    public function get_image_id_by_image_name($image_name)
    {
        $this->db->select('image_id');
        $query = $this->db->get_where('images', ['image_name' => $image_name]);
        $result = $query->row();
        if ($result) {
            return $result->image_id;
        } else {
            return null;
        }
    }

    public function get_patient_by_record_number($record_number)
    {
        $query = $this->db->get_where('patients', ['record_number' => $record_number]);
        return $query->row();
    }

    public function get_unique_record_numbers()
    {
        // $this->db->select('DISTINCT record_number');
        // $query = $this->db->get('images');
        // return $query->result();
        $this->db->distinct();
        $this->db->select('personal_id,patient_name,record_number');
        $this->db->where('record_number IS NOT NULL');
        $query = $this->db->get('images');
        return $query->result();
    }

    public function insert_image($data)
    {
        $this->db->insert('images', $data);
        return $this->db->insert_id();
    }

    public function update_image($data, $id)
    {
        $this->db->where('image_id', $id);
        $this->db->update('images', $data);
        return $this->db->affected_rows();
    }

    public function delete_image($id)
    {
        $this->db->where('image_id', $id);
        $this->db->delete('images');
        return $this->db->affected_rows();
    }

    public function get_latest_image()
    {
        // 查詢最新的圖片資訊
        $this->db->select('*');
        $this->db->from('images');
        $this->db->order_by('image_id', 'DESC');
        $this->db->limit(1); // 只取一條資料
        $query = $this->db->get();

        return $query->row_array();
    }
}
