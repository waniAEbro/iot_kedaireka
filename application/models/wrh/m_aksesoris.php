<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_aksesoris extends CI_Model
{

    public function getdata($item_code = '', $supplier = '')
    {
        $this->db->join('master_aksesoris ma', 'ma.item_code = da.item_code', 'left');
        $this->db->join('master_supplier ms', 'ms.id = da.id_supplier', 'left');
        if ($item_code != 'x') {
            $this->db->where('da.item_code', $item_code);
        }

        if ($supplier != 'x') {
            $this->db->where('da.id_supplier', $supplier);
        }

        $this->db->select('da.*,ma.deskripsi,ma.satuan,ms.supplier');

        $this->db->order_by('da.id', 'desc');
        return $this->db->get('data_aksesoris da');
    }

    public function insertaksesoris($value = '')
    {
        $this->db->insert('data_aksesoris', $value);
    }

    public function insertaksesorisDetail($value = '')
    {
        $this->db->insert('data_aksesoris_detail', $value);
    }

    public function deleteDetailItem($value = '')
    {
        $this->db->where('id', $value);
        $this->db->delete('data_aksesoris_detail');
    }

    public function getDataDetailTabel($id = '')
    {
        $this->db->join('data_aksesoris da', 'da.id = dad.id_aksesoris', 'left');
        $this->db->where('dad.id_aksesoris', $id);
        $this->db->select('dad.*');
        return $this->db->get('data_aksesoris_detail dad')->result();
    }
}

/* End of file m_aksesoris.php */
/* Location: ./application/models/klg/m_aksesoris.php */