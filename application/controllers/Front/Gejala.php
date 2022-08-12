<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gejala extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Gejala/Gejala_model']);
    }

    public function index()
    {
        $data['title'] = 'Data gejala';
        $data['gejala'] = $this->Gejala_model->get()->result();
        $this->template->front('front/gejala/main', $data);
    }
}
