<?php

class Profile_model extends CI_model
{
    public function getadmin()
    {
        $idadmin = $this->session->userdata('id');
        $this->db->where('id', $idadmin);
        return  $this->db->get('admin')->row_array();
    }

    public function getalladmin()
    {
        $this->db->select('*');
        return  $this->db->get('admin')->result_array();
    }

    public function getadminbyid($id)
    {
        $this->db->where('id', $id);
        return  $this->db->get('admin')->row_array();
    }

    public function tambahdataadmin($data)
    {
        $this->db->insert('admin', $data);
    }

    public function ubahdataadmin($data)
    {
        $this->db->set('user_name', $data['user_name']);
        $this->db->set('nama', $data['nama']);
        $this->db->set('email', $data['email']);
        $this->db->set('image', $data['image']);
        $this->db->set('password', $data['password']); 

        $this->db->where('id', $data['id']);
        $this->db->update('admin', $data);
    }

    public function deleteprofile($id)
    {
      $this->db->where('id', $id);
      $this->db->delete('admin');
      }
}
