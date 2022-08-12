<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logout extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Users/Users_model');
    }
    public function index()
    {
        $this->session->sess_destroy();
        delete_cookie('cookie');
        return redirect(base_url('Login'));
    }
}
