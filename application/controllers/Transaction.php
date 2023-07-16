<?php
defined('BASEPATH') or exit('No direct script access allowed');

class transaction extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
      
        if ($this->session->userdata('user_name') == NULL && $this->session->userdata('password') == NULL) {
            redirect(base_url() . "login");
        }
        $this->load->model('Appsettings_model', 'app');
        $this->load->model('Dashboard_model', 'dashboard');
        $this->load->model('Pelanggan_model', 'pelanggan');
        $this->load->model('Notification_model', 'notification');     
        $this->load->model('Driver_model', 'driver');    
        $this->load->model('wallet_model', 'wallet');
        $this->load->model('users_model', 'user');
        $this->load->model('reporting_model', 'reporting');
        $this->load->library('form_validation');
        $this->load->helper('file');
    }
    public function AP($date=null)
    {
        $date==null?$date=date("Y-m-d"):$date;
        $terminal2e="39fa5b5d2000c6c05032d4d2a751b887";
        $terminal2d="68b35d3f7fc2dab5dc810679100ee257";
        $terminal3="6b54a6e5d82be908a5ee15daa80b23a1";
        $list=array_merge($this->dashboard->get_AP($terminal2e,$this->driver->get_token()->token_ap,$date)->data,$this->dashboard->get_AP($terminal2d,$this->driver->get_token()->token_ap,$date)->data,$this->dashboard->get_AP($terminal3,$this->driver->get_token()->token_ap,$date)->data);
        return $list;
    }
    function schema_AP()
    {
        $schema = array(
            'Transaction Date' => 'Transaction Date',
            'Transaction Time' => 'Transaction Time',
            'Location' => 'Location',
            'Item Sequence' => 'Item Sequence',
            'Item Nama' => 'Item Nama',
            'Item Code' => 'Item Code',
            'Quantity' => 'Quantity',
            'Price per unit' => 'Price per unit',
            'Price amount' => 'Price amount',
            'Total Price Amount' => 'Total Price Amount',
            'Total VAT' => 'Total VAT',
            'Transaction amount ' => 'Transaction amount '
        );
        return $schema;
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
    public function laporan_ap()
    {
        $status = html_escape($this->input->post('status', TRUE));
        $tgljemput = html_escape($this->input->post('tgljemput', TRUE));
        $data['transaksi'] = $this->dashboard->getAPtransaksiby($status, $tgljemput);
        // $data['unreported'] = $this->dashboard->getAPtransaksiunreported( $tgljemput);
        // $data['filter'] = $this->dashboard->getAPtransaksifilter( $tgljemput);
        // $data['reported'] = $this->dashboard->getAPtransaksireported($tgljemput);
        $data['total_penumpang'] = $this->dashboard->total_penumpang($tgljemput)->total_penumpang==NULL?0:$this->dashboard->total_penumpang($tgljemput)->total_penumpang;
        $data['total_reported'] = $this->dashboard->total_reported($tgljemput)->total==NULL?0:$this->dashboard->total_reported($tgljemput)->total;
        $data['total_unreported'] = $this->dashboard->total_unreported($tgljemput)->total==NULL?0:$this->dashboard->total_unreported($tgljemput)->total;
        $data['total'] = (int)$data['total_reported']+(int)$data['total_unreported'];
        $data['driver'] = $this->driver->get_driver_ap();
        $data['ap'] = $this->AP($tgljemput);
        usort($data['ap'], function($a, $b) {
    return strtotime($a->transaction_time) < strtotime($b->transaction_time);
});
usort($data['transaksi'], function($a, $b) {
    return strtotime($a['waktu_selesai'] ) < strtotime($b['waktu_selesai'] );
});
        $_SESSION["ap"]=$data['ap'];
        if (isset($_POST["export"])) {
            $data = $data['transaksi'];
            
            $objPHPExcel = new PHPExcel();
            $format = $this->schema_AP();
            $header = array();

            
                $jumlah = 0;
                $kelipatan = 0;
            foreach ($format as $key => $value) {
                $header[0][$key] = strtolower($value);
            }
            $nomer=0;
            for ($x = 1; $x <= (count($data)-floor($jumlah)); $x++) {
                $header[$x]['Transaction Date'] =  date_format(new DateTime($data[$x+$nomer-1]['waktu_order']),"Y-m-d");
                $header[$x]['Transaction Time'] = $data[$x+$nomer-1]['waktu_order'];
                $header[$x]['Location'] = $data[$x+$nomer-1]['aplikator'];
                $header[$x]['Item Sequence'] = $x;
                $header[$x]['Item Nama'] = $data[$x+$nomer-1]['fitur'];
                $header[$x]['Item Code'] = $data[$x+$nomer-1]['id_order'];
                $header[$x]['Quantity'] = 1;
                if (isset($omzet)) {
                    if((int)$omzet>0){
                        $nilai=((int)$data[$x+$nomer-1]['biaya_akhir']) * ((100-(int)$omzet) / 100);
                    } else{
                        $nilai = (int)$data[$x+$nomer-1]['biaya_akhir'];
                    }
                    $total = "Rp." . number_format($nilai / 100, 2, ".", ".");
                    $header[$x]['Price per unit'] = $total;
                $header[$x]['Price amount'] = $total;
                $header[$x]['Total Price Amount'] = $total;
                $header[$x]['Total VAT'] =$total;
                $header[$x]['Transaction amount'] = $total;
                } else {
                    $total = "Rp." . number_format((int)$data[$x+$nomer-1]['biaya_akhir'] / 100, 2, ".", ".");
                    $header[$x]['Price per unit'] = $total;
                $header[$x]['Price amount'] = $total;
                $header[$x]['Total Price Amount'] = $total;
                $header[$x]['Total VAT'] =$total;
                $header[$x]['Transaction amount'] = $total;
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
        }else{
        $this->load->view('includes/header');
        $this->load->view('transaction/laporan_ap', $data);
        $this->load->view('includes/footer');
    }}
    public function index()
    {
        $status = html_escape($this->input->post('status', TRUE));
        $tgljemput = html_escape($this->input->post('tgljemput', TRUE));
        $fitur = html_escape($this->input->post('fitur', TRUE));
        $area = html_escape($this->input->post('area', TRUE));
        $bulan = html_escape($this->input->post('bulan', TRUE));
        $omzet = html_escape($this->input->post('omset', TRUE));
        if (date("m") >=  (int)$bulan) {
            $blnjemput = date("Y")."-".$bulan; 
        }else{
            $blnjemput = (date("Y")-1)."-".$bulan; 
        }
if(!empty($tgljemput)){
    $tgljemput;
        }else if(empty($bulan)){
            $tgljemput = date("Y-m");
        }else if($bulan=='ALL'){
            $tgljemput = date("Y-m");
        }else if(!empty($bulan) ){
            $tgljemput = $blnjemput;
        }
        $data['transaksi'] = $this->dashboard->getAlltransaksiby($status, $tgljemput, $fitur, $area);
        if (isset($_POST["export"])) {

            $data = $data['transaksi'];
            $objPHPExcel = new PHPExcel();
            $format = $this->schema();
            $header = array();

            if (isset($retase)) {
                $jumlah = count($data) * ((int)$retase / 100);
                $kelipatan = $jumlah?floor(count($data) / $jumlah):0;
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
                if ($kelipatan !== 0 &&($x+$nomer) % $kelipatan == 0) {
                    unset($data[$x]);
                    $nomer++;
                }
                $header[$x]['No'] = $x;
                $header[$x]['ID Transaksi'] = "INV -" . $data[$x+$nomer-1]['id_transaksi'];
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
                        $nilai=((int)$data[$x+$nomer-1]['biaya_akhir']) * ((100-(int)$omzet) / 100);
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
        }else{
        $data['currency'] = $this->app->getappbyid();
        
        $data['fitur'] = $this->dashboard->getAllfitur();
        $data['saldo'] = $this->dashboard->getallsaldo();

        $this->load->view('includes/header');
        $this->load->view('transaction/index', $data);
        $this->load->view('includes/footer');
    }}

    public function addberkah()
    {

        $data = array();
        
        // Get messages from the session
        if($this->session->userdata('success_msg')){
            $data['success_msg'] = $this->session->userdata('success_msg');
            $this->session->unset_userdata('success_msg');
        }
        if($this->session->userdata('error_msg')){
            $data['error_msg'] = $this->session->userdata('error_msg');
            $this->session->unset_userdata('error_msg');
        }
        
        // Get rows
        $data['members'] = $this->reporting->getRows();
        
        
        // $kode = html_escape($this->input->post('kode', TRUE));
        // $jenis = html_escape($this->input->post('jenis', TRUE));
        // $aplikator = html_escape($this->input->post('aplikator', TRUE));
        // $nama = html_escape($this->input->post('nama', TRUE));
        // $phone = substr(html_escape($this->input->post('phone', TRUE)),2);
        // $region = html_escape($this->input->post('region', TRUE));
        // $pickuptime = html_escape($this->input->post('pickuptime', TRUE));
        // $typecar = html_escape($this->input->post('typecar', TRUE));
        // $qty = html_escape($this->input->post('qty', TRUE));
        // $flight = html_escape($this->input->post('flight', TRUE));
        // $rute = html_escape($this->input->post('rute', TRUE));
        // $reporting = html_escape($this->input->post('reporting', TRUE));
        // $nd = html_escape($this->input->post('nd', TRUE));
        // $jemput = html_escape($this->input->post('jemput', TRUE));
        // $tujuan = html_escape($this->input->post('tujuan', TRUE));
        // $durasi = html_escape($this->input->post('durasi', TRUE));
        // $region_code = html_escape($this->input->post('kode_reg', TRUE));
        
        // $this->form_validation->set_rules('nd', 'nd', 'trim|prep_for_form');


        // if ($this->form_validation->run() == TRUE) {
        //     $nd = $nd * 100;
        //     for ($x = 0; $x < $qty; $x++) {
        //     $datapel = $this->pelanggan->getidpelbyphone($phone);
        //     $dataid = $this->dashboard->getidlast();             
        //     $remove = array(".", ",");
        //     $add = array("", "");
        //     $iddriver = html_escape($this->input->post('iddriver', TRUE));

        //     if($datapel==TRUE){
        //         $iduser = $datapel['id'];
        //     } else {
        //         $iduser = 'P'.rand(1000000000,9999999999);   
        //     }

        //     if($jenis=='RENTCAR'){
        //         $jenisx=20;
        //         $types=3; 
        //         $notes = $aplikator." / ".$typecar." / ".$flight." / ".$phone." / ".$pickuptime." / ".$durasi." Hari";
        //     } else if($jenis=='SHUTTLE'){  
        //         $jenisx=34;
        //         $types=1;
        //         $notes = $aplikator." / ".$typecar." / ".$flight." / ".$phone." / ".$pickuptime;
        //     }


        //     $data_signup = array(
        //         'id'                        => $iduser,
        //         'fullnama'                  => html_escape($this->input->post('nama', TRUE)),
        //         'email'                     => $phone.'@gmail.com',
        //         'no_telepon'                => '62'.$phone,
        //         'countrycode'               => '+62',
        //         'phone'                     => $phone,
        //         'password'                  => '7c222fb2927d828af22f592134e8932480637c0d',
        //         'created_on '               => date('Y-m-d H:i:s'),
        //         'tgl_lahir '                => date('Y-m-d'), 
        //         'rating_pelanggan'          => '0',
        //         'status'                    => '1',
        //         'token'                     => '12345',
        //         'fotopelanggan'             => 'smart.jpg'
        //     );
            
        //     $user = $this->pelanggan->signup($data_signup);

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
        //         'harga'                         => $nd,
        //         'reporting'                     => $reporting,
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
        //         'staff'                         => $this->session->userdata('id'),
        //         'pakai_wallet'                  => 1
        //     );
            
        //     $data_rep = array(
        //         'sub_total_before_discount'             => $nd,
        //         'online_payment'                        => $nd,
        //         'customer_paid_amount'                  => $nd,
        //         'created_at'                            => date('Y-m-d H:i:s')
        //     );
            
        //     $trans = $this->pelanggan->insert_transaksi_berkah($data_req, $data_rep);

        //     if($trans){

        //     $datadriver = $this->driver->get_driver_regid($region_code);
        //     $q = count($datadriver);
        //     $cart = array();
        //     for ($i = 0; $i < $q; $i++) {                

        //      $data_notif = array(
        //         'id_pelanggan'                  => $iduser,
        //         'order_fitur'                   => $types,
        //         'jenis'                         => $jenis,
        //         'distance'                      => 0,
        //         'harga'                         => $nd,
        //         'estimasi_time'                 => '0 mins',
        //         'waktu_order'                   => $pickuptime,
        //         'aplikator'                     => $aplikator,
        //         'type_car'                      => $typecar,
        //         'alamat_asal'                   => $jemput,
        //         'alamat_tujuan'                 => $tujuan,
        //         'biaya'                         => number_format($nd/100,2,".","."),
        //         'kredit_promo'                  => 0,
        //         'pakai_wallet'                  => true,
        //         'reg_id'                        => $datadriver[$i]['reg_id'],
        //         'id_transaksi'                  => $dataid['id'] + 1
        //     );

        //     $cart[] = $data_notif;
        //     // $this->notification->send_notif_req_berkah($data_notif);
        //     }
        // }
        // }
        //     redirect('transaction/addberkah');
        // } else {
        //     $this->load->view('includes/header');
        //     $this->load->view('transaction/addberkah', $data);
        //     $this->load->view('includes/footer');
        // }
        
        $this->load->view('includes/header');
            $this->load->view('transaction/addberkah', $data);
            $this->load->view('includes/footer');
    }

    public function import(){
    $data = array();
    $memData = array();
    
    // If import request is submitted
    if($this->input->post('importSubmit')){
        // Form field validation rules
        $this->form_validation->set_rules('file', 'CSV file', 'callback_file_check');
        
        // Validate submitted form data
        if($this->form_validation->run() == true){
            $insertCount = $updateCount = $rowCount = $notAddCount = 0;
            
            // If file uploaded
            if(is_uploaded_file($_FILES['file']['tmp_name'])){
                // Load CSV reader library
                $this->load->library('CSVReader');
                
                // Parse data from CSV file
                $csvData = $this->csvreader->parse_csv($_FILES['file']['tmp_name']);
                
                // Insert/update CSV data into database
                if(!empty($csvData)){
                    foreach($csvData as $row){ $rowCount++;
                        
                        // Prepare data for DB insertion
                        $memData = array(
                            'noshuttle' => $row['Booking Code'],
                            'route' => $row['Pickup & Dropoff Point'],
                            'qty' => $row['Number of Car'],
                            'nettsp' => $row['Net Selling Price'],
                            'nettsales' => $row[' Net Sales'],
                        );

                        $con = array(
                            'where' => array(
                                'noshuttle' => $row['Booking Code']
                            ),
                            'returnType' => 'count'
                        );
                        $prevCount = $this->reporting->getRows($con);
                        
                        if($prevCount > 0){
                            // Update reporting data
                            $condition = array('noshuttle' => $row['Booking Code']);
                            $update = $this->reporting->update($memData, $condition);
                            
                            if($update){
                                $updateCount++;
                            }
                        }else{
                            // Insert reporting data
                            $insert = $this->reporting->insert($memData);
                            
                            if($insert){
                                $insertCount++;
                            }
                        }
                    }
                    
                    // Status message with imported data count
                    $notAddCount = ($rowCount - ($insertCount + $updateCount));
                    $successMsg = 'reportings imported successfully. Total Rows ('.$rowCount.') | Inserted ('.$insertCount.') | Updated ('.$updateCount.') | Not Inserted ('.$notAddCount.')';
                    $this->session->set_userdata('success_msg', $successMsg);
                }
            }else{
                $this->session->set_userdata('error_msg', 'Error on file upload, please try again.');
            }
        }else{
            $this->session->set_userdata('error_msg', 'Invalid file, please select only CSV file.');
        }
    }
    redirect('transaction/addberkah');
    }
    

    public function file_check($str){
        $allowed_mime_types = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != ""){
            $mime = get_mime_by_extension($_FILES['file']['name']);
            $fileAr = explode('.', $_FILES['file']['name']);
            $ext = end($fileAr);
            if(($ext == 'csv') && in_array($mime, $allowed_mime_types)){
                return true;
            }else{
                $this->form_validation->set_message('file_check', 'Please select only CSV file to upload.');
                return false;
            }
        }else{
            $this->form_validation->set_message('file_check', 'Please select a CSV file to upload.');
            return false;
        }
    }
    
    public function detailap($id)
    {        

        $list=$_SESSION["ap"];
        foreach ($list as $tr) {
            if($tr->invoice_number==$id){
                $data["ap"]=$tr;
            }
            }
       
            $this->load->view('includes/header');
            $this->load->view('transaction/detail', $data);
            $this->load->view('includes/footer');
    }
       public function detail($id)
    {        

        $data['terminal'] = $this->dashboard->getTerminalbyId($id);


       
            $this->load->view('includes/header');
            $this->load->view('transaction/addberkah2', $data);
            $this->load->view('includes/footer');
    }
           public function terminal()
    {
        
        if(isset($_POST["terminal"])){
            $post["30KM"] = html_escape($this->input->post('30KM', TRUE));
        $post["50KM"]  = html_escape($this->input->post('50KM', TRUE));
        $post["100KM"]  = html_escape($this->input->post('100KM', TRUE));
        $post["150KM"]  = html_escape($this->input->post('150KM', TRUE));
            $post["minimum"] = html_escape($this->input->post('minimum', TRUE));
        $post["fee_company"]  = html_escape($this->input->post('fee_company', TRUE));
        $post["base_fare"]  = html_escape($this->input->post('base_fare', TRUE));
        $post["distance"]  = html_escape($this->input->post('distance', TRUE));
        $post["surge"]  = html_escape($this->input->post('surge', TRUE));
        $post["retase"]  = html_escape($this->input->post('retase', TRUE));
        $post["omset"]  = html_escape($this->input->post('omset', TRUE));
        $post["id"]  = html_escape($this->input->post('id', TRUE));
        $this->dashboard->updateTerminalbyId($post);
        }elseif(isset($_POST["submit"])){
             $driver = html_escape($this->input->post('driver', TRUE));
             $this->dashboard->updatedriverap($driver);
             
        }
        $data['terminal'] = $this->dashboard->getTerminal();
        $data['driver'] = $this->dashboard->get_driverseting();

       
            $this->load->view('includes/header');
            $this->load->view('transaction/terminal', $data);
            $this->load->view('includes/footer');
        
    }
    
}
