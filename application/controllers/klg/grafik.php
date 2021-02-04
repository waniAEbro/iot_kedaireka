<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grafik extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('klg/m_quotation');
	}

	public function index()
	{
		$this->fungsi->check_previleges('grafik');

		$kode       = 'x';
		$dari_tgl   = 'x';
		$sampai_tgl = date('Y-m-d');


		$data['aplikator'] = $this->m_quotation->getAplikator();
		$data['g1']        = $this->m_quotation->getStatusQuotation('1',$kode,$dari_tgl,$sampai_tgl)->row()->jumlah;
		$data['g2']        = $this->m_quotation->getStatusQuotation('2',$kode,$dari_tgl,$sampai_tgl)->row()->jumlah;
		$data['g3']        = $this->m_quotation->getStatusQuotation('3',$kode,$dari_tgl,$sampai_tgl)->row()->jumlah;
		$data['g4']        = $this->m_quotation->getStatusQuotation('4',$kode,$dari_tgl,$sampai_tgl)->row()->jumlah;
		$data['kode']      = '';
		$data['dari']      = '';
		$data['sampai']    = $sampai_tgl;
		$this->load->view('klg/grafik/v_grafik',$data);
	}

	public function diSet($kode='',$dari_tgl='',$sampai_tgl='')
	{
		$this->fungsi->check_previleges('grafik');
		$data['aplikator'] = $this->m_quotation->getAplikator();
		$data['g1']        = $this->m_quotation->getStatusQuotation('1',$kode,$dari_tgl,$sampai_tgl)->row()->jumlah;
		$data['g2']        = $this->m_quotation->getStatusQuotation('2',$kode,$dari_tgl,$sampai_tgl)->row()->jumlah;
		$data['g3']        = $this->m_quotation->getStatusQuotation('3',$kode,$dari_tgl,$sampai_tgl)->row()->jumlah;
		$data['g4']        = $this->m_quotation->getStatusQuotation('4',$kode,$dari_tgl,$sampai_tgl)->row()->jumlah;
		$data['kode']      = $kode;
		$data['dari']      = $dari_tgl;
		$data['sampai']    = $sampai_tgl;
		$this->load->view('klg/grafik/v_grafik',$data);
	}

}

/* End of file grafik.php */
/* Location: ./application/controllers/klg/grafik.php */