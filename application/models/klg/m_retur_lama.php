<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_retur_lama extends CI_Model {

	public function getData($value='')
	{
		$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->join('master_tipe mt', 'mt.id = did.id_tipe', 'left');

		$this->db->join('master_item mpn', 'mpn.id = did.id_item_baru', 'left');
		$this->db->join('master_warna mwn', 'mwn.id = did.id_warna_baru', 'left');
		$this->db->join('master_tipe mtn', 'mtn.id = did.id_tipe_baru', 'left');

		$this->db->join('master_store ms', 'ms.id = did.id_store', 'left');
		$this->db->select('did.*,mt.tipe,ms.store,mp.item,mw.warna,mpn.item as item_baru,mwn.warna as warna_baru,mtn.tipe as tipe_baru');
		// $this->db->where('did.status', 1);
		$this->db->order_by('did.id', 'desc');
		return $this->db->get('data_retur_lama_detail did');
	}

	public function getNoRetur($value='')
	{
		$year = date('Y');
		$this->db->where('DATE_FORMAT(date,"%Y")', $year);	
		$hasil = $this->db->get('data_retur_detail');
        if ($hasil->num_rows()>0) {
            return $hasil->num_rows()+1;
        } else {
            return '1';
        }
	}

	public function getEditretur_lama($value='')
	{
		$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->join('master_store ms', 'ms.id = did.id_store', 'left');
		$this->db->join('master_tipe mt', 'mt.id = did.id_tipe', 'left');
		$this->db->select('did.*,mt.tipe,ms.store,mp.item,mw.warna');
		$this->db->where('did.id', $value);
		return $this->db->get('data_retur_lama_detail did');
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

	public function insertretur_lamaDetail($value='')
	{
		$this->db->insert('data_retur_lama_detail', $value);
	}

	public function updateretur_lamaDetail($value='',$id)
	{
		$this->db->where('id', $id);
		$this->db->update('data_retur_lama_detail', $value);
	}

	public function getItemInvoice($id='')
	{
		$this->db->where('did.id_store', $id);
		$this->db->join('master_item mi', 'mi.id = did.id_item', 'left');
		$this->db->join('master_tipe mt', 'mt.id = did.id_tipe', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->group_by('did.id_item,did.id_tipe,did.id_warna,did.bukaan');
		$this->db->select('did.*,mi.item,mt.tipe,mw.warna');
		return $this->db->get('warehouse_data_detail did')->result();
	}

	public function getNoInvoice($id='')
	{
		$this->db->join('data_invoice di', 'di.id = ms.id_invoice', 'left');
		$this->db->where('ms.id', $id);
		$this->db->select('ms.id, di.no_invoice');
		return $this->db->get('master_store ms')->row();
	}

	public function getDetailInvoice($value='')
	{
		$this->db->where('id', $value);
		return $this->db->get('warehouse_data_detail')->row();
	}

	public function getDetailretur_lama($id='')
	{
		$this->db->where('drd.id', $id);
		return $this->db->get('data_retur_lama_detail drd')->row();
	}

	public function insertStok($value='')
	{
		$this->db->insert('data_stok_detail', $value);
	}

	public function insertStokWarehouse($value='')
	{
		$this->db->insert('warehouse_data_detail', $value);
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
		$this->db->update('data_retur_lama_detail', $object);
	}

	public function deleteretur_lama($value='')
	{
		$this->db->where('id', $value);
		$this->db->delete('data_retur_lama_detail');
	}

	public function getHeaderCetak($value='')
	{
		$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->join('master_tipe mt', 'mt.id = did.id_tipe', 'left');

		$this->db->join('master_item mpn', 'mpn.id = did.id_item_baru', 'left');
		$this->db->join('master_warna mwn', 'mwn.id = did.id_warna_baru', 'left');
		$this->db->join('master_tipe mtn', 'mtn.id = did.id_tipe_baru', 'left');

		$this->db->join('master_store ms', 'ms.id = did.id_store', 'left');
		$this->db->select('did.*,mt.tipe,ms.store,mp.item,mw.warna,mpn.item as item_baru,mwn.warna as warna_baru,mtn.tipe as tipe_baru');
		$this->db->where('did.id', $value);
		// $this->db->order_by('did.id', 'desc');
		return $this->db->get('data_retur_lama_detail did');
	}

	

}
