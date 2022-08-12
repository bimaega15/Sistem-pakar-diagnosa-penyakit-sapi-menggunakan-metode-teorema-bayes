<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Users/Users_model', 'Profile/Profile_model']);
        check_not_login_users();
    }

    public function index()
    {
        $data['title'] = 'Form Profile';
        $data['profile'] = check_profile();
        $this->template->front('front/profile/main', $data);
    }
    public function process()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|callback_validateUsername');
        $this->form_validation->set_rules('password', 'Password', 'callback_validatePassword');

        $this->form_validation->set_rules('nama_profile', 'Nama', 'required');
        $this->form_validation->set_rules('alamat_profile', 'Alamat', 'required');
        $this->form_validation->set_rules('nohp_profile', 'No. HP', 'required');
        $this->form_validation->set_rules('jenis_kelamin_profile', 'Jenis kelamin', 'required');
        $this->form_validation->set_rules('gambar_profile', 'Gambar', 'callback_validateGambar');
        $this->form_validation->set_message('required', '{field} Wajib diisi');
        $this->form_validation->set_error_delimiters('<small class="text-danger">', '</small><br>');

        if ($this->form_validation->run() == false) {
            return $this->index();
        } else {
            $password = htmlspecialchars($this->input->post('password', true));
            if ($password == null) {
                $password = htmlspecialchars($this->input->post('password_old', true));
            } else {
                $password = md5($password);
            }

            $data_Users = [
                'username' => htmlspecialchars($this->input->post('username', true)),
                'password' => $password,
                'level' => 'users',
            ];
            $id_users = htmlspecialchars($this->input->post('id_users', true));
            $updateUsers = $this->Users_model->update($data_Users, $id_users);

            $id_profile = htmlspecialchars($this->input->post('id_profile', true));
            $gambarProfile = $this->uploadGambar($id_users);
            $dataProfile = [
                'nama_profile' => htmlspecialchars($this->input->post('nama_profile', true)),
                'alamat_profile' => htmlspecialchars($this->input->post('alamat_profile', true)),
                'nohp_profile' => htmlspecialchars($this->input->post('nohp_profile', true)),
                'jenis_kelamin_profile' => htmlspecialchars($this->input->post('jenis_kelamin_profile', true)),
                'gambar_profile' => $gambarProfile,
                'users_id' => $id_users,
            ];
            $updateProfile = $this->Profile_model->update($dataProfile, $id_profile);
            if ($updateProfile > 0 || $updateUsers > 0) {
                $this->session->set_flashdata('success', 'Berhasil update profile');
                return redirect(base_url('Front/Account/Profile'));
            } else {
                $this->session->set_flashdata('error', 'Gagal update');
                return redirect(base_url('Front/Account/Profile'));
            }
        }
    }

    public function validateGambar()
    {
        $check = TRUE;
        if (($_FILES['gambar_profile']) && $_FILES['gambar_profile']['size'] != 0) {
            $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG");
            $extension = pathinfo($_FILES["gambar_profile"]["name"], PATHINFO_EXTENSION);

            if (filesize($_FILES['gambar_profile']['tmp_name']) > 1000000) {
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

    public function validatePassword()
    {
        $check = TRUE;
        $password = $this->input->post('password', true);
        $confirm_password = $this->input->post('confirm_password', true);

        if ($password != null && $confirm_password != null) {
            if ($password != $confirm_password) {
                $this->form_validation->set_message('validatePassword', 'Password tidak sama dengan confirm password');
                $check = FALSE;
            }
        }

        return $check;
    }

    public function validateUsername()
    {
        $check = TRUE;
        $username = $this->input->post('username', true);
        $id_users = $this->input->post('id_users', true);
        $check_username = $this->db->get_where('Users', ['username' => $username, 'id_users <> ' => $id_users])->num_rows();
        if ($check_username > 0) {
            $this->form_validation->set_message('validateUsername', 'Username sudah digunakan');
            $check = FALSE;
        }

        return $check;
    }

    private function uploadGambar($id_users = '')
    {
        $gambar = $_FILES["gambar_profile"]['name'];
        if ($gambar != null) {
            $this->removeImage($id_users);
            $config['upload_path'] = './public/image/users';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['overwrite'] = true;
            $new_name = rand(1000, 100000) . time() . $_FILES["gambar_profile"]['name'];
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('gambar_profile')) {
                echo $this->upload->display_errors();
            } else {
                $gambar = $this->upload->data();
                //Compress Image
                $config['image_library'] = 'gd2';
                $config['source_image'] = './public/image/users/' . $gambar['file_name'];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = FALSE;
                $config['quality'] = '50%';
                $config['new_image'] = './public/image/users/' . $gambar['file_name'];
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                return $gambar['file_name'];
            }
        } else {
            if ($id_users != null) {
                $Users = $this->Users_model->get($id_users)->row();
                if ($Users->gambar_profile != 'default.png') {
                    return $Users->gambar_profile;
                }
            }
            return 'default.png';
        }
    }

    private function removeImage($id)
    {
        if ($id != null) {
            $img = $this->Users_model->get($id)->row();
            if ($img->gambar_profile != 'default.png') {
                $filename = explode('.', $img->gambar_profile)[0];
                return array_map('unlink', glob(FCPATH . "public/image/users/" . $filename . '.*'));
            }
        }
    }
}
