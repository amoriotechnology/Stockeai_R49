<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Onlinehelp extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->auth->check_admin_auth();
        $this->load->model('Users');
        $this->load->model('Web_settings');
    }  

    public function index() {

        $data['superadmin_logo'] = $this->Users->superadmin_logo();

        $data['retrieve_admin_data']=$this->Web_settings->retrieve_admin_data();

        $this->load->view('onlinehelp/home', $data);
    }
}
