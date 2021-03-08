<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_ncr extends CI_Model
{

	public function getdata($value = '')
	{
		$this->db->join('master_store mst', 'mst.id = di.id_store', 'left');
		$this->db->join('master_jenis_ketidaksesuaian mjk', 'mjk.id = di.id_jenis_ketidaksesuaian', 'left');
		$this->db->select('di.*,mst.store,mjk.jenis_ketidaksesuaian');
		$this->db->order_by('di.id', 'desc');
		return $this->db->get('data_ncr di');
	}



	public function getEdit($value = '')
	{
		$this->db->where('di.id', $value);
		return $this->db->get('data_ncr di');
	}

	public function getncr($value = '')
	{
		$year = date('Y');
		$this->db->where('DATE_FORMAT(date,"%Y")', $year);
		$hasil = $this->db->get('data_ncr');
		if ($hasil->num_rows() > 0) {
			return $hasil->num_rows() + 1;
		} else {
			return '1';
		}
	}

	public function insertncr($value = '')
	{
		$this->db->insert('data_ncr', $value);
	}

	public function updatencr($id = '', $value = '')
	{
		$this->db->where('id', $id);
		$this->db->update('data_ncr', $value);
	}

	public function insertncrDetail($value = '')
	{
		$this->db->insert('data_ncr_detail', $value);
	}

	public function deleteDetailItem($value = '')
	{
		$this->db->where('id', $value);
		$this->db->delete('data_ncr_detail');
	}

	public function getRowDetailStore($value = '')
	{
		$this->db->where('id', $value);
		return $this->db->get('master_store')->row();
	}

	public function getRowDetailItem($value = '')
	{
		$this->db->where('id', $value);
		return $this->db->get('master_item')->row();
	}

	public function getWarnaItem($id = '')
	{
		$this->db->join('master_warna mw', 'mw.id = mi.id_warna', 'left');
		$this->db->select('mw.*');
		$this->db->where('mi.id', $id);
		return $this->db->get('master_item mi')->result();
	}

	public function getDataDetailTabel($value = '')
	{
		$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->join('master_tipe mt', 'mt.id = did.id_tipe', 'left');
		$this->db->where('did.id_ncr', $value);
		$this->db->select('mp.item,did.*,mp.gambar,mw.warna,mt.tipe');
		return $this->db->get('data_ncr_detail did')->result();
	}

	public function getDataDetailTabelProduksi($value = '')
	{
		$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->join('master_tipe mt', 'mt.id = did.id_tipe', 'left');
		$this->db->join('data_produksi dp', 'dp.id_ncr_detail = did.id', 'left');
		$this->db->where('did.id_ncr', $value);
		$this->db->group_by('did.id');
		$this->db->select('mp.item,did.lebar,did.tinggi,mp.gambar,mw.warna,mt.tipe,did.id,did.qty,sum(dp.qty) as qtyProduksi');
		return $this->db->get('data_ncr_detail did')->result();
	}

	public function getDataDetailItemProduksi($value = '')
	{
		$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->join('master_tipe mt', 'mt.id = did.id_tipe', 'left');
		$this->db->join('data_produksi dp', 'dp.id_ncr_detail = did.id', 'left');
		$this->db->join('data_ncr di', 'di.id = did.id_ncr', 'left');
		$this->db->where('did.id', $value);
		$this->db->group_by('did.id');
		$this->db->select('di.no_ncr,did.id_ncr,mp.item,did.lebar,did.tinggi,mw.warna,mt.tipe,did.id,did.qty,sum(dp.qty) as qtyProduksi');
		return $this->db->get('data_ncr_detail did')->row();
	}

	public function saveDetailProduksi($object = '')
	{
		$this->db->insert('data_produksi', $object);
	}

	public function getJumDetail($value = '')
	{
		$this->db->where('id_ncr', $value);
		$hasil = $this->db->get('data_ncr_detail');
		if ($hasil->num_rows() > 0) {
			return '1';
		} else {
			return '0';
		}
	}

	public function getTotOrder($value = '')
	{
		$this->db->where('id_ncr', $value);
		$this->db->select('sum(qty) as jml');
		return $this->db->get('data_ncr_detail')->row()->jml;
	}

	public function getTotProduksi($value = '')
	{
		$this->db->where('id_ncr', $value);
		$this->db->select('sum(qty) as jml');
		$hasil = $this->db->get('data_produksi');
		// if ($hasil->num_rows()>0) {
		return $hasil->row()->jml;
		// } else {
		//     return '0';
		// }
	}

	public function getHeaderCetak($value = '')
	{
		$this->db->join('master_store mst', 'mst.id = di.id_store', 'left');
		$this->db->join('master_jenis_ketidaksesuaian mjk', 'mjk.id = di.id_jenis_ketidaksesuaian', 'left');
		$this->db->select('di.*,mst.store,mjk.jenis_ketidaksesuaian');
		$this->db->where('di.id', $value);
		return $this->db->get('data_ncr di')->row();
	}

	public function deleteNCR($id = '')
	{
		$this->db->where('id', $id);
		$this->db->delete('data_ncr');
	}
}

/* End of file m_ncr.php */
/* Location: ./application/models/klg/m_ncr.php */