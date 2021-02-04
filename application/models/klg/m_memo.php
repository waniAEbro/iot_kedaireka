<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_memo extends CI_Model {

	public function getdata($value='')
	{
		$this->db->join('master_store mst', 'mst.id = di.id_store', 'left');
		$this->db->select('di.*,mst.store');
		$this->db->order_by('di.id', 'desc');
		return $this->db->get('data_memo di');
	}



	public function getEdit($value='')
	{
		$this->db->join('master_store mst', 'mst.id = di.id_store', 'left');
		$this->db->select('di.*,mst.store');
		$this->db->where('di.id', $value);
		return $this->db->get('data_memo di');
	}

	public function getmemo($value='')
	{
		$year = date('Y');
		$this->db->where('DATE_FORMAT(date,"%Y")', $year);	
		$hasil = $this->db->get('data_memo');
        if ($hasil->num_rows()>0) {
            return $hasil->num_rows()+1;
        } else {
            return '1';
        }
	}

	public function insertmemo($value='')
	{
		$this->db->insert('data_memo', $value);
	}

	public function updatememo($id='',$value='')
	{
		$this->db->where('id', $id);
		$this->db->update('data_memo', $value);
	}

	public function insertmemoDetail($value='')
	{
		$this->db->insert('data_memo_detail', $value);
	}

	public function deleteDetailItem($value='')
	{
		$this->db->where('id', $value);
		$this->db->delete('data_memo_detail');
	}

	public function getRowDetailStore($value='')
	{
		$this->db->where('id', $value);
		return $this->db->get('master_store')->row();
	}

	public function getRowDetailItem($value='')
	{
		$this->db->where('id', $value);
		return $this->db->get('master_item')->row();
	}

	public function getWarnaItem($id='')
	{
		$this->db->join('master_warna mw', 'mw.id = mi.id_warna', 'left');
		$this->db->select('mw.*');
		$this->db->where('mi.id', $id);
		return $this->db->get('master_item mi')->result();
	}

	public function getDataDetailTabel($value='')
	{
		$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->join('master_tipe mt', 'mt.id = did.id_tipe', 'left');
		$this->db->join('master_alasan ma', 'ma.id = did.id_alasan', 'left');
		$this->db->where('did.id_memo', $value);
		$this->db->select('did.*,mp.item,did.*,mp.gambar,mw.warna,mt.tipe,ma.alasan');
		return $this->db->get('data_memo_detail did')->result();
	}

	public function getDataDetailTabelProduksi($value='')
	{
		$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->join('master_tipe mt', 'mt.id = did.id_tipe', 'left');
		$this->db->join('data_produksi dp', 'dp.id_memo_detail = did.id', 'left');
		$this->db->where('did.id_memo', $value);
		$this->db->group_by('did.id');
		$this->db->select('mp.item,did.lebar,did.tinggi,mp.gambar,mw.warna,mt.tipe,did.id,did.qty,sum(dp.qty) as qtyProduksi');
		return $this->db->get('data_memo_detail did')->result();
	}

	public function getDataDetailItemProduksi($value='')
	{
		$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->join('master_tipe mt', 'mt.id = did.id_tipe', 'left');
		$this->db->join('data_produksi dp', 'dp.id_memo_detail = did.id', 'left');
		$this->db->join('data_memo di', 'di.id = did.id_memo', 'left');
		$this->db->where('did.id', $value);
		$this->db->group_by('did.id');
		$this->db->select('di.no_memo,did.id_memo,mp.item,did.lebar,did.tinggi,mw.warna,mt.tipe,did.id,did.qty,sum(dp.qty) as qtyProduksi');
		return $this->db->get('data_memo_detail did')->row();
	}

	public function saveDetailProduksi($object='')
	{
		$this->db->insert('data_produksi', $object);
	}

	public function getJumDetail($value='')
	{
		$this->db->where('id_memo', $value);
		$hasil = $this->db->get('data_memo_detail');
        if ($hasil->num_rows()>0) {
            return '1';
        } else {
            return '0';
        }
	}

	public function getTotOrder($value='')
	{
		$this->db->where('id_memo', $value);
		$this->db->select('sum(qty) as jml');
		return $this->db->get('data_memo_detail')->row()->jml;
	}

	public function getTotProduksi($value='')
	{
		$this->db->where('id_memo', $value);
		$this->db->select('sum(qty) as jml');
		$hasil = $this->db->get('data_produksi');
        // if ($hasil->num_rows()>0) {
            return $hasil->row()->jml;
        // } else {
        //     return '0';
        // }
	}

	public function getHeaderCetak($value='')
	{
		$this->db->join('master_store mst', 'mst.id = di.id_store', 'left');
		$this->db->select('di.*,mst.store');
		$this->db->where('di.id', $value);
		return $this->db->get('data_memo di')->row();
	}

	public function getRowMemo($value='')
	{
		$this->db->where('id', $value);
		return $this->db->get('data_memo')->row();
	}

	public function getRowMemoDetail($value='')
	{
		$this->db->where('id_memo', $value);
		return $this->db->get('data_memo_detail');
	}

	public function updateStatusMemo($value='')
	{
		$object = array('id_status' => 2, );
		$this->db->where('id', $value);
		$this->db->update('data_memo', $object);
	}

}

/* End of file m_memo.php */
/* Location: ./application/models/klg/m_memo.php */