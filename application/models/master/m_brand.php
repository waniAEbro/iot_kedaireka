<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_brand extends CI_Model
{

    public function getData($value = '')
    {
        // $this->db->join('kabupaten k', 'k.id = ma.id_kabupaten', 'left');
        // $this->db->select('ma.*,k.kabupaten');
        $this->db->order_by('ma.id', 'desc');

        return $this->db->get('master_brand ma');
    }

    public function insertData($data = '')
    {

        $this->db->insert('master_brand', $data);
    }

    public function updateData($data = '')
    {
        $this->db->where('id', $data['id']);
        $this->db->update('master_brand', $data);
    }

    public function updateItemCode($data = '')
    {
        $this->db->where('item_code', $data['item_code']);
        $this->db->update('master_brand', $data);
    }

    public function deleteData($id = '')
    {
        $this->db->where('id', $id);
        $this->db->delete('master_brand');
    }
}

/* End of file m_brand.php */
/* Location: ./application/models/master/m_brand.php */