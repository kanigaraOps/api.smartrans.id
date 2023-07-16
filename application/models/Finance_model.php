<?php

defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Finance_model extends CI_model
{

    function __construct()
    {
        parent::__construct();
    }
    
    public function createQR($id,$amount) 
    {
    $merchant_id = "1142";
    $merchant_key = "3ea5bd4dfa9f35ea3fc22ea2";
    
    $custom = $id;
    $bussiness_id = "00003711077";
    //$amount ="1000";
    $indicator_tip = '';
    $tip = 0;
    $store_label = '';
    $terminal_label = '';
    $expired_time = '2023-01-24 12:51:28';
    
    $signature = md5($merchant_id.(md5($custom.$merchant_key)));
    $data = array("merchant_id"=>$merchant_id,
    "custom"=>$custom,
    "bussiness_id"=>$bussiness_id,
    "amount"=>$amount,
    "indicator_tip"=>$indicator_tip,
    "tip"=>$tip,
    "store_label"=>$store_label,
    "terminal_label"=>$terminal_label,
    "expired_time"=>"",
    "signature"=>$signature);
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
        return $response;
    }
     public function cekwallet($transfer) 
    {
         $this->db->select('*');
       $this->db->where('expired>',date('Y-m-d H:i:s'));
        $this->db->where('transfer', $transfer);
        $this->db->order_by('wallet.id', 'DESC');
        $this->db->limit(1);
        return $this->db->get('wallet')->row();
    }
    
    public function createNotification($notification) 
    {
        return  $this->db->insert('gv_notification', $notification);
    }
    public function updateqr($id,$qr)
  {
       $cek = $this->db->query("UPDATE `transaksi` SET `qr` = '$qr' WHERE `transaksi`.`id` = '$id'  ");
        // if ($cek->num_rows() == 1) {
            return $qr; 
        // } else {
        //     return $qr;
        // }
  }
   public function updateqrinter($id,$qr)
  {
       $cek = $this->db->query("UPDATE `transaksi_international` SET `qr` = '$qr' WHERE `transaksi_international`.`id` = '$id'  ");
        // if ($cek->num_rows() == 1) {
            return $qr; 
        // } else {
        //     return $qr;
        // }
  }
    public function createcekmutasi($datacallback) 
    {
        $ins = $this->db->insert('callbackcekmutasi', $datacallback);
        return $ins;
    }
    
    public function createqrisconftech($datacallback) 
    {
        $ins = $this->db->insert('callbackqris', $datacallback);
        return $ins;
    }
    
    public function gv_notification($notification) 
    {
       $this->db->insert('gv_notification', $notification);
       $idnotif = $this->db->insert_id();
       
       return $this->qrispairing($notification->amount, $notification->invoice_no, $idnotif); 
    }
    
    public function qrispairing($amount, $invoiceno, $idnotif) 
    {
        // $this->db->select('custom');
        // $this->db->from('callbackqris'); 
        // $this->db->where('reference_label', $notification);
        // $custom = $this->db->get()->row_array(); 

        // $this->db->select('*');
        // $this->db->from('wallet'); 
        // $this->db->where('id', $custom['custom']);
        // $wallet = $this->db->get()->row_array(); 
        
        $this->db->select('*');
        $this->db->from('wallet'); 
        $this->db->where('transfer', $amount);
        $this->db->where('status', 0);
        $this->db->limit(1);
        $wallet = $this->db->get()->row_array(); 
        
        if($wallet){
            $this->db->select('*');
            $this->db->from('saldo'); 
            $this->db->where('id_user', $wallet['id_user']);
            $saldo = $this->db->get()->row_array(); 
            
            $saldo = $saldo['saldo'];
            $jumlah = $wallet['jumlah'];
            $saldoawal = $saldo;
            $saldoakhir = $saldo + $jumlah;
    
            $this->db->set('saldo_awal', $saldoawal);
            $this->db->set('saldo_akhir', $saldoakhir);
            $this->db->set('aprovel', 'AUTOTOPUP');
            $this->db->set('topupvia', 'QRIS');
            $this->db->set('status', 1);
            $this->db->set('trx_datetime', date('Y-m-d H:i:s'));
            $this->db->where('id', $wallet['id']);
            $this->db->update('wallet');
            
            $this->db->set('saldo', $saldoakhir);
            $this->db->set('update_at', date('Y-m-d H:i:s'));
            $this->db->where('id_user', $wallet['id_user']);
            $updatesaldo = $this->db->update('saldo');
            
            $this->db->select('*');
            $this->db->from('driver'); 
            $this->db->where('id', $wallet['id_user']);
            $driver = $this->db->get()->row_array(); 
            
            $this->db->set('id_wallet', $wallet['id']);
            $this->db->where('id', $idnotif);
            $updatesaldo = $this->db->update('gv_notification');
            
            $datarespon = array(
                "jumlah"=>$jumlah / 100,
                "saldoakhir"=>$saldoakhir / 100,
                "reg_id"=>$driver['reg_id'],
                "nama"=>$driver['nama_driver'],
            );
            
            return $datarespon;
        } else {
            $datarespon = array(
                "jumlah"=>"",
                "saldoakhir"=>"",
                "reg_id"=>"",
                "nama"=>"",
            );
            
            return $datarespon;
        }
        

    }
}