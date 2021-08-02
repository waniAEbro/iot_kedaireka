<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('wrh/m_aluminium');
	}

	public function index()
	{
		$this->status_pak();
	}

	public function status_pak()
	{
		$cek_stock_awal_bulan = $this->m_aluminium->cekStockAwalBulan()->num_rows();
		$item = $this->m_aluminium->getlistStock();

		if ($cek_stock_awal_bulan < 1) {
			foreach ($item->result() as $key) {
				$obj = array(
					'awal_bulan' => 1,
					'inout' => 1,
					'id_item' => $key->id,
					'id_divisi' => $key->id_divisi,
					'id_gudang' => $key->id_gudang,
					'keranjang' => $key->keranjang,
					'qty_in' => $this->m_aluminium->getStockBulanSebelum($key->id, $key->id_divisi, $key->id_gudang, $key->keranjang),
					'created' => date('Y-m-d H:i:s')
				);
				$this->db->insert('data_stock', $obj);
			}
		}

		$this->load->view('v_dashboard');
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/pak/dashboard.php */