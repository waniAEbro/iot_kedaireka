<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_dashboard extends CI_Model {

	public function getData($value='')
	{
		$this->db->select('dp.id,dp.nip,dp.pangkat_awal, dp.status,mk1.pangkat as pangkat1,mk1.jabatan as jabatan1, mk2.pangkat as pangkat2,mk2.jabatan as jabatan2');
		$this->db->join('master_kum mk1', 'mk1.id = dp.pangkat_awal', 'left');
		$this->db->join('master_kum mk2', 'mk2.id = dp.pangkat_tujuan', 'left');
		return $this->db->get('data_pengajuan dp');
	}

	public function getIdPangkat($id_pangkat_tujuan='')
	{
		$this->db->where('id', $id_pangkat_tujuan);
		return $this->db->get('master_kum')->row()->id_pangkat;
	}

	public function getKumA($nip='',$id_pangkat='',$id_unsur='',$param='')
	{
		if ($param == '1') {
			$this->db->select('sum(dpp.nilai) as nilai');
		} else {
			$this->db->select('sum(dpp.nilai_fix) as nilai');
		}
		
		$this->db->join('master_komponen_detail mkd', 'mkd.id = dpp.id_kode', 'left');
		$this->db->where('dpp.id_dosen', $nip);
		$this->db->where('dpp.id_pangkat', $id_pangkat);
		$this->db->where('mkd.id_komponen', $id_unsur);
		$this->db->from('data_penilaian_pak dpp');
		$val = $this->db->get();
		if ($val->row()->nilai == '') {
			return '0';
		} else {
			return $val->row()->nilai;
		}
	}

}

/* End of file m_dashboard.php */
/* Location: ./application/models/pak/m_dashboard.php */