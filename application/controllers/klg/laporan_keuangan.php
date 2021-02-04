<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_keuangan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->fungsi->restrict();
        $this->load->model('klg/m_laporan_keuangan');
        $this->load->model('warehouse/m_konsinyasi');
        $this->load->model('warehouse/m_invoice');
    }

    public function index()
    {
        $this->fungsi->check_previleges('laporan_keuangan');
        $bulan             = date('m');
        $tahun             = date('Y');
        // $data['bulan']     = $this->db->get('master_bulan');
        $data['tgl_awal'] = $tahun . '-' . $bulan . '-01';
        $data['tgl_akhir'] = date("Y-m-t", strtotime($data['tgl_awal']));
        $data['jenis_barang']  = $this->m_laporan_keuangan->getJenisbarang();
        $data['jenis_market']  = $this->m_laporan_keuangan->getJenisMarket();
        // $data['totalPermintaan'] = $this->m_laporan_keuangan->getItemTotalInvoice($bulan, $tahun);
        // $data['nilaiPermintaan'] = $this->m_laporan_keuangan->getItemNilaiInvoice($bulan, $tahun);
        $data['alltotInv'] = $this->m_laporan_keuangan->getAllItemTotalInvoice($data['tgl_awal'], $data['tgl_akhir']);
        $data['allNilaiInv'] = $this->m_laporan_keuangan->getAllItemNilaiInvoice($data['tgl_awal'], $data['tgl_akhir']);

        $this->load->view('klg/laporan_keuangan/v_laporan_keuangan', $data);
    }

    public function diSet($tgl_awal = '', $tgl_akhir = '')
    {
        $this->fungsi->check_previleges('laporan_keuangan');
        $data['tgl_awal'] = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;
        $data['jenis_barang']  = $this->m_laporan_keuangan->getJenisbarang();
        $data['jenis_market']  = $this->m_laporan_keuangan->getJenisMarket();
        $data['alltotInv'] = $this->m_laporan_keuangan->getAllItemTotalInvoice($data['tgl_awal'], $data['tgl_akhir']);
        $data['allNilaiInv'] = $this->m_laporan_keuangan->getAllItemNilaiInvoice($data['tgl_awal'], $data['tgl_akhir']);
        $this->load->view('klg/laporan_keuangan/v_laporan_keuangan', $data);
    }

    public function detail($store, $tgl_awal, $tgl_akhir)
    {
        $this->fungsi->check_previleges('laporan_keuangan');
        $data['invoice'] = $this->m_laporan_keuangan->getDataLaporanDetail($store, $tgl_awal, $tgl_akhir);
        $this->load->view('klg/laporan_keuangan/v_laporan_keuangan_detail', $data);
    }
}

/* End of file laporan_keuangan.php */
/* Location: ./application/controllers/klg/laporan_keuangan.php */