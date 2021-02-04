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
		$this->db->join('master_jenis_retur mjr', 'mjr.id = did.id_jenis_retur', 'left');
		$this->db->select('did.*,mjr.jenis_retur,mt.tipe,dp.no_pengiriman,di.no_invoice,di.no_po,mp.item,mw.warna,mpn.item as item_baru,mwn.warna as warna_baru,mtn.tipe as tipe_baru');
		$this->db->order_by('did.id', 'desc');
		return $this->db->get('data_retur_detail did');
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

	public function getItemStore($id='')
	{
		$this->db->where('did.id_store', $id);
		$this->db->join('master_item mi', 'mi.id = did.id_item', 'left');
		$this->db->join('master_tipe mt', 'mt.id = did.id_tipe', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->group_by('did.id_item,did.id_tipe,did.id_warna,did.bukaan');
		$this->db->select('did.*,mi.item,mt.tipe,mw.warna');
		return $this->db->get('warehouse_data_detail did')->result();
	}

	public function getDetailInvoice($value='')
	{
		$this->db->where('id', $value);
		return $this->db->get('warehouse_data_detail')->row();
	}

	public function insertreturDetail($value='')
	{
		$this->db->insert('data_retur_detail', $value);
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

		$this->db->join('data_invoice di', 'di.id = did.id_invoice', 'left');
		$this->db->select('did.*,mt.tipe,di.no_invoice,di.no_po,mp.item,mw.warna,mpn.item as item_baru,mwn.warna as warna_baru,mtn.tipe as tipe_baru');
		$this->db->where('did.id', $value);
		return $this->db->get('data_retur_detail did')->row();
	}

	public function insertStok($value='')
	{
		$this->db->insert('data_stok_detail', $value);
	}

	public function getDetailretur($id='')
	{
		$this->db->where('drd.id', $id);
		$this->db->join('data_invoice di', 'di.id = drd.id_invoice', 'left');
		$this->db->select('drd.*,di.*');
		return $this->db->get('data_retur_detail drd')->row();
	}

	public function getMaxProduksi($value='')
	{
		$this->db->select_max('id');
		return $this->db->get('data_produksi')->row()->id;
	}

	public function insertStokWarehouse($value='')
	{
		$this->db->insert('warehouse_data_detail', $value);
	}

	public function updateStatus($value='')
	{
		$object = array('status' => 2, );
		$this->db->where('id', $value);
		$this->db->update('data_retur_detail', $object);
	}

	public function getEditretur($value='')
	{
		$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->join('master_tipe mt', 'mt.id = did.id_tipe', 'left');

		$this->db->join('master_item mpn', 'mpn.id = did.id_item_baru', 'left');
		$this->db->join('master_warna mwn', 'mwn.id = did.id_warna_baru', 'left');
		$this->db->join('master_tipe mtn', 'mtn.id = did.id_tipe_baru', 'left');

		$this->db->join('data_pengiriman dp', 'dp.id = did.id_surat_jalan', 'left');
		$this->db->join('data_invoice di', 'di.id = dp.id_invoice', 'left');
		$this->db->join('master_jenis_retur mjr', 'mjr.id = did.id_jenis_retur', 'left');
		$this->db->select('did.*,mjr.jenis_retur,mt.tipe,dp.no_pengiriman,di.no_invoice,di.no_po,mp.item,mw.warna,mpn.item as item_baru,mwn.warna as warna_baru,mtn.tipe as tipe_baru');
		$this->db->where('did.id', $value);
		return $this->db->get('data_retur_detail did');
	}



	

}
