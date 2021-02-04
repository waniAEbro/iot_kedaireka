<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_warna extends CI_Model {

	public function getData($value='')
	{
		return $this->db->get('master_warna ');
	}

	public function insertData($data='')
	{
		
        $this->db->insert('master_warna',$data);
       
	}

	public function updateData($data='')
	{
		 $this->db->where('id',$data['id']);
            $this->db->update('master_warna',$data);
	}

	public function deleteData($id='')
	{
		$this->db->where('id', $id);
        $this->db->delete('master_warna');
	}

}

/* End of file m_warna.php */
/* Location: ./application/models/master/m_warna.php */