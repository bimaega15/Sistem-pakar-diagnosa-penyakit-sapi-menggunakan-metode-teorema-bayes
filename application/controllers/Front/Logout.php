<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logout extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Users/Users_model', 'Profile/Profile_model']);
    }

    public function index()
    {
        delete_cookie('cookie');
        session_destroy();
        return redirect(base_url('Front/Login'));
    }
}
