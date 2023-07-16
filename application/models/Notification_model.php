<?php

class notification_model extends CI_model
{
      public function send_notif_testing($title, $message, $token)
  {
       $url = "https://fcm.googleapis.com/fcm/send";
    $serverKey =  keyfcm ;
    $title = "Notification title";
    $body = "Hello I am from Your php server";
    $notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1');
    $arrayToSend = array('to' => $token, 'data' => $message);
    $json = json_encode($arrayToSend);
    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Authorization: key='. keyfcm;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
    //Send the request
    $response = curl_exec($ch);
    //Close request
    if ($response === FALSE) {
    die('FCM Send Error: ' . curl_error($ch));
    }
    curl_close($ch);
  }
  public function notif_cancel_user($id_driver, $id_transaksi, $token_user)
  {

    $datanotif = array(
      'id_driver' => $id_driver,
      'id_transaksi' => $id_transaksi,
      'response' => '5',
      'type' => 1
    );
    $senderdata = array(
      'data' => $datanotif,
      'to' => $token_user
    );
    $headers = array(
      "Content-Type: application/json",
      "Authorization: key=" . keyfcm
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
public function notif_accept_driver($id_transaksi, $token_driver)
  {

    $data = array(
      'id_pelanggan' => $id_transaksi,
      'id_transaksi' => '0',
      'response' => 1,
       'desc' => $id_transaksi,
      'invoice' => '0',
      'ordertime' => 1,
      'response' => '0',
      'type' => 1
    );
    $senderdata = array(
      'data' => $data,
      'to' => $token_driver
    );

    $headers = array(
      "Content-Type: application/json",
      'Authorization: key=' . keyfcm
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
  public function notif_cancel_driver($id_transaksi, $token_driver)
  {

    $data = array(
      'id_transaksi' => $id_transaksi,
      'response' => '0',
      'type' => 1
    );
    $senderdata = array(
      'data' => $data,
      'to' => $token_driver
    );

    $headers = array(
      "Content-Type: application/json",
      'Authorization: key=' . keyfcm
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

  public function send_notif($title, $message, $topic)
  {

    $data = array(
      'title' => $title,
      'message' => $message,
      'type' => 4
    );
    $senderdata = array(
      'data' => $data,
      'to' => '/topics/' . $topic
    );

    $headers = array(
      'Content-Type : application/json',
      'Authorization: key=' . keyfcm
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
  }

  public function send_notif_topup($title, $id, $message, $method, $token)
  {

    $data = array(
      'title' => $title,
      'id' => $id,
      'message' => $message,
      'method' => $method,
      'type' => 3
    );
    $senderdata = array(
      'data' => $data,
      'to' => $token

    );

    $headers = array(
      'Content-Type : application/json',
      'Authorization: key=' . keyfcm
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
  }

  public function send_notif_req_berkah($data_notif,$token)
  {

//   $data = array(
//         "alamat_asal"=> $data_notif['alamat_asal'],
//         "alamat_tujuan"=> $data_notif['alamat_tujuan'],
//         "estimasi_time"=> $data_notif['estimasi_time'],
//         "distance"=> $data_notif['distance'],
//         "biaya"=> "Rp ".$data_notif['biaya'],
//         "harga"=> $data_notif['harga'],
//         "id_transaksi"=> $data_notif['id_transaksi'],
//         "layanan"=> $data_notif['layanan'],
//         "layanandesc"=> $data_notif['layanandesc'],
//         "order_fitur"=> $data_notif['order_fitur'],
//         "pakai_wallet"=> $data_notif['pakai_wallet'],
//         "bridging"=> 2, 
//         "type"=> 1
//     );

    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Authorization: key='. keyfcm;
     $url = "https://fcm.googleapis.com/fcm/send";
     
    $arrayToSend = array("registration_ids" => $token, 'data' => $data_notif);
    $json = json_encode($arrayToSend);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST,"POST");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
    curl_setopt($curl, CURLOPT_HTTPHEADER,$headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl,CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
     curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
    curl_setopt($curl, CURLOPT_TIMEOUT,30);
    curl_setopt($curl,CURLOPT_ENCODING, "");
    // curl_setopt_array($curl, array(
    //   CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
    //   CURLOPT_RETURNTRANSFER => true,
    //   CURLOPT_ENCODING => "",
    //   CURLOPT_MAXREDIRS => 10,
    //   CURLOPT_TIMEOUT => 30,
    //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //   CURLOPT_CUSTOMREQUEST => "POST",
    //   CURLOPT_POSTFIELDS => json_encode($json),
    //   CURLOPT_HTTPHEADER => $headers,
    // ));
    $response = curl_exec($curl);
    // $err = curl_error($curl);
if ($response === FALSE) {
   return $response;
}
    curl_close($curl);
    return TRUE;
  }
  
  public function send_notif_request_order_bytopic($key,$data_notif,$regioncode)
  {

    $senderdata = array(
      'data' => $data_notif,
      'priority' => "high",
      'to' => "/topics/".$regioncode,
    );


    $headers = array(
      'Content-Type : application/json',
      'Authorization: key=' . keyfcm
    );

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => json_encode($senderdata),
      CURLOPT_HTTPHEADER => array(
        "Authorization: key=".keyfcm,
        "Content-Type: application/json"
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    //echo $response;
  }
  
}