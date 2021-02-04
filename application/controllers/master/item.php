<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Item extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('master/m_item');
	}

	public function index()
	{
		$this->fungsi->check_previleges('item');
		$data['item'] = $this->m_item->getData();
		$this->load->view('master/item/v_item_list', $data);
	}


	public function show_addForm($value = '')
	{
		$this->fungsi->check_previleges('item');
		$data['jenis_barang'] = $this->db->get('master_jenis_barang');
		$data['lokasi'] = $this->db->get('master_lokasi');
		$this->load->view('master/item/v_item_add', $data);
	}

	public function insert($value = '')
	{
		$this->fungsi->check_previleges('item');
		$datapost = array(
			'item'            => $this->input->post('item'),
			'id_jenis_barang' => $this->input->post('id_jenis_barang'),
			'gambar'          => 'assets/img/noimage.png',
			'lebar'           => $this->input->post('lebar'),
			'tinggi'          => $this->input->post('tinggi'),
			'spesifikasi'     => $this->input->post('spesifikasi'),
			'id_lokasi'       => $this->input->post('id_lokasi'),
			'safety_stok'     => $this->input->post('safety_stok'),
			'date'            => date('Y-m-d'),
		);
		$this->m_item->insertData($datapost);
		$this->fungsi->catat($datapost, "Menambah Master item dengan data sbb:", true);
		$data['msg'] = "item Disimpan!";
		echo json_encode($data);
	}

	public function insertFile()
	{
		$this->fungsi->check_previleges('item');

		$upload_folder = get_upload_folder('./files/');

		$config['upload_path']   = $upload_folder;
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size']      = '3072';
		$config['encrypt_name']  = true;

		$this->load->library('upload', $config);
		$err = "";
		$msg = "";
		if (!$this->upload->do_upload('ufile')) {
			$err = $this->upload->display_errors('<span class="error_string">', '</span>');
		} else {
			$data = $this->upload->data();
			/***********************/
			// CREATE THUMBNAIL 100x100 - maintain aspect ratio
			/**********************/
			$config['image_library'] = 'gd2';
			$config['source_image'] = $upload_folder . $data['file_name'];
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 100;
			$config['height'] = 100;

			$this->load->library('image_lib', $config);

			if (!$this->image_lib->resize()) {
				$err = $this->image_lib->display_errors('<span class="error_string">', '</span>');
			} else {
				$datapost = array(
					'item'            => $this->input->post('item'),
					'id_jenis_barang' => $this->input->post('id_jenis_barang'),
					'gambar'          => substr($upload_folder, 2) . $data['file_name'],
					'lebar'           => $this->input->post('lebar'),
					'tinggi'          => $this->input->post('tinggi'),
					'spesifikasi'     => $this->input->post('spesifikasi'),
					'id_lokasi'       => $this->input->post('id_lokasi'),
					'safety_stok'     => $this->input->post('safety_stok'),
					'date'            => date('Y-m-d'),
				);
				$this->m_item->insertData($datapost);
				$this->fungsi->catat($datapost, "Menambah Master item dengan data sbb:", true);
				$data['msg'] = "item Disimpan!";
				echo json_encode($data);
			}
		}
	}

	public function show_editForm($id = '')
	{
		$this->fungsi->check_previleges('item');
		$this->load->library('form_validation');
		$config = array(
			array(
				'field'	=> 'id',
				'label' => 'wes mbarke',
				'rules' => ''
			),
			array(
				'field'	=> 'item',
				'label' => 'item',
				'rules' => 'required'
			),
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

		if ($this->form_validation->run() == FALSE) {
			$data['edit'] = $this->m_item->getEdititem($id);
			$data['jenis_barang'] = $this->db->get('master_jenis_barang');
			$data['lokasi'] = $this->db->get('master_lokasi');
			$this->load->view('master/item/v_item_edit', $data);
		} else {
			$datapost = get_post_data(array('id', 'item', 'id_jenis_barang', 'lebar', 'tinggi', 'spesifikasi', 'id_lokasi', 'safety_stok'));
			$this->m_item->insertData($datapost, false);
			$this->fungsi->catat($datapost, "Mengedit Master item dengan data sbb:", true);
			$data['msg'] = "item Diperbarui!";
			echo json_encode($data);
		}
	}

	public function show_editForm_file($id = '')
	{
		$this->fungsi->check_previleges('item');
		$this->load->library('form_validation');
		$config = array(
			array(
				'field'	=> 'id',
				'label' => 'wes mbarke',
				'rules' => ''
			),
			array(
				'field'	=> 'item',
				'label' => 'item',
				'rules' => 'required'
			),
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

		if ($this->form_validation->run() == FALSE) {

			$data['edit'] = $this->m_item->getEdititem($id);
			$data['jenis_barang'] = $this->db->get('master_jenis_barang');
			$data['lokasi'] = $this->db->get('master_lokasi');
			$this->load->view('master/item/v_item_edit', $data);
		} else {
			$upload_folder = get_upload_folder('./files/');

			$config['upload_path']   = $upload_folder;
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size']      = '3072';
			$config['encrypt_name']  = true;

			$this->load->library('upload', $config);
			$err = "";
			$msg = "";
			if (!$this->upload->do_upload('ufile')) {
				$err = $this->upload->display_errors('<span class="error_string">', '</span>');
			} else {
				$data = $this->upload->data();
				/***********************/
				// CREATE THUMBNAIL 100x100 - maintain aspect ratio
				/**********************/
				$config['image_library'] = 'gd2';
				$config['source_image'] = $upload_folder . $data['file_name'];
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 100;
				$config['height'] = 100;

				$this->load->library('image_lib', $config);

				if (!$this->image_lib->resize()) {
					$err = $this->image_lib->display_errors('<span class="error_string">', '</span>');
				} else {
					$datapost = array(
						'id'              => $this->input->post('id'),
						'item'            => $this->input->post('item'),
						'id_jenis_barang' => $this->input->post('id_jenis_barang'),
						'gambar'          => substr($upload_folder, 2) . $data['file_name'],
						'lebar'           => $this->input->post('lebar'),
						'tinggi'          => $this->input->post('tinggi'),
						'spesifikasi'     => $this->input->post('spesifikasi'),
						'id_lokasi'       => $this->input->post('id_lokasi'),
						'safety_stok'     => $this->input->post('safety_stok'),
					);
					$this->m_item->insertData($datapost, false);
					$this->fungsi->catat($datapost, "Mengupdate Master item dengan data sbb:", true);
					$data['msg'] = "item Baru Disimpan!";
					echo json_encode($data);
				}
			}
		}
	}

	public function delete($id)
	{
		$this->fungsi->check_previleges('item');
		if ($id == '' || !is_numeric($id)) die;
		$this->m_item->deleteData($id);
		$this->fungsi->run_js('load_silent("master/item","#content")');
		$this->fungsi->message_box("Data Master item berhasil dihapus...", "notice");
		$this->fungsi->catat("Menghapus laporan dengan id " . $id);
	}


	public function modal($id = '')
	{
		$content   = "<div id='divsubcontent'></div>";
		$header    = "Detail Product";
		$subheader = "";
		$buttons[] = button('', 'Tutup', 'btn btn-default', 'data-dismiss="modal"');
		echo $this->fungsi->parse_modal($header, $subheader, $content, $buttons, "");
		$this->fungsi->run_js('load_silent("master/item/detailModal/' . $id . '","#divsubcontent")');
	}

	public function detailModal($id)
	{
		$item = $this->m_item->getRowitem($id)->row();
		$data = array(
			'item' => $item,
		);
		$this->load->view('master/item/v_modal', $data);
	}
}

/* End of file item.php */
/* Location: ./application/controllers/master/item.php */