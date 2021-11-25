<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_barang extends CI_Model
{

    public function getData()
    {
        $this->db->where('is_del', 1);
        return $this->db->get('master_barang');
    }

    public function getBrand()
    {
        $this->db->where('is_del', 1);
        $this->db->group_by('brand');
        return $this->db->get('master_barang');
    }

    public function getMax($value = '')
    {
        return $this->db->get('master_barang')->num_rows();
    }

    public function insertData($data, $new = true)
    {
        if ($new) {
            $this->db->insert('master_barang', $data);
        } else {
            $this->db->where('id', $data['id']);
            $this->db->update('master_barang', $data);
        }
    }

    public function deleteData($id = '')
    {
        $obj = array('is_del' => 2);
        $this->db->where('id', $id);
        // $this->db->delete('master_barang');
        $this->db->update('master_barang', $obj);
    }

    public function getEditbarang($id = '')
    {
        $this->db->where('id', $id);
        return $this->db->get('master_barang');
    }
}

/* End of file m_barang.php */
/* Location: ./application/models/master/m_barang.php */