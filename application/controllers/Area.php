<?php
defined('BASEPATH') or exit('No direct script access allowed');

class area extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
      
        if ($this->session->userdata('user_name') == NULL && $this->session->userdata('password') == NULL) {
            redirect(base_url() . "login");
        }
        $this->load->model('Appsettings_model', 'app');
        $this->load->model('Dashboard_model', 'dashboard');
        // $this->load->library('form_validation');
    }

    public function index()
    {
        $data['area'] = $this->app->getAllarea();

        $this->load->view('includes/header');
        $this->load->view('area/index', $data);
        $this->load->view('includes/footer');
    }

    
    public function pricecards()
    {
        $data['area'] = $this->app->getAllpricecards();
        $data['currency'] = $this->app->getappbyid();
        $data['transaksi'] = $this->dashboard->getAlltransaksi();
        $data['fitur'] = $this->dashboard->getAllfitur();
        $data['saldo'] = $this->dashboard->getallsaldo();

        $this->load->view('includes/header');
        $this->load->view('area/pricecards', $data);
        $this->load->view('includes/footer');
    }
     public function zonaMovic()
    {
        $data["tarif"]=$this->app->getprice();
       $data["zona"]=$this->app->getzona();
        $this->load->view('includes/header');
        $this->load->view('area/terminal', $data);
        $this->load->view('includes/footer');
    }
    public function tariftravelin()
    {
       $data["zona"]=$this->app->getpricetravelin();
        $this->load->view('includes/header');
        $this->load->view('area/tarifTravellin', $data);
        $this->load->view('includes/footer');
    }
    public function tarifMovic()
    {
       $data["zona"]=$this->app->getprice();
        $this->load->view('includes/header');
        $this->load->view('area/tarif', $data);
        $this->load->view('includes/footer');
    }
     public function tarifMovicBasic()
    {
       $data["zona"]=$this->app->getpriceBasic();
        $this->load->view('includes/header');
        $this->load->view('area/tarifBasic', $data);
        $this->load->view('includes/footer');
    }
    public function detail($id)
    {
        $data=$this->app->getzonaid($id);
        $data["tarif"]=$this->app->getprice();
        $this->load->view('includes/header');
        $this->load->view('area/add_zona',$data);
        $this->load->view('includes/footer');
    }
    public function detailtarif($id)
    {
        $data=$this->app->getpriceid($id);
      
        $this->load->view('includes/header');
        $this->load->view('area/add_price',$data);
        $this->load->view('includes/footer');
    }
    public function detailtariftravelin($id)
    {
        $data=$this->app->getpriceidtravelin($id);
      
        $this->load->view('includes/header');
        $this->load->view('area/add_priceTravellin',$data);
        $this->load->view('includes/footer');
    }
    public function detailtarifbasic($id)
    {
        $data=$this->app->getpriceidbasic($id);
      
        $this->load->view('includes/header');
        $this->load->view('area/add_pricebasic',$data);
        $this->load->view('includes/footer');
    }
    public function addzona()
    {
         if(isset($_POST["add"])){
              $post["nama"]  = html_escape($this->input->post('nama', TRUE));
                 $post["zona"]  = html_escape($this->input->post('zona', TRUE));
                   $post["base_fare"] = html_escape($this->input->post('base_fare', TRUE));
                    $post["km"] =html_escape($this->input->post('km', TRUE));
                    $post["surcharge"]  = html_escape($this->input->post('surcharge', TRUE));
              $post["extra_charge"]  = html_escape($this->input->post('extra_charge', TRUE));
                 $post["distance"]  = html_escape($this->input->post('distance', TRUE));
                 $post["id_tarif"] =html_escape($this->input->post('tarif', TRUE));
                    $this->app->addzona($post);
         }
          if(isset($_POST["update"])){
                $post["id"]  = html_escape($this->input->post('id', TRUE));
              $post["nama"]  = html_escape($this->input->post('nama', TRUE));
                 $post["zona"]  = html_escape($this->input->post('zona', TRUE));
                   $post["base_fare"] = html_escape($this->input->post('base_fare', TRUE));
                    $post["km"] =html_escape($this->input->post('km', TRUE));
                    $post["surcharge"]  = html_escape($this->input->post('surcharge', TRUE));
              $post["extra_charge"]  = html_escape($this->input->post('extra_', TRUE));
                 $post["distance"]  = html_escape($this->input->post('distance', TRUE));
                 $post["id_tarif"] =html_escape($this->input->post('tarif', TRUE));
                    $this->app->updatezona($post);
          }
        $data["tarif"]=$this->app->getprice();
        $this->load->view('includes/header');
        $this->load->view('area/add_zona', $data);
        $this->load->view('includes/footer');
    }
    public function addpricetravelin()
    {
         if(isset($_POST["add"])){
              $post["nama"]  = html_escape($this->input->post('nama', TRUE));
                 $post["wilayah"]  = html_escape($this->input->post('wilayah', TRUE));
                    $post["harga"] =html_escape($this->input->post('harga', TRUE));
                    $this->app->addpricetravelin($post);
         }
          if(isset($_POST["update"])){
                $post["id"]  = html_escape($this->input->post('id', TRUE));
               $post["nama"]  = html_escape($this->input->post('nama', TRUE));
                 $post["wilayah"]  = html_escape($this->input->post('wilayah', TRUE));
                    $post["harga"] =html_escape($this->input->post('harga', TRUE));
                    $this->app->updatepricetravelin($post);
          }
      
        $this->load->view('includes/header');
        $this->load->view('area/add_priceTravellin');
        $this->load->view('includes/footer');
    }
    
    public function addprice()
    {
         if(isset($_POST["add"])){
              $post["nama"]  = html_escape($this->input->post('nama', TRUE));
                 $post["awal"]  = html_escape($this->input->post('awal', TRUE));
                   $post["akhir"] = html_escape($this->input->post('akhir', TRUE));
                    $post["harga"] =html_escape($this->input->post('harga', TRUE));
                    $this->app->addprice($post);
         }
          if(isset($_POST["update"])){
                $post["id"]  = html_escape($this->input->post('id', TRUE));
               $post["nama"]  = html_escape($this->input->post('nama', TRUE));
                 $post["awal"]  = html_escape($this->input->post('awal', TRUE));
                   $post["akhir"] = html_escape($this->input->post('akhir', TRUE));
                    $post["harga"] =html_escape($this->input->post('harga', TRUE));
                    $this->app->updateprice($post);
          }
      
        $this->load->view('includes/header');
        $this->load->view('area/add_price');
        $this->load->view('includes/footer');
    }
    public function addpricebasic()
    {
         if(isset($_POST["add"])){
              $post["nama"]  = html_escape($this->input->post('nama', TRUE));
                 $post["awal"]  = html_escape($this->input->post('awal', TRUE));
                   $post["akhir"] = html_escape($this->input->post('akhir', TRUE));
                    $post["harga"] =html_escape($this->input->post('harga', TRUE));
                    $this->app->addpricebasic($post);
         }
          if(isset($_POST["update"])){
                $post["id"]  = html_escape($this->input->post('id', TRUE));
               $post["nama"]  = html_escape($this->input->post('nama', TRUE));
                 $post["awal"]  = html_escape($this->input->post('awal', TRUE));
                   $post["akhir"] = html_escape($this->input->post('akhir', TRUE));
                    $post["harga"] =html_escape($this->input->post('harga', TRUE));
                    $this->app->updatepricebasic($post);
          }
      
        $this->load->view('includes/header');
        $this->load->view('area/add_pricebasic');
        $this->load->view('includes/footer');
    }
}
