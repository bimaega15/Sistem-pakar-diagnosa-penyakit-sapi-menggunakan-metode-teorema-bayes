<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();

        if (!$this->session->has_userdata('id_users')) {
            show_404();
        }
        $this->load->model(['Gejala/Gejala_model', 'Penyakit/Penyakit_model', 'Users/Users_model', 'Rule/Rule_model', 'Hasil/Hasil_model']);
    }
    public function index()
    {
        $this->breadcrumbs->push('Home', 'Admin/Home');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Dashboard';
        $data['gejala'] = $this->Gejala_model->get()->num_rows();
        $data['penyakit'] = $this->Penyakit_model->get()->num_rows();
        $data['users'] = $this->Users_model->get()->num_rows();
        $data['rule'] = $this->Rule_model->get()->num_rows();
        $data['hasil'] = $this->Hasil_model->get()->num_rows();

        $this->template->admin('admin/home/main', $data);
    }
}
