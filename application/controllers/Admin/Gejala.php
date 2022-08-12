<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gejala extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        if (!$this->session->has_userdata('id_users')) {
            show_404();
        }
        $this->load->model(['Gejala/Gejala_model']);
    }
    public function index()
    {
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Gejala', 'Admin/Gejala');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Gejala';
        $this->template->admin('admin/gejala/main', $data);
    }

    public function process()
    {
        $this->form_validation->set_rules('kode_gejala', 'Kode gejala', 'required|callback_validateKodeGejala');
        $this->form_validation->set_rules('nama_gejala', 'Nama gejala', 'required');
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
                $data_Gejala = [
                    'kode_gejala' =>  htmlspecialchars($this->input->post('kode_gejala', true)),
                    'nama_gejala' => htmlspecialchars($this->input->post('nama_gejala', true)),
                ];
                $insert = $this->Gejala_model->insert($data_Gejala);
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
                $id = htmlspecialchars($this->input->post('id_gejala', true));
                $data = [
                    'status' => 'error',
                    'output' => $this->form_validation->error_array()
                ];
                echo json_encode($data);
            } else {
                $id = htmlspecialchars($this->input->post('id_gejala', true));
                $data_Gejala = [
                    'kode_gejala' =>  htmlspecialchars($this->input->post('kode_gejala', true)),
                    'nama_gejala' => htmlspecialchars($this->input->post('nama_gejala', true)),
                ];
                $update = $this->Gejala_model->update($data_Gejala, $id);
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

        $get = $this->Gejala_model->get($id)->row();

        $data = [
            'row' => $get,
        ];
        echo json_encode($data);
    }

    public function delete()
    {
        $id_gejala = htmlspecialchars($this->input->post('id_gejala', true));
        $delete = $this->Gejala_model->delete($id_gejala);
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
        $data = $this->Gejala_model->get()->result();
        $result = [];
        $no = 1;
        if ($data == null) {
            $result['data'] = [];
        }
        foreach ($data as $index => $v_data) {
            $result['data'][] = [
                $no++,
                $v_data->kode_gejala,
                $v_data->nama_gejala,
                '
                <div class="text-center">
                    <a href="' . base_url('Admin/Gejala/edit/' . $v_data->id_gejala) . '" class="btn btn-warning btn-edit" data-id_gejala="' . $v_data->id_gejala . '">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a href="' . base_url('Admin/Gejala/delete') . '" class="btn btn-danger btn-delete" data-id_gejala="' . $v_data->id_gejala . '">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
                '
            ];
        }
        echo json_encode($result);
    }
    public function validateKodeGejala()
    {
        $check = TRUE;
        $kode_gejala = $this->input->post('kode_gejala', true);
        if ($_POST['page'] == 'add') {
            $check_gejala = $this->db->get_where('gejala', ['kode_gejala' => $kode_gejala])->num_rows();
            if ($check_gejala > 0) {
                $this->form_validation->set_message('validateKodeGejala', 'Kode sudah digunakan');
                $check = FALSE;
            }
        } else {
            $id_gejala = $this->input->post('id_gejala', true);
            $check_gejala = $this->db->get_where('gejala', ['kode_gejala' => $kode_gejala, 'id_gejala <> ' => $id_gejala])->num_rows();
            if ($check_gejala > 0) {
                $this->form_validation->set_message('validateKodeGejala', 'Kode sudah digunakan');
                $check = FALSE;
            }
        }
        return $check;
    }
    public function kodeGejala()
    {
        $kodeGejala =  kodeGejala();
        echo json_encode($kodeGejala);
    }
}
