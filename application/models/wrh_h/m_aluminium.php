<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_aluminium extends CI_Model
{

    public function getdata()
    {
        $id_jenis_item = 1;
        $year  = date('Y');
        $month = date('m');
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->join('master_warna mwa', 'mwa.kode = mi.kode_warna', 'left');
        $this->db->where('mi.kode_warna !=', '01');
        $this->db->where('ds.id_jenis_item', $id_jenis_item);
        $this->db->where('DATE_FORMAT(ds.created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(ds.created,"%m")', $month);
        // $this->db->where('ds.awal_bulan', 1);
        $this->db->where_in('ds.id_gudang', ['2', '4', '58', '59', '79']);
        $this->db->where('ds.qty_in >', 0);
        $this->db->group_by('mi.id');
        $this->db->select('mi.*,mwa.warna');
        return $this->db->get('data_stock ds');
    }

    public function getdataMf()
    {
        $id_jenis_item = 1;
        $year  = date('Y');
        $month = date('m');
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->join('master_warna mwa', 'mwa.kode = mi.kode_warna', 'left');
        $this->db->where('mi.kode_warna', '01');
        $this->db->where('ds.id_jenis_item', $id_jenis_item);
        $this->db->where('DATE_FORMAT(ds.created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(ds.created,"%m")', $month);
        // $this->db->where('ds.awal_bulan', 1);
        $this->db->where_in('ds.id_gudang', ['2', '4', '58', '59', '79']);
        $this->db->where('ds.qty_in >', 0);
        $this->db->group_by('mi.id');
        $this->db->select('mi.*,mwa.warna');
        return $this->db->get('data_stock ds');

        
        // $id_jenis_item = 1;
        // $this->db->join('master_item mi', 'mi.id = dc.id_item', 'left');
        // $this->db->join('master_warna mwa', 'mwa.kode = mi.kode_warna', 'left');
        // $this->db->where('mi.id_jenis_item', $id_jenis_item);
        // $this->db->where('mi.kode_warna', '01');
        // $this->db->where('dc.qty >', 0);
        // $this->db->where_in('dc.id_gudang', ['1','3']);

        // $this->db->select('mi.*,mwa.warna');
        // $this->db->group_by('mi.id');
        // // return $this->db->get('master_item mi');
        // return $this->db->get('data_counter dc');
    }

    public function getdatapaging($num = false, $keyword = '', $perpage = '', $offset = '')
    {
        $id_jenis_item = 1;
        $this->db->join('master_warna mwa', 'mwa.kode = mi.kode_warna', 'left');
        $this->db->where('mi.id_jenis_item', $id_jenis_item);
        $this->db->where('mi.id_warna !=', '01');
        $this->db->select('mwa.warna,mi.*');
        if ($keyword != '') {
            // $this->db->like('mi.section_ata', $keyword);
            // $this->db->like('mi.section_allure', $keyword);
            // $this->db->like('mi.temper', $keyword);
            // $this->db->like('mi.ukuran', $keyword);
            // $this->db->like('mi.kode_warna', $keyword);
            $this->db->like('mi.item_code', $keyword);
            // $this->db->like('mwa.warna', $keyword);
        }
        if ($num) {
            $r = $this->db->get('master_item mi');
            return $r->num_rows();
        } else {
            $this->db->limit($perpage, $offset);
            return $this->db->get('master_item mi');
        }
    }



    public function getCetakMonitoring($id_jenis_barang)
    {
        $this->db->join('master_gudang mg', 'mg.id = dc.id_gudang', 'left');
        $this->db->join('master_item mi', 'mi.id = dc.id_item', 'left');
        $this->db->join('master_warna mw', 'mw.kode = mi.kode_warna', 'left');

        $this->db->where('mi.kode_warna !=', '01');
        $this->db->where_in('dc.id_gudang', ['2', '4', '58', '59', '79']);
        $this->db->select('dc.*,mg.gudang,mi.*,mw.warna');

        $this->db->where('dc.id_jenis_item', $id_jenis_barang);
        return $this->db->get('data_counter dc');
    }

    public function getCetakMonitoringMf($id_jenis_barang)
    {
        $this->db->join('master_gudang mg', 'mg.id = dc.id_gudang', 'left');
        $this->db->join('master_item mi', 'mi.id = dc.id_item', 'left');
        $this->db->join('master_warna mw', 'mw.kode = mi.kode_warna', 'left');
        $this->db->where('mi.kode_warna', '01');
        $this->db->where_in('dc.id_gudang', ['2', '4', '58', '59', '79']);
        $this->db->select('dc.*,mg.gudang,mi.*,mw.warna');

        $this->db->where('dc.id_jenis_item', $id_jenis_barang);
        return $this->db->get('data_counter dc');
    }

    public function getStockAwalBulanCetak()
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(ds.created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(ds.created,"%m")', $month);
        $this->db->where('ds.awal_bulan', 1);
        $this->db->select('*');

        $res  = $this->db->get('data_stock ds');
        $data = array();

        foreach ($res->result() as $key) {

            if (!isset($data[$key->id_item][$key->id_gudang][$key->keranjang])) {
                $data[$key->id_item][$key->id_gudang][$key->keranjang] = 0;
            }
            $data[$key->id_item][$key->id_gudang][$key->keranjang] = $data[$key->id_item][$key->id_gudang][$key->keranjang] + $key->qty_in;
        }
        return $data;
    }

    public function getTotalInPerBulanCetak()
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('inout', 1);
        $this->db->where('awal_bulan', 0);

        $res  = $this->db->get('data_stock');
        $data = array();
        foreach ($res->result() as $key) {

            if (!isset($data[$key->id_item][$key->id_gudang][$key->keranjang])) {
                $data[$key->id_item][$key->id_gudang][$key->keranjang] = 0;
            }
            $data[$key->id_item][$key->id_gudang][$key->keranjang] = $data[$key->id_item][$key->id_gudang][$key->keranjang] + $key->qty_in;
        }
        return $data;
    }

    public function getTotalOutPerBulanCetak()
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('inout', 2);
        $this->db->where('id_surat_jalan >', 0);
        $this->db->where('awal_bulan', 0);

        $res  = $this->db->get('data_stock');
        $data = array();
        foreach ($res->result() as $key) {

            if (!isset($data[$key->id_item][$key->id_gudang][$key->keranjang])) {
                $data[$key->id_item][$key->id_gudang][$key->keranjang] = 0;
            }
            $data[$key->id_item][$key->id_gudang][$key->keranjang] = $data[$key->id_item][$key->id_gudang][$key->keranjang] + $key->qty_out;
        }
        return $data;
    }

    public function getdataItem()
    {
        $id_jenis_item = 1;
        $this->db->join('master_warna mwa', 'mwa.kode = mi.kode_warna', 'left');
        $this->db->where('mi.id_jenis_item', $id_jenis_item);
        $this->db->select('mi.*,mwa.warna');
        // $this->db->limit(300);
        return $this->db->get('master_item mi');
    }

    public function getdataItemAda()
    {
        $id_jenis_item = 1;
        $this->db->join('master_item mi', 'mi.id = dc.id_item', 'left');
        $this->db->join('master_warna mwa', 'mwa.kode = mi.kode_warna', 'left');
        $this->db->where('dc.id_jenis_item', $id_jenis_item);
        $this->db->where_in('dc.id_gudang', ['2', '4', '58', '59', '79']);
        $this->db->select('mi.*,mwa.warna');
        $this->db->group_by('dc.id_item');

        // $this->db->limit(300);
        // return $this->db->get('master_item mi');
        return $this->db->get('data_counter dc');
    }

    public function getdataItemAdamf()
    {
        $id_jenis_item = 1;
        $this->db->join('master_item mi', 'mi.id = dc.id_item', 'left');
        $this->db->join('master_warna mwa', 'mwa.kode = mi.kode_warna', 'left');
        $this->db->where('dc.id_jenis_item', $id_jenis_item);
        $this->db->where('mi.kode_warna', '01');
        $this->db->where_in('dc.id_gudang', ['2', '4', '58', '59', '79']);
        $this->db->select('mi.*,mwa.warna');
        $this->db->group_by('dc.id_item');

        // $this->db->limit(300);
        // return $this->db->get('master_item mi');
        return $this->db->get('data_counter dc');
    }

    public function getdataItemAdawarna()
    {
        $id_jenis_item = 1;
        $this->db->join('master_item mi', 'mi.id = dc.id_item', 'left');
        $this->db->join('master_warna mwa', 'mwa.kode = mi.kode_warna', 'left');
        $this->db->where('dc.id_jenis_item', $id_jenis_item);
        $this->db->where('mi.kode_warna !=', '01');
        $this->db->where_in('dc.id_gudang', ['2', '4', '58', '59', '79']);
        $this->db->select('mi.*,mwa.warna');
        $this->db->group_by('dc.id_item');

        // $this->db->limit(300);
        // return $this->db->get('master_item mi');
        return $this->db->get('data_counter dc');
    }

    public function getdataItemMutasi($id_item)
    {
        $id_jenis_item = 1;
        $this->db->join('master_warna mwa', 'mwa.kode = mi.kode_warna', 'left');
        $this->db->where('mi.id_jenis_item', $id_jenis_item);
        $this->db->where('mi.id', $id_item);
        $this->db->select('mi.*,mwa.warna');
        return $this->db->get('master_item mi');
    }

    public function cekStockAwalBulan()
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('awal_bulan', 1);
        // $this->db->where('id_jenis_item', 1);
        return $this->db->get('data_stock');
    }

    public function getlistStock()
    {


        return $this->db->get('data_counter');
    }

    public function getStockBulanSebelum($id, $id_gudang, $keranjang)
    {
        $hit_tgl = date('Y-m-d', strtotime(date('Y-m-d') . '- 1 month'));

        $year = date('Y', strtotime($hit_tgl));
        $month = date('m', strtotime($hit_tgl));
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->select('sum(qty_in) as stock_in');
        $this->db->where('inout', 1);
        $this->db->where('id_item', $id);
        $res_in = $this->db->get('data_stock');
        $stock_in = ($res_in->num_rows() < 1) ? 0 : $res_in->row()->stock_in;

        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->select('sum(qty_out) as stock_out');
        $this->db->where('inout', 2);
        $this->db->where('id_surat_jalan >', 0);
        $this->db->where('id_item', $id);
        $res_out = $this->db->get('data_stock');
        $stock_out = ($res_out->num_rows() < 1) ? 0 : $res_out->row()->stock_out;

        return $stock_in - $stock_out;
    }

    public function getStockAwalBulan()
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(ds.created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(ds.created,"%m")', $month);
        $this->db->where('ds.awal_bulan', 1);
        $this->db->where('ds.inout', 1);
        $this->db->where_in('ds.id_gudang', ['2', '4', '58', '59', '79']);
        $res = $this->db->get('data_stock ds');
        $data = array();

        foreach ($res->result() as $key) {

            if (!isset($data[$key->id_item])) {
                $data[$key->id_item] = 0;
            }
            $data[$key->id_item] = $data[$key->id_item] + $key->qty_in;
        }
        return $data;

        // $nilai = 0;
        // foreach ($res->result() as $key) {
        //     if (isset($data[$key->id_item])) {
        //         $nilai = $data[$key->id_item];
        //     } else {
        //         $nilai = 0;
        //     }
        //     $data[$key->id_item] = $key->qty_in + $nilai;
        // }
        // return $data;
    }

    public function getTotalBOM()
    {
        $this->db->where('id_fppp !=', 0);
        $this->db->where('status_fppp', 0);
        $res = $this->db->get('data_stock');
        $data = array();
        foreach ($res->result() as $key) {

            if (!isset($data[$key->id_item])) {
                $data[$key->id_item] = 0;
            }
            $data[$key->id_item] = $data[$key->id_item] + $key->qty_bom;
        }
        return $data;
    }

    public function getTotalInPerBulan()
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('inout', 1);
        $this->db->where('awal_bulan', 0);
        $this->db->where('mutasi', 0);
        $this->db->where_in('id_gudang', ['2', '4', '58', '59', '79']);

        $res = $this->db->get('data_stock');
        $data = array();
        foreach ($res->result() as $key) {

            if (!isset($data[$key->id_item])) {
                $data[$key->id_item] = 0;
            }
            $data[$key->id_item] = $data[$key->id_item] + $key->qty_in;
        }
        return $data;
    }

    public function getTotalOut()
    {
        $this->db->where('mutasi', 0);
        $this->db->where('inout', 2);
        // $this->db->where('is_bom', 1);
        $this->db->where('status_fppp', 0);
        $this->db->where('id_surat_jalan >', 0);
        $this->db->where_in('id_gudang', ['2', '4', '58', '59', '79']);

        $res = $this->db->get('data_stock');
        $data = array();
        foreach ($res->result() as $key) {

            if (!isset($data[$key->id_item])) {
                $data[$key->id_item] = 0;
            }
            $data[$key->id_item] = $data[$key->id_item] + $key->qty_out;
        }
        return $data;
    }

    public function getTotalOutPerBulan()
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('mutasi', 0);
        $this->db->where('inout', 2);
        $this->db->where_in('id_gudang', ['2', '4', '58', '59', '79']);
        $this->db->where('id_surat_jalan >', 0);

        $res = $this->db->get('data_stock');
        $data = array();
        foreach ($res->result() as $key) {

            if (!isset($data[$key->id_item])) {
                $data[$key->id_item] = 0;
            }
            $data[$key->id_item] = $data[$key->id_item] + $key->qty_out;
        }
        return $data;
    }

    public function getTotalOutPerBulanMutasi()
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(updated,"%Y")', $year);
        $this->db->where('DATE_FORMAT(updated,"%m")', $month);
        $this->db->where('mutasi', 1);
        $this->db->where('inout', 2);
        $this->db->where_in('id_gudang', ['2', '4', '58', '59', '79']);
        $this->db->where('id_surat_jalan >', 0);

        $res = $this->db->get('data_stock');
        $data = array();
        foreach ($res->result() as $key) {

            if (!isset($data[$key->id_item])) {
                $data[$key->id_item] = 0;
            }
            $data[$key->id_item] = $data[$key->id_item] + $key->qty_out;
        }
        return $data;
    }



    public function getDataDetailTabel($id_item = '')
    {
        $this->db->join('master_item mi', 'mi.id = dc.id_item', 'left');
        $this->db->join('master_gudang mg', 'mg.id = dc.id_gudang', 'left');
        $this->db->where('dc.id_item', $id_item);
        $this->db->where_in('dc.id_gudang', ['2', '4', '58', '59', '79']);
        $this->db->select('dc.*,mi.divisi,mg.gudang');

        return $this->db->get('data_counter dc')->result();
    }

    public function getAwalBulanDetailTabel($id, $id_gudang, $keranjang)
    {
        // $hit_tgl = date('Y-m-d', strtotime(date('Y-m-d') . '- 1 month'));

        // $year = date('Y', strtotime($hit_tgl));
        // $month = date('m', strtotime($hit_tgl));
        $year = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('id_item', $id);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->where('awal_bulan', 1);

        $res = $this->db->get('data_stock');
        $stock = ($res->num_rows() < 1) ? 0 : $res->row()->qty_in;

        return $stock;
    }

    public function getQtyInDetailTabelMonth($id, $id_gudang, $keranjang)
    {
        $year = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('id_item', $id);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->select('sum(qty_in) as stock_in');
        $this->db->where('inout', 1);
        $this->db->where('awal_bulan', 0);
        $res = $this->db->get('data_stock');
        $stock = ($res->num_rows() < 1) ? 0 : $res->row()->stock_in;
        return $stock;
    }
    public function getQtyInDetailTabelMonitoring($id, $id_gudang, $keranjang)
    {
        $year = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('id_item', $id);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->select('sum(qty_in) as stock_in');
        $this->db->where('inout', 1);
        $this->db->where('awal_bulan', 0);
        $this->db->where('mutasi', 0);
        $res = $this->db->get('data_stock');
        $stock = ($res->num_rows() < 1) ? 0 : $res->row()->stock_in;
        return $stock;
    }

    public function getQtyInDetailTabelMonitoringP($id, $id_gudang, $keranjang)
    {
        $year = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('id_item', $id);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->select('sum(qty_in) as stock_in');
        $this->db->where('inout', 1);
        $this->db->where('awal_bulan', 0);
        $this->db->where('mutasi', 0);
        $res = $this->db->get('data_stock');
        $stock = ($res->num_rows() < 1) ? 0 : $res->row()->stock_in;
        return $stock;
    }
    public function getQtyInDetailTabel($id, $id_gudang, $keranjang)
    {
        $year = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('id_item', $id);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->select('sum(qty_in) as stock_in');
        $this->db->where('inout', 1);
        $res = $this->db->get('data_stock');
        $stock = ($res->num_rows() < 1) ? 0 : $res->row()->stock_in;
        return $stock;
    }

    public function getQtyOutDetailTabel($id, $id_gudang, $keranjang)
    {
        $year = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(updated,"%Y")', $year);
        $this->db->where('DATE_FORMAT(updated,"%m")', $month);
        $this->db->where('id_item', $id);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->select('sum(qty_out) as stock_out');
        $this->db->where('inout', 2);
        $this->db->where('id_surat_jalan >', 0);

        $res = $this->db->get('data_stock');
        $stock = ($res->num_rows() < 1) ? 0 : $res->row()->stock_out;
        return $stock;
    }

    public function getQtyOutDetailTabelMonitoring($id, $id_gudang, $keranjang)
    {
        $year = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('id_item', $id);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->select('sum(qty_out) as stock_out');
        $this->db->where('inout', 2);
        $this->db->where('id_surat_jalan >', 0);
        // $this->db->where('mutasi', 0);

        $res = $this->db->get('data_stock');
        $stock = ($res->num_rows() < 1) ? 0 : $res->row()->stock_out;
        return $stock;
    }

    public function getQtyOutDetailTabelMonitoringP($id, $id_gudang, $keranjang)
    {
        $year = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('id_item', $id);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->select('sum(qty_out) as stock_out');
        $this->db->where('inout', 2);
        $this->db->where('id_surat_jalan >', 0);
        // $this->db->where('mutasi', 0);

        $res = $this->db->get('data_stock');
        $stock = ($res->num_rows() < 1) ? 0 : $res->row()->stock_out;
        return $stock;
    }

    public function getQtyOutDetailTabelMonitoringMutasi($id, $id_gudang, $keranjang)
    {
        $year = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('id_item', $id);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->select('sum(qty_out) as stock_out');
        $this->db->where('inout', 2);
        $this->db->where('mutasi', 1);

        $res = $this->db->get('data_stock');
        $stock = ($res->num_rows() < 1) ? 0 : $res->row()->stock_out;
        return $stock;
    }

    public function getQtyOutDetailTabelMonitoringMutasiP($id, $id_gudang, $keranjang)
    {
        $year = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('id_item', $id);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->select('sum(qty_out) as stock_out');
        $this->db->where('inout', 2);
        $this->db->where('mutasi', 1);

        $res = $this->db->get('data_stock');
        $stock = ($res->num_rows() < 1) ? 0 : $res->row()->stock_out;
        return $stock;
    }

    public function getQtyInDetailTabelMonitoringMutasi($id, $id_gudang, $keranjang)
    {
        $year = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('id_item', $id);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->select('sum(qty_in) as stock_out');
        $this->db->where('inout', 1);
        $this->db->where('mutasi', 1);

        $res = $this->db->get('data_stock');
        $stock = ($res->num_rows() < 1) ? 0 : $res->row()->stock_out;
        return $stock;
    }

    public function getQtyInDetailTabelMonitoringMutasiP($id, $id_gudang, $keranjang)
    {
        $year = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('id_item', $id);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->select('sum(qty_in) as stock_out');
        $this->db->where('inout', 1);
        $this->db->where('mutasi', 1);

        $res = $this->db->get('data_stock');
        $stock = ($res->num_rows() < 1) ? 0 : $res->row()->stock_out;
        return $stock;
    }


    public function getDataStock($tgl_awal, $tgl_akhir)
    {
        $id_jenis_item = 1;
        $this->db->join('master_gudang mg', 'mg.id = da.id_gudang', 'left');
        $this->db->join('master_item mi', 'mi.id = da.id_item', 'left');
        $this->db->join('master_warna mwa', 'mwa.kode = mi.kode_warna', 'left');
        $this->db->join('master_supplier ms', 'ms.id = da.id_supplier', 'left');
        $this->db->join('cms_user cu', 'cu.id = da.id_penginput', 'left');
        $this->db->where('da.awal_bulan', 0);
        $this->db->where('da.inout', 1);
        $this->db->where('da.mutasi', 0);
        $this->db->where('mi.id_jenis_item', $id_jenis_item);
        $this->db->where_in('da.id_gudang', ['2', '4', '58', '59', '79']);
        if (from_session('level' > 1)) {
            $this->db->where('da.id_penginput', from_session('id'));
        }
        $this->db->order_by('da.id', 'desc');
        $this->db->where('DATE(da.created) >=', $tgl_awal);
        $this->db->where('DATE(da.created) <=', $tgl_akhir);
        $this->db->select('cu.nama,da.*,mi.divisi,ms.supplier,mg.gudang,mwa.warna,mi.section_ata,mi.section_allure,mi.temper,mi.ukuran,mi.kode_warna');
        return $this->db->get('data_stock da');
    }

    public function insertstokin($value = '')
    {
        $this->db->insert('data_stock', $value);
    }

    public function getDataStockRow($id)
    {
        $this->db->join('master_gudang mg', 'mg.id = da.id_gudang', 'left');
        $this->db->join('master_item mi', 'mi.id = da.id_item', 'left');
        $this->db->join('master_supplier ms', 'ms.id = da.id_supplier', 'left');
        $this->db->join('cms_user cu', 'cu.id = da.id_penginput', 'left');
        $this->db->join('master_warna mwa', 'mwa.kode = mi.kode_warna', 'left');
        $this->db->where('da.id', $id);

        $this->db->select('cu.nama,da.*,mi.divisi,ms.supplier,mg.gudang,mwa.warna,mi.section_ata,mi.section_allure,mi.temper,mi.ukuran,mi.kode_warna');

        return $this->db->get('data_stock da');
    }

    public function updatestokin($value = '', $id)
    {
        $this->db->where('id', $id);
        $this->db->update('data_stock', $value);
    }

    public function getDataCounter($item, $gudang, $keranjang)
    {
        $id_jenis_item = 1;
        $this->db->where('id_jenis_item', $id_jenis_item);
        $this->db->where('id_item', $item);
        $this->db->where('id_gudang', $gudang);
        $this->db->where('keranjang', $keranjang);
        return $this->db->get('data_counter');
    }

    public function updateDataCounter($item, $gudang, $keranjang, $qty)
    {
        $object = array(
            'updated' => date('Y-m-d H:i:s'),
            'qty' => $qty,
        );
        $this->db->where('id_item', $item);
        $this->db->where('id_gudang', $gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->update('data_counter', $object);

        // $object = array(
        //     'updated' => date('Y-m-d H:i:s'),
        //     'qty' => $qty,
        // );
        // $this->db->where('id_item', $item);
        // $this->db->where('id_gudang', $gudang);
        // $this->db->where('keranjang', $keranjang);
        // $cek_ada = $this->db->get('data_counter')->num_rows();

        // if ($cek_ada > 0) {
        //     $object = array(
        //         'updated' => date('Y-m-d H:i:s'),
        //         'qty' => $qty,
        //     );
        //     $this->db->where('id_item', $item);
        //     $this->db->where('id_gudang', $gudang);
        //     $this->db->where('keranjang', $keranjang);
        //     $this->db->update('data_counter', $object);
        // } else {
        //     $simpan = array(
        //         'id_jenis_item' => 1,
        //         'id_item'       => $item,
        //         'id_gudang'     => $gudang,
        //         'keranjang'     => str_replace(' ', '', $keranjang),
        //         'qty'           => $qty,
        //         'created'       => date('Y-m-d H:i:s'),
        //         'updated' => date('Y-m-d H:i:s'),
        //         'itm_code'      => $this->m_kaca->getRowItem($this->input->post('item'))->item_code,
        //     );
        //     $this->db->insert('data_counter', $simpan);
        // } 


    }

    public function updateData($dt)
    {
        $this->db->where('id', $dt['id']);

        $this->db->update('master_item', $dt);
    }

    public function updateRowStock($id_stock, $object)
    {
        $this->db->where('id', $id_stock);
        $this->db->update('data_stock', $object);
    }

    public function getRowStockNonParsial($id_item, $id_fppp)
    {
        $this->db->where('id_item', $id_item);
        $this->db->where('id_fppp', $id_fppp);
        $this->db->where_in('id_gudang', ['2', '4', '58', '59', '79']);
        return $this->db->get('data_stock')->row();
    }

    public function getRowStock($id_stock)
    {
        $this->db->where('id', $id_stock);

        return $this->db->get('data_stock')->row();
    }

    public function hapusParsial($id_stock)
    {
        $this->db->where('id', $id_stock);
        $this->db->delete('data_stock');
    }

    public function getFpppStockOut($jenis_item)
    {
        $this->db->join('data_fppp df', 'df.id = ds.id_fppp', 'left');
        $this->db->where('ds.id_jenis_item', $jenis_item);
        $this->db->where('df.wh_aluminium <', 3);
        $this->db->where('df.bom_aluminium', 1);
        $this->db->where('ds.id_fppp !=', 0);
        $this->db->where('df.id_divisi <=', 5);
        
        // $this->db->where_in('ds.id_gudang', ['1','3']);
        $this->db->select('df.*');
        $this->db->group_by('ds.id_fppp');
        $this->db->order_by('ds.created', 'desc');

        return $this->db->get('data_stock ds');
    }

    public function getQtyOutProses($jenis_item)
    {
        $this->db->where('is_bom', 1);
        $this->db->where('id_jenis_item', $jenis_item);
        $this->db->where('id_surat_jalan', 0);
        // $this->db->where_in('id_gudang', ['2', '4', '58', '59', '79']);
        $res = $this->db->get('data_stock');
        $data = array();
        $nilai = 0;
        foreach ($res->result() as $key) {
            if (isset($data[$key->id_fppp])) {
                $nilai = $data[$key->id_fppp];
            } else {
                $nilai = 0;
            }
            $data[$key->id_fppp] = $key->qty_out + $nilai;
        }
        return $data;
    }

    public function getTotQtyBomFppp($jenis_item)
    {
        $this->db->where('is_bom', 1);
        $this->db->where('id_jenis_item', $jenis_item);
        // $this->db->where_in('id_gudang', ['2', '4', '58', '59', '79']);
        $res = $this->db->get('data_stock');
        $data = array();
        $nilai = 0;
        foreach ($res->result() as $key) {
            if (isset($data[$key->id_fppp])) {
                $nilai = $data[$key->id_fppp];
            } else {
                $nilai = 0;
            }
            $data[$key->id_fppp] = $key->qty_bom + $nilai;
        }
        return $data;
    }

    public function getTotQtyOutFppp($jenis_item)
    {
        $this->db->where('is_bom', 1);
        $this->db->where('id_jenis_item', $jenis_item);
        // $this->db->where('id_surat_jalan !=', 0);
        // $this->db->where_in('id_gudang', ['2', '4', '58', '59', '79']);
        $res = $this->db->get('data_stock');
        $data = array();
        $nilai = 0;
        foreach ($res->result() as $key) {
            if (isset($data[$key->id_fppp])) {
                $nilai = $data[$key->id_fppp];
            } else {
                $nilai = 0;
            }
            $data[$key->id_fppp] = $key->qty_out + $nilai;
        }
        return $data;
    }

    public function getItemBom($id_fppp)
    {
        $id_jenis_item = 1;
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->join('master_warna mwa', 'mwa.kode = mi.kode_warna', 'left');
        $this->db->join('master_gudang mg', 'mg.id = ds.id_gudang', 'left');
        $this->db->join('master_brand mb', 'mb.id = ds.id_multi_brand', 'left');


        $this->db->where('ds.id_fppp', $id_fppp);
        $this->db->where('ds.id_jenis_item', $id_jenis_item);
        $this->db->where('ds.is_bom', 1);
        // $this->db->where_in('ds.id_gudang', ['1','3']);
        $this->db->where('ds.ke_mf', 0);
        $this->db->select('ds.*,ds.id as id_stock,mi.*,mwa.warna,mi.divisi,mg.gudang,ds.created as created_,ds.updated as updated_,mb.brand');

        $this->db->order_by('ds.id', 'asc');

        return $this->db->get('data_stock ds');
    }

    public function getItemBomMf($id_fppp)
    {
        $id_jenis_item = 1;
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->join('master_warna mwa', 'mwa.kode = mi.kode_warna', 'left');
        $this->db->join('master_gudang mg', 'mg.id = ds.id_gudang', 'left');
        $this->db->join('master_brand mb', 'mb.id = ds.id_multi_brand', 'left');

        $this->db->where('ds.id_fppp', $id_fppp);
        $this->db->where('ds.id_jenis_item', $id_jenis_item);
        // $this->db->where('mi.kode_warna !=', '01');
        // $this->db->where('ds.is_bom', 1);
        // $this->db->where('ds.id_surat_jalan', 0);
        $this->db->where('ds.ke_mf', 1);
        // $this->db->where_in('ds.id_gudang', ['1','3']);
        $this->db->select('ds.*,ds.id as id_stock,mi.*,mwa.warna,mi.divisi,mg.gudang,ds.created as created_,ds.updated as updated_,mb.brand');

        $this->db->order_by('ds.id', 'asc');

        return $this->db->get('data_stock ds');
    }

    public function getItemBomfppp($id_fppp, $id_jenis_item)
    {
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->where('ds.id_fppp', $id_fppp);
        $this->db->where('ds.id_jenis_item', $id_jenis_item);
        $this->db->where('ds.is_bom', 1);
        $this->db->where_in('ds.id_gudang', ['2', '4', '58', '59', '79']);
        $this->db->get('data_stock ds');
    }

    public function getAllDataCounter($id_jenis_item)
    {
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->join('master_warna mwa', 'mwa.kode = mi.kode_warna', 'left');
        $this->db->join('master_gudang mg', 'mg.id = ds.id_gudang', 'left');
        $this->db->where('ds.id_jenis_item', $id_jenis_item);
        $this->db->where_in('ds.id_gudang', ['2', '4', '58', '59', '79']);
        $this->db->select('ds.*,ds.id as id_stock,mi.*,mwa.warna,mi.divisi,mg.gudang');

        $this->db->order_by('ds.id', 'desc');

        return $this->db->get('data_counter ds');
    }

    public function getStockAkhirBulan()
    {
        $this->db->where_in('id_gudang', ['2', '4', '58', '59', '79']);
        $res  = $this->db->get('data_counter');
        $data = array();

        foreach ($res->result() as $key) {

            if (!isset($data[$key->id_item])) {
                $data[$key->id_item] = 0;
            }
            $data[$key->id_item] = $data[$key->id_item] + $key->qty;
        }
        return $data;
    }




    public function getQtyTerbanyakStockGudang($id_item)
    {
        $this->db->where('id_item', $id_item);
        // $this->db->where('id_gudang >=', 3);
        $this->db->order_by('qty', 'desc');
        $this->db->limit(1);

        $hasil = $this->db->get('data_counter');
        if ($hasil->num_rows() < 1) {
            return 0;
        } else {
            return $hasil->row()->id_gudang;
        }
    }

    public function getQtyTerbanyakStockKeranjang($id_item)
    {
        $this->db->where('id_item', $id_item);
        // $this->db->where('id_gudang >=', 3);
        $this->db->order_by('qty', 'desc');
        $this->db->limit(1);

        $hasil = $this->db->get('data_counter');
        if ($hasil->num_rows() < 1) {
            return 0;
        } else {
            return $hasil->row()->keranjang;
        }
    }

    public function getQtyTerbanyakStockQty($id_item)
    {
        $this->db->where('id_item', $id_item);
        $this->db->where('id_gudang >=', 3);
        $this->db->order_by('qty', 'desc');
        $this->db->limit(1);

        $hasil = $this->db->get('data_counter');
        if ($hasil->num_rows() < 1) {
            return 0;
        } else {
            return $hasil->row()->qty;
        }
    }

    public function getQtyTerbanyakStockGudangMf($id_item)
    {
        $this->db->where('id_item', $id_item);
        $this->db->where('id_gudang <=', 2);
        $this->db->order_by('qty', 'desc');
        $this->db->limit(1);

        $hasil = $this->db->get('data_counter');
        if ($hasil->num_rows() < 1) {
            return 0;
        } else {
            return $hasil->row()->id_gudang;
        }
    }

    public function getQtyTerbanyakStockKeranjangMf($id_item)
    {
        $this->db->where('id_item', $id_item);
        $this->db->where('id_gudang <=', 2);
        $this->db->order_by('qty', 'desc');
        $this->db->limit(1);

        $hasil = $this->db->get('data_counter');
        if ($hasil->num_rows() < 1) {
            return 0;
        } else {
            return $hasil->row()->keranjang;
        }
    }

    public function getQtyTerbanyakStockQtyMf($id_item)
    {
        $this->db->where('id_item', $id_item);
        $this->db->where('id_gudang <=', 2);
        $this->db->order_by('qty', 'desc');
        $this->db->limit(1);

        $hasil = $this->db->get('data_counter');
        if ($hasil->num_rows() < 1) {
            return 0;
        } else {
            return $hasil->row()->qty;
        }
    }

    public function getSuratJalan($tipe, $id_jenis_item, $tgl_awal, $tgl_akhir)
    {
        if ($tipe == 1) {
            $this->db->join('data_fppp df', 'df.id = dsj.id_fppp', 'left');
            $this->db->select('dsj.*,df.no_fppp,df.nama_proyek,df.deadline_pengiriman,df.deadline_workshop');
        } else {
            $this->db->select('dsj.*');
        }

        $this->db->where('DATE(dsj.tgl_aktual) >=', $tgl_awal);
        $this->db->where('DATE(dsj.tgl_aktual) <=', $tgl_akhir);
        $this->db->where('jenis_aluminium', '2');
        // $this->db->like('dsj.no_surat_jalan', 'SJHRB');


        $this->db->order_by('dsj.id', 'desc');
        $this->db->where('dsj.tipe', $tipe);
        $this->db->where('dsj.id_jenis_item', $id_jenis_item);
        return $this->db->get('data_surat_jalan dsj');
    }

    public function getKeterangan()
    {
        $this->db->where('lapangan', 1);
        $this->db->where_in('id_gudang', ['2', '4', '58', '59', '79']);
        $res = $this->db->get('data_stock');
        $data = array();
        $nilai = 0;
        foreach ($res->result() as $key) {
            if (isset($data[$key->id_surat_jalan])) {
                $nilai = $data[$key->id_surat_jalan];
            } else {
                $nilai = 0;
            }
            $data[$key->id_surat_jalan] = $key->qty_out + $nilai;
        }
        return $data;
    }

    public function getNoSuratJalan()
    {
        $year  = date('Y');
        $month = date('m');
        $id_jenis_item = 1;
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('jenis_aluminium', '2');

        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $this->db->where('id_jenis_item', $id_jenis_item);
        $hasil = $this->db->get('data_surat_jalan');
        if ($hasil->num_rows() > 0) {

            $string = $hasil->row()->no_surat_jalan;
            $arr    = explode("/", $string, 2);
            $first  = $arr[0];
            $no     = $first + 1;
            return $no;
        } else {
            return '1';
        }
    }


    public function getKodeDivisi($id_fppp)
    {
        $this->db->join('master_divisi md', 'md.id = df.id_divisi', 'left');
        $this->db->where('df.id', $id_fppp);
        return $this->db->get('data_fppp df')->row()->divisi_pendek;
    }

    public function getRowFppp($id)
    {
        $this->db->join('master_warna mw', 'mw.id = dp.id_warna', 'left');

        $this->db->where('dp.id', $id);
        $this->db->select('dp.*,mw.warna');

        return $this->db->get('data_fppp dp')->row();
    }

    public function getBomFppp($id_fppp)
    {
        $id_jenis_item = 1;
        $this->db->where('id_fppp', $id_fppp);
        $this->db->where('id_jenis_item', $id_jenis_item);
        $this->db->where('is_bom', 1);

        return $this->db->get('data_stock');
    }

    public function getRowSj($id)
    {
        return $this->db->get('data_surat_jalan');
    }

    public function getBomSJ($id_sj)
    {
        $id_jenis_item = 1;
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->join('master_warna mwa', 'mwa.kode = mi.kode_warna', 'left');
        $this->db->join('master_gudang mg', 'mg.id = ds.id_gudang', 'left');

        $this->db->where('ds.id_surat_jalan', $id_sj);
        $this->db->where('ds.id_jenis_item', $id_jenis_item);
        $this->db->select('ds.*,ds.id as id_stock,mi.*,mwa.warna,mi.divisi,mg.gudang');

        $this->db->order_by('ds.id', 'asc');

        return $this->db->get('data_stock ds');
    }

    public function getQtyOutFppp($id_fppp, $id_item)
    {
        $this->db->where('id_fppp', $id_fppp);
        $this->db->where('inout', 2);
        $this->db->where('id_surat_jalan >', 0);
        $this->db->where('id_item', $id_item);
        $this->db->where_in('id_gudang', ['2', '4', '58', '59', '79']);
        $this->db->select('sum(qty_out) as tot_out');

        return $this->db->get('data_stock')->row()->tot_out;
    }

    public function getQtyBOMFppp($id_fppp, $id_item)
    {
        $this->db->where('id_fppp', $id_fppp);
        $this->db->where('id_item', $id_item);
        $this->db->where('is_bom', 1);

        return $this->db->get('data_stock')->row()->qty;
    }

    public function kuncidetailbom($id_detail)
    {
        $object = array('kunci' => 2,);
        $this->db->where('id', $id_detail);
        $this->db->update('data_stock', $object);
    }

    public function bukakuncidetailbom($id_detail)
    {
        $object = array('kunci' => 1,);
        $this->db->where('id', $id_detail);
        $this->db->update('data_stock', $object);
    }

    public function getListItemBonManual()
    {
        $id_jenis_item = 1;
        $this->db->join('data_fppp df', 'df.id = ds.id_fppp', 'left');
        $this->db->join('master_gudang mg', 'mg.id = ds.id_gudang', 'left');
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->join('master_warna mwa', 'mwa.kode = mi.kode_warna', 'left');
        $this->db->join('master_warna mwab', 'mwab.id = ds.id_warna_akhir', 'left');
        $this->db->join('master_brand mb', 'mb.id = ds.id_multi_brand', 'left');

        $this->db->where('ds.id_surat_jalan', 0);
        $this->db->where('ds.is_bom', 0);
        $this->db->where('ds.inout', 2);
        $this->db->where('id_surat_jalan >', 0);
        $this->db->where('ds.mutasi', 0);
        $this->db->where('ds.id_penginput', from_session('id'));
        $this->db->where('ds.id_jenis_item', $id_jenis_item);
        $this->db->where_in('ds.id_gudang', ['2', '4', '58', '59', '79']);
        $this->db->select('ds.id as id_stock,ds.*,mwab.warna as warna_akhir,mwa.warna,df.no_fppp,df.nama_proyek,mi.divisi as divisi_stock,mg.gudang,mi.*,mb.brand');
        $this->db->order_by('ds.id', 'desc');
        return $this->db->get('data_stock ds');
    }

    public function getListItemStokOut($id_sj)
    {
        $id_jenis_item = 1;
        $this->db->join('data_fppp df', 'df.id = ds.id_fppp', 'left');
        $this->db->join('master_gudang mg', 'mg.id = ds.id_gudang', 'left');
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->join('master_warna mwa', 'mwa.kode = mi.kode_warna', 'left');
        $this->db->join('master_warna mwab', 'mwab.id = ds.id_warna_akhir', 'left');
        $this->db->join('master_brand mb', 'mb.id = ds.id_multi_brand', 'left');

        $this->db->where('ds.id_surat_jalan', $id_sj);
        $this->db->where('ds.inout', 2);
        $this->db->where('id_surat_jalan >', 0);
        $this->db->where('ds.id_jenis_item', $id_jenis_item);
        // $this->db->where_in('ds.id_gudang', ['2', '4', '58', '59', '79']);
        $this->db->select('ds.id as id_stock,ds.*,mwab.warna as warna_akhir,mwa.warna,df.no_fppp,df.nama_proyek,mi.divisi as divisi_stock,mg.gudang,mi.*,mb.brand');

        return $this->db->get('data_stock ds');
    }

    public function getRowSuratJalan($id_sj)
    {
        $this->db->where('id', $id_sj);
        return $this->db->get('data_surat_jalan');
    }

    public function finishdetailbom($id_sj)
    {
        $object = array('kunci' => 1,);
        $this->db->where('id_surat_jalan', $id_sj);
        $this->db->update('data_stock', $object);
    }

    public function editRowOut($field = '', $value = '', $editid = '')
    {
        $this->db->query("UPDATE data_stock SET " . $field . "='" . $value . "' WHERE id=" . $editid);
    }

    public function editQtyOut($editid, $data)
    {
        $this->db->where('id', $editid);
        $this->db->update('data_stock', $data);
    }

    public function editStatusInOut($id)
    {
        $object = array('inout' => 2,);
        $this->db->where('id', $id);
        $this->db->update('data_stock', $object);
    }

    public function editStatusInOutCancel($id)
    {
        $object = array(
            'keranjang' => '',
            'id_gudang' => '',
            'inout' => 0,
        );
        $this->db->where('id', $id);
        $this->db->update('data_stock', $object);
    }

    public function getGudangItem($id_item)
    {
        $this->db->where('dc.id_item', $id_item);
        $this->db->where('dc.qty >', 0);
        $this->db->join('master_gudang mg', 'mg.id = dc.id_gudang', 'left');
        $this->db->select('mg.*');
        $this->db->where_in('dc.id_gudang', ['2', '4', '58', '59', '79']);
        $this->db->group_by('dc.id_gudang');
        return $this->db->get('data_counter dc')->result();
    }



    public function getGudangDivisi($id_item)
    {
        $this->db->where('dc.id_item', $id_item);
        $this->db->join('master_gudang mg', 'mg.id = dc.id_gudang', 'left');
        $this->db->select('mg.*');
        $this->db->where_in('dc.id_gudang', ['2', '4', '58', '59', '79']);
        $this->db->group_by('dc.id_gudang');

        return $this->db->get('data_counter dc')->result();
    }

    public function getKeranjangGudang($id_item,  $id_gudang)
    {
        $this->db->where('dc.id_item', $id_item);
        $this->db->where('dc.id_gudang', $id_gudang);
        $this->db->where('dc.qty >', 0);


        $this->db->select('dc.keranjang');
        return $this->db->get('data_counter dc')->result();
    }

    public function getQtyCounter($id_item, $id_gudang, $keranjang)
    {
        $this->db->where('dc.id_item', $id_item);
        $this->db->where('dc.id_gudang', $id_gudang);
        $this->db->where('dc.keranjang', $keranjang);
        $this->db->select('dc.qty');
        return $this->db->get('data_counter dc')->row()->qty;
    }

    public function getMutasiHistory($id = '')
    {
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->join('master_gudang mg', 'mg.id = ds.id_gudang', 'left');
        $this->db->where('ds.mutasi', 1);
        $this->db->where('ds.id_item', $id);
        $this->db->where_in('ds.id_gudang', ['2', '4', '58', '59', '79']);
        $this->db->order_by('ds.id', 'desc');
        $this->db->select('ds.qty_in,ds.qty_out,,ds.keterangan,ds.keranjang,ds.created as waktu,mi.*,mi.divisi,mg.gudang');


        return $this->db->get('data_stock ds');
    }



    public function getGudangBomItem($jenis_item, $id_item)
    {
        $this->db->join('master_gudang mg', 'mg.id = dc.id_gudang', 'left');
        $this->db->where('dc.id_jenis_item', $jenis_item);
        $this->db->where('dc.id_item', $id_item);
        $this->db->where_in('dc.id_gudang', ['2', '4', '58', '59', '79']);
        $this->db->group_by('dc.id_gudang');
        $this->db->select('mg.*');
        return $this->db->get('data_counter dc');
    }



    public function getKeranjangBomItem($jenis_item, $id_item)
    {
        $this->db->where('dc.id_jenis_item', $jenis_item);
        $this->db->where('dc.id_item', $id_item);
        // $this->db->where_in('dc.id_gudang', ['2', '4', '58', '59', '79']);
        $this->db->group_by('dc.keranjang');
        $this->db->select('dc.keranjang');
        return $this->db->get('data_counter dc');
    }

    public function updateIsKurang($id_stock)
    {
        $obj = array('is_kurang' => 1,);
        $this->db->where('id', $id_stock);
        $this->db->update('data_stock', $obj);
    }

    public function updateIsKurang0($id_stock)
    {
        $obj = array('is_kurang' => 0,);
        $this->db->where('id', $id_stock);
        $this->db->update('data_stock', $obj);
    }

    public function getListBomKurang($id_fppp)
    {
        $this->db->where('id_fppp', $id_fppp);
        $this->db->where('is_kurang', 1);

        return $this->db->get('data_stock');
    }

    public function updatekeMf($id_stock, $id_fppp)
    {




        $id_item      = $this->db->get_where('data_stock', array('id' => $id_stock))->row()->id_item;
        $keranjang      = $this->db->get_where('data_stock', array('id' => $id_stock))->row()->keranjang;
        $id_gudang      = $this->db->get_where('data_stock', array('id' => $id_stock))->row()->id_gudang;
        $qty_bom      = $this->db->get_where('data_stock', array('id' => $id_stock))->row()->qty_bom;
        $id_multi_brand      = $this->db->get_where('data_stock', array('id' => $id_stock))->row()->id_multi_brand;
        $keterangan      = $this->db->get_where('data_stock', array('id' => $id_stock))->row()->keterangan;
        $id_jenis_item = 1;
        $section_ata = $this->db->get_where('master_item', array('id' => $id_item))->row()->section_ata;
        $section_allure = $this->db->get_where('master_item', array('id' => $id_item))->row()->section_allure;
        $temper = $this->db->get_where('master_item', array('id' => $id_item))->row()->temper;
        $ukuran = $this->db->get_where('master_item', array('id' => $id_item))->row()->ukuran;
        $satuan = $this->db->get_where('master_item', array('id' => $id_item))->row()->satuan;
        $kode_warna = '01';

        if ($section_ata != '') {
            $this->db->where('section_ata', $section_ata);
        }
        if ($section_allure != '') {
            $this->db->where('section_allure', $section_allure);
        }
        $this->db->where('temper', $temper);
        $this->db->where('ukuran', $ukuran);
        $this->db->where('kode_warna', $kode_warna);
        $hasil = $this->db->get('master_item');
        if ($hasil->num_rows() == 0) {
            $obj_item = array(
                'id_jenis_item' => $id_jenis_item,
                'section_ata' => $section_ata,
                'section_allure' => $section_allure,
                'temper' => $temper,
                'ukuran' => $ukuran,
                'kode_warna' => $kode_warna,
                'satuan' => $satuan,
                'created' => date('Y-m-d H:i:s'),
            );
            $this->db->insert('master_item', $obj_item);
            $get_id = $this->db->insert_id();
        } else {
            $get_id = $hasil->row()->id;
        }
        // $this->db->where('id_fppp', $id_fppp);
        // $this->db->where('id_item', $id_item);
        // $this->db->where('inout', 1);
        // $this->db->select('sum(qty_bom) as tot_bom');
        // $tot_bom = $this->db->get('data_stock')->row()->tot_bom;

        $this->db->where('id_fppp', $id_fppp);
        $this->db->where('id_item', $id_item);
        $this->db->where('keranjang', $keranjang);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('inout', 2);
        $this->db->where('id_surat_jalan >', 0);
        $this->db->select('sum(qty_out) as tot');
        $tot_terkirim = $this->db->get('data_stock')->row()->tot;

        $this->db->where('id_item', $get_id);
        $this->db->where('id_fppp', $id_fppp);
        $this->db->where('ke_mf', 1);
        $cek_ada = $this->db->get('data_stock')->num_rows();
        $qty_kurang = $qty_bom - $tot_terkirim;
        if ($cek_ada == 0 && $qty_kurang > 0) {
            $object = array(
                'is_bom' => '1',
                'id_stock_sblm' => $id_stock,
                'id_item_sblm' => $id_item,
                'ke_mf' => '1',
                'id_fppp' => $id_fppp,
                'id_jenis_item' => $id_jenis_item,
                'id_item' => $get_id,
                'qty_bom' => $qty_kurang,
                'id_multi_brand' => $id_multi_brand,
                'keterangan' => $keterangan,
                'created' => date('Y-m-d H:i:s'),
            );
            $this->db->insert('data_stock', $object);
        }
    }

    public function updateIsBom($id_stock)
    {
        $object = array('is_bom' => 2);
        $this->db->where('id', $id_stock);
        $this->db->update('data_stock', $object);
    }



    public function getHeaderSendCetak($id)
    {
        $this->db->join('data_fppp df', 'df.id = dsj.id_fppp', 'left');
        $this->db->join('cms_user cu', 'cu.id = dsj.id_penginput', 'left');
        $this->db->where('dsj.id', $id);
        $this->db->select('dsj.*,df.no_fppp,df.applicant,df.nama_proyek,cu.nama');

        return $this->db->get('data_surat_jalan dsj');
    }

    public function getDataDetailSendCetak($id)
    {
        $id_jenis_item = 1;
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->join('master_warna mwa', 'mwa.kode = mi.kode_warna', 'left');
        $this->db->join('data_fppp df', 'df.id = ds.id_fppp', 'left');

        $this->db->where('ds.inout', 2);
        $this->db->where('ds.lapangan', 1);
        $this->db->where('ds.id_jenis_item', $id_jenis_item);
        $this->db->where('ds.id_surat_jalan', $id);

        return $this->db->get('data_stock ds');
    }

    public function getDataDetailSendCetakBon($id)
    {
        $id_jenis_item = 1;
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->join('master_warna mwa', 'mwa.kode = mi.kode_warna', 'left');
        $this->db->join('master_warna mwab', 'mwab.id = ds.id_warna_akhir', 'left');
        $this->db->join('data_fppp df', 'df.id = ds.id_fppp', 'left');

        $this->db->where('ds.inout', 2);
        $this->db->where('ds.lapangan', 1);
        $this->db->where('ds.id_jenis_item', $id_jenis_item);
        $this->db->where('ds.id_surat_jalan', $id);

        // $this->db->group_by('ds.id_item');
        // $this->db->group_by('ds.id_warna_akhir');
        $this->db->select('ds.id as id_stock,ds.qty_out,mwab.warna as warna_akhir,mwa.warna,df.no_fppp,df.nama_proyek,mi.*');

        return $this->db->get('data_stock ds');
    }

    public function deleteItemBonManual($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('data_stock');
    }

    public function updateJadiSuratJalan($id_fppp, $id_sj)
    {
        $this->db->where('id', $id_sj);
        $aktual = $this->db->get('data_surat_jalan')->row()->tgl_aktual;

        $object = array(
            'aktual' => $aktual,
            'id_surat_jalan' => $id_sj
        );
        $this->db->where('id_fppp', $id_fppp);
        $this->db->where('inout', 2);
        $this->db->where('id_surat_jalan', 0);
        $this->db->where('id_jenis_item', 1);
        $this->db->where('mutasi', 0);
        $this->db->where('is_bom', 1);
        $this->db->where('id_penginput', from_session('id'));
        $this->db->update('data_stock', $object);
    }

    public function updateJadiSuratJalanBon($id_sj)
    {
        // $this->db->where('id', $id_sj);
        $aktual = $this->db->get_where('data_surat_jalan', array('id' => $id_sj))->row()->tgl_aktual;
        $keterangan = $this->db->get_where('data_surat_jalan', array('id' => $id_sj))->row()->keterangan_sj;

        $object = array(
            'aktual' => $aktual,
            'keterangan' => $keterangan,
            'id_surat_jalan' => $id_sj
        );
        $this->db->where('inout', 2);
        $this->db->where('id_surat_jalan', 0);
        $this->db->where('sj_mf', 0);
        $this->db->where('is_bom', 0);
        $this->db->where('id_jenis_item', 1);
        $this->db->where('mutasi', 0);
        $this->db->where('jenis_aluminium', 2);
        $this->db->where('id_penginput', from_session('id'));
        $this->db->update('data_stock', $object);
    }

    public function updateJadiSuratJalanMf($id_fppp, $id_sj)
    {
        $this->db->where('id', $id_sj);
        $aktual = $this->db->get('data_surat_jalan')->row()->tgl_aktual;

        $object = array(
            'aktual' => $aktual,
            'id_surat_jalan' => $id_sj
        );
        $this->db->where('id_fppp', $id_fppp);
        $this->db->where('inout', 2);
        $this->db->where('id_surat_jalan', 0);
        $this->db->where('id_jenis_item', 1);
        $this->db->where('mutasi', 0);
        $this->db->where('is_bom', 1);
        $this->db->where('id_penginput', from_session('id'));
        $this->db->where('sj_mf', 1);
        $this->db->update('data_stock', $object);
    }

    public function getRowItemWarna($id_item)
    {
        $this->db->join('master_warna mwa', 'mwa.kode = mi.kode_warna', 'left');
        $this->db->where('mi.id', $id_item);
        return $this->db->get('master_item mi')->row();
    }

    public function updateStatusFppp($id_fppp)
    {
        $object = array('status_fppp' => 1);
        $this->db->where('id_fppp', $id_fppp);
        $this->db->update('data_stock', $object);
    }

    public function updateStatusLunasFppp($id_fppp)
    {
        $object = array('id_status' => 3);
        $this->db->where('id', $id_fppp);
        $this->db->update('data_fppp', $object);
    }

    public function getQtyTotalIn($jenis_item, $item, $gudang, $keranjang)
    {
        $this->db->where('awal_bulan', 0);
        $this->db->where('id_jenis_item', $jenis_item);
        $this->db->where('id_item', $item);
        $this->db->where('id_gudang', $gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->where('inout', 1);
        $this->db->select('sum(qty_in) as qty');

        return $this->db->get('data_stock')->row()->qty;
    }

    public function getQtyTotalOut($jenis_item, $item, $gudang, $keranjang)
    {
        $this->db->where('awal_bulan', 0);
        $this->db->where('id_jenis_item', $jenis_item);
        $this->db->where('id_item', $item);
        $this->db->where('id_gudang', $gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->where('inout', 2);
        $this->db->where('id_surat_jalan >', 0);
        $this->db->select('sum(qty_out) as qty');

        return $this->db->get('data_stock')->row()->qty;
    }

    public function rowsJum($s_at, $s_al, $temper, $kode_warna, $ukuran)
    {
        $this->db->where('section_ata', $s_at);
        $this->db->where('section_allure', $s_al);
        $this->db->where('temper', $temper);
        $this->db->where('kode_warna', $kode_warna);
        $this->db->where('ukuran', $ukuran);

        return $this->db->get('master_item')->num_rows();
    }

    public function updtHapus($s_at, $s_al, $temper, $kode_warna, $ukuran)
    {
        $object = array(
            'id_hapus' => 1,
            // 'dbl' => 1,
        );
        $this->db->where('section_ata', $s_at);
        $this->db->where('section_allure', $s_al);
        $this->db->where('temper', $temper);
        $this->db->where('kode_warna', $kode_warna);
        $this->db->where('ukuran', $ukuran);
        // $this->db->where('jum_row', 2);
        $this->db->order_by('id', 'desc');

        $this->db->limit(1);


        $this->db->update('master_item', $object);
    }

    public function cekCounter($id)
    {
        $this->db->where('id_item', $id);

        return $this->db->get('data_counter')->num_rows();
    }

    public function getListStockPoint($tgl = '')
    {
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->join('master_gudang mg', 'mg.id = ds.id_gudang', 'left');
        $this->db->join('master_warna mwa', 'mwa.kode = mi.kode_warna', 'left');
        $this->db->where('ds.id_jenis_item', 1);
        $this->db->where('DATE(ds.created)', $tgl);
        $this->db->select('ds.*,mg.gudang,mi.item_code,mwa.warna');
        return $this->db->get('data_stok_poin ds');
    }

    public function updateQtyAwalBulan($tgl_aktual, $datapost)
    {
        $this->db->where('awal_bulan', 1);
        $this->db->where('DATE(created) >=', $tgl_aktual);
        $this->db->where('id_item', $datapost['id_item']);
        $this->db->where('id_gudang', $datapost['id_gudang']);
        $this->db->where('keranjang', $datapost['keranjang']);
        $tampil = $this->db->get('data_stock');
        if ($tampil->num_rows() > 0) {
            foreach ($tampil->result() as $key) {
                $qty = $key->qty_in + $datapost['qty_in'];
                $object = array('qty_in' => $qty);
                $this->db->where('awal_bulan', 1);
                $this->db->where('DATE(created) >=', $tgl_aktual);
                $this->db->where('id_item', $datapost['id_item']);
                $this->db->where('id_gudang', $datapost['id_gudang']);
                $this->db->where('keranjang', $datapost['keranjang']);
                $this->db->update('data_stock', $object);
            }
        }
    }


    public function getListStockPointTest($tgl = '')
    {
        // $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        // $this->db->join('master_gudang mg', 'mg.id = ds.id_gudang', 'left');
        // $this->db->join('master_warna mwa', 'mwa.kode = mi.kode_warna', 'left');
        // $this->db->limit(10);
        $this->db->where('ds.id_jenis_item', 1);
        $this->db->where('ds.created', $tgl);
        $this->db->select('ds.*');

        $stokPoint =  $this->db->get('data_stok_poin ds');
        $masterItem =  $this->db->get('master_item');
        $masterGudang =  $this->db->get('master_gudang');
        $masterWarna =  $this->db->get('master_warna');

        $array = array();
        $arrayMI = array();
        $arrayMG = array();
        $arrayMW = array();


        foreach ($masterItem->result() as $mi) {
            $arrayMI[] = $mi;
            // echo $sp->id . "ini adalah idnya". $arrayMG[$sp->id_gudang]->gudang;   
        }

        foreach ($masterGudang->result() as $mg) {
            $arrayMG[] = $mg;
            // echo $sp->id . "ini adalah idnya". $arrayMG[$sp->id_gudang]->gudang;   
        }

        foreach ($masterWarna->result() as $mw) {
            $arrayMW[] = $mw;
            // echo $sp->id . "ini adalah idnya". $arrayMG[$sp->id_gudang]->gudang;   
        }

        foreach ($stokPoint->result() as $sp) {
            $array[] = $sp;
            // echo $sp->id . "ini adalah idnya". $arrayMG[$sp->id_gudang]->gudang;  
            // echo "<br>";        
        }


        // $gudang = $array[]

        // var_dump($array);


        // var_dump($array);

        // die();

        return $array;
    }

    public function updateQtyStockPoin($tgl_aktual, $datapost)
    {
        $this->db->where('awal_bulan', 1);
        $this->db->where('DATE(created) >=', $tgl_aktual);
        $this->db->where('id_item', $datapost['id_item']);
        $this->db->where('id_gudang', $datapost['id_gudang']);
        $this->db->where('keranjang', $datapost['keranjang']);
        $tampil = $this->db->get('data_stok_poin');
        if ($tampil->num_rows() > 0) {
            foreach ($tampil->result() as $key) {
                $qty = $key->qty + $datapost['qty_in'];
                $object = array('qty' => $qty);
                $this->db->where('awal_bulan', 1);
                $this->db->where('DATE(created) >=', $tgl_aktual);
                $this->db->where('id_item', $datapost['id_item']);
                $this->db->where('id_gudang', $datapost['id_gudang']);
                $this->db->where('keranjang', $datapost['keranjang']);
                $this->db->update('data_stok_poin', $object);
            }
        }
    }

    public function getDataWoIn($tgl_awal, $tgl_akhir)
    {
        $this->db->join('master_gudang mg', 'mg.id = dwi.id_gudang', 'left');
        $this->db->join('master_item mi', 'mi.id = dwi.id_item', 'left');
        $this->db->join('master_supplier ms', 'ms.id = dwi.id_supplier', 'left');
        $this->db->join('cms_user cu', 'cu.id = dwi.id_penginput', 'left');
        $this->db->where('DATE(dwi.aktual) >=', $tgl_awal);
        $this->db->where('DATE(dwi.aktual) <=', $tgl_akhir);
        $this->db->where_in('dwi.id_gudang', ['2', '4', '58', '59', '79']);
        $this->db->order_by('dwi.id', 'desc');
        $this->db->where('dwi.is_wo', 1);
        
        $this->db->select('dwi.*,cu.nama,ms.supplier,mg.gudang,mi.section_ata,mi.section_allure,mi.temper,mi.ukuran,mi.kode_warna');

        return $this->db->get('data_stock dwi');
    }

    public function getDropDownWo()
    {
        $this->db->group_by('no_wo');
        $this->db->where('id_divisi <=', 5);
        
        return $this->db->get('data_wo');
    }

    public function getItemWo($no_wo)
    {
        $this->db->join('master_item mi', 'mi.id = dw.id_item', 'left');
        $this->db->where('dw.no_wo', $no_wo);
        $this->db->select('mi.*');
        return $this->db->get('data_wo dw')->result();
    }
}

/* End of file m_aluminium.php */
/* Location: ./application/models/klg/m_aluminium.php */