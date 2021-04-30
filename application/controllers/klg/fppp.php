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

	public function hasil_finish($param)
	{
		$this->fungsi->check_previleges('fppp');
		$data['param_tab'] = $param;
		$this->load->view('klg/fppp/v_fppp_tab', $data);
	}

	public function list($param = '')
	{
		$this->fungsi->check_previleges('fppp');
		$data['fppp']  = $this->m_fppp->getData($param);
		$data['param'] = $param;
		$this->load->view('klg/fppp/v_fppp_list', $data);
	}

	public function deadlineWorkshop()
	{
		$this->fungsi->check_previleges('fppp');
		$field  = $this->input->post('field');
		$value  = $this->input->post('value');
		$editid = $this->input->post('id');
		$this->m_fppp->editDeadlineWorkshop($field, $value, $editid);
		$data['status'] = "berhasil";
		echo json_encode($data);
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
		$data['item']               = get_options($this->db->get('master_barang'), 'id', 'barang', true);
		$data['param']              = $param;
		// $this->load->view('klg/fppp/v_fppp_add', $data);
		if ($param == 1) {
			$data['no_fppp'] = str_pad($this->m_fppp->getNoFppp($param), 3, '0', STR_PAD_LEFT) . '/FPPP/RSD' . '/' . date('m') . '/' . date('Y');
			$this->load->view('klg/fppp/v_fppp_add_residential', $data);
		} elseif ($param == 2) {
			$data['no_fppp'] = str_pad($this->m_fppp->getNoFppp($param), 3, '0', STR_PAD_LEFT) . '/FPPP/ASTRAL' . '/' . date('m') . '/' . date('Y');
			$this->load->view('klg/fppp/v_fppp_add_astral', $data);
		} elseif ($param == 3) {
			$data['no_fppp'] = str_pad($this->m_fppp->getNoFppp($param), 3, '0', STR_PAD_LEFT) . '/FPPP/BRAVO' . '/' . date('m') . '/' . date('Y');
			$this->load->view('klg/fppp/v_fppp_add_bravo', $data);
		} else {
			$data['no_fppp'] = str_pad($this->m_fppp->getNoFppp($param), 3, '0', STR_PAD_LEFT) . '/FPPP/HRB' . '/' . date('m') . '/' . date('Y');
			$this->load->view('klg/fppp/v_fppp_add_hrb', $data);
		}
	}

	public function savefppp($value = '')
	{
		$this->fungsi->check_previleges('fppp');
		$id_div = $this->input->post('id_divisi');
		if ($id_div == 1) {
			$nofppp = str_pad($this->m_fppp->getNoFppp(1), 3, '0', STR_PAD_LEFT) . '/FPPP/RSD' . '/' . date('m') . '/' . date('Y');
		} elseif ($id_div == 2) {
			$nofppp = str_pad($this->m_fppp->getNoFppp(2), 3, '0', STR_PAD_LEFT) . '/FPPP/ASTRAL' . '/' . date('m') . '/' . date('Y');
		} elseif ($id_div == 3) {
			$nofppp = str_pad($this->m_fppp->getNoFppp(3), 3, '0', STR_PAD_LEFT) . '/FPPP/BRAVO' . '/' . date('m') . '/' . date('Y');
		} else {
			$nofppp = str_pad($this->m_fppp->getNoFppp(4), 3, '0', STR_PAD_LEFT) . '/FPPP/HRB' . '/' . date('m') . '/' . date('Y');
		}
		$datapost = array(
			'id_divisi'              => $this->input->post('id_divisi'),
			'tgl_pembuatan'          => $this->input->post('tgl_pembuatan'),
			'applicant'              => $this->input->post('applicant'),
			'applicant_sector'       => $this->input->post('applicant_sector'),
			'authorized_distributor' => $this->input->post('authorized_distributor'),
			'no_fppp'                => $nofppp,
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
				'lampiran'              => substr($upload_folder, 2) . $data['file_name'],
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
					'satuan'          => $rowData[0][6],
					'qty'             => $rowData[0][7],
					'keterangan'      => $rowData[0][8],
				);
				$this->db->insert("data_fppp_bom_aluminium", $data);
				$obj = array(
					'id_jenis_item'   => 1,
					'section_ata'     => $rowData[0][0],
					'section_allure'  => $rowData[0][1],
					'temper'          => $rowData[0][2],
					'kode_warna'      => $rowData[0][3],
					'deskripsi_warna' => $rowData[0][4],
					'ukuran'          => $rowData[0][5],
					'satuan'          => $rowData[0][6],
					'created'         => date('Y-m-d H:i:s'),
				);
				$cek_item = $this->m_fppp->cekMasterAluminium($obj['section_ata'], $obj['section_allure']);
				if ($cek_item < 1) {
					$this->m_fppp->simpanItem($obj);
				}
			} else if ($jenis_bom == 2) {
				$data = array(
					'id_fppp'            => $id_fppp,
					'item_code'          => $rowData[0][0],
					'deskripsi'          => $rowData[0][1],
					'qty'                => $rowData[0][2],
					'keterangan'         => $rowData[0][3],
					'id_jenis_aksesoris' => $rowData[0][4],
				);
				$cek_item_bom = $this->m_fppp->cekBomAksesoris($id_fppp, $data['item_code']);
				if ($cek_item_bom < 1) {
					$this->db->insert("data_fppp_bom_aksesoris", $data);
				}
				$obj = array(
					'id_jenis_item'      => 2,
					'item_code'          => $rowData[0][0],
					'deskripsi'          => $rowData[0][1],
					'id_jenis_aksesoris' => $rowData[0][4],
					'created'            => date('Y-m-d H:i:s'),
				);
				$cek_item = $this->m_fppp->cekMasterAksesoris($obj['item_code']);
				if ($cek_item < 1) {
					$this->m_fppp->simpanItem($obj);
				}
			} else {
				$data = array(
					'id_fppp'        => $id_fppp,
					'jenis_material' => $rowData[0][0],
					'nama_barang'    => $rowData[0][1],
					'lebar'          => $rowData[0][2],
					'tinggi'         => $rowData[0][3],
					'tebal'          => $rowData[0][4],
					'warna'          => $rowData[0][5],
					'qty'            => $rowData[0][6],
					'keterangan'     => $rowData[0][7],
				);
				$this->db->insert("data_fppp_bom_lembaran", $data);
				$obj = array(
					'id_jenis_item'  => 3,
					'jenis_material' => $rowData[0][0],
					'nama_barang'    => $rowData[0][1],
					'lebar'          => $rowData[0][2],
					'tinggi'         => $rowData[0][3],
					'tebal'          => $rowData[0][4],
					'warna'          => $rowData[0][5],
					'created'        => date('Y-m-d H:i:s'),
				);
				$cek_item = $this->m_fppp->cekMasterLembaran($obj['nama_barang']);
				if ($cek_item < 1) {
					$this->m_fppp->simpanItem($obj);
				}
			}
		}
		// delete_files($media['file_path']);
		// unlink($media['file_path']);
		$data['msg'] = "Data Baru Disimpan....";
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

	public function memo()
	{
		$this->fungsi->check_previleges('fppp');
		$data['fppp'] = $this->m_fppp->getDataMemo();
		$this->load->view('klg/fppp/v_fppp_memo_list', $data);
	}

	public function memoAdd()
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
		$data['item']               = get_options($this->db->get('master_barang'), 'id', 'barang', true);

		$data['no_fppp'] = str_pad($this->m_fppp->getNoFppp(99), 3, '0', STR_PAD_LEFT) . '/MEMO' . '/' . date('m') . '/' . date('Y');
		$this->load->view('klg/fppp/v_fppp_add_memo', $data);
	}

	public function savefpppmemo($value = '')
	{
		$this->fungsi->check_previleges('fppp');
		$id_div = $this->input->post('id_divisi');
		if ($id_div == 1) {
			$nofppp = str_pad($this->m_fppp->getNoFppp(1), 3, '0', STR_PAD_LEFT) . '/FPPP/RSD' . '/' . date('m') . '/' . date('Y');
		} elseif ($id_div == 2) {
			$nofppp = str_pad($this->m_fppp->getNoFppp(2), 3, '0', STR_PAD_LEFT) . '/FPPP/ASTRAL' . '/' . date('m') . '/' . date('Y');
		} elseif ($id_div == 3) {
			$nofppp = str_pad($this->m_fppp->getNoFppp(3), 3, '0', STR_PAD_LEFT) . '/FPPP/BRAVO' . '/' . date('m') . '/' . date('Y');
		} else {
			$nofppp = str_pad($this->m_fppp->getNoFppp(4), 3, '0', STR_PAD_LEFT) . '/FPPP/HRB' . '/' . date('m') . '/' . date('Y');
		}
		$datapost = array(
			'is_memo'                => 2,
			'id_divisi'              => $this->input->post('id_divisi'),
			'tgl_pembuatan'          => $this->input->post('tgl_pembuatan'),
			'applicant'              => $this->input->post('applicant'),
			'applicant_sector'       => $this->input->post('applicant_sector'),
			'authorized_distributor' => $this->input->post('authorized_distributor'),
			'no_fppp'                => $nofppp,
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

	public function savefpppmemoImage($value = '')
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
				'is_memo'                => 2,
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
				'lampiran'              => substr($upload_folder, 2) . $data['file_name'],
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
}

/* End of file fppp.php */
/* Location: ./application/controllers/klg/fppp.php */