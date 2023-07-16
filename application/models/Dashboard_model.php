<?php


class Dashboard_model extends CI_model
{
      public function updatedriverap($post)
  {
    $this->db->set('app_settings.ap', $post);
    $this->db->where('id', 1);
    return $this->db->update('app_settings');
  }
     public function updateTerminalbyId($post)
  {
      
      $this->db->set('KM30', $post["30KM"]);
    $this->db->set('KM50', $post["50KM"]);
    $this->db->set('KM100', $post["100KM"]);
    $this->db->set('KM150', $post["150KM"]);
    $this->db->set('minimum_wallet_amount', $post["minimum"]);
    $this->db->set('fee_company', $post["fee_company"]);
    $this->db->set('base_fare', $post["base_fare"]);
    $this->db->set('distance', $post["distance"]);
    $this->db->set('surge', $post["surge"]);
    $this->db->set('retase', $post["retase"]);
    $this->db->set('omset', $post["omset"]);
    $this->db->where('id', $post["id"]);
    return $this->db->update('terminal');
  }
  public function insert_harting($post)
  {
        $data= array(
      'nama' =>  $post["nama"],
      'nominal' =>  $post["nominal"],
      'waktu' =>  $post["jam"],
      'id_harting' =>  $post["fitur"],
      'terminal' =>  $post["terminal"]
    );

  return  $this->db->insert('harting',$data);
  }
  public function getHarting()
  {
    $this->db->select('*');
    $this->db->from('harting');
    return $this->db->get()->result_array();
  }
  public function total_penumpang($tgljemput=null)
  {
    $tgljemput==null?$tgljemput=date('Y-m-d'):$tgljemput;
    $this->db->select('sum(laporan_ap.pasenger) as total_penumpang');
    $this->db->from('laporan_ap');
    $this->db->where('laporan_ap.finish',1);
    $this->db->where('laporan_ap.filter',0);
    $this->db->where('laporan_ap.tanggal',$tgljemput);
    return $this->db->get()->row();
  }
  public function get_AP($teminal=null,$token,$date=null)
    {   
        $date==null?$date=date('Y-m-d'):$date;
        $teminal==null?$teminal="39fa5b5d2000c6c05032d4d2a751b887":$teminal;
        $server_output=$this->send_get_ap($teminal,$token,$date);
        if(json_decode($server_output)->status==true){
        return json_decode($server_output);
        }elseif(json_decode($server_output)->status==false and json_decode($server_output)->message == "Token Time Expire."){
        $this->login_ap();
        $server_output=$this->send_get_ap($teminal,$token,$date);
        if(json_decode($server_output)->status==true){
        return (array)json_decode($server_output);
        }
        }
        return (object)["data"=>array()];
    }
    public function login_ap( )
    {
        $post = [
    'username' => 'api.koperasiberkah.cgk',
    'password' => 'api.koperasiberkah.cgk',
];
     $ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"https://api-ecsys.angkasapura2.co.id/api/auth/login");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($post));
 curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);

curl_close ($ch);
$this->simpan_token(json_decode($server_output)->token);
if(json_decode($server_output)->status==true){
    return true;
}
return false;
    }
     public function simpan_token( $token_ap)
    {
       return $this->db->update('app_settings', array('token_ap' => $token_ap));
    }
    public function send_get_ap($teminal=null,$token,$date=null)
  {
    $post =(object)[
        "store_id"=> $teminal,
        "date"=> $date];
        $header = array();
        $header[] = 'Content-type: application/json';
        $header[] = 'Authorization:'.$token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL,"https://api-ecsys.angkasapura2.co.id/api/v1/simulation/");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($post));
        return curl_exec($ch);
  }
   public function total_reported($tgljemput=null)
  {
    $tgljemput==null?$tgljemput=date('Y-m-d'):$tgljemput;
    $this->db->select('sum(laporan_ap.total) as total');
    $this->db->from('laporan_ap');
    $this->db->where('laporan_ap.finish',1);
    $this->db->where('laporan_ap.report',1);
    $this->db->where('laporan_ap.tanggal',$tgljemput);
    return $this->db->get()->row();
  }
  public function total_unreported($tgljemput=null)
  {
    $tgljemput==null?$tgljemput=date('Y-m-d'):$tgljemput;
   $this->db->select('sum(laporan_ap.total) as total');
    $this->db->from('laporan_ap');
    $this->db->where('laporan_ap.finish',1);
    $this->db->where('laporan_ap.report',0);
    $this->db->where('laporan_ap.filter',0);
    $this->db->where('laporan_ap.tanggal',$tgljemput);
    return $this->db->get()->row();
  }
   public function get_driverseting()
  {
    $this->db->select('app_settings.ap');
    
     $this->db->where('app_settings.id',1);
    return $this->db->get('app_settings')->row();
  }
    public function getTerminalbyId($id)
  {
    $this->db->select('terminal.*');
    
     $this->db->where('terminal.id',$id);
    return $this->db->get('terminal')->row();
  }
    public function getTerminal()
  {
    $this->db->select('terminal.*');
    $this->db->from('terminal');
    $this->db->order_by('terminal.id', 'DESC');
    return $this->db->get()->result_array();
  }
  public function getAlltransaksi()
  {
    $this->db->select('transaksi.*,' . 'country_areas.area_name,' . 'admin.nama,' . 'driver.nama_driver,' . 'pelanggan.fullnama,' . 'history_transaksi.*,' . 'status_transaksi.*,' . 'fitur.fitur');
    $this->db->from('transaksi');
    $this->db->join('admin', 'transaksi.staff = admin.id', 'left');
    $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi', 'left');
    $this->db->join('status_transaksi', 'history_transaksi.status = status_transaksi.id', 'left');
    $this->db->join('driver', 'transaksi.id_driver = driver.id', 'left');
    $this->db->join('country_areas', 'country_areas.id = transaksi.region_code', 'left');
    $this->db->join('pelanggan', 'transaksi.id_pelanggan = pelanggan.id', 'left');
    $this->db->join('fitur', 'transaksi.order_fitur = fitur.id_fitur', 'left');
    $this->db->where('transaksi.now_later = 1');
    //$this->db->where('history_transaksi.status != 1');
    //$this->db->where('history_transaksi.status != 0');
    $this->db->order_by('transaksi.id', 'DESC');
    return $this->db->get()->result_array();
  }
  public function getAPtransaksiby($status=null, $tgljemput=null)
  {
      $tgljemput==null?$tgljemput=date('Y-m-d'):$tgljemput;
    $this->db->select('transaksi.*,' . 'laporan_ap.*,'. 'country_areas.area_name,' . 'driver.nama_driver,' . 'pelanggan.fullnama,' . 'history_transaksi.*,' . 'status_transaksi.*,' . 'fitur.fitur');
    $this->db->from('transaksi');
    $this->db->join('laporan_ap', 'transaksi.id = laporan_ap.id_transaksi', 'left');
    // $this->db->join('admin', 'transaksi.staff = admin.id', 'left');
    // $this->db->join('admin as release', 'transaksi.release_by = release.id ', 'left');
    $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi', 'left');
    $this->db->join('status_transaksi', 'history_transaksi.status = status_transaksi.id', 'left');
    $this->db->join('driver', 'transaksi.id_driver = driver.id', 'left');
    $this->db->join('country_areas', 'country_areas.id = transaksi.region_code', 'left');
    $this->db->join('pelanggan', 'transaksi.id_pelanggan = pelanggan.id', 'left');
    $this->db->join('fitur', 'transaksi.order_fitur = fitur.id_fitur', 'left');
    $this->db->where('laporan_ap.tanggal',$tgljemput);
    if($status!=null){
    $this->db->where('laporan_ap.report',$status);
    }
    $this->db->where('laporan_ap.finish',1);
    $this->db->where('laporan_ap.filter != 1');
    $this->db->where('transaksi.now_later = 1');
    //$this->db->like('transaksi.aplikator',  $aplikasi);
    // $this->db->like('transaksi.order_fitur',  $fitur);
    // $this->db->like('transaksi.waktu_order',  $tgljemput);
    // $this->db->like('transaksi.region_code',  $area);
    //$this->db->like('transaksi.id_order',  $idbook);
    // $this->db->like('history_transaksi.status',  $status);    
    $this->db->order_by('transaksi.id', 'DESC');
    return $this->db->get()->result_array();
  }
  public function getAPtransaksireported($tgljemput=null)
  {
      $tgljemput==null?$tgljemput=date('Y-m-d'):$tgljemput;
    $this->db->select('transaksi.*,' . 'laporan_ap.*,'. 'country_areas.area_name,' . 'driver.nama_driver,' . 'pelanggan.fullnama,' . 'history_transaksi.*,' . 'status_transaksi.*,' . 'fitur.fitur');
    $this->db->from('transaksi');
    $this->db->join('laporan_ap', 'transaksi.id = laporan_ap.id_transaksi', 'left');
    // $this->db->join('admin', 'transaksi.staff = admin.id', 'left');
    // $this->db->join('admin as release', 'transaksi.release_by = release.id ', 'left');
    $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi', 'left');
    $this->db->join('status_transaksi', 'history_transaksi.status = status_transaksi.id', 'left');
    $this->db->join('driver', 'transaksi.id_driver = driver.id', 'left');
    $this->db->join('country_areas', 'country_areas.id = transaksi.region_code', 'left');
    $this->db->join('pelanggan', 'transaksi.id_pelanggan = pelanggan.id', 'left');
    $this->db->join('fitur', 'transaksi.order_fitur = fitur.id_fitur', 'left');
    $this->db->where('laporan_ap.tanggal',$tgljemput);
    $this->db->where('laporan_ap.finish',1);
    $this->db->where('laporan_ap.report',1);
    $this->db->where('laporan_ap.filter != 1');
    $this->db->where('transaksi.now_later = 1');
    //$this->db->like('transaksi.aplikator',  $aplikasi);
    // $this->db->like('transaksi.order_fitur',  $fitur);
    // $this->db->like('transaksi.waktu_order',  $tgljemput);
    // $this->db->like('transaksi.region_code',  $area);
    //$this->db->like('transaksi.id_order',  $idbook);
    // $this->db->like('history_transaksi.status',  $status);    
    $this->db->order_by('transaksi.id', 'DESC');
    return $this->db->get()->result_array();
  }
  public function getAPtransaksiunreported( $tgljemput=null)
  {
      $tgljemput==null?$tgljemput=date('Y-m-d'):$tgljemput;
    $this->db->select('transaksi.*,' . 'laporan_ap.*,'. 'country_areas.area_name,' . 'driver.nama_driver,' . 'pelanggan.fullnama,' . 'history_transaksi.*,' . 'status_transaksi.*,' . 'fitur.fitur');
    $this->db->from('transaksi');
    $this->db->join('laporan_ap', 'transaksi.id = laporan_ap.id_transaksi', 'left');
    // $this->db->join('admin', 'transaksi.staff = admin.id', 'left');
    // $this->db->join('admin as release', 'transaksi.release_by = release.id ', 'left');
    $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi', 'left');
    $this->db->join('status_transaksi', 'history_transaksi.status = status_transaksi.id', 'left');
    $this->db->join('driver', 'transaksi.id_driver = driver.id', 'left');
    $this->db->join('country_areas', 'country_areas.id = transaksi.region_code', 'left');
    $this->db->join('pelanggan', 'transaksi.id_pelanggan = pelanggan.id', 'left');
    $this->db->join('fitur', 'transaksi.order_fitur = fitur.id_fitur', 'left');
    $this->db->where('laporan_ap.tanggal',$tgljemput);
    $this->db->where('laporan_ap.finish',1);
    $this->db->where('laporan_ap.report',0);
    $this->db->where('laporan_ap.filter != 1');
    $this->db->where('transaksi.now_later = 1');
    //$this->db->like('transaksi.aplikator',  $aplikasi);
    // $this->db->like('transaksi.order_fitur',  $fitur);
    // $this->db->like('transaksi.waktu_order',  $tgljemput);
    // $this->db->like('transaksi.region_code',  $area);
    //$this->db->like('transaksi.id_order',  $idbook);
    // $this->db->like('history_transaksi.status',  $status);    
    $this->db->order_by('transaksi.id', 'DESC');
    return $this->db->get()->result_array();
  } 
  public function getAPtransaksifilter( $tgljemput=null)
  {
      $tgljemput==null?$tgljemput=date('Y-m-d'):$tgljemput;
    $this->db->select('transaksi.*,' . 'laporan_ap.*,'. 'country_areas.area_name,' . 'driver.nama_driver,' . 'pelanggan.fullnama,' . 'history_transaksi.*,' . 'status_transaksi.*,' . 'fitur.fitur');
    $this->db->from('transaksi');
    $this->db->join('laporan_ap', 'transaksi.id = laporan_ap.id_transaksi', 'left');
    // $this->db->join('admin', 'transaksi.staff = admin.id', 'left');
    // $this->db->join('admin as release', 'transaksi.release_by = release.id ', 'left');
    $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi', 'left');
    $this->db->join('status_transaksi', 'history_transaksi.status = status_transaksi.id', 'left');
    $this->db->join('driver', 'transaksi.id_driver = driver.id', 'left');
    $this->db->join('country_areas', 'country_areas.id = transaksi.region_code', 'left');
    $this->db->join('pelanggan', 'transaksi.id_pelanggan = pelanggan.id', 'left');
    $this->db->join('fitur', 'transaksi.order_fitur = fitur.id_fitur', 'left');
    $this->db->where('laporan_ap.tanggal',$tgljemput);
    $this->db->where('laporan_ap.finish',1);
    $this->db->where('laporan_ap.filter = 1');
    $this->db->where('transaksi.now_later = 1');
    //$this->db->like('transaksi.aplikator',  $aplikasi);
    // $this->db->like('transaksi.order_fitur',  $fitur);
    // $this->db->like('transaksi.waktu_order',  $tgljemput);
    // $this->db->like('transaksi.region_code',  $area);
    //$this->db->like('transaksi.id_order',  $idbook);
    // $this->db->like('history_transaksi.status',  $status);    
    $this->db->order_by('transaksi.id', 'DESC');
    return $this->db->get()->result_array();
  } 
  
  public function getAlltransaksiby($status, $tgljemput, $fitur, $area)
  {
    $this->db->select('transaksi.*,' . 'country_areas.area_name,' . 'admin.nama,' .  'release.nama as release,' . 'driver.nama_driver,' . 'pelanggan.fullnama,' . 'history_transaksi.*,' . 'status_transaksi.*,' . 'fitur.fitur');
    $this->db->from('transaksi');
    $this->db->join('admin', 'transaksi.staff = admin.id', 'left');
    $this->db->join('admin as release', 'transaksi.release_by = release.id ', 'left');
    $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi', 'left');
    $this->db->join('status_transaksi', 'history_transaksi.status = status_transaksi.id', 'left');
    $this->db->join('driver', 'transaksi.id_driver = driver.id', 'left');
    $this->db->join('country_areas', 'country_areas.id = transaksi.region_code', 'left');
    $this->db->join('pelanggan', 'transaksi.id_pelanggan = pelanggan.id', 'left');
    $this->db->join('fitur', 'transaksi.order_fitur = fitur.id_fitur', 'left');
    $this->db->where('transaksi.now_later = 1');
    //$this->db->like('transaksi.aplikator',  $aplikasi);
    $this->db->like('transaksi.order_fitur',  $fitur);
    $this->db->like('transaksi.waktu_order',  $tgljemput);
    $this->db->like('transaksi.region_code',  $area);
    //$this->db->like('transaksi.id_order',  $idbook);
    $this->db->like('history_transaksi.status',  $status);    
    $this->db->order_by('transaksi.id', 'DESC');
    return $this->db->get()->result_array();
  } 


  public function getAlltransaksiltr()
  {
    $this->db->select('transaksi.*,' . 'admin.nama,' .  'release.nama as release,' . 'country_areas.area_name,' .'driver.nama_driver,' . 'pelanggan.fullnama,' . 'history_transaksi.*,' . 'status_transaksi.*,' . 'fitur.fitur');
    $this->db->from('transaksi');
    $this->db->join('admin', 'transaksi.staff = admin.id', 'left');
    $this->db->join('admin as release', 'transaksi.release_by = release.id ', 'left');
    $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi', 'left');
    $this->db->join('status_transaksi', 'history_transaksi.status = status_transaksi.id', 'left');
    $this->db->join('driver', 'transaksi.id_driver = driver.id', 'left');
    $this->db->join('country_areas', 'country_areas.id = transaksi.region_code', 'left');  
    $this->db->join('pelanggan', 'transaksi.id_pelanggan = pelanggan.id', 'left');
    $this->db->join('fitur', 'transaksi.order_fitur = fitur.id_fitur', 'left');
    $this->db->where('transaksi.now_later = 2');
    //$this->db->where('history_transaksi.status != 0');
    $this->db->order_by('transaksi.id', 'DESC');
    return $this->db->get()->result_array();
  }

  /*
  public function getAlltransaksiltrby($aplikasi, $status, $tgljemput,  $tgljemput2, $idbook, $fitur, $area)
  {
        $query = $this->db->query("
                select a.*
                from transaksi a
                left join admin b on a.staff=b.id
                left join history_transaksi c on a.id=c.id_transaksi
                left join status_transaksi d on c.status=d.id
                left join fitur e on a.order_fitur=e.id_fitur
                left join driver f ON a.id_driver=f.id
                left join country_areas g ON g.id=a.region_code
                left join pelanggan h on a.id_pelanggan=h.id
                where a.now_later = 2 
                and a.waktu_order >= '$tgljemput'
                and a.waktu_order <= '$tgljemput2'
                or a.notes like '%$aplikasi%'
                or a.order_fitur like '%$fitur%'
                or a.region_code like '%$area%'
                or a.id_order like '%$idbook%'
                or c.status like '%$status%'  
                ORDER BY `a`.`waktu_order` DESC
            ");
    return $query->result_array();
  }*/
  
    public function getAlltransaksiltrby($aplikasi, $status, $tgljemput,  $tgljemput2, $idbook, $fitur, $area)
  {
    $this->db->select('transaksi.*,' . 'country_areas.area_name,' .  'release.nama as release,' . 'admin.nama,'.'driver.nama_driver,' . 'pelanggan.fullnama,' . 'history_transaksi.*,' . 'status_transaksi.*,' . 'reportingshtvlk.*,' . 'fitur.fitur');
    $this->db->from('transaksi');
     $this->db->join('admin', 'transaksi.staff = admin.id', 'left');
    $this->db->join('admin as release', 'transaksi.release_by = release.id ', 'left');
    $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi', 'left');
    $this->db->join('status_transaksi', 'history_transaksi.status = status_transaksi.id', 'left');
    $this->db->join('driver', 'transaksi.id_driver = driver.id', 'left');
    $this->db->join('country_areas', 'country_areas.id = transaksi.region_code', 'left');  
    $this->db->join('pelanggan', 'transaksi.id_pelanggan = pelanggan.id', 'left');
    $this->db->join('fitur', 'transaksi.order_fitur = fitur.id_fitur', 'left');
        $this->db->join('reportingshtvlk', 'reportingshtvlk.noshuttle = SUBSTRING_INDEX(transaksi.id_order,"-",1)', 'left');
    $this->db->where('transaksi.now_later = 2');
    $this->db->like('transaksi.waktu_order',  $tgljemput);
    
    //$a = "transaksi.waktu_order >= $tgljemput AND transaksi.waktu_order <= $tgljemput2";
    //$this->db->or_where($a);
    
    $this->db->like('transaksi.notes',  $aplikasi); 
    $this->db->like('transaksi.order_fitur',  $fitur);    
    $this->db->like('transaksi.region_code',  $area);
    $this->db->like('transaksi.id_order',  $idbook);
    $this->db->like('history_transaksi.status',  $status);    
    $this->db->order_by('transaksi.id', 'DESC');
    return $this->db->get()->result_array();
  }
  
      public function getAllrekonshuttle($aplikasi, $status, $tgljemput,  $tgljemput2, $idbook, $fitur, $area)
  {
    $this->db->select('transaksi.*,' . 'SUBSTRING_INDEX(transaksi.id_order,"-",1) as noshuttletrx,' . 'country_areas.area_name,' .  'release.nama as release,' . 'admin.nama,'.'driver.nama_driver,' . 'pelanggan.fullnama,' . 'history_transaksi.*,' . 'status_transaksi.*,' . 'reportingshtvlk.*,' . 'fitur.fitur');
    $this->db->from('transaksi');
     $this->db->join('admin', 'transaksi.staff = admin.id', 'left');
    $this->db->join('admin as release', 'transaksi.release_by = release.id ', 'left');
    $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi', 'left');
    $this->db->join('status_transaksi', 'history_transaksi.status = status_transaksi.id', 'left');
    $this->db->join('driver', 'transaksi.id_driver = driver.id', 'left');
    $this->db->join('country_areas', 'country_areas.id = transaksi.region_code', 'left');  
    $this->db->join('pelanggan', 'transaksi.id_pelanggan = pelanggan.id', 'left');
    $this->db->join('fitur', 'transaksi.order_fitur = fitur.id_fitur', 'left');
    $this->db->join('reportingshtvlk', 'reportingshtvlk.noshuttle = SUBSTRING_INDEX(transaksi.id_order,"-",1)', 'left');
    $this->db->where('transaksi.now_later = 2');
    $this->db->like('transaksi.waktu_order',  $tgljemput);
    
    //$a = "transaksi.waktu_order >= $tgljemput AND transaksi.waktu_order <= $tgljemput2";
    //$this->db->or_where($a);
    
    $this->db->like('transaksi.notes',  $aplikasi); 
    $this->db->like('transaksi.order_fitur',  34);    
    $this->db->like('transaksi.region_code',  $area);
    $this->db->like('transaksi.id_order',  $idbook);
    $this->db->like('history_transaksi.status',  $status);    
    $this->db->order_by('transaksi.id', 'DESC');
    return $this->db->get()->result_array();
  }

  public function getAlltransaksijurnalnow($tgljemput) 
  {
    $this->db->select('*');
    $this->db->from('transaksi_jurnal');
    $this->db->join('transaksi', 'transaksi.id = transaksi_jurnal.id_transaksi', 'left');
    $this->db->where('transaksi.now_later = 1');
    $this->db->like('transaksi.waktu_order',  $tgljemput);
    $this->db->order_by('transaksi_jurnal.id', 'DESC'); 
    return $this->db->get()->result_array();
  }

  public function getAlltransaksijurnallater($tgljemput) 
  {
    $this->db->select('*');
    $this->db->from('transaksi_jurnal');
    $this->db->join('transaksi', 'transaksi.id = transaksi_jurnal.id_transaksi', 'left');
    $this->db->where('transaksi.now_later = 2'); 
    $this->db->like('transaksi.waktu_order',  $tgljemput);
    $this->db->order_by('transaksi_jurnal.id', 'DESC');  
    return $this->db->get()->result_array();
  }

  public function getidlast() 
  {
    $this->db->select('id');
    $this->db->from('transaksi');
    $this->db->order_by('transaksi.id', 'DESC');
    return $idtx = $this->db->get()->row_array();
  }

  public function getallcountryarea() 
  {
    $this->db->select('*');
    $this->db->from('country_areas');
    $this->db->order_by('country_areas.id', 'ASC');
    return $this->db->get()->result_array();
  }

  public function getcountryareaby($id) 
  {
    $this->db->select('*');
    $this->db->from('country_areas');
    $this->db->where('country_areas.id',$id); 
    $this->db->order_by('country_areas.id', 'ASC');
    return $this->db->get()->row_array();
  }

  
  function getTotalTransaksiBulanan($bulan, $tahun, $typefitur)
  {
    //        lihat tranasksi tanpa limit 15
    $query = $this->db->query("
                SELECT COUNT(transaksi.id) as jumlah
                FROM transaksi
                left join fitur on transaksi.order_fitur = fitur.id_fitur
                left join history_transaksi on transaksi.id = history_transaksi.id_transaksi
                
                WHERE MONTH(waktu_selesai) = $bulan
                AND YEAR(waktu_selesai) = $tahun
                AND fitur.home = $typefitur
                AND history_transaksi.status = 4
            ");
    return $query->result_array();
  }

  public function getbydate()
  {
    $day = date('d');
    $month = date('m');
    $year = date('Y');
    $this->db->select('fitur.fitur');
    $this->db->select("
                (SELECT COUNT(tr.id)
                FROM transaksi tr
                left join history_transaksi on tr.id = history_transaksi.id_transaksi
                WHERE DAY(tr.waktu_selesai) = $day
                AND tr.order_fitur = fitur.id_fitur
                AND history_transaksi.status = 4) as hari
                ");
                $this->db->select("
                (SELECT COUNT(tr.id)
                FROM transaksi tr
                left join history_transaksi on tr.id = history_transaksi.id_transaksi
                WHERE MONTH(tr.waktu_selesai) = $month
                AND tr.order_fitur = fitur.id_fitur
                AND history_transaksi.status = 4) as bulan
                ");
                $this->db->select("
                (SELECT COUNT(tr.id)
                FROM transaksi tr
                left join history_transaksi on tr.id = history_transaksi.id_transaksi
                WHERE YEAR(tr.waktu_selesai) = $year
                AND tr.order_fitur = fitur.id_fitur
                AND history_transaksi.status = 4) as tahun
                ");
    $this->db->from('fitur');
    return $this->db->get()->result_array();

  }

  function getTotalTransaksiharian($hari, $fitur)
  {
    //        lihat tranasksi tanpa limit 15
    $query = $this->db->query("
                SELECT COUNT(transaksi.id) as jumlah
                FROM transaksi
                left join history_transaksi on transaksi.id = history_transaksi.id_transaksi
                
                WHERE DAY(waktu_selesai) = $hari
                AND history_transaksi.status = 4
            ");
    return $query->result_array();
  }

  public function getallsaldo()
  {
    $this->db->select('SUM(biaya_akhir)as total');
    $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi', 'left');
    $this->db->where('history_transaksi.status != 1');
    return $this->db->get('transaksi')->row_array();
  }

  public function getAllfitur()
  {
    return $this->db->get('fitur')->result_array();
  }

  public function gettransaksibyid($id)
  {
    $this->db->select('merchant.*');
    $this->db->select('transaksi_detail_merchant.total_biaya as total_belanja');
    $this->db->select('transaksi_detail_send.*');
    $this->db->select('history_transaksi.*');
    $this->db->select('transaksi_jurnal.*');
    $this->db->select('status_transaksi.*');
    $this->db->select('voucher.*');
    $this->db->select('fitur.*');
    $this->db->select('rating_driver.*');
    $this->db->select('pelanggan.fullnama,pelanggan.email as email_pelanggan,pelanggan.no_telepon as telepon_pelanggan,pelanggan.fotopelanggan,pelanggan.token');
    $this->db->select('driver.nama_driver,driver.foto,driver.email,driver.no_telepon,driver.reg_id');
    $this->db->select('transaksi.*');
    $this->db->select('regional.*');

    $this->db->join('transaksi_jurnal', 'transaksi_jurnal.id_transaksi = transaksi.id', 'left');
    $this->db->join('transaksi_detail_merchant', 'transaksi.id = transaksi_detail_merchant.id_transaksi', 'left');
    $this->db->join('merchant', 'transaksi_detail_merchant.id_merchant = merchant.id_merchant', 'left');
    $this->db->join('transaksi_detail_send', 'transaksi.id = transaksi_detail_send.id_transaksi', 'left');
    $this->db->join('history_transaksi', 'transaksi.id = history_transaksi.id_transaksi', 'left');
    $this->db->join('status_transaksi', 'history_transaksi.status = status_transaksi.id', 'left');
    $this->db->join('voucher', 'transaksi.order_fitur = voucher.untuk_fitur', 'left');
    $this->db->join('fitur', 'transaksi.order_fitur = fitur.id_fitur', 'left');
    $this->db->join('rating_driver', 'transaksi.id = rating_driver.id_transaksi', 'left');
    $this->db->join('driver', 'transaksi.id_driver = driver.id', 'left');
    $this->db->join('pelanggan', 'transaksi.id_pelanggan = pelanggan.id', 'left');
    $this->db->join('regional', 'regional.kode_reg = transaksi.region_code', 'left');
    //$this->db->where('history_transaksi.status != 1');
    $this->db->order_by('transaksi.id', 'DESC');
    return $this->db->get_where('transaksi', ['transaksi.id' => $id])->row_array();
  }

  public function gettransaksibydriver($id,$tanggal)
  {
    $this->db->select('*');
    $this->db->where('id_driver',$id);
    $this->db->like('waktu_order',$tanggal);
    return $this->db->get('transaksi')->result_array();
  }

  public function getdriverarea($id)
  {    
    $this->db->select('driver.*');
    $this->db->select('kendaraan.*');
    $this->db->join('kendaraan', 'kendaraan.id_k = driver.kendaraan', 'left');
    $this->db->join('transaksi', 'transaksi.region_code = driver.region_code', 'left');
    $this->db->where("transaksi.id = $id");
    $this->db->where("(driver.berkah = '1' OR driver.paskas = '1' )");
    return $this->db->get('driver')->result_array();
  }

  public function getitem($id)
  {
    $this->db->where("transaksi_item.id_transaksi = $id");
    $this->db->join('item', 'transaksi_item.id_item = item.id_item', 'left');
    return $this->db->get('transaksi_item')->result_array();
  }
  public function updateStaff($id)
  {
    $this->db->set('release_by', $this->session->userdata('id'));
    $this->db->where('id', $id);
    return $this->db->update('transaksi');;
  }
  public function ubahshootdriver($id,$iddrv,$status,$staff)
  {
    $this->db->set('status', $status);
    $this->db->set('id_driver', $iddrv);
    $this->db->where('id_transaksi', $id);
    $this->db->update('history_transaksi');

    if($iddrv=='D0'){
      $iddrv= NULL;
    }
    $this->db->set('release_by', $staff);
    $this->db->set('id_driver', $iddrv); 
    $this->db->where('id', $id);
    $this->db->update('transaksi');

    if($status==2 && $status==12){
        $this->db->set('status', '1'); 
        $this->db->where('id_driver', $iddrv); 
        $this->db->update('config_driver');
    }
  }

  public function fixsaldouser($id_pelanggan)
  {
    //$trx = $this->db->gettransaksibyid($idtrx);
    $data= array(
      'id_user' => $id_pelanggan,
      'saldo' => 0,
      'saldotrx' => 0
    );

    $this->db->insert('saldo',$data);
  }

  public function log_history($data)
  {
    $this->db->insert('log_history',$data);
  }  

  public function ubahstatustransaksibyid($id)
  {
    $this->db->set('status', 5);
    $this->db->where('id_transaksi', $id);
    $this->db->update('history_transaksi');
  }

  public function ubahstatusdriverbyid($id_driver)
  {
    $this->db->set('status', 4);
    $this->db->where('id_driver', $id_driver);
    $this->db->update('config_driver');
  }

  public function deletetransaksi($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('transaksi');

    $this->db->where('id_transaksi', $id);
    $this->db->delete('history_transaksi');

    $this->db->where('id_transaksi', $id);
    $this->db->delete('rating_driver');

    $this->db->where('id_transaksi', $id);
    $this->db->delete('transaksi_detail_send');

    $this->db->where('id_transaksi', $id);
    $this->db->delete('transaksi_jurnal');
  }

  public function countdriver()
  {
    $this->db->where('status != 0');
    return $this->db->get('driver')->result_array();
  }

  public function countmitra()
  {
    $this->db->where('status_mitra != 0');
    return $this->db->get('mitra')->result_array();
  }
  
  public function edittransactionltr($data, $id)
  {
    $this->db->where('id', $id);
    $edit = $this->db->update('transaksi', $data);
    return $edit;
  }
  
  public function manual_harting($terminal, $idharting, $status, $id)
  {
      if($status == 1){
        $this->db->set('manual', 0);
        $this->db->set('status', 0);
        $this->db->where('id_harting', $idharting);
        $this->db->where('terminal', $terminal);
        $this->db->update('harting');  
      }
      
    $this->db->set('manual', $status);
    $this->db->set('status', $status);
    $this->db->where('id', $id);
    return $this->db->update('harting');
  }
  
  public function delete_harting($id)
  {
    $this->db->where('id', $id);
    return $this->db->delete('harting');
  }
  
  public function getterminaldata()
  {
    $this->db->select('*');
    $this->db->from('terminal');
    return $this->db->get()->result_array();
  }
  
  public function getparamroute()
  {
    $this->db->select('*');
    $this->db->from('paramshuttlebyroute');
    // $this->db->where('id_param', $id);
    return $this->db->get()->result_array();
  }
  
  public function editmargin($id, $margin)
  {
      $this->db->set('margin', $margin);
    $this->db->where('id_param', $id);
    return $this->db->update('paramshuttlebyroute');
  }
}
