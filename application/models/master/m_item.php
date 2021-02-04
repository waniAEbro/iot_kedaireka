<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_item extends CI_Model
{

	public function getData($value = '')
	{
		$this->db->join('master_jenis_barang mjb', 'mjb.id = mi.id_jenis_barang', 'left');
		$this->db->order_by('mi.id', 'desc');
		$this->db->select('mi.*,mjb.jenis_barang');
		return $this->db->get('master_item mi');
	}

	public function getMax($value = '')
	{
		return $this->db->get('master_item')->num_rows();
	}

	public function insertData($data, $new = true)
	{
		if ($new) {
			$this->db->insert('master_item', $data);
		} else {
			$this->db->where('id', $data['id']);
			$this->db->update('master_item', $data);
		}
	}

	public function check($str = '')
	{
		$this->db->where('kode', $str);
		return $this->db->get('master_item')->row();
	}

	public function deleteData($id = '')
	{
		$this->db->where('id', $id);
		$this->db->delete('master_item');
	}

	public function getEdititem($id = '')
	{
		$this->db->where('mi.id', $id);
		return $this->db->get('master_item mi');
	}

	public function attnBuyer($value = '')
	{
		$this->db->where('id', $value);
		return $this->db->get('master_buyer')->row()->attn;
	}

	public function getRowitem($id = '')
	{
		$this->db->where('mi.id', $id);
		return $this->db->get('master_item mi');
	}
}

/* End of file m_item.php */
/* Location: ./application/models/master/m_item.php */