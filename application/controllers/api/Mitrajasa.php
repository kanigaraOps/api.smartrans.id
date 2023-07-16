<?php
//'tes' => number_format(200 / 100, 2, ",", "."),
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class MItrajasa extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        
        $this->load->helper("url");
        $this->load->database();
        $this->load->model('Mitrajasa_model');
        $this->load->model('Mitrajasa_model');
        $this->load->model('Pelanggan_model');
        $this->load->model('Dashboard_model');
        $this->load->model('wallet_model', 'wallet'); 
        $this->load->model('Flip_model', 'flip'); 
        date_default_timezone_set('Asia/Jakarta');
    }

    function index_get()
    {
        $this->response("Api for Smartrans!", 200);
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

        $job = $this->Mitrajasa_model->get_job();

        $message = array(
            'code' => '200',
            'message' => 'found',
            'data' => $job
        );
        $this->response($message, 200); 
    }

    function jobservices_post()
    {

        $jobservices = $this->Mitrajasa_model->get_job_services();

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

        $check_banned = $this->Mitrajasa_model->check_banned($decoded_data->no_telepon);
        
        if ($check_banned) {
            $message = array(
                'message' => 'banned',
                'data' => []
            );
            $this->response($message, 200);
        } else {
            $cek_login = $this->Mitrajasa_model->get_data_pelanggan($condition);
            $message = array();

            if ($cek_login->num_rows() > 0) {
                $upd_regid = $this->Mitrajasa_model->edit_profile($reg_id, $decoded_data->no_telepon);
                $get_pelanggan = $this->Mitrajasa_model->get_data_pelanggan($condition);
                $this->Mitrajasa_model->edit_status_login($decoded_data->no_telepon);
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
        $ins = $this->Mitrajasa_model->my_location($data);

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
        $cek_login = $this->Mitrajasa_model->get_data_driver($condition);

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

        $logout = $this->Mitrajasa_model->logout($dataEdit, $decoded_data->id);
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
        $getDataDriver = $this->Mitrajasa_model->get_data_driver_sync($dec_data->id);
        $condition = array(
            'no_telepon' => $dec_data->no_telepon
        );
        $cek_login = $this->Mitrajasa_model->get_data_pelanggan($condition);
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

                    $getTrans = $this->Mitrajasa_model->change_status_driver($dec_data->id, $stat);
                    $message = array(
                        'message' => 'success',
                        'driver_status' => $stat,
                        'data_driver' => $getDataDriver['data_driver']->result(),
                        'data_transaksi' => $getDataDriver['status_order']->result(),
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
                        'payu' => $payu
                    );
                    $this->response($message, 200);
                } else {
                    $this->Mitrajasa_model->change_status_driver($dec_data->id, 1);
                    $message = array(
                        'message' => 'success',
                        'driver_status' => 1,
                        'data_driver' => $getDataDriver['data_driver']->result(),
                        'data_transaksi' => [],
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
                        'payu' => $payu
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
            $upd_regid = $this->Mitrajasa_model->edit_config($dataEdit, $dec_data->id);
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
                'status' => 4
            );
            $upd_regid = $this->Mitrajasa_model->edit_config($dataEdit, $dec_data->id);
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
        $waktu_skr = date('Y-m-d h:i:s');
        $tenggang = strtotime($waktu_order) - strtotime($waktu_skr);
        if( $tenggang < 7200) {
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
            $this->Mitrajasa_model->delete_chat($cancel_req['iddriver'], $cancel_req['idpelanggan']);
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
        //$this->response($tenggang, 200);
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

        $tes = $this->Dashboard_model->gettransaksibyid($dec_data->id_transaksi);
        $harga = $tes['harga'];
        $region_code = $tes['region_code'];
        $notes = $tes['notes'];
        $xpander=strpos($notes,"Xpander");
        $innova=strpos($notes,"Innova");

        if($harga >= 9000000 && $region_code == 11){  
            if($xpander){ 
                $id_driver = $dec_data->id;
            } else if($innova){ 
                $id_driver = $dec_data->id; 
            }else {
                $id_driver = 'D1605962742'; 
            }    
        } /*elseif($harga < 1100000 && $harga >= 900000 && $region_code == 11){ 
            if($xpander){ 
                $id_driver = $dec_data->id; 
            } else if($innova){ 
                $id_driver = $dec_data->id;
            }else {
                $id_driver = 'D0000000445'; 
            }    
        } */else {
            $id_driver = $dec_data->id;   
        }
        
        $data_req = array(
            'id_driver' => $id_driver,
            'id_transaksi' => $dec_data->id_transaksi
        );

        $condition = array(
            'id_driver' => $dec_data->id, 
            'status' => '1'
        );

        $cek_login = $this->Mitrajasa_model->get_status_driver($condition);
        if ($cek_login->num_rows() > 0) {

            $acc_req = $this->Mitrajasa_model->accept_request($data_req);
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

        $acc_req = $this->Mitrajasa_model->start_request($data_req);
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

        $data_req = array(
            'id_driver' => $dec_data->id,
            'id_transaksi' => $dec_data->id_transaksi
        );

        $data_tr = array(
            'id_driver' => $dec_data->id,
            'id' => $dec_data->id_transaksi
        );

        $finish_transaksi = $this->Mitrajasa_model->finish_request($data_req, $data_tr);
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
            $gettranslater =$this->Mitrajasa_model->transaksidrv($dec_data->id);
        
            if ($gettranslater->id == $dec_data->id) {
                if($dec_data->status =="Terima"){
                    $sl = 12;
                    $getdriver = $this->Mitrajasa_model->edit_statuslater($dec_data->id, $dec_data->driverid  ,$sl);
                } 
            } elseif ($dec_data->status =="Tiba"){
                $sl = 2;
                $getdriver = $this->Mitrajasa_model->edit_statuslater($dec_data->id, $dec_data->driverid ,$sl);
            } elseif ($dec_data->status =="Batal"){
                if($dec_data->driverid == 'D1605962742'){
                    $sl = 0; 
                        $getdriver = $this->Mitrajasa_model->edit_statuslater($dec_data->id, $dec_data->driverid ,$sl);
                } else {
                $tes = $this->Dashboard_model->gettransaksibyid($dec_data->id);
                $waktu_order = $tes['waktu_order'];
                $waktu_skr = date('Y-m-d H:i:s');
                $tenggang = strtotime($waktu_order) - strtotime($waktu_skr);
                //var_dump($tenggang);
                    if($tenggang < 7200) {
                        $message = array(
                            'message' => 'cancel failed',
                            'data' => []
                        );
                        $this->response($message, 200); 
                    } else {  
                        $sl = 0; 
                        $getdriver = $this->Mitrajasa_model->edit_statuslater($dec_data->id, $dec_data->driverid ,$sl);
                    }
                } 
            } 
        }

        $gettrans = $this->Pelanggan_model->transaksi($dec_data->id);
        $getdriver = $this->Mitrajasa_model->get_data_pelangganid($dec_data->id_pelanggan);
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
        $dataver = $this->Mitrajasa_model->get_verify($dataverify);
        $cek_login = $this->Mitrajasa_model->get_data_pelanggan($condition);
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
        $check_exist_phone = $this->Mitrajasa_model->check_exist_phone_edit($decoded_data->id, $decoded_data->no_telepon);
        $check_exist_email = $this->Mitrajasa_model->check_exist_email_edit($decoded_data->id, $decoded_data->email);
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
                $path = "images/fotomitrajasa/" . $namafoto;
                file_put_contents($path, base64_decode($image));

                $foto = $decoded_data->fotodriver_lama;
                $path = "./images/fotomitrajasa/$foto";
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


            $cek_login = $this->Mitrajasa_model->get_data_pelanggan($condition2);
            if ($cek_login->num_rows() > 0) {
                $upd_user = $this->Mitrajasa_model->edit_profile($datauser, $decoded_data->no_telepon_lama);
                $getdata = $this->Mitrajasa_model->get_data_pelanggan($condition);
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



        $cek_login = $this->Mitrajasa_model->get_data_pelanggan($condition);
        if ($cek_login->num_rows() > 0) {
            $upd_user = $this->Mitrajasa_model->edit_kendaraan($datakendaraan, $decoded_data->id_kendaraan);
            $getdata = $this->Mitrajasa_model->get_data_pelanggan($condition);
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
        $cek_login = $this->Mitrajasa_model->get_data_pelanggan($condition);
        $message = array();

        if ($cek_login->num_rows() > 0) {
            $upd_regid = $this->Mitrajasa_model->edit_profile($reg_id, $decoded_data->no_telepon);
            $get_pelanggan = $this->Mitrajasa_model->get_data_pelanggan($condition2);

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
        $getWallet = $this->Mitrajasa_model->all_transaksi($decoded_data->id);
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
        $getBook = $this->Mitrajasa_model->book_history($decoded_data->id);
        $message = array(
            'status' => true,
            'data' => $getBook->result()
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
        $cek_login = $this->Mitrajasa_model->get_data_pelanggan($condition);
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
        $check_exist = $this->Mitrajasa_model->check_exist($email, $phone);
        $check_exist_phone = $this->Mitrajasa_model->check_exist_phone($phone);
        $check_exist_email = $this->Mitrajasa_model->check_exist_email($email);
        $check_exist_sim = $this->Mitrajasa_model->check_sim($dec_data->id_sim);
        $check_exist_ktp = $this->Mitrajasa_model->check_ktp($dec_data->no_ktp);
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
                $path = "images/fotomitrajasa/" . $namafoto;
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


                $signup = $this->Mitrajasa_model->signup($data_signup, $data_kendaraan, $data_berkas);
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
        $kodeunik = $digits / 100 ;
        $transfer = $dec_data->amount / 100 ;
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
        $message = 'Transfer dana ke rek BCA 7880559529 - Suskandani sebesar IDR. '.$amount ;
        
        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $noteswd = "WD-".substr(str_shuffle($permitted_chars), 0, 10);
        $notestrxdep = "TRX-DEP-".substr(str_shuffle($permitted_chars), 0, 10);
        $notestopup = "Topup-".substr(str_shuffle($permitted_chars), 0, 10);

        $datatopup = array(
            'id_user' => $iduser,
            'rekening' => $card,
            'bank' => $bank,
            'nama_pemilik' => $nama,
            'type' => $dec_data->type,
            'jumlah' => $jumlah,
            'saldo_awal' => $saldolamax,
            'kode_unik' => $kodeunik,
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
            'bank' => "Transaction Wallet",
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

        $check_exist = $this->Mitrajasa_model->check_exist($email, $phone);

        if ($dec_data->type ==  "topup") {
            $withdrawdata = $this->Pelanggan_model->insertwallet($datatopup);
            $this->wallet->send_notif($title, $message, $topic);

            $message = array(
                'code' => '200',
                'message' => 'success',
                'data' => []
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
                $withdrawdata = $this->Mitrajasa_model->insertwallettrx($datatopuptrxwd);                
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
                if($iduser=='D0000000180'){  
                $withdrawdata = $this->wconfirmtrx($iduser, $amount);  
                } else {
                    $this->Mitrajasa_model->insertwallettrx($datawithdraw);
                    $message = array(
                        'code' => '200',
                        'message' => 'success',
                        'data' => []
                    );
                    $this->response($message, 200); 
                }               

                if($withdrawdata){
                    $this->Mitrajasa_model->insertwallettrx($datawithdrawflip);   
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
                            }
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

        $title = 'Withdraw Success';
        $message = 'Withdraw Has Been Confirmed';
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
        $check_exist = $this->Mitrajasa_model->check_exist($email, $phone);

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
