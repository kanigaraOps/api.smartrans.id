<?php
//'tes' => number_format(200 / 100, 2, ",", "."),
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Berkah extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        
        $this->load->helper("url");
        $this->load->database();
        $this->load->model('Notification_model', 'notification'); 
        $this->load->model('Driver_model');
        $this->load->model('Berkah_model', 'berkah');
        $this->load->model('Dashboard_model','dashboard');
        $this->load->model('wallet_model', 'wallet'); 
        $this->load->model('Flip_model', 'flip'); 
        date_default_timezone_set('Asia/Jakarta');
    }

    function index_get()
    {
        $this->response("Api for Smartrans!", 200);
    }
    

    
    public function generateidunik($kodeunik)
    {
        $cari = $this->berkah->getidunik($kodeunik);
        if ($cari) {
            return false;
        } else {
            return $kodeunik;
        }
        // return $cari;
    }

    
    public function idunik()
    {
        $x = 1;
        do {
          $kodeunik = 'P'.rand(1000000000,9999999999); 
          $generate = $this->generateidunik($kodeunik);
        //   echo "cek $x :  $kodeunik - $generate<br>";
          $x++;
        } while (!$generate || $x == 15);
        
        // $kodeunik = rand(3,999);
        // $generate = $this->generatekodeunik('679');
        
        if($generate !== ""){
            return $generate;
            //echo $generate;
        }
    }
    
    public function xxx_get()
    {
        $this->berkah->xxx();  
    }
    
    function searchcustomer($nama, $phone, $email)
    {
        
        $datapel = $this->berkah->getidpelbyphone($phone);
        $dataid = $this->berkah->getidlast(); 
        $iduser = "";

        if($datapel == TRUE){
            $iduser = $datapel['id'];
            // echo "old".$iduser;
            return $iduser;
        }
        else {
            $iduser = $this->idunik();
            $data_signup = array(
                    'id'                        => $iduser,
                    'fullnama'                  => $nama,
                    'email'                     => $email,
                    'no_telepon'                => '62'.$phone,
                    'countrycode'               => '+62',
                    'phone'                     => $phone,
                    'password'                  => '7c222fb2927d828af22f592134e8932480637c0d',
                    'created_on '               => date('Y-m-d H:i:s'),
                    'tgl_lahir '                => date('Y-m-d'), 
                    'rating_pelanggan'          => '0',
                    'status'                    => '1',
                    'token'                     => '12345',
                    'fotopelanggan'             => 'smart.jpg'
                );
            $user = $this->berkah->signup($data_signup);
        }
        
        return $iduser;
    }
    
    function addtransaction_post()
    {
        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);

        
        $nama = $decoded_data->customer->nama;
        $phone = $decoded_data->customer->phone;
        $email = $decoded_data->customer->email;
        $iduser = $this->searchcustomer($nama, $phone, $email);
        
        $notes = $decoded_data->transaction->notes;
        if($decoded_data->transaction->now_later=='2'){
            $pickuptime = $decoded_data->transaction->waktu_pickup;
        } else {
            $pickuptime =  date('Y-m-d H:i:s');
        }
        
        $aplikator = "SMARTRANS WEB";
        $kode = 'WEB'.rand(1000000000,9999999999);
        
        // if($decoded_data->transaction->order_fitur=='20'){
        //     $jenisx=20;
        //     if($rute == "Tanpa Supir"){
        //     $jenisx=37;
        //     }
        //     $types=3; 
        //     $notes = $aplikator ." RentCar ".$rute." / ".$typecar." / ".$flight." / ".$phone." / ".$pickuptime." / ".$durasi." Hari / ". $addons;
        // } 
        if($decoded_data->transaction->order_fitur=='34' && $decoded_data->transaction->now_later=='2'){  
            $jenisx=34;
            $types=1;
            $notes = $aplikator." / 0".$phone." / ".$pickuptime." / ".$email." / ".$notes;
        } else if($decoded_data->transaction->order_fitur=='34' && $decoded_data->transaction->now_later=='1'){  
            $jenisx=38;
            $types=1;
            $notes = $aplikator." / 0".$phone." / ".$pickuptime." / ".$email." / ".$notes;
        }
        
        $data_req = array(
            'id_order'                      => $kode,
            'id_pelanggan'                  => $iduser,
            'id_driver'                     => NULL,
            'order_fitur'                   => $jenisx,
            'start_latitude'                => $decoded_data->rute->location[0]->lat,
            'start_longitude'               => $decoded_data->rute->location[0]->lng,
            'end_latitude'                  => $decoded_data->rute->location[1]->lat,
            'end_longitude'                 => $decoded_data->rute->location[1]->lng,
            'jarak'                         => $decoded_data->rute->distance,
            'estimasi_time'                 => $decoded_data->rute->traffictime." mins", 
            'reporting'                     => 0,
            'harga'                         => $decoded_data->price->subtotal * 100,
            'kredit_promo'                  => $decoded_data->price->discount * 100,
            'biaya_akhir'                   => $decoded_data->price->total * 100,
            'now_later'                     => $decoded_data->transaction->now_later,
            'bridging'                      => 2,
            'waktu_order'                   => $pickuptime,
            'alamat_asal'                   => $decoded_data->rute->location[0]->address,
            'alamat_tujuan'                 => $decoded_data->rute->location[1]->address,
            'notes'                         => $notes,
            'region_code'                   => 900,
            'aplikator'                     => $aplikator,
            'fleet'                         => 'Smartrans',
            'staff'                         => NULL,
            'pakai_wallet'                  => $decoded_data->transaction->pakai_wallet,
            'payment'                       => $decoded_data->transaction->payment,
        );
        

    
        $data_rep = array(
            'sub_total_before_discount'             => $decoded_data->price->subtotal * 100,
            'base_fare'                             => $decoded_data->price->basefare * 100,
            'distance'                              => $decoded_data->price->distance * 100,
            'surge_amount'                          => $decoded_data->price->surge * 100,
            'discount_amount'                       => $decoded_data->price->discount * 100,
            'tax_amount'                            => $decoded_data->price->tax * 100,
            'customer_paid_amount'                  => $decoded_data->price->total * 100,
            'created_at'                            => date('Y-m-d H:i:s')
        );
        
        if($decoded_data->transaction->payment == 'CASH'){
            $data_rep['online_payment'] = 0;
            $data_rep['cash_payment'] = $decoded_data->price->total * 100;
        } else {
            $data_rep['online_payment'] = $decoded_data->price->total * 100;
            $data_rep['cash_payment'] = 0;
        }
    
        if($iduser != ""){
            $trans = $this->berkah->insert_transaksi_web($data_req, $data_rep);
        }
        
        
        $this->response($trans, 200);
        // $kode = $decoded_data->kode;
        // $jenis = $decoded_data->jenis;
        // $aplikator = $decoded_data->aplikator;
        // $fleet = $decoded_data->fleet;
        // $nama = $decoded_data->nama;
        // $phone = $decoded_data->phone;
        // $email = $decoded_data->email;
        // $region = $decoded_data->region;
        // $pickuptime = $decoded_data->pickuptime;
        // $typecar = $decoded_data->typecar;
        // $qty = $decoded_data->qty;
        // $flight = $decoded_data->flight;
        // $rute = $decoded_data->rute;
        // $reporting = $decoded_data->reporting;
        // $nd = $decoded_data->nd;
        // $jemput = $decoded_data->jemput;
        // $tujuan = $decoded_data->tujuan;
        // $addons = $decoded_data->addons;
        // $durasi = $decoded_data->durasi;
        // $region_code = $decoded_data->region_code;
        // $datapel = $this->berkah->getidpelbyphone($phone);
        // $dataid = $this->berkah->getidlast(); 
        // $iduser = "";

        // if($datapel == TRUE){
        //     $iduser = $datapel['id'];
        //     echo "old".$iduser;
        // }
        // else {
        //     $iduser = $this->idunik();
        // }
        
        // // if($jenis=='RENTCAR'){
        // //     $jenisx=20;
        // //     if($rute == "Tanpa Supir"){
        // //     $jenisx=37;
        // //     }
        // //     $types=3; 
        // //     $notes = $aplikator ." RentCar ".$rute." / ".$typecar." / ".$flight." / ".$phone." / ".$pickuptime." / ".$durasi." Hari / ". $addons;
        // // } else if($jenis=='SHUTTLE' || $jenis=='SHUTTLE INSTANT BOOKING'){  
        // //     $jenisx=34;
        // //     if($jenis=='SHUTTLE INSTANT BOOKING'){
        // //     $jenisx=38;
        // //     }
        // //     $types=1;
        // //     $notes = $aplikator." / ".$typecar." / ".$flight." / ".$phone." / ".$pickuptime." / ".$email;
        // // }  
        
        // if($email == ''){
        //     $email = $phone.'@gmail.com';
        // }

        //     if($datapel==TRUE){
        //         $iduser = $datapel['id'];
        //     } else {
        //         // $iduser = 'P'.rand(1000000000,9999999999); 
        //         $data_signup = array(
        //             'id'                        => $iduser,
        //             'fullnama'                  => $nama,
        //             'email'                     => $email,
        //             'no_telepon'                => '62'.$phone,
        //             'countrycode'               => '+62',
        //             'phone'                     => $phone,
        //             'password'                  => '7c222fb2927d828af22f592134e8932480637c0d',
        //             'created_on '               => date('Y-m-d H:i:s'),
        //             'tgl_lahir '                => date('Y-m-d'), 
        //             'rating_pelanggan'          => '0',
        //             'status'                    => '1',
        //             'token'                     => '12345',
        //             'fotopelanggan'             => 'smart.jpg'
        //         );
        //         $user = $this->berkah->signup($data_signup);
        //         echo "new".$iduser;
        //         // var_dump($user);
        //         if(!$user){
        //             $iduser = "";
        //         }
        //     }
            
            
            // $nd = $nd * 100;
            // for ($x = 0; $x < $qty; $x++) {
            // $datapel = $this->berkah->getidpelbyphone($phone);
            // $dataid = $this->berkah->getidlast();           


            //     $data_req = array(
            //         'id'                            => $dataid['id'] + 1,
            //         'id_order'                      => $kode."-".$x,
            //         'id_pelanggan'                  => $iduser,
            //         'id_driver'                     => NULL,
            //         'order_fitur'                   => $jenisx,
            //         'start_latitude'                => '-6.123493',
            //         'start_longitude'               => '106.652051',
            //         'end_latitude'                  => '-6.123493',
            //         'end_longitude'                 => '106.672051',
            //         'jarak'                         => 0,
            //         'reporting'                     => $reporting * 100,
            //         'harga'                         => $nd,
            //         'now_later'                     => 2,
            //         'bridging'                      => 2,
            //         'estimasi_time'                 => '0 mins',
            //         'waktu_order'                   => $pickuptime,
            //         'alamat_asal'                   => $jemput,
            //         'alamat_tujuan'                 => $tujuan,
            //         'notes'                         => $notes,
            //         'biaya_akhir'                   => $nd,
            //         'kredit_promo'                  => 0,
            //         'region_code'                   => $region_code,
            //         'aplikator'                     => $aplikator,
            //         'fleet'                         => $fleet,
            //         'staff'                         => $this->session->userdata('id'),
            //         'pakai_wallet'                  => 1
            //     );
            
            //     $data_rep = array(
            //         'sub_total_before_discount'             => $nd,
            //         'online_payment'                        => $nd,
            //         'customer_paid_amount'                  => $nd,
            //         'created_at'                            => date('Y-m-d H:i:s')
            //     );
            
            //     if($iduser != ""){
            //         $trans = $this->berkah->insert_transaksi_berkah($data_req, $data_rep);
            //     }
    
            // } 
        //redirect('https://smartrans.conftech.id/transactionltr/index');
        //header('location: https://api.smartrans.id/root/transactionltr/index');
    }
    
    function addberkah_post()
    {
        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);
        
        $kode = $decoded_data->kode;
        $jenis = $decoded_data->jenis;
        $aplikator = $decoded_data->aplikator;
        $fleet = $decoded_data->fleet;
        $nama = $decoded_data->nama;
        $phone = $decoded_data->phone;
        $email = $decoded_data->email;
        $region = $decoded_data->region;
        $pickuptime = $decoded_data->pickuptime;
        $typecar = $decoded_data->typecar;
        $qty = $decoded_data->qty;
        $flight = $decoded_data->flight;
        $rute = $decoded_data->rute;
        $reporting = $decoded_data->reporting;
        $nd = $decoded_data->nd;
        $jemput = $decoded_data->jemput;
        $tujuan = $decoded_data->tujuan;
        $addons = $decoded_data->addons;
        $durasi = $decoded_data->durasi;
        $region_code = $decoded_data->region_code;
        $datapel = $this->berkah->getidpelbyphone($phone);
        $dataid = $this->berkah->getidlast(); 
        $iduser = "";

        if($datapel == TRUE){
            $iduser = $datapel['id'];
            echo "old".$iduser;
        }
        else {
            $iduser = $this->idunik();
            
        }
        
        if($jenis=='RENTCAR'){
            $jenisx=20;
            if($rute == "Tanpa Supir"){
            $jenisx=37;
            }
            $types=3; 
            $notes = $aplikator ." RentCar ".$rute." / ".$typecar." / ".$flight." / ".$phone." / ".$pickuptime." / ".$durasi." Hari / ". $addons;
        } else if($jenis=='SHUTTLE' || $jenis=='SHUTTLE INSTANT BOOKING'){  
            $jenisx=34;
            if($jenis=='SHUTTLE INSTANT BOOKING'){
            $jenisx=38;
            }
            $types=1;
            $notes = $aplikator." / ".$typecar." / ".$flight." / ".$phone." / ".$pickuptime." / ".$email;
        }  
        
        if($email == ''){
            $email = $phone.'@gmail.com';
        }

            if($datapel==TRUE){
                $iduser = $datapel['id'];
            } else {
                // $iduser = 'P'.rand(1000000000,9999999999); 
                $data_signup = array(
                    'id'                        => $iduser,
                    'fullnama'                  => $nama,
                    'email'                     => $email,
                    'no_telepon'                => '62'.$phone,
                    'countrycode'               => '+62',
                    'phone'                     => $phone,
                    'password'                  => '7c222fb2927d828af22f592134e8932480637c0d',
                    'created_on '               => date('Y-m-d H:i:s'),
                    'tgl_lahir '                => date('Y-m-d'), 
                    'rating_pelanggan'          => '0',
                    'status'                    => '1',
                    'token'                     => '12345',
                    'fotopelanggan'             => 'smart.jpg'
                );
                $user = $this->berkah->signup($data_signup);
                // echo "new".$iduser;
                // var_dump($user);
                if(!$user){
                    $iduser = "";
                }
            }
            
            
            $nd = $nd * 100;
            for ($x = 0; $x < $qty; $x++) {
            $datapel = $this->berkah->getidpelbyphone($phone);
            $dataid = $this->berkah->getidlast();           


                $data_req = array(
                    'id'                            => $dataid['id'] + 1,
                    'id_order'                      => $kode."-".$x,
                    'id_pelanggan'                  => $iduser,
                    'id_driver'                     => NULL,
                    'order_fitur'                   => $jenisx,
                    'start_latitude'                => '-6.123493',
                    'start_longitude'               => '106.652051',
                    'end_latitude'                  => '-6.123493',
                    'end_longitude'                 => '106.672051',
                    'jarak'                         => 0,
                    'reporting'                     => $reporting * 100,
                    'harga'                         => $nd,
                    'now_later'                     => 2,
                    'bridging'                      => 2,
                    'estimasi_time'                 => '0 mins',
                    'waktu_order'                   => $pickuptime,
                    'alamat_asal'                   => $jemput,
                    'alamat_tujuan'                 => $tujuan,
                    'notes'                         => $notes,
                    'biaya_akhir'                   => $nd,
                    'kredit_promo'                  => 0,
                    'region_code'                   => $region_code,
                    'aplikator'                     => $aplikator,
                    'fleet'                         => $fleet,
                    'staff'                         => $this->session->userdata('id'),
                    'pakai_wallet'                  => 1
                );
            
                $data_rep = array(
                    'sub_total_before_discount'             => $nd,
                    'online_payment'                        => $nd,
                    'customer_paid_amount'                  => $nd,
                    'created_at'                            => date('Y-m-d H:i:s')
                );
            
            if($iduser != ""){
                $trans = $this->berkah->insert_transaksi_berkah($data_req, $data_rep);
            }

        } 
        
        //redirect('https://smartrans.conftech.id/transactionltr/index');
        //header('location: https://api.smartrans.id/root/transactionltr/index');
    }
    
    
    
    public function publish_get($id)
    {
        $this->berkah->publish($id);
        $this->session->set_flashdata('hapus', 'Transaction Has Been Publishsssss ');
        
        $trans = $this->berkah->gettransactionbyid($id);
        
        $data = array(
                    'id'                    => $trans['id'],
                    'aplikator'             => $trans['aplikator'],
                    'fleet'                 => $trans['fleet'],
                    'region_code'           => $trans['region_code']
                );
                
        $datadriver = $this->berkah->get_driver_regid_fleet($trans['region_code'], $trans['fleet']);
                    
                    
            $biayand= number_format($trans['harga']/100,2,".",".");
            $data = array(
                "alamat_asal"=> $trans['alamat_asal'],
                "alamat_tujuan"=> $trans['alamat_tujuan'],
                "estimasi_time"=> '0 mins',
                "distance"=> 0,
                "biaya"=> "Rp ".$biayand,
                "harga"=> $trans['harga'],
                "id_transaksi"=> $trans['id'],
                "layanan"=> $trans['aplikator'],
                "layanandesc"=> $trans['notes'],
                "order_fitur"=> 'T-CAR',
                "pakai_wallet"=> true,
                "bridging"=> 2, 
                "type"=> 1
            );
            
            $send = $this->berkah->send_notif_req_berkah_topic(keyfcm,$data, $trans['region_code']); 
            echo $trans['region_code'];
            
        // $q = count($datadriver);
        // $notif_user = array();
        //     for ($i = 0; $i < $q; $i++) {                
        //     $notif_user[]= $datadriver[$i]['reg_id'];
            
        //     $send = $this->berkah->send_notif_req_berkah(keyfcm,$data,$datadriver[$i]['reg_id']); 
            
        //     //$this->response($send, 200);
        //     }
            
        //     $this->response($notif_user, 200);
            
        //     $sendfcm= array(
        //         'key' => keyfcm,
        //         'data' => $data,
        //         'registration_ids' => array_values($notif_user)
        //       );
 
            //$this->berkah->send_notif_req_berkah($sendfcm);   
            //$send = $this->berkah->send_notif_req_berkah(keyfcm,$data,array_values($notif_user));  
            //redirect('transactionltr/index');
    }
    
    function addmdcgk_post()
    {
        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);
        $cash_payment = 0;
        $online_payment = 0;
        
        if($decoded_data->dataorder->payment == "TUNAI"){
            $cash_payment=$decoded_data->harga->customerpaid * 100;
        } else {
            $online_payment=$decoded_data->harga->customerpaid * 100;
        }

        $data_rep = array(
            'sub_total_before_discount'=>$decoded_data->harga->stbdawal * 100,
            'base_fare'=>$decoded_data->harga->bf * 100,
            'distance'=>$decoded_data->harga->distance * 100,
            'surge_amount'=>$decoded_data->harga->surge * 100,
            'extra_charges'=>$decoded_data->harga->xc * 100,
            'tawar'=>$decoded_data->harga->upping * 100,
            'discount_amount'=>$decoded_data->harga->disc * 100,
            'toll_amount'=>$decoded_data->harga->tol * 100,
            'cash_payment'=>$cash_payment,
            'online_payment'=>$online_payment,
            'customer_paid_amount'=>$decoded_data->harga->customerpaid * 100,
            'company_earning'=>$decoded_data->harga->companyearning * 100,
            'driver_earning'=>$decoded_data->harga->driverearning * 100,
            'amount_deducted_from_driver_wallet'=>$decoded_data->harga->driverdeduct * 100,
            'driver_total_payout_amount'=>$decoded_data->harga->driverpayout * 100,
            'created_at'                            => date('Y-m-d H:i:s')
        );

        $trans = $this->berkah->insert_transaksi_md($decoded_data->dataorder, $data_rep);

        $this->response($trans, 200);
        
    }
    
    function cqrgv_post(){
        $post = file_get_contents('php://input');
        $json = json_decode($post);
        
        $merchant_id = 1142;
        $merchant_key = "3ea5bd4dfa9f35ea3fc22ea2";
        
        $id= $json->id;
        $amount= $json->amount;
        
        $custom = $id;
        //$bussiness_id = 2211123;
        $bussiness_id = "00003711077";
        $amount = $amount;
        $indicator_tip = '';
        $tip = '';
        $store_label = 'smartdrivertopup';
        $terminal_label = 'smartrans';
        $expired_time = '2023-01-20 19:51:28';
        
        $signature = md5($merchant_id.(md5($custom.$merchant_key)));
        
        $data = array(
            'merchant_id' => $merchant_id,
            'custom' => $custom,
            'bussiness_id' => $bussiness_id,
            'amount' => $amount,
            'indicator_tip' => $indicator_tip,
            'tip' => $tip,
            'store_label' => $store_label,
            'terminal_label' => $terminal_label,
            'expired_duration' => 1,
            'expired_time' => '',
            'signature' => $signature
        );
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://www.gudangvoucher.com/payment_channel/gv_connect/qris/create_qr',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_POSTFIELDS => json_encode($data),
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        echo $response;
    }
    
    function cqrx_post() 
    {
    $data = file_get_contents("php://input");
    $decoded_data = json_decode($data);
    
    $merchant_id = "1142";
    $merchant_key = "3ea5bd4dfa9f35ea3fc22ea2";
    
    $id = $decoded_data->id;
    $amount= $decoded_data->amount;
    
    $custom = $id;
    $bussiness_id = "00003711077";
    $amount = $amount;
    $indicator_tip = '';
    $tip = 0;
    $store_label = 'strasad';
    $terminal_label = 'smartrans';
    $expired_time = '2023-01-27 13:51:28';
    
    // $signature = md5($merchant_id.(md5($custom.$merchant_key)));
    
    // $data = array("merchant_id"=>$merchant_id,
    //     "custom"=>$custom,
    //     "bussiness_id"=>$bussiness_id,
    //     "amount"=>$amount,
    //     "indicator_tip"=>$indicator_tip,
    //     "tip"=>$tip,
    //     "store_label"=>$store_label,
    //     "terminal_label"=>$terminal_label,
    //     "expired_time"=>"",
    //     "signature"=>$signature
    // );
    
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
    var_dump($response); 
    
    $qrisdata = array( 
        'custom'=> $response->responddata->custom,
        'reference_label'=> $response->responddata->reference_label,
        'merchant_id'=> $response->responddata->merchant_id,
        'bussiness_id'=> $response->responddata->bussiness_id,
        'bussiness_name'=> $response->responddata->bussiness_name,
        'amount'=> $response->responddata->amount,
        'expired_time'=> $response->responddata->expired_time,
        'data_qr'=> $response->responddata->data_qr
    );
    
    $db = $this->berkah->resqrisdinamis($qrisdata); 

    // $message = array(
    //     'code' => '200',
    //     'message' => 'success',
    //     'data' =>[],
    //     'amount' =>$response->responddata->amount, 
    //     'data_qr' =>$response->responddata->data_qr,
    //     'status' =>'0',
    // );
                    
    // $this->response($message, 200);
    return $db;
    }
    
}
