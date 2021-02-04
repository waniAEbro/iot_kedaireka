<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_stok extends CI_Model {

	public function getData()
	{
		$this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
		$this->db->join('master_produk_dari mpd', 'mpd.id = ds.id_produk_dari', 'left');
		$this->db->join('master_warna mw', 'mw.id = ds.id_warna', 'left');
		$this->db->join('master_lokasi ml', 'ml.id = ds.id_lokasi', 'left');
		$this->db->order_by('ds.id', 'desc');
		$this->db->select('ds.*,mi.item,mpd.produk_dari,mw.warna,ml.lokasi');
		return $this->db->get('data_stok ds');
	}

	public function insertData($data,$new=true)
	{
		if($new)
        {
            $this->db->insert('data_stok',$data);
        }
        else
        {
            $this->db->where('id',$data['id']);
            $this->db->update('data_stok',$data);
        }
	}

}

/* End of file m_stok.php */
/* Location: ./application/models/klg/m_stok.php */