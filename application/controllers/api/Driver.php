<?php
//'tes' => number_format(200 / 100, 2, ",", "."),
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Driver extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        
        $this->load->helper("url");
        $this->load->database();
        $this->load->model('Notification_model', 'notification'); 
        $this->load->model('Driver_model');
        $this->load->model('Pelanggan_model');
        $this->load->model('Dashboard_model');
        $this->load->model('wallet_model', 'wallet'); 
        $this->load->model('berkah_model', 'berkah');
        $this->load->model('Flip_model', 'flip'); 
        $this->load->model('Finance_model', 'finance');
        date_default_timezone_set('Asia/Jakarta');
    }

    function index_get()
    {
//         $result="";
        //  $all =$this->Driver_model->get_laporan_ap("2023-04-23");
//          foreach ($all as $value) {
//   $laporan_ap=$this->Driver_model->get_laporan_apid( "200248");
//             $ap= $this->Driver_model->send_post($laporan_ap);
// //             $result=$ap;
// // }
    
        $this->response("masuk", 200);
       
    }
    function sendnotif_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
         $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);
        $kredit_promo = $decoded_data->title;
        $message = $decoded_data->message;
        if($decoded_data->phone!=null||$decoded_data->phone!=""){
            $token=array($this->Pelanggan_model->gettokenpelbyphone($decoded_data->phone));
        }else{
        $long=$decoded_data->longitude;
        $lat=$decoded_data->latitude;
        $point = $lat . "," . $long;
        $area = $this->Pelanggan_model->getarea($point);
        $token = $this->Driver_model->get_driver_regid($area);
        }
        $result = $this->notification->send_notif_testing($title, $message, $token);
        $this->response($result, 200);
    }
    
    function addberkah_post()
    {
        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);
        $kode = $decoded_data->kode;
        $jenis = $decoded_data->jenis;
        $aplikator = $decoded_data->aplikator;
        $nama = $decoded_data->nama;
        $phone = $decoded_data->phone;
        $region = $decoded_data->region;
        $pickuptime = $decoded_data->pickuptime;
        $typecar = $decoded_data->typecar;
        $qty = $decoded_data->qty;
        $flight = $decoded_data->flight;
        $rute = $decoded_data->rute;
        $nd = $decoded_data->nd;
        $jemput = $decoded_data->jemput;
        $tujuan = $decoded_data->tujuan;
        $durasi = $decoded_data->durasi;
        $region_code = $decoded_data->region_code;
        $datapel = $this->Pelanggan_model->getidpelbyphone($phone);
            $dataid = $this->Dashboard_model->getidlast(); 
                        

            if($datapel==TRUE){
                $iduser = $datapel['id'];
            } else {
                $iduser = 'P'.rand(1000000000,9999999999); 
                $data_signup = array(
                    'id'                        => $iduser,
                    'fullnama'                  => $nama,
                    'email'                     => $phone.'@gmail.com',
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
                $user = $this->Pelanggan_model->signup($data_signup);
            }
            $nd = $nd * 100;
            for ($x = 0; $x < $qty; $x++) {
            $datapel = $this->Pelanggan_model->getidpelbyphone($phone);
            $dataid = $this->Dashboard_model->getidlast();             

            if($datapel==TRUE){
                $iduser = $datapel['id'];
            } else {
                $iduser = 'P'.rand(1000000000,9999999999); 
            }

            if($jenis=='RENTCAR'){
                $jenisx=20;
                $types=3; 
                $notes = $aplikator." / ".$typecar." / ".$flight." / ".$phone." / ".$pickuptime." / ".$durasi." Hari";
            } else if($jenis=='SHUTTLE'){  
                $jenisx=34;
                $types=1;
                $notes = $aplikator." / ".$typecar." / ".$flight." / ".$phone." / ".$pickuptime;
            }


            
            
           

            $data_req = array(
                'id'                            => $dataid['id'] + 1,
                'id_order'                      => $kode."-".$x,
                'id_pelanggan'                  => $iduser,
                'id_driver'                     => "D0",
                'order_fitur'                   => $jenisx,
                'start_latitude'                => '-6.123493',
                'start_longitude'               => '106.652051',
                'end_latitude'                  => '-6.123493',
                'end_longitude'                 => '106.672051',
                'jarak'                         => 0,
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
                'staff'                         => $this->session->userdata('id'),
                'pakai_wallet'                  => 1
            );
            $data_rep = array(
                'sub_total_before_discount'             => $nd,
                'online_payment'                        => $nd,
                'customer_paid_amount'                  => $nd,
                'created_at'                            => date('Y-m-d H:i:s')
            );
            $datadriver = $this->Driver_model->get_driver_regid($region_code);
            $biayand= number_format($nd/100,2,".",".");
             $data_notif = array(
                'id_pelanggan'                  => $iduser,
                'order_fitur'                   => $types,
                'jenis'                         => $jenis,
                'distance'                      => 0,
                'harga'                         => $nd,
                'estimasi_time'                 => '0 mins',
                'waktu_order'                   => $pickuptime,
                'aplikator'                     => $aplikator,
                'type_car'                      => $typecar,
                'alamat_asal'                   => $jemput,
                'alamat_tujuan'                 => $tujuan,
                'biaya'                         => number_format($nd/100,2,".","."),
                'kredit_promo'                  => 0,
                'pakai_wallet'                  => true,
                'reg_id'                        => $datadriver[$i]['reg_id'],
                'id_transaksi'                  => $dataid['id'] + 1,
                "bridging"=> 2, 
                "type"=> 1
            );
            $trans = $this->Pelanggan_model->insert_transaksi_berkah($data_req, $data_rep,$data_notif,$datadriver);

            if($trans){

            // $datadriver = $this->Driver_model->get_driver_regid($region_code);
            // $q = count($datadriver);
            // $notif_user = array();
            // for ($i = 0; $i < $q; $i++) {                

            

            
            
            
            // // $token= $data_notif['reg_id'];
            
            // $notif_user[]= $datadriver[$i]['reg_id'];
 
            // }
            // $biayand= number_format($nd/100,2,".",".");
            //  $data_notif = array(
            //     'id_pelanggan'                  => $iduser,
            //     'order_fitur'                   => $types,
            //     'jenis'                         => $jenis,
            //     'distance'                      => 0,
            //     'harga'                         => $biayand,
            //     'estimasi_time'                 => '0 mins',
            //     'waktu_order'                   => $pickuptime,
            //     'aplikator'                     => $aplikator,
            //     'type_car'                      => $typecar,
            //     'alamat_asal'                   => $jemput,
            //     'alamat_tujuan'                 => $tujuan,
            //     'biaya'                         => number_format($nd/100,2,".","."),
            //     'kredit_promo'                  => 0,
            //     'pakai_wallet'                  => true,
            //     'reg_id'                        => $datadriver[$i]['reg_id'],
            //     'id_transaksi'                  => $dataid['id'] + 1,
            //     "bridging"=> 2, 
            //     "type"=> 1
            // );
            // $this->notification->send_notif_req_berkah($data_notif,$datadriver);
            // $biayand= number_format($nd/100,2,".",".");
            // $data = array(
            //     "alamat_asal"=> $jemput,
            //     "alamat_tujuan"=> $tujuan,
            //     "estimasi_time"=> '0 mins',
            //     "distance"=> 0,
            //     "biaya"=> "Rp ".$biayand,
            //     "harga"=> $nd,
            //     "id_transaksi"=> $dataid['id'] + 1,
            //     "layanan"=> $typecar,
            //     "layanandesc"=> $pickuptime." ".$aplikator." ".$jenis,
            //     "order_fitur"=> $types,
            //     "pakai_wallet"=> true,
            //     "bridging"=> 2, 
            //     "type"=> 1
            // );
            // $sendfcm= array(
            //     'key' => keyfcm,
            //     'data' => $data,
            //     'registration_ids' => $datadriver
            //   );
            $message =  array(
                    "message" => "success",
                    "data" => $data_notif);
                $this->response($message, 200);
        }else{
            $this->response("Data Gagal Terkirim driver", 200);
        }

        } 
        $this->response("Data Gagal  driver", 200);
    }

    function privacy_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $app_settings = $this->Pelanggan_model->get_settings();

        $message = array(
            'code' => '200',
            'message' => 'found',
            'data' => $app_settings
        );
        $this->response($message, 200);
    }

    function job_post()
    {

        $job = $this->Driver_model->get_job();

        $message = array(
            'code' => '200',
            'message' => 'found',
            'data' => $job
        );
        $this->response($message, 200); 
    }

    function jobservices_post()
    {

        $jobservices = $this->Driver_model->get_job_services();

        $message = array(
            'code' => '200',
            'message' => 'found',
            'data' => $jobservices 
        );
        $this->response($message, 200);
    }

    function login_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);
        $reg_id = array(
            'reg_id' => $decoded_data->token
        );

        $condition = array(
            //'password' => sha1($decoded_data->password),
            'no_telepon' => $decoded_data->no_telepon,
            //'token' => $decoded_data->token
        );

        $check_banned = $this->Driver_model->check_banned($decoded_data->no_telepon);
        
        if ($check_banned) {
            $message = array(
                'message' => 'banned',
                'data' => []
            );
            $this->response($message, 200);
        } else {
            $cek_login = $this->Driver_model->get_data_pelanggan($condition);
            $message = array();

            if ($cek_login->num_rows() > 0) {
                $upd_regid = $this->Driver_model->edit_profile($reg_id, $decoded_data->no_telepon);
                $get_pelanggan = $this->Driver_model->get_data_pelanggan($condition);
                $this->Driver_model->edit_status_login($decoded_data->no_telepon);
                $message = array(
                    'code' => '200',
                    'message' => 'found',
                    'data' => $get_pelanggan->result()
                );
                $this->response($message, 200);
            } else {
                $message = array(
                    'code' => '404',
                    'message' => 'wrong phone or password cuk',
                    'data' => []
                );
                $this->response($message, 200);
            }
        }
    }

    function update_location_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);
        $data = array(
            'latitude' => $decoded_data->latitude,
            'longitude' => $decoded_data->longitude,
            'bearing' => $decoded_data->bearing,
            'id_driver' => $decoded_data->id_driver
        );
        $ins = $this->Driver_model->my_location($data);

        if ($ins) {
            $message = array(
                'message' => 'location updated',
                'data' => []
            );
            $this->response($message, 200);
        }
    }

    function home_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        $saldo = $this->Pelanggan_model->saldouser($dec_data->id);
        $app_settings = $this->Pelanggan_model->get_settings();
        $condition = array(
            'no_telepon' => $dec_data->no_telepon
        );
        $cek_login = $this->Driver_model->get_data_driver($condition);

        foreach ($app_settings as $item) {
            if ($cek_login->num_rows() > 0) {
                $message = array(
                    'code' => '200',
                    'message' => 'success',
                    'saldo' => $saldo->row('saldo'),
                    'currency' => $item['app_currency'],
                    'currency_text' => $item['app_currency_text'],
                    'app_aboutus' => $item['app_aboutus'],
                    'app_contact' => $item['app_contact'],
                    'app_website' => $item['app_website'],
                    'stripe_active' => $item['stripe_active'],
                    'paypal_key' => $item['paypal_key'],
                    'paypal_mode' => $item['paypal_mode'],
                    'paypal_active' => $item['paypal_active'],
                    'app_email' => $item['app_email']


                );
                $this->response($message, 200);
            } else {
                $message = array(
                    'code' => '201',
                    'message' => 'failed',
                    'data' => []
                );
                $this->response($message, 201);
            }
        }
    }

    function logout_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);
        $dataEdit = array(
            'status' => 5
        );

        $logout = $this->Driver_model->logout($dataEdit, $decoded_data->id);
        if ($logout) {
            $message = array(
                'message' => 'success',
                'data' => ''
            );
            $this->response($message, 200);
        } else {
            $message = array(
                'message' => 'fail',
                'data' => ''
            );
            $this->response($message, 200);
        }
    }

    function syncronizing_account_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        $saldo = $this->Pelanggan_model->saldouser($dec_data->id);
        $app_settings = $this->Pelanggan_model->get_settings();
        $getDataDriver = $this->Driver_model->get_data_driver_sync($dec_data->id);
        $condition = array(
            'no_telepon' => $dec_data->no_telepon
        );
        $cek_login = $this->Driver_model->get_data_pelanggan($condition);
        foreach ($app_settings as $item) {
            if ($cek_login->num_rows() > 0) {
                $payu = $this->Pelanggan_model->payusettings()->result();
                if ($getDataDriver['status_order']->num_rows() > 0) {
                    $stat = 0;
                    if ($getDataDriver['status_order']->row('status') == 3) {
                        $stat = 3;
                    } else if ($getDataDriver['status_order']->row('status') == 2) {
                        $stat = 2;
                    } else {
                        $stat = 1;
                    }

                    $getTrans = $this->Driver_model->change_status_driver($dec_data->id, $stat);
                    $message = array(
                        'message' => 'success',
                        'driver_status' => $stat,
                        'data_driver' => $getDataDriver['data_driver']->result(),
                        'data_transaksi' => $getDataDriver['status_order']->result(),
                        'absen' => $getDataDriver['data_driver']->row('absen'),
                        'pool' => $getDataDriver['data_driver']->row('pool'),
                        'saldo' => $saldo->row('saldo'),
                        'saldotrx' => $saldo->row('saldotrx'),
                        'currency' => $item['app_currency'],
                        'currency_text' => $item['app_currency_text'],
                        'app_aboutus' => $item['app_aboutus'],
                        'app_contact' => $item['app_contact'],
                        'app_website' => $item['app_website'],
                        'stripe_active' => $item['stripe_active'],
                        'paypal_key' => $item['paypal_key'],
                        'paypal_mode' => $item['paypal_mode'],
                        'paypal_active' => $item['paypal_active'],
                        'app_email' => $item['app_email'],
                        'payu' => $payu,
                        'smartkey' => $item['smartkey'],
                        'petakey' => $item['petakey'],
                    );
                    $this->response($message, 200);
                } else {
                    $this->Driver_model->change_status_driver($dec_data->id, $getDataDriver['data_driver']->row('status_config'));
                    $message = array(
                        'message' => 'success',
                        'driver_status' => $getDataDriver['data_driver']->row('status_config'),
                        'data_driver' => $getDataDriver['data_driver']->result(),
                        'data_transaksi' => [],
                        'absen' => $getDataDriver['data_driver']->row('absen'),
                        'pool' => $getDataDriver['data_driver']->row('pool'),
                        'saldo' => $saldo->row('saldo'),
                        'saldotrx' => $saldo->row('saldotrx'),
                        'currency' => $item['app_currency'],
                        'currency_text' => $item['app_currency_text'],
                        'app_aboutus' => $item['app_aboutus'],
                        'app_contact' => $item['app_contact'],
                        'app_website' => $item['app_website'],
                        'stripe_active' => $item['stripe_active'],
                        'paypal_key' => $item['paypal_key'],
                        'paypal_mode' => $item['paypal_mode'],
                        'paypal_active' => $item['paypal_active'],
                        'app_email' => $item['app_email'],
                        'payu' => $payu,
                        'smartkey' => $item['smartkey'],
                        'petakey' => $item['petakey'],
                    );
                    $this->response($message, 200);
                }
            } else {
                $message = array(
                    'code' => '201',
                    'message' => 'failed',
                    'data' => []
                );
                $this->response($message, 201);
            }
        }
    }

    function absen_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $absen = $dec_data->absen;
        $id = $dec_data->id;

        $driver = $this->Driver_model->getdriverbyid($dec_data->id);
        $saldo = $driver['saldo'];
        $status = $driver['status_job'];
        $area = $driver['region_code'];
        $lokasi = $driver['lng'].",".$driver['lat'];
        if(intval($saldo) <5000000){
            $message = array(
                'message' => 'fail',
                'data' => []
            );
            $this->response($message, 200);
        }
        $jarak = $this->Driver_model->nearby($driver['lat'],$driver['lng']);
        //set map api url
        // $url = "https://route.ls.hereapi.com/routing/7.2/calculateroute.json?apiKey=IhmQsn2_1l7M0JKuXJK6rFfVZQGC9CUFddTZLBL-AWA&waypoint0=geo!$lokasi&waypoint1=-6.115430,106.684669&mode=fastest;car";
    //   $url ="https://api.openrouteservice.org/v2/directions/driving-car?api_key=5b3ce3597851110001cf624802b1bc6d41b44aeab6269f226d57f7c3&start=106.652051,-6.123493&end=$lokasi";
    //     //call api
    //     $json = file_get_contents($url);
    //     $json = json_decode($json);
    //     // $dist = $json->response->route[0]->summary->distance / 1000;
    //     $dist = $json->features[0]->properties->segments[0]->distance /1000;

        $now = strtotime(date('H:i:s'));
        $open = strtotime('06:00:00');
        // && $jarak <= 7
        if( $now >= $open && $saldo >= 0 && $status=='1' ){

            $dataEdit = array(
            'absen' => $absen
            );

        $upd_regid = $this->Driver_model->edit_config($dataEdit, $dec_data->id);
        if($absen == "Y"){
            $statabs = $this->Driver_model->addantrian($dec_data->id);
        }else if($absen == "N" && $jarak >= 10){
            $statabs = $this->Driver_model->cancelantrian($dec_data->id);
        }
        //var_dump($driver);
        
        if($statabs){
            $message = array(
                'message' => 'success',
                'data' => $absen,
                'jarak' => $jarak,
            );
        } else {
            $message = array(
                'message' => 'fail',
                'data' => []
            );
        }     
        
        } else {
            $message = array(
                'message' => 'fail',
                'data' => "N",
                'message2' => $saldo,
            );
        }
    $this->response($message, 200);
    }
    
    function absenx_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $absen = $dec_data->absen;
        $id = $dec_data->id;

        $driver = $this->Driver_model->getdriverbyid($dec_data->id);
        $saldo = $driver['saldo'];
        $status = $driver['status_job'];
        $area = $driver['region_code'];
        $lokasi = $driver['lng'].",".$driver['lat'];
        if(intval($saldo) <5000000){
            $message = array(
                'message' => 'fail',
                'data' => []
            );
            $this->response($message, 200);
        }
        $jarak = $this->Driver_model->nearby($driver['lat'],$driver['lng']);
        //set map api url
        // $url = "https://route.ls.hereapi.com/routing/7.2/calculateroute.json?apiKey=IhmQsn2_1l7M0JKuXJK6rFfVZQGC9CUFddTZLBL-AWA&waypoint0=geo!$lokasi&waypoint1=-6.115430,106.684669&mode=fastest;car";
    //   $url ="https://api.openrouteservice.org/v2/directions/driving-car?api_key=5b3ce3597851110001cf624802b1bc6d41b44aeab6269f226d57f7c3&start=106.652051,-6.123493&end=$lokasi";
    //     //call api
    //     $json = file_get_contents($url);
    //     $json = json_decode($json);
    //     // $dist = $json->response->route[0]->summary->distance / 1000;
    //     $dist = $json->features[0]->properties->segments[0]->distance /1000;

        $now = strtotime(date('H:i:s'));
        $open = strtotime('06:00:00');
        $message = array(
                        'lokasi' => $lokasi,
                'data' => "N",
                'jarak' => $jarak,
                'data1' => $status,
                'message1' => $driver
            );
        
        // && $jarak <= 7
        // if($now >= $open && $saldo >= 0 && $status=='1' ){

        //     $dataEdit = array(
        //     'absen' => $absen
        //     );

        // $upd_regid = $this->Driver_model->edit_config($dataEdit, $dec_data->id);
        // if($absen == "Y"){
        //     $statabs = $this->Driver_model->addantrian($dec_data->id);
        // }else {
        //     $statabs = $this->Driver_model->cancelantrian($dec_data->id);
        // }
        // //var_dump($driver);
        
        // if($statabs){
        //     $message = array(
        //         'message' => 'success',
        //         'data' => $absen, 
        //     );
        // } else {
        //     $message = array(
        //         'message' => 'fail',
        //         'data' => []
        //     );
        // }     
        
        // } else {
        //     $message = array(
        //         'message' => 'fail',
        //         'data' => "N",
        //         'message2' => $saldo,
        //         'data1' => $status,
        //         'message1' => $dist
        //     );
        // }
    $this->response($message, 200);
    }

    function turning_on_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $is_turn = $dec_data->is_turn;
        $dataEdit = array();
        if ($is_turn) {
            $dataEdit = array(
                'status' => 1
            );
            $upd_regid = $this->Driver_model->edit_config($dataEdit, $dec_data->id);
            if ($upd_regid) {
                $message = array(
                    'message' => 'success',
                    'data' => '1'
                );
                $this->response($message, 200);
            } else {
                $message = array(
                    'message' => 'fail',
                    'data' => []
                );
                $this->response($message, 200);
            }
        } else {
            $dataEdit = array(
                'status' => 4,
                'absen' => 'N'
            );
            $upd_regid = $this->Driver_model->edit_config($dataEdit, $dec_data->id);
            $statabs = $this->Driver_model->cancelantrian($dec_data->id);
            
            if ($upd_regid) {
                $message = array(
                    'message' => 'success',
                    'data' => '4'
                );
                $this->response($message, 200);
            } else {
                $message = array(
                    'message' => 'fail',
                    'data' => []
                );
                $this->response($message, 200);
            }
            
        }
    }

    function driver_cancel_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);


        $tes = $this->Dashboard_model->gettransaksibyid($dec_data->id_transaksi);
        $waktu_order = $tes['waktu_order'];
        $waktu_skr = date('Y-m-d H:i:s');
        $tenggang = strtotime($waktu_order) - strtotime($waktu_skr);
        if( $tenggang < 14400) {
            $message = array(
                'message' => 'cancel failed',
                'data' => []
            );
            $this->response($message, 200);
        } else {
        
        $data_req = array(
            'id_transaksi' => $dec_data->id_transaksi
        );
        $cancel_req = $this->Pelanggan_model->user_cancel_request($data_req);

        if ($cancel_req['status']) {
            $this->Driver_model->delete_chat($cancel_req['iddriver'], $cancel_req['idpelanggan']);
            $message = array(
                'message' => 'canceled',
                'data' => []
            );
            $this->response($message, 200);
        } else {
            $message = array(
                'message' => 'cancel fail',
                'data' => []
            );
            $this->response($message, 200);
        }

        }
        // $this->response($waktu_order. " - ". $waktu_skr ." = ".$tenggang, 200);
    }

    function accept_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $data_req = array(
            'id_driver' => $dec_data->id,
            'id_transaksi' => $dec_data->id_transaksi
        );

        $condition = array(
            'id_driver' => $dec_data->id, 
            'status' => '1'
        );

        $cek_login = $this->Driver_model->get_status_driver($condition);
        if ($cek_login->num_rows() > 0) {

            $acc_req = $this->Driver_model->accept_request($data_req);

            if ($acc_req['status']) {
                $message = array(
                    'message' => 'berhasil',
                    'data' => 'berhasil'
                );
                $this->response($message, 200);
            } else {
                if ($acc_req['data'] == 'canceled') {
                    $message = array(
                        'message' => 'canceled',
                        'data' => 'canceled'
                    );
                    $this->response($message, 200);
                } else {
                    $message = array(
                        'message' => 'unknown fail',
                        'data' => 'canceled'
                    );
                    $this->response($message, 200);
                }
            }
        } else {
            $message = array(
                'message' => 'unknown fail',
                'data' => 'canceled'
            );
            $this->response($message, 200);
        }
    }

    function accept2_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        //Driver
        $id_driver = $dec_data->id;
        $id_transaksi = $dec_data->id_transaksi;

        //Voucher
        $voucher = $this->Dashboard_model->gettransaksibyid($dec_data->id_transaksi);
        $harga = $voucher['harga'];
        $waktu = $voucher['waktu_order'];
        $stamp = strtotime($waktu);
        $tanggal = date('Y-m-d',$stamp);
        $region_code = $voucher['region_code'];
        $notes = $voucher['notes'];
        $xpander=strpos($notes,"Xpander");
        $innova=strpos($notes,"Innova");
        $later = $voucher['now_later'];
        $bridging = $voucher['bridging'];

        $max = $stamp + 7200;
        $min = $stamp - 7200;
        //$tanggal = date('Y-m-d H:i:s',$max);

        $listvoucher = $this->Dashboard_model->gettransaksibydriver($dec_data->id,$tanggal);
        $i = count($listvoucher);
        for ($y = 0; $y <= $i; $y++) {
            $waktuorder =  $listvoucher[0]['waktu_order'];
            $x = strtotime($waktuorder); 

            if($x < $max && $x > $min && $later=='2' && $bridging=='2'){ 
                $confirm = 'Tidak Bisa'; 
                break;
            } else {
                $confirm = 'Bisa'; 
            }
        }             

        if($confirm=='Tidak Bisa'){
            $message = array(
                'message' => 'unknown fail',
                'data' => 'canceled'
            );
            $this->response($message, 200);
        } else if($confirm=='Bisa'){
            $data_req = array(
                'id_driver' => $id_driver,
                'id_transaksi' => $dec_data->id_transaksi
            );
    
            $condition = array(
                'id_driver' => $dec_data->id, 
                'status' => '1'
            );
    
            $cek_login = $this->Driver_model->get_status_driver($condition);
            if ($cek_login->num_rows() > 0) {
    
                $acc_req = $this->Driver_model->accept_request($data_req);
                if ($acc_req['status']) {
                    $message = array(
                        'message' => 'berhasil',
                        'data' => 'berhasil'
                    );
                    $this->response($message, 200);
                } else {
                    if ($acc_req['data'] == 'canceled') {
                        $message = array(
                            'message' => 'canceled',
                            'data' => 'canceled'
                        );
                        $this->response($message, 200);
                    } else {
                        $message = array(
                            'message' => 'unknown fail',
                            'data' => 'canceled'
                        );
                        $this->response($message, 200);
                    }
                }
            } else {
                $message = array(
                    'message' => 'unknown fail',
                    'data' => 'canceled'
                );
                $this->response($message, 200);
            }
        }
        
        /*
        $data_req = array(
            'id_driver' => $id_driver,
            'id_transaksi' => $dec_data->id_transaksi
        );

        $condition = array(
            'id_driver' => $dec_data->id, 
            'status' => '1'
        );

        $cek_login = $this->Driver_model->get_status_driver($condition);
        if ($cek_login->num_rows() > 0) {

            $acc_req = $this->Driver_model->accept_request($data_req);
            if ($acc_req['status']) {
                $message = array(
                    'message' => 'berhasil',
                    'data' => 'berhasil'
                );
                $this->response($message, 200);
            } else {
                if ($acc_req['data'] == 'canceled') {
                    $message = array(
                        'message' => 'canceled',
                        'data' => 'canceled'
                    );
                    $this->response($message, 200);
                } else {
                    $message = array(
                        'message' => 'unknown fail',
                        'data' => 'canceled'
                    );
                    $this->response($message, 200);
                }
            }
        } else {
            $message = array(
                'message' => 'unknown fail',
                'data' => 'canceled'
            );
            $this->response($message, 200);
        }*/
    }

    function start_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $data_req = array(
            'id_driver' => $dec_data->id,
            'id_transaksi' => $dec_data->id_transaksi
        );

        $acc_req = $this->Driver_model->start_request($data_req);
        if ($acc_req['status']) {
            $message = array(
                'message' => 'berhasil',
                'data' => 'success'
            );
            $this->response($message, 200);
        } else {
            if ($acc_req['data'] == 'canceled') {
                $message = array(
                    'message' => 'canceled',
                    'data' => 'canceled'
                );
                $this->response($message, 200);
            } else {
                $message = array(
                    'message' => 'unknown fail',
                    'data' => 'unknown fail'
                );
                $this->response($message, 200);
            }
        }
    }

    function finish_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        if($this->Driver_model->cek_laporan_ap($dec_data->id_transaksi)==true ){
            if( $this->Driver_model->cek_driver_ap($dec_data->id)==true){    
        $report =count($this->Driver_model->get_laporan_report_ap());
        $all =count($this->Driver_model->get_laporan_ap());
        $laporan_ap=$this->Driver_model->get_laporan_apid( $dec_data->id_transaksi);
        $retase=(int)$laporan_ap->retase;
         $now = strtotime(date('H:i:s'));
        $open = strtotime('06:00:00');
        if($now >= $open AND ($retase/100)>=($report/$all) AND isset($laporan_ap->id_terminal_ap) AND !empty($laporan_ap->id_terminal_ap)){
            $ap= $this->Driver_model->send_post($laporan_ap);
            if($ap==true){
            $this->Driver_model->updete_laporan_report_ap($dec_data->id_transaksi);
            }
            $this->Driver_model->updete_laporan_finish_ap($dec_data->id_transaksi);
        }else{
            $this->Driver_model->updete_laporan_finish_ap($dec_data->id_transaksi);
        }
            }else{
                $this->Driver_model->updete_laporan_bukan_member($dec_data->id_transaksi);
            }
        }else{
            $this->Driver_model->updete_laporan_finish_ap($dec_data->id_transaksi);
        }
        $data_req = array(
            'id_driver' => $dec_data->id,
            'id_transaksi' => $dec_data->id_transaksi
        );

        $data_tr = array(
            'id_driver' => $dec_data->id,
            'id' => $dec_data->id_transaksi
        );

        $finish_transaksi = $this->Driver_model->finish_request($data_req, $data_tr);
        if ($finish_transaksi['status']) {
            $message = array(
                'message' => 'berhasil',
                'data' => 'finish',
            );
            $this->response($message, 200);
        } else {
            $message = array(
                'message' => 'fail',
                'data' => $finish_transaksi['data']
            );
            $this->response($message, 200);
        }
    }

    function detail_transaksi_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        if($dec_data->status != ""){
            $gettranslater =$this->Driver_model->transaksidrv($dec_data->id);
        
            if ($gettranslater->id == $dec_data->id) {
                if($dec_data->status =="Terima"){
                    $sl = 12;
                    $getdriver = $this->Driver_model->edit_statuslater($dec_data->id, $dec_data->driverid, $sl);
                } 
            } elseif ($dec_data->status =="Tiba"){
                $sl = 2;
                $getdriver = $this->Driver_model->edit_statuslater($dec_data->id, $dec_data->driverid ,$sl);
            } elseif ($dec_data->status =="Batal"){
                $tes = $this->Dashboard_model->gettransaksibyid($dec_data->id);
                $waktu_order = $tes['waktu_order'];
                $waktu_skr = date('Y-m-d H:i:s');
                $tenggang = strtotime($waktu_order) - strtotime($waktu_skr);
                //var_dump($tenggang);
                    if($tenggang < 18000) {
                        $message = array(
                            'message' => 'cancel failed',
                            'data' => []
                        );
                        $this->response($message, 200); 
                    } else {  
                        $sl = 0; 
                        $getdriver = $this->Driver_model->edit_statuslater($dec_data->id, $dec_data->driverid ,$sl);
                    }
                 
            } 
        }

        $gettrans = $this->Pelanggan_model->transaksi($dec_data->id);
        $getdriver = $this->Driver_model->get_data_pelangganid($dec_data->id_pelanggan);
        $getitem = $this->Pelanggan_model->detail_item($dec_data->id); 
        
        $message = array(
            'status' => true,
            //'status2' => $gettranslater->result('id'),
            'data' => $gettrans->result(),
            'pelanggan' => $getdriver->result(),
            'item' => $getitem->result(),
        );
        //var_dump($gettranslater->id);
        $this->response($message, 200);
    }

    function verifycode_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        $condition = array(
            'no_telepon' => $dec_data->no_telepon
        );
        $dataverify = array(
            'struk' => $dec_data->verifycode,
            'id_transaksi' => $dec_data->id_transaksi
        );
        $dataver = $this->Driver_model->get_verify($dataverify);
        $cek_login = $this->Driver_model->get_data_pelanggan($condition);
        if ($cek_login->num_rows() > 0 && $dataver->num_rows() > 0) {

            $message = array(
                'message' => 'success',
                'data' => '',
            );
            $this->response($message, 200);
        } else {
            $message = array(
                'message' => 'fail',
                'data' => ''
            );
            $this->response($message, 200);
        }
    }

    function edit_profile_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);
        $check_exist_phone = $this->Driver_model->check_exist_phone_edit($decoded_data->id, $decoded_data->no_telepon);
        $check_exist_email = $this->Driver_model->check_exist_email_edit($decoded_data->id, $decoded_data->email);
        if ($check_exist_phone) {
            $message = array(
                'code' => '201',
                'message' => 'phone already exist',
                'data' => []
            );
            $this->response($message, 201);
        } else if ($check_exist_email) {
            $message = array(
                'code' => '201',
                'message' => 'email already exist',
                'data' => []
            );
            $this->response($message, 201);
        } else {
            $condition = array(
                'no_telepon' => $decoded_data->no_telepon
            );
            $condition2 = array(
                'no_telepon' => $decoded_data->no_telepon_lama
            );

            if ($decoded_data->fotodriver == null && $decoded_data->fotodriver_lama == null) {
                $datauser = array(
                    'nama_driver' => $decoded_data->fullnama,
                    'no_telepon' => $decoded_data->no_telepon,
                    'phone' => $decoded_data->phone,
                    'email' => $decoded_data->email,
                    'countrycode' => $decoded_data->countrycode,
                    'tgl_lahir' => $decoded_data->tgl_lahir
                );
            } else {
                $image = $decoded_data->fotodriver;
                $namafoto = time() . '-' . rand(0, 99999) . ".jpg";
                $path = "images/fotodriver/" . $namafoto;
                file_put_contents($path, base64_decode($image));

                $foto = $decoded_data->fotodriver_lama;
                $path = "./images/fotodriver/$foto";
                unlink("$path");


                $datauser = array(
                    'nama_driver' => $decoded_data->fullnama,
                    'no_telepon' => $decoded_data->no_telepon,
                    'phone' => $decoded_data->phone,
                    'email' => $decoded_data->email,
                    'countrycode' => $decoded_data->countrycode,
                    'foto' => $namafoto,
                    'tgl_lahir' => $decoded_data->tgl_lahir
                );
            }


            $cek_login = $this->Driver_model->get_data_pelanggan($condition2);
            if ($cek_login->num_rows() > 0) {
                $upd_user = $this->Driver_model->edit_profile($datauser, $decoded_data->no_telepon_lama);
                $getdata = $this->Driver_model->get_data_pelanggan($condition);
                $message = array(
                    'code' => '200',
                    'message' => 'success',
                    'data' => $getdata->result()
                );
                $this->response($message, 200);
            } else {
                $message = array(
                    'code' => '404',
                    'message' => 'error data',
                    'data' => []
                );
                $this->response($message, 200);
            }
        }
    }

    function edit_kendaraan_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);

        $condition = array(
            'id' => $decoded_data->id,
            'no_telepon' => $decoded_data->no_telepon
        );

        $datakendaraan = array(
            'merek' => $decoded_data->merek,
            'tipe' => $decoded_data->tipe,
            'nomor_kendaraan' => $decoded_data->no_kendaraan,
            'warna' => $decoded_data->warna
        );



        $cek_login = $this->Driver_model->get_data_pelanggan($condition);
        if ($cek_login->num_rows() > 0) {
            $upd_user = $this->Driver_model->edit_kendaraan($datakendaraan, $decoded_data->id_kendaraan);
            $getdata = $this->Driver_model->get_data_pelanggan($condition);
            $message = array(
                'code' => '200',
                'message' => 'success',
                'data' => $getdata->result()
            );
            $this->response($message, 200);
        } else {
            $message = array(
                'code' => '404',
                'message' => 'error data',
                'data' => []
            );
            $this->response($message, 200);
        }
    }

    function changepass_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);
        $reg_id = array(
            'password' => sha1($decoded_data->new_password)
        );

        $condition = array(
            'password' => sha1($decoded_data->password),
            'no_telepon' => $decoded_data->no_telepon
        );
        $condition2 = array(
            'password' => sha1($decoded_data->new_password),
            'no_telepon' => $decoded_data->no_telepon
        );
        $cek_login = $this->Driver_model->get_data_pelanggan($condition);
        $message = array();

        if ($cek_login->num_rows() > 0) {
            $upd_regid = $this->Driver_model->edit_profile($reg_id, $decoded_data->no_telepon);
            $get_pelanggan = $this->Driver_model->get_data_pelanggan($condition2);

            $message = array(
                'code' => '200',
                'message' => 'found',
                'data' => $get_pelanggan->result()
            );
            $this->response($message, 200);
        } else {
            $message = array(
                'code' => '404',
                'message' => 'wrong password',
                'data' => []
            );
            $this->response($message, 200);
        }
    }

    function history_progress_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);
        $getWallet = $this->Driver_model->all_transaksi($decoded_data->id);
        $message = array(
            'status' => true,
            'data' => $getWallet->result()
        );
        $this->response($message, 200);
    }
    
    function historynew_progress_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);
        $getWallet = $this->Driver_model->all_transaksi_periode($decoded_data->id, $decoded_data->periode);
        $message = array(
            'status' => true,
            'data' => $getWallet->result()
        );
        $this->response($message, 200);
    }

    function book_progress_post()
    {
        
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);
        $getBook = $this->Driver_model->book_historyxx($decoded_data->id);
        $message = array(
            'status' => true,
            'data' => $getBook
        );
        $this->response($message, 200);
    }
    
    function forgot_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);

        $condition = array(
            'email' => $decoded_data->email,
            'status' => '1'
        );
        $cek_login = $this->Driver_model->get_data_pelanggan($condition);
        $app_settings = $this->Pelanggan_model->get_settings();
        $token = sha1(rand(0, 999999) . time());


        if ($cek_login->num_rows() > 0) {
            $cheker = array('msg' => $cek_login->result());
            foreach ($app_settings as $item) {
                foreach ($cheker['msg'] as $item2 => $val) {
                    $dataforgot = array(
                        'userid' => $val->id,
                        'token' => $token,
                        'idKey' => '2'
                    );
                }


                $forgot = $this->Pelanggan_model->dataforgot($dataforgot);

                $linkbtn = base_url() . 'resetpass/rest/' . $token . '/2';
                $template = $this->Pelanggan_model->template1($item['email_subject'], $item['email_text1'], $item['email_text2'], $item['app_website'], $item['app_name'], $linkbtn, $item['app_linkgoogle'], $item['app_address']);
                $sendmail = $this->Pelanggan_model->emailsend($item['email_subject'] . " [ticket-" . rand(0, 999999) . "]", $decoded_data->email, $template, $item['smtp_host'], $item['smtp_port'], $item['smtp_username'], $item['smtp_password'], $item['smtp_from'], $item['app_name'], $item['smtp_secure']);
            }
            if ($forgot && $sendmail) {
                $message = array(
                    'code' => '200',
                    'message' => 'found',
                    'data' => []
                );
                $this->response($message, 200);
            } else {
                $message = array(
                    'code' => '401',
                    'message' => 'email not registered',
                    'data' => []
                );
                $this->response($message, 200);
            }
        } else {
            $message = array(
                'code' => '404',
                'message' => 'email not registered',
                'data' => []
            );
            $this->response($message, 200);
        }
    }

    function register_driver_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        switch ($dec_data->alamat_driver) {
            case "JABODETABEK":
                $region_code = 11;
            break;
            case "SURABAYA":
                $region_code = 14;
            break;
            case "MANADO":
                $region_code = 10;
            break;
            case "MAKASSAR":
                $region_code = 25;
            break;
            case "MEDAN":
                $region_code = 37;
            break;
            case "YOGYAKARTA":
                $region_code = 21;
            break;
            case "BATAM":
                $region_code = 45;
            break;
            case "LAMPUNG":
                $region_code = 43;
            break;
            case "SEMARANG":
                $region_code = 23;
            break;
            case "KENDARI":
                $region_code = 27;
            break;
            case "PALEMBANG":
                $region_code = 41;
            break;
            case "PADANG":
                $region_code = 47;
            break;
            case "BANJARMASIN":
                $region_code = 33;
            break;
            case "BALIKPAPAN":
                $region_code = 31;
            break;
            case "PONTIANAK":
                $region_code = 25; 
            break;
            case "PEKANBARU":
                $region_code = 39;
            break;


        }

        $kata = $dec_data->no_telepon.$dec_data->nama_driver;
        $refferal = '';
        for($i = 0; $i < 5; $i++) {
        $pos = rand(0, strlen($kata)-1);
        $refferal .= $data{$pos};
        }
        $refferal = $refferal;


        $email = $dec_data->email;
        $phone = $dec_data->no_telepon;
        $check_exist = $this->Driver_model->check_exist($email, $phone);
        $check_exist_phone = $this->Driver_model->check_exist_phone($phone);
        $check_exist_email = $this->Driver_model->check_exist_email($email);
        $check_exist_sim = $this->Driver_model->check_sim($dec_data->id_sim);
        $check_exist_ktp = $this->Driver_model->check_ktp($dec_data->no_ktp);
        if ($check_exist) {
            $message = array(
                'code' => '201',
                'message' => 'email and phone number already exist',
                'data' => ''
            );
            $this->response($message, 201);
        } else if ($check_exist_phone) {
            $message = array(
                'code' => '201',
                'message' => 'phone already exist',
                'data' => ''
            );
            $this->response($message, 201);
        } else if ($check_exist_sim) {
            $message = array(
                'code' => '201',
                'message' => 'Driver license already exist',
                'data' => ''
            );
            $this->response($message, 201);
        } else if ($check_exist_ktp) {
            $message = array(
                'code' => '201',
                'message' => 'ID Card already exist',
                'data' => ''
            );
            $this->response($message, 201);
        } else if ($check_exist_email) {
            $message = array(
                'code' => '201',
                'message' => 'email already exist',
                'data' => ''
            );
            $this->response($message, 201);
        } else {
            if ($dec_data->checked == "true") {
                $message = array(
                    'code' => '200',
                    'message' => 'next',
                    'data' => ''
                );
                $this->response($message, 200);
            } else {
                $image = $dec_data->foto;
                $namafoto = time() . '-' . rand(0, 99999) . ".jpg";
                $path = "images/fotodriver/" . $namafoto;
                file_put_contents($path, base64_decode($image));
                $data_signup = array(
                    'id' => 'D' . time(),
                    'fleet' => '0',
                    'nama_driver' => strtoupper($dec_data->nama_driver),
                    'reff' => strtoupper($dec_data->reff),
                    'no_ktp' => str_replace(' ', '', $dec_data->no_ktp),
                    'tgl_lahir' => $dec_data->tgl_lahir,
                    'no_telepon' => $dec_data->no_telepon,
                    'phone' => $dec_data->phone,
                    'email' => $dec_data->email,
                    'foto' => $namafoto,
                    'password' => sha1(time()),
                    'job' => $dec_data->job,
                    'countrycode' => $dec_data->countrycode,
                    'gender' => $dec_data->gender,
                    'alamat_driver' => $dec_data->alamat_driver,
                    'region_code' => $region_code,
                    'referral_code' => strtoupper($refferal),
                    'uppline_id' => strtoupper($dec_data->reff),
                    'reg_id' => 12345,
                    'status' => 0,
                    'berkah' => 0
                );

                $data_kendaraan = array(
                    'merek' => strtoupper($dec_data->merek),
                    'tipe' => strtoupper($dec_data->tipe),
                    'jenis' => strtoupper($dec_data->job),
                    'nomor_kendaraan' => strtoupper(str_replace(' ', '', $dec_data->nomor_kendaraan)),
                    'warna' => strtoupper($dec_data->warna)
                );

                $imagektp = $dec_data->foto_ktp;
                $namafotoktp = time() . '-' . rand(0, 99999) . ".jpg";
                $pathktp = "images/fotoberkas/ktp/" . $namafotoktp;
                file_put_contents($pathktp, base64_decode($imagektp));

                $imagesim = $dec_data->foto_sim;
                $namafotosim = time() . '-' . rand(0, 99999) . ".jpg";
                $pathsim = "images/fotoberkas/sim/" . $namafotosim;
                file_put_contents($pathsim, base64_decode($imagesim));

                $imagestnk = $dec_data->foto_stnk;
                $namafotostnk = time() . '-' . rand(0, 99999) . ".jpg";
                $pathstnk = "images/fotoberkas/stnk/" . $namafotostnk;
                file_put_contents($pathstnk, base64_decode($imagestnk));

                $data_berkas = array(
                    'foto_ktp' => $namafotoktp,
                    'foto_sim' => $namafotosim,
                    'foto_stnk' => $namafotostnk,
                    'id_sim' => str_replace(' ', '', $dec_data->id_sim),
                    'stnk_berlaku' => $dec_data->stnk
                );


                $signup = $this->Driver_model->signup($data_signup, $data_kendaraan, $data_berkas);
                if ($signup) {
                    $message = array(
                        'code' => '200',
                        'message' => 'success',
                        'data' => 'Data pendaftaran telah kami terima untuk proses verifikasi.'
                    );
                    $this->response($message, 200);
                } else {
                    $message = array(
                        'code' => '201',
                        'message' => 'failed',
                        'data' => ''
                    );
                    $this->response($message, 201);
                }
            }
        }
    }
    

    public function generatekodeunik($kodeunik)
    {
        $cari = $this->wallet->getkodeunik($kodeunik);
        if ($cari) {
            return false;
        } else {
            return $kodeunik;
        }
        // return $cari;
    }

    
    // public function kodeunikx_post()
    public function kodeunik()
    {
        $x = 1;
        do {
          $kodeunik = rand(3,999);
          $generate = $this->generatekodeunik($kodeunik);
        //   echo "cek $x :  $kodeunik - $generate<br>";
          $x++;
        } while (!$generate || $x == 15);
        
        // $kodeunik = rand(3,999);
        // $generate = $this->generatekodeunik('679');
        
        if($generate !== ""){
            return $generate;
        }
    }

    public function withdraw_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $iduser = $dec_data->id;
        $bank = $dec_data->bank;
        $nama = $dec_data->nama;
        $amount = $dec_data->amount;
        $digits = substr($dec_data->amount,-5);
        $jumlah = $amount - $digits;
        // $kodeunik = $digits / 100 ;
        // //$transfer = $dec_data->amount / 100 ;
        // $kodeunik = rand(3,999) ;
        $kodeunik = $this->kodeunik();
        $token = $this->wallet->gettoken($iduser);
        
        $amountunik = ($jumlah / 100) + $kodeunik ;
        $transfer = $amountunik;
        // $transfer = round($amountunik / 0.993, 0);
        // $mdr = $transfer - $amountunik;
        $expired = date("Y-m-d H:i:s", strtotime("+1 hours"));
        
        $card = $dec_data->card;
        $email = $dec_data->email;
        $phone = $dec_data->no_telepon;

        $saldolama = $this->Pelanggan_model->saldouser($iduser);
        $saldolamaxtrx = $saldolama->row('saldotrx');
        $saldolamax = $saldolama->row('saldo');

        $token = $this->wallet->gettoken($iduser);
        $regid = $this->wallet->getregid($iduser);
        $tokenmerchant = $this->wallet->gettokenmerchant($iduser);

        if ($token == NULL and $tokenmerchant == NULL and $regid != NULL) {
            $topic = $regid['reg_id'];
        } else if ($regid == NULL and $tokenmerchant == NULL and $token != NULL) {
            $topic = $token['token'];
        } else if ($regid == NULL and $token == NULL and $tokenmerchant != NULL) {
            $topic = $tokenmerchant['token_merchant']; 
        } 

        $title = 'Cara Topup';
        $message = 'Transfer dana ke rek BCA 7880559529 - Suskandani sebesar IDR. '.$transfer ;
        
        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $noteswd = "WD-".substr(str_shuffle($permitted_chars), 0, 10);
        $notestrxdep = "TRX-DEP-".substr(str_shuffle($permitted_chars), 0, 10);
        $notestopup = "Topup-".substr(str_shuffle($permitted_chars), 0, 10);
        $qr_code = "00020101021126730021COM.GUDANGVOUCHER.WWW011893600916300371101802150870000037110180303UMI51450015ID.OR.GPNQR.WWW02150870000037110180303UMI5204412153033605802ID5915MITRA SMARTRANS6009TANGERANG61051512562070703A0163046BCE";
        $datatopup = array(
            'id_user' => $iduser,
            'rekening' => $card,
            'bank' => $bank,
            'nama_pemilik' => $nama,
            'type' => $dec_data->type,
            'jumlah' => $jumlah,
            'saldo_awal' => $saldolamax,
            'kode_unik' => $kodeunik,
            'expired' => $expired,
            'transfer' => $transfer,
            'notes' => $notestopup,
            'status' => 0
        );

        $datawithdraw = array(
            'id_user' => $iduser,
            'rekening' => $card,
            'bank' => $bank,
            'nama_pemilik' => $nama,
            'type' => $dec_data->type,
            'jumlah' => $amount,
            'saldo_awal' => $saldolamaxtrx,
            'notes' => $noteswd,
            'status' => 0
        );

        $datawithdrawflip = array(
            'id_user' => $iduser,
            'rekening' => $card,
            'bank' => $bank,
            'nama_pemilik' => $nama,
            'type' => $dec_data->type,
            'jumlah' => $amount,
            'saldo_awal' => $saldolamaxtrx,
            'saldo_akhir' => $saldolamaxtrx - $amount,
            'notes' => $noteswd,
            'status' => 1
        );

        $datatopuptrxwd = array(
            'id_user' => $iduser,
            'rekening' => $amount,
            'bank' => "Deposit Wallet",
            'nama_pemilik' => 'Topup',
            'type' => "withdraw",
            'jumlah' => $amount,
            'saldo_awal' => $saldolamaxtrx,
            'saldo_akhir' => $saldolamaxtrx - $amount,
            'notes' => $notestrxdep,
            'status' => 1
        );

        $datatopuptrx = array(
            'id_user' => $iduser,
            'rekening' => $amount,
            'bank' => "dari Transation Wallet",
            'nama_pemilik' => 'Topup',
            'type' => "topup",
            'jumlah' => $amount,
            'saldo_awal' => $saldolamax,
            'saldo_akhir' => $saldolamax + $amount,
            'notes' => $notestrxdep,
            'status' => 1 
        );

        $check_exist = $this->Driver_model->check_exist($email, $phone);

        if ($dec_data->type ==  "topup" && $dec_data->id == "D1616486995" || $dec_data->type ==  "topup" && $dec_data->id == "D0000000016") {
            $this->wallet->send_notif("Topup", "Segera lakukan Topup Sebesar RP. ".$transfer, $topic);
            $datatopup["qrcode"]= $qr_code;
            $datatopup["topupvia"] = "QRIS";
            $datatopup["trx_datetime"] = date("Y-m-d H:i:s");
             $datatopup["expired"] = date("Y-m-d H:i:s", strtotime("+1 hours"));
             $id = $this->Pelanggan_model->insertwallet($datatopup);
                         
            //  $idnew = $id."TOPX";
            //  $qr = $this->finance->createQR($id,$transfer);
             
        // $qrisdata = array( 
        //         'id_gv' =>  $qr->responddata->reference_label,
        //         'qrcode' => $qr_code,
        //         'expired' => "",
        //         'topupvia' => 'QRIS'
        // //     );
        //      $insertIdGv= $this->Pelanggan_model->updateWallet($id,$qrisdata 
        //      ); 
             
            if(isset($id)){
                 $message = array(
                                'code' => '200',
                                'message' => 'success',
                                'data' =>[],
                                'amount' =>$transfer, 
                                'data_qr' =>$qr_code,
                                'status' =>'0',
                                );
                                
                 $this->response($message, 200);
            } else {
             $message = array(
                'code' => '400',
                'message' => 'fail',
                'data' => []
                );
            $this->response($message, 400);
            }
        }else if ($dec_data->type ==  "topup" ) {
            
            $withdrawdata = $this->Pelanggan_model->insertwallet($datatopup);
            $this->wallet->send_notif($title, $message, $topic);

            $message = array(
                'code' => '200',
                'message' => 'success',
                'data' => [],
            );
            $this->response($message, 200);
        } else if ($dec_data->type ==  "topuptrx") {
            if ($saldolama->row('saldotrx') >= $amount && $check_exist) {
                $saldobarutrx = $saldolama->row('saldotrx') - $amount;
                $saldobaru = $saldolama->row('saldo') + $amount;
                $saldo = array(
                    'saldo' => $saldobaru,
                    'saldotrx' => $saldobarutrx, 
                );
                $this->Pelanggan_model->tambahsaldo($iduser, $saldo);
                $withdrawdata = $this->Driver_model->insertwallettrx($datatopuptrxwd);                
                $withdrawdata = $this->Pelanggan_model->insertwallet($datatopuptrx);

                $message = array(
                    'code' => '200',
                    'message' => 'success',
                    'data' => []
                );
                $this->response($message, 200); 
            } else {
                $message = array(
                    'code' => '201',
                    'message' => 'You have insufficient balance (Topup Trx)',
                    'data' => []
                );
                $this->response($message, 200);
            }    
        } else if ($dec_data->type ==  "withdraw") {
            $btsflip = $saldolamaxtrx - 1500;
            if ($amount < 1500000 && $amount > $saldolamaxtrx ) {
                $message = array(
                    'code' => '201',
                    'message' => 'Request anda dibawah minimum (Withdraw Trx)',
                    'data' => []
                );
                $this->response($message, 200);
            } else if ($saldolama->row('saldotrx') >= $amount && $check_exist) {
                /*if($iduser=='D0000000180'){  
                $withdrawdata = $this->wconfirmtrx($iduser, $amount);  
                } else {
                    $this->Driver_model->insertwallettrx($datawithdraw);
                    $message = array(
                        'code' => '200',
                        'message' => 'success',
                        'data' => []
                    );
                    $this->response($message, 200); 
                } */              

                $withdrawdata = $this->wconfirmtrx($iduser, $amount);  
                if($withdrawdata){
                    $this->Driver_model->insertwallettrx($datawithdrawflip);   
                    $message = array(
                        'code' => '200',
                        'message' => 'success',
                        'data' => []
                    );
                    
                    /*
                    $flipamount = ($amount - 500000)/100;
                    $wdflip = $this->flip->reqwd($flipamount,$bank,$card,$noteswd);
                            if($wdflip===true){
                            $message = array(
                                'code' => '200',
                                'message' => 'success',
                                'data' => []
                            );
                            } else {
                                $this->flip->refundsaldotrx($noteswd, date('Y-m-d H:i:s'));
                                $message = array(
                                    'code' => '201',
                                    'message' => 'Flip Gagal',
                                    'data' => []
                                );    
                            } */
                    $this->response($message, 200); 
                }
            } else {
                $message = array(
                    'code' => '201',
                    'message' => 'You have insufficient balance (Withdraw Trx)',
                    'data' => []
                );
                $this->response($message, 200);
            }
        } else if ($dec_data->type ==  "topupqris" ) {
            
            // $id = $this->Pelanggan_model->insertwallet($datatopup);
            // $message = $this->berkah->cqr($id,$transfer);
            // $this->response($message, 200);
                        
            // $topup = $this->Pelanggan_model->insertwallet($datatopup);

            // $message = array(
            //     'code' => '200',
            //     'message' => 'success',
            //     'data' => [],
            //     'reference_label' =>'',
            //     'amount' =>$transfer,
            //     'expired_time' => $expired,
            //     'data_qr' =>'',
            //     'status' =>'0',
            // );
            // $this->response($message, 200);
            
            $cari = $this->wallet->getlasttopup($dec_data->id);
            // $this->response($cari, 200);  
            if ($cari) {
                $message = array(
                    'code' => '201',
                    'message' => 'Anda memiliki permintaan topup yang masih aktif',
                    'data' => []
                );
                $this->response($message, 200);
            } else {
                $topup = $this->Pelanggan_model->insertwallet($datatopup);
        
                $message = array(
                    'code' => '200',
                    'message' => 'success',
                    'data' => [],
                    'reference_label' =>'',
                    'amount' =>$transfer,
                    'expired_time' => $expired,
                    'data_qr' =>'',
                    'status' =>'0',  
                ); 
                $this->response($message, 200);  
            }
        } else if ($dec_data->type ==  "topupqrisx" ) {
            
            $cari = $this->wallet->getlasttopup($dec_data->id);
            // $this->response($cari, 200);  
            if ($cari) {
                $message = array(
                    'code' => '201',
                    'message' => 'Anda memiliki permintaan topup yang masih aktif',
                    'data' => []
                );
                $this->response($message, 200);
            } else {
                $topup = $this->Pelanggan_model->insertwallet($datatopup);
        
                $message = array(
                    'code' => '200',
                    'message' => 'success',
                    'data' => [],
                    'reference_label' =>'',
                    'amount' =>$transfer,
                    'expired_time' => $expired,
                    'data_qr' =>'',
                    'status' =>'0',  
                ); 
                $this->response($message, 200);  
            }
        }
    }

    public function wconfirmtrx($id_user, $amount)
    {
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

        $title = 'Withdraw Sukses';
        $message = 'Withdraw telah dikonfirmasi, dana sedang di proses transfer ke rekening yang anda input.';
        $saldotrx = $this->wallet->getsaldotrx($id_user); //saldotrx 
        $saldonew = $saldotrx['saldotrx'] - $amount;

        if($saldotrx['saldotrx'] < $amount ){ 
            $title = 'Withdraw Cancel';
            $message = 'Withdraw dibatalkan karena saldo tidak cukup..!!';
            //$this->wallet->cancelstatuswithdrawbyidtrx($id);
            $this->wallet->send_notif($title, $message, $topic);
            return false;
        } elseif($saldotrx['saldotrx'] >= $amount){
            $this->wallet->ubahsaldotrx($id_user, $amount, $saldotrx); //Ubah Saldo kurangi WD
            //$this->wallet->ubahstatuswithdrawbyidtrx($id);
            $this->wallet->send_notif($title, $message, $topic);
            return true;
        } else {
            return false;
        }
    }

    public function topuppaypal_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $iduser = $dec_data->id;
        $bank = $dec_data->bank;
        $nama = $dec_data->nama;
        $amount = $dec_data->amount;
        $card = $dec_data->card;
        $email = $dec_data->email;
        $phone = $dec_data->no_telepon;

        $datatopup = array(
            'id_user' => $iduser,
            'rekening' => $card,
            'bank' => $bank,
            'nama_pemilik' => $nama,
            'type' => 'topup',
            'jumlah' => $amount,
            'status' => 1
        );
        $check_exist = $this->Driver_model->check_exist($email, $phone);

        if ($check_exist) {
            $this->Pelanggan_model->insertwallet($datatopup);
            $saldolama = $this->Pelanggan_model->saldouser($iduser);
            $saldobaru = $saldolama->row('saldo') + $amount;
            $saldo = array('saldo' => $saldobaru);
            $this->Pelanggan_model->tambahsaldo($iduser, $saldo);

            $message = array(
                'code' => '200',
                'message' => 'success',
                'data' => '' 
            );
            $this->response($message, 200);
        } else {
            $message = array(
                'code' => '201',
                'message' => 'You have insufficient balance',
                'data' => ''
            );
            $this->response($message, 200);
        }
    }
}
