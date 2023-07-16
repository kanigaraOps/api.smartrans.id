<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mitrajasa_model extends CI_model
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('Flip_model', 'flip'); 
    }

    public function signup($data_signup, $data_kendaraan, $data_berkas)
    {
        $inskendaraan = $this->db->insert('kendaraan', $data_kendaraan);
        $inserid = $this->db->insert_id();

        //Mitrajasa
        $datasignup = array(
            'id' => $data_signup['id'],
            'nama_driver' => $data_signup['nama_driver'],
            'referral_code' => $data_signup['referral_code'],
            'uppline_id' => $data_signup['uppline_id'],
            'no_ktp' => $data_signup['no_ktp'],
            'tgl_lahir' => $data_signup['tgl_lahir'],
            'no_telepon' => $data_signup['no_telepon'],
            'phone' => $data_signup['phone'],
            'email' => $data_signup['email'],
            'countrycode' => $data_signup['countrycode'],
            'foto' => $data_signup['foto'],
            'password' => $data_signup['password'],
            'job' => $data_signup['job'],
            'gender' => $data_signup['gender'],
            'alamat_driver' => $data_signup['alamat_driver'],
            'region_code' => $data_signup['region_code'],
            'reg_id' => '12345',
            'status' => '0'
        );
        $signup = $this->db->insert('mitrajasa', $datasignup);

        //Config Driver
        $dataconfig = array(
            'id_driver' => $data_signup['id'],
            'latitude' => '0',
            'longitude' => '0',
            'status' => '5'
        );
        $insconfig = $this->db->insert('config_mitrajasa', $dataconfig);

        //Berkas Driver
        $databerkas = array(
            'id_driver' => $data_signup['id'],
            'foto_ktp' => $data_berkas['foto_ktp'],
            'foto_sim' => $data_berkas['foto_sim'],
            'foto_stnk' => $data_berkas['foto_stnk'],
            'id_sim' => $data_berkas['id_sim'],
            'stnk_berlaku' => $data_berkas['stnk_berlaku']
        );
        $insberkas = $this->db->insert('berkas_mitrajasa', $databerkas);

        //Saldo
        $datasaldo = array(
            'id_user' => $data_signup['id'],
            'saldo' => 0,
            'saldotrx' => 0
        );
        $insSaldo = $this->db->insert('saldo', $datasaldo);
        return $signup;
    }

    public function check_exist($email, $phone)
    {
        $cek = $this->db->query("SELECT id FROM mitrajasa where email='$email' AND no_telepon='$phone'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function check_ktp($ktp)
    {
        $cek = $this->db->query("SELECT id FROM mitrajasa where no_ktp='$ktp'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function check_sim($sim)
    {
        $cek = $this->db->query("SELECT id_berkas FROM berkas_mitrajasa where id_sim='$sim'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function check_exist_phone($phone)
    {
        $cek = $this->db->query("SELECT id FROM mitrajasa where no_telepon='$phone'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }
    public function check_exist_email($email)
    {
        $cek = $this->db->query("SELECT id FROM mitrajasa where email='$email'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function check_banned($phone)
    {
        $stat =  $this->db->query("SELECT id FROM mitrajasa WHERE status='3' AND no_telepon='$phone'");
        if ($stat->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function check_exist_phone_edit($id, $phone)
    {
        $cek = $this->db->query("SELECT no_telepon FROM mitrajasa where no_telepon='$phone' AND id!='$id'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function check_exist_email_edit($id, $email)
    {
        $cek = $this->db->query("SELECT id FROM mitrajasa where email='$email' AND id!='$id'");
        if ($cek->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function get_data_pelanggan($condition)
    {
        $this->db->select('mitrajasa.*, saldo.saldo');
        $this->db->from('mitrajasa');
        $this->db->join('saldo', 'mitrajasa.id = saldo.id_user');
        $this->db->where($condition);
        $this->db->where('status', '1');
        return $this->db->get();
    }

    public function get_job()
    {
        $this->db->select('*');
        $this->db->from('driver_job');
        $this->db->where('status_job', '1');
        $this->db->where('grup', '1');
        return $this->db->get()->result();
    }

    public function get_job_services()
    {
        $this->db->select('*');
        $this->db->from('driver_job');
        $this->db->where('status_job', '1');
        $this->db->where('grup', '2');
        return $this->db->get()->result();
    }

    public function get_driver_regid($region_code)
    {
        $this->db->select('reg_id');
        $this->db->from('mitrajasa');
        $this->db->where('region_code',$region_code);
        $this->db->where('berkah', 1);
        return $this->db->get()->result_array();
    }

    public function insertwallettrx($data_withdraw)
    {
        $verify = $this->db->insert('wallettrx', $data_withdraw);
        return true;
    }

    public function get_status_driver($condition)
    {
        $this->db->select('*');
        $this->db->from('config_mitrajasa');
        $this->db->where($condition);
        return $this->db->get();
    }

    public function edit_profile($data, $phone)
    {

        $this->db->where('no_telepon', $phone);
        $this->db->update('mitrajasa', $data);
        return true;
    }

    public function edit_status_login($phone)
    {
        $phonenumber = array('no_telepon' => $phone);
        $datadriver = $this->get_data_driver($phonenumber);
        $datas = array('status' => '4');
        $this->db->where('id_driver', $datadriver->row('id'));
        $this->db->update('config_mitrajasa', $datas);
        return true;
    }

    public function logout($dataEdit, $id)
    {

        $this->db->where('id_driver', $id);
        $logout = $this->db->update('config_mitrajasa', $dataEdit);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function edit_kendaraan($data, $id)
    {

        $this->db->where('id_k', $id);
        $this->db->update('kendaraan', $data);
        return true;
    }

    function my_location($data_l)
    {
        if ($data_l['bearing'] != '0.0') {
            $data = array(
                'latitude' => $data_l['latitude'],
                'longitude' => $data_l['longitude'],
                'bearing' => $data_l['bearing']
            );
        } else {
            $data = array(
                'latitude' => $data_l['latitude'],
                'longitude' => $data_l['longitude']
            );
        }

        $this->db->select('status');
        $this->db->where('id_driver', $data_l['id_driver']);
        $status = $this->db->get('config_mitrajasa')->row('status'); 

        $this->db->set('id_user', $data_l['id_driver']);
        $this->db->set('latitude', $data_l['latitude']);
        $this->db->set('longitude', $data_l['longitude']);
        $this->db->set('status', $status);
        $this->db->insert('location');

        $this->db->where('id_driver', $data_l['id_driver']);
        $upd = $this->db->update('config_mitrajasa', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_data_driver($condition)
    {        
        $this->db->select('mitrajasa.*, saldo.saldo');
        $this->db->from('mitrajasa');
        $this->db->join('config_mitrajasa', 'mitrajasa.id = config_mitrajasa.id_driver');
        $this->db->join('saldo', 'mitrajasa.id = saldo.id_user');
        $this->db->where($condition);
        return $this->db->get();
    }

    public function get_deduct_timer()
    {
        $this->db->select('mitrajasa.id, saldo.saldo');
        $this->db->from('mitrajasa');
        $this->db->join('config_mitrajasa', 'mitrajasa.id = config_mitrajasa.id_driver');
        $this->db->join('saldo', 'mitrajasa.id = saldo.id_user'); 
        $this->db->where('mitrajasa.region_code','11');
        //$this->db->where('mitrajasa.pool','1');
        //$this->db->where('driver.nama_driver','Berkah Berkah'); 
        $driver = $this->db->get()->result_array();
        $todayx = date("Y-m-d");

        for ($x = 0; $x <= count($driver); $x++) {
            $driverx = $driver[$x]['id']; 
            echo $driverx." - ";
            $trans = $this->db->query("select count(a.harga) as cy, sum(c.sub_total_before_discount) as sumstbd, sum(c.surge_amount) as sumsurge from transaksi a left join history_transaksi b on a.id=b.id_transaksi left join transaksi_jurnal c on c.id_transaksi=a.id where a.id_driver = '$driverx' and a.waktu_order like '%2020-12-06%'")->row();
            echo $cy = $trans->cy ? $trans->cy : 0;
            $sumstbd = $trans->sumstbd ;
            $sumsurge = $trans->sumsurge;
            echo $sums = $sumstbd + $sumsurge;             
            
            If($cy == 0){
                $deduct = 0;
                //echo "<br>";
            } else if ($sums < 15000000 && $cy > 0){
                $deduct = 2000000;
                //echo "<br>";
            } else if ($sums > 15000000 && $cy > 0){
                $deduct = 2000000; 
                //echo "<br>";
            }
            echo $deduct;
            echo "<br>"; 
            
            if($deduct > 0){
            $saldo = $driver[$x]['saldo']; 
            $saldonew = $saldo - $deduct ; 
            $data_ins = array(
                'id_user' => $driverx,  
                'jumlah' => $deduct,
                'saldo_awal' => $saldo,
                'saldo_akhir' => $saldonew, 
                'bank' => "TIMER-2020-12-06",//"TIMER-".$todayx, 
                'nama_pemilik' => $driverx,
                'rekening' => 'wallet',
                'notes' => "TIMER-2020-12-06-".$driverx,  //"TIMER-".$todayx."-".$driverx, 
                'type' => 'withdraw', 
                'status' => 1
            );  
            $ins_trans = $this->db->insert('wallet', $data_ins); 
            if ($ins_trans) {
                $this->db->where('id_user', $driverx);
                $upd = $this->db->update('saldo', array('saldo' => $saldonew)); 
            } 
        }
        }
    }

    function change_status_driver($idD, $stat_order)
    {


        $params = array(
            'status' => $stat_order
        );
        $this->db->where('id_driver', $idD);
        $upd = $this->db->update('config_mitrajasa', $params);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_data_driver_sync($id)
    {

        $this->db->select(""
            . "driver.*,"
            . "kendaraan.*,"
            . "driver.foto as foto,"
            . "saldo.*,"
            . "config_mitrajasa.status as status_config");
        $this->db->from('mitrajasa');
        $this->db->join('config_mitrajasa', 'driver.id = config_mitrajasa.id_driver');
        $this->db->join('saldo', 'mitrajasa.id = saldo.id_user');
        $this->db->join('kendaraan', 'mitrajasa.kendaraan = kendaraan.id_k');
        $this->db->where('driver.id', $id);
        $dataCon = $this->db->get();
        return array(
            'data_driver' => $dataCon,
            'status_order' => $this->check_status_order($id)
        );
    }

    function check_status_order($idDriver)
    {
        $this->db->select(''
            . 'transaksi.*,'
            . 'transaksi_detail_send.*,'
            . 'history_transaksi.*,'
            . 'pelanggan.fullnama,'
            . 'pelanggan.no_telepon as telepon,'
            . 'pelanggan.token as reg_id_pelanggan');
        $this->db->join('transaksi', 'transaksi.id = history_transaksi.id_transaksi');
        $this->db->join('pelanggan', 'transaksi.id_pelanggan = pelanggan.id');
        $this->db->join('transaksi_detail_send', 'transaksi.id = transaksi_detail_send.id_transaksi', 'left');
        $this->db->where("(history_transaksi.status = '2' OR history_transaksi.status = '3')", NULL, FALSE);
        $this->db->where('history_transaksi.id_driver', $idDriver);
        $this->db->order_by('history_transaksi.nomor', 'DESC');
        $check = $this->db->get('history_transaksi', 1, 0);
        return $check;
    }

    function edit_config($data, $id)
    {
        $this->db->where('id_driver', $id);
        $edit = $this->db->update('config_mitrajasa', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function edit_statuslater($id, $driverid, $statuslater)
    {
        if($statuslater == 12 )   {
            $this->db->where('id', $id);
            $edit = $this->db->update('transaksi', array('id_driver' => $driverid));
            $this->db->where('id_transaksi', $id);
            $edit = $this->db->update('history_transaksi', array('status' => $statuslater, 'id_driver' => $driverid));
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } else if($statuslater == 2 )   {
            $this->db->where('id_transaksi', $id);
            $edit = $this->db->update('history_transaksi', array('status' => $statuslater));
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } elseif ($statuslater == 0 )  {
            $driverid = "D0";
            $this->db->where('id', $id);
            $edit = $this->db->update('transaksi', array('id_driver' => NULL));
            $this->db->where('id_transaksi', $id);
            $edit = $this->db->update('history_transaksi', array('status' => $statuslater, 'id_driver' => $driverid));
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function accept_request($cond)
    {
        $idtrans = $cond['id_transaksi'];

        $this->db->select('*');
        $this->db->from('transaksi');
        $this->db->where('id',$idtrans);
        $cek = $this->db->get();

        if ($cek->row('bridging') == 2) {  
            $this->db->where('id_driver', 'D0');
            $this->db->where('id_transaksi', $cond['id_transaksi']);
            $this->db->where("(status = '0')", NULL, FALSE);
            $this->db->from('history_transaksi');
            $cek_once = $this->db->get();
            if ($cek_once->num_rows() > 0) {
                $data = array(
                    'status' => '12',
                    'id_driver' => $cond['id_driver']
                );
                $this->db->where('id_driver', 'D0');
                $this->db->where('id_transaksi', $cond['id_transaksi']);
                $edit = $this->db->update('history_transaksi', $data);
    
                if ($this->db->affected_rows() > 0) {
                    $this->db->where('id', $cond['id_transaksi']);
                    $update_trans = $this->db->update('transaksi', array('id_driver' => $cond['id_driver']));
    
                    $datD = array(
                        'status' => '12'
                    );
                    $this->db->where(array('id_driver' => $cond['id_driver']));
                    $updDriver = $this->db->update('config_mitrajasa', $datD);
                    return array(
                        'status' => true,
                        'data' => []
                    );
                } else {
                    return array(
                        'status' => false,
                        'data' => []
                    );
                }
            } else {
                return array(
                    'status' => false,
                    'data' => 'canceled'
                );
            }

        } else {  
            $this->db->where('id_driver', 'D0');
            $this->db->where('id_transaksi', $cond['id_transaksi']);
            $this->db->where("(status = '1')", NULL, FALSE);
            $this->db->from('history_transaksi');
            $cek_once = $this->db->get();
            if ($cek_once->num_rows() > 0) {
                $data = array(
                    'status' => '2',
                    'id_driver' => $cond['id_driver']
                );
                $this->db->where('id_driver', 'D0');
                $this->db->where('id_transaksi', $cond['id_transaksi']);
                $edit = $this->db->update('history_transaksi', $data);
    
                if ($this->db->affected_rows() > 0) {
                    $this->db->where('id', $cond['id_transaksi']);
                    $update_trans = $this->db->update('transaksi', array('id_driver' => $cond['id_driver']));
    
                    $datD = array(
                        'status' => '2'
                    );
                    $this->db->where(array('id_driver' => $cond['id_driver']));
                    $updDriver = $this->db->update('config_mitrajasa', $datD);
                    return array(
                        'status' => true,
                        'data' => []
                    );
                } else {
                    return array(
                        'status' => false,
                        'data' => []
                    );
                }
            } else {
                return array(
                    'status' => false,
                    'data' => 'canceled'
                );
            }
            
        }  

    }

    public function start_request($cond)
    {

        $this->db->where($cond);
        $this->db->where('status', '2');
        $this->db->from('history_transaksi');
        $cek_once = $this->db->get();
        if ($cek_once->num_rows() > 0) {
            $data = array(
                'status' => '3',
                'id_driver' => $cond['id_driver']
            );
            $this->db->where($cond);
            $edit = $this->db->update('history_transaksi', $data);
            if ($this->db->affected_rows() > 0) {
                $datD = array(
                    'status' => '3'
                );
                $this->db->where(array('id_driver' => $cond['id_driver']));
                $updDriver = $this->db->update('config_mitrajasa', $datD);
                return array(
                    'status' => true,
                    'data' => []
                );
            } else {
                return array(
                    'status' => false,
                    'data' => []
                );
            }
        } else {
            $datD = array(
                'status' => '1'
            );
            $this->db->where(array('id_driver' => $cond['id_driver']));

            $updDriver = $this->db->update('config_mitrajasa', $datD);
            return array(
                'status' => false,
                'data' => 'canceled'
            );
        }
    }

    public function finish_request($cond, $condtr)
    {
        $this->db->where($condtr);
        $this->db->update('transaksi', array('waktu_selesai' => date('Y-m-d H:i:s')));
       

        if ($this->db->affected_rows() > 0) {
            $last_trans = $this->get_data_last_transaksi($condtr);
            //var_dump($last_trans);
            $get_mitra = $this->get_trans_merchant($last_trans->row('id_transaksi'));
            $datapelanggan = $this->get_data_pelangganid($last_trans->row('id_pelanggan'));
            $datadriver = $this->get_data_driverid($cond['id_driver']);

            $data_cut = array(
                'id_driver' => $cond['id_driver'],
                'harga' => $last_trans->row('harga'),
                'biaya_akhir' => $last_trans->row('biaya_akhir'),
                'kredit_promo' => $last_trans->row('kredit_promo'),
                'now_later' => $last_trans->row('now_later'),
                'bridging' => $last_trans->row('bridging'),
                'id_transaksi' => $last_trans->row('id_transaksi'),
                'fitur' => $last_trans->row('fitur'),
                'order_fitur' => $last_trans->row('order_fitur'),
                'nama_driver' => $datadriver->row('nama_driver'),
                'pakai_wallet' => $last_trans->row('pakai_wallet')
            );
            $dataC = array(
                'id_pelanggan' => $last_trans->row('id_pelanggan'),
                'harga' => $last_trans->row('harga'),
                'biaya_akhir' => $last_trans->row('biaya_akhir'),
                'kredit_promo' => $last_trans->row('kredit_promo'),
                'now_later' => $last_trans->row('now_later'),
                'bridging' => $last_trans->row('bridging'),
                'id_transaksi' => $last_trans->row('id_transaksi'),
                'pakai_wallet' => $last_trans->row('pakai_wallet'),
                'order_fitur' => $last_trans->row('order_fitur'),
                'nama_pelanggan' => $datapelanggan->row('fullnama'),
                'fitur' => $last_trans->row('fitur')
            );
            if ($last_trans->row('home') == 4) {

                $data_cut_mitra = array(
                    'id_mitra' => $get_mitra->row('id_mitra'),
                    'harga' => $get_mitra->row('total_biaya'),
                    'biaya_akhir' => $last_trans->row('biaya_akhir'),
                    'kredit_promo' => $last_trans->row('kredit_promo'),
                    'id_transaksi' => $last_trans->row('id_transaksi'),
                    'fitur' => $last_trans->row('fitur'),
                    'order_fitur' => $last_trans->row('order_fitur'),
                    'nama_mitra' => $get_mitra->row('nama_mitra'),
                    'pakai_wallet' => $last_trans->row('pakai_wallet')
                );
                $this->cut_mitra_saldo_by_order($data_cut_mitra);
                $this->delete_chat($get_mitra->row('id_merchant'), $last_trans->row('id_pelanggan'));
                $this->delete_chat($get_mitra->row('id_merchant'), $cond['id_driver']);
            };

            $cutUser = $this->cut_user_saldo_by_order($dataC);
            $cutting = $this->cut_driver_saldo_by_order($data_cut);


            if ($cutting['status']) {
                $this->delete_chat($cond['id_driver'], $last_trans->row('id_pelanggan'));
                $data = array(
                    'status' => '4'
                );
                $this->db->where($cond);
                $this->db->update('history_transaksi', $data);
                $datD = array(
                    'status' => '1'
                );
                $this->db->where(array('id_driver' => $cond['id_driver']));
                $this->db->update('config_mitrajasa', $datD);
                return array(
                    'status' => true,
                    'data' => $last_trans->result(),
                    'idp' => $last_trans->row('id_pelanggan'),
                );
            } else {
                return array(
                    'status' => false,
                    'data' => $cutting //'false in cutting'
                );
            }
        } else {
            return array(
                'status' => false,
                'data' => 'abc'
            );
        }
    }

    public function get_data_pelangganid($id)
    {
        $this->db->select('pelanggan.*, saldo.saldo');
        $this->db->from('pelanggan');
        $this->db->join('saldo', 'pelanggan.id = saldo.id_user');
        $this->db->where('id', $id);
        return $this->db->get();
    }

    public function get_data_driverid($id)
    {
        $this->db->select('driver.*, saldo.saldo');
        $this->db->from('mitrajasa');
        $this->db->join('saldo', 'driver.id = saldo.id_user');
        $this->db->where('id', $id);
        return $this->db->get();
    }

    function cut_user_saldo_by_order($dataC)
    {

        $this->db->where('id_user', $dataC['id_pelanggan']);
        $saldo = $this->db->get('saldo')->row('saldo');
        $saldonew = $saldo - $dataC['biaya_akhir'];

        if ($dataC['pakai_wallet'] == 1) {
            if($dataC['bridging'] != 2){
            $data_ins = array(
                'id_user' => $dataC['id_pelanggan'],
                'jumlah' => $dataC['biaya_akhir'],
                'saldo_awal' => $saldo,
                'saldo_akhir' => $saldonew,
                'bank' => $dataC['fitur'],
                'nama_pemilik' => $dataC['nama_pelanggan'],
                'rekening' => 'wallet',
                'type' => 'Order-'
            );
            $ins_trans = $this->db->insert('wallet', $data_ins);
            if ($ins_trans) {
                $this->db->where('id_user', $dataC['id_pelanggan']);
                $upd = $this->db->update('saldo', array('saldo' => $saldonew));
            } else {
                return false;
            }

        }
        }
    }

    function cut_driver_saldo_by_order($data)
    {
        $this->db->select('komisi');
        $this->db->where('id_fitur', $data['order_fitur']);
        $persen = $this->db->get('fitur')->row('komisi'); 

        //amount deduct
        $this->db->where('id_transaksi', $data['id_transaksi']);
        $deduct = $this->db->get('transaksi_jurnal')->row('amount_deducted_from_driver_wallet');

        //saldo deposit
        $this->db->where('id_user', $data['id_driver']);
        $saldo = $this->db->get('saldo')->row('saldo');

        //saldo transaction
        $this->db->where('id_user', $data['id_driver']);
        $saldotrx = $this->db->get('saldo')->row('saldotrx');
      
        if ($data['pakai_wallet'] == 1) {
            $kred = $data['harga'];
            if($data['bridging'] == 2){
                $potongan = 0;
            } else {
                $potongan = $kred * ($persen / 100);
            }
            
            //$hasil = $kred - $potongan;
            $hasil = $kred - $deduct;
            $saldonew = $saldotrx + $hasil;

            $data_ins = array(
                'id_user' => $data['id_driver'],
                'jumlah' => $hasil,
                'saldo_awal' => $saldotrx,
                'saldo_akhir' => $saldonew,
                'bank' => $data['fitur']." ".$data['id_transaksi'],
                'nama_pemilik' => $data['nama_driver'],
                'rekening' => 'wallet',
                'notes' => $data['fitur']."-".$data['id_transaksi'],
                'type' => 'Order+'
            );
            $ins_trans = $this->db->insert('wallettrx', $data_ins);
            if ($ins_trans) {
                $this->db->where('id_user', $data['id_driver']);
                $upd = $this->db->update('saldo', array('saldotrx' => $saldonew));
                if ($upd) {
                    return array(
                        'status' => true,
                        'data' => array('saldotrx' => $saldonew)
                    );
                } else {
                    return array(
                        'status' => false,
                        'data' => 'fail in update wallet'
                    );
                }
            } else {
                return array(
                    'status' => false,
                    'data' => []
                );
            }
        } else {
            $this->db->where('id_transaksi', $data['id_transaksi']);
            $deduct = $this->db->get('transaksi_jurnal')->row('amount_deducted_from_driver_wallet');
            $saldonew = $saldo - $deduct;
            $data_ins = array(
                'id_user' => $data['id_driver'], 
                'jumlah' => $deduct,
                'saldo_awal' => $saldo,
                'saldo_akhir' => $saldonew, 
                'bank' => $data['fitur']." ".$data['id_transaksi'],
                'nama_pemilik' => $data['nama_driver'],
                'rekening' => 'wallet',
                'notes' => $data['fitur']."-".$data['id_transaksi'],
                'type' => 'Order-'
            );
            $ins_trans = $this->db->insert('wallet', $data_ins);
            if ($ins_trans) {
                $this->db->where('id_user', $data['id_driver']);
                $upd = $this->db->update('saldo', array('saldo' => $saldonew));
                if ($upd) {
                    return array(
                        'status' => true,
                        'data' => []
                    );
                } else {
                    return array(
                        'status' => false,
                        'data' =>  []
                    );
                }
            } else {
                return array(
                    'status' => false,
                    'data' => []
                );
            }
        }
    }

    function cut_mitra_saldo_by_order($data)
    {
        $this->db->select('komisi');
        $this->db->where('id_fitur', $data['order_fitur']);
        $persen = $this->db->get('fitur')->row('komisi');  //persentase

        $this->db->where('id_user', $data['id_mitra']);
        $saldo = $this->db->get('saldo')->row('saldo');
        if ($data['pakai_wallet'] == 1) { 
            $kred = $data['harga'];
            $potongan = $kred * ($persen / 100);
            $hasil = $kred - $potongan;

            $data_ins = array(
                'id_user' => $data['id_mitra'],
                'jumlah' => $hasil,
                'bank' => $data['fitur'],
                'nama_pemilik' => $data['nama_mitra'],
                'rekening' => 'wallet',
                'type' => 'Order+'
            );
            $ins_trans = $this->db->insert('wallet', $data_ins);
            if ($ins_trans) {
                $this->db->where('id_user', $data['id_mitra']);
                $upd = $this->db->update('saldo', array('saldo' => ($saldo + $hasil)));
                if ($this->db->affected_rows() > 0) {
                    return array(
                        'status' => true,
                        'data' => array('saldo' => ($saldo + $hasil))
                    );
                } else {
                    return array(
                        'status' => false,
                        'data' => 'fail in update'
                    );
                }
            } else {
                return array(
                    'status' => false,
                    'data' => []
                );
            }
        } else {
            $hasil = $data['harga'] * ($persen / 100);
            $data_ins = array(
                'id_user' => $data['id_mitra'],
                'jumlah' => $hasil,
                'bank' => $data['fitur'],
                'nama_pemilik' => $data['nama_mitra'],
                'rekening' => 'wallet',
                'type' => 'Order-'
            );
            $ins_trans = $this->db->insert('wallet', $data_ins);
            if ($ins_trans) {
                $this->db->where('id_user', $data['id_mitra']);
                $upd = $this->db->update('saldo', array('saldo' => ($saldo - $hasil)));
                if ($this->db->affected_rows() > 0) {
                    return array(
                        'status' => true,
                        'data' => []
                    );
                } else {
                    return array(
                        'status' => false,
                        'data' => 'fail in update'
                    );
                }
            } else {
                return array(
                    'status' => false,
                    'data' => []
                );
            }
        }
    }

    function get_data_last_transaksi($cond)
    {
        $this->db->select('id as id_transaksi,'
            . '(waktu_selesai - waktu_order) as lama,'
            . 'waktu_selesai,'
            . 'harga,'
            . 'biaya_akhir,'
            . 'kredit_promo,'
            . 'order_fitur,'
            . 'now_later,'
            . 'bridging,'
            . 'id_pelanggan,'
            . 'fitur.home, fitur.fitur,'
            . 'pakai_wallet');
        $this->db->from('transaksi');
        $this->db->join('fitur', 'transaksi.order_fitur = fitur.id_fitur', 'left');
        $this->db->where($cond);
        $cek = $this->db->get();
        return $cek;
    }



    function all_transaksi($iduser)
    {
        $this->db->select('*');
        $this->db->from('transaksi');
        $this->db->join('transaksi_detail_merchant', 'transaksi.id = transaksi_detail_merchant.id_transaksi', 'left');
        $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi', 'left');
        $this->db->join('status_transaksi', 'history_transaksi.status = status_transaksi.id', 'left');
        $this->db->join('fitur', 'transaksi.order_fitur = fitur.id_fitur', 'left');
        $this->db->where('transaksi.id_driver', $iduser);
        $this->db->where('history_transaksi.status != 1');
        $this->db->where('history_transaksi.status != 2');
        $this->db->where('history_transaksi.status != 3');
        $this->db->where('history_transaksi.status != 11');
        $this->db->where('history_transaksi.status != 12');
        $this->db->where('history_transaksi.status != 0');
        $this->db->order_by('transaksi.waktu_order', 'DESC');
        $trans = $this->db->get();
        return $trans;
    }

    function book_history($iddriver)
    {
 
        $this->db->select('driver.*,saldo.*');
        $this->db->from('mitrajasa');
        $this->db->join('saldo', 'saldo.id_user= driver.id', 'left');
        $this->db->where('id',$iddriver);
        //$this->db->where('berkah','1');
        $driver = $this->db->get();

        $region_code = $driver->row('region_code');
        $berkah = $driver->row('berkah');
        $saldo = $driver->row('saldo');

        $trans = $this->db->query("select a.*,b.*,c.*,d.status_transaksi,e.* from transaksi a left join transaksi_detail_merchant b on a.id=b.id_transaksi left join history_transaksi c on a.id=c.id_transaksi left join status_transaksi d on c.status=d.id left join fitur e on a.order_fitur=e.id_fitur where (a.id_driver='$iddriver' and a.now_later='2' and a.region_code='$region_code' and c.status ='12') or a.id_driver is null and a.now_later='2' and a.region_code='$region_code'and c.status ='0' order by d.status_transaksi DESC");
        if($berkah == 1 && $region_code==11 && $saldo>=5000000){
            return $trans;
        } else if($berkah == 1 && $region_code<>11){
            return $trans;
        } else {
            $trans = $this->db->query("select a.*,b.*,c.*,d.status_transaksi,e.* from transaksi a left join transaksi_detail_merchant b on a.id=b.id_transaksi left join history_transaksi c on a.id=c.id_transaksi left join status_transaksi d on c.status=d.id left join fitur e on a.order_fitur=e.id_fitur where a.id_driver is null and a.now_later='2' and a.region_code='100'and c.status ='0' order by d.status_transaksi DESC");
            return $trans;
        }
    }
    
    function delete_chat($otherid, $userid)
    {
        $headers = array(
            "Accept: application/json",
            "Content-Type: application/json"
        );
        $data3 = array();
        $url3 = firebaseDb . '/chat/' . $otherid . '-' . $userid . '/.json';
        $ch3 = curl_init($url3);

        curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch3, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch3, CURLOPT_POSTFIELDS, json_encode($data3));
        curl_setopt($ch3, CURLOPT_HTTPHEADER, $headers);

        $return3 = curl_exec($ch3);

        $json_data3 = json_decode($return3, true);

        $data2 = array();

        $url2 = firebaseDb . '/chat/' . $userid . '-' . $otherid . '/.json';
        $ch2 = curl_init($url2);

        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch2, CURLOPT_POSTFIELDS, json_encode($data2));
        curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers);

        $return2 = curl_exec($ch2);

        $json_data2 = json_decode($return2, true);

        $data1 = array();

        $url1 = firebaseDb . '/Inbox/' . $userid . '/' . $otherid . '/.json';
        $ch1 = curl_init($url1);

        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch1, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch1, CURLOPT_POSTFIELDS, json_encode($data1));
        curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers);

        $return1 = curl_exec($ch1);

        $json_data1 = json_decode($return1, true);

        $data = array();

        $url = firebaseDb . '/Inbox/' . $otherid . '/' . $userid . '/.json';
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $return = curl_exec($ch);

        $json_data = json_decode($return, true);
    }


    public function getAlldriver()
    {
        $this->db->select('config_mitrajasa.status as status_job');
        $this->db->select('driver_job.driver_job');
        $this->db->select('driver.*');
        $this->db->select('saldo.*');
        $this->db->select('kendaraan.*');
        $this->db->select('country_areas.area_name');
        $this->db->join('config_mitrajasa', 'driver.id = config_mitrajasa.id_driver', 'left');
        $this->db->join('saldo', 'saldo.id_user = driver.id', 'left');
        $this->db->join('kendaraan', 'kendaraan.id_k = driver.kendaraan', 'left');
        $this->db->join('driver_job', 'driver.job = driver_job.id', 'left');
        $this->db->join('country_areas', 'country_areas.id = driver.region_code', 'left');
        return  $this->db->get('mitrajasa')->result_array();
    }

    public function getAlldriverby($job, $status,$statusjob, $area, $string)
    {
        $this->db->select('config_mitrajasa.status as status_job');
        $this->db->select('driver_job.driver_job');
        $this->db->select('driver.*');
        $this->db->select('saldo.*');
        $this->db->select('kendaraan.*');
        $this->db->select('country_areas.area_name');
        $this->db->join('config_mitrajasa', 'driver.id = config_mitrajasa.id_driver', 'left');
        $this->db->join('saldo', 'saldo.id_user = driver.id', 'left');
        $this->db->join('kendaraan', 'kendaraan.id_k = driver.kendaraan', 'left');
        $this->db->join('driver_job', 'driver.job = driver_job.id', 'left');
        $this->db->join('country_areas', 'country_areas.id = driver.region_code', 'left');
        $this->db->like('driver.job', $job);
        $this->db->like('driver.status', $status);
        $this->db->like('config_mitrajasa.status', $statusjob);        
        $this->db->like('driver.region_code', $area);        
        if($string<>''){
            $this->db->like('driver.nama_driver', $string);
            $this->db->or_like('driver.no_telepon', $string);
            $this->db->or_like('driver.email', $string);
        }
        
        return  $this->db->get('mitrajasa')->result_array();
    }

    public function getdriverbyid($id)
    {
        $this->db->select('kendaraan.*');
        $this->db->select('saldo.*');
        $this->db->select('config_mitrajasa.status as status_job');
        $this->db->select('driver_job.driver_job');
        $this->db->select('berkas_driver.*');
        $this->db->select('driver.*');
        $this->db->join('kendaraan', 'driver.kendaraan = kendaraan.id_k', 'left');
        $this->db->join('saldo', 'driver.id = saldo.id_user', 'left');
        $this->db->join('config_mitrajasa', 'driver.id = config_mitrajasa.id_driver', 'left');
        $this->db->join('driver_job', 'driver.job = driver_job.id', 'left');
        $this->db->join('berkas_driver', 'driver.id = berkas_driver.id_driver', 'left');
        return  $this->db->get_where('mitrajasa', ['driver.id' => $id])->row_array();
    }

    public function countorder($id)
    {
        $this->db->select('id_driver');
        $query = $this->db->get_where('transaksi', ['id_driver' => $id])->result_array();
        return count($query);
    }

    public function wallet($id)
    {
        $this->db->order_by('wallet.id', 'DESC');
        return $this->db->get_where('wallet', ['id_user' => $id])->result_array();
    }

    public function wallettrx($id)
    {
        $this->db->order_by('wallettrx.id', 'DESC');
        return $this->db->get_where('wallettrx', ['id_user' => $id])->result_array();
    }

    public function transaksi($id)
    {
        $this->db->select('status_transaksi.*');
        $this->db->select('history_transaksi.*');
        $this->db->select('fitur.*');
        $this->db->select('transaksi.*');
        $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi', 'left');
        $this->db->join('status_transaksi', 'history_transaksi.status = status_transaksi.id', 'left');
        $this->db->join('fitur', 'transaksi.order_fitur = fitur.id_fitur', 'left');
        $this->db->order_by('transaksi.id', 'DESC');
        $this->db->where('history_transaksi.status != 1');
        return $this->db->get_where('transaksi', ['transaksi.id_driver' => $id])->result_array();
    }

    public function transaksidrv($id)
    {
        return $this->db->query("SELECT * FROM `transaksi` WHERE `id` = '$id' AND `id_driver` IS NULL ORDER BY `id` DESC")->row();
    }

    public function transaksidet($id)
    {
        return $this->db->query("SELECT * FROM `transaksi` WHERE `id` = '$id'")->row();
    }

    public function ubahdataid($data)
    {
        $this->db->set('nama_driver', $data['nama_driver']);
        $this->db->set('email', $data['email']);
        $this->db->set('countrycode', $data['countrycode']);
        $this->db->set('phone', $data['phone']);
        $this->db->set('no_telepon', $data['no_telepon']);
        $this->db->set('tempat_lahir', $data['tempat_lahir']);
        $this->db->set('tgl_lahir', $data['tgl_lahir']);
        $this->db->set('alamat_driver', $data['alamat_driver']);

        $this->db->where('id', $data['id']);
        $this->db->update('mitrajasa', $data);
    }

    public function ubahdatakendaraan($data, $data2)
    {
        $this->db->set('jenis', $data['jenis']);
        $this->db->set('merek', $data['merek']);
        $this->db->set('tipe', $data['tipe']);
        $this->db->set('nomor_kendaraan', $data['nomor_kendaraan']);
        $this->db->set('warna', $data['warna']);


        $this->db->where('id_k', $data['id_k']);
        $this->db->update('kendaraan', $data);

        $this->db->set('job', $data2['job']);
        $this->db->where('id', $data2['id']);
        $this->db->update('mitrajasa', $data2);
    }

    public function ubahdatafoto($data)
    {
        $this->db->set('foto', $data['foto']);

        $this->db->where('id', $data['id']);
        $this->db->update('mitrajasa', $data);
    }

    public function ubahdatapassword($data)
    {
        $this->db->set('password', $data['password']);

        $this->db->where('id', $data['id']);
        $this->db->update('mitrajasa', $data);
    }

    public function blockdriverbyid($id)
    {
        $this->db->set('status', 3);
        $this->db->where('id', $id);
        $this->db->update('mitrajasa');

        $this->db->set('status', 5);
        $this->db->where('id_driver', $id);
        $this->db->update('config_mitrajasa');
    }

    public function unblockdriverbyid($id)
    {
        $this->db->set('status', 1);
        $this->db->where('id', $id);
        $this->db->update('mitrajasa');
    }

    public function ubahdatacard($data, $data2)
    {

        $this->db->set('foto_ktp', $data['foto_ktp']);
        $this->db->set('foto_sim', $data['foto_sim']);
        $this->db->set('id_sim', $data['id_sim']);
        $this->db->where('id_driver', $data['id']);
        $this->db->update('berkas_driver');

        $this->db->set('no_ktp', $data2['no_ktp']);
        $this->db->where('id', $data2['id']);
        $this->db->update('mitrajasa');
    }

    public function driverjob()
    {
        return $this->db->get('driver_job')->result_array();
    }

    public function hapusdriverbyid($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('mitrajasa');

        $this->db->where('id_driver', $id);
        $this->db->delete('config_mitrajasa');

        $this->db->where('id_driver', $id);
        $this->db->delete('transaksi');

        $this->db->where('id_user', $id);
        $this->db->delete('saldo');

        $this->db->where('id_driver', $id);
        $this->db->delete('history_transaksi');

        $this->db->where('id_driver', $id);
        $this->db->delete('berkas_driver');

        $this->db->where('userid', $id);
        $this->db->delete('forgot_password');

        $this->db->where('id_driver', $id);
        $this->db->delete('rating_driver');

        $this->db->where('id_user', $id);
        $this->db->delete('wallet');
    }

    public function tambahdatadriver($datadriver)
    {
        $this->db->insert('mitrajasa');
    }

    public function ubahstatusnewreg($id)
    {
        $this->db->set('status', 1);
        $this->db->where('id', $id);
        $this->db->update('mitrajasa');
    }

    public function get_trans_merchant($idtransaksi)
    {
        $this->db->select('mitra.*,transaksi_detail_merchant.id_merchant,transaksi_detail_merchant.total_biaya');
        $this->db->from('transaksi_detail_merchant');
        $this->db->join('mitra', 'transaksi_detail_merchant.id_merchant = mitra.id_merchant');
        $this->db->where('id_transaksi', $idtransaksi);
        return $this->db->get();
    }

    public function get_verify($data)
    {
        $this->db->select('*');
        $this->db->from('transaksi_detail_merchant');
        $this->db->where($data);
        return $this->db->get();
    }
}
