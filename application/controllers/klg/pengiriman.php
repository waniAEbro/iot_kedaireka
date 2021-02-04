<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengiriman extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('klg/m_prioritas_pengiriman');
		$this->load->model('klg/m_invoice');
		$this->load->model('klg/m_pengiriman');
		$this->load->model('klg/m_retur');
	}

	public function index()
	{
		$this->fungsi->check_previleges('pengiriman');
		$data['totalTerkirim'] = $this->m_pengiriman->getItemTotalPengiriman();
		$data['store']         = $this->db->get('master_store');
		$data['bulan']         = $this->db->get('master_bulan');
		$data['id_bulan']      = '';
		$data['id_tahun']      = date('Y');
		$data['id_tgl']        = '';
		$data['pengiriman']    = $this->m_pengiriman->getData('x', 'x', date('Y'), 'x');
		$data['total_sent']    = $this->m_pengiriman->getTotalSent('x', 'x', date('Y'), 'x');


		$this->load->view('klg/pengiriman/v_pengiriman_list', $data);
	}

	public function filter($store = '', $bulan = '', $tahun = '', $tgl = '')
	{
		$this->fungsi->check_previleges('pengiriman');
		$data['totalTerkirim'] = $this->m_pengiriman->getItemTotalPengiriman();
		$data['store']         = $this->db->get('master_store');
		$data['bulan']         = $this->db->get('master_bulan');
		$data['id_store']      = $store;
		$data['id_bulan']      = $bulan;
		$data['id_tahun']      = $tahun;
		$data['id_tgl']        = $tgl;
		$data['pengiriman']    = $this->m_pengiriman->getData($store, $bulan, $tahun, $tgl);
		$data['total_sent']    = $this->m_pengiriman->getTotalSent($store, $bulan, $tahun, $tgl);
		$this->load->view('klg/pengiriman/v_pengiriman_list', $data);
	}

	public function getDetailTabel($value = '')
	{
		$this->fungsi->check_previleges('pengiriman');
		$id_sku = $this->input->post('id_sku');
		$id_kirim = $this->input->post('id_kirim');
		$tot_permintaan = $this->m_prioritas_pengiriman->getTotPermintaan($id_sku);
		$tot_kirim = $this->m_prioritas_pengiriman->getTotKirim($id_sku);

		if ($tot_permintaan == $tot_kirim) {
			$updt = array('id_status' => 2,);

			$this->m_prioritas_pengiriman->updateStatusInvoice($id_sku, $updt);
		}
		$data['detail'] = $this->m_pengiriman->getDataDetailTabel($id_sku, $id_kirim);
		echo json_encode($data);
	}

	public function batalKirim($id_jalan = '', $id_invoice = '')
	{
		$this->fungsi->check_previleges('pengiriman');
		$this->m_pengiriman->deletePengiriman($id_jalan);
		$this->m_pengiriman->deleteStokWarehouse($id_jalan);
		$this->m_pengiriman->deleteStokDetail($id_jalan);
		$this->m_pengiriman->updateStatusInvoice($id_invoice);
		$datapost = array(
			'id_surat_jalan' => $id_jalan,
			'id_invoice' => $id_invoice,
		);
		$this->fungsi->run_js('load_silent("klg/pengiriman","#content")');
		$this->fungsi->message_box("Pembatalan Pengiriman Berhasil", "success");
		$this->fungsi->catat($datapost, "Membatalkan Pengiriman dengan data sbb:", true);
	}

	public function cetak($id)
	{
		$data = array(
			'id'     => $id,
			'header' => $this->m_pengiriman->getHeaderCetak($id),
			'detail' => $this->m_pengiriman->getDataDetailCetak($id),
		);
		$this->load->view('klg/pengiriman/v_cetak', $data);
	}

	public function cetak_tarik($id)
	{
		$data = array(
			'id'     => $id,
			'header' => $this->m_retur->getHeaderCetak($id)->row(),
			'isi'    => $this->m_retur->getIsiCetak($id),
		);
		$this->load->view('klg/pengiriman/v_cetak_tarik', $data);
	}
	public function finish($id = '')
	{
		$this->fungsi->check_previleges('pengiriman');
		$tot_permintaan = $this->m_prioritas_pengiriman->getTotPermintaan($id);
		$tot_kirim = $this->m_prioritas_pengiriman->getTotKirim($id);

		if ($tot_permintaan == $tot_kirim) {
			$obj = array('id_status' => 2,);

			$this->m_prioritas_pengiriman->updateStatusInvoice($id, $obj);
		}
		$data['pengiriman'] = $this->m_pengiriman->getData();
		$this->load->view('klg/pengiriman/v_pengiriman_list', $data);
	}

	public function simpantgl($value = '')
	{
		$this->fungsi->check_previleges('pengiriman');
		$id = $this->input->post('id');

		$this->db->where('id', $id);
		$cek = $this->db->get('data_pengiriman')->row()->tgl_cetak;
		if ($cek == '' || $cek == null) {
			$obj = array('tgl_cetak' => date('Y-m-d H:i:s'),);
			$this->db->where('id', $id);
			$this->db->update('data_pengiriman', $obj);
		}
		$data['ctk'] = $cek;
		echo json_encode($data);
	}

	public function edit($id = '', $id_invoice = '')
	{
		$this->fungsi->check_previleges('pengiriman');
		$data = array(
			'rowPengiriman' => $this->m_pengiriman->getRowPengiriman($id),
			'detail'        => $this->m_invoice->getDataDetailTabel($id_invoice),
			'rowPermintaan' => $this->m_prioritas_pengiriman->rowPermintaan($id_invoice),
			'id_invoice'    => $id_invoice,
			'id_kirim'      => $id,
		);
		$this->load->view('klg/pengiriman/v_pengiriman_edit', $data);
	}
}

/* End of file pengiriman.php */
/* Location: ./application/controllers/klg/pengiriman.php */