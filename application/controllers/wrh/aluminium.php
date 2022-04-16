<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aluminium extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->fungsi->restrict();
        $this->load->model('wrh/m_aluminium');
        $this->load->model('wrh/m_aksesoris');
        $this->load->model('klg/m_fppp');
    }

    public function index()
    {
        $this->fungsi->check_previleges('aluminium');
        $data['aluminium_list'] = $this->m_aluminium->getData();

        $data['s_awal_bulan'] = $this->m_aluminium->getStockAwalBulan();
        $data['s_akhir_bulan'] = $this->m_aksesoris->getStockAkhirBulan();

        $data['total_bom'] = $this->m_aluminium->getTotalBOM();
        // print_r($data);
        // die();
        $data['total_in_per_bulan']  = $this->m_aluminium->getTotalInPerBulan();
        $data['total_out_per_bulan'] = $this->m_aluminium->getTotalOutPerBulan();
        $data['warna']               = 'Warna';

        $this->load->view('wrh/aluminium/v_aluminium_list', $data);
        // echo "coba";
    }

    public function list()
    {
        $this->fungsi->check_previleges('aluminium');
        $offset  = $this->uri->segment(4, 0);
        $perpage = 10;
        // $data['user'] = $this->m_catatan->get_user(false,'',$perpage,$offset);
        $data['aluminium_list'] = $this->m_aluminium->getdatapaging(false, '', $perpage, $offset);
        $total_rows       = $this->m_aluminium->getdatapaging(true, '');
        $data['paging']         = $this->fungsi->create_paging('wrh/aluminium/list', $total_rows, $perpage, 4);
        $data['datainfo']       = parse_infotable($offset, $perpage, $total_rows);

        $data['s_awal_bulan']        = $this->m_aluminium->getStockAwalBulan();
        $data['total_bom']           = $this->m_aluminium->getTotalBOM();
        $data['total_in_per_bulan']  = $this->m_aluminium->getTotalInPerBulan();
        $data['total_out_per_bulan'] = $this->m_aluminium->getTotalOutPerBulan();
        $data['warna']               = 'Warna';
        $this->load->view('wrh/aluminium/v_aluminium_list_paging', $data);
    }

    public function search()
    {
        $this->fungsi->check_previleges('aluminium');
        $offset = $this->uri->segment(5, 0);
        if ($offset > 0) {
            $keyword = from_session('keyword');
        } else {
            $keyword = $this->input->post('keyword');
            $this->session->set_userdata('keyword', $keyword);
            $keyword = from_session('keyword');
        }

        $perpage          = 10;
        $data['aluminium_list'] = $this->m_aluminium->getdatapaging(false, $keyword, $perpage, $offset);
        $total_rows       = $this->m_aluminium->getdatapaging(true, $keyword);
        $data['paging']         = $this->fungsi->create_paging('wrh/aluminium/list', $total_rows, $perpage, 4);
        $data['datainfo']       = parse_infotable($offset, $perpage, $total_rows);
        $data['search']         = true;

        $data['s_awal_bulan']        = $this->m_aluminium->getStockAwalBulan();
        $data['total_bom']           = $this->m_aluminium->getTotalBOM();
        $data['total_in_per_bulan']  = $this->m_aluminium->getTotalInPerBulan();
        $data['total_out_per_bulan'] = $this->m_aluminium->getTotalOutPerBulan();
        $data['warna']               = 'Warna';
        $this->load->view('wrh/aluminium/v_aluminium_list_paging', $data);
    }

    public function monitoring_mf()
    {
        $this->fungsi->check_previleges('aluminium');
        $data['aluminium_list']      = $this->m_aluminium->getdataMf();
        $data['s_awal_bulan']        = $this->m_aluminium->getStockAwalBulan();
        $data['s_akhir_bulan'] = $this->m_aksesoris->getStockAkhirBulan();
        $data['total_bom']           = $this->m_aluminium->getTotalBOM();
        $data['total_in_per_bulan']  = $this->m_aluminium->getTotalInPerBulan();
        $data['total_out_per_bulan'] = $this->m_aluminium->getTotalOutPerBulan();
        $data['warna']               = 'MF';
        $this->load->view('wrh/aluminium/v_aluminium_list', $data);
    }

    public function cetakExcelMonitoring()
    {
        $data['aksesoris']    = $this->m_aluminium->getCetakMonitoring(1);
        $data['jenis_barang'] = "Aluminium";
        $this->load->view('wrh/aksesoris/v_aksesoris_cetak_monitoring', $data);
    }

    public function cetakExcelMonitoringMf()
    {
        $data['aksesoris']    = $this->m_aluminium->getCetakMonitoringMf(1);
        $data['jenis_barang'] = "Aluminium";
        $this->load->view('wrh/aksesoris/v_aksesoris_cetak_monitoring', $data);
    }

    public function getDetailTabel()
    {
        $this->fungsi->check_previleges('aluminium');
        $id                = $this->input->post('id');
        $data_aluminium_in = $this->m_aluminium->getDataDetailTabel($id);
        $arr               = array();
        foreach ($data_aluminium_in as $key) {
            $stok_awal_bulan = $this->m_aluminium->getAwalBulanDetailTabel($key->id_item, $key->id_gudang, $key->keranjang);
            $qtyin           = $this->m_aluminium->getQtyInDetailTabelMonitoring($key->id_item, $key->id_gudang, $key->keranjang);
            $qtyout          = $this->m_aluminium->getQtyOutDetailTabelMonitoring($key->id_item, $key->id_gudang, $key->keranjang);
            $qtyinmutasi          = $this->m_aluminium->getQtyInDetailTabelMonitoringMutasi($key->id_item, $key->id_gudang, $key->keranjang);
            $qtyoutmutasi          = $this->m_aluminium->getQtyOutDetailTabelMonitoringMutasi($key->id_item, $key->id_gudang, $key->keranjang);
            $temp            = array(
                "divisi"           => $key->divisi,
                "gudang"           => $key->gudang,
                "keranjang"        => $key->keranjang,
                "stok_awal_bulan"  => $stok_awal_bulan,
                "tot_in"           => $qtyin,
                "tot_out"          => $qtyout,
                "mutasi_in"          => $qtyinmutasi,
                "mutasi_out"          => $qtyoutmutasi,
                "stok_akhir_bulan" => $key->qty,
                // "stok_akhir_bulan" => ($stok_awal_bulan + $qtyin + $qtyinmutasi) - $qtyout - $qtyoutmutasi,
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
        $bulan       = date('m');
        $tahun       = date('Y');
        $data['tbl_del']   = 1;
        $data['tgl_awal']  = $tahun . '-' . $bulan . '-01';
        $data['tgl_akhir'] = date("Y-m-t", strtotime($data['tgl_awal']));
        $data['aluminium'] = $this->m_aluminium->getDataStock($data['tgl_awal'], $data['tgl_akhir']);

        $this->load->view('wrh/aluminium/v_aluminium_in_list', $data);
    }

    public function stok_in_set($tgl_awal = '', $tgl_akhir = '')
    {
        $this->fungsi->check_previleges('aluminium');
        $data['tgl_awal']  = $tgl_awal;
        $data['tgl_akhir'] = $tgl_akhir;
        $data['tbl_del']   = 0;
        $data['aluminium'] = $this->m_aluminium->getDataStock($data['tgl_awal'], $data['tgl_akhir']);

        $this->load->view('wrh/aluminium/v_aluminium_in_list', $data);
    }

    public function finish_stok_in()
    {
        $this->fungsi->check_previleges('aluminium');
        $this->m_aksesoris->hapusTemp(1);
        $this->stok_in();
    }

    public function stok_in_add()
    {
        $this->fungsi->check_previleges('aluminium');
        $data['item']     = $this->m_aluminium->getdataItem();
        $data['gudang']   = $this->db->get_where('master_gudang', array('id_jenis_item' => 1));
        $data['supplier'] = $this->db->get('master_supplier');

        $cek_in_temp = $this->m_aksesoris->getInTemp(1)->num_rows();
        if ($cek_in_temp < 1) {
            $this->load->view('wrh/aluminium/v_aluminium_in', $data);
        } else {
            $data['row_temp'] = $this->m_aksesoris->getInTemp(1)->row();
            $this->load->view('wrh/aluminium/v_aluminium_in_temp', $data);
        }
    }

    public function stok_in_edit($id)
    {
        $this->fungsi->check_previleges('aluminium');
        $data['id']       = $id;
        $data['row']      = $this->m_aluminium->getDataStockRow($id)->row();
        $data['supplier'] = $this->db->get('master_supplier');
        $this->load->view('wrh/aluminium/v_aluminium_edit', $data);
    }

    public function simpan_edit()
    {
        $this->fungsi->check_previleges('aluminium');
        $id  = $this->input->post('id');
        $obj = array(
            'id_supplier'    => $this->input->post('supplier'),
            'no_surat_jalan' => $this->input->post('no_surat_jalan'),
            'no_pr'          => $this->input->post('no_pr'),
            'keterangan'     => $this->input->post('keterangan'),
        );
        $this->m_aluminium->updatestokin($obj, $id);
        $this->fungsi->catat($obj, "mengubah Stock In dengan id " . $id . " data sbb:", true);
        $respon = ['msg' => 'Data Berhasil Dihapus'];
        echo json_encode($respon);
    }

    public function savestokin()
    {
        $this->fungsi->check_previleges('aluminium');

        $cek_in_temp = $this->m_aksesoris->getInTemp(1)->num_rows();;
        if ($cek_in_temp < 1) {
            $data_temp = array(
                'id_user'        => from_session('id'),
                'id_jenis_item'  => 1,
                'tgl_aktual'     => $this->input->post('aktual'),
                'id_supplier'    => $this->input->post('supplier'),
                'no_surat_jalan' => $this->input->post('no_surat_jalan'),
                'no_pr'          => $this->input->post('no_pr'),
                'created'        => date('Y-m-d H:i:s'),
            );
            $this->db->insert('data_in_temp', $data_temp);
        }

        $datapost = array(
            'id_item'        => $this->input->post('item'),
            'inout'          => 1,
            'id_jenis_item'  => 1,
            'aktual'         => $this->input->post('aktual'),
            'qty_in'         => $this->input->post('qty'),
            'id_supplier'    => $this->input->post('supplier'),
            'no_surat_jalan' => $this->input->post('no_surat_jalan'),
            'no_pr'          => $this->input->post('no_pr'),
            'id_gudang'      => $this->input->post('id_gudang'),
            'keranjang'      => str_replace(" ", "", $this->input->post('keranjang')),
            'keterangan'     => $this->input->post('keterangan'),
            'id_penginput'   => from_session('id'),
            'created'        => date('Y-m-d H:i:s'),
            'updated'        => date('Y-m-d H:i:s'),
            'in_temp'        => 1,
        );
        $this->m_aluminium->insertstokin($datapost);
        $data['id'] = $this->db->insert_id();
        $this->fungsi->catat($datapost, "Menyimpan detail stock-in Aluminium sbb:", true);
        $cekDataCounter = $this->m_aluminium->getDataCounter($datapost['id_item'], $datapost['id_gudang'], $datapost['keranjang'])->num_rows();
        if ($cekDataCounter == 0) {
            $simpan = array(
                'id_jenis_item' => 1,
                'id_item'       => $this->input->post('item'),
                'id_gudang'     => $this->input->post('id_gudang'),
                'keranjang'     => str_replace(" ", "", $this->input->post('keranjang')),
                'qty'           => $this->input->post('qty'),
                'created'       => date('Y-m-d H:i:s'),
                'itm_code'      => $this->m_aksesoris->getRowItem($this->input->post('item'))->item_code,
            );
            $this->db->insert('data_counter', $simpan);
        } else {
            $cekQtyCounter = $this->m_aluminium->getDataCounter($datapost['id_item'],  $datapost['id_gudang'], $datapost['keranjang'])->row()->qty;
            $qty_jadi      = (int)$datapost['qty_in'] + (int)$cekQtyCounter;
            $this->m_aluminium->updateDataCounter($datapost['id_item'],  $datapost['id_gudang'], $datapost['keranjang'], $qty_jadi);
        }
        $data['msg'] = "stock Disimpan";
        echo json_encode($data);
    }

    public function deleteIn($id)
    {
        $this->fungsi->check_previleges('aluminium');
        $getRow        = $this->m_aluminium->getRowStock($id);
        $cekQtyCounter = $this->m_aluminium->getDataCounter($getRow->id_item, $getRow->id_gudang, $getRow->keranjang)->row()->qty;
        $qty_jadi      = (int)$cekQtyCounter - (int)$getRow->qty_in;
        $this->m_aluminium->updateDataCounter($getRow->id_item, $getRow->id_gudang, $getRow->keranjang, $qty_jadi);
        sleep(1);
        $data = array(
            'id' => $id,
            'qty_dihapus' => $getRow->qty_in,
        );
        $this->db->where('id', $id);
        $this->db->delete('data_stock');

        $this->fungsi->catat($data, "Menghapus Stock In Aluminium dengan data sbb:", true);
        $this->fungsi->run_js('load_silent("wrh/aluminium/stok_in","#content")');
        $this->fungsi->message_box("Menghapus Stock In Aluminium", "success");
    }


    public function deleteItemIn()
    {
        $this->fungsi->check_previleges('aluminium');
        $id            = $this->input->post('id');
        $getRow        = $this->m_aluminium->getRowStock($id);
        $cekQtyCounter = $this->m_aluminium->getDataCounter($getRow->id_item, $getRow->id_gudang, $getRow->keranjang)->row()->qty;
        $qty_jadi      = (int)$cekQtyCounter - (int)$getRow->qty_in;
        $this->m_aluminium->updateDataCounter($getRow->id_item, $getRow->id_gudang, $getRow->keranjang, $qty_jadi);
        sleep(1);
        $data = array(
            'id' => $id,
            'qty_dihapus' => $getRow->qty_in,
        );
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
        $data['qty_out_proses']     = $this->m_aluminium->getQtyOutProses($id_jenis_item);
        $data['dataFpppOut'] = $this->m_aluminium->getFpppStockOut($id_jenis_item);
        $this->load->view('wrh/aluminium/v_aluminium_out_list', $data);
    }

    public function make_lunas($id_fppp)
    {
        $this->fungsi->check_previleges('aluminium');
        $this->m_aluminium->updateStatusLunasFppp($id_fppp);
        $data = array('id_fppp' => $id_fppp);
        $this->fungsi->catat($data, "Mengubah status menjadi lunas fppp", true);
        $this->stok_out();
    }

    public function stok_out_make($id_fppp)
    {
        $id_jenis_item   = 1;
        $data['id_fppp']       = $id_fppp;
        $data['rowFppp']       = $this->m_aluminium->getRowFppp($id_fppp);
        $data['list_bom']      = $this->m_aluminium->getItemBom($id_fppp);
        $data['id_jenis_item'] = $id_jenis_item;
        $data['aluminium']     = $this->m_aluminium->getAllDataCounter($id_fppp);
        $this->load->view('wrh/aluminium/v_aluminium_detail_bom', $data);
    }

    public function stok_out_make_mf($id_fppp)
    {

        $id_jenis_item = 1;
        $data['id_fppp']     = $id_fppp;
        $this->db->where('id_fppp', $id_fppp);
        $this->db->where('inout', 0);
        $this->db->where('ke_mf', 1);
        $this->db->delete('data_stock');
        $list          = $this->m_aluminium->getListBomKurang($id_fppp);
        foreach ($list->result() as $key) {
            $this->m_aluminium->updatekeMf($key->id, $id_fppp);
        }
        sleep(1);
        $data['rowFppp']       = $this->m_aluminium->getRowFppp($id_fppp);
        $data['list_bom']      = $this->m_aluminium->getItemBomMf($id_fppp);
        $data['id_jenis_item'] = $id_jenis_item;
        $data['aluminium']     = $this->m_aluminium->getAllDataCounter($id_jenis_item);
        $this->load->view('wrh/aluminium/v_aluminium_detail_bom_mf', $data);
    }

    public function hapus_bom($id)
    {
        # code...
    }

    public function saveout()
    {
        $this->fungsi->check_previleges('aluminium');
        $field   = $this->input->post('field');
        $value   = $this->input->post('value');
        $editid  = $this->input->post('id');
        $id_fppp = $this->input->post('id_fppp');
        if ($field == 'produksi_' . $editid) {
            $this->m_aluminium->editRowOut('produksi', $value, $editid);
            $this->m_aluminium->editRowOut('lapangan', 0, $editid);
        } else if ($field == 'lapangan_' . $editid) {
            $this->m_aluminium->editRowOut('lapangan', $value, $editid);
            $this->m_aluminium->editRowOut('produksi', 0, $editid);
        } else {
            $obj = array(
                'id_gudang'    => $this->input->post('gudang'),
                'keranjang'    => str_replace(" ", "", $this->input->post('keranjang')),
                'qty_out'      => $value,
                'id_penginput' => from_session('id'),
                'updated'      => date('Y-m-d H:i:s'),
                'aktual'      => date('Y-m-d'),
            );
            $this->m_aluminium->editQtyOut($editid, $obj);
        }
        if ($field == 'qty_out') {
            if ($value > 0) {
                $this->m_aluminium->editStatusInOut($editid);
            } else {
                $this->m_aluminium->editStatusInOutCancel($editid);
            }
        }
        $id_item      = $this->db->get_where('data_stock', array('id' => $editid))->row()->id_item;
        $id_gudang    = $this->input->post('gudang');
        $keranjang    = str_replace(" ", "", $this->input->post('keranjang'));
        $qtyin        = $this->m_aluminium->getQtyInDetailTabel($id_item,  $id_gudang, $keranjang);
        $qtyout       = $this->m_aluminium->getQtyOutDetailTabel($id_item, $id_gudang, $keranjang);
        $data['qty_gudang'] = $qtyin - $qtyout;
        $this->m_aluminium->updateDataCounter($id_item, $id_gudang, $keranjang, $data['qty_gudang']);

        $id_jenis_item = 1;
        $qty_bom       = $this->m_aluminium->getTotQtyBomFppp($id_jenis_item);
        $qty_out       = $this->m_aluminium->getTotQtyOutFppp($id_jenis_item);
        $q_bom         = @$qty_bom[$id_fppp];
        $q_out         = @$qty_out[$id_fppp];
        if ($q_bom <= $q_out) {
            $this->m_aluminium->updateStatusFppp($id_fppp);
        }

        $data['status'] = "berhasil";
        echo json_encode($data);
    }

    public function saveoutcheck()
    {
        $this->fungsi->check_previleges('aluminium');
        $field   = $this->input->post('field');
        $value   = $this->input->post('value');
        $editid  = $this->input->post('id');
        $id_fppp = $this->input->post('id_fppp');
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
            'sj_mf'        => 0,
            'id_gudang'    => $this->input->post('gudang'),
            'keranjang'    => str_replace(" ", "", $this->input->post('keranjang')),
            'qty_out'      => $qty_out,
            'id_penginput' => from_session('id'),
            'updated'      => date('Y-m-d H:i:s'),
            'aktual'      => date('Y-m-d'),
        );
        $this->m_aluminium->editQtyOut($editid, $obj);
        $this->m_aluminium->editStatusInOut($editid);
        $id_item      = $this->db->get_where('data_stock', array('id' => $editid))->row()->id_item;
        $id_gudang    = $this->input->post('gudang');
        $keranjang    = str_replace(" ", "", $this->input->post('keranjang'));
        $qtyin        = $this->m_aluminium->getQtyInDetailTabel($id_item,  $id_gudang, $keranjang);
        $qtyout       = $this->m_aluminium->getQtyOutDetailTabel($id_item,  $id_gudang, $keranjang);
        $data['qty_gudang'] = $qtyin - $qtyout;
        $this->m_aluminium->updateDataCounter($id_item,  $id_gudang, $keranjang, $data['qty_gudang']);

        $data['status'] = "berhasil";
        echo json_encode($data);
    }

    public function saveoutcheckmf()
    {
        $this->fungsi->check_previleges('aluminium');
        $field   = $this->input->post('field');
        $value   = $this->input->post('value');
        $editid  = $this->input->post('id');
        $id_fppp = $this->input->post('id_fppp');
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
            'sj_mf'        => 1,
            'id_gudang'    => $this->input->post('gudang'),
            'keranjang'    => str_replace(" ", "", $this->input->post('keranjang')),
            'qty_out'      => $qty_out,
            'id_penginput' => from_session('id'),
            'updated'      => date('Y-m-d H:i:s'),
            'aktual'      => date('Y-m-d'),
        );
        $this->m_aluminium->editQtyOut($editid, $obj);
        $this->m_aluminium->editStatusInOut($editid);
        $id_item      = $this->db->get_where('data_stock', array('id' => $editid))->row()->id_item;
        $id_gudang    = $this->input->post('gudang');
        $keranjang    = str_replace(" ", "", $this->input->post('keranjang'));
        $qtyin        = $this->m_aluminium->getQtyInDetailTabel($id_item,  $id_gudang, $keranjang);
        $qtyout       = $this->m_aluminium->getQtyOutDetailTabel($id_item,  $id_gudang, $keranjang);
        $data['qty_gudang'] = $qtyin - $qtyout;
        $this->m_aluminium->updateDataCounter($id_item,  $id_gudang, $keranjang, $data['qty_gudang']);

        $id_stock_sblm = $this->db->get_where('data_stock', array('id' => $editid))->row()->id_stock_sblm;
        $this->m_aluminium->updateIsBom($id_stock_sblm);

        $data['status'] = "berhasil";
        echo json_encode($data);
    }

    public function kirim_parsial($id_fppp, $id_stock)
    {
        $this->fungsi->check_previleges('aluminium');

        $getRowStock = $this->m_aluminium->getRowStock($id_stock);
        $set_parsial = array(
            'qty_bom'     => $getRowStock->qty_out,
            'set_parsial' => 1,
        );
        $this->m_aluminium->updateRowStock($id_stock, $set_parsial);


        $qtyBOM = $getRowStock->qty_bom;
        $kurang = $qtyBOM - $getRowStock->qty_out;
        $object = array(
            'is_bom'        => $getRowStock->is_bom,
            'id_multi_brand'        => $getRowStock->id_multi_brand,
            'id_fppp'       => $id_fppp,
            'is_parsial'    => 1,
            'id_jenis_item' => $getRowStock->id_jenis_item,
            'id_item'       => $getRowStock->id_item,
            'qty_bom'       => $kurang,
            'ke_mf'         => $getRowStock->ke_mf,
            'keterangan'         => $getRowStock->keterangan,
            'is_parsial'    => 1,
            'created'       => date('Y-m-d H:i:s'),
        );
        $this->db->insert('data_stock', $object);
        $this->fungsi->message_box("Kirim Parsial berhasil", "success");
        $this->fungsi->catat($object, "Membuat kirim parsial data sbb:", true);
        $this->fungsi->run_js('load_silent("wrh/aluminium/stok_out_make/' . $id_fppp . '","#content")');
    }

    public function kirim_parsial_mf($id_fppp, $id_stock)
    {
        $this->fungsi->check_previleges('aluminium');

        $getRowStock = $this->m_aluminium->getRowStock($id_stock);
        $set_parsial = array(
            'qty_bom'     => $getRowStock->qty_out,
            'set_parsial' => 1,
        );
        $this->m_aluminium->updateRowStock($id_stock, $set_parsial);


        $qtyBOM = $getRowStock->qty_bom;
        $kurang = $qtyBOM - $getRowStock->qty_out;
        $object = array(
            'is_bom'        => $getRowStock->is_bom,
            'id_multi_brand'        => $getRowStock->id_multi_brand,
            'id_fppp'       => $id_fppp,
            'inout'    => 3,
            'is_parsial'    => 1,
            'id_jenis_item' => $getRowStock->id_jenis_item,
            'id_item'       => $getRowStock->id_item,
            'qty_bom'       => $kurang,
            'ke_mf'         => $getRowStock->ke_mf,
            'keterangan'         => $getRowStock->keterangan,
            'is_parsial'    => 1,
            'created'       => date('Y-m-d H:i:s'),
        );
        $this->db->insert('data_stock', $object);
        $this->fungsi->message_box("Kirim Parsial berhasil", "success");
        $this->fungsi->catat($object, "Membuat kirim parsial data sbb:", true);
        $this->fungsi->run_js('load_silent("wrh/aluminium/stok_out_make_mf/' . $id_fppp . '","#content")');
    }

    public function hapus_parsial($id_fppp, $id_stock)
    {
        $this->fungsi->check_previleges('aluminium');
        $parsial = $this->m_aluminium->getRowStock($id_stock);
        $asli = $this->m_aluminium->getRowStockNonParsial($parsial->id_item, $id_fppp);
        $obj = array(
            'set_parsial'        =>  0,
            'qty_bom'        =>  $asli->qty_bom + $parsial->qty_bom,
        );
        $this->db->where('id', $asli->id);
        $this->db->update('data_stock', $obj);

        $this->m_aluminium->hapusParsial($id_stock);
        $object      = array(
            'id_stock' => $id_stock,
        );
        $this->fungsi->message_box("Hapus Parsial berhasil", "success");
        $this->fungsi->catat($object, "Menghapus parsial data sbb:", true);
        $this->fungsi->run_js('load_silent("wrh/aluminium/stok_out_make/' . $id_fppp . '","#content")');
    }

    public function buat_surat_jalan($id_fppp)
    {
        $this->fungsi->check_previleges('aluminium');
        $data['id_fppp']        = $id_fppp;
        $data['row_fppp']       = $this->m_aluminium->getRowFppp($id_fppp);
        $kode_divisi      = $this->m_aluminium->getKodeDivisi($id_fppp);
        $data['no_surat_jalan'] = str_pad($this->m_aluminium->getNoSuratJalan(), 3, '0', STR_PAD_LEFT) . '/SJ/' . $kode_divisi . '/' . date('m') . '/' . date('Y');

        $this->load->view('wrh/aluminium/v_aluminium_buat_surat_jalan', $data);
    }

    public function buat_surat_jalan_mf($id_fppp)
    {
        $this->fungsi->check_previleges('aluminium');
        $data['id_fppp']        = $id_fppp;
        $data['row_fppp']       = $this->m_aluminium->getRowFppp($id_fppp);
        $kode_divisi      = $this->m_aluminium->getKodeDivisi($id_fppp);
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
        $data['keterangan']  = $this->m_aluminium->getKeterangan();
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
        $id_jenis_item     = 1;
        $id_fppp           = $this->input->post('id_fppp');
        $penerima          = $this->input->post('penerima');
        $alamat_pengiriman = $this->input->post('alamat_pengiriman');
        $sopir             = $this->input->post('sopir');
        $no_kendaraan      = $this->input->post('no_kendaraan');
        $kode_divisi       = $this->m_aluminium->getKodeDivisi($id_fppp);
        $no_surat_jalan    = str_pad($this->m_aluminium->getNoSuratJalan(), 3, '0', STR_PAD_LEFT) . '/SJ/' . $kode_divisi . '/' . date('m') . '/' . date('Y');
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
        $data['id'] = $this->db->insert_id();
        $this->m_aluminium->updateJadiSuratJalan($id_fppp, $data['id']);
        echo json_encode($data);
    }

    public function simpanSuratJalanMf()
    {
        $this->fungsi->check_previleges('aluminium');
        $id_jenis_item     = 1;
        $id_fppp           = $this->input->post('id_fppp');
        $penerima          = $this->input->post('penerima');
        $alamat_pengiriman = $this->input->post('alamat_pengiriman');
        $sopir             = $this->input->post('sopir');
        $no_kendaraan      = $this->input->post('no_kendaraan');
        $kode_divisi       = $this->m_aluminium->getKodeDivisi($id_fppp);
        $no_surat_jalan    = str_pad($this->m_aluminium->getNoSuratJalan(), 3, '0', STR_PAD_LEFT) . '/SJMF/' . $kode_divisi . '/' . date('m') . '/' . date('Y');
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
        $data['id'] = $this->db->insert_id();
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

    public function additemdetailbom($id_fppp)
    {
        $content   = "<div id='divsubcontent'></div>";
        $header    = "Form Tambah Item BOM";
        $subheader = "";
        $buttons[]          = button('', 'Tutup', 'btn btn-default', 'data-dismiss="modal"');
        echo $this->fungsi->parse_modal($header, $subheader, $content, $buttons, "");
        $this->fungsi->run_js('load_silent("wrh/aluminium/showformitemdetailbom/' . $id_fppp . '","#divsubcontent")');
    }

    public function showformitemdetailbom($id_fppp = '')
    {
        $this->fungsi->check_previleges('aluminium');
        $this->load->library('form_validation');
        $id_jenis_item = 1;
        $config        = array(
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
            $data['brand']    = $this->db->get('master_brand');
            $data['item']    = $this->db->get_where('master_item', array('id_jenis_item' => 1,));
            $this->load->view('wrh/aluminium/v_aluminium_add_item_bom', $data);
        } else {
            $datapost_bom = array(
                'is_bom'        => 1,
                'id_multi_brand'       => $this->input->post('id_brand'),
                'id_fppp'       => $this->input->post('id_fppp'),
                'id_jenis_item' => $id_jenis_item,
                'id_item'       => $this->input->post('id_item'),
                'qty_bom'       => $this->input->post('qty'),
                'keterangan'    => 'TAMBAHAN',
                'created'       => date('Y-m-d H:i:s'),
            );
            $this->db->insert('data_stock', $datapost_bom);
            $this->fungsi->run_js('load_silent("wrh/aluminium/stok_out_make/' . $this->input->post('id_fppp') . '","#content")');
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

        $id_item   = $this->db->get_where('data_stock', array('id' => $editid))->row()->id_item;
        $id_gudang = $this->input->post('gudang');
        $keranjang = str_replace(" ", "", $this->input->post('keranjang'));
        $qtyin     = $this->m_aluminium->getQtyInDetailTabel($id_item,  $id_gudang, $keranjang);
        $qtyout    = $this->m_aluminium->getQtyOutDetailTabel($id_item,  $id_gudang, $keranjang);
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
            'detail' => $this->m_aluminium->getDataDetailSendCetakBon($id)->result(),
        );
        // print_r($data['detail']);

        $this->load->view('wrh/aluminium/v_aluminium_cetak_sj_bon', $data);
    }

    public function bon_manual()
    {
        $this->fungsi->check_previleges('aluminium');
        $id_jenis_item = 1;
        $data['surat_jalan'] = $this->m_aluminium->getSuratJalan(2, $id_jenis_item);
        $data['keterangan']  = $this->m_aluminium->getKeterangan();
        $this->load->view('wrh/aluminium/v_aluminium_bon_list', $data);
    }

    public function bon_manual_add()
    {
        $this->fungsi->check_previleges('aluminium');
        $id_jenis_item = 1;
        $data['fppp']        = $this->db->get('data_fppp');
        $data['warna_akhir'] = $this->db->get('master_warna');
        $data['item']        = $this->m_aluminium->getDataItem();
        $data['list_sj']     = $this->m_aluminium->getListItemBonManual();
        $this->load->view('wrh/aluminium/v_aluminium_bon_item', $data);
    }

    public function buat_surat_jalan_bon()
    {
        $this->fungsi->check_previleges('aluminium');
        $id_fppp          = $this->m_aluminium->getListItemBonManual()->row()->id_fppp;
        $data['id_fppp']        = $id_fppp;
        $kode_divisi      = $this->m_aluminium->getKodeDivisi($id_fppp);
        $no_surat_jalan   = str_pad($this->m_aluminium->getNoSuratJalan(), 3, '0', STR_PAD_LEFT) . '/SJBON/' . $kode_divisi . '/' . date('m') . '/' . date('Y');
        $data['no_surat_jalan'] = $no_surat_jalan;
        $data['list_sj']        = $this->m_aluminium->getListItemBonManual();
        $this->load->view('wrh/aluminium/v_aluminium_bon_add', $data);
    }

    public function lihat_item_stok_out($id_sj)
    {
        $this->fungsi->check_previleges('aluminium');
        $data['id_fppp']           = $this->m_aluminium->getRowSuratJalan($id_sj)->row()->id_fppp;
        $data['no_surat_jalan']    = $this->m_aluminium->getRowSuratJalan($id_sj)->row()->no_surat_jalan;
        $data['penerima']          = $this->m_aluminium->getRowSuratJalan($id_sj)->row()->penerima;
        $data['alamat_pengiriman'] = $this->m_aluminium->getRowSuratJalan($id_sj)->row()->alamat_pengiriman;
        $data['sopir']             = $this->m_aluminium->getRowSuratJalan($id_sj)->row()->sopir;
        $data['no_kendaraan']      = $this->m_aluminium->getRowSuratJalan($id_sj)->row()->no_kendaraan;
        $data['list_sj']           = $this->m_aluminium->getListItemStokOut($id_sj);
        $this->load->view('wrh/aluminium/v_aluminium_lihat_item_out', $data);
    }

    public function edit_item_stok_out($id_sj)
    {
        $this->fungsi->check_previleges('aluminium');
        $id_fppp             = $this->m_aluminium->getListItemStokOut($id_sj)->row()->id_fppp;
        $data['fppp']              = $this->db->get('data_fppp');
        $data['warna_akhir']       = $this->db->get('master_warna');
        $data['item']              = $this->m_aluminium->getDataItem();
        $data['id_sj']             = $id_sj;
        $data['id_fppp']           = $id_fppp;
        $data['no_surat_jalan']    = $this->m_aluminium->getRowSuratJalan($id_sj)->row()->no_surat_jalan;
        $data['penerima']          = $this->m_aluminium->getRowSuratJalan($id_sj)->row()->penerima;
        $data['tgl_aktual']        = $this->m_aksesoris->getRowSuratJalan($id_sj)->row()->tgl_aktual;
        $data['alamat_pengiriman'] = $this->m_aluminium->getRowSuratJalan($id_sj)->row()->alamat_pengiriman;
        $data['sopir']             = $this->m_aluminium->getRowSuratJalan($id_sj)->row()->sopir;
        $data['no_kendaraan']      = $this->m_aluminium->getRowSuratJalan($id_sj)->row()->no_kendaraan;
        $data['list_sj']           = $this->m_aluminium->getListItemStokOut($id_sj);
        $this->load->view('wrh/aluminium/v_aluminium_edit_item_out', $data);
    }

    public function simpanSuratJalanBon()
    {
        $this->fungsi->check_previleges('aluminium');
        $id_jenis_item     = 1;
        $id_fppp           = $this->input->post('id_fppp');
        $penerima          = $this->input->post('penerima');
        $tgl_aktual        = $this->input->post('tgl_aktual');
        $alamat_pengiriman = $this->input->post('alamat_pengiriman');
        $sopir             = $this->input->post('sopir');
        $no_kendaraan      = $this->input->post('no_kendaraan');
        $kode_divisi       = $this->m_aluminium->getKodeDivisi($id_fppp);
        $no_surat_jalan    = str_pad($this->m_aluminium->getNoSuratJalan(), 3, '0', STR_PAD_LEFT) . '/SJBON/' . $kode_divisi . '/' . date('m') . '/' . date('Y');
        $obj               = array(
            'id_fppp'           => $id_fppp,
            'no_surat_jalan'    => $no_surat_jalan,
            'penerima'          => $penerima,
            'tgl_aktual'        => $tgl_aktual,
            'alamat_pengiriman' => $alamat_pengiriman,
            'sopir'             => $sopir,
            'no_kendaraan'      => $no_kendaraan,
            'id_jenis_item'     => $id_jenis_item,
            'tipe'              => 2,
            'id_penginput'      => from_session('id'),
            'created'           => date('Y-m-d H:i:s'),
        );
        $this->db->insert('data_surat_jalan', $obj);
        $data['id'] = $this->db->insert_id();
        $this->m_aluminium->updateJadiSuratJalanBon($data['id']);
        echo json_encode($data);
    }

    public function updateSuratJalanBon()
    {
        $this->fungsi->check_previleges('aluminium');
        $id_jenis_item     = 1;
        $id_sj             = $this->input->post('id_sj');
        $penerima          = $this->input->post('penerima');
        $tgl_aktual        = $this->input->post('tgl_aktual');
        $alamat_pengiriman = $this->input->post('alamat_pengiriman');
        $sopir             = $this->input->post('sopir');
        $no_kendaraan      = $this->input->post('no_kendaraan');
        $obj               = array(
            'penerima'          => $penerima,
            'tgl_aktual'        => $tgl_aktual,
            'alamat_pengiriman' => $alamat_pengiriman,
            'sopir'             => $sopir,
            'no_kendaraan'      => $no_kendaraan,
            'id_jenis_item'     => $id_jenis_item,
            'tipe'              => 2,
            'id_penginput'      => from_session('id'),
            'updated'           => date('Y-m-d H:i:s'),
        );
        $this->db->where('id', $id_sj);
        $this->db->update('data_surat_jalan', $obj);
        $data['id'] = $id_sj;
        echo json_encode($data);
    }

    public function getQtyRowGudangBon()
    {
        $id_item      = $this->input->post('item');
        $id_gudang    = $this->input->post('gudang');
        $keranjang    = str_replace(" ", "", $this->input->post('keranjang'));
        $qtyin        = $this->m_aluminium->getQtyInDetailTabel($id_item,  $id_gudang, $keranjang);
        $qtyout       = $this->m_aluminium->getQtyOutDetailTabel($id_item,  $id_gudang, $keranjang);
        $data['qty_gudang'] = $qtyin - $qtyout;

        $data['status'] = "berhasil";
        echo json_encode($data);
    }

    public function savebonmanual()
    {
        $this->fungsi->check_previleges('aluminium');
        $id_jenis_item = 1;
        $id_item       = $this->input->post('item');
        $id_gudang     = $this->input->post('id_gudang');
        $keranjang     = str_replace(" ", "", $this->input->post('keranjang'));
        $cekQtyCounter = $this->m_aluminium->getDataCounter($id_item,  $id_gudang, $keranjang)->row()->qty;
        $qty_out       = $this->input->post('qty');
        if ($qty_out > $cekQtyCounter) {
            $data['sts'] = "gagal";
        } else {
            $datapost      = array(
                'inout'          => 2,
                'id_jenis_item'  => $id_jenis_item,
                'id_surat_jalan' => $this->input->post('id_sj'),
                'id_fppp'        => $this->input->post('id_fppp'),
                'id_multi_brand' => $this->input->post('id_multi_brand'),
                'id_item'        => $this->input->post('item'),
                'id_gudang'      => $this->input->post('id_gudang'),
                'keranjang'      => str_replace(" ", "", $this->input->post('keranjang')),
                'qty_out'        => $this->input->post('qty'),
                'produksi'       => $this->input->post('produksi'),
                'lapangan'       => $this->input->post('lapangan'),
                'id_warna_akhir' => $this->input->post('warna_akhir'),
                'id_penginput'   => from_session('id'),
                'created'        => date('Y-m-d H:i:s'),
                'updated'        => date('Y-m-d H:i:s'),
                'aktual'      => date('Y-m-d'),
            );
            $this->db->insert('data_stock', $datapost);
            $data['id']          = $this->db->insert_id();
            $cekQtyCounter = $this->m_aluminium->getDataCounter($id_item,  $id_gudang, $keranjang)->row()->qty;
            $qty_jadi      = (int)$cekQtyCounter - (int)$qty_out;
            $this->m_aluminium->updateDataCounter($id_item,  $id_gudang, $keranjang, $qty_jadi);

            $this->fungsi->catat($datapost, "Menyimpan detail BON Manual sbb:", true);
            $data['msg'] = "BON Disimpan";
            $data['sts'] = "sukses";
        }
        echo json_encode($data);
    }

    public function deleteItemBonManual()
    {
        $this->fungsi->check_previleges('aluminium');
        $id = $this->input->post('id');

        $id_item   = $this->db->get_where('data_stock', array('id' => $id))->row()->id_item;
        $id_gudang = $this->db->get_where('data_stock', array('id' => $id))->row()->id_gudang;
        $keranjang = $this->db->get_where('data_stock', array('id' => $id))->row()->keranjang;
        $qty_out   = $this->db->get_where('data_stock', array('id' => $id))->row()->qty_out;

        $cekQtyCounter = $this->m_aluminium->getDataCounter($id_item,  $id_gudang, $keranjang)->row()->qty;
        $qty_jadi      = (int)$cekQtyCounter + (int)$qty_out;
        $this->m_aluminium->updateDataCounter($id_item,  $id_gudang, $keranjang, $qty_jadi);
        sleep(1);
        $this->m_aluminium->deleteItemBonManual($id);
        $data = array('id' => $id,);
        $this->fungsi->catat($data, "Menghapus BON manual Detail dengan data sbb:", true);
        $respon = ['msg' => 'Data Berhasil Dihapus'];
        echo json_encode($respon);
    }

    public function deleteSJBon($id)
    {
        $this->fungsi->check_previleges('aluminium');
        $data_detail = $this->db->get_where('data_stock', array('id_surat_jalan' => $id))->result();

        foreach ($data_detail as $key) {
            $id_item   = $this->db->get_where('data_stock', array('id' => $key->id))->row()->id_item;
            $id_divisi = $this->db->get_where('data_stock', array('id' => $key->id))->row()->id_divisi;
            $id_gudang = $this->db->get_where('data_stock', array('id' => $key->id))->row()->id_gudang;
            $keranjang = $this->db->get_where('data_stock', array('id' => $key->id))->row()->keranjang;
            $qty_out   = $this->db->get_where('data_stock', array('id' => $key->id))->row()->qty_out;

            $cekQtyCounter = $this->m_aluminium->getDataCounter($id_item, $id_divisi, $id_gudang, $keranjang)->row()->qty;
            $qty_jadi      = (int)$cekQtyCounter + (int)$qty_out;
            $this->m_aluminium->updateDataCounter($id_item, $id_divisi, $id_gudang, $keranjang, $qty_jadi);
            $this->m_aluminium->deleteItemBonManual($key->id);
        }

        $data = array(
            'id' => $id,
            'no_sj_bon' => $this->db->get_where('data_surat_jalan', array('id' => $id))->row()->no_surat_jalan,
        );
        $this->fungsi->catat($data, "Menghapus SJ BON dengan data sbb:", true);
        sleep(1);
        $this->m_aksesoris->deleteSJBonManual($id);
        $this->fungsi->message_box("Menghapus " . $data['no_sj_bon'] . "", "success");
        $this->fungsi->run_js('load_silent("wrh/aluminium/bon_manual","#content")');
    }


    public function mutasi_stock_add($id = '')
    {
        $this->fungsi->check_previleges('aluminium');
        $id_jenis_item = 1;
        $data['id_item']     = $id;
        $data['row']         = $this->m_aluminium->getDataItemMutasi($id)->row();
        // $data['item']    = $this->m_aluminium->getDataItem();
        // $data['divisi']  = $this->db->get_where('master_divisi_stock', array('id_jenis_item' => $id_jenis_item));
        $data['gudang'] = $this->db->get_where('master_gudang', array('id_jenis_item' => $id_jenis_item));

        $this->load->view('wrh/aluminium/v_aluminium_mutasi_stock_add', $data);
    }

    public function optionGetGudangItem()
    {
        $this->fungsi->check_previleges('aluminium');
        $id_item  = $this->input->post('item');
        $get_data = $this->m_aluminium->getGudangItem($id_item);
        $data     = array();
        foreach ($get_data as $val) {
            $data[] = $val;
        }
        echo json_encode($data, JSON_PRETTY_PRINT);
    }


    public function optionGetGudangDivisi()
    {
        $this->fungsi->check_previleges('aluminium');
        $id_item  = $this->input->post('item');
        $get_data = $this->m_aluminium->getGudangDivisi($id_item);
        $data     = array();
        foreach ($get_data as $val) {
            $data[] = $val;
        }
        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function optionGetKeranjangGudang()
    {
        $this->fungsi->check_previleges('aluminium');
        $id_item   = $this->input->post('item');
        $id_gudang = $this->input->post('gudang');
        $get_data  = $this->m_aluminium->getKeranjangGudang($id_item, $id_gudang);
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
        $id_gudang = $this->input->post('gudang');
        $keranjang = str_replace(" ", "", $this->input->post('keranjang'));
        $data['qty']     = $this->m_aluminium->getQtyCounter($id_item,  $id_gudang, $keranjang);
        echo json_encode($data);
    }

    public function simpanMutasi()
    {
        $this->fungsi->check_previleges('aluminium');
        $id_jenis_item = 1;
        $tgl_aktual       = $this->input->post('tgl_aktual');
        $id_item       = $this->input->post('id_item');
        $id_gudang     = $this->input->post('id_gudang');
        $keranjang     = str_replace(" ", "", $this->input->post('keranjang'));
        $qty           = $this->input->post('qty');

        $id_gudang2 = $this->input->post('id_gudang2');
        $keranjang2 = str_replace(" ", "", $this->input->post('keranjang2'));
        $qty2       = $this->input->post('qty2');

        $datapost_out = array(
            'id_item'       => $id_item,
            'inout'         => 2,
            'mutasi'        => 1,
            'id_jenis_item' => 1,
            'qty_out'       => $qty2,
            'id_gudang'     => $id_gudang,
            'keranjang'     => $keranjang,
            'keterangan'    => 'Mutasi Out',
            'created'       => date('Y-m-d H:i:s'),
            'updated'       => date('Y-m-d H:i:s'),
            'aktual'       => $tgl_aktual,
        );
        $this->m_aluminium->insertstokin($datapost_out);
        $this->fungsi->catat($datapost_out, "Mutasi OUT sbb:", true);
        $data['qty_gudang'] = $qty - $qty2;
        $this->m_aluminium->updateDataCounter($id_item, $id_gudang, $keranjang, $data['qty_gudang']);


        $datapost_in = array(
            'id_item'       => $id_item,
            'mutasi'        => 1,
            'inout'         => 1,
            'id_jenis_item' => 1,
            'qty_in'        => $qty2,
            'id_gudang'     => $id_gudang2,
            'keranjang'     => $keranjang2,
            'keterangan'    => 'Mutasi IN',
            'created'       => date('Y-m-d H:i:s'),
            'updated'       => date('Y-m-d H:i:s'),
            'aktual'       => $tgl_aktual,
        );
        $this->m_aluminium->insertstokin($datapost_in);
        $this->fungsi->catat($datapost_in, "Mutasi IN sbb:", true);

        $cekDataCounter = $this->m_aluminium->getDataCounter($datapost_in['id_item'], $datapost_in['id_gudang'], $datapost_in['keranjang'])->num_rows();
        if ($cekDataCounter == 0) {
            $simpan = array(
                'id_jenis_item' => $id_jenis_item,
                'id_item'       => $datapost_in['id_item'],
                'id_gudang'     => $datapost_in['id_gudang'],
                'keranjang'     => $datapost_in['keranjang'],
                'qty'           => $datapost_in['qty_in'],
                'created'       => date('Y-m-d H:i:s'),
                'itm_code'      => $this->m_aksesoris->getRowItem($this->input->post('id_item'))->item_code,
            );
            $this->db->insert('data_counter', $simpan);
        } else {
            $cekQtyCounter = $this->m_aluminium->getDataCounter($datapost_in['id_item'],  $datapost_in['id_gudang'], $datapost_in['keranjang'])->row()->qty;
            $qty_jadi      = (int)$datapost_in['qty_in'] + (int)$cekQtyCounter;
            $this->m_aluminium->updateDataCounter($datapost_in['id_item'],  $datapost_in['id_gudang'], $datapost_in['keranjang'], $qty_jadi);
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

    public function stockPointList($tgl = '')
    {
        $this->fungsi->check_previleges('aluminium');
        $tgl_def = date('Y-m-d');

        if ($tgl == '') {
            $data['tgl'] = $tgl_def;
        } else {
            $data['tgl'] = $tgl;
        }

        $data['list_data'] = $this->m_aluminium->getListStockPoint($data['tgl']);

        $this->load->view('wrh/aluminium/v_aluminium_stock_point', $data);
    }
}

/* End of file aluminium.php */
/* Location: ./application/controllers/wrh/aluminium.php */