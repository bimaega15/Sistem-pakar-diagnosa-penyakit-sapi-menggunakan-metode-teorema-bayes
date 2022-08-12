<?php
function check_already_login()
{
    $ci = &get_instance();
    if (get_cookie('cookie') != null) {
        $cookie = get_cookie('cookie');
        $users = $ci->db->get_where("users", ['cookie' => $cookie])->row();
        $ci->session->set_userdata('id_users', $users->id_users);
    }
    $session = $ci->session->userdata('id_users');
    if (!empty($session)) {
        $profile = check_profile();
        if ($profile->level == 'users') {
            $ci->session->set_flashdata('error', 'Anda sudah login sebagai users');
            return redirect(base_url('Front/Account/Riwayat'));
        }
        redirect(base_url('Admin/Home'));
    }
}
function check_already_login_users()
{
    $ci = &get_instance();
    if (get_cookie('cookie') != null) {
        $cookie = get_cookie('cookie');
        $users = $ci->db->get_where("users", ['cookie' => $cookie])->row();
        $ci->session->set_userdata('id_users', $users->id_users);
    }
    $session = $ci->session->userdata('id_users');
    if (!empty($session)) {
        $profile = check_profile();
        if ($profile->level == 'admin') {
            $ci->session->set_flashdata('error', 'Anda sudah login sebagai admin');
            return redirect(base_url('Admin/Home'));
        }
        redirect(base_url('Front/Account/Riwayat'));
    }
}
function check_not_login_users()
{
    $ci = &get_instance();
    if (!$ci->session->has_userdata('id_users')) {
        redirect(base_url('Front/Login'));
    }
    if ($ci->session->has_userdata('id_users')) {
        $profile = check_profile();
        if ($profile->level == 'admin') {
            $ci->session->set_flashdata('error', 'Anda sudah login sebagai admin');
            return redirect(base_url('Admin/Home'));
        }
    }
}
function tanggal_indo($tanggal = null)
{
    if ($tanggal != null) {
        $explode = explode('-', $tanggal);
        $data_tanggal = [];
        $data_tanggal[0] = $explode[2];
        $data_tanggal[1] = $explode[1];
        $data_tanggal[2] = $explode[0];
        $output = implode('-', $data_tanggal);
        return $output;
    }
}
function check_not_login()
{
    $ci = &get_instance();
    if (!$ci->session->has_userdata('id_users')) {
        redirect(base_url('Login'));
    }
    if ($ci->session->has_userdata('id_users')) {
        $profile = check_profile();
        if ($profile->level == 'users') {
            $ci->session->set_flashdata('error', 'Anda sudah login sebagai users');
            return redirect(base_url('Front/Account/Riwayat'));
        }
    }
}

function numeric($number)
{
    $output = number_format($number, 0, '.', ',');
    return $output;
}
function check_profile()
{
    $ci = &get_instance();
    $ci->load->model('Users/Users_model');
    $session_id = $ci->session->userdata('id_users');
    $rows = $ci->Users_model->get($session_id)->row();
    return $rows;
}

function wordTextSlider($text, $limit)
{
    if (strlen($text) > $limit) {
        $word = strip_tags($text);
        $word = mb_substr($word, 0, $limit) . " ... ";
    } else {
        $word = $text;
    }
    return ($word);
}

function konfigurasi()
{
    $ci = &get_instance();
    $get = $ci->db->get('konfigurasi')->row();
    return $get;
}

function kodeGejala()
{
    $ci = &get_instance();
    $ci->load->model('Gejala/Gejala_model');

    $kodeGejala = $ci->Gejala_model->maxKode()->row();
    $kodeGejala = $kodeGejala->max_kode_gejala;

    $urutan = (int) substr($kodeGejala, 1, 2);
    $urutan++;

    $huruf = "G";
    $kodeGejala = $huruf . sprintf("%02s", $urutan);
    return $kodeGejala;
}

function kodePenyakit()
{
    $ci = &get_instance();
    $ci->load->model('Penyakit/Penyakit_model');

    $kodePenyakit = $ci->Penyakit_model->maxKode()->row();
    $kodePenyakit = $kodePenyakit->max_kode_penyakit;

    $urutan = (int) substr($kodePenyakit, 1, 2);
    $urutan++;

    $huruf = "P";
    $kodePenyakit = $huruf . sprintf("%02s", $urutan);
    return $kodePenyakit;
}

function kodeSolusi()
{
    $ci = &get_instance();
    $ci->load->model('Solusi/Solusi_model');

    $kodeSolusi = $ci->Solusi_model->maxKode()->row();
    $kodeSolusi = $kodeSolusi->max_kode_solusi;

    $urutan = (int) substr($kodeSolusi, 1, 2);
    $urutan++;

    $huruf = "S";
    $kodeSolusi = $huruf . sprintf("%02s", $urutan);
    return $kodeSolusi;
}
function kodeRule()
{
    $ci = &get_instance();
    $ci->load->model('Rule/Rule_model');

    $kodeRule = $ci->Rule_model->maxKode()->row();
    $kodeRule = $kodeRule->max_kode_rule;

    $urutan = (int) substr($kodeRule, 1, 2);
    $urutan++;

    $huruf = "R";
    $kodeRule = $huruf . sprintf("%02s", $urutan);
    return $kodeRule;
}

function check_gejala_id($gejala_id = null)
{
    $ci = &get_instance();
    $ci->load->model('Gejala/Gejala_model');

    $getGejala = $ci->Gejala_model->get($gejala_id)->row();
    return $getGejala;
}

function check_penyakit_id($penyakit_id = null)
{
    $ci = &get_instance();
    $ci->load->model('Penyakit/Penyakit_model');

    $getpenyakit = $ci->Penyakit_model->get($penyakit_id)->row();
    return $getpenyakit;
}
function check_solusi($solusi_id = null, $penyakit_id = null)
{
    $ci = &get_instance();
    $ci->load->model(['Penyakit/Penyakit_model', 'Solusi/Solusi_model']);

    $getpenyakit = $ci->Solusi_model->get(null, $penyakit_id);
    return $getpenyakit;
}

function check_rule_id($rule_id = null)
{
    $ci = &get_instance();
    $ci->load->model('Rule/Rule_model');

    $rule = $ci->Rule_model->get($rule_id)->row();
    return $rule;
}

function checkedPutGejala($gejala_id = null, $put_diagnosa = [])
{
    if (!empty($put_diagnosa)) {
        if (in_array($gejala_id, $put_diagnosa)) {
            return 'checked';
        }
    }
    return '';
}
