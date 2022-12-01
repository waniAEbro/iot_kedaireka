<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('wrh/m_aluminium');
		$this->load->model('wrh/m_aksesoris');
		// $this->load->model('master/m_aluminium');
	}

	public function index()
	{
		$this->status_pak();
	}

	public function domagic()
	{
		$this->db->where('id_jenis_item', 1);
		$variable = $this->db->get('master_item');

		foreach ($variable->result() as $key) {
			$object = array(
				'item_code' => $key->section_ata . '-' . $key->section_allure . '-' . $key->temper . '-' . str_pad($key->kode_warna, 2, '0', STR_PAD_LEFT) . '-' . $key->ukuran,
			);
			$this->db->where('id', $key->id);
			$this->db->update('master_item', $object);
		}

		echo "berhasil";
	}

	public function status_pak()
	{
		// $this->db->where('id_jenis_item', 1);
		// $this->db->where('id >', 315297);
		// $hehe = $this->db->get('data_stock')->result();
		// foreach ($hehe as $key) {
		// 	$cekDataCounter = $this->m_aluminium->getDataCounter($key->id_item,  $key->id_gudang, $key->keranjang)->num_rows();
		// 	if ($cekDataCounter == 0) {
		// 		$simpan = array(
		// 			'id_jenis_item' => 1,
		// 			'id_item'       => $key->id_item,
		// 			'id_gudang'     => $key->id_gudang,
		// 			'keranjang'     => $key->keranjang,
		// 			'qty'           => $key->qty_in,
		// 			'created'       => date('Y-m-d H:i:s'),
		// 			'itm_code'      => $this->m_aksesoris->getRowItem($key->id_item)->item_code,
		// 		);
		// 		$this->db->insert('data_counter', $simpan);
		// 	} else {
		// 		if ($key->inout == 1) {
		// 			$cekQtyCounter = $this->m_aluminium->getDataCounter($key->id_item,  $key->id_gudang, $key->keranjang)->row()->qty;
		// 			$qty_jadi      = (int)$key->qty_in + (int)$cekQtyCounter;
		// 			$this->m_aluminium->updateDataCounter($key->id_item,  $key->id_gudang, $key->keranjang, $qty_jadi);
		// 		} else {
		// 			$cekQtyCounter = $this->m_aluminium->getDataCounter($key->id_item,  $key->id_gudang, $key->keranjang)->row()->qty;
		// 			$qty_jadi      = (int)$cekQtyCounter - (int)$key->qty_out;
		// 			$this->m_aluminium->updateDataCounter($key->id_item,  $key->id_gudang, $key->keranjang, $qty_jadi);
		// 		}
		// 	}

		// }



		// $this->db->where('id_jenis_item', 1);
		// $master = $this->db->get('master_item');
		// foreach ($master->result() as $key) {
		// 	$item_code = $key->section_ata . '-' . $key->section_allure . '-' . $key->temper . '-' . $key->kode_warna . '-' . $key->ukuran;
		// 	$object = array('item_code'=>$item_code);
		// 	$this->db->where('id', $key->id);

		// 	$this->db->update('master_item', $object);

		// }



		// echo "delete counter";
		// $this->db->where('id_jenis_item', '1');
		// $this->db->where('kode_warna !=', '01');
		// $xx = $this->db->get('master_item');
		// foreach ($xx->result() as $key) {
		// 	$this->db->where('id_item', $key->id);
		// 	$this->db->delete('data_counter');
		// }


		// $this->db->where('id_jenis_item', 1);
		// $this->db->where('id >', 15000);

		// $a = $this->db->get('master_item');
		// foreach ($a->result() as $key) {
		// 	// $this->db->where('id', $key->id);
		// 	// $object = array('item_code'=>$key->section_ata.'-'.$key->section_allure.'-'.$key->temper.'-'.$key->kode_warna.'-'.$key->ukuran);
		// 	$this->db->where('item_code', $key->item_code);
		// 	$cek_double = $this->db->get('master_item')->num_rows();

		// 	$this->db->where('id', $key->id);
		// 	$object = array('cek_double' => $cek_double);
		// 	$this->db->update('master_item', $object);
		// }



		// $year  = date('Y');
		// $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
		// $this->db->where('mi.id_jenis_item', 1);

		// $this->db->where('DATE_FORMAT(ds.created,"%Y")', $year);
		// $this->db->where('ds.mutasi', 1);
		// $this->db->where('ds.awal_bulan', 0);
		// $this->db->where('ds.inout', 2);
		// $hsl = $this->db->get('data_stock_20-2-2022 ds');
		// foreach ($hsl->result() as $key) {
		// $cekDataCounter = $this->m_aluminium->getDataCounter($key->id_item,  $key->id_gudang, $key->keranjang)->num_rows();
		// if ($cekDataCounter == 0) {
		// 	$simpan = array(
		// 		'id_jenis_item' => 1,
		// 		'id_item'       => $key->id_item,
		// 		'id_gudang'     => $key->id_gudang,
		// 		'keranjang'     => $key->keranjang,
		// 		'qty'           => $key->qty_in,
		// 		'created'       => date('Y-m-d H:i:s'),
		// 		'itm_code'           => $this->m_aksesoris->getRowItem($key->id_item)->item_code,
		// 	);
		// 	$this->db->insert('data_counter', $simpan);
		// } else {
		// 	$cekQtyCounter = $this->m_aluminium->getDataCounter($key->id_item,  $key->id_gudang, $key->keranjang)->row()->qty;
		// 	$qty_jadi      = (int)$key->qty_in + (int)$cekQtyCounter;
		// 	$this->m_aluminium->updateDataCounter($key->id_item,  $key->id_gudang, $key->keranjang, $qty_jadi);
		// }

		// $cekQtyCounter = $this->m_aluminium->getDataCounter($key->id_item,  $key->id_gudang, $key->keranjang)->row()->qty;
		// $qty_jadi      = (int)$cekQtyCounter - (int)$key->qty_out;
		// $this->m_aluminium->updateDataCounter($key->id_item,  $key->id_gudang, $key->keranjang, $qty_jadi);
		// }


		// $this->db->where('cek_double', 1);
		// $res = $this->db->get('master_item');
		// foreach ($res->result() as $key) {
		// 	$obja = array('cek_double' => 1);
		// 	$this->db->where('id_item', $key->id);
		// 	$this->db->update('data_counter', $obja);
		// }


		// $this->db->where('susulan', 1);
		// $awal_susulan = $this->db->get('data_counter');


		// foreach ($awal_susulan->result() as $key) {
		// 	$obj = array(
		// 		'awal_bulan' => 1,
		// 		'inout' => 1,
		// 		'id_item' => $key->id_item,
		// 		'id_divisi' => $key->id_divisi,
		// 		'id_gudang' => $key->id_gudang,
		// 		'keranjang' => $key->keranjang,
		// 		'id_jenis_item' => $key->id_jenis_item,
		// 		'qty_in' => $key->qty,
		// 		'created' => date('Y-m-d H:i:s')
		// 	);
		// 	$this->db->insert('data_stock', $obj);
		// }

		// $this->db->where('cek_double', 2);
		// $al = $this->db->get('master_item');
		// foreach ($al->result() as $key) {
		// 	$this->db->where('id_item', $key->id);
		// 	$tt = $this->db->get('data_stock')->num_rows();
		// 	$obb = array('jum_stock' => $tt);
		// 	$this->db->where('id', $key->id);
		// 	$this->db->update('master_item', $obb);
		// }


		// $this->db->where('id_jenis_item', 1);
		// $this->db->where('cek_double', 1);
		// $this->db->delete('master_item');
		// $res = $this->db->get('master_item');
		// foreach ($res->result() as $key) {
		// 	$this->db->where('id_item', $key->id);
		// }

		// $dsj = $this->db->get('data_surat_jalan');
		// foreach ($dsj->result() as $key) {
		// 	$obb = array('aktual' => $key->tgl_aktual);
		// 	$this->db->where('id_surat_jalan', $key->id);
		// 	$this->db->update('data_stock', $obb);
		// }


		//aluminium update id item
		// $this->db->where('id_jenis_item', 1);
		// $counter = $this->db->get('master_item');
		// foreach ($counter->result() as $key) {
		// 	$object = array('id_item' => $key->id);
		// 	$this->db->where('id_jenis_item', 1);
		// 	$this->db->where('itm_code', $key->item_code);
		// 	$this->db->update('data_counter', $object);
		// }



		// $this->db->where('id_jenis_item', 1);
		// $this->db->where('id_item', 0);
		// $counter = $this->db->get('data_counter');
		// foreach ($counter->result() as $key) {
		// 	$this->db->where('item_code', $key->itm_code);
		// 	$id = $this->db->get('master_item')->row()->id;

		// 	$object = array('id_item' => $id);
		// 	$this->db->where('id_jenis_item', 1);
		// 	$this->db->where('itm_code', $key->item_code);
		// 	$this->db->update('data_counter', $object);
		// }

		// $this->db->where('id_jenis_item', 2);
		// $counter = $this->db->get('master_item');
		// foreach ($counter->result() as $key) {
		// 	$object = array('itm_code' => $key->item_code);
		// 	$this->db->where('id_item', $key->id);
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
		// $cek_stock_awal_bulan = $this->m_aluminium->cekStockAwalBulan()->num_rows();
		// $item = $this->m_aluminium->getlistStock();

		// if ($cek_stock_awal_bulan < 1) {
		// 	foreach ($item->result() as $key) {
		// 		$obj = array(
		// 			'awal_bulan' => 1,
		// 			'inout' => 1,
		// 			'id_item' => $key->id_item,
		// 			'id_divisi' => $key->id_divisi,
		// 			'id_gudang' => $key->id_gudang,
		// 			'keranjang' => $key->keranjang,
		// 			'id_jenis_item' => $key->id_jenis_item,
		// 			'qty_in' => $key->qty,
		// 			'created' => date('Y-m-d H:i:s'),
		// 			'aktual' => date('Y-m-d')
		// 		);
		// 		$this->db->insert('data_stock', $obj);
		// 	}
		// }

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

		// $this->db->where('kode_warna', 145);
		// $this->db->where('id_jenis_item', 1);
		// $xx = $this->db->get('master_item');
		// foreach ($xx->result() as $key) {
		// 	$obx = array(
		// 		'item_code' => $key->section_ata . '-' . $key->section_allure . '-' . $key->temper . '-' . $key->kode_warna . '-' . $key->ukuran,
		// 	);
		// 	$this->db->where('kode_warna', 145);
		// 	$this->db->where('id_jenis_item', 1);
		// 	$this->db->update('master_item', $obx);
		// }

		$this->load->view('v_dashboard');
	}

	

	public function cekadaA()
	{
		$this->db->where('id_jenis_item', 1);
		$r = $this->db->get('master_item');
		foreach ($r->result() as $key) {
			$ss = array(
				'cek_ada' => 1,
			);
			$this->db->where('id_item', $key->id);
			$this->db->update('data_stock', $ss);
		}
		echo "ok";
	}
	public function cekadaB()
	{
		$this->db->where('id_jenis_item', 2);
		$r = $this->db->get('master_item');
		foreach ($r->result() as $key) {
			$ss = array(
				'cek_ada' => 1,
			);
			$this->db->where('id_item', $key->id);
			$this->db->update('data_stock', $ss);
		}
		echo "ok";
	}

	public function setJenisItemB()
	{

		// $this->db->where('id_jenis_item', 2);
		$this->db->where('ds.mutasi', 1);
		$this->db->where('ds.id_jenis_item', 0);

		$this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
		$this->db->select('mi.id,mi.id_jenis_item');

		$r = $this->db->get('data_stock ds');
		foreach ($r->result() as $key) {
			$ss = array(
				'id_jenis_item' => $key->id_jenis_item,
			);
			$this->db->where('mutasi', 1);
			$this->db->where('id_item', $key->id);
			$this->db->update('data_stock', $ss);
		}
		echo "ok";
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

	public function log_transaksi($item_code,$keranjang,$tgl)
	{
		$year        = date('Y', strtotime($tgl));
        $month       = date('m', strtotime($tgl));
        $this->db->select('mi.item_code,ds.id_gudang,ds.keranjang,ds.awal_bulan,ds.qty_in,ds.qty_out,ds.created,ds.aktual,ds.keterangan');
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->where('mi.item_code', $item_code);

        $this->db->where('DATE_FORMAT(ds.aktual,"%Y")', $year);
        $this->db->where('DATE_FORMAT(ds.aktual,"%m")', $month);
        
        $this->db->where('ds.keranjang', $keranjang);
        $data['list'] = $this->db->get('data_stock ds');
        $this->load->view('pak/v_log_transaksi',$data);
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/pak/dashboard.php */