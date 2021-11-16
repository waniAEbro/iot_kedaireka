<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_aksesoris extends CI_Model
{

    public function getData($tgl_awal, $tgl_akhir)
    {
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->join('master_divisi_stock mds', 'mds.id = ds.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = ds.id_gudang', 'left');
        $this->db->where('mi.id_jenis_item', 2);
        $this->db->where('DATE(ds.created) >=', $tgl_awal);
        $this->db->where('DATE(ds.created) <=', $tgl_akhir);
        $this->db->select('ds.*,mi.*,ds.created as tgl_stok,mds.divisi as divisi_aksesoris,mg.gudang');
        $this->db->order_by('ds.id', 'desc');

        return $this->db->get('data_stock ds');
    }
}

/* End of file m_aksesoris.php */
/* Location: ./application/models/inout/m_aksesoris.php */