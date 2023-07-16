<?php

defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Harga_model extends CI_model
{

    function __construct()
    {
        parent::__construct();
    }
    
    public function getjurnal() 
    {
        $this->db->select('*');
        $this->db->from('transaksi_jurnal');
        $this->db->where('id_transaksi','170723');
        return $this->db->get()->row_array(); 
    }
}