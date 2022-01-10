<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('wrh/m_aluminium');
		// $this->load->model('master/m_aluminium');
	}

	public function index()
	{
		$this->status_pak();
	}

	public function status_pak()
	{
		$this->db->where('qty <', 1);
		$this->db->delete('data_counter');

		// $this->db->where('cek_double', 1);
		// $res = $this->db->get('master_item');
		// foreach ($res->result() as $key) {
		// 	$obja = array('cek_double' => 1);
		// 	$this->db->where('id_item', $key->id);
		// 	$this->db->update('data_counter', $obja);
		// }


		// $this->db->where('id_jenis_item', 1);
		// $this->db->where('cek_double', 1);
		// $this->db->delete('master_item');
		// $res = $this->db->get('master_item');
		// foreach ($res->result() as $key) {
		// 	$this->db->where('id_item', $key->id);
		// }


		// $this->db->where('id_jenis_item', 1);
		// $counter = $this->db->get('master_item');
		// foreach ($counter->result() as $key) {
		// 	$object = array('id_item' => $key->id);
		// 	$this->db->where('itm_code', $key->item_code);
		// 	$this->db->update('data_counter', $object);
		// }

		// $year  = date('Y');
		// $this->db->where('DATE_FORMAT(created,"%Y")', $year);
		// $this->db->where('id_jenis_item', 1);
		// $this->db->where('awal_bulan', 1);
		// $this->db->delete('data_stock');



		// $this->db->where('id_jenis_item', 1);
		// $this->db->delete('data_counter');


		// $this->db->where('mi.id_jenis_item', 1);
		// $this->db->where('mi.jum_row >', 1);
		// $this->db->where('mi.dbl', 1);
		// $item = $this->db->get('master_item mi');
		// foreach ($item->result() as $key) {
		// $nr = $this->m_aluminium->rowsJum($key->section_ata, $key->section_allure, $key->temper, $key->kode_warna, $key->ukuran);
		// $this->m_aluminium->updtHapus($key->section_ata, $key->section_allure, $key->temper, $key->kode_warna, $key->ukuran);
		// $cek_counter = $this->m_aluminium->cekCounter($key->id);

		// $object = array(
		// 'jum_row' => $nr,
		// 'id_hapus' => $nr,
		// 'ada_counter' => $cek_counter,
		// );
		// $this->db->where('id', $key->id);
		// $this->db->update('master_item', $object);
		// }


		// $this->db->join('master_divisi_stock mds', 'mds.id = mi.id_divisi', 'left');

		// $this->db->where('mi.id_jenis_item', 1);
		// $this->db->select('mi.*,mds.divisi');

		// $item = $this->db->get('master_item mi');
		// foreach ($item->result() as $key) {
		// 	$item_code = $key->section_ata . '-' . $key->section_allure . '-' . $key->temper . '-' . $key->kode_warna . '-' . $key->ukuran;
		// 	$object = array(
		// 		'item_code' => $item_code,
		// 		'divisi' => $key->divisi,
		// 	);
		// 	$this->db->where('id', $key->id);
		// 	$this->db->update('master_item', $object);
		// }

		//inti
		$cek_stock_awal_bulan = $this->m_aluminium->cekStockAwalBulan()->num_rows();
		$item = $this->m_aluminium->getlistStock();

		if ($cek_stock_awal_bulan < 1) {
			foreach ($item->result() as $key) {
				$obj = array(
					'awal_bulan' => 1,
					'inout' => 1,
					'id_item' => $key->id_item,
					'id_divisi' => $key->id_divisi,
					'id_gudang' => $key->id_gudang,
					'keranjang' => $key->keranjang,
					'id_jenis_item' => $key->id_jenis_item,
					'qty_in' => $key->qty,
					'created' => date('Y-m-d H:i:s')
				);
				$this->db->insert('data_stock', $obj);
			}
		}

		//inti


		// $dc = $this->m_aluminium->getDC();
		// foreach ($dc->result() as $key) {
		// 	$qtyin = $this->m_aluminium->getQtyTotalIn($key->id_jenis_item, $key->id_item, $key->id_divisi, $key->id_gudang, $key->keranjang);
		// 	$qtyout = $this->m_aluminium->getQtyTotalOut($key->id_jenis_item, $key->id_item, $key->id_divisi, $key->id_gudang, $key->keranjang);
		// 	$obj = array(
		// 		'id_jenis_item' => $key->id_jenis_item,
		// 		'id_item' => $key->id_item,
		// 		'id_divisi' => $key->id_divisi,
		// 		'id_gudang' => $key->id_gudang,
		// 		'keranjang' => $key->keranjang,
		// 		'qty' => $qtyin - $qtyout,
		// 	);
		// 	$this->db->insert('data_counter', $obj);
		// }

		// $this->load->library('zend');
		// $this->zend->load('Zend/Barcode');
		// $this->db->where('id_jenis_item', 2);

		// $hasil = $this->db->get('master_item');
		// foreach ($hasil->result() as $key) {
		// 	// $code = '2' . str_pad($key->id, 10, '0', STR_PAD_LEFT);
		// 	$code = $key->item_code;
		// 	$barcode = $code; //nomor id barcode
		// 	$imageResource = Zend_Barcode::factory('code128', 'image', array('text' => $barcode), array())->draw();
		// 	$imageName = $barcode . '.jpg';
		// 	$imagePath = 'files/'; // penyimpanan file barcode
		// 	imagejpeg($imageResource, $imagePath . $imageName);
		// 	$pathBarcode = $imagePath . $imageName; //Menyimpan path image bardcode kedatabase

		// 	$data = array(
		// 		'id' => $key->id,
		// 		'barcode' => $barcode,
		// 		'image_barcode' => $pathBarcode
		// 	);
		// 	$this->m_aluminium->updateData($data);
		// }



		$this->load->view('v_dashboard');
	}

	public function insertbarcode($code, $id)
	{
		$this->load->library('zend');
		$this->zend->load('Zend/Barcode');
		$barcode = $code; //nomor id barcode
		$imageResource = Zend_Barcode::factory('code128', 'image', array('text' => $barcode), array())->draw();
		$imageName = $barcode . '.jpg';
		$imagePath = 'files/'; // penyimpanan file barcode
		imagejpeg($imageResource, $imagePath . $imageName);
		$pathBarcode = $imagePath . $imageName; //Menyimpan path image bardcode kedatabase

		$data = array(
			'id' => $id,
			'barcode' => $barcode,
			'image_barcode' => $pathBarcode
		);
		$this->m_aluminium->updateData($data);
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/pak/dashboard.php */