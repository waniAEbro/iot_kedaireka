<?php
defined('BASEPATH') or exit('No direct script access allowed');

class aluminium extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->fungsi->restrict();
        $this->load->model('wrh/m_aluminium');
        $this->load->model('klg/m_fppp');
    }

    public function index()
    {
        $this->fungsi->check_previleges('aluminium');
        $data['aluminium']           = $this->m_aluminium->getData();
        $data['stock_awal_bulan']    = $this->m_aluminium->getStockAwalBulan();
        $data['total_bom']           = $this->m_aluminium->getTotalBOM();
        $data['total_in_per_bulan']  = $this->m_aluminium->getTotalInPerBulan();
        $data['total_out_per_bulan'] = $this->m_aluminium->getTotalOutPerBulan();
        $data['warna']               = 'Warna';
        $this->load->view('wrh/aluminium/v_aluminium_list', $data);
    }

    public function monitoring_mf()
    {
        $this->fungsi->check_previleges('aluminium');
        $data['aluminium']           = $this->m_aluminium->getdataMf();
        $data['stock_awal_bulan']    = $this->m_aluminium->getStockAwalBulan();
        $data['total_bom']           = $this->m_aluminium->getTotalBOM();
        $data['total_in_per_bulan']  = $this->m_aluminium->getTotalInPerBulan();
        $data['total_out_per_bulan'] = $this->m_aluminium->getTotalOutPerBulan();
        $data['warna']               = 'MF';
        $this->load->view('wrh/aluminium/v_aluminium_list', $data);
    }

    public function getDetailTabel()
    {
        $this->fungsi->check_previleges('aluminium');
        $id                = $this->input->post('id');
        $data_aluminium_in = $this->m_aluminium->getDataDetailTabel($id);
        $arr               = array();
        foreach ($data_aluminium_in as $key) {
            $stok_awal_bulan = $this->m_aluminium->getAwalBulanDetailTabel($key->id_item, $key->id_divisi, $key->id_gudang, $key->keranjang);
            $qtyin           = $this->m_aluminium->getQtyInDetailTabelMonth($key->id_item, $key->id_divisi, $key->id_gudang, $key->keranjang);
            $qtyout          = $this->m_aluminium->getQtyOutDetailTabel($key->id_item, $key->id_divisi, $key->id_gudang, $key->keranjang);
            $temp            = array(
                "divisi"           => $key->divisi,
                "gudang"           => $key->gudang,
                "keranjang"        => $key->keranjang,
                "stok_awal_bulan"  => $stok_awal_bulan,
                "tot_in"           => $qtyin,
                "tot_out"          => $qtyout,
                "stok_akhir_bulan" => $qtyin - $qtyout,
                "rata_pemakaian"   => '0',
                "min_stock"        => '0',
            );

            array_push($arr, $temp);
            // echo $key->gt . '<br>';
        }
        $data['detail'] = $arr;
        echo json_encode($data);
    }

    public function stok_in()
    {
        $this->fungsi->check_previleges('aluminium');
        $data['aluminium'] = $this->m_aluminium->getDataStock();

        $this->load->view('wrh/aluminium/v_aluminium_in_list', $data);
    }

    public function stok_in_add()
    {
        $this->fungsi->check_previleges('aluminium');
        $data['item']     = $this->m_aluminium->getdataItem();
        $data['divisi']   = $this->db->get_where('master_divisi_stock', array('id_jenis_item' => 1));
        $data['gudang']   = $this->db->get_where('master_gudang', array('id_jenis_item' => 1));
        $data['supplier'] = $this->db->get('master_supplier');
        $this->load->view('wrh/aluminium/v_aluminium_in', $data);
    }

    public function savestokin()
    {
        $this->fungsi->check_previleges('aluminium');

        $datapost = array(
            'id_item'        => $this->input->post('item'),
            'inout'          => 1,
            'id_jenis_item'  => 1,
            'qty_in'         => $this->input->post('qty'),
            'id_supplier'    => $this->input->post('supplier'),
            'no_surat_jalan' => $this->input->post('no_surat_jalan'),
            'no_pr'          => $this->input->post('no_pr'),
            'id_divisi'      => $this->input->post('id_divisi'),
            'id_gudang'      => $this->input->post('id_gudang'),
            'keranjang'      => $this->input->post('keranjang'),
            'keterangan'     => $this->input->post('keterangan'),
            'created'        => date('Y-m-d H:i:s'),
        );
        $this->m_aluminium->insertstokin($datapost);
        $data['id'] = $this->db->insert_id();
        $this->fungsi->catat($datapost, "Menyimpan detail stock-in Aluminium sbb:", true);
        $cekDataCounter = $this->m_aluminium->getDataCounter($datapost['id_item'], $datapost['id_divisi'], $datapost['id_gudang'], $datapost['keranjang'])->num_rows();
        if ($cekDataCounter == 0) {
            $simpan = array(
                'id_jenis_item' => 1,
                'id_item'       => $this->input->post('item'),
                'id_divisi'     => $this->input->post('id_divisi'),
                'id_gudang'     => $this->input->post('id_gudang'),
                'keranjang'     => $this->input->post('keranjang'),
                'qty'           => $this->input->post('qty'),
                'created'       => date('Y-m-d H:i:s'),
            );
            $this->db->insert('data_counter', $simpan);
        } else {
            $cekQtyCounter = $this->m_aluminium->getDataCounter($datapost['id_item'], $datapost['id_divisi'], $datapost['id_gudang'], $datapost['keranjang'])->row()->qty;
            $qty_jadi      = (int)$datapost['qty_in'] + (int)$cekQtyCounter;
            $this->m_aluminium->updateDataCounter($datapost['id_item'], $datapost['id_divisi'], $datapost['id_gudang'], $datapost['keranjang'], $qty_jadi);
        }
        $data['msg'] = "stock Disimpan";
        echo json_encode($data);
    }

    public function deleteItemIn()
    {
        $this->fungsi->check_previleges('aluminium');
        $id   = $this->input->post('id');
        $data = array('id' => $id,);
        $this->db->where('id', $id);
        $this->db->delete('data_stock');

        $this->fungsi->catat($data, "Menghapus Stock In Aluminium dengan data sbb:", true);
        $respon = ['msg' => 'Data Berhasil Dihapus'];
        echo json_encode($respon);
    }

    public function stok_out()
    {
        $this->fungsi->check_previleges('aluminium');
        // $data['surat_jalan'] = $this->m_aluminium->getSuratJalan(1, 1);
        $id_jenis_item = 1;
        $data['qty_bom']     = $this->m_aluminium->getTotQtyBomFppp($id_jenis_item);
        $data['qty_out']     = $this->m_aluminium->getTotQtyOutFppp($id_jenis_item);
        $data['dataFpppOut'] = $this->m_aluminium->getFpppStockOut($id_jenis_item);
        $this->load->view('wrh/aluminium/v_aluminium_out_list', $data);
    }

    public function stok_out_make($id_fppp)
    {
        $id_jenis_item = 1;
        $data['id_fppp']   = $id_fppp;
        $data['rowFppp']   = $this->m_aluminium->getRowFppp($id_fppp);
        $data['list_bom']  = $this->m_aluminium->getItemBom($id_fppp);
        $data['id_jenis_item']    = $id_jenis_item;
        // $data['divisi']    = $this->m_aluminium->getDivisiBom($id_jenis_item);
        // $data['gudang']    = $this->m_aluminium->getGudangBom($id_jenis_item);
        // $data['keranjang'] = $this->m_aluminium->getKeranjangBom($id_jenis_item);
        // $data['aluminium'] = $this->m_aluminium->getItemBomfppp($id_fppp, $id_jenis_item);
        $data['aluminium'] = $this->m_aluminium->getAllDataCounter($id_fppp);
        $this->load->view('wrh/aluminium/v_aluminium_detail_bom', $data);
    }

    public function stok_out_make_mf($id_fppp)
    {

        $id_jenis_item = 1;
        $data['id_fppp']   = $id_fppp;
        $list =  $this->m_aluminium->getListBomKurang($id_fppp);
        foreach ($list->result() as $key) {
            $this->m_aluminium->updatekeMf($key->id, $id_fppp);
        }
        sleep(1);
        $data['rowFppp']   = $this->m_aluminium->getRowFppp($id_fppp);
        $data['list_bom']  = $this->m_aluminium->getItemBomMf($id_fppp);
        $data['id_jenis_item']    = $id_jenis_item;
        // $data['divisi']    = $this->m_aluminium->getDivisiBom($id_jenis_item);
        // $data['gudang']    = $this->m_aluminium->getGudangBomMf($id_jenis_item);
        // $data['keranjang'] = $this->m_aluminium->getKeranjangBom($id_jenis_item);
        $data['aluminium'] = $this->m_aluminium->getAllDataCounter($id_jenis_item);
        $this->load->view('wrh/aluminium/v_aluminium_detail_bom_mf', $data);
    }

    public function saveout()
    {
        $this->fungsi->check_previleges('aluminium');
        $field  = $this->input->post('field');
        $value  = $this->input->post('value');
        $editid = $this->input->post('id');
        // $id_fppp = $this->input->post('id_fppp');
        if ($field == 'produksi_' . $editid) {
            $this->m_aluminium->editRowOut('produksi', $value, $editid);
            $this->m_aluminium->editRowOut('lapangan', 0, $editid);
        } else if ($field == 'lapangan_' . $editid) {
            $this->m_aluminium->editRowOut('lapangan', $value, $editid);
            $this->m_aluminium->editRowOut('produksi', 0, $editid);
        } else {
            $obj = array(
                'id_divisi' => $this->input->post('divisi'),
                'id_gudang' => $this->input->post('gudang'),
                'keranjang' => $this->input->post('keranjang'),
                'qty_out'   => $value,
            );
            $this->m_aluminium->editQtyOut($editid, $obj);
        }
        if ($field == 'qty_out') {
            $this->m_aluminium->editStatusInOut($editid);
        }
        $id_item      = $this->db->get_where('data_stock', array('id' => $editid))->row()->id_item;
        $id_divisi    = $this->input->post('divisi');
        $id_gudang    = $this->input->post('gudang');
        $keranjang    = $this->input->post('keranjang');
        $qtyin        = $this->m_aluminium->getQtyInDetailTabel($id_item, $id_divisi, $id_gudang, $keranjang);
        $qtyout       = $this->m_aluminium->getQtyOutDetailTabel($id_item, $id_divisi, $id_gudang, $keranjang);
        $data['qty_gudang'] = $qtyin - $qtyout;
        // $this->m_aluminium->updateDataCounter($id_item, $id_divisi, $id_gudang, $keranjang, $data['qty_gudang']);

        $data['status'] = "berhasil";
        echo json_encode($data);
    }

    public function saveoutcheck()
    {
        $this->fungsi->check_previleges('aluminium');
        $field  = $this->input->post('field');
        $value  = $this->input->post('value');
        $editid = $this->input->post('id');
        // $id_fppp = $this->input->post('id_fppp');
        if ($field == 'produksi_' . $editid) {
            $this->m_aluminium->editRowOut('produksi', $value, $editid);
            $this->m_aluminium->editRowOut('lapangan', 0, $editid);
        } else if ($field == 'lapangan_' . $editid) {
            $this->m_aluminium->editRowOut('lapangan', $value, $editid);
            $this->m_aluminium->editRowOut('produksi', 0, $editid);
        }
        $qty_txt = $this->input->post('qtytxt');
        $qty_out = ($qty_txt == '') ? 0 : $qty_txt;

        $obj = array(
            'sj_mf' => 0,
            'id_divisi' => $this->input->post('divisi'),
            'id_gudang' => $this->input->post('gudang'),
            'keranjang' => $this->input->post('keranjang'),
            'qty_out'   => $qty_out,
        );
        $this->m_aluminium->editQtyOut($editid, $obj);
        $this->m_aluminium->editStatusInOut($editid);
        $id_item      = $this->db->get_where('data_stock', array('id' => $editid))->row()->id_item;
        $id_divisi    = $this->input->post('divisi');
        $id_gudang    = $this->input->post('gudang');
        $keranjang    = $this->input->post('keranjang');
        $qtyin        = $this->m_aluminium->getQtyInDetailTabel($id_item, $id_divisi, $id_gudang, $keranjang);
        $qtyout       = $this->m_aluminium->getQtyOutDetailTabel($id_item, $id_divisi, $id_gudang, $keranjang);
        $data['qty_gudang'] = $qtyin - $qtyout;
        $this->m_aluminium->updateDataCounter($id_item, $id_divisi, $id_gudang, $keranjang, $data['qty_gudang']);

        $data['status'] = "berhasil";
        echo json_encode($data);
    }

    public function saveoutcheckmf()
    {
        $this->fungsi->check_previleges('aluminium');
        $field  = $this->input->post('field');
        $value  = $this->input->post('value');
        $editid = $this->input->post('id');
        // $id_fppp = $this->input->post('id_fppp');
        if ($field == 'produksi_' . $editid) {
            $this->m_aluminium->editRowOut('produksi', $value, $editid);
            $this->m_aluminium->editRowOut('lapangan', 0, $editid);
        } else if ($field == 'lapangan_' . $editid) {
            $this->m_aluminium->editRowOut('lapangan', $value, $editid);
            $this->m_aluminium->editRowOut('produksi', 0, $editid);
        }
        $qty_txt = $this->input->post('qtytxt');
        $qty_out = ($qty_txt == '') ? 0 : $qty_txt;

        $obj = array(
            'sj_mf' => 1,
            'id_divisi' => $this->input->post('divisi'),
            'id_gudang' => $this->input->post('gudang'),
            'keranjang' => $this->input->post('keranjang'),
            'qty_out'   => $qty_out,
            // 'updated'   => $qty_out, revisi
        );
        $this->m_aluminium->editQtyOut($editid, $obj);
        $this->m_aluminium->editStatusInOut($editid);
        $id_item      = $this->db->get_where('data_stock', array('id' => $editid))->row()->id_item;
        $id_divisi    = $this->input->post('divisi');
        $id_gudang    = $this->input->post('gudang');
        $keranjang    = $this->input->post('keranjang');
        $qtyin        = $this->m_aluminium->getQtyInDetailTabel($id_item, $id_divisi, $id_gudang, $keranjang);
        $qtyout       = $this->m_aluminium->getQtyOutDetailTabel($id_item, $id_divisi, $id_gudang, $keranjang);
        $data['qty_gudang'] = $qtyin - $qtyout;
        $this->m_aluminium->updateDataCounter($id_item, $id_divisi, $id_gudang, $keranjang, $data['qty_gudang']);

        $id_stock_sblm = $this->db->get_where('data_stock', array('id' => $editid))->row()->id_stock_sblm;
        $this->m_aluminium->updateIsBom($id_stock_sblm);

        $data['status'] = "berhasil";
        echo json_encode($data);
    }

    public function kirim_parsial($id_fppp, $id_stock)
    {
        $this->fungsi->check_previleges('aluminium');
        $getRowStock = $this->m_aluminium->getRowStock($id_stock);
        $qtyBOM = $getRowStock->qty_bom;
        $kurang = $qtyBOM - $getRowStock->qty_out;
        $object      = array(
            'id_fppp'       => $id_fppp,
            'is_parsial'       => 1,
            'is_bom'        => $getRowStock->is_bom,
            'id_jenis_item' => $getRowStock->id_jenis_item,
            'id_item'       => $getRowStock->id_item,
            'qty_bom'       => $kurang,
            'is_parsial'       => 1,
            'created'       => date('Y-m-d H:i:s'),
        );
        $this->db->insert('data_stock', $object);
        $this->fungsi->message_box("Kirim Parsial berhasil", "success");
        $this->fungsi->catat($object, "Membuat kirim parsial data sbb:", true);
        $this->fungsi->run_js('load_silent("wrh/aluminium/stok_out_make/' . $id_fppp . '","#content")');
    }

    public function hapus_parsial($id_fppp, $id_stock)
    {
        $this->fungsi->check_previleges('aluminium');
        $this->m_aluminium->hapusParsial($id_stock);
        $object      = array(
            'id_stock'       => $id_stock,
        );
        $this->fungsi->message_box("Hapus Parsial berhasil", "success");
        $this->fungsi->catat($object, "Menghapus parsial data sbb:", true);
        $this->fungsi->run_js('load_silent("wrh/aluminium/stok_out_make/' . $id_fppp . '","#content")');
    }

    public function buat_surat_jalan($id_fppp)
    {
        $this->fungsi->check_previleges('aluminium');
        $data['id_fppp']        = $id_fppp;
        $data['row_fppp']        = $this->m_aluminium->getRowFppp($id_fppp);
        $kode_divisi = $this->m_aluminium->getKodeDivisi($id_fppp);
        $data['no_surat_jalan'] = str_pad($this->m_aluminium->getNoSuratJalan(), 3, '0', STR_PAD_LEFT) . '/SJ/' . $kode_divisi . '/' . date('m') . '/' . date('Y');

        $this->load->view('wrh/aluminium/v_aluminium_buat_surat_jalan', $data);
    }

    public function buat_surat_jalan_mf($id_fppp)
    {
        $this->fungsi->check_previleges('aluminium');
        $data['id_fppp']        = $id_fppp;
        $data['row_fppp']        = $this->m_aluminium->getRowFppp($id_fppp);
        $kode_divisi = $this->m_aluminium->getKodeDivisi($id_fppp);
        $data['no_surat_jalan'] = str_pad($this->m_aluminium->getNoSuratJalan(), 3, '0', STR_PAD_LEFT) . '/SJMF/' . $kode_divisi . '/' . date('m') . '/' . date('Y');

        $this->load->view('wrh/aluminium/v_aluminium_buat_surat_jalan_mf', $data);
    }

    public function stok_out_add()
    {
        $this->fungsi->check_previleges('aluminium');
        $data['no_fppp']        = $this->db->get_where('data_fppp', array('id_status' => 1));
        $data['no_surat_jalan'] = str_pad($this->m_aluminium->getNoSuratJalan(), 3, '0', STR_PAD_LEFT) . '/SJ/AL/' . date('m') . '/' . date('Y');

        $this->load->view('wrh/aluminium/v_aluminium_out', $data);
    }

    public function list_surat_jalan()
    {
        $this->fungsi->check_previleges('aluminium');
        $id_jenis_item = 1;
        $data['surat_jalan'] = $this->m_aluminium->getSuratJalan(1, $id_jenis_item);
        $data['keterangan'] = $this->m_aluminium->getKeterangan();
        $this->load->view('wrh/aluminium/v_aluminium_out_sj_list', $data);
    }

    public function getDetailFppp()
    {
        $this->fungsi->check_previleges('aluminium');
        $id = $this->input->post('no_fppp');

        $data['nama_proyek']         = $this->m_aluminium->getRowFppp($id)->nama_proyek;
        $data['alamat_proyek']       = $this->m_aluminium->getRowFppp($id)->alamat_proyek;
        $data['sales']               = $this->m_aluminium->getRowFppp($id)->sales;
        $data['deadline_pengiriman'] = $this->m_aluminium->getRowFppp($id)->deadline_pengiriman;
        echo json_encode($data);
    }



    public function simpanSuratJalan()
    {
        $this->fungsi->check_previleges('aluminium');
        $id_jenis_item = 1;
        $id_fppp           = $this->input->post('id_fppp');
        $penerima          = $this->input->post('penerima');
        $alamat_pengiriman = $this->input->post('alamat_pengiriman');
        $sopir             = $this->input->post('sopir');
        $no_kendaraan      = $this->input->post('no_kendaraan');
        $kode_divisi = $this->m_aluminium->getKodeDivisi($id_fppp);
        $no_surat_jalan = str_pad($this->m_aluminium->getNoSuratJalan(), 3, '0', STR_PAD_LEFT) . '/SJ/' . $kode_divisi . '/' . date('m') . '/' . date('Y');
        $obj               = array(
            'id_fppp'           => $id_fppp,
            'no_surat_jalan'    => $no_surat_jalan,
            'penerima'          => $penerima,
            'alamat_pengiriman' => $alamat_pengiriman,
            'sopir'             => $sopir,
            'no_kendaraan'      => $no_kendaraan,
            'id_jenis_item'     => $id_jenis_item,
            'tipe'              => 1,
            'created'           => date('Y-m-d H:i:s'),
        );
        $this->db->insert('data_surat_jalan', $obj);
        $data['id']    = $this->db->insert_id();
        $this->m_aluminium->updateJadiSuratJalan($id_fppp, $data['id']);
        echo json_encode($data);
    }

    public function simpanSuratJalanMf()
    {
        $this->fungsi->check_previleges('aluminium');
        $id_jenis_item = 1;
        $id_fppp           = $this->input->post('id_fppp');
        $penerima          = $this->input->post('penerima');
        $alamat_pengiriman = $this->input->post('alamat_pengiriman');
        $sopir             = $this->input->post('sopir');
        $no_kendaraan      = $this->input->post('no_kendaraan');
        $kode_divisi = $this->m_aluminium->getKodeDivisi($id_fppp);
        $no_surat_jalan = str_pad($this->m_aluminium->getNoSuratJalan(), 3, '0', STR_PAD_LEFT) . '/SJMF/' . $kode_divisi . '/' . date('m') . '/' . date('Y');
        $obj               = array(
            'id_fppp'           => $id_fppp,
            'no_surat_jalan'    => $no_surat_jalan,
            'penerima'          => $penerima,
            'alamat_pengiriman' => $alamat_pengiriman,
            'sopir'             => $sopir,
            'no_kendaraan'      => $no_kendaraan,
            'id_jenis_item'     => $id_jenis_item,
            'tipe'              => 1,
            'created'           => date('Y-m-d H:i:s'),
        );
        $this->db->insert('data_surat_jalan', $obj);
        $data['id']    = $this->db->insert_id();
        $this->m_aluminium->updateJadiSuratJalanMf($id_fppp, $data['id']);
        echo json_encode($data);
    }

    public function updateSuratJalan()
    {
        $this->fungsi->check_previleges('aluminium');
        $id_sj             = $this->input->post('id_sj');
        $penerima          = $this->input->post('penerima');
        $alamat_pengiriman = $this->input->post('alamat_pengiriman');
        $sopir             = $this->input->post('sopir');
        $no_kendaraan      = $this->input->post('no_kendaraan');
        $obj               = array(
            'penerima'          => $penerima,
            'alamat_pengiriman' => $alamat_pengiriman,
            'sopir'             => $sopir,
            'no_kendaraan'      => $no_kendaraan,
            'updated'           => date('Y-m-d H:i:s'),
        );
        $this->db->where('id', $id_sj);
        $this->db->update('data_surat_jalan', $obj);
        $data['id'] = 'ok';
        echo json_encode($data);
    }

    public function finishdetailbom($id_sj)
    {
        $this->fungsi->check_previleges('aluminium');
        $this->m_aluminium->finishdetailbom($id_sj);
        $datapost = array('id_sj' => $id_sj,);
        $this->fungsi->message_box("Fisnish Surat Jalan", "success");
        $this->fungsi->catat($datapost, "Finish Suraj Jalan dengan id:", true);
        $this->stok_out();
    }

    public function additemdetailbom($id_sj, $id_fppp)
    {
        $content   = "<div id='divsubcontent'></div>";
        $header    = "Form Tambah Item BOM";
        $subheader = "";
        $buttons[]          = button('', 'Tutup', 'btn btn-default', 'data-dismiss="modal"');
        echo $this->fungsi->parse_modal($header, $subheader, $content, $buttons, "");
        $this->fungsi->run_js('load_silent("wrh/aluminium/showformitemdetailbom/' . $id_sj . '/' . $id_fppp . '","#divsubcontent")');
    }

    public function showformitemdetailbom($id_sj = '', $id_fppp = '')
    {
        $this->fungsi->check_previleges('aluminium');
        $this->load->library('form_validation');
        $id_jenis_item = 1;
        $config = array(
            array(
                'field' => 'id_item',
                'label' => 'id_item',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['id_fppp'] = $id_fppp;
            $data['id_sj']   = $id_sj;
            $data['item']    = $this->db->get_where('master_item', array('id_jenis_item' => 1,));
            $this->load->view('wrh/aluminium/v_aluminium_add_item_bom', $data);
        } else {
            $datapost_bom = array(
                'id_fppp'       => $this->input->post('id_fppp'),
                'id_jenis_item' => $id_jenis_item,
                'id_item'       => $this->input->post('id_item'),
                'qty'           => $this->input->post('qty'),
                'keterangan'    => 'TAMBAHAN',
                'created'       => date('Y-m-d H:i:s'),
            );
            $this->db->insert('data_fppp_bom', $datapost_bom);

            $object = array(
                'inout'          => 0,
                'id_fppp'        => $this->input->post('id_fppp'),
                'id_surat_jalan' => $this->input->post('id_sj'),
                'id_jenis_item'  => $id_jenis_item,
                'id_item'        => $this->input->post('id_item'),
                'qty_bom'        => $this->input->post('qty'),
                'created'        => date('Y-m-d H:i:s'),
            );
            $this->db->insert('data_stock', $object);
            $this->fungsi->run_js('load_silent("wrh/aluminium/detailbom/' . $this->input->post('id_sj') . '","#content")');
            $this->fungsi->message_box("BOM baru disimpan!", "success");
            $this->fungsi->catat($datapost_bom, "Menambah BOM data sbb:", true);
        }
    }

    public function getQtyRowGudang()
    {
        $this->fungsi->check_previleges('aluminium');
        $field  = $this->input->post('field');
        $value  = $this->input->post('value');
        $editid = $this->input->post('id');
        // $id_fppp = $this->input->post('id_fppp');

        $id_item      = $this->db->get_where('data_stock', array('id' => $editid))->row()->id_item;
        $id_divisi    = $this->input->post('divisi');
        $id_gudang    = $this->input->post('gudang');
        $keranjang    = $this->input->post('keranjang');
        $qtyin        = $this->m_aluminium->getQtyInDetailTabel($id_item, $id_divisi, $id_gudang, $keranjang);
        $qtyout       = $this->m_aluminium->getQtyOutDetailTabel($id_item, $id_divisi, $id_gudang, $keranjang);
        // $data['qty_gudang'] = $qtyin;
        $data['qty_gudang'] = $qtyin - $qtyout;

        $data['status'] = "berhasil";
        echo json_encode($data);
    }



    public function cetakSj($id)
    {
        $data = array(
            'id'     => $id,
            'header' => $this->m_aluminium->getHeaderSendCetak($id)->row(),
            'detail' => $this->m_aluminium->getDataDetailSendCetak($id)->result(),
        );
        // print_r($data['detail']);

        $this->load->view('wrh/aluminium/v_aluminium_cetak_sj', $data);
    }

    public function cetakSjBon($id)
    {
        $data = array(
            'id'     => $id,
            'header' => $this->m_aluminium->getHeaderSendCetak($id)->row(),
            'detail' => $this->m_aluminium->getDataDetailSendCetak($id)->result(),
        );
        // print_r($data['detail']);

        $this->load->view('wrh/aluminium/v_aluminium_cetak_sj_bon', $data);
    }

    public function bon_manual()
    {
        $this->fungsi->check_previleges('aluminium');
        $id_jenis_item = 1;
        $data['surat_jalan'] = $this->m_aluminium->getSuratJalan(2, $id_jenis_item);
        $data['keterangan'] = $this->m_aluminium->getKeterangan();
        $this->load->view('wrh/aluminium/v_aluminium_bon_list', $data);
    }

    public function bon_manual_add()
    {
        $this->fungsi->check_previleges('aluminium');
        $id_jenis_item = 1;
        $data['fppp']              = $this->db->get('data_fppp');
        $data['item']              = $this->m_aluminium->getDataItem();
        $data['divisi']            = $this->m_aluminium->getDivisiBom($id_jenis_item);
        $data['list_sj']           = $this->m_aluminium->getListItemBonManual();
        $this->load->view('wrh/aluminium/v_aluminium_bon_item', $data);
    }

    public function buat_surat_jalan_bon()
    {
        $this->fungsi->check_previleges('aluminium');
        $id_fppp = $this->m_aluminium->getListItemBonManual()->row()->id_fppp;
        $data['id_fppp']        = $id_fppp;
        $kode_divisi = $this->m_aluminium->getKodeDivisi($id_fppp);
        $no_surat_jalan = str_pad($this->m_aluminium->getNoSuratJalan(), 3, '0', STR_PAD_LEFT) . '/SJBON/' . $kode_divisi . '/' . date('m') . '/' . date('Y');
        $data['no_surat_jalan']    = $no_surat_jalan;
        $data['list_sj']           = $this->m_aluminium->getListItemBonManual();
        $this->load->view('wrh/aluminium/v_aluminium_bon_add', $data);
    }

    // public function bon_manual_add()
    // {
    //     $this->fungsi->check_previleges('aluminium');
    //     $data['no_fppp']        = $this->db->get_where('data_fppp', array('id_status' => 1));
    //     $data['no_surat_jalan'] = str_pad($this->m_aluminium->getNoSuratJalan(), 3, '0', STR_PAD_LEFT) . '/SJ/AL/' . date('m') . '/' . date('Y');

    //     $this->load->view('wrh/aluminium/v_aluminium_bon_add', $data);
    // }

    public function simpanSuratJalanBon()
    {
        $this->fungsi->check_previleges('aluminium');
        $id_jenis_item = 1;
        $id_fppp           = $this->input->post('id_fppp');
        $penerima          = $this->input->post('penerima');
        $alamat_pengiriman = $this->input->post('alamat_pengiriman');
        $sopir             = $this->input->post('sopir');
        $no_kendaraan      = $this->input->post('no_kendaraan');
        $kode_divisi = $this->m_aluminium->getKodeDivisi($id_fppp);
        $no_surat_jalan = str_pad($this->m_aluminium->getNoSuratJalan(), 3, '0', STR_PAD_LEFT) . '/SJBON/' . $kode_divisi . '/' . date('m') . '/' . date('Y');
        $obj               = array(
            'id_fppp'           => 0,
            'no_surat_jalan'    => $no_surat_jalan,
            'penerima'          => $penerima,
            'alamat_pengiriman' => $alamat_pengiriman,
            'sopir'             => $sopir,
            'no_kendaraan'      => $no_kendaraan,
            'id_jenis_item'     => $id_jenis_item,
            'tipe'              => 2,
            'created'           => date('Y-m-d H:i:s'),
        );
        $this->db->insert('data_surat_jalan', $obj);
        $data['id']    = $this->db->insert_id();
        $this->m_aluminium->updateJadiSuratJalanBon($data['id']);
        echo json_encode($data);
    }

    // public function edit_bon_manual($id_sj = '')
    // {
    //     $this->fungsi->check_previleges('aluminium');
    //     $id_jenis_item = 1;

    //     $data['id_sj']             = $id_sj;
    //     $data['fppp']              = $this->db->get('data_fppp');
    //     $data['item']              = $this->m_aluminium->getDataItem();
    //     $data['no_surat_jalan']    = $this->m_aluminium->getRowSj($id_sj)->row()->no_surat_jalan;
    //     $data['penerima']          = $this->m_aluminium->getRowSj($id_sj)->row()->penerima;
    //     $data['alamat_pengiriman'] = $this->m_aluminium->getRowSj($id_sj)->row()->alamat_pengiriman;
    //     $data['sopir']             = $this->m_aluminium->getRowSj($id_sj)->row()->sopir;
    //     $data['no_kendaraan']      = $this->m_aluminium->getRowSj($id_sj)->row()->no_kendaraan;
    //     $data['divisi']            = $this->m_aluminium->getDivisiBom($id_jenis_item);
    //     $data['list_sj']           = $this->m_aluminium->getListItemBonManual($id_sj);
    //     $this->load->view('wrh/aluminium/v_aluminium_bon_item', $data);
    // }

    public function getQtyRowGudangBon()
    {
        $id_item      = $this->input->post('item');
        $id_divisi    = $this->input->post('divisi');
        $id_gudang    = $this->input->post('gudang');
        $keranjang    = $this->input->post('keranjang');
        $qtyin        = $this->m_aluminium->getQtyInDetailTabel($id_item, $id_divisi, $id_gudang, $keranjang);
        $qtyout       = $this->m_aluminium->getQtyOutDetailTabel($id_item, $id_divisi, $id_gudang, $keranjang);
        $data['qty_gudang'] = $qtyin - $qtyout;

        $data['status'] = "berhasil";
        echo json_encode($data);
    }

    public function savebonmanual()
    {
        $this->fungsi->check_previleges('aluminium');
        $id_jenis_item = 1;
        $id_item = $this->input->post('item');
        $id_divisi = $this->input->post('id_divisi');
        $id_gudang = $this->input->post('id_gudang');
        $keranjang = $this->input->post('keranjang');
        $datapost = array(
            'inout'          => 2,
            'id_jenis_item'  => $id_jenis_item,
            'id_surat_jalan' => 0,
            'id_fppp'        => $this->input->post('id_fppp'),
            'id_item'        => $this->input->post('item'),
            'id_divisi'      => $this->input->post('id_divisi'),
            'id_gudang'      => $this->input->post('id_gudang'),
            'keranjang'      => $this->input->post('keranjang'),
            'qty_out'        => $this->input->post('qty'),
            'produksi'       => $this->input->post('produksi'),
            'lapangan'       => $this->input->post('lapangan'),
            'created'        => date('Y-m-d H:i:s'),
        );
        $this->db->insert('data_stock', $datapost);
        $qtyin        = $this->m_aluminium->getQtyInDetailTabel($id_item, $id_divisi, $id_gudang, $keranjang);
        $qtyout       = $this->m_aluminium->getQtyOutDetailTabel($id_item, $id_divisi, $id_gudang, $keranjang);
        $data['qty_gudang'] = $qtyin - $qtyout;
        $this->m_aluminium->updateDataCounter($id_item, $id_divisi, $id_gudang, $keranjang, $data['qty_gudang']);

        $this->fungsi->catat($datapost, "Menyimpan detail BON Manual sbb:", true);
        $data['msg'] = "BON Disimpan";
        echo json_encode($data);
    }

    public function deleteItemBonManual()
    {
        $this->fungsi->check_previleges('aluminium');
        $id   = $this->input->post('id');

        $id_item      = $this->db->get_where('data_stock', array('id' => $id))->row()->id_item;
        $id_divisi    = $this->db->get_where('data_stock', array('id' => $id))->row()->id_divisi;
        $id_gudang    = $this->db->get_where('data_stock', array('id' => $id))->row()->id_gudang;
        $keranjang    = $this->db->get_where('data_stock', array('id' => $id))->row()->keranjang;
        $this->m_aluminium->deleteItemBonManual($id);
        $qtyin        = $this->m_aluminium->getQtyInDetailTabel($id_item, $id_divisi, $id_gudang, $keranjang);
        $qtyout       = $this->m_aluminium->getQtyOutDetailTabel($id_item, $id_divisi, $id_gudang, $keranjang);
        $data['qty_gudang'] = $qtyin - $qtyout;
        $this->m_aluminium->updateDataCounter($id_item, $id_divisi, $id_gudang, $keranjang, $data['qty_gudang']);

        $data = array('id' => $id,);
        $this->fungsi->catat($data, "Menghapus BON manual Detail dengan data sbb:", true);
        $respon = ['msg' => 'Data Berhasil Dihapus'];
        echo json_encode($respon);
    }

    // public function finishdetailbon($id_sj)
    // {
    //     $this->fungsi->check_previleges('aluminium');
    //     // $this->m_aluminium->finishdetailbom($id_sj);
    //     $datapost = array('id_sj' => $id_sj,);
    //     $this->fungsi->message_box("Fisnish BON Manual", "success");
    //     $this->fungsi->catat($datapost, "Finish BON Manual dengan id:", true);
    //     $this->bon_manual();
    // }

    public function mutasi_stock_add($id = '')
    {
        $this->fungsi->check_previleges('aluminium');
        $id_jenis_item = 1;
        $data['id_item'] = $id;
        $data['item']    = $this->m_aluminium->getDataItem();
        $data['divisi']  = $this->db->get_where('master_divisi_stock', array('id_jenis_item' => $id_jenis_item));
        $data['gudang']  = $this->db->get_where('master_gudang', array('id_jenis_item' => $id_jenis_item));
        $this->load->view('wrh/aluminium/v_aluminium_mutasi_stock_add', $data);
    }

    public function optionGetGudangDivisi()
    {
        $this->fungsi->check_previleges('aluminium');
        $id_item   = $this->input->post('item');
        $id_divisi = $this->input->post('divisi');
        $get_data  = $this->m_aluminium->getGudangDivisi($id_item, $id_divisi);
        $data      = array();
        foreach ($get_data as $val) {
            $data[] = $val;
        }
        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function optionGetKeranjangGudang()
    {
        $this->fungsi->check_previleges('aluminium');
        $id_item   = $this->input->post('item');
        $id_divisi = $this->input->post('divisi');
        $id_gudang = $this->input->post('gudang');
        $get_data  = $this->m_aluminium->getKeranjangGudang($id_item, $id_divisi, $id_gudang);
        $data      = array();
        foreach ($get_data as $val) {
            $data[] = $val;
        }
        echo json_encode($data, JSON_PRETTY_PRINT);
    }
    public function optionGetQtyKeranjang()
    {
        $this->fungsi->check_previleges('aluminium');
        $id_item   = $this->input->post('item');
        $id_divisi = $this->input->post('divisi');
        $id_gudang = $this->input->post('gudang');
        $keranjang = $this->input->post('keranjang');
        $qtyin     = $this->m_aluminium->getQtyInDetailTabel($id_item, $id_divisi, $id_gudang, $keranjang);
        $qtyout    = $this->m_aluminium->getQtyOutDetailTabel($id_item, $id_divisi, $id_gudang, $keranjang);

        $get_data = $qtyin - $qtyout;
        $data['qty']    = $get_data;
        echo json_encode($data);
    }

    public function simpanMutasi()
    {
        $this->fungsi->check_previleges('aluminium');
        $id_jenis_item = 1;
        $id_item   = $this->input->post('item');
        $id_divisi = $this->input->post('divisi');
        $id_gudang = $this->input->post('gudang');
        $keranjang = $this->input->post('keranjang');

        $datapost_out = array(
            'id_item'    => $this->input->post('id_item'),
            'inout'      => 2,
            'mutasi'     => 1,
            'qty_out'    => $this->input->post('qty2'),
            'id_divisi'  => $this->input->post('id_divisi'),
            'id_gudang'  => $this->input->post('id_gudang'),
            'keranjang'  => $this->input->post('keranjang'),
            'keterangan' => 'Mutasi Out',
            'created'    => date('Y-m-d H:i:s'),
        );
        $this->m_aluminium->insertstokin($datapost_out);
        $this->fungsi->catat($datapost_out, "Mutasi OUT sbb:", true);
        $qtyin        = $this->m_aluminium->getQtyInDetailTabel($id_item, $id_divisi, $id_gudang, $keranjang);
        $qtyout       = $this->m_aluminium->getQtyOutDetailTabel($id_item, $id_divisi, $id_gudang, $keranjang);
        $data['qty_gudang'] = $qtyin - $qtyout;
        $this->m_aluminium->updateDataCounter($id_item, $id_divisi, $id_gudang, $keranjang, $data['qty_gudang']);


        $datapost_in = array(
            'id_item'    => $this->input->post('id_item'),
            'mutasi'     => 1,
            'inout'      => 1,
            'qty_in'     => $this->input->post('qty2'),
            'id_divisi'  => $this->input->post('id_divisi2'),
            'id_gudang'  => $this->input->post('id_gudang2'),
            'keranjang'  => $this->input->post('keranjang2'),
            'keterangan' => 'Mutasi IN',
            'created'    => date('Y-m-d H:i:s'),
        );
        $this->m_aluminium->insertstokin($datapost_in);
        $this->fungsi->catat($datapost_in, "Mutasi IN sbb:", true);

        $cekDataCounter = $this->m_aluminium->getDataCounter($datapost_in['id_item'], $datapost_in['id_divisi'], $datapost_in['id_gudang'], $datapost_in['keranjang'])->num_rows();
        if ($cekDataCounter == 0) {
            $simpan = array(
                'id_jenis_item' => $id_jenis_item,
                'id_item'       => $datapost_in['id_item'],
                'id_divisi'     => $datapost_in['id_divisi'],
                'id_gudang'     => $datapost_in['id_gudang'],
                'keranjang'     => $datapost_in['keranjang'],
                'qty'           => $datapost_in['qty_in'],
                'created'       => date('Y-m-d H:i:s'),
            );
            $this->db->insert('data_counter', $simpan);
        } else {
            $cekQtyCounter = $this->m_aluminium->getDataCounter($datapost_in['id_item'], $datapost_in['id_divisi'], $datapost_in['id_gudang'], $datapost_in['keranjang'])->row()->qty;
            $qty_jadi      = (int)$datapost_in['qty_in'] + (int)$cekQtyCounter;
            $this->m_aluminium->updateDataCounter($datapost_in['id_item'], $datapost_in['id_divisi'], $datapost_in['id_gudang'], $datapost_in['keranjang'], $qty_jadi);
        }
        $data['pesan'] = "Berhasil";
        echo json_encode($data);
    }

    public function mutasi_stock_history($id = '')
    {
        $this->fungsi->check_previleges('aluminium');
        $data['item']   = $this->db->get_where('master_item', array("id" => $id))->row();
        $data['mutasi'] = $this->m_aluminium->getMutasiHistory($id);

        $this->load->view('wrh/aluminium/v_aluminium_mutasi_stock_history', $data);
    }
}

/* End of file aluminium.php */
/* Location: ./application/controllers/wrh/aluminium.php */