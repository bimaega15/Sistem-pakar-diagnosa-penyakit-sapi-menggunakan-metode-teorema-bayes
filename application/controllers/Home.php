<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Users/Users_model', 'Konfigurasi/Konfigurasi_model', 'ProbabilitasPakar/ProbabilitasPakar_model']);
    }

    public function index()
    {
        $data['konfigurasi'] = $this->Konfigurasi_model->get()->row();
        $probablitasPakar =  $this->ProbabilitasPakar_model->get()->result();

        // data probabilitas
        $dataProbabilitas = [];
        foreach ($probablitasPakar as $key => $vProbabilitas) {
            $dataProbabilitas[$vProbabilitas->penyakit_id][] = $vProbabilitas;
        }

        $indexPlus = 0;
        $convertDataProbabilitas = [];
        $getConvertDataProb = [];
        foreach ($dataProbabilitas as $penyakit_id => $value) {
            $convertDataProbabilitas[$indexPlus] = $value;
            $getConvertDataProb[$indexPlus] = $penyakit_id;
            $indexPlus++;
        }

        $limit = $this->setPagination($convertDataProbabilitas)['limit'];
        $offset = $this->setPagination($convertDataProbabilitas)['offset'];
        $getPage = $this->setPagination($convertDataProbabilitas)['getPage'];

        // ajax
        if ($this->input->is_ajax_request()) {
            // pagination
            $limit = $this->setPagination($convertDataProbabilitas)['limit'];
            $offset = $this->setPagination($convertDataProbabilitas)['offset'];
            $getPage = $this->setPagination($convertDataProbabilitas)['getPage'];
            $penyakit =  array_slice($convertDataProbabilitas, $offset, $limit);
            $arr_solusi = [];
            foreach ($penyakit as $key => $v_penyakit) {
                $getPenyakit = ($v_penyakit[0])->id_penyakit;
                $solusi = check_solusi(null, $getPenyakit)->result();
                $arr_solusi[] = $solusi;
            }
            $output = [
                'status' => 'success',
                'output' => $penyakit,
                'getPage' => $getPage,
                'offset' => $offset,
                'limit' => $limit,
                'solusi' => $arr_solusi,
                'pagination_link' => $this->pagination->create_links()
            ];
            echo json_encode($output);
            return;
        }


        $data['title'] = 'Home page';
        $data['penyakit'] = array_slice($convertDataProbabilitas, $offset, $limit);
        $data['dataProbabilitas'] = $dataProbabilitas;
        $data['getConvertDataProb'] = $getConvertDataProb;
        $data['getPage'] = $getPage;

        $this->template->front('front/home/main', $data);
    }

    private function setPagination($convertDataProbabilitas)
    {
        $limit = 6;
        $config['base_url'] = base_url('Home');
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = count($convertDataProbabilitas);
        $config['per_page'] = $limit;
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';

        $this->pagination->initialize($config);
        $offset = 0;
        $getPage = 0;
        if (isset($_GET['per_page']) && $_GET['per_page'] != 0) {
            $getPage = $this->input->get('per_page', true);
            $page = $getPage * $limit;
            $page_current = $page - $limit;
            $offset = $page_current;
        }
        return [
            'limit' => $limit,
            'offset' => $offset,
            'getPage' => $getPage,
        ];
    }

    public function sendKontak()
    {
        $this->form_validation->set_rules('nama_depan', 'Nama depan', 'required');
        $this->form_validation->set_rules('nama_belakang', 'Nama Belakang', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('comments', 'Comment', 'required');
        $this->form_validation->set_message('required', '{field} Wajib diisi');
        $this->form_validation->set_error_delimiters('<small class="text-danger">', '</small><br>');

        if ($this->form_validation->run() == false) {
            $data = [
                'status' => 'error',
                'output' => $this->form_validation->error_array()
            ];
            echo json_encode($data);
        } else {
            $konfigurasi = konfigurasi();
            $data_kontak = [
                'nama_depan' => htmlspecialchars($this->input->post('nama_depan', true)),
                'nama_belakang' => htmlspecialchars($this->input->post('nama_belakang', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'subject' => htmlspecialchars($this->input->post('subject', true)),
                'comments' => htmlspecialchars($this->input->post('comments', true)),
            ];

            $html = $this->load->view('template/email/contact', [
                'konfigurasi' => $konfigurasi,
                'data_kontak' => $data_kontak
            ], true);
            $nameAccount = $data_kontak['nama_depan'] . ' ' . $data_kontak['nama_belakang'];
            $email = $this->sendEmail($html, $data_kontak['email'], $nameAccount, $data_kontak['subject']);

            if ($email) {
                $data = [
                    'status_db' => 'success',
                    'output' => 'Berhasil kirim pesan'
                ];
            } else {
                $data = [
                    'status_db' => 'error',
                    'output' => 'Gagal kirim pesan'
                ];
            }
            echo json_encode($data);
        }
    }

    private function sendEmail($html, $toEmail = null, $nameAccount = null, $subject = null)
    {
        $name = 'Admin Pakar Penyakit Sapi';
        $to = $toEmail;
        $toName = $nameAccount;
        $subject = $subject;
        $body = $html;

        $from = 'masbim956@gmail.com';
        $password = 'jrbimkyofprgmngq';


        $mail = new PHPMailer();
        $mail->IsSMTP();

        $mail->SMTPDebug = 0;
        $mail->SMTPAuth   = TRUE;
        $mail->SMTPSecure = "ssl";
        $mail->Host       = "smtp.gmail.com";
        $mail->Port       = 465;
        $mail->Username   = $from;
        $mail->Password   = $password;

        $mail->IsHTML(true);
        $mail->SetFrom($from, $name);
        $mail->AddAddress($to, $toName);

        // file
        $konfigurasi = konfigurasi();
        $mail->AddEmbeddedImage('public/image/konfigurasi/' . $konfigurasi->gambar_konfigurasi, 'gambar_konfigurasi');

        $mail->Subject = $subject;
        $mail->Body = $body;
        $email = $mail->Send();
        if ($email) {
            return true;
        } else {
            return false;
        }
    }
}
