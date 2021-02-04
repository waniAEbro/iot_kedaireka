<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_kaca extends CI_Model
{

    public function getData($value = '')
    {
        return $this->db->get('master_kaca ');
    }

    public function insertData($data = '')
    {

        $this->db->insert('master_kaca', $data);
    }

    public function updateData($data = '')
    {
        $this->db->where('id', $data['id']);
        $this->db->update('master_kaca', $data);
    }

    public function deleteData($id = '')
    {
        $this->db->where('id', $id);
        $this->db->delete('master_kaca');
    }
}

/* End of file m_kaca.php */
/* Location: ./application/models/master/m_kaca.php */