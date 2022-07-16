<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_wo extends CI_Model
{
    public function getData($tgl_awal, $tgl_akhir)
    {

        $this->db->join('master_divisi md', 'md.id = dw.id_divisi', 'left');
        $this->db->join('master_item mi', 'mi.id = dw.id_item', 'left');
        
        $this->db->where('DATE(dw.tgl_order) >=', $tgl_awal);
        $this->db->where('DATE(dw.tgl_order) <=', $tgl_akhir);
        $this->db->select('dw.*,md.divisi,mi.item_code');
        $this->db->order_by('dw.id', 'desc');
        
        return $this->db->get('data_wo dw');
    }

    public function getdataItem()
    {
        $id_jenis_item = 1;
        $this->db->where('mi.id_jenis_item', $id_jenis_item);
        $this->db->where('mi.kode_warna', '01');
        $this->db->order_by('mi.item_code', 'asc');
        
        return $this->db->get('master_item mi');
    }

    public function getTotalIn()
    {
        $this->db->where('is_wo', 1);
        $res  = $this->db->get('data_stock');
        
        $data = array();
        foreach ($res->result() as $key) {

            if (!isset($data[$key->id_item][$key->no_wo])) {
                $data[$key->id_item][$key->no_wo] = 0;
            }
            $data[$key->id_item][$key->no_wo] = $data[$key->id_item][$key->no_wo] + $key->qty_in;
        }
        return $data;
    }

    public function getTemp()
	{
		$this->db->where('id_penginput', from_session('id'));
		return $this->db->get('data_wo_temp')->result();
	}



    
}
