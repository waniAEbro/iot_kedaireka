<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pivot extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('klg/m_summary');
	}

	public function index()
	{
		$this->fungsi->check_previleges('pivot');
		$data['warna']     = $this->db->get('master_warna');
		$data['jenis_barang']    = $this->db->get('master_jenis_barang');
		$data['bukaan']    = $this->db->get('master_bukaan');
		$data['store']    = $this->db->get('master_store');
		$this->load->view('klg/pivot/v_pivot_list',$data);
	}

	public function cetakstock($warna='',$jenis_barang='',$bukaan='')
	{
		$warnaq = explode("-",$warna);
		$this->db->where_in('id', $warnaq);
		$res_warna = $this->db->get('master_warna');
		$data['warna']=$res_warna;

		// $rplc0 = str_replace('-', 'x', $bukaan );
		// $rplc1 = str_replace('1', 'L', $rplc0);
		// $rplc2 = str_replace('2', 'R', $rplc1 );
		// $rplc3 = str_replace('3', '-', $rplc2 );
		// $bukaan_rplc = explode("x",$rplc3);
		

		$jenis_barangq = explode("-",$jenis_barang);
		$this->db->join('master_item mi', 'mi.id = dsd.id_item', 'left');
		$this->db->where_in('mi.id_jenis_barang', $jenis_barangq);
		// $this->db->where_in('dsd.id_warna', $warnaq);
		// $this->db->where_in('dsd.bukaan', $bukaan_rplc);
		$this->db->where('dsd.status_so', 1);
		$this->db->select('mi.*,sum(dsd.qty) as jml, sum(dsd.qty_out) as jml_out');
		$this->db->group_by('dsd.id_item');
		$this->db->order_by('mi.item', 'asc');
		$res_item = $this->db->get('data_stok_detail dsd');
		$data['item']=$res_item;

		$bukaanq = explode("-",$bukaan);
		$this->db->where_in('id', $bukaanq);
		$res_bukaan = $this->db->get('master_bukaan');
		$data['bukaan']=$res_bukaan;

		$data['byk_bukaan']= count($bukaanq);
		$this->load->view('klg/pivot/v_pivot_cetak',$data);
	}

	public function cetakots($warna='',$jenis_barang='',$bukaan='')
	{
		$warnaq = explode("-",$warna);
		$this->db->where_in('id', $warnaq);
		$res_warna = $this->db->get('master_warna');
		$data['warna']=$res_warna;

		$jenis_barangq = explode("-",$jenis_barang);
		$this->db->join('master_item mi', 'mi.id = dsd.id_item', 'left');
		$this->db->join('data_invoice di', 'di.id = dsd.id_invoice', 'left');
		$this->db->where_in('mi.id_jenis_barang', $jenis_barangq);
		$this->db->where('di.id_status', 1);
		$this->db->group_by('dsd.id_item');
		$this->db->order_by('mi.item', 'asc');
		$this->db->select('mi.*');
		$res_item = $this->db->get('data_invoice_detail dsd');
		$data['item']=$res_item;

		$bukaanq = explode("-",$bukaan);
		$this->db->where_in('id', $bukaanq);
		$res_bukaan = $this->db->get('master_bukaan');
		$data['bukaan']=$res_bukaan;
		$data['byk_bukaan']= count($bukaanq);
		$this->load->view('klg/pivot/v_pivot_ots',$data);
	}

}