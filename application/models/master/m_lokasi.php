<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_lokasi extends CI_Model {

	public function getData($value='')
	{
		return $this->db->get('master_lokasi ');
	}

	public function insertData($data='')
	{
		
        $this->db->insert('master_lokasi',$data);
       
	}

	public function updateData($data='')
	{
		 $this->db->where('id',$data['id']);
            $this->db->update('master_lokasi',$data);
	}

	public function deleteData($id='')
	{
		$this->db->where('id', $id);
        $this->db->delete('master_lokasi');
	}

}

/* End of file m_lokasi.php */
/* Location: ./application/models/master/m_lokasi.php */