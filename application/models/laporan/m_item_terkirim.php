<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_item_terkirim extends CI_Model {

	function get_all_terkirim($bulan='',$tahun='')
	{
		$this->db->join('data_stok_detail dsd', 'dsd.id_invoice = di.id', 'left');
		$this->db->where('MONTH(dsd.date)', $bulan);
		$this->db->where('YEAR(dsd.date)', $tahun);
		$this->db->where('di.id_status', 2);
		$res=$this->db->get('data_invoice di');
		$data=array();
		$nilai=0;
		foreach ($res->result() as $key) {
			if(isset($data[$key->id_store])){
				$nilai=$data[$key->id_store];
			}else{
				$nilai=0;
			}
			$data[$key->id_store]=$key->qty_out+$nilai;
		}
		return $data;
	}

}

/* End of file m_item_terkirim.php */
/* Location: ./application/models/laporan/m_item_terkirim.php */