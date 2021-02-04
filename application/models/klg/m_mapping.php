<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_mapping extends CI_Model {

	public function getData($value='')
	{
		$this->db->join('master_item mp', 'mp.id = dra.id_item', 'left');
		$this->db->join('master_warna mta', 'mta.id = dra.id_warna', 'left');
		$this->db->select('dra.*,mp.item,mta.warna');
		$this->db->order_by('dra.id', 'desc');
		return $this->db->get('data_mapping dra');
	}

	public function insertData($data,$new=true)
	{
		if($new)
        {
            $this->db->insert('data_mapping',$data);
        }
        else
        {
            $this->db->where('id',$data['id']);
            $this->db->update('data_mapping',$data);
        }
	}

	public function deleteData($id='')
	{
		$this->db->where('id', $id);
        $this->db->delete('data_mapping');
	}

	public function check($str = '') {
		$this->db->where('mapping', $str);
		return $this->db->get('data_mapping')->row();
	}

}

/* End of file m_mapping.php */
/* Location: ./application/models/master/m_mapping.php */