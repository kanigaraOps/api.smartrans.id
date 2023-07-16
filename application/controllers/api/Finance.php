<?php
//'tes' => number_format(200 / 100, 2, ",", "."),
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Finance extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        
        $this->load->helper("url");
        $this->load->database();
        $this->load->model('Notification_model', 'notification'); 
        $this->load->model('Finance_model', 'finance');
        $this->load->model('wallet_model', 'wallet');
        $this->load->model('Pelanggan_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    function index_get()
    {
        $saldo=1000;
         $this->wallet->send_notif("Topup", "Topup Berhasil Saldo anda Rp. " .$saldo , "e_x69LcYRUio9xtT1w06kj:APA91bEa51K92REVtcRRhZ4awfuIy6HHrxQXgJiUOQUCzM0eDeaCQrdWmoNPpK8ptMwe1sQyITtpNzAkn73aqoUI3eKZSzD4pkr6zUpeEx5o6TdKLXGF2LXhhzBKt4Q_Mp2EKB3tmESB");
        $this->response("Api for Smartrans!", 200);
    }
    
    function notifikasi_post(){
        $post = file_get_contents('php://input');
        $json = json_decode($post);
        if (isset($json->amount_final)) {
            $json->final_amount=$json->amount_final;
              unset($json->amount_final);
        }
         if (isset($json->transaction_date)) {
            $json->datetime=$json->transaction_date;
             unset($json->transaction_date);
        };
        
        //Code Naef
        /*$wallet = $this->finance->cekwallet($json->amount);
        if(isset($wallet->id_user)){
        $saldo = $this->wallet->getsaldo($wallet->id_user);
        $saldoberhasil = ($saldo["saldo"]/100+$json->amount);
        $this->wallet->send_notif("Topup", "Topup Berhasil Saldo anda Rp. " .$saldoberhasil , $this->wallet->getregid($wallet->id_user)["reg_id"]);
        }
        if(isset($saldo)){
        $this->wallet->ubahsaldotopupqris($wallet->id_user, $saldo["saldo"]+($json->amount*100));
        $this->Pelanggan_model->updateWallet($wallet->id,array( 
            'id_gv' =>  $json->invoice_no,
            'saldo_awal' => $saldo["saldo"],
            'saldo_akhir' =>$saldo["saldo"]+($json->amount*100),
            'status' => '1',
            'aprovel' => 'system_topup'
        ));
        }
        if(isset($wallet->id))$json->id_wallet =$wallet->id;
        
        $this->finance->createNotification($json);
        $this->response( "Success!!", 200 ); */
        
        //Code JRy
            $respon = $this->finance->gv_notification($json);
            if($respon){
            $this->wallet->send_notif("QRIS Smratrans", "Topup QRIS Berhasil sebesar Rp. ".$respon['jumlah'].", Saldo anda Rp. " .$respon['saldoakhir'] , $respon['reg_id']);
            }
            $this->response($respon, 200);
            
        // if($json->bussiness_id == "099000003738148"){
        //     $respon = $this->finance->gv_notification($json);
        //     if($respon){
        //     $this->wallet->send_notif("QRIS Smratrans", "Topup QRIS Berhasil sebesar Rp. ".$respon['jumlah'].", Saldo anda Rp. " .$respon['saldoakhir'] , $respon['reg_id']);
        //     }
        //     $this->response($respon, 200);
        // } else {
        //     $respon = "UnAuthorized";
        //     $this->response($respon, 401);
        // }
    }
    
    function notifcekmutasi_post(){
        $post = file_get_contents('php://input');
        $json = json_decode($post);

        if (json_last_error() !== JSON_ERROR_NONE) {
            exit('Invalid JSON');
        }
        
        $service_name = $json->content->service_name;
        $service_code = $json->content->service_code;
        $account_number = $json->content->account_number;
        $account_name = $json->content->account_name;
        
        
        
        if ($json->action === 'payment_report') {
            foreach ($json->content->data as $data) {
                // Waktu transaksi dalam format unix timestamp
                $time = $data->unix_timestamp;
        
                // Tipe transaksi : credit / debit
                $type = $data->type;
        
                // Jumlah (2 desimal) : 50000.00
                $amount = $data->amount;
        
                // Berita transfer
                $description = $data->description;
        
                // Saldo rekening (2 desimal) : 1500000.00
                $balance = $data->balance;
                
                $datacallback = array(
                    'time'                          => gmdate("Y-m-d H:i:s", $time),
                    'type'                          => $type,
                    'amount'                        => str_replace(".","",$amount) /100,
                    'description'                   => $description,
                    'balance'                       => $balance,
                    'service_code'                  => $service_code,
                    'account_number'                => $account_number 
                );
                
                $insert = $this->finance->createcekmutasi($datacallback);
            }
        }
        
        $this->response($datacallback, 200);
    }
    
    function notifqrisconftech_post(){
        $post = file_get_contents('php://input');
        $json = json_decode($post);

        if (json_last_error() !== JSON_ERROR_NONE) {
            exit('Invalid JSON');
        }
        
            // $service_name = $json->content->service_name;
            // $service_code = $json->content->service_code;
            // $issuer_name = $json->content->issuer_name;
            // $customer_name = $json->content->customer_name;
            // $store_label = $json->content->store_label;
            // $terminal_label = $json->content->terminal_label;
            // $invoice_no = $json->content->invoice_no;
            // $time = $json->content->time;
            // $amount = $json->content->account_name;
        
        $datacallback = array(
            'invoice_no' => $json->invoice_no,
            'service_name' => $json->service_name,
            'service_code' => $json->service_code,
            'issuer_name' => $json->issuer_name,
            'customer_name' => $json->customer_name,
            'store_label' => $json->store_label,
            'terminal_label' => $json->terminal_label,
            'time' => $json->time,
            'amount' => $json->amount,
            'mdr' => $json->mdr,
            'fee' => $json->fee
        );

        
        $insert = $this->finance->createqrisconftech($datacallback);
        
        $this->response($datacallback, 200);
    }
    
    function createqr_post(){
        $post = file_get_contents('php://input');
        $json = json_decode($post);
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://38.47.180.198/api.php',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_POSTFIELDS =>  'amount='.$json->amount.'&id='.$json->id,
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
          ),
        ));
        
        $response = json_decode(curl_exec($curl));
        
        curl_close($curl);
        $res=$response->responddata->data_qr;
        
        if($json->inter == "1"){
            $re =$this->finance->updateqrinter($json->id,$res);
        }else{
             $re =$this->finance->updateqr($json->id,$res);
        }
        
        $this->response($re, 200);
    }
    
    function cqr_post() 
    {
    $post = file_get_contents('php://input');
    $json = json_decode($post);
    
    $merchant_id = "1142";
    $merchant_key = "3ea5bd4dfa9f35ea3fc22ea2";
    
    $id= $json->id;
    $amount= $json->amount;
    
    $custom = $id;
    $bussiness_id = "00003711077";
    $amount = $amount;
    $indicator_tip = '';
    $tip = 0;
    $store_label = 'strasad';
    $terminal_label = 'smartrans';
    $expired_time = '2023-01-27 13:51:28';
    
    $signature = md5($merchant_id.(md5($custom.$merchant_key)));
    $data = array("merchant_id"=>$merchant_id,
    "custom"=>$custom,
    "bussiness_id"=>$bussiness_id,
    "amount"=>$amount,
    "indicator_tip"=>$indicator_tip,
    "tip"=>$tip,
    "store_label"=>$store_label,
    "terminal_label"=>$terminal_label,
    "expired_time"=>"",
    "signature"=>$signature);
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://103.159.223.136/api.php',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_POSTFIELDS =>  'amount='.$amount.'&id='.$id,
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded'
      ),
    ));

    $response = json_decode(curl_exec($curl));

    curl_close($curl);
        return $response;
    }
}