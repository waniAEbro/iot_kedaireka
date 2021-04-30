<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aksesoris extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->fungsi->restrict();
        $this->load->model('wrh/m_aksesoris');
        $this->load->model('klg/m_fppp');
    }

    public function index()
    {
        $this->fungsi->check_previleges('aksesoris');
        $data['aksesoris'] = $this->m_aksesoris->getData();
        $data['total_in']  = $this->m_aksesoris->getTotalIn();
        $data['total_out'] = $this->m_aksesoris->getTotalOut();
        $data['total_bom'] = $this->m_aksesoris->getTotalBom();
        $this->load->view('wrh/aksesoris/v_aksesoris_list', $data);
    }

    public function getDetailTabel($value = '')
    {
        $this->fungsi->check_previleges('aksesoris');
        $id = $this->input->post('id');
        // $data['detail'] = $this->m_aksesoris->getDataDetailTabel($id);
        // echo json_encode($data);
        $data_aksesoris_in = $this->m_aksesoris->getDataDetailTabel($id);
        $arr               = array();
        foreach ($data_aksesoris_in as $key) {
            // $tot_out = $this->m_aksesoris->getTotout($key->item_code);
            $temp = array(
                "divisi"           => $key->divisi,
                "gudang"           => $key->gudang,
                "keranjang"        => $key->keranjang,
                "stok_awal_bulan"  => 0,
                "tot_in"           => $key->qty,
                "tot_out"          => 0,
                "stok_akhir_bulan" => 0,
                "rata_pemakaian"   => 0,
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
        $data['aksesoris'] = $this->m_aksesoris->getDataStock();

        $this->load->view('wrh/aksesoris/v_aksesoris_in_list', $data);
    }

    public function stok_in_add()
    {
        $this->fungsi->check_previleges('aksesoris');
        $data['item_code'] = $this->m_aksesoris->getData();
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
            'item_code'      => $this->input->post('id_aksesoris'),
            'qty'            => $this->input->post('qty'),
            'supplier'       => $this->input->post('supplier'),
            'no_surat_jalan' => $this->input->post('no_surat_jalan'),
            'no_pr'          => $this->input->post('no_pr'),
            'id_divisi'      => $this->input->post('id_divisi'),
            'id_gudang'      => $this->input->post('id_gudang'),
            'keranjang'      => $this->input->post('keranjang'),
            'keterangan'     => $this->input->post('keterangan'),
        );
        $cekQtyCommon = $this->m_aksesoris->cekQtyIn($this->input->post('id_aksesoris'), $this->input->post('id_gudang'), $this->input->post('keranjang'))->num_rows();
        if ($cekQtyCommon > 0) {
            $cekQtyIn = $this->m_aksesoris->cekQtyIn($this->input->post('id_aksesoris'), $this->input->post('id_gudang'), $this->input->post('keranjang'))->row()->qty;
            $qtyacc   = $this->input->post('qty') +  $cekQtyIn;
            $this->m_aksesoris->updatestokin($datapost, $qtyacc);
        } else {
            $this->m_aksesoris->insertstokin($datapost);
        }

        $this->m_aksesoris->insertstokinhistory($datapost);

        $this->fungsi->catat($datapost, "Menyimpan detail stock-in sbb:", true);
        $data['msg'] = "stock Disimpan";
        echo json_encode($data);
    }

    public function stok_out()
    {
        $this->fungsi->check_previleges('aksesoris');
        $data['fppp'] = $this->m_aksesoris->getfpppaksesoris();
        $this->load->view('wrh/aksesoris/v_aksesoris_out_list', $data);
    }

    public function stok_out_add()
    {
        $this->fungsi->check_previleges('aksesoris');
        $data['no_fppp'] = $this->db->get('data_fppp');
        $this->load->view('wrh/aksesoris/v_aksesoris_out', $data);
    }

    // public function savestokout()
    // {
    //     $this->fungsi->check_previleges('aksesoris');
    //     $datapost = array(
    //         'tgl_proses'     => $this->input->post('tgl_proses'),
    //         'id_fppp'   => $this->input->post('id_fppp'),
    //         'item_code'   => $this->input->post('id_aksesoris'),
    //         'qty'            => $this->input->post('qty'),
    //         'id_divisi'      => $this->input->post('id_divisi'),
    //         'id_gudang'      => $this->input->post('id_gudang'),
    //         'created'      => date('Y-m-d H:i:s'),
    //     );

    //     $this->m_aksesoris->insertstokout($datapost);
    //     $this->fungsi->catat($datapost, "Menyimpan detail stock-in sbb:", true);
    //     $data['msg'] = "stock Disimpan";
    //     echo json_encode($data);
    // }

    public function getDetailFppp()
    {
        $this->fungsi->check_previleges('aksesoris');
        $id = $this->input->post('no_fppp');

        $data['nama_proyek']       = $this->m_aksesoris->getRowFppp($id)->nama_proyek;
        $data['alamat_proyek']       = $this->m_aksesoris->getRowFppp($id)->alamat_proyek;
        $data['sales'] = $this->m_aksesoris->getRowFppp($id)->sales;
        $data['deadline_pengiriman']             = $this->m_aksesoris->getRowFppp($id)->deadline_pengiriman;
        echo json_encode($data);
    }

    public function detailbom($id)
    {
        $this->fungsi->check_previleges('aksesoris');
        $cek_fppp_out = $this->m_aksesoris->cek_fppp_out($id);
        $bom          = $this->m_fppp->bom_aksesoris($id);
        $divisi       = $this->m_aksesoris->getRowFppp($id)->id_divisi;
        if ($cek_fppp_out < 1) {
            foreach ($bom->result() as $row) {
                $obj = array(
                    'tgl_proses' => date('Y-m-d'),
                    'id_fppp'    => $id,
                    'item_code'  => $row->item_code,
                    'qty_bom'    => $row->qty,
                    'id_divisi'  => $divisi,
                    'id_gudang'  => '1',
                    'produksi'   => '1',
                    'created'    => date('Y-m-d H:i:s'),
                );
                $this->db->insert('data_aksesoris_out', $obj);
            }
        }
        sleep(0.25);
        $data['id_fppp']           = $id;
        $data['bom_aksesoris']     = $this->m_aksesoris->getBomAksesoris($id);
        $data['no_fppp']           = $this->m_aksesoris->getRowFppp($id)->no_fppp;
        $data['nama_proyek']       = $this->m_aksesoris->getRowFppp($id)->nama_proyek;
        $data['alamat_proyek'] = $this->m_aksesoris->getRowFppp($id)->alamat_proyek;
        $data['sales']             = $this->m_aksesoris->getRowFppp($id)->sales;
        $data['deadline_pengiriman']             = $this->m_aksesoris->getRowFppp($id)->deadline_pengiriman;
        $data['divisi']            = get_options($this->db->get('master_divisi'), 'id', 'divisi', true);
        $data['gudang']            = get_options($this->db->get('master_gudang'), 'id', 'gudang', true);
        $this->load->view('wrh/aksesoris/v_aksesoris_detail_bom', $data);
    }

    public function kuncidetailbom($id = '', $id_detail = '')
    {
        $this->fungsi->check_previleges('aksesoris');
        $this->m_aksesoris->kunciStockOut($id_detail);
        $data['id_fppp']           = $id;
        $data['bom_aksesoris']     = $this->m_aksesoris->getBomAksesoris($id);
        $data['no_fppp']           = $this->m_aksesoris->getRowFppp($id)->no_fppp;
        $data['nama_proyek']       = $this->m_aksesoris->getRowFppp($id)->nama_proyek;
        $data['alamat_pengiriman'] = $this->m_aksesoris->getRowFppp($id)->alamat_pengiriman;
        $data['warna']             = $this->m_aksesoris->getRowFppp($id)->warna_sealant;
        $data['divisi']            = get_options($this->db->get('master_divisi'), 'id', 'divisi', true);
        $data['gudang']            = get_options($this->db->get('master_gudang'), 'id', 'gudang', true);
        $this->fungsi->message_box("Kunci Berhasil", "success");
        $this->load->view('wrh/aksesoris/v_aksesoris_detail_bom', $data);
    }

    public function kirimparsial($id = '', $id_detail = '')
    {
        $this->fungsi->check_previleges('aksesoris');
        $rowout = $this->m_aksesoris->getRowAksesorisOut($id_detail);
        $obj    = array(
            'tgl_proses' => date('Y-m-d'),
            'id_fppp'    => $id,
            'item_code'  => $rowout->item_code,
            'qty_bom'    => $rowout->qty_bom,
            'id_divisi'  => $rowout->id_divisi,
            'id_gudang'  => $rowout->id_gudang,
            'produksi'   => '1',
            'created'    => date('Y-m-d H:i:s'),
        );
        $this->db->insert('data_aksesoris_out', $obj);
        sleep(0.25);
        $data['id_fppp']           = $id;
        $data['bom_aksesoris']     = $this->m_aksesoris->getBomAksesoris($id);
        $data['no_fppp']           = $this->m_aksesoris->getRowFppp($id)->no_fppp;
        $data['nama_proyek']       = $this->m_aksesoris->getRowFppp($id)->nama_proyek;
        $data['alamat_pengiriman'] = $this->m_aksesoris->getRowFppp($id)->alamat_pengiriman;
        $data['warna']             = $this->m_aksesoris->getRowFppp($id)->warna_sealant;
        $data['divisi']            = get_options($this->db->get('master_divisi'), 'id', 'divisi', true);
        $data['gudang']            = get_options($this->db->get('master_gudang'), 'id', 'gudang', true);
        $this->fungsi->message_box("Parsial Berhasil", "success");
        $this->load->view('wrh/aksesoris/v_aksesoris_detail_bom', $data);
    }

    public function finishdetailbom($id = '')
    {
        $this->fungsi->check_previleges('aksesoris');
        $this->m_aksesoris->finishStockOut($id);
        $data['id_fppp']           = $id;
        $data['bom_aksesoris']     = $this->m_aksesoris->getBomAksesoris($id);
        $data['no_fppp']           = $this->m_aksesoris->getRowFppp($id)->no_fppp;
        $data['nama_proyek']       = $this->m_aksesoris->getRowFppp($id)->nama_proyek;
        $data['alamat_pengiriman'] = $this->m_aksesoris->getRowFppp($id)->alamat_pengiriman;
        $data['warna']             = $this->m_aksesoris->getRowFppp($id)->warna_sealant;
        $data['divisi']            = get_options($this->db->get('master_divisi'), 'id', 'divisi', true);
        $data['gudang']            = get_options($this->db->get('master_gudang'), 'id', 'gudang', true);
        $this->fungsi->message_box("finish Berhasil", "success");
        $this->load->view('wrh/aksesoris/v_aksesoris_detail_bom', $data);
    }

    public function saveout()
    {
        $this->fungsi->check_previleges('aksesoris');
        $field  = $this->input->post('field');
        $value  = $this->input->post('value');
        $editid = $this->input->post('id');
        if ($field == 'produksi') {
            $this->m_aksesoris->editRowOut($field, $value, $editid);
            $this->m_aksesoris->editRowOut('lapangan', 0, $editid);
        } else if ($field == 'lapangan') {
            $this->m_aksesoris->editRowOut($field, $value, $editid);
            $this->m_aksesoris->editRowOut('produksi', 0, $editid);
        } else {
            $this->m_aksesoris->editRowOut($field, $value, $editid);
        }
        sleep(0.25);
        $item_code  = $this->m_aksesoris->getRowAksesorisOut($editid)->item_code;
        $divisi     = $this->m_aksesoris->getRowAksesorisOut($editid)->id_divisi;
        $gudang     = $this->m_aksesoris->getRowAksesorisOut($editid)->id_gudang;
        $qty_gudang = $this->m_aksesoris->getQtyGudang($item_code, $divisi, $gudang);

        $data['qty_gudang'] = $qty_gudang;
        $data['status']     = "berhasil";
        echo json_encode($data);
    }

    public function bon_manual()
    {
        $this->fungsi->check_previleges('aksesoris');
        $data['bom_aksesoris'] = $this->m_aksesoris->getBomAksesorisManual();

        $this->load->view('wrh/aksesoris/v_aksesoris_bon_manual_list', $data);
    }

    public function bon_manual_add()
    {
        $this->fungsi->check_previleges('aksesoris');
        $data['item_code'] = $this->m_aksesoris->getData();
        $data['fppp']      = $this->db->get('data_fppp');
        $data['supplier']  = $this->db->get('master_supplier');
        $data['divisi']    = $this->db->get('master_divisi');
        $data['gudang']    = $this->db->get('master_gudang');

        $this->load->view('wrh/aksesoris/v_aksesoris_bon_out', $data);
    }

    public function optionAksesoris()
    {
        $this->fungsi->check_previleges('aksesoris');
        $id_fppp  = $this->input->post('fppp');
        $get_data = $this->m_aksesoris->getOptionAksesoris($id_fppp);
        $data     = array();
        foreach ($get_data as $val) {
            $data[] = $val;
        }
        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function savebonmanual($value = '')
    {
        $this->fungsi->check_previleges('aksesoris');

        $datapost = array(
            'tgl_proses' => $this->input->post('tgl_proses'),
            'id_fppp'    => $this->input->post('id_fppp'),
            'item_code'  => $this->input->post('id_aksesoris'),
            'qty'        => $this->input->post('qty'),
            'id_divisi'  => $this->input->post('id_divisi'),
            'id_gudang'  => $this->input->post('id_gudang'),
            'produksi'   => $this->input->post('produksi'),
            'lapangan'   => $this->input->post('lapangan'),
            'created'    => date('Y-m-d H:i:s'),
            'is_manual'  => 2,
        );
        $this->m_aksesoris->insertstokout($datapost);

        $this->fungsi->catat($datapost, "Menyimpan detail stock-in sbb:", true);
        $data['msg'] = "stock Disimpan";
        echo json_encode($data);
    }

    public function deleteItemBonManual()
    {
        $this->fungsi->check_previleges('aksesoris');
        $id   = $this->input->post('id');
        $data = array('id' => $id,);
        $this->m_aksesoris->deleteItemBonManual($id);
        $this->fungsi->catat($data, "Menghapus BON manual Detail dengan data sbb:", true);
        $respon = ['msg' => 'Data Berhasil Dihapus'];
        echo json_encode($respon);
    }

    public function mutasi_stock()
    {
        $this->fungsi->check_previleges('aksesoris');
        $data['mutasi'] = $this->m_aksesoris->getMutasi();

        $this->load->view('wrh/aksesoris/v_aksesoris_mutasi_stock', $data);
    }

    public function mutasi_stock_add($item_code = '')
    {
        $this->fungsi->check_previleges('aksesoris');
        $data['item']     = $this->m_aksesoris->getItemMutasi();
        $data['divisi']   = $this->db->get('master_divisi');
        $data['gudang']   = $this->db->get('master_gudang');
        $data['itemcode'] = $item_code;
        $this->load->view('wrh/aksesoris/v_aksesoris_mutasi_stock_add', $data);
    }

    public function optionDivisiMutasi()
    {
        $this->fungsi->check_previleges('aksesoris');
        $item     = $this->input->post('item');
        $get_data = $this->m_aksesoris->getDivisiMutasi($item);
        $data     = array();
        foreach ($get_data as $val) {
            $data[] = $val;
        }
        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function optionGudangMutasi()
    {
        $this->fungsi->check_previleges('aksesoris');
        $item     = $this->input->post('item');
        $divisi   = $this->input->post('divisi');
        $get_data = $this->m_aksesoris->getGudangMutasi($item, $divisi);
        $data     = array();
        foreach ($get_data as $val) {
            $data[] = $val;
        }
        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function optionKeranjangMutasi()
    {
        $this->fungsi->check_previleges('aksesoris');
        $item     = $this->input->post('item');
        $divisi   = $this->input->post('divisi');
        $gudang   = $this->input->post('gudang');
        $get_data = $this->m_aksesoris->getKeranjangMutasi($item, $divisi, $gudang);
        $data     = array();
        foreach ($get_data as $val) {
            $data[] = $val;
        }
        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function optionQtyMutasi()
    {
        $this->fungsi->check_previleges('aksesoris');
        $item      = $this->input->post('item');
        $divisi    = $this->input->post('divisi');
        $gudang    = $this->input->post('gudang');
        $keranjang = $this->input->post('keranjang');
        $get_data  = $this->m_aksesoris->getQtyMutasi($item, $divisi, $gudang, $keranjang);
        $data['qty']     = $get_data;
        echo json_encode($data);
    }

    public function simpanMutasi()
    {
        $this->fungsi->check_previleges('aksesoris');
        $item      = $this->input->post('item');
        $divisi    = $this->input->post('divisi');
        $gudang    = $this->input->post('gudang');
        $keranjang = $this->input->post('keranjang');
        $qty       = $this->input->post('qty');

        $divisi2    = $this->input->post('divisi2');
        $gudang2    = $this->input->post('gudang2');
        $keranjang2 = $this->input->post('keranjang2');
        $qty2       = $this->input->post('qty2');

        $cek_mutasi_tempat_baru = $this->m_aksesoris->cekMutasiTempatBaru($item, $divisi2, $gudang2, $keranjang2)->num_rows();
        if ($cek_mutasi_tempat_baru < 1) {
            $qty_tempat_lama = $qty - $qty2;
            $arr_tempat_lama = array(
                'qty' => $qty_tempat_lama,
            );
            $this->m_aksesoris->updateQtyTempatLama($item, $divisi, $gudang, $keranjang, $arr_tempat_lama);
            $arr_tempat_baru = array(
                'tgl_proses' => date('Y-m-d'),
                'item_code'  => $item,
                'id_divisi'  => $divisi2,
                'id_gudang'  => $gudang2,
                'keranjang'  => $keranjang2,
                'qty'        => $qty2,
            );
            $this->db->insert('data_aksesoris_in', $arr_tempat_baru);
        } else {
            $qty_tempat_pindahan = $this->m_aksesoris->cekMutasiTempatBaru($item, $divisi2, $gudang2, $keranjang2)->row()->qty;
            $qty_tempat_lama     = $qty - $qty2;
            $qty_tempat_baru     = $qty_tempat_pindahan + $qty2;
            $arr_tempat_lama     = array(
                'qty' => $qty_tempat_lama,
            );
            $arr_tempat_baru = array(
                'qty' => $qty_tempat_baru,
            );
            $this->m_aksesoris->updateQtyTempatLama($item, $divisi, $gudang, $keranjang, $arr_tempat_lama);
            $this->m_aksesoris->updateQtyTempatLama($item, $divisi2, $gudang2, $keranjang2, $arr_tempat_baru);
        }

        $obj = array(
            'created'    => date('Y-m-d H:i:s'),
            'item_code'  => $item,
            'id_divisi'  => $divisi,
            'id_gudang'  => $gudang,
            'keranjang'  => $keranjang,
            'qty'        => $qty,
            'id_divisi2' => $divisi2,
            'id_gudang2' => $gudang2,
            'keranjang2' => $keranjang2,
            'qty2'       => $qty2,
        );
        $this->db->insert('data_aksesoris_mutasi', $obj);

        $data['qty'] = $qty_tempat_lama;
        echo json_encode($data);
    }

    public function mutasi_stock_history($item_code = '')
    {
        $this->fungsi->check_previleges('aksesoris');
        $data['item_code'] = $item_code;
        $data['mutasi']    = $this->m_aksesoris->getMutasiHistory($item_code);

        $this->load->view('wrh/aksesoris/v_aksesoris_mutasi_stock_history', $data);
    }



    // public function filter($item_code = '', $supplier = '')
    // {
    //     $this->fungsi->check_previleges('aksesoris');
    //     $data['item_code']   = $this->db->get('master_aksesoris');
    //     $data['supplier']    = $this->db->get('master_supplier');
    //     $data['item_code_f'] = $item_code;
    //     $data['supplier_f']  = $supplier;
    //     $data['aksesoris']   = $this->m_aksesoris->getData($item_code, $supplier);

    //     $this->load->view('wrh/aksesoris/v_aksesoris_list', $data);
    // }

    // public function formAdd($value = '')
    // {
    //     $this->fungsi->check_previleges('aksesoris');
    //     $data = array(
    //         'item_code' => $this->m_aksesoris->getData(),
    //         'supplier'  => $this->db->get('master_supplier'),
    //     );
    //     $this->load->view('wrh/aksesoris/v_aksesoris_add', $data);
    // }

    // public function formEdit($value = '')
    // {
    //     $this->fungsi->check_previleges('aksesoris');
    //     $data = array(
    //         'row'            => $this->m_aksesoris->getEdit($value)->row(),
    //         'detail'         => $this->m_aksesoris->getDataDetailTabel($value),
    //         'tipe_aksesoris' => $this->db->get('master_tipe')->result(),
    //         'item'           => $this->db->get('master_item')->result(),
    //         'warna'          => $this->db->get('master_warna')->result(),
    //         'bukaan'         => $this->db->get('master_bukaan')->result(),
    //         'brand'          => $this->db->get('master_brand')->result(),
    //         'store'          => $this->db->get('master_store')->result(),
    //         'status_detail'  => $this->db->get('master_status_detail')->result(),
    //     );
    //     $this->load->view('wrh/aksesoris/v_aksesoris_edit', $data);
    // }

    // public function saveaksesoris($value = '')
    // {
    //     $this->fungsi->check_previleges('aksesoris');

    //     $datapost = array(
    //         'item_code'   => $this->input->post('item_code'),
    //         'id_supplier' => $this->input->post('supplier'),
    //         'kode_bravo'  => $this->input->post('kode_bravo'),
    //         'created'     => date('Y-m-d H:i:s'),
    //     );
    //     $this->m_aksesoris->insertaksesoris($datapost);
    //     $data['id'] = $this->db->insert_id();
    //     $this->fungsi->catat($datapost, "Menyimpan stock aksesoris sbb:", true);
    //     $data['msg'] = "stock aksesoris Disimpan";
    //     echo json_encode($data);
    // }


    // public function saveaksesorisDetail($value = '')
    // {
    //     $this->fungsi->check_previleges('aksesoris');
    //     $datapost = array(
    //         'id_aksesoris'      => $this->input->post('id_aksesoris'),
    //         'divisi'            => $this->input->post('divisi'),
    //         'area'              => $this->input->post('area'),
    //         'rak'               => $this->input->post('rak'),
    //         'stock_awal_bulan'  => $this->input->post('stock_awal_bulan'),
    //         'stock_akhir_bulan' => $this->input->post('stock_akhir_bulan'),
    //     );

    //     $this->m_aksesoris->insertaksesorisDetail($datapost);
    //     $this->fungsi->catat($datapost, "Menyimpan detail stock sbb:", true);
    //     $data['msg'] = "stock Disimpan";
    //     echo json_encode($data);
    // }





    // public function stok_out()
    // {
    //     $this->fungsi->check_previleges('aksesoris');
    //     $data['no_fppp'] = $this->db->get('data_fppp');
    //     $data['item_code'] = $this->db->get('master_aksesoris');
    //     $data['supplier']  = $this->db->get('master_supplier');
    //     $data['divisi']    = $this->db->get('master_divisi');
    //     $data['gudang']    = $this->db->get('master_gudang');

    //     $this->load->view('wrh/aksesoris/v_aksesoris_out', $data);
    // }

    // public function savestokout()
    // {
    //     $this->fungsi->check_previleges('aksesoris');
    //     $datapost = array(
    //         'tgl_proses'     => $this->input->post('tgl_proses'),
    //         'id_fppp'   => $this->input->post('id_fppp'),
    //         'item_code'   => $this->input->post('id_aksesoris'),
    //         'qty'            => $this->input->post('qty'),
    //         'id_divisi'      => $this->input->post('id_divisi'),
    //         'id_gudang'      => $this->input->post('id_gudang'),
    //         'created'      => date('Y-m-d H:i:s'),
    //     );

    //     $this->m_aksesoris->insertstokout($datapost);
    //     $this->fungsi->catat($datapost, "Menyimpan detail stock-in sbb:", true);
    //     $data['msg'] = "stock Disimpan";
    //     echo json_encode($data);
    // }
}

/* End of file aksesoris.php */
/* Location: ./application/controllers/wrh/aksesoris.php */