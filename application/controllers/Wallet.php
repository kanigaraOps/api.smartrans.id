<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Wallet extends CI_Controller
{

    public function  __construct()
    {
        parent::__construct();
       
        if ($this->session->userdata('user_name') == NULL && $this->session->userdata('password') == NULL) {
            redirect(base_url() . "login");
        }
        // $this->load->library('form_validation');
        $this->load->model('wallet_model', 'wallet');
        $this->load->model('users_model', 'user');
        $this->load->model('dashboard_model', 'dashboard');
    }

    public function index()
    {
        $tgl = html_escape($this->input->post('tgl', TRUE));
        $bulan = html_escape($this->input->post('bulan', TRUE));
        
        if (date("m") >=  (int)$bulan) {
            $bln = date("Y")."-".$bulan; 
        }else{
            $bln = (date("Y")-1)."-".$bulan; 
        }
        
        if(empty($tgl) && $bulan=='ALL'){
            $tgl = date("Y-m-d");  
        }else if(!empty($tgl)){
            $tgl = $tgl;  
        }else if(!empty($bulan) ){
            $tgl = $bln;
        }else if(empty($tgl) || $bulan=='ALL'){
            $tgl = date("Y-m-d");  
        }
        

        $data['jumlahdiskon'] = $this->wallet->getjumlahdiskon();
        $data['orderplus'] = $this->wallet->gettotalorderplus();
        $data['ordermin'] = $this->wallet->gettotalordermin();
        $data['saldo'] = $this->wallet->getallsaldo();
        $data['currency'] = $this->user->getcurrency();
        $data['withdraw'] = $this->wallet->gettotalwithdrawtrx($tgl);
        $data['topup'] = $this->wallet->gettotaltopup($tgl);
        $data['wallet'] = $this->wallet->getwallet($tgl);
        $data['wallettrx'] = $this->wallet->getwalletxtrx($tgl);
        $data['mutasi'] = $this->wallet->getmutasi($tgl);
        $data['gvnotif'] = $this->wallet->getgvnotif($tgl);

        $this->load->view('includes/header');
        $this->load->view('wallet/index', $data);
        $this->load->view('includes/footer');
    }

    public function wconfirm($id, $id_user, $amount)
    {
        $name = $this->session->userdata('user_name');
        $token = $this->wallet->gettoken($id_user);
        $regid = $this->wallet->getregid($id_user);
        $tokenmerchant = $this->wallet->gettokenmerchant($id_user);

        if ($token == NULL and $tokenmerchant == NULL and $regid != NULL) {
            $topic = $regid['reg_id'];
        } else if ($regid == NULL and $tokenmerchant == NULL and $token != NULL) {
            $topic = $token['token'];
        } else if ($regid == NULL and $token == NULL and $tokenmerchant != NULL) {
            $topic = $tokenmerchant['token_merchant'];
        }

        $title = 'Withdraw Success';
        $message = 'Withdraw Has Been Confirmed';
        $saldo = $this->wallet->getsaldo($id_user);

        $this->wallet->ubahsaldo($id_user, $amount, $saldo);
        $this->wallet->ubahstatuswithdrawbyid($id,$name);
        $this->wallet->send_notif($title, $message, $topic);
        $this->session->set_flashdata('ubah', 'Withdraw Has Been Confirmed');
        redirect('wallet/index');
    }

    public function wconfirmtrx($id, $id_user, $amount)
    {
        $name = $this->session->userdata('user_name');
        $token = $this->wallet->gettoken($id_user);
        $regid = $this->wallet->getregid($id_user);
        $tokenmerchant = $this->wallet->gettokenmerchant($id_user);

        if ($token == NULL and $tokenmerchant == NULL and $regid != NULL) {
            $topic = $regid['reg_id'];
        } else if ($regid == NULL and $tokenmerchant == NULL and $token != NULL) {
            $topic = $token['token'];
        } else if ($regid == NULL and $token == NULL and $tokenmerchant != NULL) {
            $topic = $tokenmerchant['token_merchant'];
        }

        $title = 'Withdraw Success';
        $message = 'Withdraw Has Been Confirmed';
        $saldotrx = $this->wallet->getsaldotrx($id_user); //saldotrx
        $saldonew = $saldotrx['saldotrx'] - $amount;

        if($saldotrx['saldotrx'] < $amount ){ 
            $title = 'Withdraw Cancel';
            $message = 'Withdraw dibatalkan karena saldo tidak cukup..!!';
            $this->wallet->cancelstatuswithdrawbyidtrx($id);
            $this->wallet->send_notif($title, $message, $topic);
            redirect('wallet/index');
        } elseif($saldotrx['saldotrx'] >= $amount){
            $this->wallet->ubahsaldotrx($id_user, $amount, $saldotrx); //Ubah Saldo kurangi WD
            $this->wallet->ubahstatuswithdrawbyidtrx($id,$name);
            $this->wallet->send_notif($title, $message, $topic);
            $this->session->set_flashdata('ubah', 'Withdraw Driver Has Been Confirmed');
        redirect('wallet/index');
        } else {
        redirect('wallet/index'); 
        }
    }

    public function wcancel($id, $id_user)
    {
        $name = $this->session->userdata('user_name');
        $token = $this->wallet->gettoken($id_user);
        $regid = $this->wallet->getregid($id_user);
        $tokenmerchant = $this->wallet->gettokenmerchant($id_user);

        if ($token == NULL and $tokenmerchant == NULL and $regid != NULL) {
            $topic = $regid['reg_id'];
        } else if ($regid == NULL and $tokenmerchant == NULL and $token != NULL) {
            $topic = $token['token'];
        } else if ($regid == NULL and $token == NULL and $tokenmerchant != NULL) {
            $topic = $tokenmerchant['token_merchant'];
        }

        $title = 'Withdraw Cancel';
        $message = 'Withdraw Has Been Canceled';

        $this->wallet->cancelstatuswithdrawbyid($id, $name );
        $this->wallet->send_notif($title, $message, $topic);
        $this->session->set_flashdata('ubah', 'Withdraw Has Been Canceled');
        redirect('wallet/index');
    }

    public function wcanceltrx($id, $id_user)
    {
        $name = $this->session->userdata('user_name');
        $token = $this->wallet->gettoken($id_user);
        $regid = $this->wallet->getregid($id_user);
        $tokenmerchant = $this->wallet->gettokenmerchant($id_user);

        if ($token == NULL and $tokenmerchant == NULL and $regid != NULL) {
            $topic = $regid['reg_id'];
        } else if ($regid == NULL and $tokenmerchant == NULL and $token != NULL) {
            $topic = $token['token'];
        } else if ($regid == NULL and $token == NULL and $tokenmerchant != NULL) {
            $topic = $tokenmerchant['token_merchant'];
        }

        $title = 'Withdraw Cancel';
        $message = 'Withdraw Has Been Canceled';

        $this->wallet->cancelstatuswithdrawbyidtrx($id, $name );
        $this->wallet->send_notif($title, $message, $topic);
        $this->session->set_flashdata('ubah', 'Withdraw Has Been Canceled');
        redirect('wallet/index');
    }

    public function tconfirm($id, $id_user, $amount, $via)
    {
        $name = $this->session->userdata('user_name');
        $token = $this->wallet->gettoken($id_user);
        $regid = $this->wallet->getregid($id_user);
        $tokenmerchant = $this->wallet->gettokenmerchant($id_user);

        if ($token == NULL and $tokenmerchant == NULL and $regid != NULL) {
            $topic = $regid['reg_id'];
        } else if ($regid == NULL and $tokenmerchant == NULL and $token != NULL) {
            $topic = $token['token'];
        } else if ($regid == NULL and $token == NULL and $tokenmerchant != NULL) {
            $topic = $tokenmerchant['token_merchant'];
        }

        $title = 'Topup success';
        $message = 'We Have Confirmed Your Topup Rp. '.$amount;
        $saldo = $this->wallet->getsaldo($id_user);

        $log_kategory = 'FINANCE';
        $sesid = $this->session->userdata('id');
        $log_keterangan = "Confirm topup ".$id;
        $data_log = array(
            'id_admin' => $sesid,//$log_id_admin,
            'kategory' => $log_kategory,
            'keterangan' => $log_keterangan
        );
        $this->dashboard->log_history($data_log);
        $this->wallet->ubahsaldotopup($id_user, $amount, $saldo);
        $this->wallet->ubahstatuswithdrawbyid($id,$name, $via);
        $this->wallet->send_notif($title, $message, $topic);
        $this->session->set_flashdata('ubah', 'topup has been confirmed');
        redirect('wallet/index');
    }

    public function tcancel($id, $id_user)
    {
        $name = $this->session->userdata('user_name');
        $token = $this->wallet->gettoken($id_user);
        $regid = $this->wallet->getregid($id_user);
        $tokenmerchant = $this->wallet->gettokenmerchant($id_user);

        if ($token == NULL and $regid != NULL) {
            $topic = $regid['reg_id'];
        }

        if ($regid == NULL and $token != NULL) {
            $topic = $token['token'];
        }

        if ($regid == NULL and $token == NULL and $tokenmerchant != NULL) {
            $topic = $tokenmerchant['token_merchant'];
        }

        $title = 'Topup canceled';
        $message = 'Sorry, topup has been canceled';

        $this->wallet->cancelstatuswithdrawbyid($id,$name );
        $this->wallet->send_notif($title, $message, $topic);
        $this->session->set_flashdata('ubah', 'topup has been canceled');
        redirect('wallet/index');
    }

    public function tambahtopup()
    {
        $name = $this->session->userdata('user_name');
        $data['currency'] = $this->user->getcurrency();
        $data['saldo'] = $this->wallet->getallsaldouser();


        if ($_POST != NULL) {

            if ($this->input->post('type_user') == 'pelanggan') {
                $id_user = $this->input->post('id_pelanggan');
            } elseif ($this->input->post('type_user') == 'mitra') {
                $id_user = $this->input->post('id_mitra');
            } else {
                $id_user = $this->input->post('id_driver');
            }

            $saldo = html_escape($this->input->post('saldo', TRUE));
            $remove = array(".", ",");
            $add = array("", "");

            $data = [
                'id_user'                       => $id_user,
                'saldo'                         => str_replace($remove, $add, $saldo),
                'type_user'                     => $this->input->post('type_user'),
                'keterangan'                    => $this->input->post('keterangan')
            ];

            $log_kategory = 'FINANCE';
            $sesid = $this->session->userdata('id');
            $log_keterangan = "Manual topup ".$id_user." ".str_replace($remove, $add, $saldo) / 100;
            $data_log = array(
            'id_admin' => $sesid,//$log_id_admin,
            'kategory' => $log_kategory,
            'keterangan' => $log_keterangan
        );
        $this->dashboard->log_history($data_log);
            $this->wallet->updatesaldowallet($data,$name);
            $this->session->set_flashdata('ubah', 'Top Up Has Been Added');
            redirect('wallet');
        } else {
            $this->load->view('includes/header');
            $this->load->view('wallet/tambahtopup', $data);
            $this->load->view('includes/footer');
        }
    }

    public function tambahwithdraw()
    {
        $data['currency'] = $this->user->getcurrency();
        $data['saldo'] = $this->wallet->getallsaldouser();

        if ($_POST != NULL) {

            if ($this->input->post('type_user') == 'pelanggan') {
                $id_user = $this->input->post('id_pelanggan');
            } elseif ($this->input->post('type_user') == 'mitra') {
                $id_user = $this->input->post('id_mitra');
            } else {
                $id_user = $this->input->post('id_driver');
            }

            $saldo = html_escape($this->input->post('saldo', TRUE));
            $remove = array(".", ",");
            $add = array("", "");
            
            $data = [
                'id_user'                       => $id_user,
                'saldo'                         => str_replace($remove, $add, $saldo),
                'type_user'                     => $this->input->post('type_user')
            ];

            $data2 = [
                'bank'                          => $this->input->post('bank'),
                'nama_pemilik'                  => $this->input->post('nama_pemilik'),
                'rekening'                      => $this->input->post('rekening'),
            ];


            $this->wallet->updatesaldowalletwithdraw($data, $data2);
            $this->session->set_flashdata('ubah', 'Withdraw Has Been Added');
            redirect('wallet');

        } else {
            $this->load->view('includes/header');
            $this->load->view('wallet/tambahwithdraw', $data);
            $this->load->view('includes/footer');
        }
    }
}
