<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('klg/m_stok');
	}

	public function index()
	{
		$this->fungsi->check_previleges('stock');
		$data['stock'] = $this->m_stok->getData();
		$this->load->view('klg/stok/v_stok_list',$data);
	}

	public function formAdd($value='')
	{
		$this->fungsi->check_previleges('stock');

		$data['produk_dari'] = get_options($this->db->query('select id, produk_dari from master_produk_dari'),true);
		$data['item']        = get_options($this->db->query('select id, item from master_item'),true);
		$data['warna']       = get_options($this->db->query('select id, warna from master_warna'),true);
		$data['lokasi']      = get_options($this->db->query('select id, lokasi from master_lokasi'),true);
		$data['bukaan']      = get_options($this->db->query('select id, bukaan from master_bukaan'),true);
		$this->load->view('klg/stok/v_stok_add',$data);
	}

	public function insert($value='')
	{
		$this->fungsi->check_previleges('stock');
		$datapost = array(
			'id_produk_dari' => $this->input->post('id_produk_dari'),
			'id_item'        => $this->input->post('id_item'),
			'id_warna'       => $this->input->post('id_warna'),
			'bukaan'         => $this->input->post('bukaan'),
			'lebar'          => $this->input->post('lebar'),
			'tinggi'         => $this->input->post('tinggi'),
			'qty'            => $this->input->post('qty'),
			'id_lokasi'      => $this->input->post('id_lokasi'),
			);
        $this->m_stok->insertData($datapost);
		$this->fungsi->catat($datapost,"Menambah Stock dengan data sbb:",true);
		$data['msg'] = "Stock Disimpan!";
		echo json_encode($data);
	}

}

/* End of file stock.php */
/* Location: ./application/controllers/klg/stock.php */