<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_divisi extends CI_Model
{

    public function getData($value = '')
    {
        return $this->db->get('master_divisi ');
    }

    public function insertData($data = '')
    {

        $this->db->insert('master_divisi', $data);
    }

    public function updateData($data = '')
    {
        $this->db->where('id', $data['id']);
        $this->db->update('master_divisi', $data);
    }

    public function deleteData($id = '')
    {
        $this->db->where('id', $id);
        $this->db->delete('master_divisi');
    }
}

/* End of file m_divisi.php */
/* Location: ./application/models/master/m_divisi.php */