<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Surat_jalan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->fungsi->restrict();
        $this->load->model('klg/m_surat_jalan');
    }

    public function index()
    {
        $this->fungsi->check_previleges('surat_jalan');
        $bulan       = date('m');
        $tahun       = date('Y');
        $data['tgl_awal']  = $tahun . '-' . $bulan . '-01';
        $data['tgl_akhir'] = date("Y-m-t", strtotime($data['tgl_awal']));
        $data['surat_jalan'] = $this->m_surat_jalan->getData($data['tgl_awal'], $data['tgl_akhir']);
        $this->load->view('klg/surat_jalan/v_surat_jalan_list', $data);
    }

    public function set($tgl_awal = '', $tgl_akhir = '')
    {
        $this->fungsi->check_previleges('surat_jalan');
        $data['tgl_awal']  = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;
        $data['surat_jalan'] = $this->m_surat_jalan->getData($data['tgl_awal'], $data['tgl_akhir']);
        $this->load->view('klg/surat_jalan/v_surat_jalan_list', $data);
    }

    public function add()
    {
        $this->fungsi->check_previleges('surat_jalan');
        $data['fppp']        = $this->db->get_where('data_fppp', array('ws_update' => 1));
        // $data['fppp']        = $this->db->get('data_fppp');
        $data['list_sj']     = $this->m_surat_jalan->getlistsjproses();
        $this->load->view('klg/surat_jalan/v_surat_jalan_add', $data);
    }

    public function optionDetailFppp()
    {
        $id_fppp = $this->input->post('id_fppp');

        $this->db->where('dfd.id_fppp', $id_fppp);
        $this->db->join('master_brand mb', 'mb.id = dfd.id_brand', 'left');
        $this->db->join('master_barang mbr', 'mbr.id = dfd.id_item', 'left');
        $this->db->join('master_warna mwa', 'mwa.id = dfd.finish_coating', 'left');

        $this->db->select('dfd.*,mb.brand,mbr.barang,mwa.warna');

        $get_data = $this->db->get('data_fppp_detail dfd')->result();
        $data     = array();
        foreach ($get_data as $val) {
            $data[] = $val;
        }
        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function insert()
    {
        $datapost = array(
            'id_fppp' => $this->input->post('id_fppp'),
            'id_fppp_detail' => $this->input->post('id_fppp_detail'),
            'qty' => $this->input->post('qty'),
            'id_penginput' => from_session('id'),
            'date' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('data_sj_fppp_detail', $datapost);
        $data['id']          = $this->db->insert_id();

        $this->db->where('id', $datapost['id_fppp_detail']);
        $object = array(
            'pengiriman' => date('Y-m-d H:i:s'),
        );
        $this->db->update('data_fppp_detail', $object);

        $this->fungsi->catat($datapost, "Menyimpan SJ FPPP detail sbb:", true);
        $data['sts'] = "sukses";
        $data['msg'] = "Disimpan";
        echo json_encode($data);
    }

    public function delete()
    {
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->delete('data_sj_fppp_detail');

        $data = array('id' => $id,);
        $this->fungsi->catat($data, "Menghapus SJ FPPP detail data sbb:", true);
        $respon = ['msg' => 'Data Berhasil Dihapus'];
        echo json_encode($respon);
    }

    public function buat_surat_jalan()
    {
        $id_fppp = $this->m_surat_jalan->getlistsjproses()->row()->id_fppp;
        $kode_divisi       = $this->m_surat_jalan->getKodeDivisi($id_fppp);
        $no_surat_jalan   = str_pad($this->m_surat_jalan->getNoSuratJalan(), 3, '0', STR_PAD_LEFT) . '/' . 'SJ' . '/' . $kode_divisi . '/' . date('m') . '/' . date('Y');
        $data['no_surat_jalan']        = $no_surat_jalan;
        $data['list_sj']        = $this->m_surat_jalan->getlistsjproses();
        $data['id_fppp']        = $id_fppp;
        $this->load->view('klg/surat_jalan/v_surat_jalan_make', $data);
    }

    public function insert_sj()
    {
        $datapost = array(
            'no_sj' => $this->input->post('no_surat_jalan'),
            'id_fppp' => $this->input->post('id_fppp'),
            'penerima' => $this->input->post('penerima'),
            'alamat' => $this->input->post('alamat_pengiriman'),
            'sopir' => $this->input->post('sopir'),
            'no_kendaraan' => $this->input->post('no_kendaraan'),
            'keterangan' => $this->input->post('keterangan'),
            'date' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('data_sj_fppp', $datapost);
        $data['id']          = $this->db->insert_id();
        $object = array(
            'id_sj_fppp' => $data['id'],
            'is_proses' => 0,
        );
        $this->db->where('id_penginput', from_session('id'));
        $this->db->update('data_sj_fppp_detail', $object);

        $total_kirim_fppp = $this->db->get_where('data_fppp', array('id' => $datapost['id_fppp']))->row()->total_kirim;
        $this->db->where('id_fppp', $datapost['id_fppp']);
        $this->db->where('id_sj_fppp', $data['id']);
        $this->db->select('sum(qty) as qty');
        $total_kirim_sj = $this->db->get('data_sj_fppp_detail')->row()->qty;

        $this->db->select('sum(qty) as qty_fppp');
        $this->db->where('id_fppp', $datapost['id_fppp']);
        $total_fppp = $this->db->get('data_fppp_detail')->row()->qty_fppp;

        $this->db->where('id_fppp', $datapost['id_fppp']);
        $this->db->select('sum(qty) as qty');
        $total_terkirim = $this->db->get('data_sj_fppp_detail')->row()->qty;

        if ($total_fppp >= $total_terkirim) {
            $ws_update = 3;
        } else {
            $ws_update = 2;
        }


        $upd_fppp = array(
            'total_kirim' => $total_kirim_fppp + $total_kirim_sj,
            'ws_update' => $ws_update,
        );
        $this->db->where('id', $datapost['id_fppp']);
        $this->db->update('data_fppp', $upd_fppp);

        $this->fungsi->catat($datapost, "Menyimpan SJ FPPP sbb:", true);
        $data['sts'] = "sukses";
        $data['msg'] = "Disimpan";
        echo json_encode($data);
    }

    public function lihat_item_stok_out($param = '')
    {
        $content   = "<div id='divsubcontent'></div>";
        $header    = "Preview";
        $subheader = '';
        $buttons[]          = button('', 'Tutup', 'btn btn-default', 'data-dismiss="modal"');
        echo $this->fungsi->parse_modal($header, $subheader, $content, $buttons, '');

        $this->fungsi->run_js('load_silent("klg/surat_jalan/lihat_item_stok_out_modal/' . $param . '","#divsubcontent")');
    }

    public function lihat_item_stok_out_modal($id_sj)
    {
        $data['row']           = $this->m_surat_jalan->getRowSuratJalan($id_sj)->row();
        $data['list_sj']           = $this->m_surat_jalan->getlistsj($id_sj);
        $this->load->view('klg/surat_jalan/v_surat_jalan_lihat', $data);
    }

    public function cetakSj($id)
    {
        $data = array(
            'id'     => $id,
            'header' => $this->m_surat_jalan->getHeaderCetak($id)->row(),
            'detail' => $this->m_surat_jalan->getDataDetailCetak($id)->result(),
        );
        // print_r($data['detail']);

        $this->load->view('klg/surat_jalan/v_surat_jalan_cetak', $data);
    }
}
