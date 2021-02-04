<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('klg/m_report');
	}

	public function index()
	{
		$this->fungsi->check_previleges('report');

		$kode       = 'x';
		$dari_tgl   = 'x';
		$sampai_tgl = date('Y-m-d');


		$data['aplikator'] = $this->m_report->getAplikator();
		$data['g1']        = $this->m_report->getStatusQuotation('1',$kode,$dari_tgl,$sampai_tgl)->row()->jumlah;
		$data['g2']        = $this->m_report->getStatusQuotation('2',$kode,$dari_tgl,$sampai_tgl)->row()->jumlah;
		$data['g3']        = $this->m_report->getStatusQuotation('3',$kode,$dari_tgl,$sampai_tgl)->row()->jumlah;
		$data['kode']      = '';
		$data['dari']      = '';
		$data['sampai']    = $sampai_tgl;
		$this->load->view('klg/report/v_report',$data);
	}

	public function diSet($kode='',$dari_tgl='',$sampai_tgl='')
	{
		$this->fungsi->check_previleges('report');
		$data['aplikator'] = $this->m_report->getAplikator();
		$data['g1']        = $this->m_report->getStatusQuotation('1',$kode,$dari_tgl,$sampai_tgl)->row()->jumlah;
		$data['g2']        = $this->m_report->getStatusQuotation('2',$kode,$dari_tgl,$sampai_tgl)->row()->jumlah;
		$data['g3']        = $this->m_report->getStatusQuotation('3',$kode,$dari_tgl,$sampai_tgl)->row()->jumlah;
		$data['kode']      = $kode;
		$data['dari']      = $dari_tgl;
		$data['sampai']    = $sampai_tgl;
		$this->load->view('klg/report/v_report',$data);
	}

}

/* End of file report.php */
/* Location: ./application/controllers/klg/report.php */