<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_aluminium extends CI_Model
{

    public function getData($tgl_awal, $tgl_akhir)
    {
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->join('master_warna mw', 'mw.kode = mi.kode_warna', 'left');
        $this->db->where('mi.id_jenis_item', 1);
        $this->db->where('DATE(ds.created) >=', $tgl_awal);
        $this->db->where('DATE(ds.created) <=', $tgl_akhir);
        $this->db->select('ds.*,mi.*,mw.*,ds.created as tgl_stok');
        $this->db->order_by('ds.id', 'desc');

        return $this->db->get('data_stock ds');
    }
}

/* End of file m_aluminium.php */
/* Location: ./application/models/inout/m_aluminium.php */