<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Homecare extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('homecare_model');
    }

    public function index()
    {
        $this->load->view('camera');
    }

    public function homecare_view()
    {
        $data['home_care'] = $this->homecare_model->get_care_center();
        $data['user'] = $this->session->userdata('user');
        if ($data['user']) {
            $this->load->view('homecare/homecare_view', $data);
        } else {
            redirect('user/index');
        }
    }

    // 新增
    public function insert()
    {
        // $this->form_validation->set_rules('personal_id', '身分證字照', 'required');
        // $this->form_validation->set_rules('record_number', '病歷號', 'required');
        // $this->form_validation->set_rules('patient_name', '姓名', 'required');
        // $this->form_validation->set_rules('birthday', '生日', 'required');
        // $this->form_validation->set_rules('gender', '性別', 'required');
        $this->form_validation->set_rules('start_date', '收案日', 'required');
        $this->form_validation->set_rules('care_center', '照護機構', 'required');

        $this->form_validation->set_custom_error_messages();

        if ($this->form_validation->run() === FALSE) {
            $response['success'] = false;
            $response['errors'] = array(
                // 'personal_id' => form_error('personal_id'),
                // 'record_number' => form_error('record_number'),
                // 'patient_name' => form_error('patient_name'),
                // 'birthday' => form_error('birthday'),
                // 'gender' => form_error('gender'),
                'start_date' => form_error('start_date'),
                'care_center' => form_error('care_center')
            );
        } else {
            $response['success'] = true;
            $patient_data = $this->session->userdata('patient_data');
            // $gender = ($patient_data->gender == 'M') ? 'male' : 'female'; // TODO: EDIT
            $user_data = [
                "personal_id" => $patient_data->personal_id,
                'record_number' => $patient_data->record_number,
                'patient_name' => $patient_data->patient_name,
                'birthday' => $patient_data->birthday,
                'gender' => $patient_data->gender,
                // 'gender' => $gender, // TODO: EDIT
                'start_date' => $this->input->post('start_date'),
                "care_center" => $this->input->post('care_center'),
                'age' => $patient_data->age,
            ];

            $this->homecare_model->insert_homecare($user_data);
        }

        echo json_encode($response);
    }

    // 修改
    public function edit()
    {
        // $this->form_validation->set_rules('e_end_date', '結案日', 'required');

        // $this->form_validation->set_custom_error_messages();
        $patient_id = $this->session->userdata('id');
        // if ($this->form_validation->run() === FALSE) {
        // $response['success'] = false;
        // $response['errors'] = array(
        //     'username' => form_error('e_username'),
        // );
        // } else {
        $response['success'] = true;
        $homecare_data = [
            "end_date" => $this->input->post('e_end_date'),
            'is_end' => 1,
        ];

        $this->homecare_model->update_homecare($homecare_data, $patient_id);
        // }

        echo json_encode($response);
    }

    // 取資料
    public function get_homecare_data()
    {
        $id = $this->input->post('patient_id');
        $this->session->set_userdata('id', $id);
        $userData = $this->homecare_model->get_homecare_by_id($id);
        echo json_encode($userData);
    }

    public function get_patient_data()
    {
        $this->load->model('test_patient_model');

        $personal_id = $this->input->post('personalId');
        $record_number = $this->input->post('recordNumber');
        // $patientData_by_personal_id = $this->homecare_model->get_patient_by_personal_id($personal_id);
        // $patientData_by_record_number = $this->homecare_model->get_patient_by_record_number($record_number);
        $patientData_by_personal_id = $this->test_patient_model->get_patient_by_personal_id($personal_id);
        $patientData_by_record_number = $this->test_patient_model->get_patient_by_record_number($record_number);

        if ($patientData_by_personal_id || $patientData_by_record_number) {
            if ($patientData_by_personal_id) {
                $results = $this->homecare_model->get_home_care_by_personal_id($personal_id);
            } else {
                $results = $this->homecare_model->get_home_care_by_record_number($record_number);
            }

            $success = true;

            foreach ($results as $result) {
                if ($result->is_end == 0) {
                    $success = false;
                    break;
                }
            }

            if ($success) {
                function process_patient_data($patientData)
                {
                    $patientData->patient_name = $patientData->p_name; // TODO: EDIT
                    unset($patientData->p_name);
                    if ($patientData->gender == 'M') {
                        $patientData->gender = 'male';
                    } elseif ($patientData->gender == 'F') {
                        $patientData->gender = 'female';
                    }
                    return $patientData;
                }

                if ($patientData_by_personal_id) {
                    $patientData = process_patient_data($patientData_by_personal_id);
                } else {
                    $patientData = process_patient_data($patientData_by_record_number);
                }
                $response = [
                    'success' => true,
                    'message' => '完成更新',
                    'patientData' => $patientData,
                ];

                $this->session->set_userdata('patient_data', $patientData);
            } else {
                $response = [
                    'success' => false,
                    'message' => '個案已存在,請先結案再重新建立',
                ];
            }
        } else {
            $response = [
                'success' => false,
                'message' => '查無此病患',
            ];
        }

        echo json_encode($response);
    }



    // DataTables
    public function get_data_homecare()
    {
        $this->load->library('ssp');
        $dbDetails = array(
            'host' => $this->db->hostname,
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db'   => $this->db->database
        );
        $table = 'homecare';
        $primaryKey = 'id';
        // DataTables 設定
        $columns = array(
            array(
                'db' => 'care_center', 'dt' => 0
            ),
            array(
                'db' => 'start_date', 'dt' => 1
            ),
            array(
                'db' => 'personal_id', 'dt' => 2
            ),
            array(
                'db' => 'patient_name', 'dt' => 3
            ),
            array(
                'db' => 'is_end', 'dt' => 4
            ),
            array(
                'db' => 'record_number', 'dt' => 5
            ),
            array(
                'db' => 'id',
                'dt' => 6,
                'formatter' => function ($data, $row) {
                    return '<button class="btn btn-sm btn-warning btnTakePicture" data-record_number="' . $row['record_number'] . '">圖片上傳</button>
                    <button class="btn btn-sm btn-secondary btnCaseEnd" data-id="' . $row['id'] . '" data-bs-toggle="modal" data-bs-target="#caseEndModal">結案</button>';
                }
            )
        );

        $output = $this->ssp->simple($this->input->get(), $dbDetails, $table, $primaryKey, $columns);

        echo json_encode($output);
    }
}
