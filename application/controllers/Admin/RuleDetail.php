<?php

use SebastianBergmann\Environment\Console;

defined('BASEPATH') or exit('No direct script access allowed');

class RuleDetail extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        if (!$this->session->has_userdata('id_users')) {
            show_404();
        }
        $this->load->model(['RuleDetail/RuleDetail_model', 'Gejala/Gejala_model']);
    }
    public function index()
    {
        $rule_id = $this->input->get('rule_id', true);
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Rule', 'Admin/Rule');
        $this->breadcrumbs->push('Rule Detail', 'Admin/RuleDetail?rule_id=' . $rule_id);
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Rule Detail';
        $data['rule'] = check_rule_id($rule_id);

        $this->template->admin('admin/ruledetail/main', $data);
    }

    public function add()
    {
        $rule_id = $this->input->get('rule_id', true);
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Rule', 'Admin/Rule');
        $this->breadcrumbs->push('Rule Detail', 'Admin/RuleDetail?rule_id=' . $rule_id);
        $this->breadcrumbs->push('Add Rule Detail', 'Admin/RuleDetail/add?rule_id=' . $rule_id);
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Add Rule Detail';
        $data['rule'] = check_rule_id($rule_id);
        $data['gejala'] = $this->Gejala_model->get()->result();
        $data['page'] = 'add';

        $this->template->admin('admin/ruledetail/form', $data);
    }


    public function process()
    {
        $putGejala = $this->session->userdata('put_gejala');
        $rule_id = $this->input->get('rule_id', true);
        if (empty($putGejala)) {
            $this->session->set_flashdata('error', 'Anda belum input beberapa gejala');
            return redirect(base_url('Admin/RuleDetail/add?rule_id=' . $rule_id));
        }

        if (($_GET['page']) == 'add') {
            $putGejala = $this->session->userdata('put_gejala');
            $rule_id = htmlspecialchars($this->input->get('rule_id', true));
            $this->RuleDetail_model->delete($rule_id);
            $gejala_id = $putGejala;
            foreach ($gejala_id as $key => $v_gejala) {
                $data_RuleDetail[] = [
                    'rule_id' => $rule_id,
                    'gejala_id' => $v_gejala,
                ];
            }

            $insert = $this->RuleDetail_model->insertMany($data_RuleDetail);
            if ($insert > 0) {
                $this->session->unset_userdata('put_gejala');
                $this->session->set_flashdata('success', 'Berhasil menambah ' . $insert . ' gejala');
                return redirect(base_url('Admin/RuleDetail?rule_id=' . $rule_id));
            } else {
                $this->session->set_flashdata('error', 'Gagal menambah ' . $insert . ' gejala');
                return redirect(base_url('Admin/RuleDetail?rule_id=' . $rule_id));
            }
        } else if (($_GET['page']) == 'edit') {
            $putGejala = $this->session->userdata('put_gejala');
            $gejala_id = $putGejala;
            $rule_id = htmlspecialchars($this->input->get('rule_id', true));
            $this->RuleDetail_model->delete($rule_id);

            foreach ($gejala_id as $key => $v_gejala) {
                $data_RuleDetail[] = [
                    'rule_id' => $rule_id,
                    'gejala_id' => $v_gejala,
                ];
            }

            $insert = $this->RuleDetail_model->insertMany($data_RuleDetail);

            $update = $insert;
            if ($update > 0) {
                $this->session->unset_userdata('put_gejala');
                $this->session->set_flashdata('success', 'Berhasil mengubah ' . $update . ' gejala');
                return redirect(base_url('Admin/RuleDetail?rule_id=' . $rule_id));
            } else {
                $this->session->set_flashdata('error', 'Gagal mengubah ' . $update . ' gejala');
                return redirect(base_url('Admin/RuleDetail?rule_id=' . $rule_id));
            }
        }
    }
    public function edit($id)
    {
        $rule_id = $id;
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Rule Detail', 'Admin/RuleDetail');
        $this->breadcrumbs->push('Edit Rule Detail', 'Admin/RuleDetail/edit/' . $rule_id);
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Edit Rule Detail';
        $result = $this->RuleDetail_model->get(null, $rule_id)->result();
        $gejala_id = [];
        foreach ($result as $key => $v_result) {
            $gejala_id[] = $v_result->gejala_id;
        }

        if (!($this->session->has_userdata('put_gejala'))) {
            $this->session->set_userdata('put_gejala', $gejala_id);
        } else {
            if (empty($this->session->userdata('put_gejala'))) {
                $this->session->unset_userdata('put_gejala');
            }
        }
        $data['rule'] = check_rule_id($id);
        $data['page'] = 'edit';
        $data['gejala'] = $this->Gejala_model->get()->result();
        $this->template->admin('admin/ruledetail/form', $data);
    }

    public function delete()
    {
        $rule_id = $this->input->get('rule_id', true);
        $delete = $this->RuleDetail_model->delete($rule_id);
        if ($delete) {
            $data = [
                'status' => "success",
                'msg' => 'Success hapus data ' . $delete . ' Gejala'
            ];
            echo json_encode($data);
        } else {
            $data = [
                'status' => "error",
                'msg' => 'Gagal hapus data ' . $delete . ' Gejala'
            ];
            echo json_encode($data);
        }
    }

    public function deleteOne()
    {
        $id_rule_detail = $this->input->get('id_rule_detail', true);
        $delete = $this->RuleDetail_model->deleteOne($id_rule_detail);
        if ($delete) {
            $data = [
                'status' => "success",
                'msg' => 'Success hapus data ' . $delete . ' Gejala'
            ];
            echo json_encode($data);
        } else {
            $data = [
                'status' => "error",
                'msg' => 'Gagal hapus data ' . $delete . ' Gejala'
            ];
            echo json_encode($data);
        }
    }

    public function loadData()
    {
        $rule_id = htmlspecialchars($this->input->get('rule_id', true));
        $data = $this->RuleDetail_model->get(null, $rule_id)->result();
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
                $v_data->nama_penyakit,
                '
                <a href="' . base_url('Admin/Rule/deleteOne') . '" class="btn btn-danger btn-delete-one" data-id_rule_detail="' . $v_data->id_rule_detail . '">
                    <i class="fas fa-trash"></i>
                </a>
                '
            ];
        }
        echo json_encode($result);
    }
    public function getGejala()
    {
        $gejala_id = htmlspecialchars($this->input->post('gejala_id', true));
        // unset($_SESSION['put_gejala']);
        $arrGejala = [];
        if ($gejala_id != '') {
            if ($this->session->has_userdata('put_gejala')) {
                $getGejala = $this->session->userdata('put_gejala');
                if (in_array($gejala_id, $getGejala)) {
                    $dataGejala = [
                        'status' => 'error',
                        'output' => 'Gejala sudah diinput'
                    ];
                } else {
                    array_push($getGejala, $gejala_id);
                    $this->session->set_userdata('put_gejala', $getGejala);

                    $putGejala = $this->session->userdata('put_gejala');
                    $dataGejala = [
                        'status' => 'success',
                        'output' => $putGejala
                    ];
                }
            } else {
                $arrGejala[0] = $gejala_id;
                $this->session->set_userdata('put_gejala', $arrGejala);

                $putGejala = $this->session->userdata('put_gejala');
                $dataGejala = [
                    'status' => 'success',
                    'output' => $putGejala
                ];
            }
        } else {
            $dataGejala = [
                'status' => 'error',
                'output' => 'Gejala tidak boleh kosong'
            ];
        }
        echo json_encode($dataGejala);
    }
    public function loadPutData()
    {
        $getGejala = $this->session->userdata('put_gejala');

        $data = [];
        if (!empty($getGejala)) {
            $data = $this->Gejala_model->get(null, $getGejala)->result();
        }
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
                    <a href="' . base_url('Admin/RuleDetail/deletePutGejala/') . '" class="btn btn-danger btn-delete-put-gejala" data-id_gejala="' . $v_data->id_gejala . '">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
                '
            ];
        }
        echo json_encode($result);
    }
    public function deletePutGejala()
    {
        $gejala_id = $this->input->post('gejala_id', true);
        $putGejala = $this->session->userdata('put_gejala');
        $search = array_search($gejala_id, $putGejala);
        unset($_SESSION['put_gejala'][$search]);

        $putGejala = $this->session->userdata('put_gejala');
        $dataGejala = [
            'status' => 'success',
            'output' => 'Berhasil hapus gejala',
            'result' => $putGejala
        ];
        echo json_encode($dataGejala);
    }
}
