<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_laporan_keuangan extends CI_Model
{
    public function getJenisBarang()
    {
        return $this->db->get('master_jenis_barang');
    }

    public function getJenisMarket()
    {
        return $this->db->get('master_jenis_market');
    }

    public function getStore($jenis_barang, $jenis_market, $tgl_awal, $tgl_akhir)
    {
        $this->db->join('warehouse_invoice di', 'di.id = did.id_invoice', 'left');
        $this->db->join('master_store ms', 'ms.id = di.id_store', 'left');
        $this->db->join('master_jenis_market mjm', 'mjm.id = di.id_jenis_market', 'left');
        $this->db->join('master_item mi', 'mi.id = did.id_item', 'left');
        $this->db->where('mi.id_jenis_barang', $jenis_barang);
        $this->db->where('di.id_jenis_market', $jenis_market);
        // $this->db->where('di.id_status', 2);
        $this->db->where('DATE(di.date) >=', $tgl_awal);
        $this->db->where('DATE(di.date) <=', $tgl_akhir);
        $this->db->select('ms.id,ms.store,mjm.jenis_market,sum(did.qty) as tot_qty,sum(did.qty*did.harga) as tot_harga');
        $this->db->group_by('ms.id');
        $this->db->order_by('tot_harga', 'desc');


        return $this->db->get('warehouse_invoice_detail did');
    }

    // public function getItemTotalInvoice($bulan = '', $tahun = '')
    // {
    //     $this->db->join('warehouse_invoice di', 'di.id = did.id_invoice', 'left');
    //     $this->db->join('master_item mi', 'mi.id = did.id_item', 'left');
    //     // $this->db->where('di.id_status', 2);
    //     $this->db->where('MONTH(di.date)', $bulan);
    //     $this->db->where('YEAR(di.date)', $tahun);
    //     $res = $this->db->get('warehouse_invoice_detail did');
    //     $data = array();
    //     $nilai = 0;
    //     foreach ($res->result() as $key) {
    //         if (isset($data[$key->id_store][$key->id_jenis_barang])) {
    //             $nilai = $data[$key->id_store][$key->id_jenis_barang];
    //         } else {
    //             $nilai = 0;
    //         }
    //         $data[$key->id_store][$key->id_jenis_barang] = $key->qty + $nilai;
    //     }
    //     return $data;
    // }

    // public function getItemNilaiInvoice($bulan = '', $tahun = '')
    // {
    //     $this->db->join('warehouse_invoice di', 'di.id = did.id_invoice', 'left');
    //     $this->db->join('master_item mi', 'mi.id = did.id_item', 'left');
    //     // $this->db->where('di.id_status', 2);
    //     $this->db->where('MONTH(di.date)', $bulan);
    //     $this->db->where('YEAR(di.date)', $tahun);
    //     $this->db->select('di.id_store,did.*,mi.id_jenis_barang');

    //     $res = $this->db->get('warehouse_invoice_detail did');
    //     $data = array();
    //     $nilai = 0;
    //     foreach ($res->result() as $key) {
    //         if (isset($data[$key->id_store][$key->id_jenis_barang])) {
    //             $nilai = $data[$key->id_store][$key->id_jenis_barang];
    //         } else {
    //             $nilai = 0;
    //         }
    //         $data[$key->id_store][$key->id_jenis_barang] = ($key->qty * $key->harga) + $nilai;
    //     }
    //     return $data;
    // }

    public function getAllItemTotalInvoice($tgl_awal, $tgl_akhir)
    {
        $this->db->join('warehouse_invoice di', 'di.id = did.id_invoice', 'left');
        // $this->db->where('di.id_status', 2);
        $this->db->where('DATE(di.date) >=', $tgl_awal);
        $this->db->where('DATE(di.date) <=', $tgl_akhir);
        $this->db->select('sum(did.qty) as total');

        return $this->db->get('warehouse_invoice_detail did')->row()->total;
    }

    public function getAllItemNilaiInvoice($tgl_awal, $tgl_akhir)
    {
        $this->db->join('warehouse_invoice di', 'di.id = did.id_invoice', 'left');
        // $this->db->where('di.id_status', 2);
        $this->db->where('DATE(di.date) >=', $tgl_awal);
        $this->db->where('DATE(di.date) <=', $tgl_akhir);
        $this->db->select('sum(did.qty*did.harga) as total');
        return $this->db->get('warehouse_invoice_detail did')->row()->total;
    }

    public function getDataLaporanDetail($store, $tgl_awal, $tgl_akhir)
    {
        $this->db->order_by('di.id', 'desc');
        $this->db->join('master_store ms', 'ms.id = di.id_store', 'left');
        $this->db->join('master_jenis_market mjm', 'mjm.id = di.id_jenis_market', 'left');
        $this->db->select('di.*,ms.store,mjm.jenis_market');
        $this->db->where('di.id_store', $store);
        $this->db->where('DATE(di.date) >=', $tgl_awal);
        $this->db->where('DATE(di.date) <=', $tgl_akhir);
        return $this->db->get('warehouse_invoice di');
    }
}

/* End of file m_laporan_keuangan.php */
/* Location: ./application/models/klg/m_laporan_keuangan.php */