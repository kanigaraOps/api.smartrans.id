<?php
//'tes' => number_format(200 / 100, 2, ",", "."),
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Servicex extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        
        $this->load->helper("url");
        $this->load->database();
        $this->load->model('Driver_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    function index_get()
    {
        $this->Driver_model->get_deduct_timer();
        $this->response("dsada", 200);
    }
    
    public function deducttimerx_get()
    {
        $this->Driver_model->get_deduct_timer();  
    }
    
    public function deducttimer()
    {
        $this->Driver_model->get_deduct_timerx();  
    }

}
