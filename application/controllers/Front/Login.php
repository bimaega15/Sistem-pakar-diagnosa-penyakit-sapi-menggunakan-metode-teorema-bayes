<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Users/Users_model', 'Profile/Profile_model']);
        check_already_login_users();
    }

    public function index()
    {
        $data['title'] = 'Form Login';
        $this->template->front('front/login/main', $data);
    }
    public function process()
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == false) {
            return $this->index();
        } else {
            $username = $this->input->post('username', true);
            $password = $this->input->post('password', true);

            $model = $this->Users_model->login($username, $password);
            if ($model->num_rows() > 0) {
                $row = $model->row();
                if ($row->level == 'admin') {
                    $this->session->set_flashdata('error', 'Anda login sebagai admin');
                    return redirect(base_url('Front/Login'));
                }
                $cookie = htmlspecialchars($this->input->post('cookie', true));
                if ($cookie != null) {
                    $row_cookie = sha1($row->username);
                    set_cookie('cookie', $row_cookie, (60 * 60 * 24));
                    $dataCookie = [
                        'cookie' => $row_cookie,
                    ];
                    $this->Users_model->update($dataCookie, $row->id_users);
                }

                $this->session->set_userdata([
                    'id_users' => $row->id_users,
                ]);
                $this->session->set_flashdata('success', 'Selamat login! ' . $row->nama_profile);
                return redirect(base_url('Front/Account/Riwayat'));
            } else {
                $this->session->set_flashdata('error', 'Username atau password Users salah');
                return redirect('Front/Login');
            }
        }
    }
}
