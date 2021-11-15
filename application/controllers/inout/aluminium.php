<?php
defined('BASEPATH') or exit('No direct script access allowed');

class aluminium extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->fungsi->restrict();
        $this->load->model('inout/m_aluminium');
    }

    public function index()
    {
        $this->fungsi->check_previleges('aluminium');
        $bulan       = date('m');
        $tahun       = date('Y');
        $data['tgl_awal']  = $tahun . '-' . $bulan . '-01';
        $data['tgl_akhir'] = date("Y-m-t", strtotime($data['tgl_awal']));
        $data['aluminium']    = $this->m_aluminium->getData($data['tgl_awal'], $data['tgl_akhir']);

        $this->load->view('inout/aluminium/v_aluminium_list', $data);
    }

    public function diSet($tgl_awal = '', $tgl_akhir = '', $sort = '')
    {
        $this->fungsi->check_previleges('aluminium');
        $data['tgl_awal']         = $tgl_awal;
        $data['tgl_akhir']        = $tgl_akhir;
        $data['aluminium']    = $this->m_aluminium->getData($data['tgl_awal'], $data['tgl_akhir']);
        $this->load->view('inout/aluminium/v_aluminium_list', $data);
    }
}

/* End of file aluminium.php */
/* Location: ./application/controllers/inout/aluminium.php */