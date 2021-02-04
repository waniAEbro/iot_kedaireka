<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_produksi extends CI_Model
{

	public function getData($value = '')
	{
		$this->db->order_by('dp.id', 'desc');
		$this->db->join('data_stok_detail dpd', 'dpd.id_produksi = dp.id', 'left');
		$this->db->where('dpd.inout', 1);
		$this->db->where('dpd.id_tipe', 1);
		$this->db->where('dpd.is_retur', 0);
		$this->db->group_by('dpd.id_produksi');
		$this->db->select('dp.*,sum(dpd.qty) as total');
		return $this->db->get('data_produksi dp');
	}

	public function getNomor($value = '')
	{
		$year = date('Y');
		$month = date('m');
		$this->db->where('DATE_FORMAT(date,"%Y")', $year);
		$this->db->where('DATE_FORMAT(date,"%m")', $month);
		$hasil = $this->db->get('data_produksi');
		if ($hasil->num_rows() > 0) {
			return $hasil->num_rows() + 1;
		} else {
			return '1';
		}
	}

	public function getNomorItem($item = '', $warna = '', $bukaan = '')
	{
		$year = date('Y');
		$month = date('m');
		$this->db->where('DATE_FORMAT(date,"%Y")', $year);
		$this->db->where('DATE_FORMAT(date,"%m")', $month);
		$this->db->where('id_item', $item);
		$this->db->where('id_warna', $warna);
		$this->db->where('bukaan', $bukaan);
		$hasil = $this->db->get('data_stok_detail');
		if ($hasil->num_rows() > 0) {
			return $hasil->num_rows() + 1;
		} else {
			return '1';
		}
	}

	public function getJumDetail($value = '')
	{
		$this->db->where('id_produksi', $value);
		$this->db->where('inout', 1);
		$this->db->where('id_tipe', 1);
		$hasil = $this->db->get('data_stok_detail');
		if ($hasil->num_rows() > 0) {
			return '1';
		} else {
			return '0';
		}
	}

	public function cektgl($value = '')
	{
		$this->db->where('tgl', $value);
		$hasil = $this->db->get('data_produksi');
		if ($hasil->num_rows() > 0) {
			return $hasil->row()->id;
		} else {
			return '0';
		}
	}

	public function insertProduksi($value = '')
	{
		$this->db->insert('data_produksi', $value);
	}

	public function deleteDetailItem($value = '')
	{
		$this->db->where('id', $value);
		$this->db->delete('data_stok_detail');
	}

	public function getDataDetailTabel($value = '')
	{
		$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->where('did.id_produksi', $value);
		$this->db->where('did.inout', 1);
		$this->db->where('did.id_tipe', 1);
		$this->db->where('did.is_retur', 0);
		$this->db->group_by('did.id_item,did.id_warna,did.bukaan');
		$this->db->select('did.*,mp.item,mp.gambar,mw.warna,sum(did.qty) as jml');
		return $this->db->get('data_stok_detail did')->result();
	}

	public function insertProduksiDetail($value = '')
	{
		$this->db->insert('data_stok_detail', $value);
	}

	public function getDetail($id = '')
	{
		$this->db->where('id', $id);
		$hasil  = $this->db->get('data_stok_detail')->row();
		$id_produksi   = $hasil->id_produksi;
		$item   = $hasil->id_item;
		$warna  = $hasil->id_warna;
		$bukaan = $hasil->bukaan;


		$this->db->join('master_item mp', 'mp.id = did.id_item', 'left');
		$this->db->join('master_warna mw', 'mw.id = did.id_warna', 'left');
		$this->db->join('data_produksi dp', 'dp.id = did.id_produksi', 'left');
		$this->db->where('did.id_produksi', $id_produksi);
		$this->db->where('did.id_item', $item);
		$this->db->where('did.id_warna', $warna);
		$this->db->where('did.bukaan', $bukaan);
		$this->db->where('did.id_tipe', 1);
		$this->db->where('did.inout', 1);
		$this->db->where('did.is_retur', 0);
		$this->db->select('did.*,mp.item,mp.gambar,mw.warna,dp.tgl as tgl_produksi');
		$this->db->order_by('did.id', 'desc');
		return $this->db->get('data_stok_detail did');
	}

	public function getTotProduksi($id = '')
	{
		$this->db->where('id', $id);
		$hasil  = $this->db->get('data_stok_detail')->row();
		$id_produksi   = $hasil->id_produksi;
		$item   = $hasil->id_item;
		$warna  = $hasil->id_warna;
		$bukaan = $hasil->bukaan;

		$this->db->where('did.id_produksi', $id_produksi);
		$this->db->where('did.id_item', $item);
		$this->db->where('did.id_warna', $warna);
		$this->db->where('did.bukaan', $bukaan);
		$this->db->where('did.id_tipe', 1);
		$this->db->where('did.inout', 1);
		$this->db->where('did.is_retur', 0);
		$this->db->select('sum(did.qty) as total');
		return $this->db->get('data_stok_detail did')->row()->total;
	}

	public function deleteProduksi($value = '')
	{
		$this->db->where('id', $value);
		$this->db->delete('data_stok_detail');
	}

	public function getrowitem($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('master_item');
	}
}

/* End of file m_produksi.php */
/* Location: ./application/models/klg/m_produksi.php */