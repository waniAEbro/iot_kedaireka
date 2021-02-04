<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pengiriman extends CI_Model
{

	public function getdata($store = '', $bulan = '', $tahun = '', $tgl = '')
	{
		$this->db->join('data_invoice di', 'di.id = dp.id_invoice', 'left');
		$this->db->join('master_store ms', 'ms.id = di.id_store', 'left');
		$this->db->select('dp.*,di.is_retur,di.id_retur,di.no_invoice,di.no_po,ms.store,ms.zona');
		if ($store != 'x') {
			$this->db->where('di.id_store', $store);
		}

		if ($bulan != 'x') {
			$this->db->where('MONTH(dp.date)', $bulan);
		}

		if ($tgl != 'x') {
			$this->db->where('DATE(dp.date)', $tgl);
		}

		$this->db->where('YEAR(dp.date)', $tahun);

		$this->db->order_by('dp.id', 'desc');
		return $this->db->get('data_pengiriman dp');
	}

	public function getTotalSent($store = '', $bulan = '', $tahun = '', $tgl = '')
	{
		$this->db->join('data_invoice di', 'di.id = dp.id_invoice', 'left');
		$this->db->join('data_stok_detail dsd', 'dsd.id_surat_jalan = dp.id', 'left');
		$this->db->select('sum(dsd.qty_out) as total');
		if ($store != 'x') {
			$this->db->where('di.id_store', $store);
		}

		if ($bulan != 'x') {
			$this->db->where('MONTH(dp.date)', $bulan);
		}

		if ($tgl != 'x') {
			$this->db->where('DATE(dp.date)', $tgl);
		}

		$this->db->where('YEAR(dp.date)', $tahun);
		return $this->db->get('data_pengiriman dp')->row()->total;
	}

	public function getpengiriman($value = '')
	{
		// $year = date('Y');
		// $this->db->where('DATE_FORMAT(date,"%Y")', $year);
		// $hasil = $this->db->get('data_pengiriman');
		//       if ($hasil->num_rows()>0) {
		//           return $hasil->num_rows()+1;
		//       } else {
		//           return '1';
		//       }
		$year = date('Y');
		$month = date('m');
		$this->db->where('DATE_FORMAT(date,"%Y")', $year);
		$this->db->where('DATE_FORMAT(date,"%m")', $month);
		$this->db->order_by('no_pengiriman', 'desc');
		$this->db->limit(1);
		$hasil = $this->db->get('data_pengiriman');
		if ($hasil->num_rows() > 0) {

			$string = $hasil->row()->no_pengiriman;
			$arr = explode("/", $string, 2);
			$first = $arr[0];
			$no = $first + 1;
			return $no;
		} else {
			return '1';
		}
	}

	public function insertpengiriman($value = '')
	{
		$this->db->insert('data_pengiriman', $value);
	}

	public function updatepengiriman($data = '', $id = '')
	{
		$this->db->where('id', $id);
		$this->db->update('data_pengiriman', $data);
	}

	public function insertdetailpengiriman($value = '')
	{
		$this->db->insert('data_stok_detail', $value);
	}

	public function insertWarehouse($value = '')
	{
		$this->db->insert('warehouse_data_detail', $value);
	}

	public function getDataDetailTabel($id_invoice = '', $id_surat_jalan = '')
	{
		$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->join('master_tipe mt', 'mt.id = did.id_tipe', 'left');
		$this->db->join('master_status_detail msd', 'msd.id = did.id_status_detail', 'left');
		$this->db->join('data_stok_detail dpd', 'dpd.id_tipe= did.id_tipe AND dpd.id_item = did.id_item AND dpd.id_warna = did.id_warna AND dpd.bukaan = did.bukaan AND dpd.lebar = did.lebar AND dpd.tinggi = did.tinggi', 'left');
		$this->db->where('dpd.inout', 2);
		$this->db->where('did.id_invoice', $id_invoice);
		$this->db->where('dpd.id_surat_jalan', $id_surat_jalan);
		$this->db->group_by('dpd.id');
		$this->db->select('msd.status_detail,mp.item,did.lebar,did.tinggi,did.bukaan,mp.gambar,mw.warna,mt.tipe,did.id,dpd.qty_out,did.keterangan');
		return $this->db->get('data_invoice_detail did')->result();
	}

	public function deletePengiriman($value = '')
	{
		$object = array('id_status' => 2,);
		$this->db->where('id', $value);
		$this->db->update('data_pengiriman', $object);
	}

	public function deleteStokDetail($value = '')
	{
		$this->db->where('id_surat_jalan', $value);
		$this->db->delete('data_stok_detail');
	}

	public function deleteStokWarehouse($value = '')
	{
		$this->db->where('id_surat_jalan', $value);
		$this->db->delete('warehouse_data_detail');
	}

	public function updateStatusInvoice($value = '')
	{
		$obj = array('id_status' => 1,);
		$this->db->where('id', $value);
		$this->db->update('data_invoice', $obj);
	}

	public function getHeaderCetak($value = '')
	{
		$this->db->join('data_invoice di', 'di.id = dp.id_invoice', 'left');
		$this->db->join('master_brand mb', 'mb.id = di.id_brand', 'left');
		$this->db->join('master_status ms', 'ms.id = di.id_status', 'left');
		$this->db->join('master_store mst', 'mst.id = di.id_store', 'left');
		$this->db->select('dp.*,di.no_invoice,di.no_po,mb.brand,ms.status,mst.store,mst.zona,di.alamat_proyek as alamat,di.no_telp');
		$this->db->where('dp.id', $value);
		return $this->db->get('data_pengiriman dp')->row();
	}

	public function getDataDetailCetak($id_surat_jalan = '')
	{
		$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->join('master_tipe mt', 'mt.id = did.id_tipe', 'left');
		$this->db->join('master_status_detail msd', 'msd.id = did.id_status_detail', 'left');
		$this->db->join('data_stok_detail dpd', 'dpd.id_invoice= did.id_invoice AND dpd.id_tipe= did.id_tipe AND dpd.id_item = did.id_item AND dpd.id_warna = did.id_warna AND dpd.bukaan = did.bukaan AND dpd.lebar = did.lebar AND dpd.tinggi = did.tinggi', 'left');
		$this->db->where('dpd.inout', 2);
		// $this->db->where('did.id_invoice', $id_invoice);
		$this->db->where('dpd.id_surat_jalan', $id_surat_jalan);
		// $this->db->group_by('did.id_item,did.id_tipe,did.id_warna,did.bukaan,did.lebar,did.tinggi,dpd.qty_out');
		$this->db->group_by('dpd.id');
		$this->db->select('msd.status_detail,mp.item,did.lebar,did.tinggi,did.bukaan,mp.gambar,mw.warna,mt.tipe,did.id,dpd.qty_out,did.keterangan');
		return $this->db->get('data_invoice_detail did')->result();
		// $this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		// $this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		// $this->db->join('master_tipe mt', 'mt.id = did.id_tipe', 'left');
		// $this->db->where('did.id_surat_jalan', $value);
		// $this->db->select('mp.item,did.*,mp.gambar,mw.warna,mt.tipe');
		// return $this->db->get('data_stok_detail did')->result();
	}

	public function getItemTotalPengiriman($value = '')
	{
		// $this->db->where('id_surat_jalan', $value);
		// $this->db->select('sum(qty_out) as tot');
		// return $this->db->get('data_stok_detail')->row()->tot;
		$res = $this->db->get('data_stok_detail did');
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

	public function getRowPengiriman($id = '')
	{
		$this->db->join('data_invoice di', 'di.id = dp.id_invoice', 'left');
		$this->db->join('master_store ms', 'ms.id = di.id_store', 'left');
		$this->db->select('dp.*,di.is_retur,di.id_retur,di.no_invoice,di.no_po,ms.store,ms.zona');
		$this->db->where('dp.id', $id);

		return $this->db->get('data_pengiriman dp')->row();
	}
}

/* End of file m_pengiriman.php */
/* Location: ./application/models/klg/m_pengiriman.php */