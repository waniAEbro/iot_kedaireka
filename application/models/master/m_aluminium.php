<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_aluminium extends CI_Model
{

    public function getData($value = '')
    {
        $this->db->where('id_jenis_item', 1);
        $this->db->join('master_warna mw', 'mw.kode = mi.kode_warna', 'left');
        $this->db->order_by('mi.id', 'desc');

        $this->db->select('mi.*,mw.warna');

        return $this->db->get('master_item mi');
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

    public function cekMaster($data = '')
    {
        $this->db->where('section_ata', $data['section_ata']);
        $this->db->where('section_allure', $data['section_allure']);
        $this->db->where('temper', $data['temper']);
        $this->db->where('kode_warna', $data['kode_warna']);
        $this->db->where('ukuran', $data['ukuran']);
        return $this->db->get('master_item')->num_rows();
    }
}

/* End of file m_aluminium.php */
/* Location: ./application/models/master/m_aluminium.php */