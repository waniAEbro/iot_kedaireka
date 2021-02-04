<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class retur extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('klg/m_retur_lama');
		$this->load->model('klg/m_retur');
		$this->load->model('klg/m_invoice');

	}

	public function index()
	{
		$this->fungsi->check_previleges('retur');
		$data['retur'] = $this->m_retur->getData();
		$this->load->view('klg/retur/v_retur_list',$data);
	}

	public function formAdd($value='')
	{
		$this->fungsi->check_previleges('retur');
		$data = array(
			'no_pengiriman' => $this->m_retur->getNoPengiriman(),
			'tipe_invoice'  => $this->db->get('master_tipe')->result(),
			'item'          => $this->db->get('master_item')->result(),
			'warna'         => $this->db->get('master_warna')->result(),
			 );
		$this->load->view('klg/retur/v_retur_add',$data);
	}

	public function formEdit($id='')
	{
		$this->fungsi->check_previleges('retur');
		$data = array(
			'row' => $this->m_retur->getEditRetur($id)->row(),
			'id_retur' => $id,
			'no_pengiriman' => $this->m_retur->getNoPengiriman(),
			'tipe_invoice'  => $this->db->get('master_tipe')->result(),
			'item'          => $this->db->get('master_item')->result(),
			'warna'         => $this->db->get('master_warna')->result(),
			 );
		$this->load->view('klg/retur/v_retur_edit',$data);
	}

	public function deleteItem() {
		$this->fungsi->check_previleges('retur');
		$id = $this->input->post('id');
		$data = array('id' => $id, );
		
		$this->m_retur->deleteDetailItem($id);
		$this->fungsi->catat($data,"Menghapus Item retur data sbb:",true);
		$respon = ['msg' => 'Data Berhasil Dihapus'];
		echo json_encode($respon);
	}

	public function savereturDetail($value='')
	{
		$this->fungsi->check_previleges('retur');
		
	  	$datapost = array(
			'id_surat_jalan' => $this->input->post('id_surat_jalan'), 
			'id_item'        => $this->input->post('item'), 
			'id_tipe'        => $this->input->post('tipe'), 
			'id_warna'       => $this->input->post('warna'), 
			'bukaan'         => $this->input->post('bukaan'),
			'lebar'          => $this->input->post('lebar'), 
			'tinggi'         => $this->input->post('tinggi'), 
			'qty'            => $this->input->post('qty'), 
			'keterangan'     => $this->input->post('keterangan'),

			'id_tipe_baru'        => $this->input->post('tipe_baru'), 
			'id_item_baru'        => $this->input->post('item_baru'), 
			'id_warna_baru'       => $this->input->post('warna_baru'), 
			'bukaan_baru'         => $this->input->post('bukaan_baru'),
			'lebar_baru'          => $this->input->post('lebar_baru'), 
			'tinggi_baru'         => $this->input->post('tinggi_baru'), 
			'qty_baru'            => $this->input->post('qty_baru'),
 		);
	    $this->m_retur->insertreturDetail($datapost);
	    $data['id'] = $this->db->insert_id();
		$this->fungsi->catat($datapost,"Menyimpan item retur sbb:",true);
		$data['msg'] = "retur Disimpan";
		echo json_encode($data);
	}

	public function editreturDetail($value='')
	{
		$this->fungsi->check_previleges('retur');
		$id_retur = $this->input->post('id_retur');
	  	$datapost = array(

			'id_tipe_baru'        => $this->input->post('tipe_baru'), 
			'id_item_baru'        => $this->input->post('item_baru'), 
			'id_warna_baru'       => $this->input->post('warna_baru'), 
			'bukaan_baru'         => $this->input->post('bukaan_baru'),
			'lebar_baru'          => $this->input->post('lebar_baru'), 
			'tinggi_baru'         => $this->input->post('tinggi_baru'), 
			'qty_baru'            => $this->input->post('qty_baru'),
 		);
	    $this->m_retur->updatereturDetail($datapost,$id_retur);
	    $data['id'] = $this->db->insert_id();
		$this->fungsi->catat($datapost,"Menyimpan item retur sbb:",true);
		$data['msg'] = "retur Disimpan";
		echo json_encode($data);
	}

	public function getItemInvoice($value='')
	{
		$this->fungsi->check_previleges('retur');
		$id = $this->input->post('id');
		$get_data = $this->m_retur->getItemInvoice($id);

		// echo $this->db->last_query();
		
		$data = array();

		foreach ($get_data as $val) {
			$data[] = $val;
		}

		echo json_encode($data, JSON_PRETTY_PRINT);
	}

	public function getWarnaItem($value='')
	{
		$this->fungsi->check_previleges('retur');
		$id = $this->input->post('id_invoice');
		$id_item = $this->input->post('id_item');
		$get_data = $this->m_retur->getWarnaItem($id,$id_item);

		// echo $this->db->last_query();
		
		$data = array();

		foreach ($get_data as $val) {
			$data[] = $val;
		}

		echo json_encode($data, JSON_PRETTY_PRINT);
	}

	public function getBukaanItem($value='')
	{
		$this->fungsi->check_previleges('retur');
		$id = $this->input->post('id_invoice');
		$id_item = $this->input->post('id_item');
		$id_warna = $this->input->post('id_warna');
		$get_data = $this->m_retur->getBukaanItem($id,$id_item,$id_warna);

		// echo $this->db->last_query();
		
		$data = array();

		foreach ($get_data as $val) {
			$data[] = $val;
		}

		echo json_encode($data, JSON_PRETTY_PRINT);
	}

	public function getLebarTinggi()
	{
		$this->fungsi->check_previleges('retur');
		$id       = $this->input->post('id_invoice');
		$id_item  = $this->input->post('id_item');
		$id_warna = $this->input->post('id_warna');
		$bukaan   = $this->input->post('bukaan');

		
		$data['lebar']  = $this->m_retur->getLebarTinggi($id,$id_item,$id_warna,$bukaan)->lebar;
		$data['tinggi'] = $this->m_retur->getLebarTinggi($id,$id_item,$id_warna,$bukaan)->tinggi;
		$data['qty']    = $this->m_retur->getLebarTinggi($id,$id_item,$id_warna,$bukaan)->qty;
		echo json_encode($data);
	}

	public function getNoInvoice()
	{
		$this->fungsi->check_previleges('retur');
		$id       = $this->input->post('id');

		
		$data['no_invoice']  = $this->m_retur->getNoInvoice($id)->no_invoice;
		$data['id_surat_jalan'] = $id;
		echo json_encode($data);
	}

	public function getDetailInvoice()
	{
		$this->fungsi->check_previleges('retur');
		$id       = $this->input->post('id');

		
		$data['id_invoice']  = $this->m_retur->getDetailInvoice($id)->id_invoice;
		$data['id_item']  = $this->m_retur->getDetailInvoice($id)->id_item;
		$data['id_tipe']  = $this->m_retur->getDetailInvoice($id)->id_tipe;
		$data['id_warna'] = $this->m_retur->getDetailInvoice($id)->id_warna;
		$data['bukaan']   = $this->m_retur->getDetailInvoice($id)->bukaan;
		$data['lebar']    = $this->m_retur->getDetailInvoice($id)->lebar;
		$data['tinggi']   = $this->m_retur->getDetailInvoice($id)->tinggi;
		$data['qty']      = $this->m_retur->getDetailInvoice($id)->qty_out;
		echo json_encode($data);
	}

	public function getDetailItem()
	{
		$this->fungsi->check_previleges('invoice');
		$id = $this->input->post('item');
		
		$data['gambar'] = $this->m_invoice->getRowDetailItem($id)->gambar;
		$data['lebar'] = $this->m_invoice->getRowDetailItem($id)->lebar;
		$data['tinggi'] = $this->m_invoice->getRowDetailItem($id)->tinggi;
		$data['harga'] = $this->m_invoice->getRowDetailItem($id)->harga;
		echo json_encode($data);
	}

	public function setujui($id='')
	{
		$this->fungsi->check_previleges('retur');
		$getDetail = $this->m_retur->getDetailRetur($id);
		$id_tipe = $getDetail->id_tipe;
		$n_i = str_pad($getDetail->id, 3, '0', STR_PAD_LEFT).'/retur'.'/'.date('m').'/'.date('Y');
		$datapermintaan = array(
			'id_brand'       => $getDetail->id_brand,  
			'no_invoice'     => $n_i, 
			'no_po'          => $getDetail->no_po,
			'project_owner'  => $getDetail->project_owner,
			'id_store'       => $getDetail->id_store, 
			'alamat_proyek'  => $getDetail->alamat_proyek, 
			'no_telp'        => $getDetail->no_telp, 
			'tgl_pengiriman' => date('Y-m-d'), 
			'intruction'     => 'RETUR', 
			'lampiran'       => '', 		
			);
		$this->m_invoice->insertInvoice($datapermintaan);
	    $id_permintaan = $this->db->insert_id();

	    $datadetailpermintaan = array(
			'id_invoice' => $id_permintaan, 
			'id_tipe'    => $getDetail->id_tipe_baru, 
			'id_item'    => $getDetail->id_item_baru,
			'id_warna'   => $getDetail->id_warna_baru,
			'bukaan'     => $getDetail->bukaan_baru,
			'lebar'      => $getDetail->lebar_baru,
			'tinggi'     => $getDetail->tinggi_baru,
			'qty'        => $getDetail->qty_baru,
			'keterangan' => 'RETUR', 
			'harga'      => '', 
			'date'       => date('Y-m-d'), 
 		);
	    $this->m_invoice->insertInvoiceDetail($datadetailpermintaan);

	    $datapost = array(
			'id_produksi' => $this->m_retur->getMaxProduksi(),
			'id_retur'    => $id,
			'id_tipe'     => $id_tipe, 
			'id_item'     => $getDetail->id_item,
			'id_warna'    => $getDetail->id_warna,
			'bukaan'      => $getDetail->bukaan,
			'lebar'       => $getDetail->lebar,
			'tinggi'      => $getDetail->tinggi,
			'qty'         => $getDetail->qty,
			'keterangan'  => 'retur',
			'inout'       => 1,
			'is_retur'    => 1,
 		);
			$this->m_retur->insertStok($datapost);

		$datawareout = array(
			'id_store'    => $getDetail->id_store,
			'id_tipe'     => $getDetail->id_tipe, 
			'id_item'     => $getDetail->id_item,
			'id_warna'    => $getDetail->id_warna,
			'bukaan'      => $getDetail->bukaan,
			'lebar'       => $getDetail->lebar,
			'tinggi'      => $getDetail->tinggi,
			'qty_out'     => $getDetail->qty,
 		);
		$this->m_retur_lama->insertStokWarehouse($datawareout);
		
		$this->m_retur->updateStatus($id);
		$this->fungsi->run_js('load_silent("klg/retur","#content")');
		$this->fungsi->message_box("Berhasil Retur","success");
	}

	public function deleteRetur($id) {
		$this->fungsi->check_previleges('retur');
		$data = array('id' => $id, );
		
		$this->m_retur->deleteRetur($id);
		$this->fungsi->catat($data,"Menghapus retur data sbb:",true);
		$this->fungsi->run_js('load_silent("klg/retur","#content")');
		$this->fungsi->message_box("Berhasil menghapus retur","success");
	}

	public function cetak($id) {
		$data = array(
			'id'     => $id, 
			'header' => $this->m_retur->getHeaderCetak($id),
			);
		$this->load->view('klg/retur/v_cetak',$data);
	}


}

/* End of file retur.php */
/* Location: ./application/controllers/klg/retur.php */