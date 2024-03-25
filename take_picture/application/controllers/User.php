<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function index()
    {
        $this->load->view('signin');
    }

    public function user_view()
    {
        $data['user'] = $this->session->userdata('user');
        $this->load->view('users/user_view', $data);
    }

    // 登入
    public function signin()
    {
        $this->form_validation->set_rules('account', '帳號', 'required');
        $this->form_validation->set_rules('password', '密碼', 'required');
        $this->form_validation->set_custom_error_messages();
        $account = $this->input->post('account');
        $password = $this->input->post('password');
        $user = $this->user_model->get_user_by_account($account);

        if ($this->form_validation->run() === FALSE) {
            $response['success'] = false;
            $response['errors'] = array(
                'account' => form_error('account'),
                'password' => form_error('password')
            );
        } else {
            if ($user) {
                // 如果帳號存在，檢查密碼是否正確
                if (password_verify($password, $user->password)) {
                    $response['success'] = true;
                    $response['permission'] = $user->permission;
                    $this->session->set_userdata('user', $user);
                } else {
                    $response['success'] = false;
                    $response['errors'] = array(
                        'password' => '密碼不正確'
                    );
                }
            } else {
                // 如果帳號不存在，返回錯誤消息
                $response['success'] = false;
                $response['errors'] = array(
                    'account' => '帳號不存在'
                );
            }
        }

        echo json_encode($response);
    }

    // 登出
    public function signout()
    {
        $this->session->unset_userdata('user');

        redirect('user/index');
    }

    // 新增
    public function insert()
    {
        $this->form_validation->set_rules('username', '姓名', 'required');
        $this->form_validation->set_rules('account', '帳號', 'required');
        $this->form_validation->set_rules('title', '職稱', 'required');
        $this->form_validation->set_rules('password', '密碼', 'required');
        $this->form_validation->set_rules('password_confirm', '密碼確認', 'required|matches[password]');

        $this->form_validation->set_custom_error_messages();

        if ($this->form_validation->run() === FALSE) {
            $response['success'] = false;
            $response['errors'] = array(
                'username' => form_error('username'),
                'account' => form_error('account'),
                'title' => form_error('title'),
                'password' => form_error('password'),
                'password_confirm' => form_error('password_confirm'),
            );
        } else {
            $response['success'] = true;
            $response['errors'] = array(
                'password_confirm' => '',
            );
            $user_data = [
                "username" => $this->input->post('username'),
                'account' => $this->input->post('account'),
                // password_hash 字串長度為60
                "password" => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                "title" => $this->input->post('title')
            ];

            $this->user_model->insert_user($user_data);
        }

        echo json_encode($response);
    }

    // 修改
    public function edit()
    {
        // $this->form_validation->set_rules('e_username', '姓名', 'required');
        // $this->form_validation->set_rules('e_account', '帳號', 'required');
        // $this->form_validation->set_rules('e_title', '職稱', 'required');
        // $this->form_validation->set_rules('e_password', '密碼', 'required');

        $this->form_validation->set_rules('e_password', '密碼', 'trim');
        $this->form_validation->set_rules('e_password_confirm', '密碼確認', 'trim|matches[e_password]');
        $user_data = $this->session->userdata('user');
        $this->form_validation->set_custom_error_messages();
        $user_id = $this->session->userdata('user_id');

        if ($this->form_validation->run() === FALSE) {
            $response['success'] = false;
            $response['errors'] = array(
                // 'username' => form_error('e_username'),
                // 'account' => form_error('e_account'),
                // 'title' => form_error('e_title'),
                'password' => form_error('e_password'),
                'password_confirm' => form_error('e_password_confirm'),
            );
        } else {
            $response['success'] = true;
            if ($user_data->permission == 'admin') {
                $user_data = [
                    // "username" => $this->input->post('e_username'),
                    // 'account' => $this->input->post('e_account'),
                    // password_hash 字串長度為60
                    // "password" => password_hash($this->input->post('e_password'), PASSWORD_DEFAULT),
                    "permission" => $this->input->post('e_permission')
                    // "title" => $this->input->post('e_title')
                ];
            }
            if (!empty($this->input->post('e_password'))) {
                // password_hash 字串長度為60
                $user_data['password'] = password_hash($this->input->post('e_password'), PASSWORD_DEFAULT);
            }
            if (!empty($user_data)) {
                $this->user_model->update_user($user_data, $user_id);
            }
        }

        echo json_encode($response);
    }

    // 刪除
    public function delete()
    {
        $userId = $this->input->post('userId');
        $deleted = $this->user_model->delete_user($userId);
        if ($deleted) {
            $response['status'] = 'success';
            $response['message'] = '使用者已成功刪除';
        } else {
            $response['status'] = 'error';
            $response['message'] = '無法刪除使用者，請稍後再試';
        }
        echo json_encode($response);
    }

    // 取資料
    public function get_user_data()
    {
        $user_id = $this->input->post('user_id');
        $this->session->set_userdata('user_id', $user_id);
        $userData = $this->user_model->get_user_by_id($user_id);
        echo json_encode($userData);
    }

    // DataTables
    public function get_data_user()
    {
        $this->load->library('ssp');
        $dbDetails = array(
            'host' => $this->db->hostname,
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db'   => $this->db->database
        );
        $table = 'users';
        $primaryKey = 'user_id';
        // DataTables 設定
        $columns = array(
            array(
                'db' => 'user_id', 'dt' => 0
            ),
            array(
                'db' => 'username', 'dt' => 1
            ),
            array(
                'db' => 'account', 'dt' => 2
            ),
            array(
                'db' => 'title', 'dt' => 3
            ),
            array(
                'db' => 'permission', 'dt' => 4,
                'formatter' => function ($data, $row) {
                    switch ($data) {
                        case 'general':
                            return '<span class="badge bg-secondary">一般使用者</span>';
                        case 'advance':
                            return '<span class="badge bg-info">進階使用者</span>';
                        case 'admin':
                            return '<span class="badge bg-success">系統管理員</span>';
                        default:
                            return '<span class="badge bg-secondary">未知</span>';
                    }
                }
            ),
            array(
                'db' => 'user_id',
                'dt' => 5,
                'formatter' => function ($data, $row) {
                    return
                        '<button class="btn btn-sm btn-warning btnEdit" data-user_id="' . $row['user_id'] . '" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa-solid fa-pen"></i> 修改</button>
                    <button class="btn btn-sm btn-danger btnDelete" data-user_id="' . $row['user_id'] . '"><i class="fa-solid fa-trash"></i> 刪除</button>';
                }
            )
        );

        $output = $this->ssp->simple($this->input->get(), $dbDetails, $table, $primaryKey, $columns);

        echo json_encode($output);
    }
}
