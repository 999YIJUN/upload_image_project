<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Patient extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('patient_model');
	}

	public function patient_data()
	{
		$record_number = $this->input->post('recordNumber');
		$source = $this->input->post('source');

		$patient_data = $this->patient_model->get_patient_by_record_number($record_number);

		$this->session->set_userdata('patient_data', $patient_data);
		$this->session->set_userdata('source', $source);
		$response['success'] = true;
		echo json_encode($response);
	}
}
