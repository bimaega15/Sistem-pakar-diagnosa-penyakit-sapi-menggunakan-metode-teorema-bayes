<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penyakit extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Penyakit/Penyakit_model']);
    }

    public function index()
    {
        $data['title'] = 'Data Penyakit';
        $data['penyakit'] = $this->Penyakit_model->get()->result();
        $this->template->front('front/penyakit/main', $data);
    }
}
