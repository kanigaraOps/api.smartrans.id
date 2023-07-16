<?php
//'tes' => number_format(200 / 100, 2, ",", "."),
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Flip extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        
        $this->load->helper("url");
        $this->load->model('Flip_model');
        $this->load->model('Wallet_model');
        $this->load->model('Driver_model');
        $this->load->model('Merchantapi_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    function index_get()
    {
        $this->response("Api for Smartrans!", 200);
    }

    function transaksi_post()
    {
        $data = isset($_POST['data']) ? $_POST['data'] : null;
        $token = isset($_POST['token']) ? $_POST['token'] : null;

        if($token === '$2y$13$ckBNoPxRQ4zSCKTTfo6YWOSy6V1rfjpbN7xeglMAfaLIUgCm6gXoS'){
            $obj = json_decode($data);
            $transaksicallback = array(
                'id' => null,
                'id_flip' => $obj->{'id'},
                'bank_code' => $obj->{'bank_code'},
                'account_number' => $obj->{'account_number'},
                'user_id' => $obj->{'user_id'},
                'amount' => $obj->{'amount'},                
                'timestamp' => $obj->{'timestamp'},   
                'recipient_name' => $obj->{'recipient_name'},
                'sender_bank' => $obj->{'sender_bank'},
                'remark' => $obj->{'remark'},
                'receipt' => $obj->{'receipt'},
                'time_served' => $obj->{'time_served'},
                'bundle_id' => $obj->{'bundle_id'},
                'company_id' => $obj->{'company_id'},
                'recipient_city' => $obj->{'recipient_city'},
                'created_from' => $obj->{'created_from'},
                'direction' => $obj->{'direction'},
                'sender' => $obj->{'sender'},
                'fee' => $obj->{'fee'},
                'status' => $obj->{'status'}
            );
            $cek_transaksicallback = $this->Flip_model->input_transaksi_callback($transaksicallback);
            

            if($obj->{'status'}== "DONE"){
                $detailwd = $this->Flip_model->detailwdflip($obj->{'remark'}, $obj->{'fee'}, $obj->{'time_served'});
                $title = 'Withdraw Anda Sukses';
                $message = 'Permintaan withdraw anda telah berhasil di transfer ke rek. tujuan.';
                $topic = $detailwd;
                $this->wallet->send_notif($title, $message, $topic);
            } else if($obj->{'status'}== "CANCELLED"){
                $detailwd = $this->Flip_model->refundsaldotrx($obj->{'remark'}, $obj->{'time_served'});
                $title = 'Withdraw Anda Gagal';
                $message = 'Permintaan withdraw anda GAGAL, pastikan data rekening yang dituju benar.';
                $topic = $detailwd;
                $this->wallet->send_notif($title, $message, $topic);
            }

        }

    }

    function rekening_post()
    {
        $data = isset($_POST['data']) ? $_POST['data'] : null;
        $token = isset($_POST['token']) ? $_POST['token'] : null;

        if($token === '$2y$13$ckBNoPxRQ4zSCKTTfo6YWOSy6V1rfjpbN7xeglMAfaLIUgCm6gXoS'){
            $obj = json_decode($data);
            $rekeningcallback = array(
                'bank_code' => $obj->{'bank_code'},
                'account_number '=> $obj->{'account_number'},
                'account_holder' => $obj->{'account_holder'},
                'status' => $obj->{'status'}
            );
            //var_dump($rekeningcallback);
            $cek_rekeningcallback = $this->Flip_model->input_rekening_callback($rekeningcallback);
        }
    }

}
