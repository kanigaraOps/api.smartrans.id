<?php
//'tes' => number_format(200 / 100, 2, ",", "."),
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Pelanggan extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
        $this->load->database();
        $this->load->model('Notification_model', 'notification'); 
        $this->load->model('Driver_model');
        $this->load->model('Dashboard_model');
        $this->load->model('wallet_model', 'wallet'); 
        $this->load->model('Pelanggan_model');
         $this->load->model('Appsettings_model','app');
        date_default_timezone_set('Asia/Jakarta');
    }

    function index_get()
    {
        $this->response("Api for Smartrans!", 200);
    }
    function zona_get($id)
    {
        $near = $this->app->getzonaname($id);
        $message = array(
            'data' => $near
        );
        $this->response($message, 200);
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
         $token=$this->Pelanggan_model->gettokenpelbyphone($decoded_data->phone);
        $result = $this->notification->send_notif_testing($title, $message, $token);
        $this->response($result, 200);
    }
    
    // function ridelaters_post()
    // {
    //     function getDistanceBetweenPointsNew( $latitude2, $longitude2, $unit = 'kilometers') {
    //         $latitude1=-6.123493;
    //          $longitude1=106.652051;
    //         $theta = $longitude1 - $longitude2; 
    //         $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta))); 
    //         $distance = acos($distance); 
    //         $distance = rad2deg($distance); 
    //         $distance = $distance * 60 * 1.1515; 
    //         switch($unit) { 
    //           case 'miles': 
    //             break; 
    //           case 'kilometers' : 
    //             $distance = $distance * 1.609344; 
    //         } 
    //         return (round($distance,2)); 
    //       }


    //     $data = file_get_contents("php://input");
    //     $decoded_data = json_decode($data);
        
    //     $kredit_promo = $decoded_data->kredit_promo;
    //     if (!$kredit_promo) {
    //         $kredit_promo = 0;
    //     }
    //     // $nama = $decoded_data->nama;
    //     // $phone = $decoded_data->phone;
    //     $pickuptime = $decoded_data->waktujemput;
    //     $harga = $decoded_data->harga;
    //     $jemput = $decoded_data->alamat_asal;
    //     $tujuan = $decoded_data->alamat_tujuan;
    //     $id_pelanggan = $decoded_data->id_pelanggan;
    //     // $datapel = $this->Pelanggan_model->getidpelbyphone($phone);
    //     //     $dataid = $this->Dashboard_model->getidlast(); 


    //     // if($datapel==TRUE){
    //     // $iduser = $datapel['id'];
    //     // } else {
    //     //     $iduser = 'P'.rand(1000000000,9999999999); 
    //     //     $data_signup = array(
    //     //         'id'                        => $iduser,
    //     //         'fullnama'                  => $nama,
    //     //         'email'                     => $phone.'@gmail.com',
    //     //         'no_telepon'                => '62'.$phone,
    //     //         'countrycode'               => '+62',
    //     //         'phone'                     => $phone,
    //     //         'password'                  => '7c222fb2927d828af22f592134e8932480637c0d',
    //     //         'created_on '               => date('Y-m-d H:i:s'),
    //     //         'tgl_lahir '                => date('Y-m-d'), 
    //     //         'rating_pelanggan'          => '0',
    //     //         'status'                    => '1',
    //     //         'token'                     => '12345',
    //     //         'fotopelanggan'             => 'smart.jpg'
    //     //     );
    //     //     $user = $this->Pelanggan_model->signup($data_signup);
    //     // }
    //     // $harga = $harga * 100;
    //     // $datapel = $this->Pelanggan_model->getidpelbyphone($phone);
    //     $dataid = $this->Dashboard_model->getidlast();

    //     // if($datapel==TRUE){
    //     //     $iduser = $datapel['id'];
    //     // } else {
    //     //     $iduser = 'P'.rand(1000000000,9999999999); 
    //     // }






    //     $data_req = array(
    //         'id'                            => $dataid['id'] + 1,
    //         'id_order'                      => date('Y-m-d H:i:s'),
    //         'id_pelanggan'                  => $id_pelanggan,
    //         'order_fitur'                   => $decoded_data->order_fitur,
    //         'start_latitude'                => $decoded_data->start_latitude,
    //         'start_longitude'               => $decoded_data->start_longitude,
    //         'end_latitude'                  => $decoded_data->end_latitude,
    //         'end_longitude'                 => $decoded_data->end_longitude,
    //         'jarak'                         => $decoded_data->jarak,
    //         'harga'                         => $harga,
    //         'now_later'                     => $decoded_data->nowlater,
    //         'bridging'                      => 2,
    //         'estimasi_time'                 => $decoded_data->estimasi,
    //         'waktu_order'                   => $pickuptime,
    //         'alamat_asal'                   => $jemput,
    //         'alamat_tujuan'                 => $tujuan,
    //         'notes'                         =>  date('Y-m-d H:i:s'),
    //         'biaya_akhir'                   => $harga,
    //         'kredit_promo'                  => $kredit_promo,
    //         'region_code'                   => 0,
    //         'staff'                         => "",
    //         'pakai_wallet'                  => $decoded_data->pakai_wallet,
    //     );
    //     $lat = $decoded_data->start_latitude;
    //     $long = $decoded_data->start_longitude;
    //     $point = $lat . "," . $long;
    //     $jarak = getDistanceBetweenPointsNew($lat,$long);
    //     if($jarak<10){
    //         $pricecards = $this->Pelanggan_model->terminalpricecardbyid();
    //     }else{
    //     $area = $this->Pelanggan_model->getarea($point);
    //     $pricecards = $this->Pelanggan_model->pricecardbyid($area, $decoded_data->order_fitur);
    //     }
    //     $ha = 0;
    //     $kreditamuont = explode(".", $decoded_data->kredit_promo);
    //     $ha  = $decoded_data->harga - $kreditamuont[0];
    //     if ($ha <= 0) {
    //         $ha = 0;
    //     }
    //     $kredit_promo = $kreditamuont[0];
    //     $biaya_akhir = $ha;
    //     $fare = $biaya_akhir - $pricecards['surge'];
    //     $ce =  $fare * $pricecards['fee_company'] / 100;
    //     $de = $fare - $ce;
    //     $deductdriver = $ce + $pricecards['surge'];
    //     if ($decoded_data->pakai_wallet == 1) {
    //         $cp = 0;
    //         $op = $biaya_akhir;
    //     } elseif ($decoded_data->pakai_wallet == 0) {
    //         $cp = $biaya_akhir;
    //         $op = 0;
    //     }
    //     $data_jurnal = array(
    //         'sub_total_before_discount'             => $decoded_data->harga,
    //         'base_fare'                             => $pricecards['base_fare'],
    //         'distance'                              => $decoded_data->harga - $pricecards['base_fare'] - $pricecards['surge'],
    //         'surge_amount'                          => $pricecards['surge'],
    //         'tawar'                                 => 0 - $kredit_promo,
    //         'cash_payment'                          => $cp,
    //         'online_payment'                        => $op,
    //         'customer_paid_amount'                  => $biaya_akhir,
    //         'company_earning'                       => $ce,
    //         'driver_earning'                        => $de,
    //         'amount_deducted_from_driver_wallet'    => $deductdriver,
    //         'driver_total_payout_amount'            => $de,
    //         'created_at'                            => date('Y-m-d H:i:s')
    //     );
    //     $biayand = number_format($harga / 100, 2, ".", ".");
            
    //         $datanotif = array(
    //             "alamat_asal" => $jemput,
    //             "alamat_tujuan" => $tujuan,
    //             "estimasi_time" => $decoded_data->estimasi,
    //             "distance" => $decoded_data->jarak . " KM",
    //             "biaya" => "Rp " . $biayand,
    //             "harga" => $harga,
    //             "id_transaksi" => $dataid['id'] + 1,
    //             "layanan" => "Ride Later",
    //             "layanandesc" => $pickuptime,
    //             "order_fitur" => $decoded_data->order_fitur,
    //             "pakai_wallet" => $decoded_data->pakai_wallet,
    //             "bridging" => 2,
    //             "type" => 1,
    //         );
    //     $datadriver = $this->Driver_model->get_driver_regid($area);
    //     $idtest=["eq3lk_iNQGisqggJQTJbA1:APA91bHHz_ssStEnRvYpRbX_Oog5Uwg5LcS8uv5p016lxjrSmSMfJQqk1QzbDwMWUxMIvgIgKiFREr6e7UlH6OEWTRt8jEoGQPLtqjnJ9TTvV5LqMXsTV2_n3__KM0OFw9uADsGLdjK_",
    //             "eNBJy0KVQXGobP2CotI3y5:APA91bEwaKaA8vdwwkiDM164xKlyiY3U7Ns8ShwAPmov9ac1slQ5j7VvILrhprH-yKmMcQEQV8kA6Xjusx8M7m8dbLcvAgFpYdTMal2T473dQ_cJ00_4oIKDHcOpwH75StjD3jEQgB0W",
    //             "eKOdUPEeRj6o2iPAa9TTjJ:APA91bEJN_F3KI7kvqsjlIukro6DjJ3aAq3VUvkruEXqNYjrSKcZilBW74DYiGwPPrzRwAhpiSyusxy0MAizTIUELlcvXga3HNZxS9uZ0Din3as866S-sHBjWg9o0FDegrOhrmvA81qC"];
    //     $request = $this->Pelanggan_model->insert_transaksi_berkah($data_req, $data_jurnal,$datanotif,$idtest);
    //     if ($request['status']) {
    //         $message =  (object) array(
    //             "message" => "success",
    //             "data" => $request['data']
    //         );
            
    //         $this->response($message, 200);
    //     } else {
    //         $this->response("Data Gagal Terkirim driver", 200);
    //     }
    //     $this->response("Data Gagal  driver", 200);
    // }

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
        $cek_login = $this->Pelanggan_model->get_data_pelanggan($condition);
        $app_settings = $this->Pelanggan_model->get_settings();
        $token = sha1(rand(0, 999999) . time());


        if ($cek_login->num_rows() > 0) {
            $cheker = array('msg' => $cek_login->result());
            foreach ($app_settings as $item) {
                foreach ($cheker['msg'] as $item2 => $val) {
                    $dataforgot = array(
                        'userid' => $val->id,
                        'token' => $token,
                        'idKey' => '1'
                    );
                }


                $forgot = $this->Pelanggan_model->dataforgot($dataforgot);

                $linkbtn = base_url() . 'resetpass/rest/' . $token . '/1';
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
            'token' => $decoded_data->token
        );

        $condition = array(
            'no_telepon' => $decoded_data->no_telepon
            //'token' => $decoded_data->token
        );

        //var_dump($decoded_data->no_telepon);
        $check_banned = $this->Pelanggan_model->check_banned($decoded_data->no_telepon);
        if ($check_banned) {
            $message = array(
                'message' => 'banned',
                'data' => []
            );
            $this->response($message, 200);
        } else {
            $cek_login = $this->Pelanggan_model->get_data_pelanggan($condition);
            $message = array();

            if ($cek_login->num_rows() > 0) {
                $upd_regid = $this->Pelanggan_model->edit_profile($reg_id, $decoded_data->no_telepon);
                $get_pelanggan = $this->Pelanggan_model->get_data_pelanggan($condition);
                $message = array(
                    'code' => '200',
                    'message' => 'found',
                    'data' => $get_pelanggan->result()
                );
                $this->response($message, 200);
            } else {
                $message = array(
                    'code' => '404',
                    'message' => 'wrong phone or password',
                    'data' => []
                );
                $this->response($message, 200);
            }
        }
    }

    function register_user_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $email = $dec_data->email;
        $phone = $dec_data->no_telepon;
        $check_exist = $this->Pelanggan_model->check_exist($email, $phone);
        $check_exist_phone = $this->Pelanggan_model->check_exist_phone($phone);
        $check_exist_email = $this->Pelanggan_model->check_exist_email($email);
        if ($check_exist) {
            $message = array(
                'code' => '201',
                'message' => 'email and phone number already exist',
                'data' => []
            );
            $this->response($message, 201);
        } else if ($check_exist_phone) {
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
            if ($dec_data->checked == "true") {
                $message = array(
                    'code' => '200',
                    'message' => 'next',
                    'data' => []
                );
                $this->response($message, 200);
            } else {
                $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $reffx =  substr(str_shuffle($permitted_chars), 0, 5);
                $cekreff = $this->Pelanggan_model->check_reff($reffx);
                if($cekreff == true){
                    $reff = $reffx;
                }else{
                    $reff = $cekreff;
                }

                $image = $dec_data->fotopelanggan;
                $namafoto = time() . '-' . rand(0, 99999) . ".jpg";
                $path = "images/pelanggan/" . $namafoto;
                file_put_contents($path, base64_decode($image));
                $data_signup = array(
                    'id' => 'P' . time(),
                    'fullnama' => $dec_data->fullnama,
                    'email' => $dec_data->email,
                    'no_telepon' => $dec_data->no_telepon,
                    'phone' => $dec_data->phone,
                    'upline_id' => $dec_data->reff,
                    'reff' => $reff,
                    'password' => sha1($dec_data->password),
                    'tgl_lahir' => $dec_data->tgl_lahir,
                    'countrycode' => $dec_data->countrycode,
                    'fotopelanggan' => $namafoto,
                    'token' => $dec_data->token,
                );
                $signup = $this->Pelanggan_model->signup($data_signup);
                if ($signup) {
                    $condition = array(
                        'password' => sha1($dec_data->password),
                        'email' => $dec_data->email
                    );
                    $datauser1 = $this->Pelanggan_model->get_data_pelanggan($condition);
                    $message = array(
                        'code' => '200',
                        'message' => 'success',
                        'data' => $datauser1->result()
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
    }

    function kodepromo_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        $kodepromo = $this->Pelanggan_model->promo_code_use($dec_data->code, $dec_data->fitur);
        if ($kodepromo) {
            $message = array(
                'code' => '200',
                'message' => 'success',
                'nominal' => $kodepromo['nominal'],
                'type' => $kodepromo['type']
            );
            $this->response($message, 200);
        } else {
            $message = array(
                'code' => '201',
                'message' => 'failed'
            );
            $this->response($message, 200);
        }
    }

    function listkodepromo_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $kodepromo = $this->Pelanggan_model->promo_code()->result();
        $message = array(
            'code' => '200',
            'message' => 'success',
            'data' => $kodepromo
        );
        $this->response($message, 200);
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
        $long = $dec_data->longitude;
        $lat = $dec_data->latitude;
        $point = $lat.",".$long;
        $area = $this->Pelanggan_model->getarea($point);
        $slider = $this->Pelanggan_model->sliderhome();
        $fitur = $this->Pelanggan_model->fiturhome($area);
        $allfitur = $this->Pelanggan_model->fiturhomeall($area);
        $rating = $this->Pelanggan_model->ratinghome();
        $saldo = $this->Pelanggan_model->saldouser($dec_data->id);
        $app_settings = $this->Pelanggan_model->get_settings();
        $berita = $this->Pelanggan_model->beritahome();
        $kategorymerchant = $this->Pelanggan_model->kategorymerchant()->result();

        $merchantpromo = $this->Pelanggan_model->merchantpromo($long, $lat)->result();
        $merchantnearby = $this->Pelanggan_model->merchantnearby($long, $lat);

        $condition = array(
            'no_telepon' => $dec_data->no_telepon,
            'status' => '1'
        );
        $cek_login = $this->Pelanggan_model->get_data_pelanggan($condition);
        $payu = $this->Pelanggan_model->payusettings()->result();
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
                    'app_email' => $item['app_email'],
                    'area' => $area,
                    'slider' => $slider,
                    'fitur' => $fitur,
                    'allfitur' => $allfitur,
                    'ratinghome' => $rating,
                    'beritahome' => $berita,
                    'kategorymerchanthome' => $kategorymerchant,
                    'merchantnearby' => $merchantnearby,
                    'merchantpromo' => $merchantpromo,
                    'data' => $cek_login->result(),
                    'payu' => $payu,
                    'smartkey' => $item['smartkey'],
                    'petakey' => $item['petakey'],
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

    public function merchantbykategori_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        $kategori = $dec_data->kategori;
        $long = $dec_data->longitude;
        $lat = $dec_data->latitude;
        $merchantbykategori = $this->Pelanggan_model->merchantbykategori($kategori, $long, $lat)->result();
        $condition = array(
            'no_telepon' => $dec_data->no_telepon,
            'status' => '1'
        );
        $cek_login = $this->Pelanggan_model->get_data_pelanggan($condition);
        if ($cek_login->num_rows() > 0) {
            $message = array(
                'code' => '200',
                'message' => 'success',

                'merchantbykategori' => $merchantbykategori
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

    public function merchantbykategoripromo_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        $kategori = $dec_data->kategori;
        $long = $dec_data->longitude;
        $lat = $dec_data->latitude;

        $merchantbykategori = $this->Pelanggan_model->merchantbykategoripromo($kategori, $long, $lat)->result();
        $condition = array(
            'no_telepon' => $dec_data->no_telepon,
            'status' => '1'
        );
        $cek_login = $this->Pelanggan_model->get_data_pelanggan($condition);
        if ($cek_login->num_rows() > 0) {
            $message = array(
                'code' => '200',
                'message' => 'success',

                'merchantbykategori' => $merchantbykategori
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

    public function allmerchant_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);


        $fitur = $dec_data->fitur;
        $kategorymerchant = $this->Pelanggan_model->kategorymerchantbyfitur($fitur)->result();
        $long = $dec_data->longitude;
        $lat = $dec_data->latitude;

        $allmerchantnearby = $this->Pelanggan_model->allmerchantnearby($long, $lat, $fitur)->result();
        $condition = array(
            'no_telepon' => $dec_data->no_telepon,
            'status' => '1'
        );
        $cek_login = $this->Pelanggan_model->get_data_pelanggan($condition);

        if ($cek_login->num_rows() > 0) {
            $message = array(
                'code' => '200',
                'message' => 'success',

                'kategorymerchant' => $kategorymerchant,
                'allmerchantnearby' => $allmerchantnearby


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

    public function allmerchantbykategori_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);


        $fitur = $dec_data->fitur;

        $long = $dec_data->longitude;
        $lat = $dec_data->latitude;
        $kategori = $dec_data->kategori;
        $allmerchantnearbybykategori = $this->Pelanggan_model->allmerchantnearbybykategori($long, $lat, $fitur, $kategori)->result();
        $condition = array(
            'no_telepon' => $dec_data->no_telepon,
            'status' => '1'
        );
        $cek_login = $this->Pelanggan_model->get_data_pelanggan($condition);

        if ($cek_login->num_rows() > 0) {
            $message = array(
                'code' => '200',
                'message' => 'success',


                'allmerchantnearby' => $allmerchantnearbybykategori


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

    public function searchmerchant_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        $like = $dec_data->like;
        $long = $dec_data->longitude;
        $lat = $dec_data->latitude;
        $fitur = $dec_data->fitur;
        $searchmerchantnearby = $this->Pelanggan_model->searchmerchantnearby($like, $long, $lat, $fitur);
        $condition = array(
            'no_telepon' => $dec_data->no_telepon,
            'status' => '1'
        );
        $cek_login = $this->Pelanggan_model->get_data_pelanggan($condition);

        if ($cek_login->num_rows() > 0) {
            $message = array(
                'code' => '200',
                'message' => 'success',


                'allmerchantnearby' => $searchmerchantnearby


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

    public function merchantbyid_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        $idmerchant = $dec_data->idmerchant;
        $long = $dec_data->longitude;
        $lat = $dec_data->latitude;

        $merchantbyid = $this->Pelanggan_model->merchantbyid($idmerchant, $long, $lat)->row();
        $itemstatus = $this->Pelanggan_model->itemstatus($idmerchant)->row();
        if (empty($itemstatus->status_promo)) {
            $itempromo = '0';
        } else {
            $itempromo = $itemstatus->status_promo;
        }


        $itembyid = $this->Pelanggan_model->itembyid($idmerchant)->Result();
        $kategoriitem = $this->Pelanggan_model->kategoriitem($idmerchant)->Result();

        $condition = array(
            'no_telepon' => $dec_data->no_telepon,
            'status' => '1'
        );
        $cek_login = $this->Pelanggan_model->get_data_pelanggan($condition);

        if ($cek_login->num_rows() > 0) {

            $message = array(
                'code'              => '200',
                'message'           => 'success',
                'idfitur'           => $merchantbyid->id_fitur,
                'idmerchant'        => $merchantbyid->id_merchant,
                'namamerchant'      => $merchantbyid->nama_merchant,
                'alamatmerchant'    => $merchantbyid->alamat_merchant,
                'latmerchant'       => $merchantbyid->latitude_merchant,
                'longmerchant'      => $merchantbyid->longitude_merchant,
                'bukamerchant'      => $merchantbyid->jam_buka,
                'tutupmerchant'     => $merchantbyid->jam_tutup,
                'descmerchant'      => $merchantbyid->deskripsi_merchant,
                'fotomerchant'      => $merchantbyid->foto_merchant,
                'telpcmerchant'     => $merchantbyid->telepon_merchant,
                'distance'          => $merchantbyid->distance,
                'partner'           => $merchantbyid->partner,
                'kategori'          => $merchantbyid->nama_kategori,
                'promo'             => $itempromo,
                'itembyid'          => $itembyid,
                'kategoriitem'      => $kategoriitem


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

    public function itembykategori_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        $idmerchant = $dec_data->id;

        $itemk = $dec_data->kategori;
        $itembykategori = $this->Pelanggan_model->itembykategori($idmerchant, $itemk)->result();

        $condition = array(
            'no_telepon' => $dec_data->no_telepon,
            'status' => '1'
        );
        $cek_login = $this->Pelanggan_model->get_data_pelanggan($condition);

        if ($cek_login->num_rows() > 0) {

            $message = array(
                'code'              => '200',
                'message'           => 'success',
                'itembyid'          => $itembykategori


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



    function rate_driver_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);


        $data_rate = array();

        if ($dec_data->catatan == "") {
            $data_rate = array(
                'id_pelanggan' => $dec_data->id_pelanggan,
                'id_driver' => $dec_data->id_driver,
                'rating' => $dec_data->rating,
                'id_transaksi' => $dec_data->id_transaksi
            );
        } else {
            $data_rate = array(
                'id_pelanggan' => $dec_data->id_pelanggan,
                'id_driver' => $dec_data->id_driver,
                'rating' => $dec_data->rating,
                'id_transaksi' => $dec_data->id_transaksi,
                'catatan' => $dec_data->catatan
            );
        }

        $finish_transaksi = $this->Pelanggan_model->rate_driver($data_rate);

        if ($finish_transaksi) {
            $message = array(
                'message' => 'success',
                'data' => []
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

    public function topupstripe_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $name = $dec_data->name;
        $email = $dec_data->email;
        $card_num = $dec_data->card_num;
        $card_cvc = $dec_data->cvc;
        $card_exp = explode("/", $dec_data->expired);

        $product = $dec_data->product;
        $number = $dec_data->number;
        $price = $dec_data->price;

        $iduser = $dec_data->id;

        //include Stripe PHP library
        require_once APPPATH . "third_party/stripe/init.php";

        //set api key
        $app_settings = $this->Pelanggan_model->get_settings();
        foreach ($app_settings as $item) {
            $stripe = array(
                "secret_key"      => $item['stripe_secret_key'],
                "publishable_key" => $item['stripe_published_key']
            );

            if ($item['stripe_status'] == '1') {
                \Stripe\Stripe::setApiKey($stripe['secret_key']);
            } else if ($item['stripe_status'] == '2') {
                \Stripe\Stripe::setApiKey($stripe['publishable_key']);
            } else {
                \Stripe\Stripe::setApiKey("");
            }
        }

        $tokenstripe = \Stripe\Token::create([
            'card' => [
                'number' => $card_num,
                'exp_month' => $card_exp[0],
                'exp_year' => $card_exp[1],
                'cvc' => $card_cvc,
            ],
        ]);


        if (!empty($tokenstripe['id'])) {

            //add customer to stripe
            $customer = \Stripe\Customer::create(array(
                'email' => $email,
                'source' => $tokenstripe['id']
            ));

            //item information
            $itemName = $product;
            $itemNumber = $number;
            $itemPrice = $price;
            $currency = "usd";
            $orderID = "INV-" . time();

            //charge a credit or a debit card
            $charge = \Stripe\Charge::create(array(
                'customer' => $customer->id,
                'amount'   => $itemPrice,
                'currency' => $currency,
                'description' => $itemNumber,
                'metadata' => array(
                    'item_id' => $itemNumber
                )
            ));

            //retrieve charge details
            $chargeJson = $charge->jsonSerialize();

            //check whether the charge is successful
            if ($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1) {
                //order details 
                $amount = $chargeJson['amount'];
                $balance_transaction = $chargeJson['balance_transaction'];
                $currency = $chargeJson['currency'];
                $status = $chargeJson['status'];
                $date = date("Y-m-d H:i:s");

                $datatopup = array(
                    'id_user' => $iduser,
                    'rekening' => $card_num,
                    'bank' => 'stripe',
                    'nama_pemilik' => $name,
                    'type' => 'topup',
                    'jumlah' => $chargeJson['amount'],
                    'status' => 1
                );

                if ($status == 'succeeded') {
                    $topupdata = $this->Pelanggan_model->insertwallet($datatopup);
                    $saldolama = $this->Pelanggan_model->saldouser($iduser);
                    $saldobaru = $saldolama->row('saldo') + $itemPrice;
                    $saldo = array('saldo' => $saldobaru);
                    $this->Pelanggan_model->tambahsaldo($iduser, $saldo);

                    $message = array(
                        'code' => '200',
                        'message' => 'success',
                        'data' => []
                    );
                    $this->response($message, 200);
                } else {
                    $message = array(
                        'code' => '201',
                        'message' => 'error',
                        'data' => []
                    );
                    $this->response($message, 200);
                }
            } else {
                $message = array(
                    'code' => '202',
                    'message' => 'error',
                    'data' => []
                );
                $this->response($message, 200);
            }
        } else {
            echo "Invalid Token";
            $statusMsg = "";
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
        $check_exist = $this->Pelanggan_model->check_exist($email, $phone);

        if ($check_exist) {
            $this->Pelanggan_model->insertwallet($datatopup);
            $saldolama = $this->Pelanggan_model->saldouser($iduser);
            $saldobaru = $saldolama->row('saldo') + $amount;
            $saldo = array('saldo' => $saldobaru);
            $this->Pelanggan_model->tambahsaldo($iduser, $saldo);

            $message = array(
                'code' => '200',
                'message' => 'success',
                'data' => []
            );
            $this->response($message, 200);
        } else {
            $message = array(
                'code' => '201',
                'message' => 'You have insufficient balance',
                'data' => []
            );
            $this->response($message, 200);
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
        $card = $dec_data->card;
        $email = $dec_data->email;
        $phone = $dec_data->no_telepon;

        $saldolama = $this->Pelanggan_model->saldouser($iduser);
        $datawithdraw = array(
            'id_user' => $iduser,
            'rekening' => $card,
            'bank' => $bank,
            'nama_pemilik' => $nama,
            'type' => $dec_data->type,
            'jumlah' => $amount,
            'status' => 0
        );
        $check_exist = $this->Pelanggan_model->check_exist($email, $phone);

        if ($dec_data->type ==  "topup") {
            $withdrawdata = $this->Pelanggan_model->insertwallet($datawithdraw);

            $message = array(
                'code' => '200',
                'message' => 'success',
                'data' => []
            );
            $this->response($message, 200);
        } else {

            if ($saldolama->row('saldo') >= $amount && $check_exist) {
                $withdrawdata = $this->Pelanggan_model->insertwallet($datawithdraw);

                $message = array(
                    'code' => '200',
                    'message' => 'success',
                    'data' => []
                );
                $this->response($message, 200);
            } else {
                $message = array(
                    'code' => '201',
                    'message' => 'You have insufficient balance',
                    'data' => []
                );
                $this->response($message, 200);
            }
        }
    }

    function pricecard_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $long = $dec_data->longitude;
        $lat = $dec_data->latitude;
        //$near = $this->Pelanggan_model->get_driver_ride($dec_data->latitude, $dec_data->longitude, $dec_data->fitur);
        $point = $lat.",".$long;
        $area = $this->Pelanggan_model->getarea($point);
        $pricecards = $this->Pelanggan_model->pricecardbyid($area, $dec_data->fitur);
        $message = $pricecards;
        $this->response($message, 200);
    }
    function list_ride_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $long = $dec_data->longitude;
        $lat = $dec_data->latitude;
        $near = $this->Pelanggan_model->get_driver_ride($dec_data->latitude, $dec_data->longitude, $dec_data->fitur);
        $point = $lat.",".$long;
        $area = $this->Pelanggan_model->getarea($point);
        $pricecards = $this->Pelanggan_model->pricecardbyid($area, $dec_data->fitur);
        $message = array(
            'data' => $near->result(),
            'pricecard' => array($pricecards)
        );
        $this->response($message, 200);
    }

    function list_bank_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $near = $this->Pelanggan_model->listbank();
        $message = array(
            'data' => $near->result()
        );
        $this->response($message, 200);
    }

    function list_car_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        
        $near = $this->Pelanggan_model->get_driver_car($dec_data->latitude, $dec_data->longitude, $dec_data->fitur);
        $message = array(
            'data' => $near->result()
        );
        $this->response($message, 200);
    }

    function detail_fitur_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        $area = $dec_data->area;
        $app_settings = $this->Pelanggan_model->get_settings();
        $biaya = $this->Pelanggan_model->get_biaya($area);
        foreach ($app_settings as $item) {
            $message = array(
                'data' => $biaya,
                'currency' => $item['app_currency'],
            );
            $this->response($message, 200);
        }
    }

    function request_transaksi_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        } else {
            $cek = $this->Pelanggan_model->check_banned_user($_SERVER['PHP_AUTH_USER']);
            if ($cek) {
                $message = array(
                    'message' => 'fail',
                    'data' => 'Status User Banned'
                );
                $this->response($message, 200);
            }
        }
        $dataid = $this->Dashboard_model->getidlast();
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $lat = $dec_data->start_latitude;
        $long = $dec_data->start_longitude;
        $point = $lat.",".$long;
        $area = $this->Pelanggan_model->getarea($point);
        $pricecards = $this->Pelanggan_model->pricecardbyid($area, $dec_data->order_fitur);
        
        
        if($dec_data->nowlater == 1){
            $waktuorder = date('Y-m-d H:i:s');
        } else if($dec_data->nowlater == 2){
            $waktuorder = $dec_data->waktujemput;
        }
        
        $data_req = array(
            'staff'                         => "",
            'id_order'                      => time(),
            'now_later'                     => $dec_data->nowlater,
            'id_pelanggan'                  => $dec_data->id_pelanggan,
            'order_fitur'                   => $dec_data->order_fitur,
            'start_latitude'                => $dec_data->start_latitude,
            'start_longitude'               => $dec_data->start_longitude,
            'end_latitude'                  => $dec_data->end_latitude,
            'end_longitude'                 => $dec_data->end_longitude,
            'jarak'                         => $dec_data->jarak,
            'harga'                         => $dec_data->harga,
            'estimasi_time'                 => $dec_data->estimasi,
            'waktu_order'                   => $waktuorder,
            'now_later'                     => $dec_data->nowlater,
            'alamat_asal'                   => $dec_data->alamat_asal,
            'alamat_tujuan'                 => $dec_data->alamat_tujuan,
            'biaya_akhir'                   => $dec_data->harga,
            'kredit_promo'                  => $dec_data->kredit_promo,
            'region_code'                   => $area,
            'pakai_wallet'                  => $dec_data->pakai_wallet
        );

        $ha = 0;
        $kreditamuont = explode(".", $dec_data->kredit_promo);
        $ha  = $dec_data->harga - $kreditamuont[0];
        if ($ha <= 0) {
            $ha = 0;
        }
        $kredit_promo= $kreditamuont[0];
        $biaya_akhir = $ha;
        $fare = $biaya_akhir - $pricecards['surge'];
        $ce =  $fare * $pricecards['fee_company'] / 100;
        $de = $fare - $ce;
        $deductdriver = $ce + $pricecards['surge'] ;
        if($dec_data->pakai_wallet==1){
            $cp=0;
            $op=$biaya_akhir;
        }elseif($dec_data->pakai_wallet==0){
            $cp=$biaya_akhir;
            $op=0;
        }       

        $data_jurnal = array(
            'sub_total_before_discount'             => $dec_data->harga,
            'base_fare'                             => $pricecards['base_fare'],
            'distance'                              => $dec_data->harga - $pricecards['base_fare'] - $pricecards['surge'],
            'surge_amount'                          => $pricecards['surge'],
            'tawar'                                 => 0-$kredit_promo,
            'cash_payment'                          => $cp,
            'online_payment'                        => $op,
            'customer_paid_amount'                  => $biaya_akhir,
            'company_earning'                       => $ce,
            'driver_earning'                        => $de,
            'amount_deducted_from_driver_wallet'    => $deductdriver,
            'driver_total_payout_amount'            => $de,
            'created_at'                            => date('Y-m-d H:i:s')
        );
        
        $biayand = number_format($biaya_akhir / 100, 2, ".", ".");
            
        $request = $this->Pelanggan_model->insert_transaksi($data_req, $data_jurnal, $dec_data->nowlater == 1 ? 1 : 0 );
        
        
        
        if ($request['status']) {
            if($dec_data->nowlater == 2){
                $data_notif = array(
                    "alamat_asal"   => $dec_data->alamat_asal,
                    "alamat_tujuan" => $dec_data->alamat_tujuan,
                    "estimasi_time" => $dec_data->estimasi,
                    "distance"      => $dec_data->jarak . " KM",
                    "biaya"         => "Rp " . $biayand  ,
                    "harga"         => $biaya_akhir,
                    "id_transaksi"  => $request['idtransaksi'],
                    "layanan"       => "RideLater",
                    "layanandesc"   => date('Y-m-d H:i:s'),
                    "order_fitur"   => $dec_data->order_fitur,
                    "pakai_wallet"  => $dec_data->pakai_wallet,
                    "bridging"      => 2,
                    "type"          => 1,
                );
                $this->notification->send_notif_request_order_bytopic(keyfcm, $data_notif, $area);
            } 
            
            $message = array(
                'message' => 'success',
                'data' => $request['data']
            );
            $this->response($message, 200);
        } else {
            $message = array(
                'message' => 'fail',
                'data' => $request['data']
            );
            $this->response($message, 200);
        }
    }

    function check_status_transaksi_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $dataTrans = array(
            'id_transaksi' => $dec_data->id_transaksi
        );

        $getStatus = $this->Pelanggan_model->check_status($dataTrans);
        $this->response($getStatus, 200);
    }

    function user_cancel_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

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

    function liat_lokasi_driver_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        $getLoc = $this->Pelanggan_model->get_driver_location($dec_data->id);
        $message = array(
            'status' => true,
            'data' => $getLoc->result()
        );
        $this->response($message, 200);
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
        $gettrans = $this->Pelanggan_model->transaksi($dec_data->id);
        $getdriver = $this->Pelanggan_model->detail_driver($dec_data->id_driver);
        $getitem = $this->Pelanggan_model->detail_item($dec_data->id);

        $message = array(
            'status' => true,
            'data' => $gettrans->result(),
            'driver' => $getdriver->result(),
            'item' => $getitem->result(),

        );
        $this->response($message, 200);
    }

    function detail_berita_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        $getberita = $this->Pelanggan_model->beritadetail($dec_data->id);
        $message = array(
            'status' => true,
            'data' => $getberita->result()
        );
        $this->response($message, 200);
    }

    function all_berita_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        $getberita = $this->Pelanggan_model->allberita();
        $message = array(
            'status' => true,
            'data' => $getberita
        );
        $this->response($message, 200);
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
        $check_exist_phone = $this->Pelanggan_model->check_exist_phone_edit($decoded_data->id, $decoded_data->no_telepon);
        $check_exist_email = $this->Pelanggan_model->check_exist_email_edit($decoded_data->id, $decoded_data->email);
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

            if ($decoded_data->fotopelanggan == null && $decoded_data->fotopelanggan_lama == null) {
                $datauser = array(
                    'fullnama' => $decoded_data->fullnama,
                    'no_telepon' => $decoded_data->no_telepon,
                    'phone' => $decoded_data->phone,
                    'email' => $decoded_data->email,
                    'countrycode' => $decoded_data->countrycode,
                    'tgl_lahir' => $decoded_data->tgl_lahir
                );
            } else {
                $image = $decoded_data->fotopelanggan;
                $namafoto = time() . '-' . rand(0, 99999) . ".jpg";
                $path = "images/pelanggan/" . $namafoto;
                file_put_contents($path, base64_decode($image));

                $foto = $decoded_data->fotopelanggan_lama;
                $path = "./images/pelanggan/$foto";
                unlink("$path");


                $datauser = array(
                    'fullnama' => $decoded_data->fullnama,
                    'no_telepon' => $decoded_data->no_telepon,
                    'phone' => $decoded_data->phone,
                    'email' => $decoded_data->email,
                    'fotopelanggan' => $namafoto,
                    'countrycode' => $decoded_data->countrycode,
                    'tgl_lahir' => $decoded_data->tgl_lahir
                );
            }


            $cek_login = $this->Pelanggan_model->get_data_pelanggan($condition2);
            if ($cek_login->num_rows() > 0) {
                $upd_user = $this->Pelanggan_model->edit_profile($datauser, $decoded_data->no_telepon_lama);
                $getdata = $this->Pelanggan_model->get_data_pelanggan($condition);
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

    function wallet_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);
        $getWallet = $this->Pelanggan_model->getwallet($decoded_data->id);
        $message = array(
            'status' => true,
            'data' => $getWallet->result(),
        );
        $this->response($message, 200);
    }

    function wallettrx_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }
        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);
        $getWallet = $this->Pelanggan_model->getwallettrx($decoded_data->id);
        $message = array(
            'status' => true,
            'data' => $getWallet->result()
        );
        $this->response($message, 200);
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
        $getWallet = $this->Pelanggan_model->all_transaksi($decoded_data->id);
        $message = array(
            'status' => true,
            'data' => $getWallet->result()
        );
        $this->response($message, 200);
    }

    function request_transaksi_send_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        } else {
            $cek = $this->Pelanggan_model->check_banned_user($_SERVER['PHP_AUTH_USER']);
            if ($cek) {
                $message = array(
                    'message' => 'fail',
                    'data' => 'Status User Banned'
                );
                $this->response($message, 200);
            }
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $lat = $dec_data->start_latitude;
        $long = $dec_data->start_longitude;
        $point = $lat.",".$long;
        $area = $this->Pelanggan_model->getarea($point);
        $pricecards = $this->Pelanggan_model->pricecardbyid($area, $dec_data->order_fitur);

        $data_req = array(
            'id_pelanggan' => $dec_data->id_pelanggan,
            'order_fitur' => $dec_data->order_fitur,
            'start_latitude' => $dec_data->start_latitude,
            'start_longitude' => $dec_data->start_longitude,
            'end_latitude' => $dec_data->end_latitude,
            'end_longitude' => $dec_data->end_longitude,
            'jarak' => $dec_data->jarak,
            'harga' => $dec_data->harga,
            'estimasi_time' => $dec_data->estimasi,
            'waktu_order' => date('Y-m-d H:i:s'),
            'alamat_asal' => $dec_data->alamat_asal,
            'alamat_tujuan' => $dec_data->alamat_tujuan,
            'biaya_akhir' => $dec_data->harga,
            'kredit_promo' => $dec_data->kredit_promo,
            'region_code' => $area,
            'pakai_wallet' => $dec_data->pakai_wallet
        );


        $dataDetail = array(
            'nama_pengirim' => $dec_data->nama_pengirim,
            'telepon_pengirim' => $dec_data->telepon_pengirim,
            'nama_penerima' => $dec_data->nama_penerima,
            'telepon_penerima' => $dec_data->telepon_penerima,
            'nama_barang' => $dec_data->nama_barang
        );

        $ha = 0;
        $kreditamuont = explode(".", $dec_data->kredit_promo);
        $ha  = $dec_data->harga - $kreditamuont[0];
        if ($ha <= 0) {
            $ha = 0;
        }
        $kredit_promo= $kreditamuont[0];
        $biaya_akhir = $ha;
        $fare = $biaya_akhir - $pricecards['surge'];
        $ce =  $fare * $pricecards['fee_company'] / 100;
        $de = $fare - $ce;
        $deductdriver = $ce + $pricecards['surge'] ;
        if($dec_data->pakai_wallet==1){
            $cp=0;
            $op=$biaya_akhir;
        }elseif($dec_data->pakai_wallet==0){
            $cp=$biaya_akhir;
            $op=0;
        }       

        $data_jurnal = array(
            'sub_total_before_discount'             => $dec_data->harga,
            'base_fare'                             => $pricecards['base_fare'],
            'distance'                              => $dec_data->harga - $pricecards['base_fare'] - $pricecards['surge'],
            'surge_amount'                          => $pricecards['surge'],
            'tawar'                                 => 0-$kredit_promo,
            'cash_payment'                          => $cp,
            'online_payment'                        => $op,
            'customer_paid_amount'                  => $biaya_akhir,
            'company_earning'                       => $ce,
            'driver_earning'                        => $de,
            'amount_deducted_from_driver_wallet'    => $deductdriver,
            'driver_total_payout_amount'            => $de,
            'created_at'                            => date('Y-m-d H:i:s')
        );

        $request = $this->Pelanggan_model->insert_transaksi_send($data_req, $dataDetail, $data_jurnal);
        if ($request['status']) {
            $message = array(
                'message' => 'success',
                'data' => $request['data']->result()
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
        $cek_login = $this->Pelanggan_model->get_data_pelanggan($condition);
        $message = array();

        if ($cek_login->num_rows() > 0) {
            $upd_regid = $this->Pelanggan_model->edit_profile($reg_id, $decoded_data->no_telepon);
            $get_pelanggan = $this->Pelanggan_model->get_data_pelanggan($condition2);

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

    function alldriver_get($id)
    {
        $near = $this->Pelanggan_model->get_driver_location_admin();
        $message = array(
            'data' => $near->result()
        );
        $this->response($message, 200);
    }

    function alldrivercar_get($id)
    {
        $near = $this->Pelanggan_model->get_driver_location_admin_car();
        $message = array(
            'data' => $near->result()
        );
        $this->response($message, 200);
    }

    function alldriverbike_get($id)
    {
        $near = $this->Pelanggan_model->get_driver_location_admin_bike();
        $message = array(
            'data' => $near->result()
        );
        $this->response($message, 200);
    }

    function alltransactionpickup_get()
    {
        $near = $this->Pelanggan_model->getAlltransaksipickup();
        $message = array(
            'data' => $near->result()
        );
        $this->response($message, 200);
    }

    function alltransactiondestination_get()
    {
        $near = $this->Pelanggan_model->getAlltransaksidestination();
        $message = array(
            'data' => $near->result()
        );
        $this->response($message, 200);
    }

    function alltransactionpickupbike_get()
    {
        $near = $this->Pelanggan_model->getAlltransaksipickupbike();
        $message = array(
            'data' => $near->result()
        );
        $this->response($message, 200);
    }

    function alltransactiondestinationbike_get()
    {
        $near = $this->Pelanggan_model->getAlltransaksidestinationbike();
        $message = array(
            'data' => $near->result()
        );
        $this->response($message, 200);
    }


    function inserttransaksimerchant_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        } else {
            $cek = $this->Pelanggan_model->check_banned_user($_SERVER['PHP_AUTH_USER']);
            if ($cek) {
                $message = array(
                    'message' => 'fail',
                    'data' => 'Status User Banned'
                );
                $this->response($message, 200);
            }
        }

        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);

        $data_transaksi = array(
            'id_pelanggan'      => $dec_data->id_pelanggan,
            'order_fitur'       => $dec_data->order_fitur,
            'start_latitude'    => $dec_data->start_latitude,
            'start_longitude'   => $dec_data->start_longitude,
            'end_latitude'      => $dec_data->end_latitude,
            'end_longitude'     => $dec_data->end_longitude,
            'jarak'             => $dec_data->jarak,
            'harga'             => $dec_data->harga,
            'waktu_order'       => date('Y-m-d H:i:s'),
            'estimasi_time'     => $dec_data->estimasi,
            'alamat_asal'       => $dec_data->alamat_asal,
            'alamat_tujuan'     => $dec_data->alamat_tujuan,
            'kredit_promo'      => $dec_data->kredit_promo,

            'pakai_wallet'      => $dec_data->pakai_wallet,
        );
        $total_belanja = [
            'total_belanja'     => $dec_data->total_biaya_belanja,
        ];



        $dataDetail = [
            'id_merchant'   => $dec_data->id_resto,
            'total_biaya'   => $dec_data->total_biaya_belanja,
            'struk'   => rand(0, 9999),

        ];



        $result = $this->Pelanggan_model->insert_data_transaksi_merchant($data_transaksi, $dataDetail, $total_belanja);

        if ($result['status'] == true) {


            $pesanan = $dec_data->pesanan;

            foreach ($pesanan as $pes) {
                $item[] = [
                    'catatan_item' => $pes->catatan,
                    'id_item' => $pes->id_item,
                    'id_merchant' => $dec_data->id_resto,
                    'id_transaksi' => $result['id_transaksi'],
                    'jumlah_item' => $pes->qty,
                    'total_harga' => $pes->total_harga,
                ];
            }

            $request = $this->Pelanggan_model->insert_data_item($item);

            if ($request['status']) {
                $message = array(
                    'message' => 'success',
                    'data' => $result['data'],


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
            $message = array(
                'message' => 'fail',
                'data' => []

            );
            $this->response($message, 200);
        }
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////


}
