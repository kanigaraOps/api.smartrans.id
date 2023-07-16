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
        $tgljemput = html_escape($this->input->post('tgljemput', TRUE));
        $bulan = html_escape($this->input->post('bulan', TRUE));
        if (date("m") >=  (int)$bulan) {
            $blnjemput = date("Y")."-".$bulan; 
        }else{
            $blnjemput = (date("Y")-1)."-".$bulan; 
        } 
        if(empty($bulan)){
            $tgljemput = date("Y-m-d");
        }else if($bulan=='ALL'){
            $tgljemput = $tgljemput;
        }else if(!empty($bulan) ){
            $tgljemput = $blnjemput;
        }

        $data['currency'] = $this->app->getappbyid();
        $data['transaksi_jurnal'] = $this->dashboard->getAlltransaksijurnalnow($tgljemput); 
        $data['fitur'] = $this->dashboard->getAllfitur();
        $data['saldo'] = $this->dashboard->getallsaldo();

        $this->load->view('includes/header');
        $this->load->view('trxjurnal/index', $data);
        $this->load->view('includes/footer'); 
    }

    public function later()
    {
        $tgljemput = html_escape($this->input->post('tgljemput', TRUE));
        $bulan = html_escape($this->input->post('bulan', TRUE));
        $blnjemput = date("Y")."-".$bulan; 
        if(empty($bulan)){
            $tgljemput = date("Y-m-d");
        }else if($bulan=='ALL'){
            $tgljemput = $tgljemput;
        }else if(!empty($bulan) ){
            $tgljemput = $blnjemput;
        }

        $data['currency'] = $this->app->getappbyid();
        $data['transaksi_jurnal'] = $this->dashboard->getAlltransaksijurnallater($tgljemput); 
        $data['fitur'] = $this->dashboard->getAllfitur();
        $data['saldo'] = $this->dashboard->getallsaldo();

        $this->load->view('includes/header');
        $this->load->view('trxjurnal/later', $data);
        $this->load->view('includes/footer'); 
    }
}
