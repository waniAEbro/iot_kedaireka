<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Mailgun\Mailgun;

$whitelist = array(
	'127.0.0.1',
	'::1'
);

if (!in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
	require '/var/www/html/alphamax/vendor/autoload.php';
}
class Retur extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('klg/m_retur');
		$this->load->model('klg/m_invoice');
	}

	public function index()
	{
		$this->fungsi->check_previleges('retur');
		$data['retur'] = $this->m_retur->getData();
		$this->load->view('klg/retur/v_retur_list', $data);
	}

	public function formAdd($value = '')
	{
		$this->fungsi->check_previleges('retur');
		$data = array(
			'no_retur'     => str_pad($this->m_retur->getNomor(), 3, '0', STR_PAD_LEFT) . '/retur' . '/' . date('m') . '/' . date('Y'),
			'item'         => $this->db->get('master_item')->result(),
			'warna'        => $this->db->get('master_warna')->result(),
			'brand'        => $this->db->get('master_brand')->result(),
			'store'        => $this->db->get('master_store')->result(),
			'alasan_retur' => $this->db->get('master_alasan_retur')->result(),
			'tipe_item'    => $this->db->get('master_tipe')->result(),
			'jenis_retur'  => $this->db->get('master_jenis_retur')->result(),
		);
		$this->load->view('klg/retur/v_retur_add', $data);
	}

	public function formEdit($id = '')
	{
		$this->fungsi->check_previleges('retur');
		$data = array(
			'edit'         => $this->m_retur->getEdit($id)->row(),
			'detail'       => $this->m_retur->getDataDetailTabel($id),
			'item'         => $this->db->get('master_item')->result(),
			'warna'        => $this->db->get('master_warna')->result(),
			'brand'        => $this->db->get('master_brand')->result(),
			'store'        => $this->db->get('master_store')->result(),
			'alasan_retur' => $this->db->get('master_alasan_retur')->result(),
			'tipe_item'    => $this->db->get('master_tipe')->result(),
			'jenis_retur'  => $this->db->get('master_jenis_retur')->result(),
		);
		$this->load->view('klg/retur/v_retur_edit', $data);
	}

	public function editRetur($value = '')
	{
		$this->fungsi->check_previleges('retur');
		$id_retur = $this->input->post('id_retur');
		$datapost = array(
			'id_store'       => $this->input->post('store'),
			'id_alasan_retur'       => $this->input->post('alasan_retur'),
			'tgl_penarikan'     => $this->input->post('tgl_penarikan'),
			'keterangan'     => $this->input->post('keterangan'),
			'tgl'            => date('Y-m-d'),
		);

		$this->m_retur->editRetur($datapost, $id_retur);
		// $data['id'] = $this->db->insert_id();

		$this->fungsi->catat($datapost, "Mengupdate retur sbb:", true);
		$data['msg'] = "retur Diedit";
		echo json_encode($data);
	}

	public function editReturImage($value = '')
	{
		$this->fungsi->check_previleges('retur');
		$upload_folder = get_upload_folder('./files/');

		$config['upload_path']   = $upload_folder;
		$config['allowed_types'] = 'pdf|jpg|png|jpeg';
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
			$id_retur = $this->input->post('id_retur');
			$datapost = array(
				'id_store'       => $this->input->post('store'),
				'id_alasan_retur'       => $this->input->post('alasan_retur'),
				'tgl_penarikan'     => $this->input->post('tgl_penarikan'),
				'keterangan'     => $this->input->post('keterangan'),
				'tgl'            => date('Y-m-d'),
				'lampiran'            => substr($upload_folder, 2) . $data['file_name'],
			);

			$this->m_retur->editRetur($datapost, $id_retur);
			// $data['id'] = $this->db->insert_id();

			$this->fungsi->catat($datapost, "Mengupdate retur sbb:", true);
			$data['msg'] = "retur Diedit";
			echo json_encode($data);
		}
	}

	public function getItemStore($value = '')
	{
		$this->fungsi->check_previleges('retur');
		$id = $this->input->post('id');
		$get_data = $this->m_retur->getItemStore($id);

		// echo $this->db->last_query();

		$data = array();

		foreach ($get_data as $val) {
			$data[] = $val;
		}

		echo json_encode($data, JSON_PRETTY_PRINT);
	}

	public function finish($id)
	{
		$whitelist = array(
			'127.0.0.1',
			'::1'
		);

		$data = array(
			'id'     => $id,
			'header' => $this->m_retur->getHeaderCetak($id)->row(),
			'isi'    => $this->m_retur->getIsiCetak($id),
		);

		if (!in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
			if ($id > 1) {
				$this->load->view('klg/retur/v_cetak_server', $data);
			}

			$detail = $this->m_retur->getRowretur($id);
			$invo = str_replace("/", "_", $data['header']->no_retur);
			$filename = BASEPATH . '/retur/' . $invo . '.pdf';
			$mg = Mailgun::create('a2cceaca998ebac8e8898da3ff8e7db5-0d2e38f7-69699916');
			$mg->messages()->send('a.alphamax.alluresystem.site', [
				'from'	=> '<no_reply@allureindustries.com>',
				'to'	=> array('imelda@allureindustries.com,bobby.armanda@allureindustries.com,kholiqtheskywalker@gmail.com,alphamax@allureindustries.com'),
				'subject' => 'Permintaan Retur ' . $data['header']->no_retur . ' ' . $data['header']->store . ' dengan jenis retur.' . $data['header']->jenis_retur,
				'html'    => $this->m_retur->template_email_retur($data['header']->id, $data['header']->store),
				'attachment' => [
					['remoteName' => $invo . '.pdf', 'filePath' => $filename]
				]
			]);
		}
		$this->fungsi->run_js('load_silent("klg/retur","#content")');
	}

	public function getDetailInvoice()
	{
		$this->fungsi->check_previleges('retur');
		$id       = $this->input->post('id');


		$data['id_item']  = $this->m_retur->getDetailInvoice($id)->id_item;
		$data['id_tipe']  = $this->m_retur->getDetailInvoice($id)->id_tipe;
		$data['id_warna'] = $this->m_retur->getDetailInvoice($id)->id_warna;
		$data['bukaan']   = $this->m_retur->getDetailInvoice($id)->bukaan;
		$data['lebar']    = $this->m_retur->getDetailInvoice($id)->lebar;
		$data['tinggi']   = $this->m_retur->getDetailInvoice($id)->tinggi;
		$data['qty']      = $this->m_retur->getDetailInvoice($id)->qty_out;
		echo json_encode($data);
	}

	public function saveRetur($value = '')
	{
		$this->fungsi->check_previleges('retur');
		$datapost = array(
			'no_retur'       => $this->input->post('no_retur'),
			'id_jenis_retur' => $this->input->post('jenis_retur'),
			'id_alasan_retur'       => $this->input->post('alasan_retur'),
			'id_store'       => $this->input->post('store'),
			'tgl_penarikan'     => $this->input->post('tgl_penarikan'),
			'keterangan'     => $this->input->post('keterangan'),
			'tgl'            => date('Y-m-d'),
		);

		$this->m_retur->insertRetur($datapost);
		$data['id'] = $this->db->insert_id();

		$this->fungsi->catat($datapost, "Menyimpan retur sbb:", true);
		$data['msg'] = "retur Disimpan";
		echo json_encode($data);
	}
	public function saveReturImage($value = '')
	{
		$this->fungsi->check_previleges('retur');
		$upload_folder = get_upload_folder('./files/');

		$config['upload_path']   = $upload_folder;
		$config['allowed_types'] = 'pdf|jpg|png|jpeg';
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
				'no_retur'       => $this->input->post('no_retur'),
				'id_jenis_retur' => $this->input->post('jenis_retur'),
				'id_alasan_retur'       => $this->input->post('alasan_retur'),
				'id_store'       => $this->input->post('store'),
				'tgl_penarikan'     => $this->input->post('tgl_penarikan'),
				'keterangan'     => $this->input->post('keterangan'),
				'tgl'            => date('Y-m-d'),
				'lampiran'            => substr($upload_folder, 2) . $data['file_name'],
			);

			$this->m_retur->insertRetur($datapost);
			$data['id'] = $this->db->insert_id();

			$this->fungsi->catat($datapost, "Menyimpan retur sbb:", true);
			$data['msg'] = "retur Disimpan";
			echo json_encode($data);
		}
	}

	public function saveReturDetail($value = '')
	{
		$this->fungsi->check_previleges('retur');
		$datapost = array(
			'id_retur'     => $this->input->post('id_retur'),

			'id_tipe'      => $this->input->post('id_tipe'),
			'id_item'      => $this->input->post('id_item'),
			'id_warna'     => $this->input->post('id_warna'),
			'bukaan'       => $this->input->post('bukaan'),
			'lebar'        => $this->input->post('lebar'),
			'tinggi'       => $this->input->post('tinggi'),
			'qty'          => $this->input->post('qty'),
			'keterangan'          => $this->input->post('keterangan'),

			'id_tipe_baru'      => $this->input->post('tipe_item'),
			'id_tipe_baru'      => $this->input->post('id_tipe_baru'),
			'id_item_baru'      => $this->input->post('id_item_baru'),
			'id_warna_baru'     => $this->input->post('id_warna_baru'),
			'bukaan_baru'       => $this->input->post('bukaan_baru'),
			'lebar_baru'        => $this->input->post('lebar_baru'),
			'tinggi_baru'       => $this->input->post('tinggi_baru'),
			'qty_baru'          => $this->input->post('qty_baru'),
			'keterangan_baru'   => $this->input->post('keterangan_baru'),
		);
		$this->m_retur->insertReturDetail($datapost);
		$data['id'] = $this->db->insert_id();

		$this->fungsi->catat($datapost, "Menyimpan item retur sbb:", true);
		$data['msg'] = "retur Disimpan";
		echo json_encode($data);
	}

	public function getDetailTabel($value = '')
	{
		$this->fungsi->check_previleges('retur');
		$id_sku = $this->input->post('id_sku');
		$data['detail'] = $this->m_retur->getDataDetailTabel($id_sku);
		echo json_encode($data);
	}

	public function deleteRetur($id)
	{
		$this->fungsi->check_previleges('retur');
		$data = array('id' => $id,);

		$this->m_retur->deleteRetur($id);
		$this->m_retur->deleteDetailRetur($id);
		$this->fungsi->catat($data, "Menghapus retur data sbb:", true);
		$this->fungsi->run_js('load_silent("klg/retur","#content")');
		$this->fungsi->message_box("Berhasil menghapus retur", "success");
	}

	public function setujui($id = '', $id_jenis_retur = '')
	{
		$this->fungsi->check_previleges('retur');
		$getRow = $this->m_retur->getRowretur($id);
		$getDetail = $this->m_retur->getDetailretur($id);

		if ($id_jenis_retur == 1) {
			$datapermintaan = array(
				'id_brand'       => 1,
				'no_invoice'     => $getRow->no_retur,
				'no_po'          => '',
				'project_owner'  => '',
				'id_store'       => $getRow->id_store,
				'alamat_proyek'  => '',
				'no_telp'        => '',
				'tgl_pengiriman' => date('Y-m-d'),
				'date' => date('Y-m-d H:i:s'),
				'timestamp' => date('Y-m-d H:i:s'),
				'lampiran'       => '',
				'is_retur'       => '2',
				'id_retur'    => $id,
			);
			$this->m_invoice->insertInvoice($datapermintaan);
			$id_permintaan = $this->db->insert_id();
			foreach ($getDetail->result() as $row) {
				$datadetailpermintaan = array(
					'id_invoice' => $id_permintaan,
					'id_tipe'    => $row->id_tipe_baru,
					'id_item'    => $row->id_item_baru,
					'id_warna'   => $row->id_warna_baru,
					'bukaan'     => $row->bukaan_baru,
					'lebar'      => $row->lebar_baru,
					'tinggi'     => $row->tinggi_baru,
					'qty'        => $row->qty_baru,
					'keterangan' => 'RETUR',
					'harga'      => '',
					'date'       => date('Y-m-d'),
				);
				$this->m_invoice->insertInvoiceDetail($datadetailpermintaan);

				// $datastok = array(
				// 	'id_produksi' => $this->m_retur->getMaxProduksi(),
				// 	'id_retur'    => $id,
				// 	'id_tipe'     => $row->id_tipe,
				// 	'id_item'     => $row->id_item,
				// 	'id_warna'    => $row->id_warna,
				// 	'bukaan'      => $row->bukaan,
				// 	'lebar'       => $row->lebar,
				// 	'tinggi'      => $row->tinggi,
				// 	'qty'         => $row->qty,
				// 	'keterangan'  => 'retur pengganti',
				// 	'inout'       => 1,
				// 	'is_retur'    => 2,
				// );
				// $this->m_retur->insertStok($datastok);

				$datawareout = array(
					'id_store'    => $getRow->id_store,
					'id_tipe'     => $row->id_tipe,
					'id_item'     => $row->id_item,
					'id_warna'    => $row->id_warna,
					'bukaan'      => $row->bukaan,
					'lebar'       => $row->lebar,
					'tinggi'      => $row->tinggi,
					'qty_out'     => $row->qty,
				);
				$this->m_retur->insertStokWarehouse($datawareout);
			}
		} elseif ($id_jenis_retur == 2) {
			$datapermintaanz = array(
				'id_brand'       => 1,
				'no_invoice'     => $getRow->no_retur,
				'no_po'          => '',
				'project_owner'  => '',
				'id_store'       => $getRow->id_store,
				'alamat_proyek'  => '',
				'no_telp'        => '',
				'tgl_pengiriman' => date('Y-m-d'),
				'date' => date('Y-m-d H:i:s'),
				'timestamp' => date('Y-m-d H:i:s'),
				'lampiran'       => '',
				'is_retur'       => '2',
				'id_retur'    => $id,
			);
			$this->m_invoice->insertInvoice($datapermintaanz);
			$id_permintaanz = $this->db->insert_id();
			foreach ($getDetail->result() as $row) {
				$datadetailpermintaanz = array(
					'id_invoice' => $id_permintaanz,
					'id_tipe'    => $row->id_tipe,
					'id_item'    => $row->id_item,
					'id_warna'   => $row->id_warna,
					'bukaan'     => $row->bukaan,
					'lebar'      => $row->lebar,
					'tinggi'     => $row->tinggi,
					'qty'        => $row->qty,
					'keterangan' => 'RETUR',
					'harga'      => '',
					'date'       => date('Y-m-d'),
				);
				$this->m_invoice->insertInvoiceDetail($datadetailpermintaanz);


				$datawareoutz = array(
					'id_store'    => $getRow->id_store,
					'id_tipe'     => $row->id_tipe,
					'id_item'     => $row->id_item,
					'id_warna'    => $row->id_warna,
					'bukaan'      => $row->bukaan,
					'lebar'       => $row->lebar,
					'tinggi'      => $row->tinggi,
					'qty_out'     => $row->qty,
				);
				$this->m_retur->insertStokWarehouse($datawareoutz);
			}
		} elseif ($id_jenis_retur == 4) {
			foreach ($getDetail->result() as $row) {
				// $datastok = array(
				// 	'id_produksi' => $this->m_retur->getMaxProduksi(),
				// 	'id_retur'    => $id,
				// 	'id_tipe'     => $row->id_tipe,
				// 	'id_item'     => $row->id_item,
				// 	'id_warna'    => $row->id_warna,
				// 	'bukaan'      => $row->bukaan,
				// 	'lebar'       => $row->lebar,
				// 	'tinggi'      => $row->tinggi,
				// 	'qty'         => $row->qty,
				// 	'keterangan'  => 'retur repair',
				// 	'inout'       => 1,
				// 	'is_retur'    => 2,
				// );
				// $this->m_retur->insertStok($datastok);
				if ($id_jenis_retur == 2) {
					$datawareout = array(
						'id_store'    => $getRow->id_store,
						'id_tipe'     => $row->id_tipe,
						'id_item'     => $row->id_item,
						'id_warna'    => $row->id_warna,
						'bukaan'      => $row->bukaan,
						'lebar'       => $row->lebar,
						'tinggi'      => $row->tinggi,
						'qty_out'     => $row->qty,
					);
					$this->m_retur->insertStokWarehouse($datawareout);
				}
			}
		} else {
			foreach ($getDetail->result() as $row) {
				// $datastok = array(
				// 	'id_produksi' => $this->m_retur->getMaxProduksi(),
				// 	'id_retur'    => $id,
				// 	'id_tipe'     => $row->id_tipe_baru,
				// 	'id_item'     => $row->id_item_baru,
				// 	'id_warna'    => $row->id_warna_baru,
				// 	'bukaan'      => $row->bukaan_baru,
				// 	'lebar'       => $row->lebar_baru,
				// 	'tinggi'      => $row->tinggi_baru,
				// 	'qty'         => $row->qty_baru,
				// 	'keterangan'  => 'retur kanibal',
				// 	'inout'       => 1,
				// 	'is_retur'    => 2,
				// );
				// $this->m_retur->insertStok($datastok);

				$datawareout = array(
					'id_store'    => $getRow->id_store,
					'id_tipe'     => $row->id_tipe,
					'id_item'     => $row->id_item,
					'id_warna'    => $row->id_warna,
					'bukaan'      => $row->bukaan,
					'lebar'       => $row->lebar,
					'tinggi'      => $row->tinggi,
					'qty_out'     => $row->qty,
				);
				$this->m_retur->insertStokWarehouse($datawareout);
			}
		}

		$this->m_retur->updateStatus($id);
		$this->fungsi->run_js('load_silent("klg/retur","#content")');
		$this->fungsi->message_box("Berhasil retur", "success");
	}

	// public function setujuiaa($id = '')
	// {
	// 	$this->fungsi->check_previleges('retur');
	// 	$getDetail = $this->m_retur->getDetailretur($id);

	// 	if ($getDetail->id_jenis_retur == '3') {
	// 		// $datastokkanibal = array(
	// 		// 	'id_produksi' => $this->m_retur->getMaxProduksi(),
	// 		// 	'id_retur'    => $id,
	// 		// 	'id_tipe'     => $getDetail->id_tipe_baru,
	// 		// 	'id_item'     => $getDetail->id_item_baru,
	// 		// 	'id_warna'    => $getDetail->id_warna_baru,
	// 		// 	'bukaan'      => $getDetail->bukaan_baru,
	// 		// 	'lebar'       => $getDetail->lebar_baru,
	// 		// 	'tinggi'      => $getDetail->tinggi_baru,
	// 		// 	'qty_out'     => $getDetail->qty_baru,
	// 		// 	'keterangan'  => 'retur kanibal',
	// 		// 	'inout'       => 1,
	// 		// 	'is_retur'    => 2,
	// 		// );
	// 		// $this->m_retur->insertStok($datastokkanibal);
	// 	} else {
	// 		$datapermintaan = array(
	// 			'id_brand'       => $getDetail->id_brand,
	// 			'no_invoice'     => str_pad($this->m_invoice->getInvoice(), 3, '0', STR_PAD_LEFT) . '/orderbyretur' . '/' . date('m') . '/' . date('Y'),
	// 			'no_po'          => $getDetail->no_po,
	// 			'project_owner'  => $getDetail->project_owner,
	// 			'id_store'       => $getDetail->id_store,
	// 			'alamat_proyek'  => $getDetail->alamat_proyek,
	// 			'no_telp'        => $getDetail->no_telp,
	// 			'tgl_pengiriman' => $getDetail->tgl_kirim,
	// 			'lampiran'       => '',
	// 			'is_retur'       => '2',
	// 			'id_retur'    => $id,
	// 		);
	// 		$this->m_invoice->insertInvoice($datapermintaan);
	// 		$id_permintaan = $this->db->insert_id();

	// 		$datadetailpermintaan = array(
	// 			'id_invoice' => $id_permintaan,
	// 			'id_tipe'    => $getDetail->id_tipe_baru,
	// 			'id_item'    => $getDetail->id_item_baru,
	// 			'id_warna'   => $getDetail->id_warna_baru,
	// 			'bukaan'     => $getDetail->bukaan_baru,
	// 			'lebar'      => $getDetail->lebar_baru,
	// 			'tinggi'     => $getDetail->tinggi_baru,
	// 			'qty'        => $getDetail->qty_baru,
	// 			'keterangan' => 'RETUR',
	// 			'harga'      => '',
	// 			'date'       => date('Y-m-d'),
	// 		);
	// 		$this->m_invoice->insertInvoiceDetail($datadetailpermintaan);


	// 		// $datastok = array(
	// 		// 	'id_produksi' => $this->m_retur->getMaxProduksi(),
	// 		// 	'id_retur'    => $id,
	// 		// 	'id_tipe'     => $getDetail->id_tipe,
	// 		// 	'id_item'     => $getDetail->id_item,
	// 		// 	'id_warna'    => $getDetail->id_warna,
	// 		// 	'bukaan'      => $getDetail->bukaan,
	// 		// 	'lebar'       => $getDetail->lebar,
	// 		// 	'tinggi'      => $getDetail->tinggi,
	// 		// 	'qty'         => $getDetail->qty,
	// 		// 	'keterangan'  => 'retur',
	// 		// 	'inout'       => 1,
	// 		// 	'is_retur'    => 2,
	// 		// );
	// 		// 	$this->m_retur->insertStok($datastok);

	// 		$datawareout = array(
	// 			'id_store'    => $getDetail->id_store,
	// 			'id_tipe'     => $getDetail->id_tipe,
	// 			'id_item'     => $getDetail->id_item,
	// 			'id_warna'    => $getDetail->id_warna,
	// 			'bukaan'      => $getDetail->bukaan,
	// 			'lebar'       => $getDetail->lebar,
	// 			'tinggi'      => $getDetail->tinggi,
	// 			'qty_out'     => $getDetail->qty,
	// 		);
	// 		$this->m_retur->insertStokWarehouse($datawareout);
	// 	}
	// 	$this->m_retur->updateStatus($id);
	// 	$this->fungsi->run_js('load_silent("klg/retur","#content")');
	// 	$this->fungsi->message_box("Berhasil retur", "success");
	// }

	public function cetak($id)
	{
		$data = array(
			'id'     => $id,
			'header' => $this->m_retur->getHeaderCetak($id)->row(),
			'isi'    => $this->m_retur->getIsiCetak($id),
		);
		$this->load->view('klg/retur/v_cetak', $data);
	}















	public function getDetailItem()
	{
		// $this->fungsi->check_previleges('retur');
		$id = $this->input->post('item');

		$data['gambar'] = $this->m_invoice->getRowDetailItem($id)->gambar;
		$data['lebar'] = $this->m_invoice->getRowDetailItem($id)->lebar;
		$data['tinggi'] = $this->m_invoice->getRowDetailItem($id)->tinggi;
		$data['harga'] = $this->m_invoice->getRowDetailItem($id)->harga;
		$data['id_jenis_barang'] = $this->m_invoice->getRowDetailItem($id)->id_jenis_barang;
		$data['jenis_barang'] = $this->m_invoice->getRowDetailItem($id)->jenis_barang;
		echo json_encode($data);
	}

	public function deleteItem()
	{
		$this->fungsi->check_previleges('retur');
		$id = $this->input->post('id');
		$data = array('id' => $id,);

		$this->m_retur->deleteDetailItem($id);
		$this->fungsi->catat($data, "Menghapus Item retur data sbb:", true);
		$respon = ['msg' => 'Data Berhasil Dihapus'];
		echo json_encode($respon);
	}





	public function detail($id = '')
	{
		$this->fungsi->check_previleges('retur');
		$data['retur'] = $this->m_retur->getDetail($id);
		$this->load->view('klg/retur/v_retur_detail', $data);
	}
}

/* End of file retur.php */
/* Location: ./application/controllers/klg/retur.php */