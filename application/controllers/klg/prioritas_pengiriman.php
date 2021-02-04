<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Prioritas_pengiriman extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('klg/m_prioritas_pengiriman');
		$this->load->model('klg/m_invoice');
		$this->load->model('klg/m_pengiriman');
	}

	public function index()
	{
		$this->fungsi->check_previleges('prioritas_pengiriman');
		$data['prioritas'] = $this->m_prioritas_pengiriman->getData();
		$data['tgl'] = $this->m_prioritas_pengiriman->getTanggal();
		$data['tglkirim'] = '';
		$data['store'] = $this->m_prioritas_pengiriman->getStore();
		$data['storemitra'] = '';
		$this->load->view('klg/prioritas_pengiriman/v_prioritas_pengiriman_list', $data);
	}

	public function diSet($tgl, $store)
	{
		$this->fungsi->check_previleges('prioritas_pengiriman');
		$data['prioritas'] = $this->m_prioritas_pengiriman->getDataFilter($tgl, $store);
		$data['tgl'] = $this->m_prioritas_pengiriman->getTanggal();
		$data['tglkirim'] = $tgl;
		$data['store'] = $this->m_prioritas_pengiriman->getStore();
		$data['storemitra'] = $store;
		$this->load->view('klg/prioritas_pengiriman/v_prioritas_pengiriman_list', $data);
	}

	public function formAdd($value = '')
	{
		$this->fungsi->check_previleges('prioritas_pengiriman');

		$data['no_invoice'] = get_options($this->db->query('select id, no_invoice from data_invoice'), true);
		$this->load->view('klg/prioritas_pengiriman/v_prioritas_pengiriman_add', $data);
	}

	public function insert($value = '')
	{
		$this->fungsi->check_previleges('prioritas_pengiriman');
		$datapost = array(
			'id_invoice'    => $this->input->post('id_invoice'),
			'tgl_prioritas' => $this->input->post('tgl_prioritas'),
			'alasan'        => $this->input->post('alasan'),
			'keterangan'    => $this->input->post('keterangan'),
		);
		$this->m_prioritas_pengiriman->insertData($datapost);
		$this->fungsi->catat($datapost, "Menambah Prioritas Pengiriman :", true);
		$data['msg'] = "Prioritas Pengiriman Disimpan!";
		echo json_encode($data);
	}

	public function form($param = '')
	{
		$content   = "<div id='divsubcontent'></div>";
		$header    = "Form Ubah Tgl Pengiriman";
		$subheader = "";
		$buttons[] = button('jQuery.facebox.close()', 'Tutup', 'btn btn-default', 'data-dismiss="modal"');
		echo $this->fungsi->parse_modal($header, $subheader, $content, $buttons, "");

		$this->fungsi->run_js('load_silent("klg/prioritas_pengiriman/show_editForm/' . $param . '","#divsubcontent")');
	}

	public function show_editForm($id = '')
	{
		$this->fungsi->check_previleges('prioritas_pengiriman');
		$this->load->library('form_validation');
		$config = array(
			array(
				'field'	=> 'id',
				'label' => 'wes mbarke',
				'rules' => ''
			),
			array(
				'field'	=> 'tgl_pengiriman',
				'label' => 'tgl_pengiriman',
				'rules' => 'required'
			)
		);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

		if ($this->form_validation->run() == FALSE) {
			$data['edit'] = $this->db->get_where('data_invoice', array('id' => $id));
			$this->load->view('klg/prioritas_pengiriman/v_prioritas_pengiriman_edit', $data);
		} else {
			$datapost = get_post_data(array('id', 'tgl_pengiriman'));
			$this->m_prioritas_pengiriman->updateData($datapost);
			$this->fungsi->run_js('load_silent("klg/prioritas_pengiriman","#content")');
			$this->fungsi->message_box("Tgl Pengiriman diperbarui", "success");
			$this->fungsi->catat($datapost, "Mengubah tgl pengiriman", true);
		}
	}

	public function kirim($id = '')
	{
		$this->fungsi->check_previleges('prioritas_pengiriman');
		$data = array(
			'detail'           => $this->m_invoice->getDataDetailTabel($id),
			'rowPermintaan'    => $this->m_prioritas_pengiriman->rowPermintaan($id),
			'nomor_pengiriman' => str_pad($this->m_pengiriman->getpengiriman(), 3, '0', STR_PAD_LEFT) . '/send' . '/' . date('m') . '/' . date('Y'),
			'id_invoice'            => $id,
		);
		$this->load->view('klg/prioritas_pengiriman/v_prioritas_pengiriman_kirim', $data);
	}


	public function savepengiriman($value = '')
	{
		$this->fungsi->check_previleges('prioritas_pengiriman');
		$obj = array('tgl_pengiriman' => date('Y-m-d'),);
		$this->db->where('id', $this->input->post('id_invoice'));
		$this->db->update('data_invoice', $obj);
		$datapost = array(
			'no_pengiriman' => $this->input->post('no_pengiriman'),
			'id_invoice'    => $this->input->post('id_invoice'),
			'sopir'         => $this->input->post('sopir'),
			'no_polisi'     => $this->input->post('no_polisi'),
			'keterangan'     => $this->input->post('keterangan'),
			'date'          => date('Y-m-d H:i:s'),
			'lampiran'      => '',
		);
		$this->m_pengiriman->insertpengiriman($datapost);
		$id_surat_jalan = $this->db->insert_id();



		$this->fungsi->catat($datapost, "Menyimpan pengiriman sbb:", true);
		$data['id'] = $id_surat_jalan;
		$data['msg'] = "pengiriman Disimpan";
		echo json_encode($data);
	}

	public function savepengirimanImage($value = '')
	{
		$this->fungsi->check_previleges('prioritas_pengiriman');
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
			$obj = array('tgl_pengiriman' => date('Y-m-d'),);
			$this->db->where('id', $this->input->post('id_invoice'));
			$this->db->update('data_invoice', $obj);
			$datapost = array(
				'no_pengiriman' => $this->input->post('no_pengiriman'),
				'id_invoice'    => $this->input->post('id_invoice'),
				'sopir'         => $this->input->post('sopir'),
				'no_polisi'     => $this->input->post('no_polisi'),
				'keterangan'     => $this->input->post('keterangan'),
				'date'          => date('Y-m-d H:i:s'),
				'lampiran'      => substr($upload_folder, 2) . $data['file_name'],
			);
			$this->m_pengiriman->insertpengiriman($datapost);
			$id_surat_jalan = $this->db->insert_id();


			$this->fungsi->catat($datapost, "Menyimpan pengiriman sbb:", true);
			$data['id'] = $id_surat_jalan;
			$data['msg'] = "pengiriman Disimpan";
			echo json_encode($data);
		}
	}

	public function updatepengiriman($value = '')
	{
		$this->fungsi->check_previleges('prioritas_pengiriman');
		$id = $this->input->post('id_pengiriman');
		$datapost = array(
			'no_pengiriman' => $this->input->post('no_pengiriman'),
			'id_invoice'    => $this->input->post('id_invoice'),
			'sopir'         => $this->input->post('sopir'),
			'no_polisi'     => $this->input->post('no_polisi'),
			'keterangan'     => $this->input->post('keterangan'),
			'lampiran'      => '',
		);
		$this->m_pengiriman->updatepengiriman($datapost, $id);

		$this->fungsi->catat($datapost, "Menyimpan pengiriman sbb:", true);
		$data['msg'] = "pengiriman Disimpan";
		echo json_encode($data);
	}

	public function updatepengirimanImage($value = '')
	{
		$this->fungsi->check_previleges('prioritas_pengiriman');
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
			$id = $this->input->post('id_pengiriman');
			$datapost = array(
				'no_pengiriman' => $this->input->post('no_pengiriman'),
				'id_invoice'    => $this->input->post('id_invoice'),
				'sopir'         => $this->input->post('sopir'),
				'no_polisi'     => $this->input->post('no_polisi'),
				'keterangan'     => $this->input->post('keterangan'),
				'date'          => date('Y-m-d H:i:s'),
				'lampiran'      => substr($upload_folder, 2) . $data['file_name'],
			);
			$this->m_pengiriman->updatepengiriman($datapost, $id);


			$this->fungsi->catat($datapost, "Menyimpan pengiriman sbb:", true);
			$data['msg'] = "pengiriman Disimpan";
			echo json_encode($data);
		}
	}

	public function savepengirimanDetail()
	{
		$this->fungsi->check_previleges('prioritas_pengiriman');
		$id_did = $this->input->post('id_did');
		$id_store = $this->input->post('id_store');
		$id_pengiriman = $this->input->post('id_pengiriman');
		$qty = $this->input->post('qty');

		$row_did = $this->m_prioritas_pengiriman->getRowdid($id_did);
		$validasi = $this->m_prioritas_pengiriman->getValidasi($id_pengiriman, $row_did->id_item, $row_did->id_tipe, $row_did->id_warna, $row_did->bukaan, $row_did->lebar, $row_did->tinggi);
		if ($validasi == 'y') {
			$obj = array(
				'id_invoice'     => $row_did->id_invoice,
				'id_surat_jalan' => $id_pengiriman,
				'id_tipe'        => $row_did->id_tipe,
				'id_item'        => $row_did->id_item,
				'id_warna'       => $row_did->id_warna,
				'bukaan'         => $row_did->bukaan,
				'lebar'          => $row_did->lebar,
				'tinggi'         => $row_did->tinggi,
				'qty_out'        => $qty,
				'harga'          => $row_did->harga,
				'inout'          => 2,
			);
			$this->m_pengiriman->insertdetailpengiriman($obj);

			$warehouse = array(
				'id_invoice'     => $row_did->id_invoice,
				'id_surat_jalan' => $id_pengiriman,
				'id_store'       => $id_store,
				'id_tipe'        => $row_did->id_tipe,
				'id_item'        => $row_did->id_item,
				'id_warna'       => $row_did->id_warna,
				'bukaan'         => $row_did->bukaan,
				'lebar'          => $row_did->lebar,
				'tinggi'         => $row_did->tinggi,
				'qty'        => $qty,
				'harga'          => $row_did->harga,
			);
			$this->m_pengiriman->insertWarehouse($warehouse);
			$data['id'] = $this->db->insert_id();
		}
		$tot_permintaan = $this->m_prioritas_pengiriman->getTotPermintaan($row_did->id_invoice);
		$tot_kirim = $this->m_prioritas_pengiriman->getTotKirim($row_did->id_invoice);

		if ($tot_permintaan == $tot_kirim) {
			$updt = array('id_status' => 2,);

			$this->m_prioritas_pengiriman->updateStatusInvoice($row_did->id_invoice, $updt);
		}
		$data['x'] = $validasi;
		echo json_encode($data);
	}

	public function updatepengirimanDetail()
	{
		$this->fungsi->check_previleges('prioritas_pengiriman');
		$id_did = $this->input->post('id_did');
		$id_store = $this->input->post('id_store');
		$id_pengiriman = $this->input->post('id_pengiriman');
		$qty = $this->input->post('qty');

		$row_did = $this->m_prioritas_pengiriman->getRowdid($id_did);
		// $validasi = $this->m_prioritas_pengiriman->getValidasi($id_pengiriman, $row_did->id_item, $row_did->id_tipe, $row_did->id_warna, $row_did->bukaan, $row_did->lebar, $row_did->tinggi);
		// if ($validasi == 'y') {
		// $obj = array(
		// 	'id_invoice'     => $row_did->id_invoice,
		// 	'id_surat_jalan' => $id_pengiriman,
		// 	'id_tipe'        => $row_did->id_tipe,
		// 	'id_item'        => $row_did->id_item,
		// 	'id_warna'       => $row_did->id_warna,
		// 	'bukaan'         => $row_did->bukaan,
		// 	'lebar'          => $row_did->lebar,
		// 	'tinggi'         => $row_did->tinggi,
		// 	'qty_out'        => $qty,
		// 	'harga'          => $row_did->harga,
		// 	'inout'          => 2,
		// );
		$this->m_prioritas_pengiriman->updateqtysend($id_pengiriman, $row_did->id_item, $row_did->id_tipe, $row_did->id_warna, $row_did->bukaan, $row_did->lebar, $row_did->tinggi, $qty);

		// $warehouse = array(
		// 	'id_invoice'     => $row_did->id_invoice,
		// 	'id_surat_jalan' => $id_pengiriman,
		// 	'id_store'       => $id_store,
		// 	'id_tipe'        => $row_did->id_tipe,
		// 	'id_item'        => $row_did->id_item,
		// 	'id_warna'       => $row_did->id_warna,
		// 	'bukaan'         => $row_did->bukaan,
		// 	'lebar'          => $row_did->lebar,
		// 	'tinggi'         => $row_did->tinggi,
		// 	'qty'        => $qty,
		// 	'harga'          => $row_did->harga,
		// );
		$this->m_prioritas_pengiriman->updateqtywarehouse($id_pengiriman, $row_did->id_item, $row_did->id_tipe, $row_did->id_warna, $row_did->bukaan, $row_did->lebar, $row_did->tinggi, $qty);
		// $data['id'] = $this->db->insert_id();
		// }
		// $tot_permintaan = $this->m_prioritas_pengiriman->getTotPermintaan($row_did->id_invoice);
		// $tot_kirim = $this->m_prioritas_pengiriman->getTotKirim($row_did->id_invoice);

		// if ($tot_permintaan == $tot_kirim) {
		// 	$updt = array('id_status' => 2,);

		// 	$this->m_prioritas_pengiriman->updateStatusInvoice($row_did->id_invoice, $updt);
		// }
		$data['x'] = '';
		echo json_encode($data);
	}
}

/* End of file prioritas_pengiriman.php */
/* Location: ./application/controllers/klg/prioritas_pengiriman.php */