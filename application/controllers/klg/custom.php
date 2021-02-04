<?php
defined('BASEPATH') or exit('No direct script access allowed');

class custom extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('klg/m_custom');
		$this->load->model('klg/m_invoice');
		$this->load->model('klg/m_monitoring');
	}




	public function index()
	{
		$this->fungsi->check_previleges('custom');
		$data['param_tab'] = '1';
		// $xxx = $this->m_custom->getxxx();
		// foreach ($xxx->result() as $key) {
		// 	$id = $key->id;
		// 	$post = array(
		// 		'date' => $key->date,
		// 		'tgl' => $key->date,
		// 		);
		// 	$this->db->where('id', $id);
		// 	$this->db->update('data_stok_detail', $post);
		// }
		$this->load->view('klg/custom/v_custom_list', $data);
	}

	public function order($value = '')
	{
		$this->fungsi->check_previleges('custom');
		$data['custom'] = $this->m_custom->getData();
		$this->load->view('klg/custom/v_custom_order', $data);
	}

	public function direct($value = '')
	{
		$this->fungsi->check_previleges('custom');
		$data['custom'] = $this->m_custom->getDataDirect();
		$this->load->view('klg/custom/v_custom_direct', $data);
	}

	public function formAdd($value = '')
	{
		$this->fungsi->check_previleges('custom');
		$data = array(
			'no_permintaan' => $this->m_custom->getNoPermintaan(),
			'item'          => $this->db->get('master_item')->result(),
			'warna'         => $this->db->get('master_warna')->result(),
		);
		$this->load->view('klg/custom/v_custom_add', $data);
	}



	public function deleteItem()
	{
		$this->fungsi->check_previleges('custom');
		$id = $this->input->post('id');
		$data = array('id' => $id,);

		$this->m_custom->deleteDetailItem($id);
		$this->fungsi->catat($data, "Menghapus Item custom data sbb:", true);
		$respon = ['msg' => 'Data Berhasil Dihapus'];
		echo json_encode($respon);
	}



	public function saveCustomDetail($value = '')
	{
		$this->fungsi->check_previleges('custom');

		$datapost = array(
			'id_invoice'    => $this->input->post('id_invoice'),
			'id_item'    => $this->input->post('item'),
			'id_tipe'     => 2,
			'id_warna'   => $this->input->post('warna'),
			'bukaan'     => $this->input->post('bukaan'),
			'lebar'      => $this->input->post('lebar'),
			'tinggi'     => $this->input->post('tinggi'),
			'qty'        => $this->input->post('qty'),
			'cek1'        => $this->input->post('cek1'),
			'cek2'        => $this->input->post('cek2'),
			'cek3'        => $this->input->post('cek3'),
			'tgl'        => $this->input->post('tgl'),
			'inout'       => 1,
		);
		$this->m_custom->insertCustomDetail($datapost);
		$data['id'] = $this->db->insert_id();
		$this->fungsi->catat($datapost, "Menyimpan item custom sbb:", true);
		$data['msg'] = "custom Disimpan";
		echo json_encode($data);
	}

	public function getItemInvoice($value = '')
	{
		$this->fungsi->check_previleges('custom');
		$id = $this->input->post('id');
		$get_data = $this->m_custom->getItemInvoice($id);

		// echo $this->db->last_query();

		$data = array();

		foreach ($get_data as $val) {
			$data[] = $val;
		}

		echo json_encode($data, JSON_PRETTY_PRINT);
	}

	public function getWarnaItem($value = '')
	{
		$this->fungsi->check_previleges('custom');
		$id = $this->input->post('id_invoice');
		$id_item = $this->input->post('id_item');
		$get_data = $this->m_custom->getWarnaItem($id, $id_item);

		// echo $this->db->last_query();

		$data = array();

		foreach ($get_data as $val) {
			$data[] = $val;
		}

		echo json_encode($data, JSON_PRETTY_PRINT);
	}

	public function getBukaanItem($value = '')
	{
		$this->fungsi->check_previleges('custom');
		$id = $this->input->post('id_invoice');
		$id_item = $this->input->post('id_item');
		$id_warna = $this->input->post('id_warna');
		$get_data = $this->m_custom->getBukaanItem($id, $id_item, $id_warna);

		// echo $this->db->last_query();

		$data = array();

		foreach ($get_data as $val) {
			$data[] = $val;
		}

		echo json_encode($data, JSON_PRETTY_PRINT);
	}

	public function getLebarItem($value = '')
	{
		$this->fungsi->check_previleges('custom');
		$id = $this->input->post('id_invoice');
		$id_item = $this->input->post('id_item');
		$id_warna = $this->input->post('id_warna');
		$bukaan = $this->input->post('bukaan');
		$get_data = $this->m_custom->getLebarItem($id, $id_item, $id_warna, $bukaan);

		// echo $this->db->last_query();

		$data = array();

		foreach ($get_data as $val) {
			$data[] = $val;
		}

		echo json_encode($data, JSON_PRETTY_PRINT);
	}

	public function getTinggiItem($value = '')
	{
		$this->fungsi->check_previleges('custom');
		$id = $this->input->post('id_invoice');
		$id_item = $this->input->post('id_item');
		$id_warna = $this->input->post('id_warna');
		$bukaan = $this->input->post('bukaan');
		$lebar = $this->input->post('lebar');
		$get_data = $this->m_custom->getTinggiItem($id, $id_item, $id_warna, $bukaan, $lebar);

		// echo $this->db->last_query();

		$data = array();

		foreach ($get_data as $val) {
			$data[] = $val;
		}

		echo json_encode($data, JSON_PRETTY_PRINT);
	}

	public function getQtyTinggi()
	{
		$this->fungsi->check_previleges('custom');
		$id       = $this->input->post('id_invoice');
		$id_item  = $this->input->post('id_item');
		$id_warna = $this->input->post('id_warna');
		$bukaan   = $this->input->post('bukaan');
		$lebar   = $this->input->post('lebar');
		$tinggi   = $this->input->post('tinggi');
		$getQtyPermintaan = $this->m_custom->getQtyItem($id, $id_item, $id_warna, $bukaan, $lebar, $tinggi)->qty;
		$getQtyReady = $this->m_custom->getQtyReadySdh($id, $id_item, $id_warna, $bukaan, $lebar, $tinggi);

		$QtyKurang = $getQtyPermintaan - $getQtyReady;

		$data['qty']    = $QtyKurang;
		echo json_encode($data);
	}

	// public function getLebarTinggi()
	// {
	// 	$this->fungsi->check_previleges('custom');
	// 	$id       = $this->input->post('id_invoice');
	// 	$id_item  = $this->input->post('id_item');
	// 	$id_warna = $this->input->post('id_warna');
	// 	$bukaan   = $this->input->post('bukaan');
	// 	$getQtyPermintaan = $this->m_custom->getLebarTinggi($id,$id_item,$id_warna,$bukaan)->qty;
	// 	$getQtyReady = $this->m_custom->getQtyReady($id,$id_item,$id_warna,$bukaan);

	// 	$QtyKurang = $getQtyPermintaan - $getQtyReady;

	// 	$data['lebar']  = $this->m_custom->getLebarTinggi($id,$id_item,$id_warna,$bukaan)->lebar;
	// 	$data['tinggi'] = $this->m_custom->getLebarTinggi($id,$id_item,$id_warna,$bukaan)->tinggi;
	// 	$data['qty']    = $QtyKurang;
	// 	echo json_encode($data);
	// }

	public function formedit($id = '')
	{
		$content   = "<div id='divsubcontent'></div>";
		$header    = "Form Edit Stock";
		$subheader = "";
		$buttons[] = button('', 'Tutup', 'btn btn-default', 'data-dismiss="modal"');
		echo $this->fungsi->parse_modal($header, $subheader, $content, $buttons, "");
		$this->fungsi->run_js('load_silent("klg/custom/show_editForm/' . $id . '","#divsubcontent")');
	}

	public function show_editForm($id = '')
	{
		$this->fungsi->check_previleges('custom');
		$this->load->library('form_validation');
		$config = array(
			array(
				'field'	=> 'id',
				'label' => 'wes mbarke',
				'rules' => ''
			),
			array(
				'field'	=> 'qty',
				'label' => 'qty',
				'rules' => 'required'
			)
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

		if ($this->form_validation->run() == FALSE) {
			$data['row'] = $this->m_custom->getRowData($id);
			$this->load->view('klg/custom/v_custom_edit', $data);
		} else {
			$datapost = get_post_data(array('id', 'qty'));
			$this->m_custom->updateData($datapost);
			$this->fungsi->run_js('load_silent("klg/custom","#content")');
			$this->fungsi->message_box("Data Master warna sukses diperbarui...", "success");
			$this->fungsi->catat($datapost, "Mengedit Master warna dengan data sbb:", true);
		}
	}

	public function deleteStock($id)
	{
		$this->fungsi->check_previleges('custom');
		$data = array('id' => $id,);

		$this->m_custom->deleteDetailItem($id);
		$this->fungsi->catat($data, "Menghapus Item custom data sbb:", true);
		$this->fungsi->message_box("Stock Custom berhasil dihapus", "success");
		$this->fungsi->run_js('load_silent("klg/custom","#content")');
	}
}

/* End of file custom.php */
/* Location: ./application/controllers/klg/custom.php */