<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_aksesoris extends CI_Model
{

    public function getData($value = '')
    {
        $this->db->where('id_jenis_item', 2);
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

    public function deleteData($id = '')
    {
        $this->db->where('id', $id);
        $this->db->delete('master_item');
    }
}

/* End of file m_aksesoris.php */
/* Location: ./application/models/master/m_aksesoris.php */