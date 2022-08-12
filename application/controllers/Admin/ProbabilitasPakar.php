<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ProbabilitasPakar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        if (!$this->session->has_userdata('id_users')) {
            show_404();
        }
        $this->load->model(['ProbabilitasPakar/ProbabilitasPakar_model', 'Gejala/Gejala_model', 'Penyakit/Penyakit_model']);
    }
    public function index()
    {
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Probabilitas Pakar', 'Admin/ProbabilitasPakar');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Probabilitas Pakar';
        $data['gejala'] = $this->Gejala_model->get()->result();
        $data['penyakit'] = $this->Penyakit_model->get()->result();
        $this->template->admin('admin/probabilitaspakar/main', $data);
    }

    public function process()
    {
        $this->form_validation->set_rules('gejala_id', 'Gejala', 'required');
        $this->form_validation->set_rules('penyakit_id', 'Penyakit', 'required');
        $this->form_validation->set_rules('bobot_probabilitas_pakar', 'Bobot probabilitas', 'required');

        $this->form_validation->set_message('required', '{field} Wajib diisi');
        $this->form_validation->set_error_delimiters('<small class="text-danger">', '</small><br>');

        if (($_POST['page']) == 'add') {
            if ($this->form_validation->run() == false) {
                $data = [
                    'status' => 'error',
                    'output' => $this->form_validation->error_array()
                ];
                echo json_encode($data);
            } else {
                $data_ProbabilitasPakar = [
                    'gejala_id' =>  htmlspecialchars($this->input->post('gejala_id', true)),
                    'penyakit_id' => htmlspecialchars($this->input->post('penyakit_id', true)),
                    'bobot_probabilitas_pakar' => htmlspecialchars($this->input->post('bobot_probabilitas_pakar', true)),
                ];
                $insert = $this->ProbabilitasPakar_model->insert($data_ProbabilitasPakar);
                if ($insert > 0) {
                    $data = [
                        'status_db' => 'success',
                        'output' => 'Berhasil menambah data'
                    ];
                    echo json_encode($data);
                } else {
                    $data = [
                        'status_db' => 'error',
                        'output' => 'Gagal mengubah data'
                    ];
                    echo json_encode($data);
                }
            }
        } else if (($_POST['page']) == 'edit') {
            if ($this->form_validation->run() == false) {
                $id = htmlspecialchars($this->input->post('id_probabilitas_pakar', true));
                $data = [
                    'status' => 'error',
                    'output' => $this->form_validation->error_array()
                ];
                echo json_encode($data);
            } else {
                $id = htmlspecialchars($this->input->post('id_probabilitas_pakar', true));
                $data_ProbabilitasPakar = [
                    'gejala_id' =>  htmlspecialchars($this->input->post('gejala_id', true)),
                    'penyakit_id' => htmlspecialchars($this->input->post('penyakit_id', true)),
                    'bobot_probabilitas_pakar' => htmlspecialchars($this->input->post('bobot_probabilitas_pakar', true)),
                ];
                $update = $this->ProbabilitasPakar_model->update($data_ProbabilitasPakar, $id);
                if ($update > 0) {
                    $data = [
                        'status_db' => 'success',
                        'output' => 'Berhasil mengubah data'
                    ];
                    echo json_encode($data);
                } else {
                    $data = [
                        'status_db' => 'error',
                        'output' => 'Gagal mengubah data'
                    ];
                    echo json_encode($data);
                }
            }
        }
    }
    public function edit($id)
    {
        $get = $this->ProbabilitasPakar_model->get($id)->row();
        $data = [
            'row' => $get,
        ];
        echo json_encode($data);
    }

    public function delete()
    {
        $id_probabilitas_pakar = htmlspecialchars($this->input->post('id_probabilitas_pakar', true));
        $delete = $this->ProbabilitasPakar_model->delete($id_probabilitas_pakar);
        if ($delete) {
            $data = [
                'status' => "success",
                'msg' => 'Success hapus data'
            ];
            echo json_encode($data);
        } else {
            $data = [
                'status' => "error",
                'msg' => 'Error hapus data'
            ];
            echo json_encode($data);
        }
    }

    public function loadData()
    {
        $data = $this->ProbabilitasPakar_model->get()->result();
        $result = [];
        $no = 1;
        if ($data == null) {
            $result['data'] = [];
        }
        foreach ($data as $index => $v_data) {
            $result['data'][] = [
                $no++,
                $v_data->kode_penyakit . ' ' . $v_data->nama_penyakit,
                $v_data->kode_gejala . ' ' . $v_data->nama_gejala,
                $v_data->bobot_probabilitas_pakar,
                '
                <div class="text-center">
                    <a href="' . base_url('Admin/ProbabilitasPakar/edit/' . $v_data->id_probabilitas_pakar) . '" class="btn btn-warning btn-edit" data-id_probabilitas_pakar="' . $v_data->id_probabilitas_pakar . '">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a href="' . base_url('Admin/ProbabilitasPakar/delete') . '" class="btn btn-danger btn-delete" data-id_probabilitas_pakar="' . $v_data->id_probabilitas_pakar . '">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
                '
            ];
        }
        echo json_encode($result);
    }
}
