<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_report extends CI_Model {

	public function getAplikator($value='')
	{
		
		return $this->db->get('master_brand');
	}

	public function getStatusQuotation($value='',$kode='',$dari_tgl='',$sampai_tgl='')
	{
		$level = from_session('level');
		if ($level == '4') {
			$this->db->where('id_brand', $kode);
		}
		if ($kode !='x') {
			$this->db->where('id_brand', $kode);
		}
		if ($dari_tgl !='x') {
			$this->db->where('DATE(date) >=', $dari_tgl);
		}
		if ($sampai_tgl !='x') {
			$this->db->where('DATE(date) <=', $sampai_tgl);
		}
		$this->db->where('id_status', $value);
		$this->db->select('COUNT(id_status) as jumlah');
		return $this->db->get('data_invoice');
	}

}

/* End of file m_report.php */
/* Location: ./application/models/klg/m_report.php */