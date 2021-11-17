<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_divisi extends CI_Model
{

    public function getData($value = '')
    {
        $this->db->join('master_jenis_item mji', 'mji.id = ma.id_jenis_item', 'left');
        $this->db->select('ma.*,mji.jenis_item');

        $this->db->order_by('ma.id', 'desc');

        return $this->db->get('master_divisi_stock ma');
    }

    public function insertData($data = '')
    {

        $this->db->insert('master_divisi_stock', $data);
    }

    public function updateData($data = '')
    {
        $this->db->where('id', $data['id']);
        $this->db->update('master_divisi_stock', $data);
    }

    public function updateItemCode($data = '')
    {
        $this->db->where('item_code', $data['item_code']);
        $this->db->update('master_divisi_stock', $data);
    }

    public function deleteData($id = '')
    {
        $this->db->where('id', $id);
        $this->db->delete('master_divisi_stock');
    }
}

/* End of file m_divisi.php */
/* Location: ./application/models/master/m_divisi.php */