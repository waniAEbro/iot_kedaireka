<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_retur extends CI_Model {

	public function getData($value='')
	{
		$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->join('master_tipe mt', 'mt.id = did.id_tipe', 'left');

		$this->db->join('master_item mpn', 'mpn.id = did.id_item_baru', 'left');
		$this->db->join('master_warna mwn', 'mwn.id = did.id_warna_baru', 'left');
		$this->db->join('master_tipe mtn', 'mtn.id = did.id_tipe_baru', 'left');

		$this->db->join('data_pengiriman dp', 'dp.id = did.id_surat_jalan', 'left');
		$this->db->join('data_invoice di', 'di.id = dp.id_invoice', 'left');
		$this->db->select('did.*,mt.tipe,dp.no_pengiriman,di.no_invoice,di.no_po,mp.item,mw.warna,mpn.item as item_baru,mwn.warna as warna_baru,mtn.tipe as tipe_baru');
		// $this->db->where('did.status', 1);
		$this->db->order_by('did.id', 'desc');
		return $this->db->get('data_retur_detail did');
	}

	public function getEditRetur($value='')
	{
		$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->join('data_pengiriman dp', 'dp.id = did.id_surat_jalan', 'left');
		$this->db->join('master_tipe mt', 'mt.id = did.id_tipe', 'left');
		$this->db->join('data_invoice di', 'di.id = dp.id_invoice', 'left');
		$this->db->select('did.*,mt.tipe,dp.no_pengiriman,di.no_invoice,di.no_po,mp.item,mw.warna');
		$this->db->where('did.id', $value);
		return $this->db->get('data_retur_detail did');
	}

	public function getNoPengiriman($value='')
	{
		$this->db->order_by('id', 'desc');
		$this->db->limit(25);
		$this->db->select('id, no_pengiriman');
		return $this->db->get('data_pengiriman')->result();
	}


	public function deleteDetailItem($value='')
	{
		$this->db->where('id', $value);
		$this->db->delete('data_stok_detail');
	}

	public function insertreturDetail($value='')
	{
		$this->db->insert('data_retur_detail', $value);
	}

	public function updatereturDetail($value='',$id)
	{
		$this->db->where('id', $id);
		$this->db->update('data_retur_detail', $value);
	}

	public function getItemInvoice($id='')
	{
		$this->db->where('did.id_surat_jalan', $id);
		$this->db->join('master_item mi', 'mi.id = did.id_item', 'left');
		$this->db->join('master_tipe mt', 'mt.id = did.id_tipe', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->select('did.*,mi.item,mt.tipe,mw.warna');
		return $this->db->get('data_stok_detail did')->result();
	}

	public function getNoInvoice($id='')
	{
		$this->db->join('data_invoice di', 'di.id = dp.id_invoice', 'left');
		$this->db->where('dp.id', $id);
		$this->db->select('dp.id, di.no_invoice');
		return $this->db->get('data_pengiriman dp')->row();
	}

	public function getDetailInvoice($value='')
	{
		$this->db->where('id', $value);
		return $this->db->get('data_stok_detail')->row();
	}

	public function getDetailRetur($id='')
	{
		$this->db->where('drd.id', $id);
		$this->db->join('data_pengiriman dp', 'dp.id = drd.id_surat_jalan', 'left');
		$this->db->join('data_invoice di', 'di.id = dp.id_invoice', 'left');
		$this->db->select('drd.*,di.*');
		return $this->db->get('data_retur_detail drd')->row();
	}

	public function insertStok($value='')
	{
		$this->db->insert('data_stok_detail', $value);
	}

	public function getMaxProduksi($value='')
	{
		$this->db->select_max('id');
		return $this->db->get('data_produksi')->row()->id;
	}
	
	public function updateStatus($value='')
	{
		$object = array('status' => 2, );
		$this->db->where('id', $value);
		$this->db->update('data_retur_detail', $object);
	}

	public function deleteRetur($value='')
	{
		$this->db->where('id', $value);
		$this->db->delete('data_retur_detail');
	}

	public function getHeaderCetak($value='')
	{
		$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->join('master_tipe mt', 'mt.id = did.id_tipe', 'left');

		$this->db->join('master_item mpn', 'mpn.id = did.id_item_baru', 'left');
		$this->db->join('master_warna mwn', 'mwn.id = did.id_warna_baru', 'left');
		$this->db->join('master_tipe mtn', 'mtn.id = did.id_tipe_baru', 'left');

		$this->db->join('data_pengiriman dp', 'dp.id = did.id_surat_jalan', 'left');
		$this->db->join('data_invoice di', 'di.id = dp.id_invoice', 'left');
		$this->db->select('did.*,mt.tipe,dp.no_pengiriman,di.no_invoice,di.no_po,mp.item,mw.warna,mpn.item as item_baru,mwn.warna as warna_baru,mtn.tipe as tipe_baru');
		$this->db->where('did.id', $value);
		return $this->db->get('data_retur_detail did')->row();
	}

	

}
