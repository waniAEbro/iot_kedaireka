<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aksesoris extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->fungsi->restrict();
        $this->load->model('inout/m_aksesoris');
    }

    public function index()
    {
        $this->fungsi->check_previleges('aksesoris');
        $bulan       = date('m');
        $tahun       = date('Y');
        $data['tgl_awal']  = $tahun . '-' . $bulan . '-01';
        $data['tgl_akhir'] = date("Y-m-t", strtotime($data['tgl_awal']));
        $data['aksesoris']    = $this->m_aksesoris->getData($data['tgl_awal'], $data['tgl_akhir']);

        $this->load->view('inout/aksesoris/v_aksesoris_list', $data);
    }

    public function diSet($tgl_awal = '', $tgl_akhir = '', $sort = '')
    {
        $this->fungsi->check_previleges('aksesoris');
        $data['tgl_awal']         = $tgl_awal;
        $data['tgl_akhir']        = $tgl_akhir;
        $data['aksesoris']    = $this->m_aksesoris->getData($data['tgl_awal'], $data['tgl_akhir']);
        $this->load->view('inout/aksesoris/v_aksesoris_list', $data);
    }

    public function diSetCetak($tgl_awal = '', $tgl_akhir = '')
    {
        $data['tgl_awal']         = $tgl_awal;
        $data['tgl_akhir']        = $tgl_akhir;
        $data['aksesoris']    = $this->m_aksesoris->getData($data['tgl_awal'], $data['tgl_akhir']);
        $this->load->view('inout/aksesoris/v_aksesoris_list_cetak', $data);
    }

    public function out()
    {
        $this->fungsi->check_previleges('aksesoris');
        $bulan       = date('m');
        $tahun       = date('Y');
        $data['tgl_awal']  = $tahun . '-' . $bulan . '-01';
        $data['tgl_akhir'] = date("Y-m-t", strtotime($data['tgl_awal']));
        $data['aksesoris']    = $this->m_aksesoris->getDataOut($data['tgl_awal'], $data['tgl_akhir']);

        $this->load->view('inout/aksesoris/v_aksesoris_list_out', $data);
    }

    public function diSetOut($tgl_awal = '', $tgl_akhir = '', $sort = '')
    {
        $this->fungsi->check_previleges('aksesoris');
        $data['tgl_awal']         = $tgl_awal;
        $data['tgl_akhir']        = $tgl_akhir;
        $data['aksesoris']    = $this->m_aksesoris->getDataOut($data['tgl_awal'], $data['tgl_akhir']);
        $this->load->view('inout/aksesoris/v_aksesoris_list_out', $data);
    }

    public function diSetCetakOut($tgl_awal = '', $tgl_akhir = '')
    {
        $data['tgl_awal']         = $tgl_awal;
        $data['tgl_akhir']        = $tgl_akhir;
        $data['aksesoris']    = $this->m_aksesoris->getDataOut($data['tgl_awal'], $data['tgl_akhir']);
        $this->load->view('inout/aksesoris/v_aksesoris_list_cetak_out', $data);
    }
}

/* End of file aksesoris.php */
/* Location: ./application/controllers/inout/aksesoris.php */