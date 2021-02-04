<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_terkirim extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('laporan/m_item_terkirim');
	}

	public function index()
	{
		$this->fungsi->check_previleges('item_terkirim');
		$bulan             = date('m');
		$tahun             = date('Y');
		$data['bulan']     = $this->db->get('master_bulan');
		$data['store']     = $this->db->get('master_store');
		$data['terkirim']  = $this->m_item_terkirim->get_all_terkirim($bulan,$tahun);
		$data['bulan_skr'] = $bulan;
		$data['tahun']     = $tahun;
		$this->load->view('laporan/item_terkirim/v_item_terkirim',$data);
	}

	public function diSet($bulan='',$tahun='')
	{
		$this->fungsi->check_previleges('item_terkirim');

		$data['bulan']     = $this->db->get('master_bulan');
		$data['store']     = $this->db->get('master_store');
		$data['terkirim']  = $this->m_item_terkirim->get_all_terkirim($bulan,$tahun);
		$data['bulan_skr'] = $bulan;
		$data['tahun']     = $tahun;
		$this->load->view('laporan/item_terkirim/v_item_terkirim',$data);
	}

}

/* End of file item_terkirim.php */
/* Location: ./application/controllers/laporan/item_terkirim.php */