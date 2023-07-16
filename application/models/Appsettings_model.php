<?php


class Appsettings_model extends CI_model
{
    public function getappbyid()
    {
        return $this->db->get_where('app_settings', ['id' => '1'])->row_array();
    }

    public function gettransfer()
    {
        $this->db->select('*');
        $this->db->from('list_bank');
        return $this->db->get()->result_array();
    }

    public function getAllarea()
    {
        $this->db->select('*');
        $this->db->from('country_areas');
        return $this->db->get()->result_array();
    }

    public function getAllpricecards()
    {
        $this->db->select('*');
        $this->db->from('price_cards');
        $this->db->join('driver_job', 'price_cards.job = driver_job.id', 'left');
        $this->db->join('country_areas', 'price_cards.id_area = country_areas.id', 'left');
        return $this->db->get()->result_array();
    }

    public function getbankid($id)
    {
        $this->db->select('*');
        $this->db->from('list_bank');
        $this->db->where('id_bank', $id);
        return $this->db->get()->row_array();
    }
    

    public function ubahdataappsettings($data)
    {
        $this->db->set('app_logo', $data['app_logo']);
        $this->db->set('app_email', $data['app_email']);
        $this->db->set('app_website', $data['app_website']);

        $this->db->set('app_privacy_policy', $data['app_privacy_policy']);
        $this->db->set('app_aboutus', $data['app_aboutus']);
        $this->db->set('app_address', $data['app_address']);
        $this->db->set('app_name', $data['app_name']);
        $this->db->set('app_linkgoogle', $data['app_linkgoogle']);
        $this->db->set('app_currency', $data['app_currency']);

        $this->db->where('id', '1');
        $this->db->update('app_settings', $data);
    }

    public function ubahdatarekening($data, $id)
    {
        $this->db->where('id_bank', $id);
        $this->db->update('list_bank', $data);
    }

    public function hapusrekening($id)
    {
        $this->db->where('id_bank', $id);
        $this->db->delete('list_bank');
    }

    public function adddatarekening($data)
    {
        $this->db->insert('list_bank', $data);
    }

    public function ubahdataemail($data)
    {
        $this->db->set('email_subject', $data['email_subject']);
        $this->db->set('email_text1', $data['email_text1']);
        $this->db->set('email_text2', $data['email_text2']);
        $this->db->set('email_subject_confirm', $data['email_subject_confirm']);
        $this->db->set('email_text3', $data['email_text3']);
        $this->db->set('email_text4', $data['email_text4']);

        $this->db->where('id', '1');
        $this->db->update('app_settings', $data);
    }

    public function ubahdatasmtp($data)
    {
        $this->db->set('smtp_host', $data['smtp_host']);
        $this->db->set('smtp_port', $data['smtp_port']);
        $this->db->set('smtp_username', $data['smtp_username']);
        $this->db->set('smtp_password', $data['smtp_password']);
        $this->db->set('smtp_from', $data['smtp_from']);
        $this->db->set('smtp_secure', $data['smtp_secure']);

        $this->db->where('id', '1');
        $this->db->update('app_settings', $data);
    }

    public function ubahdatastripe($data)
    {
        $this->db->set('stripe_secret_key', $data['stripe_secret_key']);
        $this->db->set('stripe_published_key', $data['stripe_published_key']);
        $this->db->set('stripe_status', $data['stripe_status']);
        $this->db->set('stripe_active', $data['stripe_active']);

        $this->db->where('id', '1');
        $this->db->update('app_settings', $data);
    }

    public function ubahdatapaypal($data)
    {
        $this->db->set('paypal_key', $data['paypal_key']);
        $this->db->set('app_currency_text', $data['app_currency_text']);
        $this->db->set('paypal_mode', $data['paypal_mode']);
        $this->db->set('paypal_active', $data['paypal_active']);

        $this->db->where('id', '1');
        $this->db->update('app_settings', $data);
    }

    public function getpayubyid()
    {
        return $this->db->get_where('payusettings', ['id' => '1'])->row_array();
    }

    public function ubahdatapayu($data)
    {
        $this->db->set('payu_key', $data['payu_key']);
        $this->db->set('payu_id', $data['payu_id']);
        $this->db->set('payu_salt', $data['payu_salt']);
        $this->db->set('payu_debug', $data['payu_debug']);
        $this->db->set('active', $data['active']);

        $this->db->where('id', '1');
        $this->db->update('payusettings', $data);
    }
    public function getzonaid($id)
    {
        $this->db->select('*');
        $this->db->from('zona_movic');
         $this->db->where('id', $id);
        return $this->db->get()->row_array();
    }
    public function getpriceid($id)
    {
        $this->db->select('*');
        $this->db->from('tarif_movic');
         $this->db->where('id', $id);
        return $this->db->get()->row_array();
    }
     public function getpriceidbasic($id)
    {
        $this->db->select('*');
        $this->db->from('tarif_movicBasic');
         $this->db->where('id', $id);
        return $this->db->get()->row_array();
    }
    public function getpriceidtravelin($id)
    {
        $this->db->select('*');
        $this->db->from('travelin');
         $this->db->where('id', $id);
        return $this->db->get()->row_array();
    }
     public function getzonaname($id)
    {
        $this->db->select('*');
        $this->db->from('zona_movic');
         $this->db->like('nama', $id);
        return $this->db->get()->result_array();
    }
    public function getzona()
    {
        $this->db->select('*');
        $this->db->from('zona_movic');
        return $this->db->get()->result_array();
    }
    public function getprice()
    {
        $this->db->select('*');
        $this->db->from('tarif_movic');
        return $this->db->get()->result_array();
    }
     public function getpricetravelin()
    {
        $this->db->select('*');
        $this->db->from('travelin');
        return $this->db->get()->result_array();
    }
     public function getpriceBasic()
    {
        $this->db->select('*');
        $this->db->from('tarif_movicBasic');
        return $this->db->get()->result_array();
    }
    public function updatezona($post)
  {
  $this->db->where('id',  $post['id']);
        $this->db->update('zona_movic', $post);
  }
  public function updatepricetravelin($post)
  {
  $this->db->where('id',  $post['id']);
        $this->db->update('travelin', $post);
  }
public function updateprice($post)
  {
  $this->db->where('id',  $post['id']);
        $this->db->update('tarif_movic', $post);
  }
  public function updatepricebasic($post)
  {
  $this->db->where('id',  $post['id']);
        $this->db->update('tarif_movicBasic', $post);
  }

    public function addzona($post)
  {

  return  $this->db->insert('zona_movic',$post);
  }
   public function addprice($post)
  {

  return  $this->db->insert('tarif_movic',$post);
  }
   public function addpricebasic($post)
  {

  return  $this->db->insert('tarif_movicBasic',$post);
  }
  public function addpricetravelin($post)
  {

  return  $this->db->insert('travelin',$post);
  }

}
