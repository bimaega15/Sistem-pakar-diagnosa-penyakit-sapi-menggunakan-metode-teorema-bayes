<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Solusi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Solusi/Solusi_model']);
    }

    public function index()
    {
        $data['title'] = 'Data Solusi';
        $data['solusi'] = $this->Solusi_model->get()->result();
        $this->template->front('front/solusi/main', $data);
    }
}
