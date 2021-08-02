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
		$data['divisi']    = $this->db->get('master_divisi');
		$this->load->view('klg/fppp/v_fppp_tab', $data);
	}

	public function hasil_finish($param)
	{
		$this->fungsi->check_previleges('fppp');
		$data['param_tab'] = $param;
		$data['divisi']    = $this->db->get('master_divisi');
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
		$data['divisi']               = get_options($this->db->get('master_divisi'), 'id', 'divisi');
		$data['pengiriman']           = get_options($this->db->get('master_pengiriman'), 'id', 'pengiriman');
		$data['metode_pengiriman']    = get_options($this->db->get('master_metode_pengiriman'), 'id', 'metode_pengiriman');
		$data['penggunaan_peti']      = get_options($this->db->get('master_penggunaan_peti'), 'id', 'penggunaan_peti');
		$data['penggunaan_sealant']   = get_options($this->db->get('master_penggunaan_sealant'), 'id', 'penggunaan_sealant');
		$data['warna_aluminium']      = get_options($this->db->get('master_warna_aluminium'), 'id', 'warna_aluminium');
		$data['warna_lainya']         = get_options($this->db->get('master_warna_aluminium'), 'id', 'warna_aluminium');
		$data['logo_kaca']            = get_options($this->db->get('master_logo_kaca'), 'id', 'logo_kaca');
		$data['kaca']                 = get_options($this->db->get('master_kaca'), 'id', 'kaca');
		$data['brand']                = get_options($this->db->get('master_brand'), 'id', 'brand', true);
		$data['item']                 = get_options($this->db->get('master_barang'), 'id', 'barang', true);
		$data['brand_edit']           = $this->db->get('master_brand');
		$data['warna_aluminium_edit'] = $this->db->get('master_warna_aluminium');
		$data['item_edit']            = $this->db->get('master_barang');
		$data['param']                = $param;
		$nama_divisi            = $this->m_fppp->getRowNamaDivisi($param)->divisi_pendek;
		$data['no_fppp']              = str_pad($this->m_fppp->getNoFppp($param), 3, '0', STR_PAD_LEFT) . '/FPPP/' . $nama_divisi . '/' . date('m') . '/' . date('Y');
		$this->load->view('klg/fppp/v_fppp_add', $data);
	}

	public function formEdit($id = '')
	{
		$this->fungsi->check_previleges('fppp');
		$param                  = $this->m_fppp->getRowFppp($id)->row()->id_divisi;
		$data['divisi']               = get_options($this->db->get('master_divisi'), 'id', 'divisi');
		$data['pengiriman']           = get_options($this->db->get('master_pengiriman'), 'id', 'pengiriman');
		$data['metode_pengiriman']    = get_options($this->db->get('master_metode_pengiriman'), 'id', 'metode_pengiriman');
		$data['penggunaan_peti']      = get_options($this->db->get('master_penggunaan_peti'), 'id', 'penggunaan_peti');
		$data['penggunaan_sealant']   = get_options($this->db->get('master_penggunaan_sealant'), 'id', 'penggunaan_sealant');
		$data['warna_aluminium']      = get_options($this->db->get('master_warna_aluminium'), 'id', 'warna_aluminium');
		$data['warna_lainya']         = get_options($this->db->get('master_warna_aluminium'), 'id', 'warna_aluminium');
		$data['logo_kaca']            = get_options($this->db->get('master_logo_kaca'), 'id', 'logo_kaca');
		$data['kaca']                 = get_options($this->db->get('master_kaca'), 'id', 'kaca');
		$data['brand']                = get_options($this->db->get('master_brand'), 'id', 'brand', true);
		$data['item']                 = get_options($this->db->get('master_barang'), 'id', 'barang', true);
		$data['brand_edit']           = $this->db->get('master_brand');
		$data['warna_aluminium_edit'] = $this->db->get('master_warna_aluminium');
		$data['item_edit']            = $this->db->get('master_barang');
		// $this->db->get_where('mytable', array('id' => $id), $limit, $offset);
		$data['param']     = $param;
		$data['row']       = $this->m_fppp->getRowFppp($id)->row();
		$data['detail']    = $this->m_fppp->getRowFpppDetail($id);
		$nama_divisi = $this->m_fppp->getRowNamaDivisi($param)->divisi_pendek;
		$data['no_fppp']   = str_pad($this->m_fppp->getNoFppp($param), 3, '0', STR_PAD_LEFT) . '/FPPP/' . $nama_divisi . '/' . date('m') . '/' . date('Y');
		$this->load->view('klg/fppp/v_fppp_edit', $data);
	}

	public function savefppp($value = '')
	{
		$this->fungsi->check_previleges('fppp');
		$param       = $this->input->post('id_divisi');
		$nama_divisi = $this->m_fppp->getRowNamaDivisi($param)->divisi_pendek;
		$nofppp      = str_pad($this->m_fppp->getNoFppp($param), 3, '0', STR_PAD_LEFT) . '/FPPP/' . $nama_divisi . '/' . date('m') . '/' . date('Y');

		$datapost = array(
			'id_divisi'              => $this->input->post('id_divisi'),
			'tgl_pembuatan'          => $this->input->post('tgl_pembuatan'),
			'no_fppp'                => $nofppp,
			'applicant'              => $this->input->post('applicant'),
			'applicant_sector'       => $this->input->post('applicant_sector'),
			'authorized_distributor' => $this->input->post('authorized_distributor'),
			'type_fppp'              => $this->input->post('type_fppp'),
			'tahap_produksi'         => $this->input->post('tahap_produksi'),
			'nama_aplikator'         => $this->input->post('nama_aplikator'),
			'nama_proyek'            => $this->input->post('nama_proyek'),
			'tahap'                  => $this->input->post('tahap'),
			'alamat_proyek'          => $this->input->post('alamat_proyek'),
			'status_order'           => $this->input->post('status_order'),
			'note_ncr'               => $this->input->post('note_ncr'),
			'id_pengiriman'          => $this->input->post('id_pengiriman'),
			'deadline_pengiriman'    => $this->input->post('deadline_pengiriman'),
			'id_metode_pengiriman'   => $this->input->post('id_metode_pengiriman'),
			'id_penggunaan_peti'     => $this->input->post('id_penggunaan_peti'),
			'id_penggunaan_sealant'  => $this->input->post('id_penggunaan_sealant'),
			'id_warna_aluminium'     => $this->input->post('id_warna_aluminium'),
			'id_warna_lainya'        => $this->input->post('id_warna_lainya'),
			'warna_sealant'          => $this->input->post('warna_sealant'),
			'ditujukan_kepada'       => $this->input->post('ditujukan_kepada'),
			'no_telp_tujuan'         => $this->input->post('no_telp_tujuan'),
			'pengiriman_ekspedisi'   => $this->input->post('pengiriman_ekspedisi'),
			'alamat_ekspedisi'       => $this->input->post('alamat_ekspedisi'),
			'sales'                  => $this->input->post('sales'),
			'pic_project'            => $this->input->post('pic_project'),
			'admin_koordinator'      => $this->input->post('admin_koordinator'),
			'id_kaca'                => $this->input->post('id_kaca'),
			'jenis_kaca'             => $this->input->post('jenis_kaca'),
			'id_logo_kaca'           => $this->input->post('id_logo_kaca'),
			'jumlah_gambar'          => $this->input->post('jumlah_gambar'),
			'jumlah_unit'            => $this->input->post('jumlah_unit'),
			'note'                   => $this->input->post('note'),
			'created'                => date('Y-m-d H:i:s'),
			'updated'                => date('Y-m-d H:i:s'),
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
			$data        = $this->upload->data();
			$param       = $this->input->post('id_divisi');
			$nama_divisi = $this->m_fppp->getRowNamaDivisi($param)->divisi_pendek;
			$nofppp      = str_pad($this->m_fppp->getNoFppp($param), 3, '0', STR_PAD_LEFT) . '/FPPP/' . $nama_divisi . '/' . date('m') . '/' . date('Y');

			$datapost = array(
				'id_divisi'              => $this->input->post('id_divisi'),
				'tgl_pembuatan'          => $this->input->post('tgl_pembuatan'),
				'applicant'              => $this->input->post('applicant'),
				'applicant_sector'       => $this->input->post('applicant_sector'),
				'authorized_distributor' => $this->input->post('authorized_distributor'),
				'no_fppp'                => $nofppp,
				'nama_proyek'            => $this->input->post('nama_proyek'),
				'tahap'                  => $this->input->post('tahap'),
				'alamat_proyek'          => $this->input->post('alamat_proyek'),
				'status_order'           => $this->input->post('status_order'),
				'note_ncr'               => $this->input->post('note_ncr'),
				'id_pengiriman'          => $this->input->post('id_pengiriman'),
				'deadline_pengiriman'    => $this->input->post('deadline_pengiriman'),
				'id_metode_pengiriman'   => $this->input->post('id_metode_pengiriman'),
				'id_penggunaan_peti'     => $this->input->post('id_penggunaan_peti'),
				'id_penggunaan_sealant'  => $this->input->post('id_penggunaan_sealant'),
				'id_warna_aluminium'     => $this->input->post('id_warna_aluminium'),
				'id_warna_lainya'        => $this->input->post('id_warna_lainya'),
				'warna_sealant'          => $this->input->post('warna_sealant'),
				'ditujukan_kepada'       => $this->input->post('ditujukan_kepada'),
				'no_telp_tujuan'         => $this->input->post('no_telp_tujuan'),
				'pengiriman_ekspedisi'   => $this->input->post('pengiriman_ekspedisi'),
				'alamat_ekspedisi'       => $this->input->post('alamat_ekspedisi'),
				'sales'                  => $this->input->post('sales'),
				'pic_project'            => $this->input->post('pic_project'),
				'admin_koordinator'      => $this->input->post('admin_koordinator'),
				'id_kaca'                => $this->input->post('id_kaca'),
				'jenis_kaca'             => $this->input->post('jenis_kaca'),
				'id_logo_kaca'           => $this->input->post('id_logo_kaca'),
				'jumlah_gambar'          => $this->input->post('jumlah_gambar'),
				'jumlah_unit'            => $this->input->post('jumlah_unit'),
				'lampiran'               => substr($upload_folder, 2) . $data['file_name'],
				'note'                   => $this->input->post('note'),
				'created'                => date('Y-m-d H:i:s'),
				'updated'                => date('Y-m-d H:i:s'),
			);
			$this->m_fppp->insertfppp($datapost);
			$data['id'] = $this->db->insert_id();
			$this->fungsi->catat($datapost, "Menyimpan fppp sbb:", true);
			$data['msg'] = "fppp Disimpan";
			echo json_encode($data);
		}
	}

	public function updatefppp($value = '')
	{
		$this->fungsi->check_previleges('fppp');
		$id_fppp     = $this->input->post('id_fppp');
		$param       = $this->input->post('id_divisi');
		$nama_divisi = $this->m_fppp->getRowNamaDivisi($param)->divisi_pendek;
		$nofppp      = str_pad($this->m_fppp->getNoFppp($param), 3, '0', STR_PAD_LEFT) . '/FPPP/' . $nama_divisi . '/' . date('m') . '/' . date('Y');

		$datapost = array(
			'id_divisi'              => $this->input->post('id_divisi'),
			'tgl_pembuatan'          => $this->input->post('tgl_pembuatan'),
			'no_fppp'                => $nofppp,
			'applicant'              => $this->input->post('applicant'),
			'applicant_sector'       => $this->input->post('applicant_sector'),
			'authorized_distributor' => $this->input->post('authorized_distributor'),
			'type_fppp'              => $this->input->post('type_fppp'),
			'tahap_produksi'         => $this->input->post('tahap_produksi'),
			'nama_aplikator'         => $this->input->post('nama_aplikator'),
			'nama_proyek'            => $this->input->post('nama_proyek'),
			'tahap'                  => $this->input->post('tahap'),
			'alamat_proyek'          => $this->input->post('alamat_proyek'),
			'status_order'           => $this->input->post('status_order'),
			'note_ncr'               => $this->input->post('note_ncr'),
			'id_pengiriman'          => $this->input->post('id_pengiriman'),
			'deadline_pengiriman'    => $this->input->post('deadline_pengiriman'),
			'id_metode_pengiriman'   => $this->input->post('id_metode_pengiriman'),
			'id_penggunaan_peti'     => $this->input->post('id_penggunaan_peti'),
			'id_penggunaan_sealant'  => $this->input->post('id_penggunaan_sealant'),
			'id_warna_aluminium'     => $this->input->post('id_warna_aluminium'),
			'id_warna_lainya'        => $this->input->post('id_warna_lainya'),
			'warna_sealant'          => $this->input->post('warna_sealant'),
			'ditujukan_kepada'       => $this->input->post('ditujukan_kepada'),
			'no_telp_tujuan'         => $this->input->post('no_telp_tujuan'),
			'pengiriman_ekspedisi'   => $this->input->post('pengiriman_ekspedisi'),
			'alamat_ekspedisi'       => $this->input->post('alamat_ekspedisi'),
			'sales'                  => $this->input->post('sales'),
			'pic_project'            => $this->input->post('pic_project'),
			'admin_koordinator'      => $this->input->post('admin_koordinator'),
			'id_kaca'                => $this->input->post('id_kaca'),
			'jenis_kaca'             => $this->input->post('jenis_kaca'),
			'id_logo_kaca'           => $this->input->post('id_logo_kaca'),
			'jumlah_gambar'          => $this->input->post('jumlah_gambar'),
			'jumlah_unit'            => $this->input->post('jumlah_unit'),
			'note'                   => $this->input->post('note'),
			'updated'                => date('Y-m-d H:i:s'),
		);
		$this->m_fppp->updateFppp($id_fppp, $datapost);
		$data['id'] = $id_fppp;
		$this->fungsi->catat($datapost, "Menyimpan fppp sbb:", true);
		$data['msg'] = "fppp Disimpan";
		echo json_encode($data);
	}

	public function updatefpppImage($value = '')
	{
		$this->fungsi->check_previleges('fppp');
		$id_fppp       = $this->input->post('id_fppp');
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
			$data        = $this->upload->data();
			$param       = $this->input->post('id_divisi');
			$nama_divisi = $this->m_fppp->getRowNamaDivisi($param)->divisi_pendek;
			$nofppp      = str_pad($this->m_fppp->getNoFppp($param), 3, '0', STR_PAD_LEFT) . '/FPPP/' . $nama_divisi . '/' . date('m') . '/' . date('Y');

			$datapost = array(
				'id_divisi'              => $this->input->post('id_divisi'),
				'tgl_pembuatan'          => $this->input->post('tgl_pembuatan'),
				'applicant'              => $this->input->post('applicant'),
				'applicant_sector'       => $this->input->post('applicant_sector'),
				'authorized_distributor' => $this->input->post('authorized_distributor'),
				'no_fppp'                => $nofppp,
				'nama_proyek'            => $this->input->post('nama_proyek'),
				'tahap'                  => $this->input->post('tahap'),
				'alamat_proyek'          => $this->input->post('alamat_proyek'),
				'status_order'           => $this->input->post('status_order'),
				'note_ncr'               => $this->input->post('note_ncr'),
				'id_pengiriman'          => $this->input->post('id_pengiriman'),
				'deadline_pengiriman'    => $this->input->post('deadline_pengiriman'),
				'id_metode_pengiriman'   => $this->input->post('id_metode_pengiriman'),
				'id_penggunaan_peti'     => $this->input->post('id_penggunaan_peti'),
				'id_penggunaan_sealant'  => $this->input->post('id_penggunaan_sealant'),
				'id_warna_aluminium'     => $this->input->post('id_warna_aluminium'),
				'id_warna_lainya'        => $this->input->post('id_warna_lainya'),
				'warna_sealant'          => $this->input->post('warna_sealant'),
				'ditujukan_kepada'       => $this->input->post('ditujukan_kepada'),
				'no_telp_tujuan'         => $this->input->post('no_telp_tujuan'),
				'pengiriman_ekspedisi'   => $this->input->post('pengiriman_ekspedisi'),
				'alamat_ekspedisi'       => $this->input->post('alamat_ekspedisi'),
				'sales'                  => $this->input->post('sales'),
				'pic_project'            => $this->input->post('pic_project'),
				'admin_koordinator'      => $this->input->post('admin_koordinator'),
				'id_kaca'                => $this->input->post('id_kaca'),
				'jenis_kaca'             => $this->input->post('jenis_kaca'),
				'id_logo_kaca'           => $this->input->post('id_logo_kaca'),
				'jumlah_gambar'          => $this->input->post('jumlah_gambar'),
				'jumlah_unit'            => $this->input->post('jumlah_unit'),
				'lampiran'               => substr($upload_folder, 2) . $data['file_name'],
				'note'                   => $this->input->post('note'),
				'updated'                => date('Y-m-d H:i:s'),
			);
			$this->m_fppp->updateFppp($id_fppp, $datapost);
			$data['id'] = $id_fppp;
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
		echo json_encode($data);
	}

	public function getDetailTabel($value = '')
	{
		$this->fungsi->check_previleges('fppp');
		$id_fppp = $this->input->post('id_fppp');
		$data['detail'] = $this->m_fppp->getDataDetailTabel($id_fppp);
		echo json_encode($data);
	}

	public function updateDetail()
	{
		$this->fungsi->check_previleges('fppp');
		$id    = $this->input->post('id');
		$kolom = $this->input->post('kolom');
		$nilai = $this->input->post('nilai');
		if ($nilai != '') {
			$sts = 1;
		} else {
			$sts = 0;
		}

		$id_fppp = $this->m_fppp->getIdFppp($id);
		if ($kolom == 1) {
			$datapost = array('produksi_aluminium' => $nilai,);
		} elseif ($kolom == 2) {
			$datapost = array('qc_cek' => $nilai,);
		} elseif ($kolom == 3) {
			$datapost = array('pengiriman' => $nilai, 'pengiriman_sts' => $sts,);
		} elseif ($kolom == 4) {
			$datapost = array('pasang' => $nilai, 'pasang_sts' => $sts,);
		} else {
			$datapost = array('bst' => $nilai,);
		}
		$this->m_fppp->updateDetail($id, $datapost);

		$jml_baris = $this->m_fppp->getJmlBaris($id_fppp);
		if ($kolom == 3) {
			$jml_sts_pengiriman = $this->m_fppp->getJmlStsPengiriman($id_fppp);
			$txt_ws             = $this->m_fppp->updatews($id, $jml_baris, $jml_sts_pengiriman, $id_fppp);
			$respon['txt_ws_update']    = $txt_ws;
		}

		if ($kolom == 4) {
			$jml_sts_pasang    = $this->m_fppp->getJmlStsPasang($id_fppp);
			$txt_site          = $this->m_fppp->updatesite($id, $jml_baris, $jml_sts_pasang, $id_fppp);
			$respon['txt_site_update'] = $txt_site;
		}


		$respon['msg']     = "sukses update";
		$respon['nilai']   = $nilai;
		$respon['id_fppp'] = $id_fppp;
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
				$obj = array(
					'id_jenis_item'   => 1,
					'section_ata'     => $rowData[0][0],
					'section_allure'  => $rowData[0][1],
					'temper'          => $rowData[0][2],
					'kode_warna'      => $rowData[0][3],
					'ukuran'          => $rowData[0][4],
					'satuan'          => $rowData[0][5],
					'created'         => date('Y-m-d H:i:s'),
				);
				$qty = $rowData[0][6];
				$keterangan = $rowData[0][7];
				$cek_item = $this->m_fppp->getMasterAluminium($obj['section_ata'], $obj['section_allure'], $obj['temper'], $obj['kode_warna'], $obj['ukuran']);
				if ($cek_item->num_rows() < 1) {
					$this->m_fppp->simpanItem($obj);
					$id_item = $this->db->insert_id();
				} else {
					$id_item = $cek_item->row()->id;
				}
			} else if ($jenis_bom == 2) {
				$obj = array(
					'id_jenis_item' => 2,
					'item_code'     => $rowData[0][0],
					'deskripsi'     => $rowData[0][1],
					'satuan'        => $rowData[0][2],
					'created'       => date('Y-m-d H:i:s'),
				);
				$qty = $rowData[0][3];
				$keterangan = $rowData[0][4];
				$cek_item = $this->m_fppp->getMasterAksesoris($obj['item_code']);
				if ($cek_item->num_rows() < 1) {
					$this->m_fppp->simpanItem($obj);
					$id_item = $this->db->insert_id();
				} else {
					$id_item = $cek_item->row()->id;
				}
			} else {
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
				$qty = $rowData[0][6];
				$keterangan = $rowData[0][7];
				$cek_item = $this->m_fppp->getMasterLembaran($obj['nama_barang']);
				if ($cek_item->num_rows() < 1) {
					$this->m_fppp->simpanItem($obj);
					$id_item = $this->db->insert_id();
				} else {
					$id_item = $cek_item->row()->id;
				}
			}

			$obj_bom = array(
				'id_fppp'   => $id_fppp,
				'id_jenis_item'   => $jenis_bom,
				'id_item'   => $id_item,
				'qty'   => $qty,
				'keterangan'   => $keterangan,
				'created'   => date('Y-m-d H:i:s'),
			);
			$this->db->insert('data_fppp_bom', $obj_bom);
		}
		unlink($inputFileName);
		$data['msg'] = "Data BOM Baru Disimpan....";
		echo json_encode($data);
	}

	public function lihatbom($id_fppp, $param)
	{
		$this->fungsi->check_previleges('fppp');
		$data['bom_aluminium'] = $this->m_fppp->bom_aluminium($id_fppp);
		$data['bom_aksesoris'] = $this->m_fppp->bom_aksesoris($id_fppp);
		$data['bom_lembaran']  = $this->m_fppp->bom_lembaran($id_fppp);
		$data['param']         = $param;
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
				'jumlah_unit'           => $this->input->post('jumlah_unit'),
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

	public function deleteItem()
	{
		$this->fungsi->check_previleges('fppp');
		$id   = $this->input->post('id');
		$data = array('id' => $id,);

		$this->m_fppp->deleteDetailItem($id);
		$this->fungsi->catat($data, "Menghapus FPPP Detail dengan data sbb:", true);
		$respon = ['msg' => 'Data Berhasil Dihapus'];
		echo json_encode($respon);
	}

	public function editItem($value = '')
	{
		$this->fungsi->check_previleges('fppp');
		$id      = $this->input->post('id');
		$getData = $this->m_fppp->getDetailFppp($id);
		$respon  = [
			'id_fppp'        => $getData->id_fppp,
			'id_brand'       => $getData->id_brand,
			'kode_opening'   => $getData->kode_opening,
			'kode_unit'      => $getData->kode_unit,
			'id_item'        => $getData->id_item,
			'glass_thick'    => $getData->glass_thick,
			'finish_coating' => $getData->finish_coating,
			'qty'            => $getData->qty,
			'msg'            => 'Data Berhasil Diubah',
		];
		echo json_encode($respon);
	}

	public function updateItemDetail($value = '')
	{
		$this->fungsi->check_previleges('fppp');
		$id       = $this->input->post('id');
		$datapost = array(
			'id_brand'       => $this->input->post('id_brand'),
			'kode_opening'   => $this->input->post('kode_opening'),
			'kode_unit'      => $this->input->post('kode_unit'),
			'id_item'        => $this->input->post('id_item'),
			'glass_thick'    => $this->input->post('glass_thick'),
			'finish_coating' => $this->input->post('finish_coating'),
			'qty'            => $this->input->post('qty'),
		);

		$this->m_fppp->updateFpppDetail($datapost, $id);
		$this->fungsi->catat($datapost, "Mengubah detail FPPP sbb:", true);
		$respon = [
			'id' => $id,
		];
		echo json_encode($respon);
	}

	public function cetak($id)
	{
		$data = array(
			'id'     => $id,
			'header' => $this->m_fppp->getRowFppp($id)->row(),
		);
		// print_r($data['header']);
		// die();
		$this->load->view('klg/fppp/v_cetak', $data);
	}
}

/* End of file fppp.php */
/* Location: ./application/controllers/klg/fppp.php */