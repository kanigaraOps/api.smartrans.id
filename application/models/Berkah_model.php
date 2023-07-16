<?php

defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Berkah_model extends CI_model
{

    function __construct()
    {
        parent::__construct();
    }
    
    public function getidpelbyphone($phone) 
    {
        $this->db->select('id');
        $this->db->from('pelanggan');
        $this->db->like('phone',$phone);
        return $this->db->get()->row_array(); 
    }
     
    public function getidlast() 
    {
        $this->db->select('id');
        $this->db->from('transaksi');
        $this->db->order_by('transaksi.id', 'DESC');
        return $idtx = $this->db->get()->row_array();
    }
    
    public function signup($data_signup)
    {
        $signup = $this->db->insert('pelanggan', $data_signup);
        $dataIns = array(
            'id_user' => $data_signup['id'],
            'saldo' => 0,
            'saldotrx' => 0
        );
        $insSaldo = $this->db->insert('saldo', $dataIns);
        return $signup;
    }
    
    public function insert_transaksi_berkah($data_req, $data_rep)
    {
        $this->db->insert('transaksi', $data_req);
        $reqid = $this->db->insert_id();
        if ($this->db->affected_rows() == 1) {
            $get_data = $this->get_data_transaksi($data_req);
            $data_hist = array(
                'id_transaksi' => $reqid,
                'id_driver' => 'D0',
                'status' => '20'
            );
            $this->db->insert('history_transaksi', $data_hist);
            if ($this->db->affected_rows() == 1) {
                $data_rep['id_transaksi'] = $reqid;
                $this->db->insert('transaksi_jurnal', $data_rep);
                
                return array(
                    'status' => true,
                    'data' => $get_data->result()
                );
            }
        } else {
            return array(
                'status' => false,
                'data' => []
            );
        }
    }
    
    public function insert_transaksi_md($data_req, $data_rep) 
    {
        $this->db->insert('transaksi', $data_req);
        $reqid = $this->db->insert_id();
        if ($this->db->affected_rows() == 1) {
            $cond = array(
                'id' => $reqid,
            );
            //$get_data = $this->get_data_transaksi($cond);
            $data_hist = array(
                'id_transaksi' => $reqid,
                'id_driver' => 'D0',
                'status' => '1'
            );
            $this->db->insert('history_transaksi', $data_hist);
            if ($this->db->affected_rows() == 1) {
                $data_rep['id_transaksi'] = $reqid;
                $this->db->insert('transaksi_jurnal', $data_rep);
                
                // return array(
                //     'status' => true,
                //     'data' => $reqid
                // );
                return $reqid;
            }
        } else {
            return array(
                'status' => false,
                'data' => []
            );
        }
    }
    
    public function insert_transaksi_web($data_req, $data_rep) 
    {
        if($data_req['order_fitur'] == '38'){
            $status = '1';
        } else if($data_req['order_fitur'] == '34'){
            $status = '20';
        } else {
            $status = '20';
        }
        
        // return $data_req['order_fitur'];
        
        $this->db->insert('transaksi', $data_req);
        $reqid = $this->db->insert_id();
        if ($this->db->affected_rows() == 1) {
            $cond = array(
                'id' => $reqid,
            );
            //$get_data = $this->get_data_transaksi($cond);
            $data_hist = array(
                'id_transaksi' => $reqid,
                'id_driver' => 'D0',
                'status' => $status
            );
            $this->db->insert('history_transaksi', $data_hist);
            if ($this->db->affected_rows() == 1) {
                $data_rep['id_transaksi'] = $reqid;
                $this->db->insert('transaksi_jurnal', $data_rep);
                
                // return array(
                //     'status' => true,
                //     'data' => $reqid
                // );
                return $reqid;
            }
        } else {
            return array(
                'status' => false,
                'data' => []
            );
        }
    }
    
    function get_data_transaksi($cond)
    {
        $this->db->select('*');
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail_send', 'transaksi.id = transaksi_detail_send.id_transaksi', 'left');
        $this->db->where($cond);
        $cek = $this->db->get();
        return $cek;
    }
    
    public function publish($id)
      {
        $this->db->set('status', 0);
        $this->db->where('id_transaksi', $id);
        $this->db->update('history_transaksi');
      }
      
    public function gettransactionbyid($id)
    {
    $this->db->where('id', $id);
    return $this->db->get('transaksi')->row_array();
    }
  
    public function get_driver_regid_fleet($region_code, $fleet)
    {
        $d=mktime(0, 0, 0, date("m")  , date("d")-3, date("Y"));
        $this->db->select('*');
        $this->db->from('driver');
        $this->db->where('driver.region_code',$region_code);
        if($fleet == 'Kanigara Trans'){
            $this->db->where('driver.kanigara', 1);
        } elseif($fleet == 'Smartrans'){
            $this->db->where('driver.smartrans', 1);
        } elseif($fleet == 'Ayu Indah'){
            $this->db->where('driver.ayuindah', 1);
        }
        $this->db->where('driver.job',8);
        $this->db->where('driver.berkah', 1);
        $this->db->order_by('driver.queue', 'ASC');
        $this->db->join('config_driver', 'driver.id = config_driver.id_driver');
        $this->db->where('config_driver.status', 1);
        $this->db->where('config_driver.update_at >=', $d);
        return $this->db->get()->result_array();
    }
    

    
    public function xxx()
    {
        $todayx = date('Y-m-d',strtotime("-1 days"));
        //$todayx = '2021-01-14';
        $deduct = 0;
        
        $trans = $this->db->query("SELECT b.id, b.region_code, b.pool, d.saldo, count(a.id) as retase, sum(c.driver_total_payout_amount) as drvpayout from transaksi a left join driver b on a.id_driver=b.id left join transaksi_jurnal c on a.id=c.id_transaksi left join saldo d on b.id=d.id_user where b.pool = 1 and b.region_code=11 and a.waktu_order like '%$todayx%' group by b.id")->result_array();
        for ($x = 0; $x <= count($trans) - 1; $x++) {
            echo $x." - ".$trans[$x]['id']." - ".$trans[$x]['region_code']." - ".$trans[$x]['pool']." - ".$trans[$x]['retase']." - ".$trans[$x]['drvpayout']." - ".$trans[$x]['saldo']." - ";
            if ($trans[$x]['drvpayout'] < 15000000){
                $timer = 2000000;
            } else if ($trans[$x]['drvpayout'] > 15000000 ){ 
                $timer = 2000000; 
            }
            echo $timer." - ";
            
            
            if($timer > 0){
            $saldo = $trans[$x]['saldo']; 
            $saldonew = $saldo - $timer ;
            echo $saldonew;
            
            $data_ins = array(
                'id_user' => $trans[$x]['id'],  
                'jumlah' => $timer,
                'saldo_awal' => $saldo,
                'saldo_akhir' => $saldonew, 
                'bank' => "TIMER-".$todayx, 
                'nama_pemilik' => $trans[$x]['id'],
                'rekening' => 'wallet',
                'notes' => "TIMER-".$todayx."-".$trans[$x]['id'], 
                'type' => 'withdraw',   
                'status' => 1  
            );  
            // $ins_trans = $this->db->insert('wallet', $data_ins); 
            // if ($ins_trans) {
            //     $this->db->where('id_user', $trans[$x]['id']);
            //     $upd = $this->db->update('saldo', array('saldo' => $saldonew));
            //     /*
            //     if ($this->db->affected_rows() > 0) {
            //         return true;
            //     } else {
            //         return false;
            //     }*/
            // } 
        }
        echo "<br>";
        }

    } 
    
    function cqr($id,$transfer)
    {
    $data = file_get_contents("php://input");
    $decoded_data = json_decode($data);
    
    $merchant_id = "1142";
    $merchant_key = "3ea5bd4dfa9f35ea3fc22ea2";
    

    $custom = $id;
    $bussiness_id = "00003711077";
    $indicator_tip = '';
    $tip = 0;
    $store_label = 'strasad';
    $terminal_label = 'smartrans';
    $expired_time = '2023-01-27 13:51:28';
    
    // $signature = md5($merchant_id.(md5($custom.$merchant_key)));
    
    // $data = array("merchant_id"=>$merchant_id,
    //     "custom"=>$custom,
    //     "bussiness_id"=>$bussiness_id,
    //     "amount"=>$amount,
    //     "indicator_tip"=>$indicator_tip,
    //     "tip"=>$tip,
    //     "store_label"=>$store_label,
    //     "terminal_label"=>$terminal_label,
    //     "expired_time"=>"",
    //     "signature"=>$signature
    // );
    
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://103.159.223.136/api.php',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_POSTFIELDS =>  'amount='.$transfer.'&id='.$id,
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded'
      ),
    ));

    $response = json_decode(curl_exec($curl));
    curl_close($curl);
    //var_dump($response); 
    //echo $transfer." - ".$id;
    
    $qrisdata = array( 
        'custom'=> $response->responddata->custom,
        'reference_label'=> $response->responddata->reference_label,
        'merchant_id'=> $response->responddata->merchant_id,
        'bussiness_id'=> $response->responddata->bussiness_id,
        'bussiness_name'=> $response->responddata->bussiness_name,
        'amount'=> $response->responddata->amount,
        'expired_time'=> $response->responddata->expired_time,
        'data_qr'=> $response->responddata->data_qr
    );
    
    $db = $this->resqrisdinamis($qrisdata); 
    
        if($db){
            $message = array(
                'code' => '200',
                'message' => 'success',
                'data' =>[],
                'amount' =>$response->responddata->amount, 
                'data_qr' =>$response->responddata->data_qr,
                'expired_time' =>$response->responddata->expired_time,
                'status' =>'0',
            );
            return $message; 
        }
    }
    
    public function resqrisdinamis($data)
    {
        $insert = $this->db->insert('callbackqris', $data);
        $inserid = $this->db->insert_id();
        // $insertdata = array( 
        //     'inserid'=> $inserid,
        //     'data'=> $insert
        // );
        return $insert;
    }
    
    public function getidunik($cari)
    {
        $this->db->select('id');
        $this->db->where('id', $cari);
        return $this->db->get('pelanggan')->result();
    }
    
}