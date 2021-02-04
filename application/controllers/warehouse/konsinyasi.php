<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konsinyasi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('warehouse/m_konsinyasi');
	}

	public function index()
	{
		$this->fungsi->check_previleges('konsinyasi');
		$data['konsinyasi'] = $this->m_konsinyasi->getData();
		$data['store']      = $this->db->get('master_store');
		$data['id_store']   = '';
		$this->load->view('warehouse/konsinyasi/v_konsinyasi_list',$data);
	}

	public function filter($store='')
	{
		$this->fungsi->check_previleges('konsinyasi');
		$data['konsinyasi'] = $this->m_konsinyasi->getDataFilter($store);
		$data['store']      = $this->db->get('master_store');
		$data['id_store']   = $store;
		$this->load->view('warehouse/konsinyasi/v_konsinyasi_list',$data);
	}

	public function transfer($id='')
	{
		$this->fungsi->check_previleges('konsinyasi');
		$data['store']      = $this->db->get('master_store')->result();
		$data['row']      = $this->m_konsinyasi->getRowTransfer($id);;
		$this->load->view('warehouse/konsinyasi/v_konsinyasi_transfer',$data);
	}

	public function saveTransfer($value='')
	{
		$this->fungsi->check_previleges('konsinyasi');
		$dataout = array(
			'id_invoice' => $this->input->post('id_invoice'),  
			'id_store'   => $this->input->post('id_store'), 
			'id_tipe'    => $this->input->post('id_tipe'),
			'id_item'    => $this->input->post('id_item'),
			'id_warna'   => $this->input->post('id_warna'), 
			'bukaan'     => $this->input->post('bukaan'), 
			'lebar'      => $this->input->post('lebar'), 
			'tinggi'     => $this->input->post('tinggi'), 
			'qty_out'    => $this->input->post('qty'),	
			);
		$this->m_konsinyasi->insertTransfer($dataout);
	  	$datapost = array(
			'id_invoice' => $this->input->post('id_invoice'),  
			'id_store'   => $this->input->post('store'), 
			'id_tipe'    => $this->input->post('id_tipe'),
			'id_item'    => $this->input->post('id_item'),
			'id_warna'   => $this->input->post('id_warna'), 
			'bukaan'     => $this->input->post('bukaan'), 
			'lebar'      => $this->input->post('lebar'), 
			'tinggi'     => $this->input->post('tinggi'), 
			'qty'        => $this->input->post('qty'),		
			'keterangan' => $this->input->post('keterangan'),		
			);
	    $this->m_konsinyasi->insertTransfer($datapost);
		$this->fungsi->catat($datapost,"Menyimpan Transfer Warehouse sbb:",true);
		$data['msg'] = "Transfer Warehouse Disimpan";
		echo json_encode($data);
	}

}

/* End of file konsinyasi.php */
/* Location: ./application/controllers/warehouse/konsinyasi.php */