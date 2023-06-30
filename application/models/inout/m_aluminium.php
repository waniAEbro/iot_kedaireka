<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_aluminium extends CI_Model
{

    public function getData($tgl_awal, $tgl_akhir)
    {
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->join('master_warna mw', 'mw.kode = mi.kode_warna', 'left');
        $this->db->join('master_gudang mg', 'mg.id = ds.id_gudang', 'left');
        $this->db->join('master_supplier ms', 'ms.id = ds.id_supplier', 'left');
        $this->db->where('ds.id_jenis_item', 1);
        $this->db->where('DATE(ds.aktual) >=', $tgl_awal);
        $this->db->where('DATE(ds.aktual) <=', $tgl_akhir);
        $this->db->where('mg.jenis_aluminium', 1);
        $this->db->join('cms_user cu', 'cu.id = ds.id_penginput', 'left');
        // $this->db->where('DATE(ds.created) >=', $tgl_awal);
        // $this->db->where('DATE(ds.created) <=', $tgl_akhir);
        $this->db->where('ds.inout', 1);
        $this->db->where('ds.awal_bulan', 0);
        $this->db->select('ds.*,mi.*,mw.*,cu.nama,ds.created as tgl_stok,mg.gudang,ms.supplier');
        $this->db->order_by('ds.id', 'desc');
        $this->db->group_by('ds.id');
        return $this->db->get('data_stock ds');
    }

    public function getDataOut($tgl_awal, $tgl_akhir)
    {
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->join('master_warna mw', 'mw.kode = mi.kode_warna', 'left');
        $this->db->join('master_warna mwab', 'mwab.id = ds.id_warna_akhir', 'left');
        
        $this->db->join('master_gudang mg', 'mg.id = ds.id_gudang', 'left');
        $this->db->join('data_surat_jalan dsj', 'dsj.id = ds.id_surat_jalan', 'left');
        $this->db->join('data_fppp df', 'df.id = ds.id_fppp', 'left');
        $this->db->join('master_brand mb', 'mb.id = ds.id_multi_brand', 'left');
        $this->db->join('cms_user cu', 'cu.id = ds.id_penginput', 'left');

        $this->db->where('ds.id_jenis_item', 1);
        $this->db->where('DATE(ds.aktual) >=', $tgl_awal);
        $this->db->where('DATE(ds.aktual) <=', $tgl_akhir);
        $this->db->where('mg.jenis_aluminium', 1);
        // $this->db->where('DATE(ds.created) >=', $tgl_awal);
        // $this->db->where('DATE(ds.created) <=', $tgl_akhir);
        $this->db->where('ds.inout', 2);
        // $this->db->where('ds.in_temp', 0);
        // $this->db->where('ds.id_surat_jalan !=', 0);
        $this->db->select('ds.*,mi.*,mw.*,cu.nama,mwab.warna as warna_akhir,mb.brand,ds.created as tgl_stok,mg.gudang,dsj.no_surat_jalan,df.no_fppp,dsj.tgl_aktual,df.nama_proyek,dsj.penerima,dsj.alamat_pengiriman,dsj.sopir,dsj.no_kendaraan');
        $this->db->order_by('ds.id', 'desc');
        $this->db->group_by('ds.id');
        return $this->db->get('data_stock ds');
    }
}

/* End of file m_aluminium.php */
/* Location: ./application/models/inout/m_aluminium.php */