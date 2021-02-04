<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_konsinyasi extends CI_Model {

	public function getData($value='')
	{
		$this->db->join('master_tipe mt', 'mt.id = wdd.id_tipe', 'left');
		$this->db->join('master_warna mw', 'mw.id = wdd.id_warna', 'left');
		$this->db->join('master_item mi', 'mi.id = wdd.id_item', 'left');
		$this->db->join('master_store ms', 'ms.id = wdd.id_store', 'left');
		$this->db->group_by('wdd.id_store,wdd.id_tipe,wdd.id_item,wdd.id_warna,wdd.bukaan,wdd.lebar,wdd.tinggi');
		$this->db->select('wdd.*,sum(wdd.qty) as qty_in,sum(wdd.qty_out) as qty_out, mi.item, mw.warna, mt.tipe, ms.store');
		return $this->db->get('warehouse_data_detail wdd');
	}

	public function getDataFilter($store='')
	{
		if ($store!='x') {
			$this->db->where('wdd.id_store', $store);
		}
		$this->db->join('master_tipe mt', 'mt.id = wdd.id_tipe', 'left');
		$this->db->join('master_warna mw', 'mw.id = wdd.id_warna', 'left');
		$this->db->join('master_item mi', 'mi.id = wdd.id_item', 'left');
		$this->db->join('master_store ms', 'ms.id = wdd.id_store', 'left');
		$this->db->group_by('wdd.id_store,wdd.id_tipe,wdd.id_item,wdd.id_warna,wdd.bukaan,wdd.lebar,wdd.tinggi');
		$this->db->select('wdd.*,sum(wdd.qty) as qty_in,sum(wdd.qty_out) as qty_out, mi.item, mw.warna, mt.tipe, ms.store');
		return $this->db->get('warehouse_data_detail wdd');
	}

	public function getRowTransfer($value='')
	{
		$this->db->join('master_tipe mt', 'mt.id = wdd.id_tipe', 'left');
		$this->db->join('master_warna mw', 'mw.id = wdd.id_warna', 'left');
		$this->db->join('master_item mi', 'mi.id = wdd.id_item', 'left');
		$this->db->join('master_store ms', 'ms.id = wdd.id_store', 'left');
		$this->db->group_by('wdd.id_tipe,wdd.id_item,wdd.id_warna,wdd.bukaan,wdd.lebar,wdd.tinggi');
		$this->db->select('wdd.*,sum(wdd.qty) as qty_in,sum(wdd.qty_out) as qty_out, mi.item, mw.warna, mt.tipe, ms.store');
		$this->db->where('wdd.id', $value);
		return $this->db->get('warehouse_data_detail wdd')->row();
	}

	public function insertTransfer($object='')
	{
		$this->db->insert('warehouse_data_detail', $object);
	}

}

/* End of file m_konsinyasi.php */
/* Location: ./application/models/klg/m_konsinyasi.php */