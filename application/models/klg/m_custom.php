<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_custom extends CI_Model
{

	public function getData($value = '')
	{
		$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->join('data_invoice di', 'di.id = did.id_invoice', 'left');
		$this->db->select('di.no_invoice,di.id_status,di.no_po,mp.item,did.lebar,did.tinggi,mw.warna,did.id,did.bukaan,did.qty,did.date,did.tgl');
		$this->db->where('di.id_status !=', 0);
		$this->db->where('did.id_tipe', 2);
		$this->db->where('did.inout', 1);
		$this->db->order_by('did.id', 'desc');
		return $this->db->get('data_stok_detail did');
	}

	public function getxxx($value = '')
	{
		$this->db->where('did.id_tipe', 2);
		$this->db->where('did.inout', 1);
		return $this->db->get('data_stok_detail_x did');
	}

	public function getDataDirect($value = '')
	{
		$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->select('mp.item,mw.warna,did.*');
		$this->db->where('did.id_invoice', 0);
		$this->db->where('did.id_tipe', 2);
		$this->db->where('did.inout', 1);
		$this->db->order_by('did.id', 'desc');
		return $this->db->get('data_stok_detail did');
	}

	public function getNoPermintaan($value = '')
	{
		// $this->db->select('id,no_invoice');
		// return $this->db->get('data_invoice')->result();
		$this->db->join('data_invoice di', 'di.id = did.id_invoice', 'left');
		$this->db->group_by('did.id_invoice');
		$this->db->where('di.id_status', 1);
		$this->db->where('did.id_tipe', 2);
		$this->db->select('di.id,di.no_invoice');
		return $this->db->get('data_invoice_detail did')->result();
	}


	public function deleteDetailItem($value = '')
	{
		$this->db->where('id', $value);
		$this->db->delete('data_stok_detail');
	}

	public function insertCustomDetail($value = '')
	{
		$this->db->insert('data_stok_detail', $value);
	}

	public function getItemInvoice($id = '')
	{
		$this->db->where('did.id_invoice', $id);
		$this->db->where('did.id_tipe', 2);
		$this->db->join('master_item mi', 'mi.id = did.id_item', 'left');
		$this->db->join('master_tipe mt', 'mt.id = did.id_tipe', 'left');
		$this->db->select('mi.id,mi.item,mt.tipe');
		$this->db->group_by('mi.id');
		return $this->db->get('data_invoice_detail did')->result();
	}

	public function getWarnaItem($id = '', $item = '')
	{
		$this->db->where('did.id_invoice', $id);
		$this->db->where('did.id_item', $item);
		$this->db->where('did.id_tipe', 2);
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->select('mw.id,mw.warna');
		$this->db->group_by('mw.id');
		return $this->db->get('data_invoice_detail did')->result();
	}

	public function getBukaanItem($id = '', $item = '', $warna = '')
	{
		$this->db->where('did.id_invoice', $id);
		$this->db->where('did.id_item', $item);
		$this->db->where('did.id_warna', $warna);
		$this->db->where('did.id_tipe', 2);
		$this->db->select('did.bukaan');
		$this->db->group_by('did.bukaan');
		return $this->db->get('data_invoice_detail did')->result();
	}

	public function getLebarItem($id = '', $item = '', $warna = '', $bukaan = '')
	{
		$this->db->where('did.id_invoice', $id);
		$this->db->where('did.id_item', $item);
		$this->db->where('did.id_warna', $warna);
		$this->db->where('did.bukaan', $bukaan);
		$this->db->where('did.id_tipe', 2);
		$this->db->select('did.lebar');
		$this->db->group_by('did.lebar');
		return $this->db->get('data_invoice_detail did')->result();
	}

	public function getTinggiItem($id = '', $item = '', $warna = '', $bukaan = '', $lebar = '')
	{
		$this->db->where('did.id_invoice', $id);
		$this->db->where('did.id_item', $item);
		$this->db->where('did.id_warna', $warna);
		$this->db->where('did.bukaan', $bukaan);
		$this->db->where('did.lebar', $lebar);
		$this->db->where('did.id_tipe', 2);
		$this->db->select('did.tinggi');
		return $this->db->get('data_invoice_detail did')->result();
	}

	public function getQtyItem($id = '', $item = '', $warna = '', $bukaan = '', $lebar = '', $tinggi = '')
	{
		$this->db->where('did.id_invoice', $id);
		$this->db->where('did.id_item', $item);
		$this->db->where('did.id_warna', $warna);
		$this->db->where('did.bukaan', $bukaan);
		$this->db->where('did.lebar', $lebar);
		$this->db->where('did.tinggi', $tinggi);
		$this->db->where('did.id_tipe', 2);
		$this->db->select('sum(did.qty) as qty');
		return $this->db->get('data_invoice_detail did')->row();
	}

	// public function getLebarTinggi($id='',$item='',$warna='',$bukaan='')
	// {
	// 	$this->db->where('did.id_invoice', $id);
	// 	$this->db->where('did.id_item', $item);
	// 	$this->db->where('did.id_warna', $warna);
	// 	$this->db->where('did.bukaan', $bukaan);
	// 	$this->db->where('did.id_tipe', 2);
	// 	$this->db->select('did.lebar,did.tinggi,sum(did.qty) as qty');
	// 	return $this->db->get('data_invoice_detail did')->row();
	// }

	public function getQtyReady($id = '', $item = '', $warna = '', $bukaan = '')
	{
		$this->db->where('did.id_invoice', $id);
		$this->db->where('did.id_item', $item);
		$this->db->where('did.id_warna', $warna);
		$this->db->where('did.bukaan', $bukaan);
		$this->db->where('did.inout', 1);

		$this->db->select('did.lebar,did.tinggi,sum(did.qty) as qty');
		// return $this->db->get('data_stok_detail did')->row();
		$hasil = $this->db->get('data_stok_detail did');
		if ($hasil->num_rows() > 0) {
			return $hasil->row()->qty;
		} else {
			return '0';
		}
	}

	public function getQtyReadySdh($id = '', $item = '', $warna = '', $bukaan = '', $lebar = '', $tinggi = '')
	{
		$this->db->where('did.id_invoice', $id);
		$this->db->where('did.id_item', $item);
		$this->db->where('did.id_warna', $warna);
		$this->db->where('did.bukaan', $bukaan);
		$this->db->where('did.lebar', $lebar);
		$this->db->where('did.tinggi', $tinggi);
		$this->db->where('did.inout', 1);
		$this->db->where('did.id_tipe', 2);

		$this->db->select('did.lebar,did.tinggi,sum(did.qty) as qty');
		// return $this->db->get('data_stok_detail did')->row();
		$hasil = $this->db->get('data_stok_detail did');
		if ($hasil->num_rows() > 0) {
			return $hasil->row()->qty;
		} else {
			return '0';
		}
	}

	public function getRowData($id = '')
	{
		$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->join('data_invoice di', 'di.id = did.id_invoice', 'left');
		$this->db->select('di.no_invoice,di.id_status,di.no_po,mp.item,did.lebar,did.tinggi,mw.warna,did.id,did.bukaan,did.qty,did.date,did.tgl');
		$this->db->where('did.id', $id);
		return $this->db->get('data_stok_detail did')->row();
	}

	public function updateData($data)
	{
		$this->db->where('id', $data['id']);
		$this->db->update('data_stok_detail', $data);
	}
}

/* End of file m_custom.php */
/* Location: ./application/models/klg/m_custom.php */