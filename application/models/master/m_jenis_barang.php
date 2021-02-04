<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_jenis_barang extends CI_Model {

	public function getData($value='')
	{
		return $this->db->get('master_jenis_barang ');
	}

	public function insertData($data='')
	{
		
        $this->db->insert('master_jenis_barang',$data);
       
	}

	public function updateData($data='')
	{
		 $this->db->where('id',$data['id']);
            $this->db->update('master_jenis_barang',$data);
	}

	public function deleteData($id='')
	{
		$this->db->where('id', $id);
        $this->db->delete('master_jenis_barang');
	}

}

/* End of file m_jenis_barang.php */
/* Location: ./application/models/master/m_jenis_barang.php */