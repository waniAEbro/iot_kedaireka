<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_proyek extends CI_Model
{

    public function getData($value = '')
    {
        $this->db->order_by('ma.id', 'desc');

        return $this->db->get('master_proyek ma');
    }

    public function insertData($data = '')
    {

        $this->db->insert('master_proyek', $data);
    }

    public function updateData($data = '')
    {
        $this->db->where('id', $data['id']);
        $this->db->update('master_proyek', $data);
    }

    public function updateItemCode($data = '')
    {
        $this->db->where('item_code', $data['item_code']);
        $this->db->update('master_proyek', $data);
    }

    public function cekKode($kode)
    {
        $this->db->where('kode_proyek', $kode);
        return $this->db->get('master_proyek')->num_rows();
    }

    public function deleteData($id = '')
    {
        $this->db->where('id', $id);
        $this->db->delete('master_proyek');
    }
}

/* End of file m_proyek.php */
/* Location: ./application/models/master/m_proyek.php */