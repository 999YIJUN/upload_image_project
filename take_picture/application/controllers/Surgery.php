<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Surgery extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('surgery_model');
    }

    public function index()
    {
        $this->load->view('camera');
    }

    public function surgery_view()
    {
        $data['user'] = $this->session->userdata('user');
        $data['today'] = date('Y-m-d');
        if ($data['user']) {
            $this->load->view('surgery/surgery_view', $data);
        } else {
            redirect('user/index');
        }
    }

    // DataTables
    public function get_data_surgery()
    {
        $this->load->library('ssp');
        $dbDetails = array(
            'host' => $this->db->hostname,
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db'   => $this->db->database
        );
        $table = 'surgery';
        $primaryKey = 'surgery_id';
        // DataTables 設定
        $columns = array(
            array(
                'db' => 'surgery_room', 'dt' => 0
            ),
            array(
                'db' => 'record_number', 'dt' => 1
            ),
            array(
                'db' => 'patient_name', 'dt' => 2
            ),
            array(
                'db' => 'doctor_name', 'dt' => 3
            ),
            array(
                'db' => 'surgery_date', 'dt' => 4
            ),
            array(
                'db' => 'surgery_id',
                'dt' => 5,
                'formatter' => function ($data, $row) {
                    return '<button class="btn btn-sm btn-warning btnTakePicture" data-record_number="' . $row['record_number'] . '">圖片上傳</button>';
                }
            )
        );

        $output = $this->ssp->simple($this->input->get(), $dbDetails, $table, $primaryKey, $columns);

        echo json_encode($output);
    }
}
