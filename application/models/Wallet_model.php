<?php


class wallet_model extends CI_model
{
    public function getwallet($tgl)
    {
        $this->db->select('mitra.nama_mitra');
        $this->db->select('driver.nama_driver');
        $this->db->select('pelanggan.fullnama');
        $this->db->select('wallet.*');
        $this->db->join('mitra', 'wallet.id_user = mitra.id_mitra', 'left');
        $this->db->join('driver', 'wallet.id_user = driver.id', 'left');
        $this->db->join('pelanggan', 'wallet.id_user = pelanggan.id', 'left');
        $this->db->like('wallet.waktu', $tgl);
        $this->db->order_by('wallet.id', 'DESC');
        return $this->db->get('wallet')->result_array();
    }

    public function getwalletxtrx($tgl)
    {
        $this->db->select('mitra.nama_mitra');
        $this->db->select('driver.nama_driver, driver.email');
        $this->db->select('pelanggan.fullnama');
        $this->db->select('wallettrx.*');
        $this->db->join('mitra', 'wallettrx.id_user = mitra.id_mitra', 'left');
        $this->db->join('driver', 'wallettrx.id_user = driver.id', 'left');
        $this->db->join('pelanggan', 'wallettrx.id_user = pelanggan.id', 'left');
        $this->db->like('wallettrx.waktu', $tgl);
        $this->db->order_by('wallettrx.id', 'DESC');
        return $this->db->get('wallettrx')->result_array();
    }
    
    public function getmutasi($tgl)
    {
        $this->db->select('smart_mutasi_bca.*');
        $this->db->like('smart_mutasi_bca.created', $tgl);
        $this->db->order_by('smart_mutasi_bca.id', 'DESC');
        return $this->db->get('smart_mutasi_bca')->result_array();
    }
    
    public function getgvnotif($tgl)
    {
        $this->db->select('gv_notification.*');
        $this->db->like('gv_notification.created', $tgl);
        $this->db->order_by('gv_notification.id', 'DESC');
        return $this->db->get('gv_notification')->result_array();
    }

    public function getwallettrx()
    {
        //$this->db->select('mitra.nama_mitra'); 
        $this->db->select('driver.*');
        //$this->db->select('pelanggan.fullnama');
        $this->db->select('wallettrx.*');
        //$this->db->join('mitra', 'wallettrx.id_user = mitra.id_mitra', 'left');
        $this->db->join('driver', 'wallettrx.id_user = driver.id', 'left');
        //$this->db->join('pelanggan', 'wallettrx.id_user = pelanggan.id', 'left'); 
        $this->db->order_by('wallettrx.id', 'DESC');
        return $this->db->get('wallettrx')->result_array();
    }

    public function gettokenmerchant($id_user)

    {
        $this->db->select('mitra.*');
        $this->db->select('merchant.token_merchant');
        $this->db->join('merchant', 'mitra.id_merchant = merchant.id_merchant', 'left');
        $this->db->where('mitra.id_mitra', $id_user);
        return $this->db->get('mitra')->row_array();
    }
    
    public function ubahsaldotopupqris($id_user, $saldo)
    {
        $this->db->set('saldo', $saldo);
        $this->db->where('id_user', $id_user);
        $this->db->update('saldo');
    }

    public function ubahsaldotopup($id_user, $amount, $saldo)
    {
        // $this->db->where('id_user', $dataC['id_pelanggan']);
        // $upd = $this->db->update('saldo', array('saldo' => ($saldo - $dataC['biaya_akhir'])));
        $this->db->set('saldo', $saldo['saldo'] + $amount);
        $this->db->where('id_user', $id_user);
        $this->db->update('saldo');
    }

    public function getwalletbyid($id)
    {
        $this->db->select('driver.nama_driver');
        $this->db->select('pelanggan.fullnama');
        $this->db->select('wallet.*');
        $this->db->join('driver', 'wallet.id_user = driver.id', 'left');
        $this->db->join('pelanggan', 'wallet.id_user = pelanggan.id', 'left');
        return $this->db->get_where('wallet', ['wallet.id' => $id])->row_array();
    }

    public function getallsaldo()
    {
        $this->db->select('SUM(jumlah)as total');
        return $this->db->get('wallet')->row_array();
    }

    public function getjumlahdiskon()
    {
        $this->db->select('SUM(kredit_promo) as diskon');
        return $this->db->get('transaksi')->row_array();
    }

    public function getallsaldouser()
    {
        $this->db->select('mitra.nama_mitra');
        $this->db->select('driver.nama_driver');
        $this->db->select('pelanggan.fullnama');
        $this->db->select('saldo.*');
        $this->db->join('mitra', 'saldo.id_user = mitra.id_mitra', 'left');
        $this->db->join('driver', 'saldo.id_user = driver.id', 'left');
        $this->db->join('pelanggan', 'saldo.id_user = pelanggan.id', 'left');
        return $this->db->get('saldo')->result_array();
    }

    public function gettotaltopup($tgl)
    {
        $this->db->select('SUM(jumlah)as total');
        $this->db->where('status', 1);
        $this->db->where('type', 'topup');
        $this->db->like('waktu', $tgl);
        return $this->db->get('wallet')->row_array();
    }

    public function gettotalwithdraw()
    {
        $this->db->select('SUM(jumlah)as total');
        $this->db->where('type', 'withdraw');
        $this->db->where('status', 1);
        $this->db->like('wallet.waktu', $tgl);
        return $this->db->get('wallet')->row_array();
    }

    public function gettotalwithdrawtrx($tgl)
    {
        $this->db->select('SUM(jumlah)as total');
        $this->db->where('type', 'withdraw');
        $this->db->where('status', 1);
        $this->db->like('wallettrx.waktu', $tgl);
        return $this->db->get('wallettrx')->row_array();
    }

    public function gettotalorderplus()
    {
        $this->db->select('SUM(jumlah)as total');
        $this->db->where('type', 'Order+');
        return $this->db->get('wallet')->row_array();
    }

    public function gettotalordermin()
    {
        $this->db->select('SUM(jumlah)as total');
        $this->db->where('type', 'Order-');
        return $this->db->get('wallet')->row_array();
    }

    public function ubahstatuswithdrawbyid($id,$name, $via)
    {
        $this->db->set('aprovel', $name);
        $this->db->set('status', 1);
        $this->db->set('topupvia', $via);
        $this->db->where('id', $id);
        $this->db->update('wallet');
    }

    public function ubahstatuswithdrawbyidtrx($id,$name)
    {
        $this->db->set('status', 1);
        $this->db->set('aprovel', $name);
        $this->db->where('id', $id);
        $this->db->update('wallettrx');
    }

    public function cancelstatuswithdrawbyidtrx($id,$name)
    {
        $this->db->set('aprovel', $name);
        $this->db->set('status', 2);
        $this->db->where('id', $id);
        $this->db->update('wallettrx');
    }

    public function cancelstatuswithdrawbyid($id,$name)
    {
        $this->db->set('aprovel', $name);
        $this->db->set('status', 2);
        $this->db->where('id', $id);
        $this->db->update('wallet');
    }

    public function gettoken($id_user)

    {
        $this->db->select('token');
        $this->db->where('id', $id_user);
        return $this->db->get('pelanggan')->row_array();
    }

    public function getregid($id_user)
    {
        $this->db->select('reg_id');
        $this->db->where('id', $id_user);
        return $this->db->get('driver')->row_array();
    }

    public function getsaldo($id_user)
    {
        $this->db->select('saldo');
        $this->db->where('id_user', $id_user);
        return $this->db->get('saldo')->row_array();
    }

    public function getsaldotrx($id_user)
    {
        $this->db->select('saldotrx');
        $this->db->where('id_user', $id_user);
        return $this->db->get('saldo')->row_array();
    }

    public function ubahsaldo($id_user, $amount, $saldo)
    {
        // $this->db->where('id_user', $dataC['id_pelanggan']);
        // $upd = $this->db->update('saldo', array('saldo' => ($saldo - $dataC['biaya_akhir'])));
        $this->db->set('saldo', $saldo['saldo'] - $amount);
        $this->db->where('id_user', $id_user);
        $this->db->update('saldo');
    }

    public function ubahsaldotrx($id_user, $amount, $saldotrx)
    {
        // $this->db->where('id_user', $dataC['id_pelanggan']);
        // $upd = $this->db->update('saldo', array('saldo' => ($saldo - $dataC['biaya_akhir'])));
        $this->db->set('saldotrx', $saldotrx['saldotrx'] - $amount);
        $this->db->where('id_user', $id_user);
        $this->db->update('saldo');
    }

    public function send_notif($title, $message, $topic)
    {

        $data = array(
            'title' => $title,
            'message' => $message,
            'type' => 4
        );
        $senderdata = array(
            'data' => $data,
            'to' => $topic
        );

        $headers = array(
            'Content-Type:application/json',
            'Authorization:key=' . keyfcm
        );
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($senderdata),
            CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        return $response;
    }

    public function updatesaldowallet($data,$name)
    {
        $this->db->select('mitra.nama_mitra');
        $this->db->select('driver.nama_driver');
        $this->db->select('pelanggan.fullnama');
        $this->db->select('saldo.saldo as saldolama');
        $this->db->join('mitra', 'saldo.id_user = mitra.id_mitra', 'left');
        $this->db->join('driver', 'saldo.id_user = driver.id', 'left');
        $this->db->join('pelanggan', 'saldo.id_user = pelanggan.id', 'left');
        $this->db->where('id_user', $data['id_user']);
        $saldolama = $this->db->get('saldo')->row_array();

        $saldobaru = $saldolama['saldolama'] + $data['saldo'];

        $this->db->set('saldo', $saldobaru);
        $this->db->where('id_user', $data['id_user']);
        $this->db->update('saldo');

        if ($data['type_user'] == 'pelanggan') {
            $nama = $saldolama['fullnama'];
        } elseif ($data['type_user'] == 'mitra') {
            $nama = $saldolama['nama_mitra'];
        } else {
            $nama = $saldolama['nama_driver'];
        }

        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $notestopup = "TopupManual-".substr(str_shuffle($permitted_chars), 0, 10);
        $this->db->set('status', '1');
        $this->db->set('aprovel', $name);
        $this->db->set('type', 'topup');
        $this->db->set('rekening', $data['keterangan']);
        $this->db->set('bank', 'admin');
        $this->db->set('nama_pemilik', $nama);
        $this->db->set('jumlah', $data['saldo']);
        $this->db->set('saldo_awal', $saldolama['saldolama']);
        $this->db->set('saldo_akhir', $saldobaru);
        $this->db->set('id_user', $data['id_user']);
        $this->db->set('notes', $notestopup);
        $this->db->insert('wallet');
    }

    public function updatesaldowalletwithdraw($data, $data2)
    {
        $this->db->select('mitra.nama_mitra');
        $this->db->select('driver.nama_driver');
        $this->db->select('pelanggan.fullnama');
        $this->db->select('saldo.saldo as saldolama');
        $this->db->select('saldo.saldotrx as saldolamatrx');
        $this->db->join('mitra', 'saldo.id_user = mitra.id_mitra', 'left');
        $this->db->join('driver', 'saldo.id_user = driver.id', 'left');
        $this->db->join('pelanggan', 'saldo.id_user = pelanggan.id', 'left');
        $this->db->where('id_user', $data['id_user']);
        $saldolama = $this->db->get('saldo')->row_array();

        $saldobaru = $saldolama['saldolama'] - $data['saldo'];
        $saldobarutrx = $saldolama['saldolamatrx'] - $data['saldo'];

        if ($data['type_user'] == 'driver') {
            if ($saldobarutrx < 0) {
                $this->session->set_flashdata('salah', 'Not enaugh Balances');
                redirect('wallet/tambahwithdraw');
            } else {
                $this->db->set('saldotrx', $saldobarutrx);
                $this->db->where('id_user', $data['id_user']);
                $this->db->update('saldo');
    
                if ($data['type_user'] == 'pelanggan') {
                    $nama = $saldolama['fullnama'];
                } elseif ($data['type_user'] == 'mitra') {
                    $nama = $saldolama['nama_mitra'];
                } else {
                    $nama = $saldolama['nama_driver'];
                }
    
                $this->db->set('status', '1');
                $this->db->set('type', 'withdraw');
                $this->db->set('rekening', $data2['rekening']);
                $this->db->set('bank', $data2['bank']);
                $this->db->set('nama_pemilik', $data2['nama_pemilik']);
                $this->db->set('jumlah', $data['saldo']);
                $this->db->set('saldo_awal', $saldolama['saldolamatrx']);
                $this->db->set('saldo_akhir', $saldobarutrx);
                $this->db->set('id_user', $data['id_user']); 
                $this->db->insert('wallettrx');
            }
        } else {
            if ($saldobaru < 0) {
                $this->session->set_flashdata('salah', 'Not enaugh Balances');
                redirect('wallet/tambahwithdraw');
            } else {
                $this->db->set('saldo', $saldobaru);
                $this->db->where('id_user', $data['id_user']);
                $this->db->update('saldo');
    
                if ($data['type_user'] == 'pelanggan') {
                    $nama = $saldolama['fullnama'];
                } elseif ($data['type_user'] == 'mitra') {
                    $nama = $saldolama['nama_mitra'];
                } else {
                    $nama = $saldolama['nama_driver'];
                }
    
                $this->db->set('status', '1');
                $this->db->set('type', 'withdraw');
                $this->db->set('rekening', $data2['rekening']);
                $this->db->set('bank', $data2['bank']);
                $this->db->set('nama_pemilik', $data2['nama_pemilik']);
                $this->db->set('jumlah', $data['saldo']);
                $this->db->set('saldo_awal', $saldolama['saldolama']);
                $this->db->set('saldo_akhir', $saldobaru);
                $this->db->set('id_user', $data['id_user']); 
                $this->db->insert('wallet');
            }
        }
    }

    public function getwalletall()
    {
        $this->db->select('wallet.*');
        $this->db->select('merchant.token_merchant');
        $this->db->select('driver.reg_id');
        $this->db->select('pelanggan.token');
        $this->db->select('pelanggan.id,driver.id,mitra.id_mitra,merchant.id_merchant');
        $this->db->join('mitra', 'wallet.id_user=mitra.id_mitra', 'left');
        $this->db->join('merchant', 'mitra.id_merchant=merchant.id_merchant', 'left');
        $this->db->join('driver', 'wallet.id_user=driver.id', 'left');
        $this->db->join('pelanggan', 'wallet.id_user=pelanggan.id', 'left');
        return $this->db->get('wallet')->result_array();
    }

    public function updatekadaluarsa()
    {
        $this->load->model('Notification_model');

        $wallet = $this->getwalletall();




        foreach ($wallet as $wl) {



            $date1 = date_create($wl['expired']);
            $date = new DateTime('now', new DateTimeZone('Asia/Makassar'));


            $tanggal = date_format($date1, "YmdHis");

            $tanggal2 = date_format($date, "YmdHis");
            // var_dump($tanggal);
            // var_dump($tanggal2);
            // die();

            if ($tanggal <= $tanggal2 && $wl['status'] == 0 && $wl['expired'] != "") {
                // var_dump($tanggal);
                // var_dump($tanggal2);
                // die();
                $this->db->set('status', '2');

                $this->db->Where('status', '0');
                $this->db->Where('invoice', $wl['invoice']);
                $this->db->update('wallet');

                $id = substr($wl['id_user'], '0', '1');
                if ($id == 'M') {
                    $token = $wl['token_merchant'];
                } else if ($id == 'P') {
                    $token = $wl['token'];
                } else {
                    $token = $wl['reg_id'];
                }

                $title = 'Dibatalkan';
                $desc = 'Pembayaran Kamu telah Dibatalkan';
                $this->Notification_model->send_notif_topup($title, $wl['id_user'], $desc, $wl['invoice'], $token);
            }
        }
    }
    
    public function getkodeunik($cari)
    {
        $this->db->select('kode_unik');
        $this->db->where('kode_unik', $cari);
        $this->db->where('status', 0);
        $this->db->like('type', 'topup');
        return $this->db->get('wallet')->result();
    }
    
    public function getlasttopup($iddriver)
    {
        $this->db->select('id');
        $this->db->where('id_user', $iddriver);
        $this->db->where('status', 0);
        $this->db->like('type', 'topup');
        return $this->db->get('wallet')->result();
    }
}
