<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Image extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('image_model');
    }

    public function index()
    {
        $data['source'] = $this->session->userdata('source');
        $data['patient_data'] = $this->session->userdata('patient_data');
        $this->load->view('camera', $data);
    }

    // public function upload()
    // {
    //     $fileName = $this->input->post('fileName');

    //     $data = array(
    //         'image' => $fileName
    //     );

    //     $this->Image_model->insert_image($data);
    // }

    public function upload()
    {
        $picture = $this->input->post('picture');
        $fileName = $this->input->post('fileName');
        $patient_data = $this->session->userdata('patient_data');
        $source = $this->session->userdata('source');
        if ($picture && $fileName) {
            $filePath = FCPATH . 'images/' . $fileName . '.png';
            // $filePath = 'C:\Users\Public\Pictures/' . $fileName . '.png';

            $pictureData = str_replace('data:image/png;base64,', '', $picture);
            $pictureData = str_replace(' ', '+', $pictureData);
            $pictureBinary = base64_decode($pictureData);
            // 將圖片儲存到指定路徑
            if (file_put_contents($filePath, $pictureBinary)) {
                $data = array(
                    'image_name' => $fileName,
                    'personal_id' => $patient_data->personal_id,
                    'patient_name' =>  $patient_data->patient_name,
                    'record_number' => $patient_data->record_number,
                    'create_date' => date('Y-m-d'),
                    'source' => $source
                );

                $this->image_model->insert_image($data);
                echo "圖片已成功儲存到 " . $filePath;
            } else {
                echo "儲存圖片時發生錯誤！";
            }
        } else {
            echo "請提供圖片資料和檔案名稱！";
        }
    }

    public function display()
    {
        $images = $this->session->userdata('picture');
        $record_number = $this->session->userdata('record_number');
        $patient_data = $this->image_model->get_patient_by_record_number($record_number);
        if ($images) {
            $imageData = array();
            foreach ($images as $image) {
                $imagePath = base_url('images/' . $image->image_name . '.png');
                // $sourcePath = 'C:\Users\Public\Pictures/' . $image->image_name . '.png';
                // $destinationPath = FCPATH . 'assets/images/' . $image->image_name . '.png';
                // copy($sourcePath, $destinationPath);
                // // 指定圖片路徑
                // $imagePath = base_url('assets/images/' . $image->image_name . '.png');


                $imageData[] = array(
                    'path' => $imagePath,
                    'name' => $image->image_name,
                    'source' => $image->source,
                    'date' => $image->create_date
                );
            }
            $data['patient_data'] = $patient_data;
            $data['user'] = $this->session->userdata('user');
            $data['image_data'] = $imageData; // path和image_name的關聯陣列
            $this->load->view('image/image_view', $data);
        } else {
            // $this->load->view('no_image_view');
        }
    }

    public function image_gallery()
    {
        $data['user'] = $this->session->userdata('user');
        $data['record_numbers'] = $this->image_model->get_unique_record_numbers();
        if ($data['user']) {
            $this->load->view('image/image_gallery', $data);
        } else {
            redirect('user/index');
        }
    }

    public function image_data()
    {
        $record_number = $this->input->post('recordNumber');
        $picture = $this->image_model->get_image_by_record_number($record_number);
        $this->session->set_userdata('picture', $picture);
        $this->session->set_userdata('record_number', $record_number);
        $response['success'] = true;
        echo json_encode($response);
    }

    public function delete_image()
    {
        $image_name = $this->input->post('image_name');
        $image_id =  $this->image_model->get_image_id_by_image_name($image_name);
        $this->image_model->delete_image($image_id);
        $image_path = FCPATH . 'images/' . $image_name . '.png';
        if (file_exists($image_path)) {
            unlink($image_path); // 刪除圖片
        }
        $response['status'] = 'success';
        echo json_encode($response);
    }
}
