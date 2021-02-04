<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('klg/m_monitoring');
		$this->load->model('klg/m_summary');
		$this->load->model('klg/m_prioritas_pengiriman');

	}

	public function index()
	{
		$this->common();
	}

	public function common()
	{
		$this->fungsi->check_previleges('monitoring');
		$data['monitoring'] = $this->m_monitoring->getDataCommon();
		$data['tgl'] = $this->m_monitoring->getTanggalCommon();
		$data['tglkirim'] = '';

		$data['store'] = $this->m_monitoring->getStoreCommon();
		$data['get_sudah_kirim'] = $this->m_monitoring->get_sudah_kirim();
		$data['get_stock_ready'] = $this->m_monitoring->get_stock_ready();
		$data['storemitra'] = '';

		$this->load->view('klg/monitoring/v_monitoring_list_common',$data);
	}

	public function commonfilter($tgl,$store)
	{
		$this->fungsi->check_previleges('monitoring');
		$data['monitoring'] = $this->m_monitoring->getDataCommonFilter($tgl,$store);
		$data['tgl'] = $this->m_monitoring->getTanggalCommon();

		$data['tglkirim'] = $tgl;

		$data['store'] = $this->m_monitoring->getStoreCommon();
		$data['get_sudah_kirim'] = $this->m_monitoring->get_sudah_kirim();
		$data['get_stock_ready'] = $this->m_monitoring->get_stock_ready();
		$data['storemitra'] = $store;

		$this->load->view('klg/monitoring/v_monitoring_list_common',$data);
	}

	public function custom()
	{
		$this->fungsi->check_previleges('monitoring');
		$data['monitoring'] = $this->m_monitoring->getDataCustom();
		$data['tgl'] = $this->m_monitoring->getTanggalCustom();
		$data['tglkirim'] = '';

		$data['store'] = $this->m_monitoring->getStoreCustom();
		$data['get_sudah_kirim'] = $this->m_monitoring->get_sudah_kirim();
		$data['get_stock_ready'] = $this->m_monitoring->get_stock_ready();
		$data['storemitra'] = '';

		$this->load->view('klg/monitoring/v_monitoring_list_custom',$data);
	}

	public function customfilter($tgl,$store)
	{
		$this->fungsi->check_previleges('monitoring');
		$data['monitoring'] = $this->m_monitoring->getDataCustomFilter($tgl,$store);
		$data['tgl'] = $this->m_monitoring->getTanggalCustom();
		$data['tglkirim'] = $tgl;

		$data['store'] = $this->m_monitoring->getStoreCustom();
		$data['get_sudah_kirim'] = $this->m_monitoring->get_sudah_kirim();
		$data['get_stock_ready'] = $this->m_monitoring->get_stock_ready();
		$data['storemitra'] = $store;

		$this->load->view('klg/monitoring/v_monitoring_list_custom',$data);
	}

	// public function index()
	// {
	// 	$this->fungsi->check_previleges('monitoring');
	// 	$data['param_tab'] = '1';
	// 	$this->load->view('klg/monitoring/v_monitoring_list',$data);
	// }

	// public function common($value='')
	// {
	// 	$this->fungsi->check_previleges('monitoring');
	// 	$data['monitoring'] = $this->m_monitoring->getDataCommon();
	// 	$this->load->view('klg/monitoring/v_monitoring_common',$data);
	// }

	// public function custom($value='')
	// {
	// 	$this->fungsi->check_previleges('monitoring');
	// 	$data['monitoring'] = $this->m_monitoring->getDataCustom();
	// 	$this->load->view('klg/monitoring/v_monitoring_common',$data);
	// }
	public function cetak($id,$tipe)
	{
		$data['item']=$this->m_monitoring->getDataPivot($tipe);
		$data['warna']=$this->m_monitoring->getWarnaPivot($id);
		$this->load->view('klg/monitoring/v_cetak',$data);
	}

}

/* End of file monitoring.php */
/* Location: ./application/controllers/klg/monitoring.php */