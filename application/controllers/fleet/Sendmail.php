<?php
defined('BASEPATH') or exit('No direct script access allowed');

class sendemail extends CI_Controller
{

    public function  __construct()
    {

        parent::__construct();
     
        if ($this->session->userdata('user_name') == NULL && $this->session->userdata('password') == NULL) {
            redirect(base_url() . "login");
        }
        $this->load->library('form_validation');
        $this->load->model('driver_model', 'driver');
        $this->load->model('users_model', 'user');
        $this->load->model('mitra_model', 'mitra');
        $this->load->model('appsettings_model', 'app');
        $this->load->model('email_model', 'email_model');
    }

    public function index()
    {
        $data['driver'] = $this->driver->getalldriver();
        $data['user'] = $this->user->getallusers();
        $data['mitra'] = $this->mitra->getallmitra();

        $this->load->view('includes/header');
        $this->load->view('sendemail/index', $data);
        $this->load->view('includes/footer');
    }

    public function send()
    {
        if (demo == TRUE) {
            $this->session->set_flashdata('demo', 'NOT ALLOWED FOR DEMO');
            redirect('sendemail/index');
        } else {
            $data['app'] = $this->app->getappbyid();

            $emailpelanggan = $this->input->post('emailpelanggan');
            $emaildriver = $this->input->post('emaildriver');
            $emailmitra = $this->input->post('emailmitra');
            $emailothers = $this->input->post('emailothers');
            $sendto = $this->input->post('sendto');

            if ($sendto == 'users') {
                $emailuser = $emailpelanggan;
            } elseif ($sendto == 'drivers') {
                $emailuser = $emaildriver;
            } elseif ($sendto == 'merchant') {
                $emailuser = $emailmitra;
            } else {
                $emailuser = $emailothers;
            }

            $emailuser = "jry.kairupan@gmail.com";
            $subject = "ok";//$this->input->post('subject');
            $emailmessage = "konten"; //$this->input->post('content');
            $host = "smtp.gmail.com";//$data['app']['smtp_host'];
            $port = "465";//$data['app']['smtp_port'];
            $username = "smartransindo@gmail.com";//$data['app']['smtp_username'];
            $password = "smartech123#";//$data['app']['smtp_password'];
            $from = "smartransindo@gmail.com";//$data['app']['smtp_from'];
            $appname = "sss"; $data['app']['app_name'];
            $secure = "ssl";//$data['app']['smtp_secure'];
            $address = "jry.kairupan@gmail.com";//$data['app']['app_address'];
            $linkgoogle = "smtp.gmail.com";//$data['app']['app_linkgoogle'];
            $web = "smartrans.id";//$data['app']['app_website'];

            $content = "asdasd";//$this->email_model->template2($subject, $emailmessage, $address, $appname, $linkgoogle, $web);
            $this->email_model->emailsend($subject, $emailuser, $content, $host, $port, $username, $password, $from, $appname, $secure);
            $this->session->set_flashdata('send', 'Email Has Been Sended');


            redirect('sendemail');
        }
    }
}
