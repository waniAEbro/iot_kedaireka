<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_kaca extends CI_Model
{

    public function getData($value = '')
    {
        $this->db->where('id_jenis_item', 3);
        $this->db->order_by('id', 'desc');
        return $this->db->get('master_item ');
    }

    public function insertData($data = '')
    {

        $this->db->insert('master_item', $data);
    }

    public function updateData($data = '')
    {
        $this->db->where('id', $data['id']);
        $this->db->update('master_item', $data);
    }

    public function updateItemCode($data = '')
    {
        $this->db->where('item_code', $data['item_code']);
        $this->db->update('master_item', $data);
    }

    public function deleteData($id = '')
    {
        $this->db->where('id', $id);
        $this->db->delete('master_item');
    }
    public function cekMasterkaca($item_code = '')
    {
        $this->db->where('item_code', $item_code);
        return $this->db->get('master_item')->num_rows();
    }

    public function cekMaster($data = '')
    {
        $this->db->where('item_code', $data['item_code']);
        return $this->db->get('master_item')->num_rows();
    }
}

/* End of file m_kaca.php */
/* Location: ./application/models/master/m_kaca.php */