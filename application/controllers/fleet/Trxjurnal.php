<?php
defined('BASEPATH') or exit('No direct script access allowed');

class trxjurnal extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
      
        if ($this->session->userdata('user_name') == NULL && $this->session->userdata('password') == NULL) {
            redirect(base_url() . "login");
        }
        $this->load->model('Appsettings_model', 'app');
        $this->load->model('Dashboard_model', 'dashboard');
        // $this->load->library('form_validation');
    }

    public function index()
    {

        $data['currency'] = $this->app->getappbyid();
        $data['transaksi_jurnal'] = $this->dashboard->getAlltransaksijurnal(); 
        $data['fitur'] = $this->dashboard->getAllfitur();
        $data['saldo'] = $this->dashboard->getallsaldo();

        $this->load->view('includes/header');
        $this->load->view('trxjurnal/index', $data);
        $this->load->view('includes/footer'); 
    }
}
