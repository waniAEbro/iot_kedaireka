<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Store extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('master/m_store');
	}

	public function index()
	{
		$this->fungsi->check_previleges('store');
		$data['store'] = $this->m_store->getData();
		$this->load->view('master/store/v_store_list', $data);
	}

	public function form($param = '')
	{
		$content   = "<div id='divsubcontent'></div>";
		$header    = "Form Master Store/Mitra";
		$subheader = "store";
		$buttons[] = button('jQuery.facebox.close()', 'Tutup', 'btn btn-default', 'data-dismiss="modal"');
		echo $this->fungsi->parse_modal($header, $subheader, $content, $buttons, "");
		if ($param == 'base') {
			$this->fungsi->run_js('load_silent("master/store/show_addForm/","#divsubcontent")');
		} else {
			$base_kom = $this->uri->segment(5);
			$this->fungsi->run_js('load_silent("master/store/show_editForm/' . $base_kom . '","#divsubcontent")');
		}
	}

	public function show_addForm()
	{
		$this->fungsi->check_previleges('store');
		$this->load->library('form_validation');
		$config = array(
			array(
				'field'	=> 'store',
				'label' => 'store',
				'rules' => 'required'
			)
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

		if ($this->form_validation->run() == FALSE) {
			$data['status'] = '';
			$data['jenis_market'] = $this->db->get('master_jenis_market');
			$data['kategori_lokasi'] = $this->db->get('master_kategori_lokasi');
			$this->load->view('master/store/v_store_add', $data);
		} else {
			$datapost = get_post_data(array('store', 'id_jenis_market', 'no_telp', 'alamat', 'zona', 'id_kategori_lokasi'));
			$this->m_store->insertData($datapost);
			$this->fungsi->run_js('load_silent("master/store","#content")');
			$this->fungsi->message_box("Data Master store sukses disimpan...", "success");
			$this->fungsi->catat($datapost, "Menambah Master store dengan data sbb:", true);
		}
	}

	public function show_editForm($id = '')
	{
		$this->fungsi->check_previleges('store');
		$this->load->library('form_validation');
		$config = array(
			array(
				'field'	=> 'id',
				'label' => 'wes mbarke',
				'rules' => ''
			),
			array(
				'field'	=> 'store',
				'label' => 'store',
				'rules' => 'required'
			)
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

		if ($this->form_validation->run() == FALSE) {
			$data['jenis_market'] = $this->db->get('master_jenis_market');
			$data['kategori_lokasi'] = $this->db->get('master_kategori_lokasi');
			$data['edit'] = $this->db->get_where('master_store', array('id' => $id));
			$this->load->view('master/store/v_store_edit', $data);
		} else {
			$datapost = get_post_data(array('id', 'store', 'id_jenis_market', 'no_telp', 'alamat', 'zona', 'id_kategori_lokasi'));
			$this->m_store->updateData($datapost);
			$this->fungsi->run_js('load_silent("master/store","#content")');
			$this->fungsi->message_box("Data Master store sukses diperbarui...", "success");
			$this->fungsi->catat($datapost, "Mengedit Master store dengan data sbb:", true);
		}
	}
}

/* End of file store.php */
/* Location: ./application/controllers/master/store.php */