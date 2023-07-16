<?php
//'tes' => number_format(200 / 100, 2, ",", "."),
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Harga extends REST_Controller
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
        $this->load->model('Harga_model', 'harga');
        date_default_timezone_set('Asia/Jakarta');
    }

    function index_get()
    {
        $this->response("Api for Smartrans!", 200);
    }
    
    function manualdispatch_post()
    {
        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);
        $km = $decoded_data->km;
        $tol = $decoded_data->tol;
        $xc = $decoded_data->xc;
        $harga = $decoded_data->harga;
        $upping = 0;
        $disc = 0;
        
        
        //komponent
        $bf = 70000; //Harga Base Fare
        $pricekm = 4000; //harga dasar /KM
        $surge = 27000; // Surgecharge 
        
        if($km <= 5){
            $distance = 0; // Nominal distance, tercover Base Fare
        } else {
            $distance = $pricekm * ($km-5); // Nominal distance
        } 

        //tawar batas bawah -20%, Batas Atas +50% 
        $hargab4tawar = $bf + $distance + $surge;
        $hargarendah = $hargab4tawar - ($hargab4tawar * 20/100);
        $hargatinggi = $hargab4tawar + ($hargab4tawar * 50/100); 
        
        //Harga Hasil
        $stbd = $bf + $distance; //harga yang akan di deduct
        $stbdsctolxc = $stbd + $surge + $tol + $xc;
        $stbdawal = $stbd;
        $stbdsctolxcawal = $stbdsctolxc;
        
        $x = $harga - $stbdsctolxc;
        if($x > 0){
            $upping = $x;
        } else {
            $disc = $x; 
            $stbd = $bf + $distance + $disc; //harga yang akan di deduct
            $stbdsctolxc = $stbd + $surge + $tol + $xc;
        }
        
        $totalharga = $stbdsctolxc + $upping;
        $customerpaid = $totalharga;
        
        //Pembagian
        $companyearning = $stbd * 20/100;
        $driverdeduct = $surge + $companyearning + $upping;
        $driverearning = $stbd * 80/100;
        $driverpayout = $totalharga - $driverdeduct; 
        
        
        // $result = $this->harga->getjurnal();
        
        $result = array(
                    'km'                        => $km,
                    'pricekm'                   => $pricekm,
                    'bf'                        => $bf,
                    'distance'                  => $distance,
                    'surge'                     => $surge,
                    'tol'                       => $tol,
                    'xc'                        => $xc,
                    'harga'                     => $harga,
                    
                    // 'hargab4tawar'              => $hargab4tawar,
                    // 'hargarendah'               => $hargarendah,
                    // 'hargatinggi'               => $hargatinggi, 
                    
                    'stbdawal'                  => $stbdawal,
                    'stbdsctolxcawal'           => $stbdsctolxcawal,
                    'disc'                      => $disc,
                    'stbd'                      => $stbd,
                    'stbdsctolxc'               => $stbdsctolxc,

                    'upping'                    => $upping,
                    'totalharga'                => $totalharga,
                    'customerpaid'              => $customerpaid,
                    
                    'companyearning'            => $companyearning,
                    'driverearning'             => $driverearning,
                    'driverdeduct'              => $driverdeduct,
                    'driverpayout'              => $driverpayout,
                );  
        
        $this->response($result, 200);
    }
}