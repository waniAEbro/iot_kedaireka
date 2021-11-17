<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_gudang extends CI_Model
{

    public function getData($value = '')
    {
        $this->db->join('master_jenis_item mji', 'mji.id = ma.id_jenis_item', 'left');
        $this->db->select('ma.*,mji.jenis_item');

        $this->db->order_by('ma.id', 'desc');

        return $this->db->get('master_gudang ma');
    }

    public function insertData($data = '')
    {

        $this->db->insert('master_gudang', $data);
    }

    public function updateData($data = '')
    {
        $this->db->where('id', $data['id']);
        $this->db->update('master_gudang', $data);
    }

    public function updateItemCode($data = '')
    {
        $this->db->where('item_code', $data['item_code']);
        $this->db->update('master_gudang', $data);
    }

    public function deleteData($id = '')
    {
        $this->db->where('id', $id);
        $this->db->delete('master_gudang');
    }
}

/* End of file m_gudang.php */
/* Location: ./application/models/master/m_gudang.php */