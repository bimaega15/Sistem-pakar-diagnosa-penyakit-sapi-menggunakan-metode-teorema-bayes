<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rule extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        if (!$this->session->has_userdata('id_users')) {
            show_404();
        }
        $this->load->model(['Rule/Rule_model', 'Penyakit/Penyakit_model']);
    }
    public function index()
    {
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Rule', 'Admin/Rule');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Rule';
        $data['penyakit'] = $this->Penyakit_model->get()->result();
        $this->template->admin('admin/rule/main', $data);
    }

    public function process()
    {
        $this->form_validation->set_rules('kode_rule', 'Kode Rule', 'required|callback_validateKodeRule');
        $this->form_validation->set_rules('nama_rule', 'Nama rule', 'required');
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
                $data_Rule = [
                    'kode_rule' => kodeRule(),
                    'nama_rule' => htmlspecialchars($this->input->post('nama_rule', true)),
                    'penyakit_id' => htmlspecialchars($this->input->post('penyakit_id', true)),
                ];
                $insert = $this->Rule_model->insert($data_Rule);
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
                $id = htmlspecialchars($this->input->post('id_rule', true));
                $data = [
                    'status' => 'error',
                    'output' => $this->form_validation->error_array()
                ];
                echo json_encode($data);
            } else {
                $id = htmlspecialchars($this->input->post('id_rule', true));
                $data_Rule = [
                    'kode_rule' =>  htmlspecialchars($this->input->post('kode_rule', true)),
                    'nama_rule' => htmlspecialchars($this->input->post('nama_rule', true)),
                    'penyakit_id' => htmlspecialchars($this->input->post('penyakit_id', true)),
                ];
                $update = $this->Rule_model->update($data_Rule, $id);
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
        $get = $this->Rule_model->get($id)->row();
        $data = [
            'row' => $get,
        ];
        echo json_encode($data);
    }

    public function delete()
    {
        $id_rule = htmlspecialchars($this->input->post('id_rule', true));
        $delete = $this->Rule_model->delete($id_rule);
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
        $data = $this->Rule_model->get()->result();
        $result = [];
        $no = 1;
        if ($data == null) {
            $result['data'] = [];
        }
        foreach ($data as $index => $v_data) {
            $result['data'][] = [
                $no++,
                $v_data->kode_rule,
                $v_data->nama_rule,
                $v_data->nama_penyakit,
                '
                <div class="text-center">
                    <a href="' . base_url('Admin/RuleDetail/index?rule_id=' . $v_data->id_rule) . '" class="btn btn-info">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="' . base_url('Admin/Rule/edit/' . $v_data->id_rule) . '" class="btn btn-warning btn-edit" data-id_rule="' . $v_data->id_rule . '">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a href="' . base_url('Admin/Rule/delete/') . '" class="btn btn-danger btn-delete" data-id_rule="' . $v_data->id_rule . '">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
                '
            ];
        }
        echo json_encode($result);
    }
    public function validateKodeRule()
    {
        $check = TRUE;
        $kode_rule = $this->input->post('kode_rule', true);
        if ($_POST['page'] == 'add') {
            $check_Rule = $this->db->get_where('rule', ['kode_rule' => $kode_rule])->num_rows();
            if ($check_Rule > 0) {
                $this->form_validation->set_message('validateKodeRule', 'Kode sudah digunakan');
                $check = FALSE;
            }
        } else {
            $id_rule = $this->input->post('id_rule', true);
            $check_Rule = $this->db->get_where('rule', ['kode_rule' => $kode_rule, 'id_rule <> ' => $id_rule])->num_rows();
            if ($check_Rule > 0) {
                $this->form_validation->set_message('validateKodeRule', 'Kode sudah digunakan');
                $check = FALSE;
            }
        }
        return $check;
    }
    public function kodeRule()
    {
        $kodeRule =  kodeRule();
        echo json_encode($kodeRule);
    }
}
