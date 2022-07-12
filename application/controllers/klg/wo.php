<?php
defined('BASEPATH') or exit('No direct script access allowed');

class wo extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->fungsi->restrict();
        $this->load->model('klg/m_wo');
        $this->load->model('klg/m_fppp');
    }

    public function index()
    {

        $bulan       = date('m');
        $tahun       = date('Y');
        $data['tbl_del']   = 1;
        $data['tgl_awal']  = $tahun . '-' . $bulan . '-01';
        $data['tgl_akhir'] = date("Y-m-t", strtotime($data['tgl_awal']));
        $data['wo'] = $this->m_wo->getData($data['tgl_awal'], $data['tgl_akhir']);
        $data['total_in']  = $this->m_wo->getTotalIn();

        $this->load->view('klg/wo/v_wo_list', $data);
    }

    public function set($tgl_awal = '', $tgl_akhir = '')
    {

        $data['tgl_awal']  = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;
        $data['tbl_del']   = 0;
        $data['wo'] = $this->m_wo->getData($data['tgl_awal'], $data['tgl_akhir']);

        $this->load->view('klg/wo/v_wo_list', $data);
    }

    public function add()
    {

        $data['item']      = $this->m_wo->getdataItem();
        $data['divisi']  = $this->db->get('master_divisi');
        $this->load->view('klg/wo/v_wo_add', $data);
    }

    public function savestokin()
    {

        $datapost = array(
            'tgl_order'        => $this->input->post('tgl_order'),
            'id_divisi'        => $this->input->post('id_divisi'),
            'no_wo'        => $this->input->post('no_wo'),
            'id_item'        => $this->input->post('id_item'),
            'qty_wo'        => $this->input->post('qty_wo'),
            'keterangan'        => $this->input->post('keterangan'),
            'created'        => date('Y-m-d H:i:s'),
            'id_penginput'   => from_session('id'),
        );
        $this->db->insert('data_wo', $datapost);
        $data['id'] = $this->db->insert_id();
        $this->fungsi->catat($datapost, "Menyimpan wo_id " . $data['id'] . " sbb:", true);

        $data['msg'] = "wo Disimpan";
        echo json_encode($data);
    }

    public function deleteWoIn()
    {

        $id            = $this->input->post('id');
        $getRow = $this->db->get_where('data_wo', array('id' => $id))->row();
        $data = array(
            'id' => $id,
            'no_wo' => $getRow->no_wo,
            'qty_wo' => $getRow->qty_wo,
        );
        $this->db->where('id', $id);
        $this->db->delete('data_wo');

        $this->fungsi->catat($data, "Menghapus wo dengan data sbb:", true);
        $respon = ['msg' => 'Data Berhasil Dihapus'];
        echo json_encode($respon);
    }

    public function deleteIn($id)
    {

        $getRow = $this->db->get_where('data_wo', array('id' => $id))->row();
        $data = array(
            'id' => $id,
            'no_wo' => $getRow->no_wo,
            'qty_wo' => $getRow->qty_wo,
        );
        $this->db->where('id', $id);
        $this->db->delete('data_wo');

        $this->fungsi->catat($data, "Menghapus wo dengan data sbb:", true);
        $this->fungsi->run_js('load_silent("klg/wo/","#content")');
        $this->fungsi->message_box("Menghapus WO", "success");
    }

    public function finish()
    {

        // $this->m_wo->hapusTemp(3);
        $this->index();
    }

    public function stok_in_edit($id)
    {

        $data['id']       = $id;
        $data['row']      = $this->db->get_where('data_wo', array('id' => $id))->row();
        $data['item']      = $this->m_wo->getdataItem();
        $data['divisi']  = $this->db->get('master_divisi');
        $this->load->view('klg/wo/v_wo_edit', $data);
    }

    public function simpan_edit()
    {

        $id  = $this->input->post('id');
        $obj = array(
            'tgl_order'        => $this->input->post('tgl_order'),
            'id_divisi'        => $this->input->post('id_divisi'),
            'no_wo'        => $this->input->post('no_wo'),
            'id_item'        => $this->input->post('id_item'),
            'qty_wo'        => $this->input->post('qty_wo'),
            'keterangan'        => $this->input->post('keterangan'),
        );
        $this->db->where('id', $id);
        $this->db->update('data_wo', $obj);

        $this->fungsi->catat($obj, "mengubah WO dengan id " . $id . " data sbb:", true);
        $respon = ['msg' => 'Data Berhasil Diubah'];
        echo json_encode($respon);
    }
}

/* End of file wo.php */
/* Location: ./application/controllers/klg/wo.php */