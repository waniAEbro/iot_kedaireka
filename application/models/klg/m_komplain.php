<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_komplain extends CI_Model {

	public function getData($value='')
	{
		return $this->db->get('data_komplain ');
	}

	public function insertData($data='')
	{
		
        $this->db->insert('data_komplain',$data);
       
	}

	public function updateData($data='')
	{
		 $this->db->where('id',$data['id']);
            $this->db->update('data_komplain',$data);
	}

	public function deleteData($id='')
	{
		$this->db->where('id', $id);
        $this->db->delete('data_komplain');
	}

}

/* End of file m_komplain.php */
/* Location: ./application/models/master/m_komplain.php */