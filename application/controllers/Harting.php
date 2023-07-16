<?php
defined('BASEPATH') or exit('No direct script access allowed');

class harting extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
      
        if ($this->session->userdata('user_name') == NULL && $this->session->userdata('password') == NULL) {
            redirect(base_url() . "login");
        }
        $this->load->model('Appsettings_model', 'app');
        $this->load->model('Dashboard_model', 'dashboard');
        $this->load->model('Pelanggan_model', 'pelanggan');
        $this->load->model('Notification_model', 'notification');     
        $this->load->model('Driver_model', 'driver');    
        $this->load->model('wallet_model', 'wallet');
        $this->load->model('users_model', 'user');
        $this->load->library('form_validation');
    }
    public function index()
    {
        $data['transaksi'] = $this->dashboard->getHarting();
        $data['terminal'] = $this->dashboard->getterminaldata();
        $this->load->view('includes/header');
        $this->load->view('harting/index', $data);
        $this->load->view('includes/footer');
    }

    public function add_harting()
    {
        $insert["nama"] = html_escape($this->input->post('nama', TRUE));
        $insert["nominal"] = html_escape($this->input->post('nominal', TRUE));
        $insert["jam"] = html_escape($this->input->post('jam', TRUE));
        $insert["fitur"] = html_escape($this->input->post('fitur', TRUE));
        $insert["terminal"] = html_escape($this->input->post('terminal', TRUE));
        
        $this->form_validation->set_rules('nd', 'nd', 'trim|prep_for_form');

        if ($this->form_validation->run() == TRUE) {
           $trans = $this->dashboard->insert_harting($insert);
        redirect('harting/index');
        }
        
    }
    
    public function manual($terminal, $idharting, $status, $id)
    {
        $terminal = str_replace("Terminal", "Terminal ", $terminal);
        $this->dashboard->manual_harting($terminal, $idharting, $status, $id);
        redirect('https://smartrans.id/docroot/berkah/services/hartingnew.php', 'refresh');
    }    
    
    public function delete($id)
    {
        $this->dashboard->delete_harting($id);
        redirect('harting/index');
    } 
    
}
