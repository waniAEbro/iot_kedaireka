<?php
defined('BASEPATH') or exit('No direct script access allowed');

// use Mailgun\Mailgun;

// $whitelist = array(
// 	'127.0.0.1',
// 	'::1'
// );

// if (!in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
// 	require '/var/www/html/alphamax/vendor/autoload.php';
// }
class Aksesoris extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->fungsi->restrict();
        $this->load->model('wrh/m_aksesoris');
    }

    public function index()
    {
        $this->fungsi->check_previleges('aksesoris');
        $data['item_code']   = $this->db->get('master_aksesoris');
        $data['supplier']    = $this->db->get('master_supplier');
        $data['item_code_f'] = '';
        $data['supplier_f']  = '';
        $data['aksesoris']   = $this->m_aksesoris->getData('x', 'x');

        $this->load->view('wrh/aksesoris/v_aksesoris_list', $data);
    }

    public function filter($item_code = '', $supplier = '')
    {
        $this->fungsi->check_previleges('aksesoris');
        $data['item_code']   = $this->db->get('master_aksesoris');
        $data['supplier']    = $this->db->get('master_supplier');
        $data['item_code_f'] = $item_code;
        $data['supplier_f']  = $supplier;
        $data['aksesoris']   = $this->m_aksesoris->getData($item_code, $supplier);

        $this->load->view('wrh/aksesoris/v_aksesoris_list', $data);
    }

    public function formAdd($value = '')
    {
        $this->fungsi->check_previleges('aksesoris');
        $data = array(
            'item_code' => $this->db->get('master_aksesoris'),
            'supplier'  => $this->db->get('master_supplier'),
        );
        $this->load->view('wrh/aksesoris/v_aksesoris_add', $data);
    }

    public function formEdit($value = '')
    {
        $this->fungsi->check_previleges('aksesoris');
        $data = array(
            'row'            => $this->m_aksesoris->getEdit($value)->row(),
            'detail'         => $this->m_aksesoris->getDataDetailTabel($value),
            'tipe_aksesoris' => $this->db->get('master_tipe')->result(),
            'item'           => $this->db->get('master_item')->result(),
            'warna'          => $this->db->get('master_warna')->result(),
            'bukaan'         => $this->db->get('master_bukaan')->result(),
            'brand'          => $this->db->get('master_brand')->result(),
            'store'          => $this->db->get('master_store')->result(),
            'status_detail'  => $this->db->get('master_status_detail')->result(),
        );
        $this->load->view('wrh/aksesoris/v_aksesoris_edit', $data);
    }

    public function saveaksesoris($value = '')
    {
        $this->fungsi->check_previleges('aksesoris');

        $datapost = array(
            'item_code'   => $this->input->post('item_code'),
            'id_supplier' => $this->input->post('supplier'),
            'kode_bravo'  => $this->input->post('kode_bravo'),
            'created'     => date('Y-m-d H:i:s'),
        );
        $this->m_aksesoris->insertaksesoris($datapost);
        $data['id'] = $this->db->insert_id();
        $this->fungsi->catat($datapost, "Menyimpan stock aksesoris sbb:", true);
        $data['msg'] = "stock aksesoris Disimpan";
        echo json_encode($data);
    }


    public function saveaksesorisDetail($value = '')
    {
        $this->fungsi->check_previleges('aksesoris');
        $datapost = array(
            'id_aksesoris'      => $this->input->post('id_aksesoris'),
            'divisi'            => $this->input->post('divisi'),
            'area'              => $this->input->post('area'),
            'rak'               => $this->input->post('rak'),
            'stock_awal_bulan'  => $this->input->post('stock_awal_bulan'),
            'stock_akhir_bulan' => $this->input->post('stock_akhir_bulan'),
        );

        $this->m_aksesoris->insertaksesorisDetail($datapost);
        $this->fungsi->catat($datapost, "Menyimpan detail stock sbb:", true);
        $data['msg'] = "stock Disimpan";
        echo json_encode($data);
    }

    public function getDetailTabel($value = '')
    {
        $this->fungsi->check_previleges('aksesoris');
        $id       = $this->input->post('id');
        // $data['detail'] = $this->m_aksesoris->getDataDetailTabel($id);
        // echo json_encode($data);
        $data_aksesoris_in = $this->m_aksesoris->getDataDetailTabel($id);
        $arr = array();
        foreach ($data_aksesoris_in as $key) {
            $tot_out = $this->m_aksesoris->getTotout($key->item_code);
            $temp = array(
                "divisi"     => $key->divisi,
                "gudang"  => $key->gudang,
                "keranjang"  => $key->keranjang,
                "stok_awal_bulan"  => 0,
                "tot_in"  => $key->tot_in,
                "tot_out"  => $tot_out,
                "stok_akhir_bulan"  => $key->tot_in - $tot_out,
                "rata_pemakaian"  => 0,
            );

            array_push($arr, $temp);
            // echo $key->gt . '<br>';
        }
        $data['detail'] = $arr;
        echo json_encode($data);
    }

    public function stok_in()
    {
        $this->fungsi->check_previleges('aksesoris');
        $data['item_code'] = $this->db->get('master_aksesoris');
        $data['supplier']  = $this->db->get('master_supplier');
        $data['divisi']    = $this->db->get('master_divisi');
        $data['gudang']    = $this->db->get('master_gudang');

        $this->load->view('wrh/aksesoris/v_aksesoris_in', $data);
    }

    public function savestokin($value = '')
    {
        $this->fungsi->check_previleges('aksesoris');
        $datapost = array(
            'tgl_proses'     => $this->input->post('tgl_proses'),
            'item_code'   => $this->input->post('id_aksesoris'),
            'qty'            => $this->input->post('qty'),
            'supplier'       => $this->input->post('supplier'),
            'no_surat_jalan' => $this->input->post('no_surat_jalan'),
            'no_pr'          => $this->input->post('no_pr'),
            'id_divisi'      => $this->input->post('id_divisi'),
            'id_gudang'      => $this->input->post('id_gudang'),
            'keranjang'      => $this->input->post('keranjang'),
            'keterangan'     => $this->input->post('keterangan'),
        );

        $this->m_aksesoris->insertstokin($datapost);
        $this->fungsi->catat($datapost, "Menyimpan detail stock-in sbb:", true);
        $data['msg'] = "stock Disimpan";
        echo json_encode($data);
    }

    public function stok_out()
    {
        $this->fungsi->check_previleges('aksesoris');
        $data['no_fppp'] = $this->db->get('data_fppp');
        $data['item_code'] = $this->db->get('master_aksesoris');
        $data['supplier']  = $this->db->get('master_supplier');
        $data['divisi']    = $this->db->get('master_divisi');
        $data['gudang']    = $this->db->get('master_gudang');

        $this->load->view('wrh/aksesoris/v_aksesoris_out', $data);
    }

    public function savestokout()
    {
        $this->fungsi->check_previleges('aksesoris');
        $datapost = array(
            'tgl_proses'     => $this->input->post('tgl_proses'),
            'id_fppp'   => $this->input->post('id_fppp'),
            'item_code'   => $this->input->post('id_aksesoris'),
            'qty'            => $this->input->post('qty'),
            'id_divisi'      => $this->input->post('id_divisi'),
            'id_gudang'      => $this->input->post('id_gudang'),
            'created'      => date('Y-m-d H:i:s'),
        );

        $this->m_aksesoris->insertstokout($datapost);
        $this->fungsi->catat($datapost, "Menyimpan detail stock-in sbb:", true);
        $data['msg'] = "stock Disimpan";
        echo json_encode($data);
    }
}

/* End of file aksesoris.php */
/* Location: ./application/controllers/wrh/aksesoris.php */