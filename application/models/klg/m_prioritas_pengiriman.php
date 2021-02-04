<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_prioritas_pengiriman extends CI_Model
{

	public function getdata($value = '')
	{
		$tgl1 = date('Y-m-d'); // pendefinisian tanggal awal
		$tgl2 = date('Y-m-d', strtotime('+7 days', strtotime($tgl1))); //operasi penjumlahan tanggal sebanyak 6 hari

		$this->db->join('master_brand mb', 'mb.id = di.id_brand', 'left');
		$this->db->join('master_status ms', 'ms.id = di.id_status', 'left');
		$this->db->join('master_store mst', 'mst.id = di.id_store', 'left');
		$this->db->select('di.*,mb.brand,ms.status,mst.store,mst.zona');
		$this->db->order_by('di.tgl_pengiriman', 'asc');
		$this->db->group_by('di.id');
		$this->db->where('di.tgl_pengiriman <=', $tgl2);
		$this->db->where('di.id_status <', 3);
		return $this->db->get('data_invoice di');
	}

	public function getDataFilter($tgl = '', $toko = '')
	{
		$this->db->join('master_brand mb', 'mb.id = di.id_brand', 'left');
		$this->db->join('master_status ms', 'ms.id = di.id_status', 'left');
		$this->db->join('master_store mst', 'mst.id = di.id_store', 'left');
		$this->db->select('di.*,mb.brand,ms.status,mst.store,mst.zona');
		$this->db->order_by('di.tgl_pengiriman', 'asc');
		$this->db->where('di.id_status', 1);
		$this->db->group_by('di.id');
		if ($tgl != 'x') {
			$this->db->where('DATE(tgl_pengiriman)', $tgl);
		}
		if ($toko != 'x') {
			$this->db->where('di.id_store', $toko);
		}
		return $this->db->get('data_invoice di');
	}

	public function getTanggal($value = '')
	{
		$this->db->order_by('di.tgl_pengiriman', 'asc');
		$this->db->where('di.id_status', 1);
		$this->db->group_by('di.tgl_pengiriman');
		return $this->db->get('data_invoice di');
	}

	public function getStore($value = '')
	{
		$this->db->join('master_store mst', 'mst.id = di.id_store', 'left');
		$this->db->where('di.id_status', 1);
		$this->db->select('di.id_store,mst.store');
		$this->db->group_by('di.id_store');
		return $this->db->get('data_invoice di');
	}

	public function updateData($data)
	{

		$this->db->where('id', $data['id']);
		$this->db->update('data_invoice', $data);
	}

	public function cekAdaInvoive($value = '')
	{
		$this->db->where('id_invoice', $value);
		$hasil = $this->db->get('data_pengiriman');
		if ($hasil->num_rows() > 0) {
			return '1';
		} else {
			return '0';
		}
	}

	public function rowPermintaan($value = '')
	{
		$this->db->where('di.id', $value);
		$this->db->join('master_store ms', 'ms.id = di.id_store', 'left');
		$this->db->select('di.*,ms.store');
		return $this->db->get('data_invoice di')->row();
	}

	public function updateStatusInvoice($value = '', $object = '')
	{
		$this->db->where('id', $value);
		$this->db->update('data_invoice', $object);
	}

	public function getQtyIn($item = '', $tipe = '', $warna = '', $bukaan = '', $lebar = '', $tinggi = '')
	{
		// if ($tipe == 1) {
		// 	$this->db->where('is_retur',0);
		// }
		$this->db->where('id_item', $item);
		$this->db->where('id_tipe', $tipe);
		$this->db->where('id_warna', $warna);
		$this->db->where('bukaan', $bukaan);
		$this->db->where('lebar', $lebar);
		$this->db->where('tinggi', $tinggi);
		$this->db->where('inout', 1);
		$this->db->where('status_so', 1);
		$this->db->select('sum(qty) as qty');
		$hasil = $this->db->get('data_stok_detail');
		return $hasil->row()->qty;
	}

	public function getQtyOut($item = '', $tipe = '', $warna = '', $bukaan = '', $lebar = '', $tinggi = '', $id_invoice = '')
	{
		// if ($tipe == 1) {
		// 	$this->db->where('is_retur',0);
		// }
		$this->db->where('id_invoice', $id_invoice);
		$this->db->where('id_item', $item);
		$this->db->where('id_tipe', $tipe);
		$this->db->where('id_warna', $warna);
		$this->db->where('bukaan', $bukaan);
		$this->db->where('lebar', $lebar);
		$this->db->where('tinggi', $tinggi);
		$this->db->where('inout', 2);

		$this->db->select('sum(qty_out) as qty');
		$hasil = $this->db->get('data_stok_detail')->row()->qty;
		if ($hasil != '') {
			return $hasil;
		} else {
			return '0';
		}
	}

	public function getQtyOutAll($item = '', $tipe = '', $warna = '', $bukaan = '', $lebar = '', $tinggi = '')
	{
		$this->db->where('id_item', $item);
		$this->db->where('id_tipe', $tipe);
		$this->db->where('id_warna', $warna);
		$this->db->where('bukaan', $bukaan);
		$this->db->where('lebar', $lebar);
		$this->db->where('tinggi', $tinggi);
		$this->db->where('inout', 2);
		$this->db->where('status_so', 1);

		$this->db->select('sum(qty_out) as qty');
		$hasil = $this->db->get('data_stok_detail');
		return $hasil->row()->qty;
	}

	public function getInvoiceDetail($id = '')
	{
		$this->db->where('id', $id);
		return $this->db->get('data_invoice_detail')->row();
	}

	public function getQtyTerkirimParsial($id_invoice, $id_tipe, $id_item, $id_warna, $bukaan, $lebar, $tinggi)
	{
		$this->db->where('id_invoice', $id_invoice);
		$this->db->where('id_item', $id_tipe);
		$this->db->where('id_tipe', $id_item);
		$this->db->where('id_warna', $id_warna);
		$this->db->where('bukaan', $bukaan);
		$this->db->where('lebar', $lebar);
		$this->db->where('tinggi', $tinggi);
		$this->db->where('inout', 2);

		$this->db->select('sum(qty_out) as qty');
		$hasil = $this->db->get('data_stok_detail');
		return $hasil->row()->qty;
	}

	public function getTotPermintaan($value = '')
	{
		$this->db->where('id_invoice', $value);
		$this->db->select('sum(qty) as total');
		return $this->db->get('data_invoice_detail')->row()->total;
	}

	public function getTotKirim($value = '')
	{
		$this->db->where('id_invoice', $value);
		$this->db->where('inout', 2);
		$this->db->select('sum(qty_out) as total');
		return $this->db->get('data_stok_detail')->row()->total;
	}

	public function getRowdid($value = '')
	{
		$this->db->where('id', $value);
		return $this->db->get('data_invoice_detail')->row();
	}

	public function getValidasi($id_pengiriman = '', $item = '', $tipe = '', $warna = '', $bukaan = '', $lebar = '', $tinggi = '')
	{
		// $this->db->where('id_surat_jalan', $id_pengiriman);
		// $this->db->where('id_item', $item);
		// $this->db->where('id_tipe', $tipe);
		// $this->db->where('id_warna', $warna);
		// $this->db->where('bukaan', $bukaan);
		// $this->db->where('lebar', $lebar);
		// $this->db->where('tinggi', $tinggi);
		// $this->db->where('inout', 2);
		//       $hasil = $this->db->get('data_stok_detail');
		// if ($hasil->num_rows()>0) {
		//           return 'n';
		//       } else {
		return 'y';
		// }
	}

	public function getqtysended($id_pengiriman = '', $item = '', $tipe = '', $warna = '', $bukaan = '', $lebar = '', $tinggi = '')
	{
		// if ($tipe == 1) {
		// 	$this->db->where('is_retur',0);
		// }
		$this->db->where('id_surat_jalan', $id_pengiriman);
		$this->db->where('id_item', $item);
		$this->db->where('id_tipe', $tipe);
		$this->db->where('id_warna', $warna);
		$this->db->where('bukaan', $bukaan);
		$this->db->where('lebar', $lebar);
		$this->db->where('tinggi', $tinggi);
		$this->db->where('inout', 2);

		$this->db->select('sum(qty_out) as qty');
		$hasil = $this->db->get('data_stok_detail')->row()->qty;
		if ($hasil != '') {
			return $hasil;
		} else {
			return '0';
		}
	}

	public function updateqtysend($id_pengiriman = '', $item = '', $tipe = '', $warna = '', $bukaan = '', $lebar = '', $tinggi = '', $qty = '')
	{
		$obj = array(
			'qty_out'        => $qty,
		);
		$this->db->where('id_surat_jalan', $id_pengiriman);
		$this->db->where('id_item', $item);
		$this->db->where('id_tipe', $tipe);
		$this->db->where('id_warna', $warna);
		$this->db->where('bukaan', $bukaan);
		$this->db->where('lebar', $lebar);
		$this->db->where('tinggi', $tinggi);
		$this->db->where('inout', 2);
		$this->db->update('data_stok_detail', $obj);
	}

	public function updateqtywarehouse($id_pengiriman = '', $item = '', $tipe = '', $warna = '', $bukaan = '', $lebar = '', $tinggi = '', $qty = '')
	{
		$obj = array(
			'qty'        => $qty,
		);
		$this->db->where('id_surat_jalan', $id_pengiriman);
		$this->db->where('id_item', $item);
		$this->db->where('id_tipe', $tipe);
		$this->db->where('id_warna', $warna);
		$this->db->where('bukaan', $bukaan);
		$this->db->where('lebar', $lebar);
		$this->db->where('tinggi', $tinggi);
		$this->db->update('warehouse_data_detail', $obj);
	}
}

/* End of file m_prioritas_pengiriman.php */
/* Location: ./application/models/klg/m_prioritas_pengiriman.php */