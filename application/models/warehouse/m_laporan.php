<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_laporan extends CI_Model {

	public function getItemTerjual($store='',$bulan='',$tahun='')
	{
		$this->db->where('MONTH(dsd.date)', $bulan);
		$this->db->where('YEAR(dsd.date)', $tahun);
		if ($store!='x') {
		$this->db->where('wi.id_store', $store);
		}
		$this->db->join('warehouse_invoice wi', 'wi.id = dsd.id_invoice', 'left');
		$this->db->join('master_item ms', 'ms.id = dsd.id_item', 'left');
		$this->db->select('ms.*');
		return $this->db->get('warehouse_invoice_detail dsd');

	}

	function get_all_produksi($store='',$bulan='',$tahun='')
	{
		$this->db->where('MONTH(dsd.date)', $bulan);
		$this->db->where('YEAR(dsd.date)', $tahun);
		if ($store!='x') {
		$this->db->where('wi.id_store', $store);
		}
		$this->db->join('warehouse_invoice wi', 'wi.id = dsd.id_invoice', 'left');
		$res=$this->db->get('warehouse_invoice_detail dsd');
		$data=array();
		$nilai=0;
		foreach ($res->result() as $key) {
			if(isset($data[$key->id_item])){
				$nilai=$data[$key->id_item];
			}else{
				$nilai=0;
			}
			$data[$key->id_item]=$key->qty+$nilai;
		}
		return $data;
	}

}

/* End of file m_item_produksi.php */
/* Location: ./application/models/laporan/m_item_produksi.php */