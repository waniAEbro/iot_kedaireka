<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_brand extends CI_Model
{

	public function getData($value = '')
	{
		return $this->db->get('master_brand ');
	}

	public function insertData($data = '')
	{

		$this->db->insert('master_brand', $data);
	}

	public function updateData($data = '')
	{
		$this->db->where('id', $data['id']);
		$this->db->update('master_brand', $data);
	}

	public function deleteData($id = '')
	{
		$this->db->where('id', $id);
		$this->db->delete('master_brand');
	}
}

/* End of file m_brand.php */
/* Location: ./application/models/master/m_brand.php */