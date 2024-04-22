<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Opd extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('opd_model');
    }

    public function index()
    {
        $this->load->view('camera');
    }

    public function opd_view()
    {
        $data['user'] = $this->session->userdata('user');
        $data['department'] = $this->opd_model->get_unique_department();
        $data['today'] = date('Y-m-d');
        if ($data['user']) {
            $this->load->view('opd/opd_view', $data);
        } else {
            redirect('user/index');
        }
    }

    public function patient_data()
    {
        $record_number = $this->input->post('recordNumber');
        $source = $this->input->post('source');

        $this->load->model('patient_model');
        $patient_data = $this->patient_model->get_patient_by_record_number($record_number);

        $this->session->set_userdata('patient_data', $patient_data);
        $this->session->set_userdata('source', $source);
        $response['success'] = true;
        echo json_encode($response);
    }

    // DataTables
    public function get_data_opd()
    {
        $this->load->library('ssp');
        $dbDetails = array(
            'host' => $this->db->hostname,
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db'   => $this->db->database
        );
        $table = 'opd';
        $primaryKey = 'opd_id';
        // DataTables 設定
        $columns = array(
            array(
                'db' => 'doctor_name', 'dt' => 0
            ),
            array(
                'db' => 'record_number', 'dt' => 1
            ),
            array(
                'db' => 'patient_name', 'dt' => 2
            ),
            array(
                'db' => 'date', 'dt' => 3
            ),
            array(
                'db' => 'category', 'dt' => 4
            ),
            array(
                'db' => 'department', 'dt' => 5
            ),
            array(
                'db' => 'opd_id',
                'dt' => 6,
                'formatter' => function ($data, $row) {
                    return '<button class="btn btn-sm btn-warning btnTakePicture" data-record_number="' . $row['record_number'] . '">圖片上傳</button>';
                }
            )
        );

        $output = $this->ssp->simple($this->input->get(), $dbDetails, $table, $primaryKey, $columns);

        echo json_encode($output);
    }
}
