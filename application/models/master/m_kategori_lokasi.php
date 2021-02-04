<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_kategori_lokasi extends CI_Model
{

    public function getData($value = '')
    {
        return $this->db->get('master_kategori_lokasi ');
    }

    public function insertData($data = '')
    {

        $this->db->insert('master_kategori_lokasi', $data);
    }

    public function updateData($data = '')
    {
        $this->db->where('id', $data['id']);
        $this->db->update('master_kategori_lokasi', $data);
    }

    public function deleteData($id = '')
    {
        $this->db->where('id', $id);
        $this->db->delete('master_kategori_lokasi');
    }
}

/* End of file m_kategori_lokasi.php */
/* Location: ./application/models/master/m_kategori_lokasi.php */