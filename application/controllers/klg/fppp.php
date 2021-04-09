<?php
defined('BASEPATH') or exit('No direct script access allowed');

// use Mailgun\Mailgun;

// $whitelist = array(
// 	'127.0.0.1',
// 	'::1'
// );

// if (!in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
// 	require '/var/www/html/alphamax/vendor/autoload.php';
// }
class Fppp extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
		$this->load->model('klg/m_fppp');
	}

	public function index()
	{
		$this->fungsi->check_previleges('fppp');
		$data['param_tab'] = '1';
		$this->load->view('klg/fppp/v_fppp_tab', $data);
	}

	public function list($param = '')
	{
		$this->fungsi->check_previleges('fppp');
		$data['fppp']  = $this->m_fppp->getData($param);
		$data['param'] = $param;
		$this->load->view('klg/fppp/v_fppp_list', $data);
	}

	public function formAdd($param = '')
	{
		$this->fungsi->check_previleges('fppp');
		$data['divisi']             = get_options($this->db->get('master_divisi'), 'id', 'divisi');
		$data['pengiriman']         = get_options($this->db->get('master_pengiriman'), 'id', 'pengiriman');
		$data['metode_pengiriman']  = get_options($this->db->get('master_metode_pengiriman'), 'id', 'metode_pengiriman');
		$data['penggunaan_peti']    = get_options($this->db->get('master_penggunaan_peti'), 'id', 'penggunaan_peti');
		$data['penggunaan_sealant'] = get_options($this->db->get('master_penggunaan_sealant'), 'id', 'penggunaan_sealant');
		$data['warna_aluminium']    = get_options($this->db->get('master_warna_aluminium'), 'id', 'warna_aluminium');
		$data['warna_lainya']       = get_options($this->db->get('master_warna_aluminium'), 'id', 'warna_aluminium');
		$data['logo_kaca']          = get_options($this->db->get('master_logo_kaca'), 'id', 'logo_kaca');
		$data['kaca']               = get_options($this->db->get('master_kaca'), 'id', 'kaca');
		$data['brand']              = get_options($this->db->get('master_brand'), 'id', 'brand', true);
		$data['item']               = get_options($this->db->get('master_item'), 'id', 'item', true);
		$data['no_fppp']            = str_pad($this->m_fppp->getNoFppp(), 3, '0', STR_PAD_LEFT) . '/FPPP' . '/' . date('m') . '/' . date('Y');
		$data['param']              = $param;
		// $this->load->view('klg/fppp/v_fppp_add', $data);
		if ($param == 1) {
			$this->load->view('klg/fppp/v_fppp_add_residential', $data);
		} elseif ($param == 2) {
			$this->load->view('klg/fppp/v_fppp_add_astral', $data);
		} elseif ($param == 3) {
			$this->load->view('klg/fppp/v_fppp_add_bravo', $data);
		} else {
			$this->load->view('klg/fppp/v_fppp_add_hrb', $data);
		}
	}

	public function savefppp($value = '')
	{
		$this->fungsi->check_previleges('fppp');
		$datapost = array(
			'id_divisi'              => $this->input->post('id_divisi'),
			'tgl_pembuatan'          => $this->input->post('tgl_pembuatan'),
			'applicant'              => $this->input->post('applicant'),
			'applicant_sector'       => $this->input->post('applicant_sector'),
			'authorized_distributor' => $this->input->post('authorized_distributor'),
			'no_fppp'                => $this->input->post('no_fppp'),
			// 'type_fppp'              => $this->input->post('type_fppp'),
			// 'nama_aplikator'         => $this->input->post('nama_aplikator'),
			'nama_proyek'   => $this->input->post('nama_proyek'),
			'tahap'         => $this->input->post('tahap'),
			'alamat_proyek' => $this->input->post('alamat_proyek'),
			// 'alamat_pengiriman'      => $this->input->post('alamat_pengiriman'),
			'status_order' => $this->input->post('status_order'),
			// 'system'                 => $this->input->post('system'),
			// 'pekerjaan'              => $this->input->post('pekerjaan'),
			// 'no_sph'                 => $this->input->post('no_sph'),
			// 'no_vo'                  => $this->input->post('no_vo'),
			// 'no_quo'                 => $this->input->post('no_quo'),
			'note_ncr'      => $this->input->post('note_ncr'),
			'id_pengiriman' => $this->input->post('id_pengiriman'),
			// 'waktu_produksi'         => $this->input->post('waktu_produksi'),
			'deadline_pengiriman'   => $this->input->post('deadline_pengiriman'),
			'id_metode_pengiriman'  => $this->input->post('id_metode_pengiriman'),
			'id_penggunaan_peti'    => $this->input->post('id_penggunaan_peti'),
			'id_penggunaan_sealant' => $this->input->post('id_penggunaan_sealant'),
			'id_warna_aluminium'    => $this->input->post('id_warna_aluminium'),
			'id_warna_lainya'       => $this->input->post('id_warna_lainya'),
			'warna_sealant'         => $this->input->post('warna_sealant'),
			'ditujukan_kepada'      => $this->input->post('ditujukan_kepada'),
			'no_telp_tujuan'        => $this->input->post('no_telp_tujuan'),
			'pengiriman_ekspedisi'  => $this->input->post('pengiriman_ekspedisi'),
			'alamat_ekspedisi'      => $this->input->post('alamat_ekspedisi'),
			'sales'                 => $this->input->post('sales'),
			'pic_project'           => $this->input->post('pic_project'),
			'admin_koordinator'     => $this->input->post('admin_koordinator'),
			'id_kaca'               => $this->input->post('id_kaca'),
			'jenis_kaca'            => $this->input->post('jenis_kaca'),
			'id_logo_kaca'          => $this->input->post('id_logo_kaca'),
			'jumlah_gambar'         => $this->input->post('jumlah_gambar'),
			'lampiran_lain'         => $this->input->post('lampiran_lain'),
			'attachment'            => $this->input->post('attachment'),
			'note'                  => $this->input->post('note'),
			'created'               => date('Y-m-d H:i:s'),
			'updated'               => date('Y-m-d H:i:s'),
		);
		$this->m_fppp->insertfppp($datapost);
		$data['id'] = $this->db->insert_id();
		$this->fungsi->catat($datapost, "Menyimpan fppp sbb:", true);
		$data['msg'] = "fppp Disimpan";
		echo json_encode($data);
	}

	public function savefpppImage($value = '')
	{
		$this->fungsi->check_previleges('fppp');
		$upload_folder = get_upload_folder('./files/');

		$config['upload_path']   = $upload_folder;
		$config['allowed_types'] = 'pdf';
		$config['max_size']      = '3072';
		// $config['max_width']     = '1024';
		// $config['max_height']    = '1024';
		$config['encrypt_name'] = true;

		$this->load->library('upload', $config);
		$err = "";
		$msg = "";
		if (!$this->upload->do_upload('lampiran')) {
			$err = $this->upload->display_errors('<span class="error_string">', '</span>');
		} else {
			$data = $this->upload->data();

			$datapost = array(
				'id_divisi'              => $this->input->post('id_divisi'),
				'tgl_pembuatan'          => $this->input->post('tgl_pembuatan'),
				'applicant'              => $this->input->post('applicant'),
				'applicant_sector'       => $this->input->post('applicant_sector'),
				'authorized_distributor' => $this->input->post('authorized_distributor'),
				'no_fppp'                => $this->input->post('no_fppp'),
				// 'type_fppp'              => $this->input->post('type_fppp'),
				// 'nama_aplikator'         => $this->input->post('nama_aplikator'),
				'nama_proyek'   => $this->input->post('nama_proyek'),
				'tahap'         => $this->input->post('tahap'),
				'alamat_proyek' => $this->input->post('alamat_proyek'),
				// 'alamat_pengiriman'      => $this->input->post('alamat_pengiriman'),
				'status_order' => $this->input->post('status_order'),
				// 'system'                 => $this->input->post('system'),
				// 'pekerjaan'              => $this->input->post('pekerjaan'),
				// 'no_sph'                 => $this->input->post('no_sph'),
				// 'no_vo'                  => $this->input->post('no_vo'),
				// 'no_quo'                 => $this->input->post('no_quo'),
				'note_ncr'      => $this->input->post('note_ncr'),
				'id_pengiriman' => $this->input->post('id_pengiriman'),
				// 'waktu_produksi'         => $this->input->post('waktu_produksi'),
				'deadline_pengiriman'   => $this->input->post('deadline_pengiriman'),
				'id_metode_pengiriman'  => $this->input->post('id_metode_pengiriman'),
				'id_penggunaan_peti'    => $this->input->post('id_penggunaan_peti'),
				'id_penggunaan_sealant' => $this->input->post('id_penggunaan_sealant'),
				'id_warna_aluminium'    => $this->input->post('id_warna_aluminium'),
				'id_warna_lainya'       => $this->input->post('id_warna_lainya'),
				'warna_sealant'         => $this->input->post('warna_sealant'),
				'ditujukan_kepada'      => $this->input->post('ditujukan_kepada'),
				'no_telp_tujuan'        => $this->input->post('no_telp_tujuan'),
				'pengiriman_ekspedisi'  => $this->input->post('pengiriman_ekspedisi'),
				'alamat_ekspedisi'      => $this->input->post('alamat_ekspedisi'),
				'sales'                 => $this->input->post('sales'),
				'pic_project'           => $this->input->post('pic_project'),
				'admin_koordinator'     => $this->input->post('admin_koordinator'),
				'id_kaca'               => $this->input->post('id_kaca'),
				'jenis_kaca'            => $this->input->post('jenis_kaca'),
				'id_logo_kaca'          => $this->input->post('id_logo_kaca'),
				'jumlah_gambar'         => $this->input->post('jumlah_gambar'),
				'lampirab'              => substr($upload_folder, 2) . $data['file_name'],
				'lampiran_lain'         => $this->input->post('lampiran_lain'),
				'attachment'            => $this->input->post('attachment'),
				'note'                  => $this->input->post('note'),
				'created'               => date('Y-m-d H:i:s'),
				'updated'               => date('Y-m-d H:i:s'),
			);
			$this->m_fppp->insertfppp($datapost);
			$data['id'] = $this->db->insert_id();
			$this->fungsi->catat($datapost, "Menyimpan fppp sbb:", true);
			$data['msg'] = "fppp Disimpan";
			echo json_encode($data);
		}
	}

	public function savefpppDetail($value = '')
	{
		$this->fungsi->check_previleges('fppp');
		$datapost = array(
			'id_fppp'        => $this->input->post('id_fppp'),
			'id_brand'       => $this->input->post('id_brand'),
			'kode_opening'   => $this->input->post('kode_opening'),
			'kode_unit'      => $this->input->post('kode_unit'),
			'id_item'        => $this->input->post('id_item'),
			'glass_thick'    => $this->input->post('glass_thick'),
			'finish_coating' => $this->input->post('finish_coating'),
			'qty'            => $this->input->post('qty'),
			'created'        => date('Y-m-d H:i:s'),
		);

		$this->m_fppp->insertfpppDetail($datapost);
		$data['id'] = $this->db->insert_id();
		// if (from_session('id') > 2) {
		// 	$swq = array('date'       => date('Y-m-d H:i:s'));
		// 	$this->m_fppp->updatefppp($this->input->post('id_fppp'), $swq);
		// }
		echo json_encode($data);
	}

	public function getDetailTabel($value = '')
	{
		$this->fungsi->check_previleges('fppp');
		$id_fppp  = $this->input->post('id_fppp');
		$data['detail'] = $this->m_fppp->getDataDetailTabel($id_fppp);
		echo json_encode($data);
	}

	public function updateDetail()
	{
		$this->fungsi->check_previleges('fppp');
		$id    = $this->input->post('id');
		$kolom = $this->input->post('kolom');
		$nilai = $this->input->post('nilai');
		if ($kolom == 1) {
			$datapost = array('produksi_aluminium' => $nilai,);
		} elseif ($kolom == 2) {
			$datapost = array('qc_cek' => $nilai,);
		} elseif ($kolom == 3) {
			$datapost = array('pengiriman' => $nilai,);
		} elseif ($kolom == 4) {
			$datapost = array('pasang' => $nilai,);
		} else {
			$datapost = array('bst' => $nilai,);
		}
		$this->m_fppp->updateDetail($id, $datapost);
		$arr     = explode("/", $nilai);
		$respon['msg']   = "sukses update";
		$respon['nilai'] = $nilai;
		echo json_encode($respon);
	}

	public function uploadbom($id = '')
	{
		$data['id'] = $id;
		$this->load->view('klg/fppp/v_uploadbom', $data);
	}

	public function upload()
	{
		$fileName = time();
		//      $upload_folder = get_upload_folder('./excel_files/');

		// $config['upload_path']   = $upload_folder;

		$config['upload_path']   = './files/';      //buat folder dengan nama excel_files di root folder
		$config['file_name']     = $fileName;
		$config['allowed_types'] = 'xls|xlsx|csv';
		$config['max_size']      = 20000;

		$this->load->library('upload');
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('file'))
			$this->upload->display_errors();

		$media         = $this->upload->data('file');
		$inputFileName = './files/' . $media['file_name'];

		try {
			$inputFileType = IOFactory::identify($inputFileName);
			$objReader     = IOFactory::createReader($inputFileType);
			$objPHPExcel   = $objReader->load($inputFileName);
		} catch (Exception $e) {
			die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
		}

		$sheet         = $objPHPExcel->getSheet(0);
		$highestRow    = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();

		for ($row = 2; $row <= $highestRow; $row++) {                  //  Read a row of data into an array
			$rowData = $sheet->rangeToArray(
				'A' . $row . ':' . $highestColumn . $row,
				NULL,
				TRUE,
				FALSE
			);

			$id_fppp   = $this->input->post('id');
			$jenis_bom = $this->input->post('jenis_bom');


			if ($jenis_bom == 1) {
				$data = array(
					'id_fppp'         => $id_fppp,
					'section_ata'     => $rowData[0][0],
					'section_allure'  => $rowData[0][1],
					'temper'          => $rowData[0][2],
					'kode_warna'      => $rowData[0][3],
					'deskripsi_warna' => $rowData[0][4],
					'ukuran'          => $rowData[0][5],
					'qty'             => $rowData[0][6],
					'keterangan'      => $rowData[0][7],
				);
				$this->db->insert("data_fppp_bom_aluminium", $data);
			} else if ($jenis_bom == 2) {
				$data = array(
					'id_fppp'    => $id_fppp,
					'item_code'  => $rowData[0][0],
					'deskripsi'  => $rowData[0][1],
					'satuan'     => $rowData[0][2],
					'ukuran'     => $rowData[0][3],
					'qty'        => $rowData[0][4],
					'keterangan' => $rowData[0][5],
				);
				$this->db->insert("data_fppp_bom_aksesoris", $data);
				$this->m_fppp->simpan_aksesoris($data['item_code'], $data['deskripsi'], $data['satuan']);
			} else {
				$data = array(
					'id_fppp'        => $id_fppp,
					'kode_unit'      => $rowData[0][0],
					'jenis_material' => $rowData[0][1],
					'deskripsi'      => $rowData[0][2],
					'qty'            => $rowData[0][3],
					'panjang'        => $rowData[0][4],
					'lebar'          => $rowData[0][5],
					'tebal'          => $rowData[0][6],
					'keterangan'     => $rowData[0][7],
				);
				$this->db->insert("data_fppp_bom_lembaran", $data);
			}
		}
		// delete_files($media['file_path']);
		// unlink($media['file_path']);
		$data['msg'] = "Mahasiswa Baru Disimpan....";
		echo json_encode($data);
	}

	public function lihatbom($id_fppp)
	{
		$this->fungsi->check_previleges('fppp');
		$data['bom_aluminium'] = $this->m_fppp->bom_aluminium($id_fppp);
		$data['bom_aksesoris'] = $this->m_fppp->bom_aksesoris($id_fppp);
		$data['bom_lembaran']  = $this->m_fppp->bom_lembaran($id_fppp);
		$this->load->view('klg/fppp/v_fppp_bom_list', $data);
	}

	// public function index()
	// {
	// 	$this->fungsi->check_previleges('fppp');
	// 	$data['totalPermintaan'] = $this->m_fppp->getItemTotalfppp();
	// 	$data['totalTerkirim'] = $this->m_fppp->getItemTotalTerkirim();
	// 	$data['store'] = $this->db->get('master_store');
	// 	$data['bulan'] = $this->db->get('master_bulan');
	// 	$data['id_bulan'] = '';
	// 	$data['id_tahun'] = date('Y');
	// 	$data['fppp'] = $this->m_fppp->getData('x', 'x', date('Y'));
	// 	$data['total_order'] = $this->m_fppp->getTotalOrder('x', 'x', date('Y'));

	// 	$this->load->view('klg/fppp/v_fppp_list', $data);
	// }

	// public function filter($store = '', $bulan = '', $tahun = '')
	// {
	// 	$this->fungsi->check_previleges('fppp');
	// 	$data['totalPermintaan'] = $this->m_fppp->getItemTotalfppp();
	// 	$data['totalTerkirim'] = $this->m_fppp->getItemTotalTerkirim();
	// 	$data['store'] = $this->db->get('master_store');
	// 	$data['bulan'] = $this->db->get('master_bulan');
	// 	$data['id_store'] = $store;
	// 	$data['id_bulan'] = $bulan;
	// 	$data['id_tahun'] = $tahun;
	// 	$data['fppp'] = $this->m_fppp->getData($store, $bulan, $tahun);
	// 	$data['total_order'] = $this->m_fppp->getTotalOrder($store, $bulan, $tahun);
	// 	$this->load->view('klg/fppp/v_fppp_list', $data);
	// }

	// public function formAdd($value = '')
	// {
	// 	$this->fungsi->check_previleges('fppp');
	// 	$data = array(
	// 		'tipe_fppp'  => $this->db->get('master_tipe')->result(),
	// 		'nomor_fppp' => str_pad($this->m_fppp->getfppp(), 3, '0', STR_PAD_LEFT) . '/order' . '/' . date('m') . '/' . date('Y'),
	// 		'item'          => $this->db->get('master_item')->result(),
	// 		'warna'         => $this->db->get('master_warna')->result(),
	// 		'bukaan'         => $this->db->get('master_bukaan')->result(),
	// 		'brand'         => $this->db->get('master_brand')->result(),
	// 		'store'         => $this->db->get('master_store')->result(),
	// 		'status_detail'         => $this->db->get('master_status_detail')->result(),
	// 	);
	// 	$this->load->view('klg/fppp/v_fppp_add', $data);
	// }

	// public function formEdit($value = '')
	// {
	// 	$this->fungsi->check_previleges('fppp');
	// 	$data = array(
	// 		'row'          => $this->m_fppp->getEdit($value)->row(),
	// 		'detail'       => $this->m_fppp->getDataDetailTabel($value),
	// 		'tipe_fppp' => $this->db->get('master_tipe')->result(),
	// 		'item'         => $this->db->get('master_item')->result(),
	// 		'warna'        => $this->db->get('master_warna')->result(),
	// 		'bukaan'         => $this->db->get('master_bukaan')->result(),
	// 		'brand'        => $this->db->get('master_brand')->result(),
	// 		'store'        => $this->db->get('master_store')->result(),
	// 		'status_detail'         => $this->db->get('master_status_detail')->result(),
	// 	);
	// 	$this->load->view('klg/fppp/v_fppp_edit', $data);
	// }

	// public function savefppp($value = '')
	// {
	// 	$this->fungsi->check_previleges('fppp');
	// 	$cekNofppp = $this->m_fppp->cekNofppp($this->input->post('no_fppp'));
	// 	$cekSO = $this->m_fppp->cekSO($this->input->post('no_po'));
	// 	if ($cekNofppp == 'y' && $cekSO < 1) {
	// 		$datapost = array(
	// 			'id_brand'       => $this->input->post('brand'),
	// 			'no_fppp'     => $this->input->post('no_fppp'),
	// 			'no_po'          => $this->input->post('no_po'),
	// 			'project_owner'  => $this->input->post('projek_owner'),
	// 			'id_store'       => $this->input->post('id_store'),
	// 			'alamat_proyek'  => $this->input->post('alamat_proyek'),
	// 			'no_telp'        => $this->input->post('no_telp'),
	// 			'tgl_pengiriman' => $this->input->post('tgl_pengiriman'),
	// 			'intruction'     => $this->input->post('keterangan'),
	// 			'lampiran'       => '',
	// 			'date'      	 => $this->input->post('date'),
	// 		);
	// 		$this->m_fppp->insertfppp($datapost);
	// 		$data['id'] = $this->db->insert_id();
	// 		$this->fungsi->catat($datapost, "Menyimpan Permintaan sbb:", true);
	// 		$data['msg'] = "Permintaan Disimpan";
	// 	} else {
	// 		$data['id'] = 'x';
	// 		$data['msg'] = "No SO Sudah ada";
	// 	}

	// 	echo json_encode($data);
	// }

	// public function savefpppImage($value = '')
	// {
	// 	$this->fungsi->check_previleges('fppp');
	// 	$upload_folder = get_upload_folder('./files/');

	// 	$config['upload_path']   = $upload_folder;
	// 	$config['allowed_types'] = 'pdf';
	// 	$config['max_size']      = '3072';
	// 	// $config['max_width']     = '1024';
	// 	// $config['max_height']    = '1024';
	// 	$config['encrypt_name']  = true;

	// 	$this->load->library('upload', $config);
	// 	$err = "";
	// 	$msg = "";
	// 	if (!$this->upload->do_upload('lampiran')) {
	// 		$err = $this->upload->display_errors('<span class="error_string">', '</span>');
	// 	} else {
	// 		$data = $this->upload->data();

	// 		$cekNofppp = $this->m_fppp->cekNofppp($this->input->post('no_fppp'));
	// 		$cekSO = $this->m_fppp->cekSO($this->input->post('no_po'));
	// 		if ($cekNofppp == 'y' && $cekSO < 1) {
	// 			$datapost = array(
	// 				'id_brand'       => $this->input->post('brand'),
	// 				'no_fppp'     => $this->input->post('no_fppp'),
	// 				'no_po'          => $this->input->post('no_po'),
	// 				'project_owner'  => $this->input->post('projek_owner'),
	// 				'id_store'       => $this->input->post('id_store'),
	// 				'alamat_proyek'  => $this->input->post('alamat_proyek'),
	// 				'no_telp'        => $this->input->post('no_telp'),
	// 				'tgl_pengiriman' => $this->input->post('tgl_pengiriman'),
	// 				'intruction'     => $this->input->post('keterangan'),
	// 				'lampiran'       => substr($upload_folder, 2) . $data['file_name'],
	// 				'date'      	 => $this->input->post('date'),
	// 			);
	// 			$this->m_fppp->insertfppp($datapost);
	// 			$data['id'] = $this->db->insert_id();
	// 			$this->fungsi->catat($datapost, "Menyimpan Permintaan sbb:", true);
	// 			$data['msg'] = "Permintaan Disimpan";
	// 		} else {
	// 			$data['id'] = 'x';
	// 			$data['msg'] = "No SO Sudah ada";
	// 		}
	// 		echo json_encode($data);
	// 	}
	// }

	// public function updatefppp($value = '')
	// {
	// 	$this->fungsi->check_previleges('fppp');
	// 	$id_fppp = $this->input->post('id_fppp');
	// 	$datapost = array(
	// 		'id_brand'       => $this->input->post('brand'),
	// 		'no_fppp'     => $this->input->post('no_fppp'),
	// 		'no_po'          => $this->input->post('no_po'),
	// 		'project_owner'  => $this->input->post('projek_owner'),
	// 		'id_store'       => $this->input->post('id_store'),
	// 		'alamat_proyek'  => $this->input->post('alamat_proyek'),
	// 		'no_telp'        => $this->input->post('no_telp'),
	// 		'tgl_pengiriman' => $this->input->post('tgl_pengiriman'),
	// 		'intruction'     => $this->input->post('keterangan'),
	// 		'timestamp'     => date('Y-m-d H:i:s'),
	// 	);
	// 	$this->m_fppp->updatefppp($id_fppp, $datapost);
	// 	$data['id'] = $this->db->insert_id();
	// 	$this->fungsi->catat($datapost, "Mengupdate Permintaan sbb:", true);
	// 	$data['msg'] = "Permintaan Diupdate";
	// 	echo json_encode($data);
	// }

	// public function updatefpppImage($value = '')
	// {
	// 	$this->fungsi->check_previleges('fppp');
	// 	$upload_folder = get_upload_folder('./files/');

	// 	$config['upload_path']   = $upload_folder;
	// 	$config['allowed_types'] = 'pdf';
	// 	$config['max_size']      = '3072';
	// 	// $config['max_width']     = '1024';
	// 	// $config['max_height']    = '1024';
	// 	$config['encrypt_name']  = true;

	// 	$this->load->library('upload', $config);
	// 	$err = "";
	// 	$msg = "";
	// 	if (!$this->upload->do_upload('lampiran')) {
	// 		$err = $this->upload->display_errors('<span class="error_string">', '</span>');
	// 	} else {
	// 		$data = $this->upload->data();
	// 		$id_fppp = $this->input->post('id_fppp');
	// 		$datapost = array(
	// 			'id_brand'       => $this->input->post('brand'),
	// 			'no_fppp'     => $this->input->post('no_fppp'),
	// 			'no_po'          => $this->input->post('no_po'),
	// 			'project_owner'  => $this->input->post('projek_owner'),
	// 			'id_store'       => $this->input->post('id_store'),
	// 			'alamat_proyek'  => $this->input->post('alamat_proyek'),
	// 			'no_telp'        => $this->input->post('no_telp'),
	// 			'tgl_pengiriman' => $this->input->post('tgl_pengiriman'),
	// 			'intruction'     => $this->input->post('keterangan'),
	// 			'timestamp'     => date('Y-m-d H:i:s'),
	// 			'lampiran'       => substr($upload_folder, 2) . $data['file_name'],
	// 		);
	// 		$this->m_fppp->updatefppp($id_fppp, $datapost);
	// 		$data['id'] = $this->db->insert_id();
	// 		$this->fungsi->catat($datapost, "Mengupdate Permintaan sbb:", true);
	// 		$data['msg'] = "Permintaan Diupdate";
	// 		echo json_encode($data);
	// 	}
	// }

	// public function savefpppDetail($value = '')
	// {
	// 	$harga = $this->input->post('harga');
	// 	if ($harga < 1) {
	// 		$harga = 0;
	// 	} else {
	// 		$harga = $harga = $this->input->post('harga');
	// 	}
	// 	$this->fungsi->check_previleges('fppp');
	// 	$datapost = array(
	// 		'id_fppp' => $this->input->post('id_fppp'),
	// 		'id_tipe'    => $this->input->post('tipe_fppp'),
	// 		'id_item'    => $this->input->post('item'),
	// 		'id_warna'   => $this->input->post('warna'),
	// 		'bukaan'     => $this->input->post('bukaan'),
	// 		'lebar'      => $this->input->post('lebar'),
	// 		'tinggi'     => $this->input->post('tinggi'),
	// 		'qty'        => $this->input->post('qty'),
	// 		'keterangan' => $this->input->post('keterangan'),
	// 		'id_status_detail' => $this->input->post('status_detail'),
	// 		'harga'      => $harga,
	// 		'date'       => date('Y-m-d H:i:s'),
	// 	);

	// 	$this->m_fppp->insertfpppDetail($datapost);
	// 	$data['id'] = $this->db->insert_id();
	// 	if (from_session('id') > 2) {
	// 		$swq = array('date'       => date('Y-m-d H:i:s'));
	// 		$this->m_fppp->updatefppp($this->input->post('id_fppp'), $swq);
	// 	}

	// 	$this->fungsi->catat($datapost, "Menyimpan detail fppp sbb:", true);
	// 	$data['msg'] = "fppp Disimpan";
	// 	echo json_encode($data);
	// }

	// public function getHarga()
	// {
	// 	$this->fungsi->check_previleges('fppp');
	// 	$store  = $this->input->post('store');
	// 	$item   = $this->input->post('item');
	// 	$warna  = $this->input->post('warna');
	// 	$lokasi = $this->m_fppp->getRowKategoriLokasi($store);
	// 	$harga  = $this->m_fppp->getMappingHarga($item, $warna, $lokasi);
	// 	$respon = [
	// 		'harga' => $harga,
	// 		'msg' => 'Data Berhasil Dihapus',
	// 	];
	// 	echo json_encode($respon);
	// }

	// public function cancel($id)
	// {
	// 	$this->fungsi->check_previleges('fppp');
	// 	$data = array('id' => $id,);

	// 	$this->m_fppp->cancelOrder($id);
	// 	$this->fungsi->catat($data, "Cancel Permintaan dengan id:", true);
	// 	$this->fungsi->run_js('load_silent("klg/fppp","#content")');
	// 	$this->fungsi->message_box("Cancel Permintaan Berhasil", "success");
	// }

	// public function deleteItem()
	// {
	// 	$this->fungsi->check_previleges('fppp');
	// 	$id = $this->input->post('id');
	// 	$data = array('id' => $id,);

	// 	$this->m_fppp->deleteDetailItem($id);
	// 	$this->fungsi->catat($data, "Menghapus fppp Detail dengan data sbb:", true);
	// 	$respon = ['msg' => 'Data Berhasil Dihapus'];
	// 	echo json_encode($respon);
	// }

	// public function getDetailTabel($value = '')
	// {
	// 	$this->fungsi->check_previleges('fppp');
	// 	$id_sku = $this->input->post('id_sku');
	// 	$data['detail'] = $this->m_fppp->getDataDetailTabel($id_sku);
	// 	echo json_encode($data);
	// }

















	// public function getAlamat()
	// {
	// 	$this->fungsi->check_previleges('fppp');
	// 	$id = $this->input->post('buyer');
	// 	$currency = $this->m_fppp->currencyProdukBuyer($id)->currency;

	// 	if ($currency == '1') {
	// 		$mata_uang = 'IDR';
	// 	} elseif ($currency == '2') {
	// 		$mata_uang = 'USD';
	// 	} elseif ($currency == '3') {
	// 		$mata_uang = 'EUR';
	// 	} else {
	// 		$mata_uang = 'GPB';
	// 	}

	// 	$data['currency'] = $mata_uang;
	// 	$data['alamat'] = $this->m_fppp->alamatBuyer($id);

	// 	echo json_encode($data);
	// }

	// public function getGambar()
	// {
	// 	$this->fungsi->check_previleges('fppp');
	// 	$id = $this->input->post('produk');
	// 	$currency = $this->m_fppp->gambarProduk($id)->nama_currency;

	// 	$data['size'] = $this->m_fppp->gambarProduk($id)->size;
	// 	$data['grade'] = $this->m_fppp->gambarProduk($id)->nama_grade;
	// 	$data['id_mata_uang'] = $currency;
	// 	$data['mata_uang'] = $currency;
	// 	$data['gambar'] = $this->m_fppp->gambarProduk($id)->gambar;
	// 	$data['harga'] = $this->m_fppp->gambarProduk($id)->harga;
	// 	echo json_encode($data);
	// }

	// public function getDetailStore()
	// {
	// 	$this->fungsi->check_previleges('fppp');
	// 	$id = $this->input->post('store');

	// 	$data['store']           = $this->m_fppp->getRowDetailStore($id)->store;
	// 	$data['no_telp']         = $this->m_fppp->getRowDetailStore($id)->no_telp;
	// 	$data['alamat']          = $this->m_fppp->getRowDetailStore($id)->alamat;
	// 	$data['id_jenis_market'] = $this->m_fppp->getRowDetailStore($id)->id_jenis_market;
	// 	echo json_encode($data);
	// }

	// public function getDetailItem()
	// {
	// 	$this->fungsi->check_previleges('fppp');
	// 	$id = $this->input->post('item');

	// 	$data['gambar'] = $this->m_fppp->getRowDetailItem($id)->gambar;
	// 	$data['lebar'] = $this->m_fppp->getRowDetailItem($id)->lebar;
	// 	$data['tinggi'] = $this->m_fppp->getRowDetailItem($id)->tinggi;
	// 	$data['harga'] = $this->m_fppp->getRowDetailItem($id)->harga;
	// 	$data['id_jenis_barang'] = $this->m_fppp->getRowDetailItem($id)->id_jenis_barang;
	// 	$data['jenis_barang'] = $this->m_fppp->getRowDetailItem($id)->jenis_barang;
	// 	echo json_encode($data);
	// }

	// public function getWarnaItem($value = '')
	// {
	// 	$this->fungsi->check_previleges('fppp');
	// 	$id_item = $this->input->post('item');
	// 	$get_data = $this->m_fppp->getWarnaItem($id_item);

	// 	// echo $this->db->last_query();

	// 	$data = array();

	// 	foreach ($get_data as $val) {
	// 		$data[] = $val;
	// 	}

	// 	echo json_encode($data, JSON_PRETTY_PRINT);
	// }


	// public function finish($id)
	// {
	// 	$whitelist = array(
	// 		'127.0.0.1',
	// 		'::1'
	// 	);



	// 	$data = array(
	// 		'id'     => $id,
	// 		'header' => $this->m_fppp->getHeaderCetak($id),
	// 		'detail' => $this->m_fppp->getDataDetailTabel($id),
	// 	);

	// 	if (!in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
	// 		if ($id > 1) {
	// 			$this->load->view('klg/fppp/v_cetak_server', $data);
	// 		}

	// 		$detail = $this->m_fppp->getEdit($id)->row();
	// 		$invo = str_replace("/", "_", $data['header']->no_fppp);
	// 		$filename = BASEPATH . '/attachment/' . $invo . '.pdf';
	// 		$mg = Mailgun::create('a2cceaca998ebac8e8898da3ff8e7db5-0d2e38f7-69699916');
	// 		$mg->messages()->send('a.alphamax.alluresystem.site', [
	// 			'from'	=> '<no_reply@allureindustries.com>',
	// 			'to'	=> array('calvin@allureindustries.com ,abdul.karim@allureindustries.com ,joni.halim@allureindustries.com ,imelda@allureindustries.com ,bobby.armanda@allureindustries.com,kholiqtheskywalker@gmail.com,alphamax@allureindustries.com'),
	// 			'subject' => 'Permintaan Pengiriman ' . $detail->no_fppp . ' ' . $detail->store,
	// 			'html'    => $this->m_fppp->template_email($detail->no_fppp, $detail->store),
	// 			'attachment' => [
	// 				['remoteName' => $invo . '.pdf', 'filePath' => $filename]
	// 			]
	// 		]);
	// 	}
	// 	$this->fungsi->run_js('load_silent("klg/fppp","#content")');
	// }

	// public function cetak($id)
	// {
	// 	$data = array(
	// 		'id'     => $id,
	// 		'header' => $this->m_fppp->getHeaderCetak($id),
	// 		'detail' => $this->m_fppp->getDataDetailTabel($id),
	// 	);
	// 	$this->load->view('klg/fppp/v_cetak', $data);
	// }

	// public function editItem($value = '')
	// {
	// 	$this->fungsi->check_previleges('fppp');
	// 	$id = $this->input->post('id');
	// 	$getData = $this->m_fppp->getDetailfppp($id);
	// 	$respon = [
	// 		'item'       => $getData->id_item,
	// 		'warna'      => $getData->id_warna,
	// 		'bukaan'     => $getData->bukaan,
	// 		'lebar'      => $getData->lebar,
	// 		'tinggi'     => $getData->tinggi,
	// 		'qty'        => $getData->qty,
	// 		'keterangan' => $getData->keterangan,
	// 		'msg'        => 'Data Berhasil Diubah',
	// 	];
	// 	echo json_encode($respon);
	// }

	// public function updateItemDetail($value = '')
	// {
	// 	$this->fungsi->check_previleges('fppp');
	// 	$id = $this->input->post('id');
	// 	$datapost = array(
	// 		'id_item'    => $this->input->post('item'),
	// 		'id_warna'   => $this->input->post('warna'),
	// 		'bukaan'     => $this->input->post('bukaan'),
	// 		'lebar'      => $this->input->post('lebar'),
	// 		'tinggi'     => $this->input->post('tinggi'),
	// 		'qty'        => $this->input->post('qty'),
	// 		'keterangan' => $this->input->post('keterangan'),
	// 		'date'       => date('Y-m-d H:i:s'),
	// 	);

	// 	$this->m_fppp->updatefpppDetail($datapost, $id);
	// 	$this->fungsi->catat($datapost, "Mengubah detail fppp sbb:", true);
	// 	$respon = [
	// 		'id'       => $id,
	// 	];
	// 	echo json_encode($respon);
	// }
}

/* End of file fppp.php */
/* Location: ./application/controllers/klg/fppp.php */