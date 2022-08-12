<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DiagnosaPakar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['ProbabilitasPakar/ProbabilitasPakar_model']);
    }

    public function index()
    {
        $data['title'] = 'Data Probabilitas Pakar';
        $data['probabilitas_pakar'] = $this->ProbabilitasPakar_model->get()->result();

        $this->template->front('front/probabilitaspakar/main', $data);
    }
}
