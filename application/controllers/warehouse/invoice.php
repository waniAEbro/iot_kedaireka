<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoice extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('warehouse/m_konsinyasi');
		$this->load->model('warehouse/m_invoice');
	}

	public function index()
	{
		$this->fungsi->check_previleges('invoice_w');
		$data['invoice'] = $this->m_invoice->getData();
		$this->load->view('warehouse/invoice/v_invoice_list', $data);
	}

	public function formAdd($value = '')
	{
		$this->fungsi->check_previleges('invoice_w');
		$data = array(
			'sesi_store'      => from_session('store'),
			'sesi_jenis_market'      => $this->m_invoice->getRowJenisMarket(from_session('store')),
			'store'           => $this->db->get('master_store'),
			'jenis_market'    => $this->db->get('master_jenis_market'),
			'nomor_invoice'   => str_pad($this->m_invoice->getInvoice(), 3, '0', STR_PAD_LEFT) . '/invoice' . '/' . date('m') . '/' . date('Y'),
			'tipe_invoice'    => $this->db->get('master_tipe')->result(),
			'item'            => $this->db->get('master_item')->result(),
			'warna'           => $this->db->get('master_warna')->result(),
			'brand'           => $this->db->get('master_brand')->result(),
			'case'            => $this->db->get('master_case')->result(),
			'kategori_lokasi' => $this->db->get('master_kategori_lokasi'),
		);
		$this->load->view('warehouse/invoice/v_invoice_add', $data);
	}

	public function formEdit($id = '')
	{
		$this->fungsi->check_previleges('invoice_w');
		$data = array(
			'header'          => $this->m_invoice->getDataTabel($id)->row(),
			'produk'          => $this->m_invoice->getDataDetailTabel($id),
			'sesi_store'      => from_session('store'),
			'store'           => $this->db->get('master_store'),
			'jenis_market'    => $this->db->get('master_jenis_market'),
			'tipe_invoice'    => $this->db->get('master_tipe')->result(),
			'item'            => $this->db->get('master_item')->result(),
			'warna'           => $this->db->get('master_warna')->result(),
			'brand'           => $this->db->get('master_brand')->result(),
			'case'            => $this->db->get('master_case')->result(),
			'kategori_lokasi' => $this->db->get('master_kategori_lokasi'),
		);
		$this->load->view('warehouse/invoice/v_invoice_edit', $data);
	}

	public function saveInvoice($value = '')
	{
		$this->fungsi->check_previleges('invoice');
		$cekNoInvoice = $this->m_invoice->cekNoInvoice($this->input->post('no_invoice'));
		if ($cekNoInvoice == 'y') {
			$datapost = array(
				'no_invoice'         => $this->input->post('no_invoice'),
				'id_store'           => $this->input->post('store'),
				'id_jenis_market'    => $this->input->post('jenis_market'),
				'id_case'            => $this->input->post('id_case'),
				'pembeli'            => $this->input->post('pembeli'),
				'id_kategori_lokasi' => $this->input->post('kategori_lokasi'),
				'alamat'             => $this->input->post('alamat'),
				'no_telp'            => $this->input->post('no_telp'),
				'tgl_pengiriman'     => $this->input->post('tgl_pengiriman'),
				'keterangan'         => $this->input->post('keterangan'),
				'diskon'             => $this->input->post('diskon'),
				'ppn'                => $this->input->post('ppn'),
				'biaya_kirim'        => $this->input->post('biaya_kirim'),
				'date'               => date('Y-m-d H:i:s'),
			);
			$this->m_invoice->insertInvoice($datapost);
			$data['id'] = $this->db->insert_id();
			$this->fungsi->catat($datapost, "Menyimpan Permintaan sbb:", true);
			$data['msg'] = "Permintaan Disimpan";
			echo json_encode($data);
		}
	}
	public function updateInvoice($value = '')
	{
		$this->fungsi->check_previleges('invoice');
		$id = $this->input->post('id_invoice');

		$datapost = array(
			'id_store'           => $this->input->post('store'),
			'id_jenis_market'    => $this->input->post('jenis_market'),
			'pembeli'            => $this->input->post('pembeli'),
			'id_case'            => $this->input->post('id_case'),
			'id_kategori_lokasi' => $this->input->post('kategori_lokasi'),
			'alamat'             => $this->input->post('alamat'),
			'no_telp'            => $this->input->post('no_telp'),
			'tgl_pengiriman'     => $this->input->post('tgl_pengiriman'),
			'keterangan'         => $this->input->post('keterangan'),
			'diskon'             => $this->input->post('diskon'),
			'ppn'                => $this->input->post('ppn'),
			'biaya_kirim'        => $this->input->post('biaya_kirim'),
			'date'               => date('Y-m-d H:i:s'),
		);
		$this->m_invoice->updateInvoice($datapost, $id);
		$this->fungsi->catat($datapost, "Menyimpan Permintaan sbb:", true);
		$data['msg'] = "Permintaan Disimpan";
		echo json_encode($data);
	}

	public function saveInvoiceDetail($value = '')
	{
		$this->fungsi->check_previleges('invoice');
		$datapost = array(
			'id_invoice' => $this->input->post('id_invoice'),
			'id_tipe'    => $this->input->post('tipe_invoice'),
			'id_item'    => $this->input->post('item'),
			'id_warna'   => $this->input->post('warna'),
			'bukaan'     => $this->input->post('bukaan'),
			'lebar'      => $this->input->post('lebar'),
			'tinggi'     => $this->input->post('tinggi'),
			'qty'        => $this->input->post('qty'),
			'keterangan' => $this->input->post('keterangan'),
			'harga'      => $this->input->post('harga'),
			'promo'          => $this->input->post('promo'),
			'date' => date('Y-m-d H:i:s'),
		);
		$this->m_invoice->insertInvoiceDetail($datapost);
		$data['id'] = $this->db->insert_id();
		$this->fungsi->catat($datapost, "Menyimpan detail Invoice sbb:", true);
		$data['msg'] = "Invoice Disimpan";
		echo json_encode($data);
	}

	public function getDetailTabel($value = '')
	{
		$this->fungsi->check_previleges('invoice');
		$id_sku = $this->input->post('id_sku');
		$data['detail'] = $this->m_invoice->getDataDetailTabel($id_sku);
		echo json_encode($data);
	}

	public function getHargaItem($value = '')
	{
		$this->fungsi->check_previleges('invoice');
		$item = $this->input->post('item');
		$warna = $this->input->post('warna');

		$rowHarga = $this->m_invoice->getRowHarga($item, $warna);
		if ($rowHarga->num_rows() > 0) {
			$data['harga_jabotabek'] = $rowHarga->row()->harga_jabotabek;
			$data['harga_dalam_pulau'] = $rowHarga->row()->harga_dalam_pulau;
			$data['harga_luar_pulau'] = $rowHarga->row()->harga_luar_pulau;
		} else {
			$data['harga_jabotabek'] = 0;
			$data['harga_dalam_pulau'] = 0;
			$data['harga_luar_pulau'] = 0;
		}



		echo json_encode($data);
	}

	public function cetak($id_pi)
	{
		$data = array(
			'id'     => $id_pi,
			'header' => $this->m_invoice->getDataTabel($id_pi)->row(),
			'produk' => $this->m_invoice->getDataDetailTabel($id_pi),
		);
		$this->load->view('warehouse/invoice/v_cetak', $data);
	}
	public function deleteItem()
	{
		$this->fungsi->check_previleges('invoice');
		$id = $this->input->post('id');
		$data = array('id' => $id,);
		$this->db->where('id', $id);
		$this->db->delete('warehouse_invoice_detail');
		$this->fungsi->catat($data, "Menghapus Invoice Warehouse dengan data sbb:", true);
		$respon = ['msg' => 'Data Berhasil Dihapus'];
		echo json_encode($respon);
	}

	public function pembulatanEdit($id = '')
	{
		$data = array(
			'id'     => $id,
			'header' => $this->m_invoice->getDataTabel($id)->row(),
			'produk' => $this->m_invoice->getDataDetailTabel($id),
		);
		$this->load->view('warehouse/invoice/v_invoice_pembulatan', $data);
	}

	public function updatePembulatan($value = '')
	{
		$this->fungsi->check_previleges('invoice');
		$id = $this->input->post('id_invoice');

		$datapost = array(
			'pembulatan_gt'     => $this->input->post('pembulatan_gt'),
		);
		$this->m_invoice->updateInvoice($datapost, $id);
		$this->fungsi->catat($datapost, "Menyimpan Pembulatan sbb:", true);
		$data['msg'] = "Pembulatan Disimpan";
		echo json_encode($data);
	}
}

/* End of file invoice.php */
/* Location: ./application/controllers/warehouse/invoice.php */