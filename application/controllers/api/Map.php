<?php
//'tes' => number_format(200 / 100, 2, ",", "."),
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Map extends REST_Controller
{

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
    header('Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding');
    header('Access-Control-Allow-Credentials: *');
     if ($_SERVER['REQUEST_METHOD'] === "OPTIONS") {
   die();
 }
        parent::__construct();
        
        $this->load->helper("url");
        $this->load->database();
        $this->load->model('Notification_model', 'notification'); 
        $this->load->model('Finance_model', 'finance');
        $this->load->model('wallet_model', 'wallet');
        $this->load->model('Pelanggan_model');
         $this->load->model('Map_model', 'map');
        date_default_timezone_set('Asia/Jakarta');
    }

    function index_get()
    {
       
        $this->response("Api for Smartrans!", 200);
    }
    function insert_post()
      {
        $data = file_get_contents("php://input");
        $dec_data = json_decode($data);
        if($dec_data->nowlater == 1){
            $waktuorder = date('Y-m-d H:i:s');
        } else if($dec_data->nowlater == 2){
            $waktuorder = $dec_data->waktujemput;
        }
        $check_exist_phone = $this->Pelanggan_model->check_exist_phone($dec_data->phone);
        if ($check_exist_phone == false ) {
                $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $reffx =  substr(str_shuffle($permitted_chars), 0, 5);
                $cekreff = $this->Pelanggan_model->check_reff($reffx);
                if($cekreff == true){
                    $reff = $reffx;
                }else{
                    $reff = $cekreff;
                }
                $data_signup = array(
                    'id' => 'P' . time(),
                    'fullnama' => $dec_data->fullnama,
                    'email' => $dec_data->email,
                    'no_telepon' => $dec_data->phone,
                    'phone' => $dec_data->phone,
                    'upline_id' => "",
                    'reff' => $reff,
                    'password' => sha1(""),
                    'tgl_lahir' => "",
                    'countrycode' => "",
                    'fotopelanggan' => "",
                    'token' => "",
                );
                $signup = $this->Pelanggan_model->signup($data_signup);
            }
        $datapel = $this->Pelanggan_model->getidpelbyphone($dec_data->phone);
        if($datapel==TRUE){
            $iduser = $datapel['id'];
        }
        $data_req = array(
            'staff'                         => "",
            'id_order'                      => time(),
            'now_later'                     => $dec_data->nowlater,
            'id_pelanggan'                  => $iduser,
            'order_fitur'                   => "33",
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
            'region_code'                   => "14",
            'pakai_wallet'                  => $dec_data->pakai_wallet,
            'qr'                            => $this->createQR(time(),$dec_data->harga)
            
        );

        $data_jurnal = array(
            'sub_total_before_discount'             => $dec_data->harga,
            'base_fare'                             => $dec_data->base_fare,
            'distance'                              => $dec_data->distance,
            'surge_amount'                          => $dec_data->surge,
            'tawar'                                 => 0,
            'cash_payment'                          => 0,
            'online_payment'                        => $dec_data->online_payment,
            'customer_paid_amount'                  => $dec_data->customer_paid,
            'company_earning'                       => $dec_data->company_earning,
            'driver_earning'                        => $dec_data->driver_earning,
            'amount_deducted_from_driver_wallet'    => $dec_data->amount_deducted_from_driver_wallet,
            'driver_total_payout_amount'            => $dec_data->driver_total_payout_amount,
            'created_at'                            => date('Y-m-d H:i:s')
        );
            
        $request = $this->Pelanggan_model->insert_transaksi($data_req, $data_jurnal, $dec_data->nowlater == 1 ? 1 : 0 );
        
         $message = array(
                'message' => 'Success',
                'data' => $request['data'][0]
            );
          $this->response($message, 200);
    }
    function harga_get()
    {
    //   $lat1 = $this->input->get('lat1', TRUE);
    //   $lon1 = $this->input->get('lon1', TRUE);
      $area = $this->Pelanggan_model->getarea("-6.1897236,106.8736264");
        $pricecards = $this->Pelanggan_model->pricecardbyid($area, 33);
        $message = (object)$pricecards;
        $this->response($message, 200);
    }
     function poi_get()
    {
       $search = $this->input->get('search', TRUE);
        $poi= $this->map->poi($search);
        $this->response($poi, 200);
    }
     function poisuggestion_get()
    {
       $search = $this->input->get('search', TRUE);
        $poi= $this->map->cari($search);
        $this->response($poi, 200);
    }
    function rute_get()
    {
       $lat1 = $this->input->get('lat1', TRUE);
       $lon1 = $this->input->get('lon1', TRUE);
       $lat2 = $this->input->get('lat2', TRUE);
       $lon2 = $this->input->get('lon2', TRUE);
        $poi= $this->map->rute($lat1,$lon1,$lat2,$lon2);
        $this->response($poi, 200);
    }
    
    function createQR($id,$amount){
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://38.47.180.198/api.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_POSTFIELDS =>  'amount='.($amount/100).'&id='.$id,
        CURLOPT_HTTPHEADER => array(
          'Content-Type: application/x-www-form-urlencoded'
        ),
      ));
  
       $response =  json_decode(curl_exec($curl),true);
      curl_close($curl);
          return $response["responddata"]["data_qr"];
}
}