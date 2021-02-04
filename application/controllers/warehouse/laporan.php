<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('warehouse/m_laporan');
	}

	public function index()
	{
		$this->fungsi->check_previleges('laporan');
		$store = 'x';
		$bulan             = date('m');
		$tahun             = date('Y');
		$data['store']     = $this->db->get('master_store');
		$data['bulan']     = $this->db->get('master_bulan');
		$data['store_skr'] = $store;
		$data['item']     = $this->m_laporan->getItemTerjual($store,$bulan,$tahun);
		$data['produksi']  = $this->m_laporan->get_all_produksi($store,$bulan,$tahun);
		$data['bulan_skr'] = $bulan;
		$data['tahun']     = $tahun;
		$this->load->view('warehouse/laporan/v_laporan',$data);
	}

	public function diSet($store='',$bulan='',$tahun='')
	{
		$this->fungsi->check_previleges('laporan');
		$data['bulan']     = $this->db->get('master_bulan');
		$data['store']     = $this->db->get('master_store');
		$data['store_skr'] = $store;
		$data['item']     = $this->m_laporan->getItemTerjual($store,$bulan,$tahun);
		$data['produksi']  = $this->m_laporan->get_all_produksi($store,$bulan,$tahun);
		$data['bulan_skr'] = $bulan;
		$data['tahun']     = $tahun;
		$this->load->view('warehouse/laporan/v_laporan',$data);
	}

}

/* End of file laporan.php */
/* Location: ./application/controllers/laporan/laporan.php */