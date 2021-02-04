<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ncr extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('klg/m_ncr');
	}

	public function index()
	{
		$this->fungsi->check_previleges('ncr');
		$data['ncr'] = $this->m_ncr->getData();
		$this->load->view('klg/ncr/v_ncr_list', $data);
	}

	public function formAdd($value = '')
	{
		$this->fungsi->check_previleges('ncr');
		$data = array(
			'nomor_ncr'             => str_pad($this->m_ncr->getncr(), 3, '0', STR_PAD_LEFT) . '/NCR' . '/' . date('m') . '/' . date('Y'),
			'store'                 => $this->db->get('master_store')->result(),
			'jenis_ketidaksesuaian' => $this->db->get('master_jenis_ketidaksesuaian')->result(),
		);
		$this->load->view('klg/ncr/v_ncr_add', $data);
	}

	public function savencrImage($value = '')
	{
		$this->fungsi->check_previleges('ncr');
		$upload_folder = get_upload_folder('./files/');

		$config['upload_path']   = $upload_folder;
		$config['allowed_types'] = 'pdf';
		$config['max_size']      = '3072';
		// $config['max_width']     = '1024';
		// $config['max_height']    = '1024';
		$config['encrypt_name']  = true;

		$this->load->library('upload', $config);
		$err = "";
		$msg = "";
		if (!$this->upload->do_upload('lampiran')) {
			$err = $this->upload->display_errors('<span class="error_string">', '</span>');
		} else {
			$data = $this->upload->data();

			$datapost = array(
				'id_store'                 => $this->input->post('store'),
				'nama_project'             => $this->input->post('nama_project'),
				'no_ncr'                   => $this->input->post('no_ncr'),
				'no_wo'                    => $this->input->post('no_wo'),
				'tanggal'                  => $this->input->post('tanggal'),
				'no_fppp'                  => $this->input->post('no_fppp'),
				'kepada'                   => $this->input->post('kepada'),
				'item'                     => $this->input->post('item'),
				'dilaporkan_oleh'          => $this->input->post('dilaporkan_oleh'),
				'id_jenis_ketidaksesuaian' => $this->input->post('id_jenis_ketidaksesuaian'),
				'deskripsi_masalah'        => $this->input->post('deskripsi_masalah'),
				'analisa_penyebab_masalah' => $this->input->post('analisa_penyebab_masalah'),
				'tindakan_perbaikan'       => $this->input->post('tindakan_perbaikan'),
				'lampiran'                 => substr($upload_folder, 2) . $data['file_name'],
			);
			$this->m_ncr->insertncr($datapost);
			$data['id'] = $this->db->insert_id();
			$this->fungsi->catat($datapost, "Menyimpan NCR sbb:", true);
			$data['msg'] = "NCR Disimpan";
			echo json_encode($data);
		}
	}

	public function formEdit($value = '')
	{
		$this->fungsi->check_previleges('ncr');
		$data = array(
			'row'          => $this->m_ncr->getEdit($value)->row(),
			'detail'       => $this->m_ncr->getDataDetailTabel($value),
			'tipe_ncr' => $this->db->get('master_tipe')->result(),
			'item'         => $this->db->get('master_item')->result(),
			'warna'        => $this->db->get('master_warna')->result(),
			'brand'        => $this->db->get('master_brand')->result(),
			'store'        => $this->db->get('master_store')->result(),
		);
		$this->load->view('klg/ncr/v_ncr_edit', $data);
	}

	public function feedback($id = '')
	{
		$this->fungsi->check_previleges('ncr');
		$data = array(
			'row'          => $this->m_ncr->getEdit($id)->row(),
			'id'          => $id,
		);
		$this->load->view('klg/ncr/v_ncr_feedback', $data);
	}
	public function saveFeedback($value = '')
	{
		$this->fungsi->check_previleges('ncr');
		$upload_folder = get_upload_folder('./files/');

		$config['upload_path']   = $upload_folder;
		$config['allowed_types'] = 'pdf';
		$config['max_size']      = '3072';
		// $config['max_width']     = '1024';
		// $config['max_height']    = '1024';
		$config['encrypt_name']  = true;

		$this->load->library('upload', $config);
		$err = "";
		$msg = "";
		if (!$this->upload->do_upload('lampiran')) {
			$err = $this->upload->display_errors('<span class="error_string">', '</span>');
		} else {
			$data = $this->upload->data();
			$id_ncr = $this->input->post('id_ncr');
			$datapost = array(
				'status'       => 2,
				'feedback'       => substr($upload_folder, 2) . $data['file_name'],
			);
			$this->m_ncr->updatencr($id_ncr, $datapost);
			$this->fungsi->catat($datapost, "Mengupdate Feedback NCR sbb:", true);
			$data['msg'] = "Feedback NCR Diupdate";
			echo json_encode($data);
		}
	}

	public function updatencr($value = '')
	{
		$this->fungsi->check_previleges('ncr');
		$id_ncr = $this->input->post('id_ncr');
		$datapost = array(
			'id_brand'       => $this->input->post('brand'),
			'no_ncr'     => $this->input->post('no_ncr'),
			'no_po'          => $this->input->post('no_po'),
			'project_owner'  => $this->input->post('projek_owner'),
			'id_store'       => $this->input->post('id_store'),
			'alamat_proyek'  => $this->input->post('alamat_proyek'),
			'no_telp'        => $this->input->post('no_telp'),
			'tgl_pengiriman' => $this->input->post('tgl_pengiriman'),
			'intruction'     => $this->input->post('keterangan'),
			'lampiran'       => '',
		);
		$this->m_ncr->updatencr($id_ncr, $datapost);
		$data['id'] = $this->db->insert_id();
		$this->fungsi->catat($datapost, "Mengupdate NCR sbb:", true);
		$data['msg'] = "NCR Diupdate";
		echo json_encode($data);
	}

	public function updatencrImage($value = '')
	{
		$this->fungsi->check_previleges('ncr');
		$upload_folder = get_upload_folder('./files/');

		$config['upload_path']   = $upload_folder;
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['max_size']      = '3072';
		// $config['max_width']     = '1024';
		// $config['max_height']    = '1024';
		$config['encrypt_name']  = true;

		$this->load->library('upload', $config);
		$err = "";
		$msg = "";
		if (!$this->upload->do_upload('lampiran')) {
			$err = $this->upload->display_errors('<span class="error_string">', '</span>');
		} else {
			$data = $this->upload->data();
			$id_ncr = $this->input->post('id_ncr');
			$datapost = array(
				'id_brand'       => $this->input->post('brand'),
				'no_ncr'     => $this->input->post('no_ncr'),
				'no_po'          => $this->input->post('no_po'),
				'project_owner'  => $this->input->post('projek_owner'),
				'id_store'       => $this->input->post('id_store'),
				'alamat_proyek'  => $this->input->post('alamat_proyek'),
				'no_telp'        => $this->input->post('no_telp'),
				'tgl_pengiriman' => $this->input->post('tgl_pengiriman'),
				'intruction'     => $this->input->post('keterangan'),
				'lampiran'       => substr($upload_folder, 2) . $data['file_name'],
			);
			$this->m_ncr->updatencr($id_ncr, $datapost);
			$data['id'] = $this->db->insert_id();
			$this->fungsi->catat($datapost, "Mengupdate Permintaan sbb:", true);
			$data['msg'] = "Permintaan Diupdate";
			echo json_encode($data);
		}
	}

	public function savencrDetail($value = '')
	{
		$this->fungsi->check_previleges('ncr');
		$datapost = array(
			'id_ncr' => $this->input->post('id_ncr'),
			'id_tipe'    => $this->input->post('tipe_ncr'),
			'id_item'    => $this->input->post('item'),
			'id_warna'   => $this->input->post('warna'),
			'bukaan'     => $this->input->post('bukaan'),
			'lebar'      => $this->input->post('lebar'),
			'tinggi'     => $this->input->post('tinggi'),
			'qty'        => $this->input->post('qty'),
			'keterangan' => $this->input->post('keterangan'),
			'harga'      => $this->input->post('harga'),
			'date'       => date('Y-m-d'),
		);
		$this->m_ncr->insertncrDetail($datapost);
		$data['id'] = $this->db->insert_id();
		$this->fungsi->catat($datapost, "Menyimpan detail ncr sbb:", true);
		$data['msg'] = "ncr Disimpan";
		echo json_encode($data);
	}

	public function deleteItem()
	{
		$this->fungsi->check_previleges('ncr');
		$id = $this->input->post('id');
		$data = array('id' => $id,);

		$this->m_ncr->deleteDetailItem($id);
		$this->fungsi->catat($data, "Menghapus ncr Detail dengan data sbb:", true);
		$respon = ['msg' => 'Data Berhasil Dihapus'];
		echo json_encode($respon);
	}



	public function cetak($id)
	{
		$data = array(
			'id'     => $id,
			'header' => $this->m_ncr->getHeaderCetak($id),
		);
		$this->load->view('klg/ncr/v_cetak', $data);
	}
}

/* End of file ncr.php */
/* Location: ./application/controllers/klg/ncr.php */