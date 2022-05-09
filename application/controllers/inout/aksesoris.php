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
        $this->fungsi->check_previleges('inout');
        $bulan       = date('m');
        $tahun       = date('Y');
        $data['tgl_awal']  = $tahun . '-' . $bulan . '-01';
        $data['tgl_akhir'] = date("Y-m-t", strtotime($data['tgl_awal']));
        $data['aksesoris']    = $this->m_aksesoris->getData($data['tgl_awal'], $data['tgl_akhir']);

        $this->load->view('inout/aksesoris/v_aksesoris_list', $data);
    }

    public function diSet($tgl_awal = '', $tgl_akhir = '', $sort = '')
    {
        $this->fungsi->check_previleges('inout');
        $data['tgl_awal']         = $tgl_awal;
        $data['tgl_akhir']        = $tgl_akhir;
        $data['aksesoris']    = $this->m_aksesoris->getData($data['tgl_awal'], $data['tgl_akhir']);
        $this->load->view('inout/aksesoris/v_aksesoris_list', $data);
    }

    public function formedit($param = '')
    {
        $content   = "<div id='divsubcontent'></div>";
        $header    = "Form Edit";
        $subheader = "";
        $buttons[]          = button('', 'Tutup', 'btn btn-default', 'data-dismiss="modal"');
        echo $this->fungsi->parse_modal($header, $subheader, $content, $buttons, "");

        $this->fungsi->run_js('load_silent("inout/aksesoris/show_editForm/' . $param . '","#divsubcontent")');
    }

    public function show_editForm($id = '')
    {
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'id',
                'label' => 'wes mbarke',
                'rules' => ''
            ),
            array(
                'field' => 'id_supplier',
                'label' => 'id_supplier',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['supplier'] = $this->db->get('master_supplier');
            $data['edit'] = $this->db->get_where('data_stock', array('id' => $id));
            $this->load->view('inout/aksesoris/v_inout_edit', $data);
        } else {
            $datapost = get_post_data(array('id', 'id_supplier'));

            $this->m_aksesoris->updateData($datapost);
            $this->fungsi->run_js('load_silent("inout/aksesoris","#content")');
            $this->fungsi->message_box("Data sukses diperbarui...", "success");
        }
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
        $this->fungsi->check_previleges('inout');
        $bulan       = date('m');
        $tahun       = date('Y');
        $data['tgl_awal']  = $tahun . '-' . $bulan . '-01';
        $data['tgl_akhir'] = date("Y-m-t", strtotime($data['tgl_awal']));
        $data['aksesoris']    = $this->m_aksesoris->getDataOut($data['tgl_awal'], $data['tgl_akhir']);

        $this->load->view('inout/aksesoris/v_aksesoris_list_out', $data);
    }

    public function diSetOut($tgl_awal = '', $tgl_akhir = '', $sort = '')
    {
        $this->fungsi->check_previleges('inout');
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