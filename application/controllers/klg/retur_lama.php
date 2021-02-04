<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Retur_lama extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('klg/m_retur_lama');
		$this->load->model('klg/m_invoice');

	}

	public function index()
	{
		$this->fungsi->check_previleges('retur_lama');
		$data['retur_lama'] = $this->m_retur_lama->getData();
		$this->load->view('klg/retur_lama/v_retur_lama_list',$data);
	}

	public function formAdd($value='')
	{
		$this->fungsi->check_previleges('retur_lama');
		$data = array(
			'no_pengiriman' => $this->m_retur_lama->getNoPengiriman(),
			'store'  => $this->db->get('master_store')->result(),
			'tipe_invoice'  => $this->db->get('master_tipe')->result(),
			'item'          => $this->db->get('master_item')->result(),
			'warna'         => $this->db->get('master_warna')->result(),
			 );
		$this->load->view('klg/retur_lama/v_retur_lama_add',$data);
	}

	public function formEdit($id='')
	{
		$this->fungsi->check_previleges('retur_lama');
		$data = array(
			'row' => $this->m_retur_lama->getEditretur_lama($id)->row(),
			'id_retur_lama' => $id,
			'no_pengiriman' => $this->m_retur_lama->getNoPengiriman(),
			'tipe_invoice'  => $this->db->get('master_tipe')->result(),
			'item'          => $this->db->get('master_item')->result(),
			'warna'         => $this->db->get('master_warna')->result(),
			 );
		$this->load->view('klg/retur_lama/v_retur_lama_edit',$data);
	}

	public function deleteItem() {
		$this->fungsi->check_previleges('retur_lama');
		$id = $this->input->post('id');
		$data = array('id' => $id, );
		
		$this->m_retur_lama->deleteDetailItem($id);
		$this->fungsi->catat($data,"Menghapus Item retur_lama data sbb:",true);
		$respon = ['msg' => 'Data Berhasil Dihapus'];
		echo json_encode($respon);
	}

	public function saveretur_lamaDetail($value='')
	{
		$this->fungsi->check_previleges('retur_lama');
		
	  	$datapost = array(
			'id_store' => $this->input->post('id_store'), 
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
	    $this->m_retur_lama->insertretur_lamaDetail($datapost);
	    $data['id'] = $this->db->insert_id();
		$this->fungsi->catat($datapost,"Menyimpan item retur_lama sbb:",true);
		$data['msg'] = "retur_lama Disimpan";
		echo json_encode($data);
	}

	public function editretur_lamaDetail($value='')
	{
		$this->fungsi->check_previleges('retur_lama');
		$id_retur_lama = $this->input->post('id_retur_lama');
	  	$datapost = array(

			'id_tipe_baru'        => $this->input->post('tipe_baru'), 
			'id_item_baru'        => $this->input->post('item_baru'), 
			'id_warna_baru'       => $this->input->post('warna_baru'), 
			'bukaan_baru'         => $this->input->post('bukaan_baru'),
			'lebar_baru'          => $this->input->post('lebar_baru'), 
			'tinggi_baru'         => $this->input->post('tinggi_baru'), 
			'qty_baru'            => $this->input->post('qty_baru'),
 		);
	    $this->m_retur_lama->updateretur_lamaDetail($datapost,$id_retur_lama);
	    $data['id'] = $this->db->insert_id();
		$this->fungsi->catat($datapost,"Menyimpan item retur_lama sbb:",true);
		$data['msg'] = "retur_lama Disimpan";
		echo json_encode($data);
	}

	public function getItemInvoice($value='')
	{
		$this->fungsi->check_previleges('retur_lama');
		$id = $this->input->post('id');
		$get_data = $this->m_retur_lama->getItemInvoice($id);

		// echo $this->db->last_query();
		
		$data = array();

		foreach ($get_data as $val) {
			$data[] = $val;
		}

		echo json_encode($data, JSON_PRETTY_PRINT);
	}

	public function getWarnaItem($value='')
	{
		$this->fungsi->check_previleges('retur_lama');
		$id = $this->input->post('id_invoice');
		$id_item = $this->input->post('id_item');
		$get_data = $this->m_retur_lama->getWarnaItem($id,$id_item);

		// echo $this->db->last_query();
		
		$data = array();

		foreach ($get_data as $val) {
			$data[] = $val;
		}

		echo json_encode($data, JSON_PRETTY_PRINT);
	}

	public function getBukaanItem($value='')
	{
		$this->fungsi->check_previleges('retur_lama');
		$id = $this->input->post('id_invoice');
		$id_item = $this->input->post('id_item');
		$id_warna = $this->input->post('id_warna');
		$get_data = $this->m_retur_lama->getBukaanItem($id,$id_item,$id_warna);

		// echo $this->db->last_query();
		
		$data = array();

		foreach ($get_data as $val) {
			$data[] = $val;
		}

		echo json_encode($data, JSON_PRETTY_PRINT);
	}

	public function getLebarTinggi()
	{
		$this->fungsi->check_previleges('retur_lama');
		$id       = $this->input->post('id_invoice');
		$id_item  = $this->input->post('id_item');
		$id_warna = $this->input->post('id_warna');
		$bukaan   = $this->input->post('bukaan');

		
		$data['lebar']  = $this->m_retur_lama->getLebarTinggi($id,$id_item,$id_warna,$bukaan)->lebar;
		$data['tinggi'] = $this->m_retur_lama->getLebarTinggi($id,$id_item,$id_warna,$bukaan)->tinggi;
		$data['qty']    = $this->m_retur_lama->getLebarTinggi($id,$id_item,$id_warna,$bukaan)->qty;
		echo json_encode($data);
	}

	public function getDetailInvoice()
	{
		$this->fungsi->check_previleges('retur_lama');
		$id       = $this->input->post('id');

		
		$data['id_invoice']  = $this->m_retur_lama->getDetailInvoice($id)->id_invoice;
		$data['id_item']  = $this->m_retur_lama->getDetailInvoice($id)->id_item;
		$data['id_tipe']  = $this->m_retur_lama->getDetailInvoice($id)->id_tipe;
		$data['id_warna'] = $this->m_retur_lama->getDetailInvoice($id)->id_warna;
		$data['bukaan']   = $this->m_retur_lama->getDetailInvoice($id)->bukaan;
		$data['lebar']    = $this->m_retur_lama->getDetailInvoice($id)->lebar;
		$data['tinggi']   = $this->m_retur_lama->getDetailInvoice($id)->tinggi;
		$data['qty']      = $this->m_retur_lama->getDetailInvoice($id)->qty_out;
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
		$this->fungsi->check_previleges('retur_lama');
		$getDetail = $this->m_retur_lama->getDetailretur_lama($id);
		$id_store = $getDetail->id_store;


	    $datastok = array(
			'id_produksi' => $this->m_retur_lama->getMaxProduksi(),
			'id_retur'    => $id,
			'id_tipe'     => $getDetail->id_tipe, 
			'id_item'     => $getDetail->id_item,
			'id_warna'    => $getDetail->id_warna,
			'bukaan'      => $getDetail->bukaan,
			'lebar'       => $getDetail->lebar,
			'tinggi'      => $getDetail->tinggi,
			'qty'         => $getDetail->qty,
			'keterangan'  => 'retur_lama',
			'inout'       => 1,
			'is_retur'    => 2,
 		);
			$this->m_retur_lama->insertStok($datastok);

		$datastokout = array(
			'id_produksi' => $this->m_retur_lama->getMaxProduksi(),
			'id_retur'    => $id,
			'id_tipe'     => $getDetail->id_tipe_baru, 
			'id_item'     => $getDetail->id_item_baru,
			'id_warna'    => $getDetail->id_warna_baru,
			'bukaan'      => $getDetail->bukaan_baru,
			'lebar'       => $getDetail->lebar_baru,
			'tinggi'      => $getDetail->tinggi_baru,
			'qty_out'         => $getDetail->qty_baru,
			'keterangan'  => 'retur_lama',
			'inout'       => 2,
			'is_retur'    => 2,
 		);
			$this->m_retur_lama->insertStok($datastokout);

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

		$datawarein = array(
			'id_store' => $getDetail->id_store,
			'id_tipe'  => $getDetail->id_tipe_baru, 
			'id_item'  => $getDetail->id_item_baru,
			'id_warna' => $getDetail->id_warna_baru,
			'bukaan'   => $getDetail->bukaan_baru,
			'lebar'    => $getDetail->lebar_baru,
			'tinggi'   => $getDetail->tinggi_baru,
			'qty'      => $getDetail->qty_baru,
 		);
		$this->m_retur_lama->insertStokWarehouse($datawarein);

		$this->m_retur_lama->updateStatus($id);
		$this->fungsi->run_js('load_silent("klg/retur_lama","#content")');
		$this->fungsi->message_box("Berhasil retur_lama","success");
	}

	public function deleteretur_lama($id) {
		$this->fungsi->check_previleges('retur_lama');
		$data = array('id' => $id, );
		
		$this->m_retur_lama->deleteretur_lama($id);
		$this->fungsi->catat($data,"Menghapus retur_lama data sbb:",true);
		$this->fungsi->run_js('load_silent("klg/retur_lama","#content")');
		$this->fungsi->message_box("Berhasil menghapus retur_lama","success");
	}

	public function cetak($id) {
		$data = array(
			'id'     => $id, 
			'header' => $this->m_retur_lama->getHeaderCetak($id),
			);
		$this->load->view('klg/retur_lama/v_cetak',$data);
	}


}

/* End of file retur_lama.php */
/* Location: ./application/controllers/klg/retur_lama.php */