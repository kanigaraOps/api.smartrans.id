<?php

class flip_model extends CI_model
{
  public function reqwd($flipamount,$bank,$card,$noteswd)
  {
    $ch = curl_init();
    $secret_key = "JDJ5JDEzJHZXS3B0Smx0L0gwb3ZLNUtvVUtRSmVQaDZZTVh6WHh1YlBwbFpYdTgzWmFPRnhHeS9xLldt";

    curl_setopt($ch, CURLOPT_URL, "https://sandbox.flip.id/api/v2/disbursement");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    
    curl_setopt($ch, CURLOPT_POST, TRUE);
    
    $payloads = [
        "account_number" => $card,
        "bank_code" => $bank,
        "amount" => $flipamount,
        "remark" => $noteswd
    ];

  
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payloads));
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Content-Type: application/x-www-form-urlencoded"
    ));
    
    curl_setopt($ch, CURLOPT_USERPWD, $secret_key.":");
    
    $response = curl_exec($ch);

    // Check HTTP status code
    if (!curl_errno($ch)) {
      switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
        case 200:  # OK
          return true;
          break;
        default:
          //echo 'Unexpected HTTP code: ', $http_code, "\n";
          return false;
      }
    }

    curl_close($ch);
  }

  public function input_transaksi_callback($transaksicallback)
  {
    $tes = $this->db->insert('fliptransaksi', $transaksicallback);
  }

  public function input_rekening_callback($rekeningcallback)
  {
    $this->db->insert('fliprekening', $rekeningcallback);    
  }

  public function detailwdflip($notes,$fee,$timeserved)
  {
    $datawithdraw = array(
      'admin_fee' => $fee,
      'charge' => 5000-$fee,
      'waktu_flip' => $timeserved,
      'status' => 1
    );

    $this->db->where('notes', $notes);
    $this->db->update('wallettrx', $datawithdraw);
    if ($this->db->affected_rows() > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function refundsaldotrx($notes, $timeserved)
  {
    $datawithdraw = array(
      'notes' => $notes."-CANCELED",
      'waktu_flip' => $timeserved,
      'status' => 2
    );

    $this->db->where('notes', $notes);
    $this->db->update('wallettrx', $datawithdraw);
   
    if ($this->db->affected_rows() > 0) {
          $this->db->select('wallettrx.*, saldo.*, driver.reg_id as reg_idx, wallettrx.id_user as id_userx, wallettrx.id as idx');
          $this->db->from('wallettrx');
          $this->db->join('saldo', 'wallettrx.id_user = saldo.id_user');
          $this->db->join('driver', 'wallettrx.id_user = driver.id');
          $this->db->like('wallettrx.notes', $notes);
          $userx = $this->db->get()->row_array();
          $saldolamatrx = $userx['saldotrx'];
          $saldobarutrx = $saldolamatrx + $userx['jumlah'];

    $this->db->set('saldotrx', $saldobarutrx);
    $this->db->where('id_user', $userx['id_userx']);
    $this->db->update('saldo');
    return $userx['reg_idx'];
    } else {
      return false;
    }
  }


}
