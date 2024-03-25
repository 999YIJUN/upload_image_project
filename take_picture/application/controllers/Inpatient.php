<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inpatient extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('inpatient_model');
    }

    public function index()
    {
        $this->load->view('camera');
    }

    public function inpatient_view()
    {
        $data['user'] = $this->session->userdata('user');
        $this->load->view('inpatient/inpatient_view', $data);
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
    public function get_data_inpatient()
    {
        $this->load->library('ssp');
        $dbDetails = array(
            'host' => $this->db->hostname,
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db'   => $this->db->database
        );
        $table = 'inpatient';
        $primaryKey = 'inpatient_id';
        // DataTables 設定
        $columns = array(
            array(
                'db' => 'bed_number', 'dt' => 0
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
                'db' => 'inpatient_id',
                'dt' => 4,
                'formatter' => function ($data, $row) {
                    return '<button class="btn btn-sm btn-warning btnTakePicture" data-record_number="' . $row['record_number'] . '">圖片上傳</button>';
                }
            )
        );

        $output = $this->ssp->simple($this->input->get(), $dbDetails, $table, $primaryKey, $columns);

        echo json_encode($output);
    }
}
