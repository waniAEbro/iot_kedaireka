<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_store extends CI_Model
{

	public function getData($value = '')
	{
		$this->db->join('master_kategori_lokasi mkl', 'mkl.id = ms.id_kategori_lokasi', 'left');
		$this->db->join('master_jenis_market mjm', 'mjm.id = ms.id_jenis_market', 'left');
		$this->db->select('ms.*, mkl.kategori_lokasi, mjm.jenis_market');
		$this->db->order_by('ms.id', 'desc');
		return $this->db->get('master_store ms');
	}

	public function insertData($data = '')
	{

		$this->db->insert('master_store', $data);
	}

	public function updateData($data = '')
	{
		$this->db->where('id', $data['id']);
		$this->db->update('master_store', $data);
	}

	public function deleteData($id = '')
	{
		$this->db->where('id', $id);
		$this->db->delete('master_store');
	}
}

/* End of file m_store.php */
/* Location: ./application/models/master/m_store.php */