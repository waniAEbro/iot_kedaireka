<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_jenis_market extends CI_Model
{

    public function getData($value = '')
    {
        return $this->db->get('master_jenis_market ');
    }

    public function insertData($data = '')
    {

        $this->db->insert('master_jenis_market', $data);
    }

    public function updateData($data = '')
    {
        $this->db->where('id', $data['id']);
        $this->db->update('master_jenis_market', $data);
    }

    public function deleteData($id = '')
    {
        $this->db->where('id', $id);
        $this->db->delete('master_jenis_market');
    }
}

/* End of file m_jenis_market.php */
/* Location: ./application/models/master/m_jenis_market.php */