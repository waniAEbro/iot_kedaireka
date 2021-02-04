<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_invoice extends CI_Model
{

	public function getData($value = '')
	{
		$this->db->order_by('di.id', 'desc');
		$this->db->join('master_store ms', 'ms.id = di.id_store', 'left');
		$this->db->join('master_jenis_market mjm', 'mjm.id = di.id_jenis_market', 'left');
		$this->db->select('di.*,ms.store,mjm.jenis_market');
		return $this->db->get('warehouse_invoice di');
	}

	public function getInvoice($value = '')
	{

		$year = date('Y');
		$month = date('m');
		$this->db->where('DATE_FORMAT(date,"%Y")', $year);
		$this->db->where('DATE_FORMAT(date,"%m")', $month);
		$this->db->order_by('no_invoice', 'desc');
		$this->db->limit(1);
		$hasil = $this->db->get('warehouse_invoice');
		if ($hasil->num_rows() > 0) {

			$string = $hasil->row()->no_invoice;
			$arr = explode("/", $string, 2);
			$first = $arr[0];
			$no = $first + 1;
			return $no;
		} else {
			return '1';
		}
	}

	public function insertInvoice($value = '')
	{
		$this->db->insert('warehouse_invoice', $value);
	}
	public function updateInvoice($value = '', $id = '')
	{
		$this->db->where('id', $id);
		$this->db->update('warehouse_invoice', $value);
	}

	public function insertInvoiceDetail($value = '')
	{
		$this->db->insert('warehouse_invoice_detail', $value);
	}

	public function getDataTabel($value = '')
	{
		$this->db->join('master_store ms', 'ms.id = wi.id_store', 'left');
		$this->db->where('wi.id', $value);
		$this->db->select('wi.*,ms.store');
		return $this->db->get('warehouse_invoice wi');
	}

	public function getDataDetailTabel($value = '')
	{
		$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->join('master_tipe mt', 'mt.id = did.id_tipe', 'left');
		$this->db->join('warehouse_invoice wi', 'wi.id = did.id_invoice', 'left');
		$this->db->where('did.id_invoice', $value);
		$this->db->select('mp.item,mp.harga,did.*,mp.gambar,mw.warna,mt.tipe');
		return $this->db->get('warehouse_invoice_detail did')->result();
	}

	public function getJumDetail($value = '')
	{
		$this->db->where('id_invoice', $value);
		$hasil = $this->db->get('warehouse_invoice_detail');
		if ($hasil->num_rows() > 0) {
			return '1';
		} else {
			return '0';
		}
	}

	public function getRowHarga($item = '', $warna = '')
	{
		$this->db->where('id_item', $item);
		$this->db->where('id_warna', $warna);
		return $this->db->get('data_mapping');
	}

	public function cekNoInvoice($value = '')
	{
		$this->db->where('no_invoice', $value);
		$hasil = $this->db->get('warehouse_invoice');
		if ($hasil->num_rows() > 0) {
			return 'n';
		} else {
			return 'y';
		}
	}

	public function getRowJenisMarket($id_store)
	{
		$this->db->where('id', $id_store);
		return $this->db->get('master_store')->row()->id_jenis_market;
	}
}

/* End of file m_invoice.php */
/* Location: ./application/models/warehouse/m_invoice.php */