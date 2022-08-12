<?php
class Template
{
    protected $ci;
    public function __construct()
    {
        $this->ci = &get_instance();
    }
    public function home($template, $data = null)
    {
        $data['content'] = $this->ci->load->view($template, $data, true);
        $this->ci->load->view('home', $data);
    }
    public function login($template, $data = null)
    {
        $data['content'] = $this->ci->load->view($template, $data, true);
        $this->ci->load->view('login', $data);
    }
    public function admin($template, $data = null)
    {
        $data['sidebar'] = $this->ci->load->view('template/admin/partials/sidebar', $data, true);
        $data['header'] = $this->ci->load->view('template/admin/partials/header', $data, true);
        $data['footer'] = $this->ci->load->view('template/admin/partials/footer', null, true);
        $data['content'] = $this->ci->load->view($template, $data, true);
        $data['right_sidebar'] = $this->ci->load->view('template/admin/partials/right_sidebar', null, true);

        $this->ci->load->view('template/admin/main', $data);
    }

    public function front($template, $data = null)
    {
        $konfigurasi = konfigurasi();
        $merge = array_merge([
            'konfigurasi' => $konfigurasi
        ], $data);
        $data = $merge;
        $data['topbar'] =  $this->ci->load->view('template/front/partial/topbar', $data, true);
        $data['navbar'] =  $this->ci->load->view('template/front/partial/navbar', $data, true);
        $data['footer'] =  $this->ci->load->view('template/front/partial/footer', $data, true);
        $data['content'] =  $this->ci->load->view($template, $data, true);

        $this->ci->load->view('template/front/main', $data);
    }
}
