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
        $data['fppp']        = $this->db->get('data_fppp');
        $data['list_sj']     = $this->m_surat_jalan->getlistsjproses();
        $this->load->view('klg/surat_jalan/v_surat_jalan_add', $data);
    }

    public function optionDetailFppp()
    {
        $id_fppp = $this->input->post('id_fppp');
        $this->db->where('dfd.id_fppp', $id_fppp);
        $this->db->join('master_brand mb', 'mb.id = dfd.id_brand', 'left');
        $this->db->join('master_barang mbr', 'mbr.id = dfd.id_item', 'left');

        $this->db->select('dfd.*,mb.brand,mbr.barang');

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
        $no_surat_jalan   = str_pad($this->m_surat_jalan->getNoSuratJalan(), 3, '0', STR_PAD_LEFT) . '/SJ/' . date('m') . '/' . date('Y');
        $data['no_surat_jalan']        = $no_surat_jalan;
        $data['list_sj']        = $this->m_surat_jalan->getlistsjproses();
        $this->load->view('klg/surat_jalan/v_surat_jalan_make', $data);
    }

    public function insert_sj()
    {
        $datapost = array(
            'no_sj' => $this->input->post('no_surat_jalan'),
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
            'id_sj_fppp'=>$data['id'],
            'is_proses'=>0,
        );
        $this->db->where('id_penginput', from_session('id'));        
        $this->db->update('data_sj_fppp_detail', $object);
        
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
}
