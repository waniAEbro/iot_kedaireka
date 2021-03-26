<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_aksesoris extends CI_Model
{

    public function getData($value = '')
    {
        return $this->db->get('master_aksesoris ');
    }

    public function insertData($data = '')
    {

        $this->db->insert('master_aksesoris', $data);
    }

    public function updateData($data = '')
    {
        $this->db->where('id', $data['id']);
        $this->db->update('master_aksesoris', $data);
    }

    public function deleteData($id = '')
    {
        $this->db->where('id', $id);
        $this->db->delete('master_aksesoris');
    }
}

/* End of file m_aksesoris.php */
/* Location: ./application/models/master/m_aksesoris.php */