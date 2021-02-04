<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_item_produksi extends CI_Model {

	function get_all_produksi($bulan='',$tahun='')
	{
		$this->db->where('MONTH(dsd.date)', $bulan);
		$this->db->where('YEAR(dsd.date)', $tahun);
		$this->db->where('dsd.inout', 1);
		$this->db->where('dsd.id_tipe', 1);
		$res=$this->db->get('data_stok_detail dsd');
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