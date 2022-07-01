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
		$this->load->model('wrh/m_aksesoris');
		$this->load->model('wrh/m_aluminium');
	}

	public function index()
	{
		$this->fungsi->check_previleges('fppp');
		$bulan = date('m');
		$tahun = date('Y');
		if ($this->session->userdata('tgl_awal') != '') {
			$tgl['tgl_awal'] = $this->session->userdata('tgl_awal');
		} else {
			$tgl['tgl_awal'] = date('Y-m-d', strtotime('-3 month', strtotime($tahun . '-' . $bulan . '-01')));
		}

		if ($this->session->userdata('tgl_akhir') != '') {
			$tgl['tgl_akhir'] = $this->session->userdata('tgl_akhir');
		} else {
			$tgl['tgl_akhir'] = date("Y-m-t", strtotime($tahun . '-' . $bulan . '-01'));
		}

		// $tgl['tgl_awal']  = $tahun . '-' . $bulan . '-01';


		$this->session->set_userdata($tgl);

		$data['param_tab'] = '1';
		$data['divisi']    = $this->db->get('master_divisi');
		$data['is_memo']   = 'fppp';
		$this->load->view('klg/fppp/v_fppp_tab', $data);
	}

	public function filter($param, $tgl_awal, $tgl_akhir)
	{
		$this->fungsi->check_previleges('fppp');

		$tgl['tgl_awal']  = $tgl_awal;
		$tgl['tgl_akhir'] = $tgl_akhir;

		$this->session->set_userdata($tgl);

		$data['param_tab'] = $param;
		$data['divisi']    = $this->db->get('master_divisi');
		$data['is_memo']   = 'fppp';
		$this->load->view('klg/fppp/v_fppp_tab', $data);
	}

	public function cetakFppp($param, $tgl_awal, $tgl_akhir)
	{
		$this->fungsi->check_previleges('fppp');

		$data['tgl_awal']       = $tgl_awal;
		$data['tgl_akhir']      = $tgl_akhir;
		$data['fppp']           = $this->m_fppp->getData($param);
		$data['get_total_hold'] = $this->m_fppp->getTotalHold();
		// $data['param_tab']          = $param;
		$data['param']   = $param;
		$data['memo']    = 1;
		$data['is_memo'] = 'fppp';
		$this->load->view('klg/fppp/v_fppp_cetak', $data);
	}

	public function hasil_finish($param)
	{
		$this->fungsi->check_previleges('fppp');
		$data['param_tab'] = $param;
		$data['divisi']    = $this->db->get('master_divisi');
		$data['is_memo']   = 'fppp';
		$this->load->view('klg/fppp/v_fppp_tab', $data);
	}

	public function hasil_finish_edit($param, $id_fppp)
	{
		$this->fungsi->check_previleges('fppp');
		$datapost = array(
			'tgl_modified' => date('Y-m-d H:i:s'),
		);
		$this->m_fppp->updateFppp($id_fppp, $datapost);
		$data['param_tab'] = $param;
		$data['divisi']    = $this->db->get('master_divisi');
		$data['is_memo']   = 'fppp';
		$this->load->view('klg/fppp/v_fppp_tab', $data);
	}

	public function list($param = '')
	{
		$this->fungsi->check_previleges('fppp');
		$data['tgl_awal']       = $this->session->userdata('tgl_awal');
		$data['tgl_akhir']      = $this->session->userdata('tgl_akhir');
		$data['fppp']           = $this->m_fppp->getData($param);
		$data['get_total_hold'] = $this->m_fppp->getTotalHold();
		$data['param']          = $param;
		$data['memo']           = 1;
		$data['is_memo']        = 'fppp';
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
		$data['proyek']             = $this->db->get('master_proyek');
		$data['divisi']             = get_options($this->db->get('master_divisi'), 'id', 'divisi');
		$data['pengiriman']         = get_options($this->db->get('master_pengiriman'), 'id', 'pengiriman');
		$data['metode_pengiriman']  = get_options($this->db->get('master_metode_pengiriman'), 'id', 'metode_pengiriman');
		$data['penggunaan_peti']    = get_options($this->db->get('master_penggunaan_peti'), 'id', 'penggunaan_peti');
		$data['penggunaan_sealant'] = get_options($this->db->get('master_penggunaan_sealant'), 'id', 'penggunaan_sealant');
		$data['warna']              = get_options($this->db->get('master_warna'), 'id', 'warna');
		$data['warna_lainya']       = get_options($this->db->get('master_warna'), 'id', 'warna');
		$data['logo_kaca']          = get_options($this->db->get('master_logo_kaca'), 'id', 'logo_kaca');
		$data['kaca']               = get_options($this->db->get('master_kaca'), 'id', 'kaca');
		$data['brand']              = get_options($this->db->get('master_brand'), 'id', 'brand', true);
		$data['item']               = get_options($this->db->get('master_barang'), 'id', 'barang', true);
		$data['brand_edit']         = $this->db->get('master_brand');
		$data['multi_brand']        = get_options($this->db->get('master_brand'), 'id', 'brand');
		$data['warna_edit']         = $this->db->get('master_warna');
		$data['item_edit']          = $this->db->get('master_barang');
		$data['param']              = $param;
		$data['is_memo']            = 'fppp';
		$nama_divisi          = $this->m_fppp->getRowNamaDivisi($param)->divisi_pendek;
		$data['no_fppp']            = str_pad($this->m_fppp->getNoFppp($param), 3, '0', STR_PAD_LEFT) . '/FPPP/' . $nama_divisi . '/' . date('m') . '/' . date('Y');
		$this->load->view('klg/fppp/v_fppp_add', $data);
	}

	public function deleteFPPP($id, $is_memo)
	{
		$this->fungsi->check_previleges('fppp');
		// sleep(1);
		$cek = $this->m_fppp->getNumRow($id);
		if ($cek == 0) {
			$data = array('id' => $id,);
			$this->db->where('id', $id);
			$this->db->delete('data_fppp');

			$this->fungsi->catat($data, "Menghapus " . $is_memo . " dengan data sbb:", true);
			$this->fungsi->message_box("Menghapus " . $is_memo . "", "success");
		} else {
			$this->fungsi->message_box("" . $is_memo . " sudah pernah terkirim", "warning");
		}
		if ($is_memo == 'fppp') {
			$this->fungsi->run_js('load_silent("klg/fppp/","#content")');
		} elseif ($is_memo == 'memo') {
			$this->fungsi->run_js('load_silent("klg/memo/","#content")');
		} else {
			$this->fungsi->run_js('load_silent("klg/mockup/","#content")');
		}
	}

	public function formEdit($id = '')
	{
		$this->fungsi->check_previleges('fppp');
		$param                = $this->m_fppp->getRowFppp($id)->row()->id_divisi;
		$cek_id_terakhir      = $this->m_fppp->cekIdTerakhir($param)->row()->id;
		$data['is_edit']            = ($cek_id_terakhir == $id) ? '' : 'readonly';
		$data['proyek']             = $this->db->get('master_proyek');
		$data['divisi']             = get_options($this->db->get('master_divisi'), 'id', 'divisi');
		$data['pengiriman']         = get_options($this->db->get('master_pengiriman'), 'id', 'pengiriman');
		$data['metode_pengiriman']  = get_options($this->db->get('master_metode_pengiriman'), 'id', 'metode_pengiriman');
		$data['penggunaan_peti']    = get_options($this->db->get('master_penggunaan_peti'), 'id', 'penggunaan_peti');
		$data['penggunaan_sealant'] = get_options($this->db->get('master_penggunaan_sealant'), 'id', 'penggunaan_sealant');
		$data['warna']              = get_options($this->db->get('master_warna'), 'id', 'warna');
		$data['warna_lainya']       = get_options($this->db->get('master_warna'), 'id', 'warna');
		$data['logo_kaca']          = get_options($this->db->get('master_logo_kaca'), 'id', 'logo_kaca');
		$data['kaca']               = get_options($this->db->get('master_kaca'), 'id', 'kaca');
		$data['brand']              = get_options($this->db->get('master_brand'), 'id', 'brand', true);
		$data['item']               = get_options($this->db->get('master_barang'), 'id', 'barang', true);
		$data['brand_edit']         = $this->db->get('master_brand');
		$data['multi_brand']        = get_options($this->db->get('master_brand'), 'id', 'brand');
		$data['warna_edit']         = $this->db->get('master_warna');
		$data['item_edit']          = $this->db->get('master_barang');
		// $this->db->get_where('mytable', array('id' => $id), $limit, $offset);
		$data['param']           = $param;
		$data['is_memo']         = 'fppp';
		$data['row']             = $this->m_fppp->getRowFppp($id)->row();
		$data['detail']          = $this->m_fppp->getRowFpppDetail($id);
		$data['sudah_transaksi'] = $this->m_fppp->getNumSuratJalan($id);
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
			'multi_brand'            => $this->input->post('multi_brand'),
			'no_fppp'                => $nofppp,
			'no_co'                  => $this->input->post('no_co'),
			'applicant'              => $this->input->post('applicant'),
			'applicant_sector'       => $this->input->post('applicant_sector'),
			'authorized_distributor' => $this->input->post('authorized_distributor'),
			'type_fppp'              => $this->input->post('type_fppp'),
			'tahap_produksi'         => $this->input->post('tahap_produksi'),
			'nama_aplikator'         => $this->input->post('nama_aplikator'),
			'kode_proyek'            => $this->input->post('kode_proyek'),
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
			'id_warna'               => $this->input->post('id_warna'),
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


		$mbq = explode("-", $this->input->post('multi_brand'));
		$this->db->where_in('id', $mbq);
		$res_brand = $this->db->get('master_brand')->result();
		$b         = array();
		foreach ($res_brand as $keyq) {
			$b[] = '*' . $keyq->brand . '<br>';
		};
		$data_multi_brand_string = array('multi_brand_string' => implode($b));
		$this->m_fppp->updateFppp($data['id'], $data_multi_brand_string);

		$cek_kode_proyek = $this->m_fppp->cekKodeProyek($datapost['kode_proyek'])->num_rows();
		if ($cek_kode_proyek < 1) {
			$obj_py = array(
				'kode_proyek' => str_replace(' ', '',  $datapost['kode_proyek']),
				'created'     => date('Y-m-d H:i:s'),
				'updated'     => date('Y-m-d H:i:s'),
			);
			$this->db->insert('data_fppp_finance', $obj_py);
		}
		$this->fungsi->catat($datapost, "Menyimpan fppp sbb:", true);
		$data['msg'] = "fppp Disimpan";
		echo json_encode($data);
	}

	public function savefpppImage($value = '')
	{
		$this->fungsi->check_previleges('fppp');
		$upload_folder = get_upload_folder('./files/');

		$config['upload_path']   = $upload_folder;
		$config['allowed_types'] = 'pdf|xlsx|xls|doc|docx|jpeg|jpg|png';
		$config['max_size']      = '35840';
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
				'multi_brand'            => $this->input->post('multi_brand'),
				'no_fppp'                => $nofppp,
				'no_co'                  => $this->input->post('no_co'),
				'kode_proyek'            => $this->input->post('kode_proyek'),
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
				'id_warna'               => $this->input->post('id_warna'),
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

			$mbq = explode("-", $this->input->post('multi_brand'));
			$this->db->where_in('id', $mbq);
			$res_brand = $this->db->get('master_brand')->result();
			$b         = array();
			foreach ($res_brand as $keyq) {
				$b[] = '*' . $keyq->brand . '<br>';
			};
			$data_multi_brand_string = array('multi_brand_string' => implode($b));
			$this->m_fppp->updateFppp($data['id'], $data_multi_brand_string);

			$cek_kode_proyek = $this->m_fppp->cekKodeProyek($datapost['kode_proyek'])->num_rows();
			if ($cek_kode_proyek < 1) {
				$obj_py = array(
					'kode_proyek' => $datapost['kode_proyek'],
					'created'     => date('Y-m-d H:i:s'),
					'updated'     => date('Y-m-d H:i:s'),
				);
				$this->db->insert('data_fppp_finance', $obj_py);
			}
			$this->fungsi->catat($datapost, "Menyimpan fppp dengan file sbb:", true);
			$data['msg'] = "fppp Disimpan";
			echo json_encode($data);
		}
	}

	public function updatefppp($value = '')
	{
		$this->fungsi->check_previleges('fppp');
		$id_fppp = $this->input->post('id_fppp');



		$datapost = array(
			'id_divisi'              => $this->input->post('id_divisi'),
			'tgl_pembuatan'          => $this->input->post('tgl_pembuatan'),
			'applicant'              => $this->input->post('applicant'),
			'applicant_sector'       => $this->input->post('applicant_sector'),
			'authorized_distributor' => $this->input->post('authorized_distributor'),
			'multi_brand'            => $this->input->post('multi_brand'),
			'no_fppp'                => $this->input->post('no_fppp'),
			'applicant'              => $this->input->post('applicant'),
			'no_co'                  => $this->input->post('no_co'),
			'applicant_sector'       => $this->input->post('applicant_sector'),
			'authorized_distributor' => $this->input->post('authorized_distributor'),
			'type_fppp'              => $this->input->post('type_fppp'),
			'tahap_produksi'         => $this->input->post('tahap_produksi'),
			'nama_aplikator'         => $this->input->post('nama_aplikator'),
			'kode_proyek'            => $this->input->post('kode_proyek'),
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
			'id_warna'               => $this->input->post('id_warna'),
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
			'tgl_modified'           => date('Y-m-d H:i:s'),
		);
		$this->m_fppp->updateFppp($id_fppp, $datapost);
		$data['id'] = $id_fppp;

		$mbq = explode("-", $this->input->post('multi_brand'));
		$this->db->where_in('id', $mbq);
		$res_brand = $this->db->get('master_brand')->result();
		$b         = array();
		foreach ($res_brand as $keyq) {
			$b[] = '*' . $keyq->brand . '<br>';
		};
		$data_multi_brand_string = array('multi_brand_string' => implode($b));
		$this->m_fppp->updateFppp($data['id'], $data_multi_brand_string);

		$this->fungsi->catat($datapost, "Mengupdate fppp sbb:", true);
		$data['msg'] = "fppp Disimpan";
		echo json_encode($data);
	}

	public function updatefpppImage($value = '')
	{
		$this->fungsi->check_previleges('fppp');
		$id_fppp       = $this->input->post('id_fppp');
		$upload_folder = get_upload_folder('./files/');

		$config['upload_path']   = $upload_folder;
		$config['allowed_types'] = 'pdf|xlsx|xls|doc|docx|jpeg|jpg|png';
		$config['max_size']      = '35840';
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
				'multi_brand'            => $this->input->post('multi_brand'),
				'no_fppp'                => $this->input->post('no_fppp'),
				'no_co'                  => $this->input->post('no_co'),
				'kode_proyek'            => $this->input->post('kode_proyek'),
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
				'id_warna'               => $this->input->post('id_warna'),
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

			$mbq = explode("-", $this->input->post('multi_brand'));
			$this->db->where_in('id', $mbq);
			$res_brand = $this->db->get('master_brand')->result();
			$b         = array();
			foreach ($res_brand as $keyq) {
				$b[] = '*' . $keyq->brand . '<br>';
			};
			$data_multi_brand_string = array('multi_brand_string' => implode($b));
			$this->m_fppp->updateFppp($data['id'], $data_multi_brand_string);

			$this->fungsi->catat($datapost, "Mengupdate fppp dengan file sbb:", true);
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

	public function savefpppDetailedit($value = '')
	{
		$this->fungsi->check_previleges('fppp');
		$id_fppp  = $this->input->post('id_fppp');
		$datapost = array(
			'tgl_modified' => date('Y-m-d H:i:s'),
		);
		$this->m_fppp->updateFppp($id_fppp, $datapost);
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

		$multi_brand        = $this->m_fppp->getRowFppp($id_fppp)->row()->multi_brand;
		$multi_brand_string = $this->m_fppp->getRowFppp($id_fppp)->row()->multi_brand_string;

		if ($multi_brand != '' && $multi_brand_string == '') {
			$mbq = explode("-", $multi_brand);
			$this->db->where_in('id', $mbq);
			$res_brand = $this->db->get('master_brand')->result();
			$b         = array();
			foreach ($res_brand as $keyq) {
				$b[] = '*' . $keyq->brand . '<br>';
			};
			$data_multi_brand_string = array('multi_brand_string' => implode($b));
			$this->m_fppp->updateFppp($id_fppp, $data_multi_brand_string);
		}

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
		} elseif ($kolom == 10) {
			if ($nilai == 'hold' || $nilai == 'revisi') {
				$sts_hold = 1;
			} else {
				$sts_hold = 0;
			}
			$datapost = array('hold' => $nilai, 'hold_sts' => $sts_hold,);
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

		if ($kolom == 5) {
			$jml_sts_bst           = $this->m_fppp->getJmlStsBST($id_fppp);
			$txt_site              = $this->m_fppp->updatesitebst($id, $jml_baris, $jml_sts_bst, $id_fppp);
			$respon['txt_site_bst_update'] = $txt_site;
		}


		$respon['msg']     = "sukses update";
		$respon['nilai']   = $nilai;
		$respon['id_fppp'] = $id_fppp;
		echo json_encode($respon);
	}

	public function uploadbom($id = '')
	{
		$data['id']        = $id;
		$data['id_divisi'] = $this->m_fppp->getRowFppp($id)->row()->id_divisi;
		$data['rowFppp']   = $this->m_fppp->getRowFppp($id)->row();
		$this->load->view('klg/fppp/v_uploadbom', $data);
	}

	public function uploadmasterstock($id = '')
	{
		$data['id']         = $id;
		$data['jenis_item'] = $this->db->get('master_jenis_item');;
		$this->load->view('klg/fppp/v_uploadmasterstock', $data);
	}

	public function save_uploadmasterstock()
	{
		$fileName = time();

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

		$jenis_item  = $this->input->post('jenis_item');
		$tipe_upload = $this->input->post('tipe_upload');
		$awal_bulan  = $this->input->post('awal_bulan');

		if ($highestRow < 3001) {
			for ($row = 2; $row <= $highestRow; $row++) {                  //  Read a row of data into an array
				$rowData = $sheet->rangeToArray(
					'A' . $row . ':' . $highestColumn . $row,
					NULL,
					TRUE,
					FALSE
				);

				if ($jenis_item == 1) {
					$itmcode = $rowData[0][8] . '-' . $rowData[0][9] . '-' . $rowData[0][10] . '-' . str_pad($rowData[0][11], 2, '0', STR_PAD_LEFT) . '-' . $rowData[0][12];
				}else{
					$itmcode = str_replace(' ', '', $rowData[0][1]);
				}

				$obj = array(
					'id_jenis_item'     => $jenis_item,
					'item_code'         => $itmcode,
					'deskripsi'         => $rowData[0][2],
					'satuan'            => $rowData[0][3],
					'id_divisi'         => $rowData[0][4],
					'id_gudang'         => $rowData[0][5],
					'keranjang'         => $rowData[0][6],
					'qty'         => $rowData[0][7],
					'section_ata'       => $rowData[0][8],
					'section_allure'    => $rowData[0][9],
					'temper'            => $rowData[0][10],
					'kode_warna'        => str_pad($rowData[0][11], 2, '0', STR_PAD_LEFT),
					'ukuran'            => $rowData[0][12],
					'perimeter_berat'   => $rowData[0][13],
					'perimeter_mf'      => $rowData[0][14],
					'perimeter_coating' => $rowData[0][15],
					'lebar'             => $rowData[0][16],
					'tinggi'            => $rowData[0][17],
					'tebal'            => $rowData[0][18],
					'area'            => $rowData[0][19],
					'ket'               => 'upload',
					'created'           => date('Y-m-d H:i:s'),
				);

				$obj_master = array(
					'id_jenis_item'     => $jenis_item,
					'item_code'         => $itmcode,
					'deskripsi'         => $rowData[0][2],
					'satuan'            => $rowData[0][3],
					'section_ata'       => $rowData[0][8],
					'section_allure'    => $rowData[0][9],
					'temper'            => $rowData[0][10],
					'kode_warna'        => str_pad($rowData[0][11], 2, '0', STR_PAD_LEFT),
					'ukuran'            => $rowData[0][12],
					'perimeter_berat'   => $rowData[0][13],
					'perimeter_mf'      => $rowData[0][14],
					'perimeter_coating' => $rowData[0][15],
					'lebar'             => $rowData[0][16],
					'tinggi'            => $rowData[0][17],
					'tebal'            => $rowData[0][18],
					'area'            => $rowData[0][19],
					'ket'               => 'upload',
					'created'           => date('Y-m-d H:i:s'),
				);

				$cek_item = $this->m_fppp->cekItemCode($obj['id_jenis_item'], $obj['item_code']);
				if ($tipe_upload == 1) {
					if ($cek_item->num_rows() < 1) {
						$this->db->insert('master_item', $obj_master);
					} 
					// else {
					// 	$this->db->where('item_code', $obj['item_code']);
					// 	$this->db->where('id_jenis_item', $obj['id_jenis_item']);
					// 	$this->db->update('master_item', $obj_master);
					// }
				} else {
					$iditem  = $cek_item->row()->id;
					$krjng = ($obj['keranjang']!='') ? $obj['keranjang'] : '-' ;
					$counter = array(
						'id_jenis_item' => $obj['id_jenis_item'],
						'id_item'       => $iditem,
						'id_divisi'     => $obj['id_divisi'],
						'id_gudang'     => $obj['id_gudang'],
						'keranjang'     => str_replace(' ', '-', $krjng),
						'qty'           => $obj['qty'],
						'created'       => date('Y-m-d H:i:s'),
						'updated'       => date('Y-m-d H:i:s'),
						'itm_code'      => str_replace(' ', '', $obj['item_code']),
						'keterangan'      => 'upload_stock',
					);
					$cekQtyCounter = $this->m_fppp->cekCounter($obj['id_jenis_item'], $obj['item_code'], $obj['id_divisi'], $obj['id_gudang'], $obj['keranjang']);
					if ($cekQtyCounter->num_rows() == 0) {
						$this->db->insert('data_counter', $counter);
					} else {
						$qty_sebelum = $cekQtyCounter->row()->qty;
						$qty_jadi      = (int)$qty_sebelum + (int)$obj['qty'];
						$this->m_fppp->updateCounter($obj['id_jenis_item'], $obj['item_code'], $obj['id_divisi'], $obj['id_gudang'], $obj['keranjang'], $qty_jadi);
					}

					$transaksi = array(
						'inout'         => 1,
						'awal_bulan'    => $awal_bulan,
						'id_jenis_item' => $obj['id_jenis_item'],
						'id_item'       => $iditem,
						'id_divisi'     => $obj['id_divisi'],
						'id_gudang'     => $obj['id_gudang'],
						'keranjang'     => str_replace(' ', '-', $krjng),
						'qty_in'        => $obj['qty'],
						'created'       => date('Y-m-d H:i:s'),
						'updated'       => date('Y-m-d H:i:s'),
						'aktual'        => date('Y-m-d'),
						'id_penginput'  => from_session('id'),
						'itm_code'      => str_replace(' ', '', $obj['item_code']),
						'keterangan'    => 'upload stok',
					);
					$this->db->insert('data_stock', $transaksi);
				}
			}
			$data['msg'] = "Data Disimpan....";
		} else {
			$data['msg'] = "Data melebihi 3000 row";
		}
		echo json_encode($data);
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

		$id_fppp   = $this->input->post('id');
		$jenis_bom = $this->input->post('jenis_bom');
		// $cek_sudah_ada_keluar = $this->m_fppp->cekSudahAdaKeluar($id_fppp);
		// if ($cek_sudah_ada_keluar == 0) {
		$this->m_fppp->deleteBomSebelum($id_fppp, $jenis_bom);
		$this->m_fppp->delete_temp($id_fppp, $jenis_bom);
		// }

		for ($row = 2; $row <= $highestRow; $row++) {                  //  Read a row of data into an array
			$rowData = $sheet->rangeToArray(
				'A' . $row . ':' . $highestColumn . $row,
				NULL,
				TRUE,
				FALSE
			);

			if ($jenis_bom == 1) {
				$obj = array(
					'id_jenis_item'  => 1,
					'id_multi_brand' => $rowData[0][0],
					'section_ata'    => $rowData[0][1],
					'section_allure' => $rowData[0][2],
					'temper'         => $rowData[0][3],
					'kode_warna'     => str_pad($rowData[0][4], 2, '0', STR_PAD_LEFT),
					'ukuran'         => $rowData[0][5],
					'satuan'         => $rowData[0][6],
					'created'        => date('Y-m-d H:i:s'),
				);
				$qty        = $rowData[0][7];
				$keterangan = $rowData[0][8];

				if ($obj['ukuran'] != '') {

					$cek_item = $this->m_fppp->getMasterAluminium($obj['section_ata'], $obj['section_allure'], $obj['temper'], $obj['kode_warna'], $obj['ukuran']);
					if ($cek_item->num_rows() < 1) {
						$temp = array(
							"item_code"     => $obj['section_ata'] . '-' . $obj['section_allure'] . '-' . $obj['temper'] . '-' . str_pad($obj['kode_warna'], 2, '0', STR_PAD_LEFT) . '-' . $obj['ukuran'],
							"id_penginput"  => from_session('id'),
							"id_fppp"       => $id_fppp,
							"id_jenis_item" => $jenis_bom,
						);
						$this->db->insert('data_temp', $temp);
					} else {
						$id_item = $cek_item->row()->id;
						$obj_bom = array(
							'is_bom'         => 1,
							'inout'          => 0,
							'id_fppp'        => $id_fppp,
							'id_jenis_item'  => $jenis_bom,
							'id_item'        => $id_item,
							'qty_bom'        => $qty,
							'keterangan'     => $keterangan,
							'id_multi_brand' => $obj['id_multi_brand'],
							'created'        => date('Y-m-d H:i:s'),
						);
						$this->db->insert('data_stock', $obj_bom);
					}
					$dt = array(
						'bom_aluminium'            => 1,
						'tgl_upload_bom_aluminium' => date('Y-m-d H:i:s'),
					);
					$this->m_fppp->updateStatusUploadBom($id_fppp, $dt);
				}
			} else if ($jenis_bom == 2) {
				$obj = array(
					'id_jenis_item'  => 2,
					'item_code'      => $rowData[0][0],
					'deskripsi'      => $rowData[0][1],
					'satuan'         => $rowData[0][2],
					'id_multi_brand' => $rowData[0][5],
					'created'        => date('Y-m-d H:i:s'),
				);
				$qty        = $rowData[0][3];
				$keterangan = $rowData[0][4];
				if ($obj['item_code'] != '') {
					$cek_item = $this->m_fppp->getMasterAksesoris($obj['item_code']);
					if ($cek_item->num_rows() < 1) {
						$temp = array(
							"item_code"     => $rowData[0][0],
							"id_penginput"  => from_session('id'),
							"id_fppp"       => $id_fppp,
							"id_jenis_item" => $jenis_bom,
						);
						$this->db->insert('data_temp', $temp);
					} else {
						$id_item = $cek_item->row()->id;
						$obj_bom = array(
							'is_bom'         => 1,
							'inout'          => 0,
							'id_fppp'        => $id_fppp,
							'id_jenis_item'  => $jenis_bom,
							'id_item'        => $id_item,
							'qty_bom'        => $qty,
							'keterangan'     => $keterangan,
							'id_multi_brand' => $obj['id_multi_brand'],
							'created'        => date('Y-m-d H:i:s'),
						);
						$this->db->insert('data_stock', $obj_bom);
					}
					$dt = array(
						'bom_aksesoris'            => 1,
						'tgl_upload_bom_aksesoris' => date('Y-m-d H:i:s'),
					);
					$this->m_fppp->updateStatusUploadBom($id_fppp, $dt);
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
				$qty        = $rowData[0][6];
				$keterangan = $rowData[0][7];
				$cek_item   = $this->m_fppp->getMasterLembaran($obj['nama_barang']);
				if ($cek_item->num_rows() < 1) {
					$temp = array(
						"item_code"     => $rowData[0][1],
						"id_penginput"  => from_session('id'),
						"id_fppp"       => $id_fppp,
						"id_jenis_item" => $jenis_bom,
					);
					$this->db->insert('data_temp', $temp);
				} else {
					$id_item = $cek_item->row()->id;
					$obj_bom = array(
						'is_bom'        => 1,
						'id_fppp'       => $id_fppp,
						'id_jenis_item' => $jenis_bom,
						'id_item'       => $id_item,
						'qty_bom'       => $qty,
						'keterangan'    => $keterangan,
						'created'       => date('Y-m-d H:i:s'),
					);
					$this->db->insert('data_stock', $obj_bom);
				}
				$dt = array(
					'bom_lembaran'            => 1,
					'tgl_upload_bom_lembaran' => date('Y-m-d H:i:s'),
				);
				$this->m_fppp->updateStatusUploadBom($id_fppp, $dt);
			}
		}
		unlink($inputFileName);
		sleep(1);
		$data['detail'] = $this->m_fppp->getTemp($id_fppp, $jenis_bom);
		$data['msg']    = "Data BOM Baru Disimpan....";
		echo json_encode($data);
	}

	public function uploadMaster()
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
		$id_fppp       = $this->input->post('id');
		$jenis_bom     = $this->input->post('jenis_bom');

		for ($row = 2; $row <= $highestRow; $row++) {                  //  Read a row of data into an array
			$rowData = $sheet->rangeToArray(
				'A' . $row . ':' . $highestColumn . $row,
				NULL,
				TRUE,
				FALSE
			);

			if ($jenis_bom == 1) {
				$obj = array(
					'id_jenis_item'     => 1,
					'item_code'         => $rowData[0][0],
					'section_ata'       => $rowData[0][1],
					'section_allure'    => $rowData[0][2],
					'temper'            => $rowData[0][3],
					'kode_warna'        => str_pad($rowData[0][4], 2, '0', STR_PAD_LEFT),
					'ukuran'            => $rowData[0][5],
					'satuan'            => $rowData[0][6],
					'perimeter_berat'   => $rowData[0][7],
					'perimeter_mf'      => $rowData[0][8],
					'perimeter_coating' => $rowData[0][9],
					'created'           => date('Y-m-d H:i:s'),
				);

				$cek_item = $this->m_fppp->cekItemCodeAluminium($obj['item_code']);
				if ($cek_item->num_rows() < 1) {
					$this->db->insert('master_item', $obj);
				}
				// else {
				// 	$this->db->where('item_code', $obj['item_code']);
				// 	$this->db->where('id_jenis_item', 1);
				// 	$this->db->update('master_item', $obj);
				// }
			} else if ($jenis_bom == 2) {
				$obj = array(
					'id_jenis_item' => 2,
					'item_code'     => $rowData[0][0],
					'deskripsi'     => $rowData[0][1],
					'satuan'        => $rowData[0][2],
				);
				$obj_new = array(
					'id_jenis_item' => 2,
					'item_code'     => $rowData[0][0],
					'deskripsi'     => $rowData[0][1],
					'satuan'        => $rowData[0][2],
					'created'       => date('Y-m-d H:i:s'),
				);
				$cek_item = $this->m_fppp->getMasterAksesoris($obj['item_code']);
				if ($cek_item->num_rows() < 1) {
					$this->db->insert('master_item', $obj_new);
				} else {
					$this->db->where('item_code', $obj['item_code']);
					$this->db->update('master_item', $obj);
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
				$cek_item = $this->m_fppp->getMasterLembaran($obj['nama_barang']);
				if ($cek_item->num_rows() < 1) {
					$this->db->insert('master_item', $obj);
				}
			}
		}
		// unlink($inputFileName);
		sleep(1);
		$data['detail'] = $this->m_fppp->getTemp($id_fppp, $jenis_bom);
		$data['msg']    = "Data Master Baru Disimpan....";
		echo json_encode($data);
	}

	public function uploadStock()
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
			// $obj = array(
			// 	'id_jenis_item'          => 2,
			// 	'id_divisi'          => str_replace(' ', '', $rowData[0][4]),
			// 	'id_gudang'          => str_replace(' ', '', $rowData[0][5]),
			// 	'keranjang'          => str_replace(' ', '_', $rowData[0][6]),
			// 	'qty'          => $rowData[0][7],
			// 	'itm_code'          => $rowData[0][0],
			// );
			// $obj = array(
			// 	'id_jenis_item'          => 1,
			// 	'id_divisi'     => '',
			// 	'id_gudang'          => str_replace(' ', '', $rowData[0][10]),
			// 	'keranjang'          => str_replace(' ', '_', $rowData[0][11]),
			// 	'qty'          => $rowData[0][12],
			// 	'itm_code'          => $rowData[0][0],
			// );

			// $objx = array(
			// 	'item_code'          => $rowData[0][0],
			// );
			// $this->db->where('item_code', $objx['item_code']);
			// $obb = array('cek_double' => 2);
			// $this->db->where('item_code', $objx['item_code']);
			// $this->db->update('master_item', $obb);



			// $simpan = array(
			// 	'id_jenis_item' => $obj['id_jenis_item'],
			// 	'id_item'       => 0,
			// 	'id_divisi'     => $obj['id_divisi'],
			// 	'id_gudang'     => $obj['id_gudang'],
			// 	'keranjang'     => $obj['keranjang'],
			// 	'qty'           => $obj['qty'],
			// 	'created'       => date('Y-m-d H:i:s'),
			// 	'itm_code'       => $obj['itm_code'],
			// );
			// $this->db->insert('data_counter', $simpan);

			// $obj = array(
			// 	'id_jenis_item'          => 2,
			// 	'itm_code'          => $rowData[0][0],
			// 	'supplier'          => $rowData[0][3],
			// 	'lead_time'          => $rowData[0][4],
			// );
			// $this->db->where('item_code', $obj['itm_code']);
			// $this->db->where('id_jenis_item', $obj['id_jenis_item']);
			// // $this->db->limit($obj['limit']);
			// $updt = array(
			// 	'supplier'          => $rowData[0][3],
			// 	'lead_time'          => $rowData[0][4],
			// );
			// $this->db->update('master_item',$updt);
		}
		// unlink($inputFileName);
		$data['msg'] = "Data BOM Baru Disimpan....";
		echo json_encode($data);
	}

	public function uploadCounter()
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
			$obj = array(
				'id_jenis_item'  => 1,
				'itm_code'       => $rowData[0][0] . '-' . $rowData[0][1] . '-' . $rowData[0][2] . '-' . str_pad($rowData[0][3], 2, '0', STR_PAD_LEFT) . '-' . $rowData[0][4],
				'id_gudang'      => $rowData[0][5],
				'keranjang'      => $rowData[0][6],
				'qty'      => $rowData[0][7],
				'updated'        => date('Y-m-d H:i:s'),
			);

			$cek_ada = $this->db->get_where('master_item', array('item_code' => $obj['itm_code']))->num_rows();
			if ($cek_ada < 1) {
				$master_item = array(
					'id_jenis_item'  => 1,
					'section_ata'      => $rowData[0][0],
					'section_allure'      => $rowData[0][1],
					'temper'      => $rowData[0][2],
					'kode_warna'      => str_pad($rowData[0][3], 2, '0', STR_PAD_LEFT),
					'ukuran'      => $rowData[0][4],
					'item_code'       => $rowData[0][0] . '-' . $rowData[0][1] . '-' . $rowData[0][2] . '-' . str_pad($rowData[0][3], 2, '0', STR_PAD_LEFT) . '-' . $rowData[0][4],
					'created'        => date('Y-m-d H:i:s'),
					'ket'        => 'upload master',
				);
				$this->db->insert('master_item', $master_item);
				$cek_id = $this->db->insert_id();
			} else {
				$cek_id = $this->db->get_where('master_item', array('item_code' => $obj['itm_code']))->row()->id;
			}

			$counter = array(
				'id_jenis_item'  => 1,
				'itm_code'       => $obj['itm_code'],
				'id_item'      => $cek_id,
				'id_gudang'      => $obj['id_gudang'],
				'keranjang'      => $obj['keranjang'],
				'qty'      => $obj['qty'],
				'updated'        => date('Y-m-d H:i:s'),
			);
			$cekQtyCounter = $this->m_fppp->cekCounterAlu($obj['id_jenis_item'], $cek_id, $obj['id_gudang'], $obj['keranjang']);
			if ($cekQtyCounter->num_rows() == 0) {
				$this->db->insert('data_counter', $counter);
			} else {
				$qty_sebelum = $cekQtyCounter->row()->qty;
				$qty_jadi      = (int)$qty_sebelum + (int)$obj['qty'];
				$this->m_fppp->updateCounterAlu($obj['id_jenis_item'], $obj['item_code'], $obj['id_gudang'], $obj['keranjang'], $qty_jadi);
			}


			
		}
		// unlink($inputFileName);
		// sleep(1);
		// $data['detail'] = $this->m_fppp->getTemp($id_fppp, $jenis_bom);
		$data['msg'] = "Data Counter Stock Baru Disimpan....";
		echo json_encode($data);
	}

	public function lihatbom($id_fppp, $param)
	{
		$this->fungsi->check_previleges('fppp');
		$data['bom_aluminium'] = $this->m_fppp->bom_aluminium($id_fppp);
		$data['bom_aksesoris'] = $this->m_fppp->bom_aksesoris($id_fppp);
		$data['bom_lembaran']  = $this->m_fppp->bom_lembaran($id_fppp);
		$data['param']         = $param;
		$data['rowFppp']       = $this->m_fppp->getRowFppp($id_fppp)->row();
		$this->load->view('klg/fppp/v_fppp_bom_list', $data);
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

	public function optionGetKodeProyek()
	{
		$this->fungsi->check_previleges('fppp');
		$kode_proyek = $this->input->post('kode_proyek');
		$data['np']        = $this->m_fppp->getKodeProyek($kode_proyek)->nama_proyek;
		$data['alamat']    = $this->m_fppp->getKodeProyek($kode_proyek)->alamat;
		echo json_encode($data);
	}


	public function kesesuaian_stock()
	{
		// $data_aksesoris_in = $this->m_aksesoris->getDataDetailTabel($id);
        // $arr               = array();
		
		// $this->db->where('keterangan', '');
		$this->db->where('id_jenis_item', $this->input->post('id_jenis_item'));
		// if ($this->input->post('id_gudang')!='') {
		// 	$this->db->where('id_gudang', $this->input->post('id_gudang'));
		// }
		$data_aksesoris_in = $this->db->get('data_counter')->result();
		
        foreach ($data_aksesoris_in as $key) {
            $stok_awal_bulan = $this->m_aksesoris->getAwalBulanDetailTabel($key->id_item, $key->id_divisi, $key->id_gudang, $key->keranjang);
            $qtyin           = $this->m_aksesoris->getQtyInDetailTabelMonitoring($key->id_item, $key->id_divisi, $key->id_gudang, $key->keranjang);
            $qtyout          = $this->m_aksesoris->getQtyOutDetailTabelMonitoring($key->id_item, $key->id_divisi, $key->id_gudang, $key->keranjang);
            $qtyinmutasi          = $this->m_aksesoris->getQtyInDetailTabelMonitoringMutasi($key->id_item, $key->id_divisi, $key->id_gudang, $key->keranjang);
            $qtyoutmutasi          = $this->m_aksesoris->getQtyOutDetailTabelMonitoringMutasi($key->id_item, $key->id_divisi, $key->id_gudang, $key->keranjang);
            
			// $stok_awal_bulan = $this->m_aluminium->getAwalBulanDetailTabel($key->id_item, $key->id_gudang, $key->keranjang);
            // $qtyin           = $this->m_aluminium->getQtyInDetailTabelMonitoringP($key->id_item, $key->id_gudang, $key->keranjang);
            // $qtyout          = $this->m_aluminium->getQtyOutDetailTabelMonitoringP($key->id_item, $key->id_gudang, $key->keranjang);
            // $qtyinmutasi          = $this->m_aluminium->getQtyInDetailTabelMonitoringMutasiP($key->id_item, $key->id_gudang, $key->keranjang);
            // $qtyoutmutasi          = $this->m_aluminium->getQtyOutDetailTabelMonitoringMutasiP($key->id_item, $key->id_gudang, $key->keranjang);
            
			$qty_counter = ($stok_awal_bulan + $qtyin + $qtyinmutasi) - ($qtyout + $qtyoutmutasi);
			// $temp            = array(
                // "divisi"           => $key->divisi,
                // "gudang"           => $key->gudang,
                // "keranjang"        => $key->keranjang,
                // "stok_awal_bulan"  => $stok_awal_bulan,
                // "tot_in"           => $qtyin,
                // "tot_out"          => $qtyout,
                // "mutasi_in"          => $qtyinmutasi,
                // "mutasi_out"          => $qtyoutmutasi,
                // "stok_akhir_bulan" => $key->qty,
                // "stok_akhir_bulan" => ($stok_awal_bulan + $qtyin + $qtyinmutasi) - $qtyout - $qtyoutmutasi,
                // "rata_pemakaian"   => $key->rata_pemakaian,
                // "min_stock"        => '0',
            // );

            $this->db->where('id_item', $key->id_item);
            $this->db->where('id_divisi', $key->id_divisi);
            $this->db->where('id_gudang', $key->id_gudang);
            $this->db->where('keranjang', $key->keranjang);
            $object = array(
				'qty' => $qty_counter,
				'keterangan' => 'penyesuaian '.date('Y-m-d H:i:s'),
			);
            $this->db->update('data_counter', $object);


            // array_push($arr, $temp);
            // echo $key->gt . '<br>';
        }
		$data['msg'] = "sukses";
		echo json_encode($data);
	}
}

/* End of file fppp.php */
/* Location: ./application/controllers/klg/fppp.php */