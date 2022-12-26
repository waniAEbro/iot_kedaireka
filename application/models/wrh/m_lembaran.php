<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_lembaran extends CI_Model
{

    function __construct()
	{
		$this->column_order = array(null, 'mi.item_code');
		$this->column_search = array('mi.item_code', 'mi.deskripsi');
		// Set default order
		// $this->order = array('nama' => 'asc');
	}
	public function getRows($postData)
	{
		$this->_get_datatables_query($postData);
		if ($postData['length'] != -1) {
			$this->db->limit($postData['length'], $postData['start']);
		}
		$query = $this->db->get();

		return $query->result();
	}
	public function countAll()
	{
        $id_jenis_item = 4;
        $this->db->join('master_warna mwa', 'mwa.kode = mi.kode_warna', 'left');
        $this->db->where('mi.id_jenis_item', $id_jenis_item);
        $this->db->select('mi.*,mwa.warna');
		$this->db->from('master_item mi');

		return $this->db->count_all_results();
	}
	public function countFiltered($postData)
	{
		$this->_get_datatables_query($postData);
		$query = $this->db->get();
		return $query->num_rows();
	}
	private function _get_datatables_query($postData)
	{
		$id_jenis_item = 4;
        $this->db->join('master_warna mwa', 'mwa.kode = mi.kode_warna', 'left');
        $this->db->where('mi.id_jenis_item', $id_jenis_item);
        $this->db->select('mi.*,mwa.warna');
		$this->db->from('master_item mi');

		$i = 0;
		// loop searchable columns 
		foreach ($this->column_search as $item) {
			// if datatable send POST for search
			if ($postData['search']['value']) {
				// first loop
				if ($i === 0) {
					$this->db->like($item, $postData['search']['value']);
				} else {
					$this->db->or_like($item, $postData['search']['value']);
				}
			}
			$i++;
		}

		if (isset($postData['order'])) {
			$this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	//------------------------------cek-----------------------------//

    public function getdata()
    {
        $id_jenis_item = 4;
        $this->db->join('master_warna mwa', 'mwa.kode = mi.kode_warna', 'left');
        $this->db->where('mi.id_jenis_item', $id_jenis_item);
        $this->db->select('mi.*,mwa.warna');
        return $this->db->get('master_item mi');
    }
    public function getdataItem()
    {
        $id_jenis_item = 4;
        $this->db->join('master_warna mwa', 'mwa.kode = mi.kode_warna', 'left');
        
        $this->db->where('mi.id_jenis_item', $id_jenis_item);
        $this->db->select('mi.*,mwa.warna');
        
        return $this->db->get('master_item mi');
    }

    public function cekStockAwalBulan()
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(aktual,"%Y")', $year);
        $this->db->where('DATE_FORMAT(aktual,"%m")', $month);
        $this->db->where('awal_bulan', 1);

        return $this->db->get('data_stock');
    }

    public function getlistStock()
    {
        // $this->db->join('master_divisi_stock md', 'md.id = da.id_divisi', 'left');
        // $this->db->join('master_gudang mg', 'mg.id = da.id_gudang', 'left');
        // $this->db->group_by('da.id_divisi');
        // $this->db->group_by('da.id_gudang');
        // $this->db->group_by('da.keranjang');
        // $this->db->select('da.*');

        // return $this->db->get('data_stock da');
        return $this->db->get('data_counter');
    }

    public function getCetakMonitoring($id_jenis_barang)
    {
        $this->db->join('master_divisi_stock md', 'md.id = dc.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = dc.id_gudang', 'left');
        $this->db->join('master_item mi', 'mi.id = dc.id_item', 'left');
        $this->db->join('master_warna mw', 'mw.kode = mi.kode_warna', 'left');
        $this->db->select('dc.*,mw.warna,md.divisi,mg.gudang,mi.item_code,mi.deskripsi,mi.supplier,mi.lead_time,mi.satuan,mi.lebar,mi.tinggi,mi.tebal');

        $this->db->where('dc.id_jenis_item', $id_jenis_barang);
        return $this->db->get('data_counter dc');
    }

    public function getStockBulanSebelum($id, $id_divisi, $id_gudang, $keranjang)
    {
        $hit_tgl = date('Y-m-d', strtotime(date('Y-m-d') . '- 1 month'));

        $year  = date('Y', strtotime($hit_tgl));
        $month = date('m', strtotime($hit_tgl));
        $this->db->where('DATE_FORMAT(aktual,"%Y")', $year);
        $this->db->where('DATE_FORMAT(aktual,"%m")', $month);
        $this->db->where('id_divisi', $id_divisi);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->select('sum(qty_in) as stock_in');
        $this->db->where('inout', 1);
        $this->db->where('id_item', $id);
        $res_in   = $this->db->get('data_stock');
        $stock_in = ($res_in->num_rows() < 1) ? 0 : $res_in->row()->stock_in;

        $this->db->where('DATE_FORMAT(aktual,"%Y")', $year);
        $this->db->where('DATE_FORMAT(aktual,"%m")', $month);
        $this->db->where('id_divisi', $id_divisi);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->select('sum(qty_out) as stock_out');
        $this->db->where('inout', 2);
        $this->db->where('id_item', $id);
        $res_out   = $this->db->get('data_stock');
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
        $this->db->select('*');

        $res  = $this->db->get('data_stock ds');
        $data = array();

        foreach ($res->result() as $key) {

            if (!isset($data[$key->id_item])) {
                $data[$key->id_item] = 0;
            }
            $data[$key->id_item] = $data[$key->id_item] + $key->qty_in;
        }
        return $data;
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

            if (!isset($data[$key->id_item][$key->id_divisi][$key->id_gudang][$key->keranjang])) {
                $data[$key->id_item][$key->id_divisi][$key->id_gudang][$key->keranjang] = 0;
            }
            $data[$key->id_item][$key->id_divisi][$key->id_gudang][$key->keranjang] = $data[$key->id_item][$key->id_divisi][$key->id_gudang][$key->keranjang] + $key->qty_in;
        }
        return $data;
    }

    public function getTotalInPerBulanCetak()
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(aktual,"%Y")', $year);
        $this->db->where('DATE_FORMAT(aktual,"%m")', $month);
        $this->db->where('DATE_FORMAT(aktual,"%Y")', $year);
        $this->db->where('DATE_FORMAT(aktual,"%m")', $month);
        $this->db->where('inout', 1);
        $this->db->where('awal_bulan', 0);

        $res  = $this->db->get('data_stock');
        $data = array();
        foreach ($res->result() as $key) {

            if (!isset($data[$key->id_item][$key->id_divisi][$key->id_gudang][$key->keranjang])) {
                $data[$key->id_item][$key->id_divisi][$key->id_gudang][$key->keranjang] = 0;
            }
            $data[$key->id_item][$key->id_divisi][$key->id_gudang][$key->keranjang] = $data[$key->id_item][$key->id_divisi][$key->id_gudang][$key->keranjang] + $key->qty_in;
        }
        return $data;
    }

    public function getTotalOutPerBulanCetak()
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(aktual,"%Y")', $year);
        $this->db->where('DATE_FORMAT(aktual,"%m")', $month);
        $this->db->where('DATE_FORMAT(aktual,"%Y")', $year);
        $this->db->where('DATE_FORMAT(aktual,"%m")', $month);
        $this->db->where('inout', 2);
        $this->db->where('awal_bulan', 0);

        $res  = $this->db->get('data_stock');
        $data = array();
        foreach ($res->result() as $key) {

            if (!isset($data[$key->id_item][$key->id_divisi][$key->id_gudang][$key->keranjang])) {
                $data[$key->id_item][$key->id_divisi][$key->id_gudang][$key->keranjang] = 0;
            }
            $data[$key->id_item][$key->id_divisi][$key->id_gudang][$key->keranjang] = $data[$key->id_item][$key->id_divisi][$key->id_gudang][$key->keranjang] + $key->qty_out;
        }
        return $data;
    }

    public function getTotalInPerBulanCetakLalu()
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(aktual,"%Y")', $year);
        $this->db->where('DATE_FORMAT(aktual,"%m")', $month);
        $this->db->where('DATE_FORMAT(aktual,"%Y")', $year);
        $this->db->where('DATE_FORMAT(aktual,"%m") !=', $month);
        $this->db->where('inout', 1);
        $this->db->where('awal_bulan', 0);

        $res  = $this->db->get('data_stock');
        $data = array();
        foreach ($res->result() as $key) {

            if (!isset($data[$key->id_item][$key->id_divisi][$key->id_gudang][$key->keranjang])) {
                $data[$key->id_item][$key->id_divisi][$key->id_gudang][$key->keranjang] = 0;
            }
            $data[$key->id_item][$key->id_divisi][$key->id_gudang][$key->keranjang] = $data[$key->id_item][$key->id_divisi][$key->id_gudang][$key->keranjang] + $key->qty_in;
        }
        return $data;
    }

    public function getTotalOutPerBulanCetakLalu()
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(aktual,"%Y")', $year);
        $this->db->where('DATE_FORMAT(aktual,"%m")', $month);
        $this->db->where('DATE_FORMAT(aktual,"%Y")', $year);
        $this->db->where('DATE_FORMAT(aktual,"%m") !=', $month);
        $this->db->where('inout', 2);
        $this->db->where('awal_bulan', 0);

        $res  = $this->db->get('data_stock');
        $data = array();
        foreach ($res->result() as $key) {

            if (!isset($data[$key->id_item][$key->id_divisi][$key->id_gudang][$key->keranjang])) {
                $data[$key->id_item][$key->id_divisi][$key->id_gudang][$key->keranjang] = 0;
            }
            $data[$key->id_item][$key->id_divisi][$key->id_gudang][$key->keranjang] = $data[$key->id_item][$key->id_divisi][$key->id_gudang][$key->keranjang] + $key->qty_out;
        }
        return $data;
    }

    public function getTotalOutPerBulanCetakProses()
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(aktual,"%Y")', $year);
        $this->db->where('DATE_FORMAT(aktual,"%m")', $month);
        $this->db->where('inout', 2);
        $this->db->where('id_surat_jalan', 0);
        $this->db->where('awal_bulan', 0);
        $this->db->where('mutasi', 0);

        $res  = $this->db->get('data_stock');
        $data = array();
        foreach ($res->result() as $key) {

            if (!isset($data[$key->id_item][$key->id_divisi][$key->id_gudang][$key->keranjang])) {
                $data[$key->id_item][$key->id_divisi][$key->id_gudang][$key->keranjang] = 0;
            }
            $data[$key->id_item][$key->id_divisi][$key->id_gudang][$key->keranjang] = $data[$key->id_item][$key->id_divisi][$key->id_gudang][$key->keranjang] + $key->qty_out;
        }
        return $data;
    }

    public function getStockAkhirBulan()
    {
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

    public function getTotalBOM()
    {
        $this->db->where('id_fppp !=', 0);
        $this->db->where('status_fppp', 0);
        $res  = $this->db->get('data_stock');
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
        $this->db->where('DATE_FORMAT(aktual,"%Y")', $year);
        $this->db->where('DATE_FORMAT(aktual,"%m")', $month);
        $this->db->where('inout', 1);
        $this->db->where('awal_bulan', 0);
        // $this->db->where('mutasi', 0);

        $res  = $this->db->get('data_stock');
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
        // $this->db->where('id_surat_jalan !=', 0);

        $res  = $this->db->get('data_stock');
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
        $this->db->where('DATE_FORMAT(aktual,"%Y")', $year);
        $this->db->where('DATE_FORMAT(aktual,"%m")', $month);
        // $this->db->where('mutasi', 0);
        $this->db->where('inout', 2);
        // $this->db->where('id_surat_jalan !=', 0);
        // $this->db->where('is_bom', 1);
        // $this->db->where('status_fppp', 0);
        // $this->db->where('id_surat_jalan !=', 0);

        $res  = $this->db->get('data_stock');
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
        // $this->db->join('master_divisi_stock md', 'md.id = da.id_divisi', 'left');
        // $this->db->join('master_gudang mg', 'mg.id = da.id_gudang', 'left');
        // $this->db->where('da.inout', 1);
        // $this->db->where('da.id_item', $id_item);
        // $this->db->group_by('da.id_divisi');
        // $this->db->group_by('da.id_gudang');
        // $this->db->group_by('da.keranjang');
        // $this->db->group_by(array('da.id_divisi', 'da.id_gudang', 'da.keranjang'));

        // $this->db->select('da.*,mg.gudang,md.divisi');

        // return $this->db->get('data_stock da')->result();

        $this->db->join('master_item mi', 'mi.id = dc.id_item', 'left');
        $this->db->join('master_gudang mg', 'mg.id = dc.id_gudang', 'left');
        $this->db->join('master_divisi_stock md', 'md.id = dc.id_divisi', 'left');
        $this->db->where('dc.id_item', $id_item);
        $this->db->select('dc.*,md.divisi,mg.gudang');

        return $this->db->get('data_counter dc')->result();
    }

    public function getAwalBulanDetailTabel($id, $id_divisi, $id_gudang, $keranjang)
    {
        // $hit_tgl = date('Y-m-d', strtotime(date('Y-m-d') . '- 1 month'));

        // $year = date('Y', strtotime($hit_tgl));
        // $month = date('m', strtotime($hit_tgl));
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(aktual,"%Y")', $year);
        $this->db->where('DATE_FORMAT(aktual,"%m")', $month);
        $this->db->where('id_item', $id);
        $this->db->where('id_divisi', $id_divisi);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->where('awal_bulan', 1);

        $res   = $this->db->get('data_stock');
        $stock = ($res->num_rows() < 1) ? 0 : $res->row()->qty_in;

        return $stock;
    }

    public function getQtyInDetailTabelMonth($id, $id_divisi, $id_gudang, $keranjang)
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(aktual,"%Y")', $year);
        $this->db->where('DATE_FORMAT(aktual,"%m")', $month);
        $this->db->where('id_item', $id);
        $this->db->where('id_divisi', $id_divisi);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->select('sum(qty_in) as stock_in');
        $this->db->where('inout', 1);
        $this->db->where('awal_bulan', 0);
        $res   = $this->db->get('data_stock');
        $stock = ($res->num_rows() < 1) ? 0 : $res->row()->stock_in;
        return $stock;
    }
    public function getQtyInDetailTabelMonitoring($id, $id_divisi, $id_gudang, $keranjang)
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(aktual,"%Y")', $year);
        $this->db->where('DATE_FORMAT(aktual,"%m")', $month);
        $this->db->where('id_item', $id);
        $this->db->where('id_divisi', $id_divisi);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->select('sum(qty_in) as stock_in');
        $this->db->where('inout', 1);
        $this->db->where('awal_bulan', 0);
        $this->db->where('mutasi', 0);
        $res   = $this->db->get('data_stock');
        $stock = ($res->num_rows() < 1) ? 0 : $res->row()->stock_in;
        return $stock;
    }
    public function getQtyInDetailTabel($id, $id_divisi, $id_gudang, $keranjang)
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(aktual,"%Y")', $year);
        $this->db->where('DATE_FORMAT(aktual,"%m")', $month);
        $this->db->where('id_item', $id);
        $this->db->where('id_divisi', $id_divisi);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->select('sum(qty_in) as stock_in');
        $this->db->where('inout', 1);
        $res   = $this->db->get('data_stock');
        $stock = ($res->num_rows() < 1) ? 0 : $res->row()->stock_in;
        return $stock;
    }

    public function getQtyOutDetailTabel($id, $id_divisi, $id_gudang, $keranjang)
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(updated,"%Y")', $year);
        $this->db->where('DATE_FORMAT(updated,"%m")', $month);
        $this->db->where('id_item', $id);
        $this->db->where('id_divisi', $id_divisi);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->select('sum(qty_out) as stock_out');
        $this->db->where('inout', 2);

        $res   = $this->db->get('data_stock');
        $stock = ($res->num_rows() < 1) ? 0 : $res->row()->stock_out;
        return $stock;
    }

    public function getQtyOutDetailTabelMonitoring($id, $id_divisi, $id_gudang, $keranjang)
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(aktual,"%Y")', $year);
        $this->db->where('DATE_FORMAT(aktual,"%m")', $month);
        $this->db->where('id_item', $id);
        $this->db->where('id_divisi', $id_divisi);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->select('sum(qty_out) as stock_out');
        $this->db->where('inout', 2);
        $this->db->where('mutasi', 0);
        // $this->db->where('id_surat_jalan !=', 0);

        $res   = $this->db->get('data_stock');
        $stock = ($res->num_rows() < 1) ? 0 : $res->row()->stock_out;
        return $stock;
    }

    public function getQtyOutDetailTabelMonitoringMutasi($id, $id_divisi, $id_gudang, $keranjang)
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(aktual,"%Y")', $year);
        $this->db->where('DATE_FORMAT(aktual,"%m")', $month);
        $this->db->where('id_item', $id);
        $this->db->where('id_divisi', $id_divisi);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->select('sum(qty_out) as stock_out');
        $this->db->where('inout', 2);
        $this->db->where('mutasi', 1);

        $res   = $this->db->get('data_stock');
        $stock = ($res->num_rows() < 1) ? 0 : $res->row()->stock_out;
        return $stock;
    }

    public function getQtyInDetailTabelMonitoringMutasi($id, $id_divisi, $id_gudang, $keranjang)
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(aktual,"%Y")', $year);
        $this->db->where('DATE_FORMAT(aktual,"%m")', $month);
        $this->db->where('id_item', $id);
        $this->db->where('id_divisi', $id_divisi);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->select('sum(qty_in) as stock_out');
        $this->db->where('inout', 1);
        $this->db->where('mutasi', 1);

        $res   = $this->db->get('data_stock');
        $stock = ($res->num_rows() < 1) ? 0 : $res->row()->stock_out;
        return $stock;
    }


    public function getDataStock($tgl_awal, $tgl_akhir)
    {
        $id_jenis_item = 4;
        $this->db->join('master_divisi_stock md', 'md.id = da.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = da.id_gudang', 'left');
        $this->db->join('master_item mi', 'mi.id = da.id_item', 'left');
        $this->db->join('master_supplier ms', 'ms.id = da.id_supplier', 'left');
        $this->db->join('master_warna mwa', 'mwa.kode = mi.kode_warna', 'left');
        $this->db->join('cms_user cu', 'cu.id = da.id_penginput', 'left');
        $this->db->where('da.awal_bulan', 0);
        $this->db->where('da.inout', 1);
        $this->db->where('da.mutasi', 0);
        $this->db->where('mi.id_jenis_item', $id_jenis_item);
        if (from_session('level' > 1)) {
            $this->db->where('da.id_penginput', from_session('id'));
        }
        $this->db->order_by('da.id', 'desc');
        $this->db->where('DATE(da.created) >=', $tgl_awal);
        $this->db->where('DATE(da.created) <=', $tgl_akhir);
        $this->db->select('mwa.warna,cu.nama,da.*,md.divisi,ms.supplier,mg.gudang,mi.item_code,mi.deskripsi');

        return $this->db->get('data_stock da');
    }

    public function getDataStockRow($id)
    {
        $this->db->join('master_divisi_stock md', 'md.id = da.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = da.id_gudang', 'left');
        $this->db->join('master_item mi', 'mi.id = da.id_item', 'left');
        $this->db->join('master_supplier ms', 'ms.id = da.id_supplier', 'left');
        $this->db->join('cms_user cu', 'cu.id = da.id_penginput', 'left');
        $this->db->where('da.id', $id);

        $this->db->select('cu.nama,da.*,md.divisi,ms.supplier,mg.gudang,mi.item_code,mi.deskripsi');

        return $this->db->get('data_stock da');
    }

    public function insertstokin($value = '')
    {
        $this->db->insert('data_stock', $value);
    }

    public function updatestokin($value = '', $id)
    {
        $this->db->where('id', $id);
        $this->db->update('data_stock', $value);
    }

    public function getDataCounter($item, $divisi, $gudang, $keranjang)
    {
        $id_jenis_item = 4;
        $this->db->where('id_jenis_item', $id_jenis_item);
        $this->db->where('id_item', $item);
        $this->db->where('id_divisi', $divisi);
        $this->db->where('id_gudang', $gudang);
        $this->db->where('keranjang', $keranjang);
        return $this->db->get('data_counter');
    }

    public function updateDataCounter($item, $divisi, $gudang, $keranjang, $qty)
    {
        // $id_jenis_item = 4;
        $object = array(
            'updated' => date('Y-m-d H:i:s'),
            'qty' => $qty,
        );
        // $this->db->where('id_jenis_item', $id_jenis_item);
        $this->db->where('id_item', $item);
        $this->db->where('id_divisi', $divisi);
        $this->db->where('id_gudang', $gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->update('data_counter', $object);
    }

    public function updateRowStock($id_stock, $object)
    {
        $this->db->where('id', $id_stock);
        $this->db->update('data_stock', $object);
    }

    public function getRowStock($id_stock)
    {
        $this->db->where('id', $id_stock);
        return $this->db->get('data_stock')->row();
    }

    public function getRowItem($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('master_item')->row();
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
        $this->db->where('df.wh_aksesoris <', 4);
        $this->db->where('df.bom_aksesoris', 1);
        $this->db->where('ds.id_fppp !=', 0);
        $this->db->select('df.*');
        $this->db->group_by('ds.id_fppp');
        return $this->db->get('data_stock ds');
    }

    public function getTotQtyBomFppp($jenis_item)
    {
        $this->db->where('is_bom', 1);
        $this->db->where('id_jenis_item', $jenis_item);
        $res   = $this->db->get('data_stock');
        $data  = array();
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
        $res   = $this->db->get('data_stock');
        $data  = array();
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
        $id_jenis_item = 4;
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->join('master_divisi_stock mds', 'mds.id = ds.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = ds.id_gudang', 'left');

        $this->db->where('ds.id_fppp', $id_fppp);
        $this->db->where('ds.id_jenis_item', $id_jenis_item);
        $this->db->where('ds.is_bom', 1);
        // $this->db->where('ds.id_surat_jalan', 0);
        $this->db->where('ds.ke_mf', 0);
        $this->db->select('ds.*,ds.id as id_stock,mi.*,mds.divisi,mg.gudang');

        $this->db->order_by('ds.id', 'asc');

        return $this->db->get('data_stock ds');
    }

    public function getQtyOutProses($jenis_item)
    {
        $this->db->where('is_bom', 1);
        $this->db->where('id_jenis_item', $jenis_item);
        $this->db->where('id_surat_jalan', 0);
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

    public function getItemBomMf($id_fppp)
    {
        $id_jenis_item = 4;
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->join('master_divisi_stock mds', 'mds.id = ds.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = ds.id_gudang', 'left');

        $this->db->where('ds.id_fppp', $id_fppp);
        $this->db->where('ds.id_jenis_item', $id_jenis_item);
        $this->db->where('ds.ke_mf', 1);
        $this->db->select('ds.*,ds.id as id_stock,mi.*,mds.divisi,mg.gudang');

        $this->db->order_by('ds.id', 'asc');

        return $this->db->get('data_stock ds');
    }

    public function getItemBomfppp($id_fppp, $id_jenis_item)
    {
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->where('ds.id_fppp', $id_fppp);
        $this->db->where('ds.id_jenis_item', $id_jenis_item);
        $this->db->where('ds.is_bom', 1);
        $this->db->get('data_stock ds');
    }

    public function getAllDataCounter($id_jenis_item)
    {
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->join('master_divisi_stock mds', 'mds.id = ds.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = ds.id_gudang', 'left');
        $this->db->where('ds.id_jenis_item', $id_jenis_item);
        $this->db->select('ds.*,ds.id as id_stock,mi.*,mds.divisi,mg.gudang');

        $this->db->order_by('ds.id', 'desc');

        return $this->db->get('data_counter ds');
    }



    public function getQtyTerbanyakStockDivisi($id_item)
    {
        $this->db->where('id_item', $id_item);
        // $this->db->where('id_gudang >=', 4);
        $this->db->order_by('qty', 'desc');
        $this->db->limit(1);

        $hasil = $this->db->get('data_counter');
        if ($hasil->num_rows() < 1) {
            return 0;
        } else {
            return $hasil->row()->id_divisi;
        }
    }
    public function getQtyTerbanyakStockGudang($id_item)
    {
        $this->db->where('id_item', $id_item);
        // $this->db->where('id_gudang >=', 4);
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
        // $this->db->where('id_gudang >=', 4);
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
        $this->db->where('id_gudang >=', 4);
        $this->db->order_by('qty', 'desc');
        $this->db->limit(1);

        $hasil = $this->db->get('data_counter');
        if ($hasil->num_rows() < 1) {
            return 0;
        } else {
            return $hasil->row()->qty;
        }
    }

    public function getQtyTerbanyakStockDivisiMf($id_item)
    {
        $this->db->where('id_item', $id_item);
        $this->db->where('id_gudang <=', 2);
        $this->db->order_by('qty', 'desc');
        $this->db->limit(1);

        $hasil = $this->db->get('data_counter');
        if ($hasil->num_rows() < 1) {
            return 0;
        } else {
            return $hasil->row()->id_divisi;
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


        $this->db->order_by('dsj.id', 'desc');
        $this->db->where('dsj.tipe', $tipe);
        $this->db->where('dsj.id_jenis_item', $id_jenis_item);
        return $this->db->get('data_surat_jalan dsj');
    }

    public function getKeterangan()
    {
        $this->db->where('lapangan', 1);
        $res   = $this->db->get('data_stock');
        $data  = array();
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
        $year          = date('Y');
        $month         = date('m');
        $id_jenis_item = 4;
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
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
        $id_jenis_item = 4;
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
        $id_jenis_item = 4;
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->join('master_divisi_stock mds', 'mds.id = ds.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = ds.id_gudang', 'left');

        $this->db->where('ds.id_surat_jalan', $id_sj);
        $this->db->where('ds.id_jenis_item', $id_jenis_item);
        $this->db->select('ds.*,ds.id as id_stock,mi.*,mds.divisi,mg.gudang');

        $this->db->order_by('ds.id', 'asc');

        return $this->db->get('data_stock ds');
    }

    public function getQtyOutFppp($id_fppp, $id_item)
    {
        $this->db->where('id_fppp', $id_fppp);
        $this->db->where('inout', 2);
        $this->db->where('id_item', $id_item);
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
        $id_jenis_item = 4;
        $this->db->join('data_fppp df', 'df.id = ds.id_fppp', 'left');
        $this->db->join('master_divisi_stock mds', 'mds.id = ds.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = ds.id_gudang', 'left');
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->join('master_warna mw', 'mw.id = ds.id_warna_akhir', 'left');
        $this->db->join('master_warna mw2', 'mw2.id = ds.id_warna_awal', 'left');
        $this->db->join('master_brand mb', 'mb.id = ds.id_multi_brand', 'left');

        $this->db->where('ds.id_surat_jalan', 0);
        $this->db->where('ds.is_bom', 0);
        $this->db->where('ds.inout', 2);
        $this->db->where('ds.mutasi', 0);
        $this->db->where('ds.id_penginput', from_session('id'));
        $this->db->where('ds.id_jenis_item', $id_jenis_item);
        $this->db->select('mw2.warna as warna_awal,mw.warna as warna_akhir,ds.id as id_stock,ds.*,df.no_fppp,df.nama_proyek,mds.divisi as divisi_stock,mg.gudang,mi.*,mb.brand');
        $this->db->order_by('ds.id', 'desc');

        return $this->db->get('data_stock ds');
    }

    public function getListItemStokOut($id_sj)
    {
        $id_jenis_item = 4;
        $this->db->join('data_fppp df', 'df.id = ds.id_fppp', 'left');
        $this->db->join('master_divisi_stock mds', 'mds.id = ds.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = ds.id_gudang', 'left');
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->join('master_warna mwa', 'mwa.kode = mi.kode_warna', 'left');
        
        $this->db->join('master_warna mw', 'mw.id = ds.id_warna_akhir', 'left');
        $this->db->join('master_warna mw2', 'mw2.id = ds.id_warna_awal', 'left');
        $this->db->join('master_brand mb', 'mb.id = ds.id_multi_brand', 'left');

        $this->db->where('ds.id_surat_jalan', $id_sj);
        $this->db->where('ds.inout', 2);
        $this->db->where('ds.id_jenis_item', $id_jenis_item);
        $this->db->select('mwa.warna,mw2.warna as warna_awal,mw.warna as warna_akhir,ds.id as id_stock,ds.*,df.no_fppp,df.nama_proyek,mds.divisi as divisi_stock,mg.gudang,mi.*,mb.brand');

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
        $object = array('inout' => 0,);
        $this->db->where('id', $id);
        $this->db->update('data_stock', $object);
    }

    public function getGudangItem($id_item)
    {
        $this->db->where('dc.id_item', $id_item);
        $this->db->where('dc.qty >', 0);
        $this->db->join('master_gudang mg', 'mg.id = dc.id_gudang', 'left');
        $this->db->select('mg.*');
        return $this->db->get('data_counter dc')->result();
    }

    public function getDivisiItem($id_item)
    {
        $this->db->where('dc.id_item', $id_item);
        $this->db->join('master_divisi_stock mds', 'mds.id = dc.id_divisi', 'left');
        $this->db->select('mds.*');
        $this->db->group_by('dc.id_divisi');
        return $this->db->get('data_counter dc')->result();
    }

    public function getGudangDivisi($id_item, $id_divisi)
    {
        $this->db->where('dc.id_item', $id_item);
        $this->db->where('dc.id_divisi', $id_divisi);
        $this->db->join('master_gudang mg', 'mg.id = dc.id_gudang', 'left');
        $this->db->select('mg.*');
        $this->db->group_by('dc.id_gudang');
        return $this->db->get('data_counter dc')->result();
    }

    public function getKeranjangGudang($id_item, $id_divisi, $id_gudang)
    {
        $this->db->where('dc.id_item', $id_item);
        $this->db->where('dc.id_divisi', $id_divisi);
        $this->db->where('dc.id_gudang', $id_gudang);
        $this->db->where('dc.qty >', 0);
        $this->db->select('dc.keranjang');
        return $this->db->get('data_counter dc')->result();
    }

    public function getQtyCounter($id_item, $id_divisi, $id_gudang, $keranjang)
    {
        $this->db->where('dc.id_item', $id_item);
        $this->db->where('dc.id_divisi', $id_divisi);
        $this->db->where('dc.id_gudang', $id_gudang);
        $this->db->where('dc.keranjang', $keranjang);
        $this->db->select('dc.qty');
        return $this->db->get('data_counter dc')->row()->qty;
    }

    public function getMutasiHistory($id = '')
    {
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->join('master_divisi_stock md', 'md.id = ds.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = ds.id_gudang', 'left');
        $this->db->where('ds.mutasi', 1);
        $this->db->where('ds.id_item', $id);
        $this->db->order_by('ds.id', 'desc');
        $this->db->select('ds.qty_in,ds.qty_out,,ds.keterangan,ds.keranjang,ds.created as waktu,mi.*,md.divisi,mg.gudang');

        return $this->db->get('data_stock ds');
    }

    public function getDivisiBom($jenis_item)
    {
        $this->db->join('master_divisi_stock mds', 'mds.id = dc.id_divisi', 'left');

        $this->db->where('dc.id_jenis_item', $jenis_item);
        $this->db->group_by('dc.id_divisi');
        $this->db->select('mds.*');
        return $this->db->get('data_counter dc');
    }

    public function getDivisiBomItem($jenis_item, $id_item)
    {
        $this->db->join('master_divisi_stock mds', 'mds.id = dc.id_divisi', 'left');
        $this->db->where('dc.id_item', $id_item);
        $this->db->where('dc.id_jenis_item', $jenis_item);
        $this->db->group_by('dc.id_divisi');
        $this->db->select('mds.*');
        return $this->db->get('data_counter dc');
    }

    // public function getGudangBom($jenis_item, $is_bon = '')
    // {
    //     $this->db->join('master_gudang mg', 'mg.id = dc.id_gudang', 'left');
    //     $this->db->where('dc.id_jenis_item', $jenis_item);
    //     if ($is_bon != 1) {
    //         $this->db->where('mg.id >=', 4);
    //     }
    //     $this->db->group_by('dc.id_gudang');
    //     $this->db->select('mg.*');
    //     return $this->db->get('data_counter dc');
    // }

    public function getGudangBomItem($jenis_item, $id_item)
    {
        $this->db->join('master_gudang mg', 'mg.id = dc.id_gudang', 'left');
        $this->db->where('dc.id_jenis_item', $jenis_item);
        $this->db->where('dc.id_item', $id_item);
        $this->db->group_by('dc.id_gudang');
        $this->db->select('mg.*');
        return $this->db->get('data_counter dc');
    }

    // public function getGudangBomMf($jenis_item)
    // {
    //     $this->db->join('master_gudang mg', 'mg.id = dc.id_gudang', 'left');
    //     $this->db->where('dc.id_jenis_item', $jenis_item);
    //     $this->db->where('mg.id <=', 2);
    //     $this->db->group_by('dc.id_gudang');
    //     $this->db->select('mg.*');
    //     return $this->db->get('data_counter dc');
    // }

    public function getKeranjangBomItem($jenis_item, $id_item)
    {
        $this->db->where('dc.id_jenis_item', $jenis_item);
        $this->db->where('dc.id_item', $id_item);
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

    public function getListBomKurang($id_fppp)
    {
        $this->db->where('id_fppp', $id_fppp);
        $this->db->where('is_kurang', 1);

        return $this->db->get('data_stock');
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
        $id_jenis_item = 4;
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->join('data_fppp df', 'df.id = ds.id_fppp', 'left');

        $this->db->where('ds.inout', 2);
        $this->db->where('ds.lapangan', 1);
        $this->db->where('ds.id_jenis_item', $id_jenis_item);
        $this->db->where('ds.id_surat_jalan', $id);
        return $this->db->get('data_stock ds');
    }

    public function getDataDetailSendCetakBon($id)
    {
        $id_jenis_item = 4;
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->join('master_warna mwa', 'mwa.kode = mi.kode_warna', 'left');
        $this->db->join('master_warna mw', 'mw.id = ds.id_warna_akhir', 'left');
        $this->db->join('master_warna mw2', 'mw2.id = ds.id_warna_awal', 'left');
        $this->db->join('data_fppp df', 'df.id = ds.id_fppp', 'left');

        $this->db->where('ds.inout', 2);
        $this->db->where('ds.lapangan', 1);
        $this->db->where('ds.id_jenis_item', $id_jenis_item);
        $this->db->where('ds.id_surat_jalan', $id);
        // $this->db->group_by('ds.id_item');
        // $this->db->group_by('ds.id_warna_awal');
        // $this->db->group_by('ds.id_warna_akhir');

        $this->db->select('ds.id as id_stock,ds.qty_out,mwa.warna,mw.warna as warna_akhir,mw2.warna as warna_awal,df.no_fppp,df.nama_proyek,mi.*');

        return $this->db->get('data_stock ds');
    }

    public function deleteItemBonManual($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('data_stock');
    }

    public function deleteSJBonManual($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('data_surat_jalan');

        $this->db->where('id_surat_jalan', $id);
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
        $object = array('id_surat_jalan' => $id_sj);
        $this->db->where('id_fppp', $id_fppp);
        $this->db->where('inout', 2);
        $this->db->where('id_surat_jalan', 0);
        $this->db->where('id_jenis_item', 4);
        $this->db->where('mutasi', 0);
        $this->db->where('is_bom', 1);
        $this->db->where('id_penginput', from_session('id'));
        $this->db->update('data_stock', $object);
    }

    public function updateJadiSuratJalanBon($id_sj)
    {
        $keterangan = $this->db->get_where('data_surat_jalan', array('id' => $id_sj))->row()->keterangan_sj;

        $object = array(
            'keterangan' => $keterangan,
            'id_surat_jalan' => $id_sj
        );
        $this->db->where('inout', 2);
        $this->db->where('id_surat_jalan', 0);
        $this->db->where('sj_mf', 0);
        $this->db->where('is_bom', 0);
        $this->db->where('id_jenis_item', 4);
        $this->db->where('mutasi', 0);
        $this->db->where('id_penginput', from_session('id'));
        $this->db->update('data_stock', $object);
    }

    public function updateJadiSuratJalanMf($id_fppp, $id_sj)
    {
        $object = array('id_surat_jalan' => $id_sj);
        $this->db->where('id_fppp', $id_fppp);
        $this->db->where('inout', 2);
        // $this->db->where('lapangan', 1);
        $this->db->where('id_surat_jalan', 0);
        $this->db->where('sj_mf', 1);
        $this->db->update('data_stock', $object);
    }

    public function getRowItemWarna($id_item)
    {
        $this->db->where('mi.id', $id_item);
        return $this->db->get('master_item mi')->row();
    }

    public function updateStatusFppp($id_fppp)
    {
        $object = array('status_fppp' => 1);
        $this->db->where('id_fppp', $id_fppp);
        $this->db->update('data_stock', $object);
    }

    public function getinOptionGetKeranjang($id_item, $id_divisi, $id_gudang)
    {
        $this->db->where('id_item', $id_item);
        $this->db->where('id_divisi', $id_divisi);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->order_by('qty', 'desc');
        return $this->db->get('data_counter')->row()->keranjang;
    }

    public function getInTemp($id_jenis_item = '')
    {
        $this->db->where('id_jenis_item', $id_jenis_item);
        $this->db->where('id_user', from_session('id'));
        return $this->db->get('data_in_temp');
    }

    public function hapusTemp($id_jenis_item = '')
    {
        $this->db->where('id_jenis_item', $id_jenis_item);
        $this->db->where('id_user', from_session('id'));
        $this->db->delete('data_in_temp');

        $dt = array('in_temp' => 0);
        $this->db->where('id_penginput', from_session('id'));
        $this->db->update('data_stock', $dt);
    }

    public function cekAdaStockPoint($id_jenis_item)
    {
        $this->db->where('DATE(created)', date('Y-m-d'));
        $this->db->where('id_jenis_item', $id_jenis_item);
        $cek = $this->db->get('data_stok_poin')->num_rows();
        if ($cek < 1) {
            $this->db->where('dc.id_jenis_item', $id_jenis_item);
            $counter = $this->db->get('data_counter dc');
            foreach ($counter->result() as $key) {
                $masuk = array(
                    'id_jenis_item' => $id_jenis_item,
                    'id_item'       => $key->id_item,
                    'id_divisi'     => $key->id_divisi,
                    'id_gudang'     => $key->id_gudang,
                    'keranjang'     => $key->keranjang,
                    'qty'           => $key->qty,
                    'created'       => date('Y-m-d H:i:s'),
                    'itm_code'      => $key->itm_code,
                );
                $this->db->insert('data_stok_poin', $masuk);
            }
        }
    }

    public function getListStockPoint($tgl = '')
    {
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->join('master_divisi_stock mds', 'mds.id = ds.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = ds.id_gudang', 'left');
        $this->db->where('ds.id_jenis_item', 4);
        $this->db->where('DATE(ds.created)', $tgl);
        $this->db->select('ds.*,mds.divisi,mg.gudang,mi.item_code,mi.deskripsi');
        return $this->db->get('data_stok_poin ds');
    }
}

/* End of file m_lembaran.php */
/* Location: ./application/models/klg/m_lembaran.php */