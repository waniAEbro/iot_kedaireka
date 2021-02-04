<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_manajer extends CI_Model {

	public function getData($value='')
	{
		$this->db->join('master_level ml', 'ml.id = cu.level', 'left');
		$this->db->where_in('cu.level', ['2','3']);
		$this->db->select('cu.*,ml.level as nama_level');
		return $this->db->get('cms_user cu');
	}

	public function update($value='',$id='')
	{
		$this->db->where('id', $id);
		$this->db->update('cms_user', $value);
	}

}

/* End of file m_manajer.php */
/* Location: ./application/models/master/m_manajer.php */