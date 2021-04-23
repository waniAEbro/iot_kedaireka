<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_fppp extends CI_Model
{

	public function getData($param)
	{
		$this->db->join('master_divisi md', 'md.id = df.id_divisi', 'left');
		$this->db->join('master_kaca mk', 'mk.id = df.id_kaca', 'left');
		$this->db->join('master_pengiriman mp', 'mp.id = df.id_pengiriman', 'left');
		$this->db->join('master_metode_pengiriman mpp', 'mpp.id = df.id_metode_pengiriman', 'left');
		$this->db->join('master_warna_aluminium mwa', 'mwa.id = df.id_warna_aluminium', 'left');
		$this->db->where('df.id_divisi', $param);
		$this->db->order_by('df.id', 'desc');

		$this->db->select('df.*,md.divisi,mk.kaca,mp.pengiriman,metode_pengiriman,mwa.warna_aluminium');

		return $this->db->get('data_fppp df');
	}

	public function insertfppp($value = '')
	{
		$this->db->insert('data_fppp', $value);
	}

	public function insertfpppDetail($value = '')
	{
		$this->db->insert('data_fppp_detail', $value);
	}

	public function getDataDetailTabel($value = '')
	{
		$this->db->join('master_brand mb', 'mb.id = did.id_brand', 'left');
		$this->db->join('master_barang mi', 'mi.id = did.id_item', 'left');
		$this->db->select('did.*,mb.brand,mi.barang as item');

		$this->db->where('did.id_fppp', $value);
		return $this->db->get('data_fppp_detail did')->result();
	}
	public function getNoFppp($value = '')
	{
		$year  = date('Y');
		$month = date('m');
		$this->db->where('DATE_FORMAT(created,"%Y")', $year);
		$this->db->where('DATE_FORMAT(created,"%m")', $month);
		$this->db->order_by('id', 'desc');
		$this->db->limit(1);
		$hasil = $this->db->get('data_fppp');
		if ($hasil->num_rows() > 0) {

			$string = $hasil->row()->no_fppp;
			$arr    = explode("/", $string, 2);
			$first  = $arr[0];
			$no     = $first + 1;
			return $no;
		} else {
			return '1';
		}
	}

	public function updateDetail($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('data_fppp_detail', $data);
	}

	public function bom_aluminium($id_fppp)
	{
		$this->db->join('data_fppp df', 'df.id = db.id_fppp', 'left');
		$this->db->where('db.id_fppp', $id_fppp);
		$this->db->select('db.*,df.nama_proyek');

		return $this->db->get('data_fppp_bom_aluminium db');
	}

	public function bom_aksesoris($id_fppp)
	{
		$this->db->join('data_fppp df', 'df.id = db.id_fppp', 'left');
		$this->db->where('db.id_fppp', $id_fppp);
		$this->db->select('db.*,df.nama_proyek');

		return $this->db->get('data_fppp_bom_aksesoris db');
	}

	public function bom_lembaran($id_fppp)
	{
		$this->db->join('data_fppp df', 'df.id = db.id_fppp', 'left');
		$this->db->where('db.id_fppp', $id_fppp);
		$this->db->select('db.*,df.nama_proyek');

		return $this->db->get('data_fppp_bom_lembaran db');
	}

	public function cekMasterAluminium($section_ata = '', $section_allure = '')
	{
		$this->db->where('section_ata', $section_ata);
		$this->db->where('section_allure', $section_allure);
		return $this->db->get('master_item')->num_rows();
	}

	public function cekBomAksesoris($id_fppp = '', $item_code = '')
	{
		$this->db->where('id_fppp', $id_fppp);
		$this->db->where('item_code', $item_code);
		return $this->db->get('data_fppp_bom_aksesoris')->num_rows();
	}

	public function cekMasterAksesoris($item_code = '')
	{
		$this->db->where('item_code', $item_code);
		return $this->db->get('master_item')->num_rows();
	}

	public function cekMasterLembaran($nama_barang = '')
	{
		$this->db->where('nama_barang', $nama_barang);
		return $this->db->get('master_item')->num_rows();
	}

	public function simpanItem($object)
	{
		$this->db->insert('master_item', $object);
	}
}

/* End of file m_fppp.php */
/* Location: ./application/models/klg/m_fppp.php */