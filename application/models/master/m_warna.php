<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_warna extends CI_Model
{

    public function getData($value = '')
    {
        // $this->db->join('kabupaten k', 'k.id = ma.id_kabupaten', 'left');
        // $this->db->select('ma.*,k.kabupaten');
        $this->db->order_by('ma.id', 'desc');

        return $this->db->get('master_warna ma');
    }

    public function insertData($data = '')
    {

        $this->db->insert('master_warna', $data);
    }

    public function updateData($data = '')
    {
        $this->db->where('id', $data['id']);
        $this->db->update('master_warna', $data);
    }

    public function updateItemCode($data = '')
    {
        $this->db->where('item_code', $data['item_code']);
        $this->db->update('master_warna', $data);
    }

    public function deleteData($id = '')
    {
        $this->db->where('id', $id);
        $this->db->delete('master_warna');
    }
}

/* End of file m_warna.php */
/* Location: ./application/models/master/m_warna.php */