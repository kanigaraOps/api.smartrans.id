<?php
defined('BASEPATH') or exit('No direct script access allowed');

class transactionltr extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('user_name') == NULL && $this->session->userdata('password') == NULL) {
            redirect(base_url() . "login");
        }
        $this->load->model('Appsettings_model', 'app');
        $this->load->model('Dashboard_model', 'dashboard');
        $this->load->model('Berkah_model', 'berkah');
        $this->load->model('Notification_model', 'notification');
        $this->load->library('PHPExcel');
        // $this->load->library('form_validation');
    }

    public function search()
    {

        $data['currency'] = $this->app->getappbyid();
        $data['transaksi'] = $this->dashboard->getAlltransaksiltr();
        $data['fitur'] = $this->dashboard->getAllfitur();
        $data['saldo'] = $this->dashboard->getallsaldo();

        $this->load->view('includes/header');
        $this->load->view('transactionltr/index', $data);
        $this->load->view('includes/footer');
    }
    function schema()
    {
        $schema = array(
            'No' => 'No',
            'ID Transaksi' => 'ID Transaksi',
            'ID Order' => 'ID Order',
            'Customer' => 'Customer',
            'Driver' => 'Driver',
            'Area' => 'Area',
            'Service' => 'Service',
            'Aplikator' => 'Aplikator',
            'Pickup Time' => 'Pickup Time',
            'Pick Up' => 'Pick Up',
            'Destination' => 'Destination',
            'Price' => 'Price',
            'Payment Method' => 'Payment Method'
        );
        return $schema;
    }

    public function index()
    {
        $aplikasi = html_escape($this->input->post('aplikator', TRUE));
        $status = html_escape($this->input->post('status', TRUE));
        $tgljemput = html_escape($this->input->post('tgljemput', TRUE));
        $tgljemput2 = html_escape($this->input->post('tgljemput2', TRUE));
        $idbook = html_escape($this->input->post('idbook', TRUE));
        $fitur = html_escape($this->input->post('fitur', TRUE));
        $area = html_escape($this->input->post('area', TRUE));
        $bulan = html_escape($this->input->post('bulan', TRUE));
        $tahun = html_escape($this->input->post('tahun', TRUE));
        $omzet = html_escape($this->input->post('omset', TRUE));
        $retase = html_escape($this->input->post('retase', TRUE));
          if (empty($tahun)) {
                $tahunjemput = date("Y");
            } else {
                $tahunjemput = $tahun;
            }

            if (empty($bulan)) {
                $tgljemput = date("Y-m-d");
            } else if ($bulan == 'ALL') {
                $tgljemput = $tgljemput;
            } else if (!empty($bulan)) {
                $tgljemput = $tahunjemput . "-" . $bulan;
            }
        if (isset($_POST["export"])) {

            $data = $this->dashboard->getAlltransaksiltrby($aplikasi, $status, $tgljemput, $tgljemput2, $idbook, $fitur, $area);
            $objPHPExcel = new PHPExcel();
            $format = $this->schema();
            $header = array();

            if (isset($retase)) {
                $jumlah = count($data) * ((int)$retase / 100);
                $kelipatan = $jumlah?floor(count($data) / $jumlah):1;
                for ($x = 0; $x <= $jumlah; $x++) {
                    if ($x % $kelipatan == 0 && $kelipatan!=0) {
                        unset($data[$x]);
                    }
                }
            }else{
                $jumlah = 0;
                $kelipatan = 0;
            }
            foreach ($format as $key => $value) {
                $header[0][$key] = strtolower($value);
            }
            $nomer=0;
            for ($x = 1; $x <= (count($data)-floor($jumlah)); $x++) {
                if (($x+$nomer) % $kelipatan == 0) {
                    unset($data[$x]);
                    $nomer++;
                }
                $header[$x]['No'] = $x;
                $header[$x]['ID Transaksi'] = "INV -" . $data[$x+$nomer]['id_transaksi'];
                $header[$x]['ID Order'] = $data[$x+$nomer-1]['id_order'];
                $header[$x]['Customer'] = $data[$x+$nomer-1]['fullnama'];
                $header[$x]['Driver'] = $data[$x+$nomer-1]['nama_driver'];
                $header[$x]['Area'] = $data[$x+$nomer-1]['area_name'];
                $header[$x]['Service'] = $data[$x+$nomer-1]['fitur'];
                $header[$x]['Aplikator'] = "BANDARA CGK";
                $header[$x]['Pickup Time'] = $data[$x+$nomer-1]['waktu_order'];
                $header[$x]['Pick Up'] = $data[$x+$nomer-1]['alamat_asal'];
                $header[$x]['Destination'] = $data[$x+$nomer-1]['alamat_tujuan'];
                if (isset($omzet)) {
                    if((int)$omzet>0){
                        $nilai=((int)$data[$x+$nomer-1]['biaya_akhir']);
                        // * ((100-(int)$omzet) / 100);
                    } else{
                        $nilai = (int)$data[$x+$nomer-1]['biaya_akhir'];
                    }
                    $header[$x]['Price'] = "Rp." . number_format($nilai / 100, 2, ".", ".");
                } else {
                    $header[$x]['Price'] = "Rp." . number_format((int)$data[$x+$nomer-1]['biaya_akhir'] / 100, 2, ".", ".");
                }
                if ($data[$x+$nomer]['pakai_wallet'] == '0') {
                    $header[$x]['Payment Method'] = 'CASH';
                } else {
                    $header[$x]['Payment Method'] = 'WALLET';
                }
            }

            // $row =  1;
            $coll = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
            $temp = 0;
            // $slot = 0;

            for ($j = 0; $j < count($header); $j++) {
                if (count($coll) - 1 < $j) {
                    if ($j == count($coll)) {
                        $no = 0;
                        foreach ($header[$j] as $key => $value) {
                            $temp = floor($j / count($coll));
                        $slot = $j - (count($coll) * $temp);
                        $cell = $coll[$temp - 1] . $coll[$slot] . ($j + 1);
                            $objPHPExcel->getActiveSheet()->SetCellValue($cell, $value);
                            $no++;
                        }
                    } else {
                        $no = 0;
                        foreach ($header[$j] as $key => $value) {
                            $cell = $coll[$no] . ($j + 1);
                            $objPHPExcel->getActiveSheet()->SetCellValue($cell, $value);
                            $no++;
                        }
                    }
                } else {
                    $no = 0;
                    foreach ($header[$j] as $key => $value) {
                        $cell = $coll[$no] . ($j + 1);
                        $objPHPExcel->getActiveSheet()->SetCellValue($cell, $value);
                        $no++;
                    }
                }
            }
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="lAPORANBANDARA' . date("Y-m-d") . '.xlsx"'); // Set nama file excel nya
            header('Cache-Control: max-age=0');
            $write = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $write->save('php://output');
        } else {
          
            $data['currency'] = $this->app->getappbyid();
            $data['transaksi'] = $this->dashboard->getAlltransaksiltrby($aplikasi, $status, $tgljemput, $tgljemput2, $idbook, $fitur, $area);
            $data['fitur'] = $this->dashboard->getAllfitur();
            $data['saldo'] = $this->dashboard->getallsaldo();
            $data['countryarea'] = $this->dashboard->getallcountryarea();
            //$data['hasil'] =  $tgljemput.",".$blnjemput;
            //$data['hasil'] =  $aplikasi.",".$status.",".$tgljemput.",".$blnjemput.",".$idbook.",".$fitur.",".$area;

            $this->load->view('includes/header');
            $this->load->view('transactionltr/index', $data);
            $this->load->view('includes/footer');

        }
    }
    
    public function edit($id)
    {
        echo "edit ".$id;
        $data['transaksi'] = $this->dashboard->gettransaksibyid($id);
        $this->load->view('includes/header');
        $this->load->view('transactionltr/editberkah', $data);
        $this->load->view('includes/footer');
    }
    
    public function editdata()
    {
        $id = html_escape($this->input->post('id', TRUE));
        $jenis = html_escape($this->input->post('jenis', TRUE));
        $notes = html_escape($this->input->post('notes', TRUE));
        $pickuptime = html_escape($this->input->post('pickuptime', TRUE));
        
        if(explode("/",$notes)[4] == "INSTANT BOOKING"){
            $notesnew = explode("/",$notes)[0]." / ".explode("/",$notes)[1]." / ".explode("/",$notes)[2]." / ".explode("/",$notes)[3]." / INSTANT BOOKING";
        } else if($jenis=='RENTCAR'){
            $notesnew = explode("/",$notes)[0]." / ".explode("/",$notes)[1]." / ".explode("/",$notes)[2]." / ".explode("/",$notes)[3]." / ". $pickuptime." / ".explode("/",$notes)[5]." / ".explode("/",$notes)[6];
        } else if($jenis=='SHUTTLE'){
            $notesnew = explode("/",$notes)[0]." / ".explode("/",$notes)[1]." / ".explode("/",$notes)[2]." / ".explode("/",$notes)[3]." / ". $pickuptime;
        } 

        
        $data = array(
            //'kode' => html_escape($this->input->post('kode', TRUE)),
            // 'jenis' => html_escape($this->input->post('jenis', TRUE)),
            // 'aplikator' => html_escape($this->input->post('aplikator', TRUE)),
            // 'nama' => html_escape($this->input->post('nama', TRUE)),
            // 'phone' => substr(html_escape($this->input->post('phone', TRUE)),2),
            // 'region' => html_escape($this->input->post('region', TRUE)),
            'waktu_order' => html_escape($this->input->post('pickuptime', TRUE)),
            // 'typecar' => html_escape($this->input->post('typecar', TRUE)),
            // 'qty' => html_escape($this->input->post('qty', TRUE)),
            // 'flight' => html_escape($this->input->post('flight', TRUE)),
            'harga' => html_escape($this->input->post('nd', TRUE)) * 100,
            'biaya_akhir' => html_escape($this->input->post('nd', TRUE)) * 100,
            'alamat_asal' => $this->input->post('jemput', TRUE),
            'alamat_tujuan' => $this->input->post('tujuan', TRUE),
            'notes' => $notesnew,
            'region_code' => html_escape($this->input->post('kode_reg', TRUE)),
        );
        // var_dump($data);
        // echo $id;
        $edit = $this->dashboard->edittransactionltr($data, $id);
        redirect('transactionltr/index');

    }
    
    public function publish($id)
    {
        $this->berkah->publish($id);
        $this->session->set_flashdata('hapus', 'Transaction Has Been Publish');
         $this->dashboard->updateStaff($id);
        $trans = $this->berkah->gettransactionbyid($id);
        
        $data = array(
                    'id'                    => $trans['id'],
                    'aplikator'             => $trans['aplikator'],
                    'fleet'                 => $trans['fleet'],
                    'region_code'           => $trans['region_code']
                );
                
        $arraynotes = explode("/",$trans['notes']) ;       
        $layanandesc = $arraynotes[0]."/".$arraynotes[1]."/".$arraynotes[2];
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
                "layanan"=> $layanandesc,
                "layanandesc"   => $trans['waktu_order'],
                "order_fitur"=> 'T-CAR',
                "pakai_wallet"=> true,
                "bridging"=> 2, 
                "type"=> 1
            );
            
            $send = $this->notification->send_notif_request_order_bytopic(keyfcm,$data, $trans['region_code']); 
            redirect('transactionltr/index');
    }
    
    public function rekonshuttle()
    {
        $aplikasi = html_escape($this->input->post('aplikator', TRUE));
        $status = html_escape($this->input->post('status', TRUE));
        $tgljemput = html_escape($this->input->post('tgljemput', TRUE));
        $tgljemput2 = html_escape($this->input->post('tgljemput2', TRUE));
        $idbook = html_escape($this->input->post('idbook', TRUE));
        $fitur = html_escape($this->input->post('fitur', TRUE));
        $area = html_escape($this->input->post('area', TRUE));
        $bulan = html_escape($this->input->post('bulan', TRUE));
        $tahun = html_escape($this->input->post('tahun', TRUE));
        $omzet = html_escape($this->input->post('omset', TRUE));
        $retase = html_escape($this->input->post('retase', TRUE));
          if (empty($tahun)) {
                $tahunjemput = date("Y");
            } else {
                $tahunjemput = $tahun;
            }

            if (empty($bulan)) {
                $tgljemput = date("Y-m-d");
            } else if ($bulan == 'ALL') {
                $tgljemput = $tgljemput;
            } else if (!empty($bulan)) {
                $tgljemput = $tahunjemput . "-" . $bulan;
            }
        if (isset($_POST["export"])) {

            $data = $this->dashboard->getAlltransaksiltrby($aplikasi, $status, $tgljemput, $tgljemput2, $idbook, $fitur, $area);
            $objPHPExcel = new PHPExcel();
            $format = $this->schema();
            $header = array();

            if (isset($retase)) {
                $jumlah = count($data) * ((int)$retase / 100);
                $kelipatan = $jumlah?floor(count($data) / $jumlah):1;
                for ($x = 0; $x <= $jumlah; $x++) {
                    if ($x % $kelipatan == 0 && $kelipatan!=0) {
                        unset($data[$x]);
                    }
                }
            }else{
                $jumlah = 0;
                $kelipatan = 0;
            }
            foreach ($format as $key => $value) {
                $header[0][$key] = strtolower($value);
            }
            $nomer=0;
            for ($x = 1; $x <= (count($data)-floor($jumlah)); $x++) {
                if (($x+$nomer) % $kelipatan == 0) {
                    unset($data[$x]);
                    $nomer++;
                }
                $header[$x]['No'] = $x;
                $header[$x]['ID Transaksi'] = "INV -" . $data[$x+$nomer]['id_transaksi'];
                $header[$x]['ID Order'] = $data[$x+$nomer-1]['id_order'];
                $header[$x]['Customer'] = $data[$x+$nomer-1]['fullnama'];
                $header[$x]['Driver'] = $data[$x+$nomer-1]['nama_driver'];
                $header[$x]['Area'] = $data[$x+$nomer-1]['area_name'];
                $header[$x]['Service'] = $data[$x+$nomer-1]['fitur'];
                $header[$x]['Aplikator'] = "BANDARA CGK";
                $header[$x]['Pickup Time'] = $data[$x+$nomer-1]['waktu_order'];
                $header[$x]['Pick Up'] = $data[$x+$nomer-1]['alamat_asal'];
                $header[$x]['Destination'] = $data[$x+$nomer-1]['alamat_tujuan'];
                if (isset($omzet)) {
                    if((int)$omzet>0){
                        $nilai=((int)$data[$x+$nomer-1]['biaya_akhir']);
                        // * ((100-(int)$omzet) / 100);
                    } else{
                        $nilai = (int)$data[$x+$nomer-1]['biaya_akhir'];
                    }
                    $header[$x]['Price'] = "Rp." . number_format($nilai / 100, 2, ".", ".");
                } else {
                    $header[$x]['Price'] = "Rp." . number_format((int)$data[$x+$nomer-1]['biaya_akhir'] / 100, 2, ".", ".");
                }
                if ($data[$x+$nomer]['pakai_wallet'] == '0') {
                    $header[$x]['Payment Method'] = 'CASH';
                } else {
                    $header[$x]['Payment Method'] = 'WALLET';
                }
            }

            // $row =  1;
            $coll = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
            $temp = 0;
            // $slot = 0;

            for ($j = 0; $j < count($header); $j++) {
                if (count($coll) - 1 < $j) {
                    if ($j == count($coll)) {
                        $no = 0;
                        foreach ($header[$j] as $key => $value) {
                            $temp = floor($j / count($coll));
                        $slot = $j - (count($coll) * $temp);
                        $cell = $coll[$temp - 1] . $coll[$slot] . ($j + 1);
                            $objPHPExcel->getActiveSheet()->SetCellValue($cell, $value);
                            $no++;
                        }
                    } else {
                        $no = 0;
                        foreach ($header[$j] as $key => $value) {
                            $cell = $coll[$no] . ($j + 1);
                            $objPHPExcel->getActiveSheet()->SetCellValue($cell, $value);
                            $no++;
                        }
                    }
                } else {
                    $no = 0;
                    foreach ($header[$j] as $key => $value) {
                        $cell = $coll[$no] . ($j + 1);
                        $objPHPExcel->getActiveSheet()->SetCellValue($cell, $value);
                        $no++;
                    }
                }
            }
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="lAPORANBANDARA' . date("Y-m-d") . '.xlsx"'); // Set nama file excel nya
            header('Cache-Control: max-age=0');
            $write = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $write->save('php://output');
        } else {
          
            $data['currency'] = $this->app->getappbyid();
            $data['transaksi'] = $this->dashboard->getAllrekonshuttle($aplikasi, $status, $tgljemput, $tgljemput2, $idbook, $fitur, $area);
            $data['fitur'] = $this->dashboard->getAllfitur();
            $data['saldo'] = $this->dashboard->getallsaldo();
            $data['countryarea'] = $this->dashboard->getallcountryarea();
            //$data['hasil'] =  $tgljemput.",".$blnjemput;
            //$data['hasil'] =  $aplikasi.",".$status.",".$tgljemput.",".$blnjemput.",".$idbook.",".$fitur.",".$area;

            $this->load->view('includes/header');
            $this->load->view('transactionltr/rekonshuttle', $data);
            $this->load->view('includes/footer');

        }
    }
    
    public function parammargin()
    {
        $data['transaksi'] = $this->dashboard->getparamroute();

        $this->load->view('includes/header');
        $this->load->view('transactionltr/parammargin', $data);
        $this->load->view('includes/footer');
    }
    
    public function editmargin()
    {
        $id = html_escape($this->input->post('id', TRUE));
        $margin = html_escape($this->input->post('margin', TRUE));
        
        $edit = $this->dashboard->editmargin($id, $margin);

        redirect('transactionltr/parammargin');
    }
}
