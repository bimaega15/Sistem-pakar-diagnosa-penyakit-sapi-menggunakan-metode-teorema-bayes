<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Solusi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        if (!$this->session->has_userdata('id_users')) {
            show_404();
        }
        $this->load->model(['Solusi/Solusi_model', 'Penyakit/Penyakit_model']);
    }
    public function index()
    {
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Solusi', 'Admin/Solusi');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Solusi';
        $data['penyakit'] = $this->Penyakit_model->get()->result();
        $this->template->admin('admin/solusi/main', $data);
    }

    public function process()
    {
        $this->form_validation->set_rules('kode_solusi', 'Kode Solusi', 'required|callback_validateKodeSolusi');
        $this->form_validation->set_rules('keterangan_solusi', 'Keterangan', 'required');
        $this->form_validation->set_rules('penyakit_id', 'Penyakit', 'required');
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
                $data_Solusi = [
                    'kode_solusi' => kodeSolusi(),
                    'keterangan_solusi' => htmlspecialchars($this->input->post('keterangan_solusi', true)),
                    'penyakit_id' => htmlspecialchars($this->input->post('penyakit_id', true)),
                ];
                $insert = $this->Solusi_model->insert($data_Solusi);
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
                $id = htmlspecialchars($this->input->post('id_solusi', true));
                $data = [
                    'status' => 'error',
                    'output' => $this->form_validation->error_array()
                ];
                echo json_encode($data);
            } else {
                $id = htmlspecialchars($this->input->post('id_solusi', true));
                $data_Solusi = [
                    'kode_solusi' =>  htmlspecialchars($this->input->post('kode_solusi', true)),
                    'keterangan_solusi' => htmlspecialchars($this->input->post('keterangan_solusi', true)),
                    'penyakit_id' => htmlspecialchars($this->input->post('penyakit_id', true)),
                ];
                $update = $this->Solusi_model->update($data_Solusi, $id);
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
        $get = $this->Solusi_model->get($id)->row();
        $data = [
            'row' => $get,
        ];
        echo json_encode($data);
    }

    public function delete()
    {
        $id_solusi = htmlspecialchars($this->input->post('id_solusi', true));
        $delete = $this->Solusi_model->delete($id_solusi);
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
        $data = $this->Solusi_model->get()->result();
        $result = [];
        $no = 1;
        if ($data == null) {
            $result['data'] = [];
        }
        foreach ($data as $index => $v_data) {
            $result['data'][] = [
                $no++,
                $v_data->kode_solusi,
                $v_data->keterangan_solusi,
                $v_data->nama_penyakit,
                '
                <div class="text-center">
                    <a href="' . base_url('Admin/Solusi/edit/' . $v_data->id_solusi) . '" class="btn btn-warning btn-edit" data-id_solusi="' . $v_data->id_solusi . '">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a href="' . base_url('Admin/Solusi/delete/') . '" class="btn btn-danger btn-delete" data-id_solusi="' . $v_data->id_solusi . '">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
                '
            ];
        }
        echo json_encode($result);
    }
    public function validateKodeSolusi()
    {
        $check = TRUE;
        $kode_solusi = $this->input->post('kode_solusi', true);
        if ($_POST['page'] == 'add') {
            $check_Solusi = $this->db->get_where('solusi', ['kode_solusi' => $kode_solusi])->num_rows();
            if ($check_Solusi > 0) {
                $this->form_validation->set_message('validateKodeSolusi', 'Kode sudah digunakan');
                $check = FALSE;
            }
        } else {
            $id_solusi = $this->input->post('id_solusi', true);
            $check_Solusi = $this->db->get_where('solusi', ['kode_solusi' => $kode_solusi, 'id_solusi <> ' => $id_solusi])->num_rows();
            if ($check_Solusi > 0) {
                $this->form_validation->set_message('validateKodeSolusi', 'Kode sudah digunakan');
                $check = FALSE;
            }
        }
        return $check;
    }
    public function kodeSolusi()
    {
        $kodeSolusi =  kodeSolusi();
        echo json_encode($kodeSolusi);
    }
}
