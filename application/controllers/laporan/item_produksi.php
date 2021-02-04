<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_produksi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('laporan/m_item_produksi');
	}

	public function index()
	{
		$this->fungsi->check_previleges('item_produksi');
		$bulan             = date('m');
		$tahun             = date('Y');
		$data['bulan']     = $this->db->get('master_bulan');
		$data['item']     = $this->db->get('master_item');
		$data['produksi']  = $this->m_item_produksi->get_all_produksi($bulan,$tahun);
		$data['bulan_skr'] = $bulan;
		$data['tahun']     = $tahun;
		$this->load->view('laporan/item_produksi/v_item_produksi',$data);
	}

	public function diSet($bulan='',$tahun='')
	{
		$this->fungsi->check_previleges('item_produksi');

		$data['bulan']     = $this->db->get('master_bulan');
		$data['item']     = $this->db->get('master_item');
		$data['produksi']  = $this->m_item_produksi->get_all_produksi($bulan,$tahun);
		$data['bulan_skr'] = $bulan;
		$data['tahun']     = $tahun;
		$this->load->view('laporan/item_produksi/v_item_produksi',$data);
	}

}

/* End of file item_produksi.php */
/* Location: ./application/controllers/laporan/item_produksi.php */