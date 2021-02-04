<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_salahkirim extends CI_Model {

	public function getData($value='')
	{
		$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->join('data_pengiriman dp', 'dp.id = did.id_pengiriman', 'left');
		$this->db->join('master_tipe mt', 'mt.id = did.id_tipe', 'left');
		$this->db->join('data_invoice di', 'di.id = dp.id_invoice', 'left');
		$this->db->select('did.bukaan,mt.tipe,dp.no_pengiriman,di.no_invoice,di.no_po,mp.item,did.lebar,did.tinggi,mw.warna,did.id,did.qty,did.date,did.keterangan');
		return $this->db->get('data_salahkirim_detail did');
	}

	public function getNoPengiriman($value='')
	{
		$this->db->order_by('id', 'desc');
		$this->db->limit(25);
		$this->db->select('id_invoice as id, no_pengiriman');
		return $this->db->get('data_pengiriman')->result();
	}


	public function deleteDetailItem($value='')
	{
		$this->db->where('id', $value);
		$this->db->delete('data_salahkirim_detail');
	}

	public function insertsalahkirimDetail($value='')
	{
		$this->db->insert('data_salahkirim_detail', $value);
	}

	public function getItemInvoice($id='')
	{
		$this->db->where('did.id_invoice', $id);
		$this->db->join('master_item mi', 'mi.id = did.id_item', 'left');
		$this->db->join('master_tipe mt', 'mt.id = did.id_tipe', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->select('did.*,mi.item,mt.tipe,mw.warna');
		return $this->db->get('data_invoice_detail did')->result();
	}

	// public function getWarnaItem($id='',$item='')
	// {
	// 	$this->db->where('did.id_invoice', $id);
	// 	$this->db->where('did.id_item', $item);
	// 	$this->db->where('did.id_tipe', 2);
	// 	$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
	// 	$this->db->select('mw.id,mw.warna');
	// 	return $this->db->get('data_invoice_detail did')->result();
	// }

	// public function getBukaanItem($id='',$item='',$warna='')
	// {
	// 	$this->db->where('did.id_invoice', $id);
	// 	$this->db->where('did.id_item', $item);
	// 	$this->db->where('did.id_warna', $warna);
	// 	$this->db->where('did.id_tipe', 2);
	// 	$this->db->select('did.bukaan');
	// 	return $this->db->get('data_invoice_detail did')->result();
	// }

	// public function getLebarTinggi($id='',$item='',$warna='',$bukaan='')
	// {
	// 	$this->db->where('did.id_invoice', $id);
	// 	$this->db->where('did.id_item', $item);
	// 	$this->db->where('did.id_warna', $warna);
	// 	$this->db->where('did.bukaan', $bukaan);
	// 	$this->db->select('did.lebar,did.tinggi,did.qty');
	// 	return $this->db->get('data_invoice_detail did')->row();
	// }

	public function getNoInvoice($id='')
	{
		$this->db->join('data_invoice di', 'di.id = dp.id_invoice', 'left');
		$this->db->where('dp.id_invoice', $id);
		$this->db->select('dp.id, di.no_invoice');
		return $this->db->get('data_pengiriman dp')->row();
	}

	public function getDetailInvoice($value='')
	{
		$this->db->where('id', $value);
		return $this->db->get('data_invoice_detail')->row();
	}

	public function getDetailsalahkirim($id='')
	{
		$this->db->where('drd.id', $id);
		$this->db->join('data_pengiriman dp', 'dp.id = drd.id_pengiriman', 'left');
		$this->db->join('data_invoice di', 'di.id = dp.id_invoice', 'left');
		$this->db->select('drd.*,di.*');
		return $this->db->get('data_salahkirim_detail drd')->row();
	}

	public function getMaxProduksi($value='')
	{
		$this->db->select_max('id');
		return $this->db->get('data_produksi')->row()->id;
	}

	public function tambahStokCommon($value='')
	{
		$this->db->insert('data_produksi_detail', $value);
	}

	public function updateStatus($value='')
	{
		$object = array('status' => 2, );
		$this->db->where('id', $value);
		$this->db->update('data_salahkirim_detail', $object);
	}

	

}
