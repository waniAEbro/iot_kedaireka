<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class salahkirim extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('klg/m_salahkirim');
		$this->load->model('klg/m_invoice');

	}

	public function index()
	{
		$this->fungsi->check_previleges('salahkirim');
		$data['salahkirim'] = $this->m_salahkirim->getData();
		$this->load->view('klg/salahkirim/v_salahkirim_list',$data);
	}

	public function formAdd($value='')
	{
		$this->fungsi->check_previleges('salahkirim');
		$data = array(
			'no_pengiriman' => $this->m_salahkirim->getNoPengiriman(),
			'item'          => $this->db->get('master_item')->result(),
			'warna'         => $this->db->get('master_warna')->result(),
			 );
		$this->load->view('klg/salahkirim/v_salahkirim_add',$data);
	}

	

	public function deleteItem() {
		$this->fungsi->check_previleges('salahkirim');
		$id = $this->input->post('id');
		$data = array('id' => $id, );
		
		$this->m_salahkirim->deleteDetailItem($id);
		$this->fungsi->catat($data,"Menghapus Item salahkirim data sbb:",true);
		$respon = ['msg' => 'Data Berhasil Dihapus'];
		echo json_encode($respon);
	}

	public function savesalahkirimDetail($value='')
	{
		$this->fungsi->check_previleges('salahkirim');
		
	  	$datapost = array(
			'id_pengiriman'    => $this->input->post('id_surat_jalan'), 
			'id_item'    => $this->input->post('item'), 
			'id_tipe'    => $this->input->post('tipe'), 
			'id_warna'   => $this->input->post('warna'), 
			'bukaan'     => $this->input->post('bukaan'),
			'lebar'      => $this->input->post('lebar'), 
			'tinggi'     => $this->input->post('tinggi'), 
			'qty'        => $this->input->post('qty'), 
			'keterangan' => $this->input->post('keterangan'),
			'date'       => date('Y-m-d'), 
 		);
	    $this->m_salahkirim->insertsalahkirimDetail($datapost);
	    $data['id'] = $this->db->insert_id();
		$this->fungsi->catat($datapost,"Menyimpan item salahkirim sbb:",true);
		$data['msg'] = "salahkirim Disimpan";
		echo json_encode($data);
	}

	public function getItemInvoice($value='')
	{
		$this->fungsi->check_previleges('salahkirim');
		$id = $this->input->post('id');
		$get_data = $this->m_salahkirim->getItemInvoice($id);

		// echo $this->db->last_query();
		
		$data = array();

		foreach ($get_data as $val) {
			$data[] = $val;
		}

		echo json_encode($data, JSON_PRETTY_PRINT);
	}

	public function getWarnaItem($value='')
	{
		$this->fungsi->check_previleges('salahkirim');
		$id = $this->input->post('id_invoice');
		$id_item = $this->input->post('id_item');
		$get_data = $this->m_salahkirim->getWarnaItem($id,$id_item);

		// echo $this->db->last_query();
		
		$data = array();

		foreach ($get_data as $val) {
			$data[] = $val;
		}

		echo json_encode($data, JSON_PRETTY_PRINT);
	}

	public function getBukaanItem($value='')
	{
		$this->fungsi->check_previleges('salahkirim');
		$id = $this->input->post('id_invoice');
		$id_item = $this->input->post('id_item');
		$id_warna = $this->input->post('id_warna');
		$get_data = $this->m_salahkirim->getBukaanItem($id,$id_item,$id_warna);

		// echo $this->db->last_query();
		
		$data = array();

		foreach ($get_data as $val) {
			$data[] = $val;
		}

		echo json_encode($data, JSON_PRETTY_PRINT);
	}

	public function getLebarTinggi()
	{
		$this->fungsi->check_previleges('salahkirim');
		$id       = $this->input->post('id_invoice');
		$id_item  = $this->input->post('id_item');
		$id_warna = $this->input->post('id_warna');
		$bukaan   = $this->input->post('bukaan');

		
		$data['lebar']  = $this->m_salahkirim->getLebarTinggi($id,$id_item,$id_warna,$bukaan)->lebar;
		$data['tinggi'] = $this->m_salahkirim->getLebarTinggi($id,$id_item,$id_warna,$bukaan)->tinggi;
		$data['qty']    = $this->m_salahkirim->getLebarTinggi($id,$id_item,$id_warna,$bukaan)->qty;
		echo json_encode($data);
	}

	public function getNoInvoice()
	{
		$this->fungsi->check_previleges('salahkirim');
		$id       = $this->input->post('id');

		
		$data['no_invoice']  = $this->m_salahkirim->getNoInvoice($id)->no_invoice;
		$data['id_surat_jalan'] = $this->m_salahkirim->getNoInvoice($id)->id;
		echo json_encode($data);
	}

	public function getDetailInvoice()
	{
		$this->fungsi->check_previleges('salahkirim');
		$id       = $this->input->post('id');

		
		$data['id_item']  = $this->m_salahkirim->getDetailInvoice($id)->id_item;
		$data['id_tipe']  = $this->m_salahkirim->getDetailInvoice($id)->id_tipe;
		$data['id_warna'] = $this->m_salahkirim->getDetailInvoice($id)->id_warna;
		$data['bukaan']   = $this->m_salahkirim->getDetailInvoice($id)->bukaan;
		$data['lebar']    = $this->m_salahkirim->getDetailInvoice($id)->lebar;
		$data['tinggi']   = $this->m_salahkirim->getDetailInvoice($id)->tinggi;
		$data['qty']      = $this->m_salahkirim->getDetailInvoice($id)->qty;
		echo json_encode($data);
	}

	public function setujui($id='')
	{
		$this->fungsi->check_previleges('salahkirim');
		$id       = $this->input->post('id');
		$this->m_salahkirim->updateStatus($id);
		$this->fungsi->run_js('load_silent("klg/salahkirim","#content")');
		$this->fungsi->message_box("Berhasil Salah Kirim","success");
	}


}

/* End of file salahkirim.php */
/* Location: ./application/controllers/klg/salahkirim.php */