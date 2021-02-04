<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produksi extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('klg/m_produksi');
		$this->load->model('klg/m_invoice');
	}

	public function index()
	{
		$this->fungsi->check_previleges('produksi');
		$data['produksi'] = $this->m_produksi->getData();
		$this->load->view('klg/produksi/v_produksi_list', $data);
	}

	public function formAdd($value = '')
	{
		$this->fungsi->check_previleges('produksi');
		$data = array(
			'no_produksi' => str_pad($this->m_produksi->getNomor(), 3, '0', STR_PAD_LEFT) . '/produksi' . '/' . date('m') . '/' . date('Y'),
			'item'          => $this->db->get('master_item')->result(),
			'warna'         => $this->db->get('master_warna')->result(),
			'brand'         => $this->db->get('master_brand')->result(),
			'store'         => $this->db->get('master_store')->result(),
		);
		$this->load->view('klg/produksi/v_produksi_add', $data);
	}

	public function saveProduksi($value = '')
	{
		$this->fungsi->check_previleges('produksi');
		$tgl = $this->input->post('tgl');
		$no_produksi = $this->input->post('no_produksi');
		$datapost = array(
			'no_produksi' => $no_produksi,
			'tgl'         => $tgl,
		);
		$cektgl = $this->m_produksi->cekTgl($tgl);

		if ($cektgl == '0') {
			$this->m_produksi->insertProduksi($datapost);
			$data['id'] = $this->db->insert_id();
		} else {
			$data['id'] = $cektgl;
		}


		$this->fungsi->catat($datapost, "Menyimpan Produksi sbb:", true);
		$data['msg'] = "Tgl Produksi Disimpan";
		echo json_encode($data);
	}

	public function getDetailItem()
	{
		// $this->fungsi->check_previleges('produksi');
		$id = $this->input->post('item');

		$data['gambar'] = $this->m_invoice->getRowDetailItem($id)->gambar;
		$data['lebar'] = $this->m_invoice->getRowDetailItem($id)->lebar;
		$data['tinggi'] = $this->m_invoice->getRowDetailItem($id)->tinggi;
		$data['harga'] = $this->m_invoice->getRowDetailItem($id)->harga;
		$data['id_jenis_barang'] = $this->m_invoice->getRowDetailItem($id)->id_jenis_barang;
		$data['jenis_barang'] = $this->m_invoice->getRowDetailItem($id)->jenis_barang;
		echo json_encode($data);
	}

	public function deleteItem()
	{
		$this->fungsi->check_previleges('produksi');
		$id = $this->input->post('id');
		$data = array('id' => $id,);

		$this->m_produksi->deleteDetailItem($id);
		$this->fungsi->catat($data, "Menghapus Item Produksi data sbb:", true);
		$respon = ['msg' => 'Data Berhasil Dihapus'];
		echo json_encode($respon);
	}

	public function getDetailTabel($value = '')
	{
		$this->fungsi->check_previleges('produksi');
		$id_sku = $this->input->post('id_sku');
		$data['detail'] = $this->m_produksi->getDataDetailTabel($id_sku);
		echo json_encode($data);
	}

	public function saveProduksiDetail($value = '')
	{
		$harga = $this->input->post('harga');
		if ($harga < 1) {
			$harga = 0;
		} else {
			$harga = $harga = $this->input->post('harga');
		}
		$this->fungsi->check_previleges('produksi');
		$item    = $this->input->post('item');
		$warna   = $this->input->post('warna');
		$bukaan  = $this->input->post('bukaan');
		$rowitem = $this->m_produksi->getrowitem($item)->row();
		$nomor   = date('Y-m') . '-' . str_pad($this->m_produksi->getNomorItem($item, $warna, $bukaan), 4, '0', STR_PAD_LEFT);
		$datapost = array(
			'id_produksi' => $this->input->post('id_produksi'),
			'no_produksi' => $nomor,
			'id_tipe'     => 1,
			'id_item'     => $this->input->post('item'),
			'id_warna'    => $this->input->post('warna'),
			'bukaan'      => $this->input->post('bukaan'),
			'lebar'       => $rowitem->lebar,
			'tinggi'      => $rowitem->tinggi,
			'qty'         => $this->input->post('qty'),
			'cek1'        => $this->input->post('cek1'),
			'cek2'        => $this->input->post('cek2'),
			'cek3'        => $this->input->post('cek3'),
			'harga'       => $harga,
			'inout'       => 1,
		);
		$this->m_produksi->insertProduksiDetail($datapost);
		$data['id'] = $this->db->insert_id();
		$data['nomor'] = $nomor;

		$this->fungsi->catat($datapost, "Menyimpan item Produksi sbb:", true);
		$data['msg'] = "Produksi Disimpan";
		echo json_encode($data);
	}

	public function detail($id = '')
	{
		$this->fungsi->check_previleges('produksi');
		$data['produksi'] = $this->m_produksi->getDetail($id);
		$data['tot_produksi'] = $this->m_produksi->getTotProduksi($id);
		$this->load->view('klg/produksi/v_produksi_detail', $data);
	}

	public function deleteProduksi($id = '')
	{
		$this->fungsi->check_previleges('produksi');
		$data = array('id' => $id,);

		$this->m_produksi->deleteProduksi($id);
		$this->fungsi->catat($data, "Menghapus Produksi dengan data sbb:", true);
		$this->fungsi->message_box("Produksi berhasil dihapus", "success");
		$this->fungsi->run_js('load_silent("klg/produksi/","#content")');
	}
}

/* End of file produksi.php */
/* Location: ./application/controllers/klg/produksi.php */