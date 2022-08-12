<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penyakit extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        if (!$this->session->has_userdata('id_users')) {
            show_404();
        }
        $this->load->model(['Penyakit/Penyakit_model']);
    }
    public function index()
    {
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Penyakit', 'Admin/Penyakit');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Penyakit';
        $this->template->admin('admin/penyakit/main', $data);
    }

    public function process()
    {
        $this->form_validation->set_rules('kode_penyakit', 'Kode Penyakit', 'required|callback_validateKodePenyakit');
        $this->form_validation->set_rules('nama_penyakit', 'Nama Penyakit', 'required');
        $this->form_validation->set_rules('gambar_penyakit', 'Gambar', 'callback_validateGambar');
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
                $gambar_penyakit = $this->uploadGambar();
                $data_Penyakit = [
                    'kode_penyakit' => kodePenyakit(),
                    'nama_penyakit' => htmlspecialchars($this->input->post('nama_penyakit', true)),
                    'gambar_penyakit' => $gambar_penyakit
                ];
                $insert = $this->Penyakit_model->insert($data_Penyakit);
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
                $id = htmlspecialchars($this->input->post('id_penyakit', true));
                $data = [
                    'status' => 'error',
                    'output' => $this->form_validation->error_array()
                ];
                echo json_encode($data);
            } else {
                $id = htmlspecialchars($this->input->post('id_penyakit', true));
                $gambar_penyakit = $this->uploadGambar($id);
                $data_Penyakit = [
                    'kode_penyakit' =>  htmlspecialchars($this->input->post('kode_penyakit', true)),
                    'nama_penyakit' => htmlspecialchars($this->input->post('nama_penyakit', true)),
                    'gambar_penyakit' => $gambar_penyakit
                ];
                $update = $this->Penyakit_model->update($data_Penyakit, $id);
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
        $get = $this->Penyakit_model->get($id)->row();
        $data = [
            'row' => $get,
        ];
        echo json_encode($data);
    }

    public function delete()
    {
        $id_penyakit = htmlspecialchars($this->input->post('id_penyakit', true));
        $delete = $this->Penyakit_model->delete($id_penyakit);
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
        $data = $this->Penyakit_model->get()->result();
        $result = [];
        $no = 1;
        if ($data == null) {
            $result['data'] = [];
        }
        foreach ($data as $index => $v_data) {
            $gambarPenyakit = base_url('public/image/penyakit/' . $v_data->gambar_penyakit);
            $result['data'][] = [
                $no++,
                $v_data->kode_penyakit,
                $v_data->nama_penyakit,
                '<img src="' . $gambarPenyakit . '" class="img-thumbnail rounded" width="150px;"></img>',
                '
                <div class="text-center">
                    <a href="' . base_url('Admin/Penyakit/edit/' . $v_data->id_penyakit) . '" class="btn btn-warning btn-edit" data-id_penyakit="' . $v_data->id_penyakit . '">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <a href="' . base_url('Admin/Penyakit/delete/') . '" class="btn btn-danger btn-delete" data-id_penyakit="' . $v_data->id_penyakit . '">
                        <i class="fas fa-trash"></i>
                    </a>
                </div>
                '
            ];
        }
        echo json_encode($result);
    }
    public function validateKodePenyakit()
    {
        $check = TRUE;
        $kode_penyakit = $this->input->post('kode_penyakit', true);
        if ($_POST['page'] == 'add') {
            $check_penyakit = $this->db->get_where('penyakit', ['kode_penyakit' => $kode_penyakit])->num_rows();
            if ($check_penyakit > 0) {
                $this->form_validation->set_message('validateKodePenyakit', 'Kode sudah digunakan');
                $check = FALSE;
            }
        } else {
            $id_penyakit = $this->input->post('id_penyakit', true);
            $check_penyakit = $this->db->get_where('penyakit', ['kode_penyakit' => $kode_penyakit, 'id_penyakit <> ' => $id_penyakit])->num_rows();
            if ($check_penyakit > 0) {
                $this->form_validation->set_message('validateKodePenyakit', 'Kode sudah digunakan');
                $check = FALSE;
            }
        }
        return $check;
    }
    public function kodePenyakit()
    {
        $kodePenyakit =  kodePenyakit();
        echo json_encode($kodePenyakit);
    }

    public function validateGambar()
    {
        $check = TRUE;
        if (($_FILES['gambar_penyakit']) && $_FILES['gambar_penyakit']['size'] != 0) {
            $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG");
            $extension = pathinfo($_FILES["gambar_penyakit"]["name"], PATHINFO_EXTENSION);

            if (filesize($_FILES['gambar_penyakit']['tmp_name']) > 1000000) {
                $this->form_validation->set_message('validateGambar', 'Gambar melebihi 1 MB');
                $check = FALSE;
            }
            if (!in_array($extension, $allowedExts)) {
                $this->form_validation->set_message('validateGambar', "Tidak didukung format {$extension}");
                $check = FALSE;
            }
        }
        return $check;
    }
    private function uploadGambar($id_penyakit = '')
    {
        $gambar = $_FILES["gambar_penyakit"]['name'];
        if ($gambar != null) {
            $this->removeImage($id_penyakit);
            $config['upload_path'] = './public/image/penyakit';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['overwrite'] = true;
            $new_name = rand(1000, 100000) . time() . $_FILES["gambar_penyakit"]['name'];
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('gambar_penyakit')) {
                echo $this->upload->display_errors();
            } else {
                $gambar = $this->upload->data();
                //Compress Image
                $config['image_library'] = 'gd2';
                $config['source_image'] = './public/image/penyakit/' . $gambar['file_name'];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = FALSE;
                $config['quality'] = '50%';
                $config['new_image'] = './public/image/penyakit/' . $gambar['file_name'];
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                return $gambar['file_name'];
            }
        } else {
            if ($id_penyakit != null) {
                $Users = $this->Penyakit_model->get($id_penyakit)->row();
                if ($Users->gambar_penyakit != 'default.png') {
                    return $Users->gambar_penyakit;
                }
            }
            return 'default.png';
        }
    }

    private function removeImage($id)
    {
        if ($id != null) {
            $img = $this->Penyakit_model->get($id)->row();
            if ($img->gambar_penyakit != 'default.png') {
                $filename = explode('.', $img->gambar_penyakit)[0];
                return array_map('unlink', glob(FCPATH . "public/image/penyakit/" . $filename . '.*'));
            }
        }
    }
}
