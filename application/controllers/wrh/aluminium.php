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
        $data['aluminium'] = $this->m_aluminium->getData();
        $data['total_in']  = $this->m_aluminium->getTotalIn();
        $data['total_out'] = $this->m_aluminium->getTotalOut();
        $data['total_bom'] = $this->m_aluminium->getTotalBom();
        $this->load->view('wrh/aluminium/v_aluminium_list', $data);
    }

    public function getDetailTabel($value = '')
    {
        $this->fungsi->check_previleges('aluminium');
        $id = $this->input->post('id');
        // $data['detail'] = $this->m_aluminium->getDataDetailTabel($id);
        // echo json_encode($data);
        $data_aluminium_in = $this->m_aluminium->getDataDetailTabel($id);
        $awal_bulan        = $this->m_aluminium->getTotalDivisiGudangAwalBulan();
        $rata              = $this->m_aluminium->getTotalDivisiGudangRata();
        $min_stock         = $this->m_aluminium->getTotalDivisiGudangMinStock();
        $in                = $this->m_aluminium->getTotalDivisiGudangIn();
        $out               = $this->m_aluminium->getTotalDivisiGudangOut();
        $arr               = array();
        foreach ($data_aluminium_in as $key) {
            $qtyin           = @$in[$key->section_ata][$key->id_divisi][$key->id_gudang];
            $qtyout          = @$out[$key->section_ata][$key->id_divisi][$key->id_gudang];
            $stok_awal_bulan = @$awal_bulan[$key->section_ata][$key->id_divisi][$key->id_gudang][$key->keranjang];
            $stok_rata       = @$rata[$key->section_ata][$key->id_divisi][$key->id_gudang][$key->keranjang];
            $stok_min_stock  = @$min_stock[$key->section_ata][$key->id_divisi][$key->id_gudang][$key->keranjang];
            $temp            = array(
                "divisi"           => $key->divisi,
                "gudang"           => $key->gudang,
                "keranjang"        => $key->keranjang,
                "stok_awal_bulan"  => $stok_awal_bulan,
                "tot_in"           => $qtyin,
                "tot_out"          => $qtyout,
                "stok_akhir_bulan" => $qtyin - $qtyout,
                "rata_pemakaian"   => $stok_rata,
                "min_stock"        => $stok_min_stock,
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
        $data['section_ata'] = $this->m_aluminium->getData();
        $data['supplier']    = $this->db->get('master_supplier');
        $data['divisi']      = $this->db->get('master_divisi_stock');
        $data['gudang']      = $this->db->get('master_gudang');

        $this->load->view('wrh/aluminium/v_aluminium_in', $data);
    }

    public function optionGetSectionAllure()
    {
        $this->fungsi->check_previleges('aluminium');
        $section_ata = $this->input->post('section_ata');
        $get_data    = $this->m_aluminium->optionGetSectionAllure($section_ata);
        $data        = array();
        foreach ($get_data as $val) {
            $data[] = $val;
        }
        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function optionGetSectionAta()
    {
        $this->fungsi->check_previleges('aluminium');
        $section_allure = $this->input->post('section_allure');
        $get_data       = $this->m_aluminium->optionGetSectionAta($section_allure);
        $data           = array();
        foreach ($get_data as $val) {
            $data[] = $val;
        }
        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function optionGetTemper()
    {
        $this->fungsi->check_previleges('aluminium');
        $section_ata    = $this->input->post('section_ata');
        $section_allure = $this->input->post('section_allure');
        $get_data       = $this->m_aluminium->optionGetTemper($section_ata, $section_allure);
        $data           = array();
        foreach ($get_data as $val) {
            $data[] = $val;
        }
        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function optionGetKodeWarna()
    {
        $this->fungsi->check_previleges('aluminium');
        $section_ata    = $this->input->post('section_ata');
        $section_allure = $this->input->post('section_allure');
        $temper         = $this->input->post('temper');
        $get_data       = $this->m_aluminium->optionGetTemper($section_ata, $section_allure, $temper);
        $data           = array();
        foreach ($get_data as $val) {
            $data[] = $val;
        }
        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function optionGetUkuran()
    {
        $this->fungsi->check_previleges('aluminium');
        $section_ata    = $this->input->post('section_ata');
        $section_allure = $this->input->post('section_allure');
        $temper         = $this->input->post('temper');
        $kode_warna     = $this->input->post('kode_warna');
        $get_data       = $this->m_aluminium->optionGetTemper($section_ata, $section_allure, $temper, $kode_warna);
        $data           = array();
        foreach ($get_data as $val) {
            $data[] = $val;
        }
        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function savestokin($value = '')
    {
        $this->fungsi->check_previleges('aluminium');

        $datapost = array(
            'tgl_proses'     => $this->input->post('tgl_proses'),
            'section_ata'    => $this->input->post('section_ata'),
            'section_allure' => $this->input->post('section_allure'),
            'temper'         => $this->input->post('temper'),
            'kode_warna'     => $this->input->post('kode_warna'),
            'ukuran'         => $this->input->post('ukuran'),
            'qty'            => $this->input->post('qty'),
            'supplier'       => $this->input->post('supplier'),
            'no_surat_jalan' => $this->input->post('no_surat_jalan'),
            'no_pr'          => $this->input->post('no_pr'),
            'id_divisi'      => $this->input->post('id_divisi'),
            'id_gudang'      => $this->input->post('id_gudang'),
            'keranjang'      => $this->input->post('keranjang'),
            'keterangan'     => $this->input->post('keterangan'),
        );
        $this->m_aluminium->insertstokin($datapost);

        $data['id'] = $this->db->insert_id();

        $this->fungsi->catat($datapost, "Menyimpan detail stock-in Aluminium sbb:", true);
        $data['msg'] = "stock Disimpan";
        echo json_encode($data);
    }

    public function deleteItemIn()
    {
        $this->fungsi->check_previleges('aluminium');
        $id   = $this->input->post('id');
        $data = array('id' => $id,);
        $this->db->where('id', $id);
        $this->db->delete('data_aluminium_in');

        $this->fungsi->catat($data, "Menghapus Stock In Aluminium dengan data sbb:", true);
        $respon = ['msg' => 'Data Berhasil Dihapus'];
        echo json_encode($respon);
    }

    public function stok_out()
    {
        $this->fungsi->check_previleges('aluminium');
        $data['fppp'] = $this->m_aluminium->getfpppaluminium();
        $this->load->view('wrh/aluminium/v_aluminium_out_list', $data);
    }

    public function stok_out_add()
    {
        $this->fungsi->check_previleges('aluminium');
        $data['no_fppp'] = $this->db->get('data_fppp');
        $this->load->view('wrh/aluminium/v_aluminium_out', $data);
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

    public function detailbom($id)
    {
        $this->fungsi->check_previleges('aluminium');
        $cek_fppp_out = $this->m_aluminium->cek_fppp_out($id);
        $bom          = $this->m_fppp->bom_aluminium($id);
        $divisi       = $this->m_aluminium->getRowFppp($id)->id_divisi;
        if ($cek_fppp_out < 1) {
            foreach ($bom->result() as $row) {
                $obj = array(
                    'tgl_proses'     => date('Y-m-d'),
                    'id_fppp'        => $id,
                    'section_ata'    => $row->section_ata,
                    'section_allure' => $row->section_allure,
                    'temper'         => $row->temper,
                    'kode_warna'     => $row->kode_warna,
                    'ukuran'         => $row->ukuran,
                    'qty_bom'        => $row->qty,
                    'id_divisi'      => $divisi,
                    'id_gudang'      => '1',
                    'produksi'       => '1',
                    'created'        => date('Y-m-d H:i:s'),
                );
                $this->db->insert('data_aluminium_out', $obj);
            }
        }
        sleep(0.25);
        $data['id_fppp']             = $id;
        $data['total_out']           = $this->m_aluminium->getTotalItemFpppOut();
        $data['bom_aluminium']       = $this->m_aluminium->getBomaluminium($id);
        $data['no_fppp']             = $this->m_aluminium->getRowFppp($id)->no_fppp;
        $data['nama_proyek']         = $this->m_aluminium->getRowFppp($id)->nama_proyek;
        $data['alamat_proyek']       = $this->m_aluminium->getRowFppp($id)->alamat_proyek;
        $data['sales']               = $this->m_aluminium->getRowFppp($id)->sales;
        $data['deadline_pengiriman'] = $this->m_aluminium->getRowFppp($id)->deadline_pengiriman;
        $data['divisi']              = get_options($this->db->get('master_divisi_stock'), 'id', 'divisi', true);
        $data['gudang']              = get_options($this->db->get('master_gudang'), 'id', 'gudang', true);
        $this->load->view('wrh/aluminium/v_aluminium_detail_bom', $data);
    }

    public function kuncidetailbom($id = '', $id_detail = '')
    {
        $this->fungsi->check_previleges('aluminium');
        $this->m_aluminium->kunciStockOut($id_detail);
        $data['id_fppp']             = $id;
        $data['total_out']           = $this->m_aluminium->getTotalItemFpppOut();
        $data['bom_aluminium']       = $this->m_aluminium->getBomaluminium($id);
        $data['no_fppp']             = $this->m_aluminium->getRowFppp($id)->no_fppp;
        $data['nama_proyek']         = $this->m_aluminium->getRowFppp($id)->nama_proyek;
        $data['alamat_proyek']       = $this->m_aluminium->getRowFppp($id)->alamat_proyek;
        $data['sales']               = $this->m_aluminium->getRowFppp($id)->sales;
        $data['deadline_pengiriman'] = $this->m_aluminium->getRowFppp($id)->deadline_pengiriman;
        $data['divisi']              = get_options($this->db->get('master_divisi'), 'id', 'divisi', true);
        $data['gudang']              = get_options($this->db->get('master_gudang'), 'id', 'gudang', true);
        $this->fungsi->message_box("Kunci Berhasil", "success");
        $this->load->view('wrh/aluminium/v_aluminium_detail_bom', $data);
    }

    public function bukakuncidetailbom($id = '', $id_detail = '')
    {
        $this->fungsi->check_previleges('aluminium');
        $this->m_aluminium->bukakunciStockOut($id_detail);
        $data['id_fppp']             = $id;
        $data['total_out']           = $this->m_aluminium->getTotalItemFpppOut();
        $data['bom_aluminium']       = $this->m_aluminium->getBomaluminium($id);
        $data['no_fppp']             = $this->m_aluminium->getRowFppp($id)->no_fppp;
        $data['nama_proyek']         = $this->m_aluminium->getRowFppp($id)->nama_proyek;
        $data['alamat_proyek']       = $this->m_aluminium->getRowFppp($id)->alamat_proyek;
        $data['sales']               = $this->m_aluminium->getRowFppp($id)->sales;
        $data['deadline_pengiriman'] = $this->m_aluminium->getRowFppp($id)->deadline_pengiriman;
        $data['divisi']              = get_options($this->db->get('master_divisi'), 'id', 'divisi', true);
        $data['gudang']              = get_options($this->db->get('master_gudang'), 'id', 'gudang', true);
        $this->fungsi->message_box("Buka Kunci Berhasil", "success");
        $this->load->view('wrh/aluminium/v_aluminium_detail_bom', $data);
    }

    public function kirimparsial($id = '', $id_detail = '')
    {
        $this->fungsi->check_previleges('aluminium');
        $rowout = $this->m_aluminium->getRowaluminiumOut($id_detail);
        $obj    = array(
            'tgl_proses'     => date('Y-m-d'),
            'id_fppp'        => $id,
            'section_ata'    => $rowout->section_ata,
            'section_allure' => $rowout->section_allure,
            'temper'         => $rowout->temper,
            'kode_warna'     => $rowout->kode_warna,
            'ukuran'         => $rowout->ukuran,
            'qty_bom'        => $rowout->qty_bom,
            'id_divisi'      => $rowout->id_divisi,
            'id_gudang'      => $rowout->id_gudang,
            'produksi'       => '1',
            'created'        => date('Y-m-d H:i:s'),
        );
        $this->db->insert('data_aluminium_out', $obj);
        sleep(0.25);
        $data['id_fppp']             = $id;
        $data['total_out']           = $this->m_aluminium->getTotalItemFpppOut();
        $data['bom_aluminium']       = $this->m_aluminium->getBomaluminium($id);
        $data['no_fppp']             = $this->m_aluminium->getRowFppp($id)->no_fppp;
        $data['nama_proyek']         = $this->m_aluminium->getRowFppp($id)->nama_proyek;
        $data['alamat_proyek']       = $this->m_aluminium->getRowFppp($id)->alamat_proyek;
        $data['sales']               = $this->m_aluminium->getRowFppp($id)->sales;
        $data['deadline_pengiriman'] = $this->m_aluminium->getRowFppp($id)->deadline_pengiriman;
        $data['divisi']              = get_options($this->db->get('master_divisi'), 'id', 'divisi', true);
        $data['gudang']              = get_options($this->db->get('master_gudang'), 'id', 'gudang', true);
        $this->fungsi->message_box("Parsial Berhasil", "success");
        $this->load->view('wrh/aluminium/v_aluminium_detail_bom', $data);
    }

    public function finishdetailbom($id = '')
    {
        $this->fungsi->check_previleges('aluminium');
        $this->m_aluminium->finishStockOut($id);
        $data['id_fppp']             = $id;
        $data['total_out']           = $this->m_aluminium->getTotalItemFpppOut();
        $data['bom_aluminium']       = $this->m_aluminium->getBomaluminium($id);
        $data['no_fppp']             = $this->m_aluminium->getRowFppp($id)->no_fppp;
        $data['nama_proyek']         = $this->m_aluminium->getRowFppp($id)->nama_proyek;
        $data['alamat_proyek']       = $this->m_aluminium->getRowFppp($id)->alamat_proyek;
        $data['sales']               = $this->m_aluminium->getRowFppp($id)->sales;
        $data['deadline_pengiriman'] = $this->m_aluminium->getRowFppp($id)->deadline_pengiriman;
        $data['divisi']              = get_options($this->db->get('master_divisi_stock'), 'id', 'divisi', true);
        $data['gudang']              = get_options($this->db->get('master_gudang'), 'id', 'gudang', true);

        $this->fungsi->message_box("finish Berhasil", "success");
        $this->load->view('wrh/aluminium/v_aluminium_detail_bom', $data);
    }

    public function saveout()
    {
        $this->fungsi->check_previleges('aluminium');
        $field  = $this->input->post('field');
        $value  = $this->input->post('value');
        $editid = $this->input->post('id');
        // $total_out = $this->m_aluminium->getTotalItemFpppOut();
        if ($field == 'produksi') {
            $this->m_aluminium->editRowOut($field, $value, $editid);
            $this->m_aluminium->editRowOut('lapangan', 0, $editid);
        } else if ($field == 'lapangan') {
            $this->m_aluminium->editRowOut($field, $value, $editid);
            $this->m_aluminium->editRowOut('produksi', 0, $editid);
        } else {
            $this->m_aluminium->editRowOut($field, $value, $editid);
        }
        sleep(0.25);
        $section_ata = $this->m_aluminium->getRowaluminiumOut($editid)->section_ata;
        $divisi      = $this->m_aluminium->getRowaluminiumOut($editid)->id_divisi;
        $gudang      = $this->m_aluminium->getRowaluminiumOut($editid)->id_gudang;
        $qty_gudang  = $this->m_aluminium->getQtyGudang($section_ata, $divisi, $gudang);

        $data['qty_gudang'] = $qty_gudang;
        $data['status']     = "berhasil";
        echo json_encode($data);
    }

    public function bon_manual()
    {
        $this->fungsi->check_previleges('aluminium');
        $data['bom_aluminium'] = $this->m_aluminium->getBonManual();

        $this->load->view('wrh/aluminium/v_aluminium_bon_manual_list', $data);
    }
    public function getBonDetailTabel($value = '')
    {
        $this->fungsi->check_previleges('aluminium');
        $id_bon   = $this->input->post('id_bon');
        $data['detail'] = $this->m_aluminium->getBomaluminiumManual($id_bon);
        echo json_encode($data);
    }

    public function bon_manual_add()
    {
        $this->fungsi->check_previleges('aluminium');
        $data['section_ata'] = $this->m_aluminium->getData();
        $data['fppp']        = $this->db->get('data_fppp');
        $data['nama_proyek'] = $this->m_aluminium->getNamaProyekList();
        $data['supplier']    = $this->db->get('master_supplier');
        $data['divisi']      = $this->db->get('master_divisi_stock');
        $data['gudang']      = $this->db->get('master_gudang');
        $data['no_form']     = str_pad($this->m_aluminium->getNoFormBon(), 3, '0', STR_PAD_LEFT) . '/FORM/' . date('m') . '/' . date('Y');

        $this->load->view('wrh/aluminium/v_aluminium_bon_out', $data);
    }

    public function getNamaProyek()
    {
        $this->fungsi->check_previleges('aluminium');
        $id_fppp     = $this->input->post('id_fppp');
        $nama_proyek = $this->m_aluminium->getRowFppp($id_fppp)->nama_proyek;
        $respon      = ['nama_proyek' => $nama_proyek];
        echo json_encode($respon);
    }

    public function getQtyDivisiGudang()
    {
        $this->fungsi->check_previleges('aluminium');
        $section_ata = $this->input->post('section_ata');
        $id_divisi   = $this->input->post('id_divisi');
        $id_gudang   = $this->input->post('id_gudang');
        $out         = $this->m_aluminium->getTotalDivisiGudangOut();
        $in          = $this->m_aluminium->getTotalDivisiGudangIn();
        $res_out     = @$out[$section_ata][$id_divisi][$id_gudang];
        $res_in      = @$in[$section_ata][$id_divisi][$id_gudang];
        $result      = $res_in -  $res_out;
        $respon      = ['stock' => $result];
        echo json_encode($respon);
    }

    public function optionGetNamaProyek()
    {
        $this->fungsi->check_previleges('aluminium');
        $id_fppp  = $this->input->post('fppp');
        $get_data = $this->m_aluminium->optionGetNamaProyek($id_fppp);
        $data     = array();
        foreach ($get_data as $val) {
            $data[] = $val;
        }
        echo json_encode($data, JSON_PRETTY_PRINT);
    }
    public function optionGetNoFppp()
    {
        $this->fungsi->check_previleges('aluminium');
        $nama_proyek = $this->input->post('nama_proyek');
        $get_data    = $this->m_aluminium->optionGetNoFppp($nama_proyek);
        $data        = array();
        foreach ($get_data as $val) {
            $data[] = $val;
        }
        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function savebonmanual()
    {
        $this->fungsi->check_previleges('aluminium');
        $obj = array(
            'tgl_proses' => $this->input->post('tgl_proses'),
            'id_fppp'    => $this->input->post('id_fppp'),
            'no_form'    => $this->input->post('no_form'),
            'created'    => date('Y-m-d H:i:s'),
        );
        $cek_ada = $this->m_aluminium->getIdBon($this->input->post('id_fppp'), $this->input->post('tgl_proses'))->num_rows();
        if ($cek_ada > 0) {
            $id = $this->m_aluminium->getIdBon($this->input->post('id_fppp'), $this->input->post('tgl_proses'))->row()->id;
        } else {
            $this->m_aluminium->saveDataBon($obj);
            $id = $this->db->insert_id($obj);
        }

        $datapost = array(
            'tgl_proses'  => $this->input->post('tgl_proses'),
            'id_fppp'     => $this->input->post('id_fppp'),
            'section_ata' => $this->input->post('section_ata'),
            'qty'         => $this->input->post('qty'),
            'id_divisi'   => $this->input->post('id_divisi'),
            'id_gudang'   => $this->input->post('id_gudang'),
            'produksi'    => $this->input->post('produksi'),
            'lapangan'    => $this->input->post('lapangan'),
            'created'     => date('Y-m-d H:i:s'),
            'is_manual'   => 2,
            'id_bon'      => $id,
        );
        $this->m_aluminium->insertstokout($datapost);



        $this->fungsi->catat($datapost, "Menyimpan detail stock-in sbb:", true);
        $data['msg'] = "stock Disimpan";
        echo json_encode($data);
    }

    public function deleteItemBonManual()
    {
        $this->fungsi->check_previleges('aluminium');
        $id   = $this->input->post('id');
        $data = array('id' => $id,);
        $this->m_aluminium->deleteItemBonManual($id);
        $this->fungsi->catat($data, "Menghapus BON manual Detail dengan data sbb:", true);
        $respon = ['msg' => 'Data Berhasil Dihapus'];
        echo json_encode($respon);
    }

    public function mutasi_stock()
    {
        $this->fungsi->check_previleges('aluminium');
        $data['mutasi'] = $this->m_aluminium->getMutasi();

        $this->load->view('wrh/aluminium/v_aluminium_mutasi_stock', $data);
    }

    public function mutasi_stock_add($section_ata = '')
    {
        $this->fungsi->check_previleges('aluminium');
        $data['divisi']      = $this->db->get('master_divisi');
        $data['gudang']      = $this->db->get('master_gudang');
        $data['section_ata'] = $section_ata;
        $this->load->view('wrh/aluminium/v_aluminium_mutasi_stock_add', $data);
    }

    public function optionDivisiMutasi()
    {
        $this->fungsi->check_previleges('aluminium');
        $section_ata = $this->input->post('section_ata');
        $get_data    = $this->m_aluminium->getDivisiMutasi($section_ata);
        $data        = array();
        foreach ($get_data as $val) {
            $data[] = $val;
        }
        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function optionGudangMutasi()
    {
        $this->fungsi->check_previleges('aluminium');
        $section_ata = $this->input->post('section_ata');
        $divisi      = $this->input->post('divisi');
        $get_data    = $this->m_aluminium->getGudangMutasi($section_ata, $divisi);
        $data        = array();
        foreach ($get_data as $val) {
            $data[] = $val;
        }
        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function optionKeranjangMutasi()
    {
        $this->fungsi->check_previleges('aluminium');
        $section_ata = $this->input->post('section_ata');
        $divisi      = $this->input->post('divisi');
        $gudang      = $this->input->post('gudang');

        $get_data = $this->m_aluminium->getKeranjangMutasi($section_ata, $divisi, $gudang);
        $data     = array();
        foreach ($get_data as $val) {
            $data[] = $val;
        }
        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function optionQtyMutasi()
    {
        $this->fungsi->check_previleges('aluminium');
        $section_ata = $this->input->post('section_ata');
        $divisi      = $this->input->post('divisi');
        $gudang      = $this->input->post('gudang');
        $out         = $this->m_aluminium->getTotalDivisiGudangOut();
        $in          = $this->m_aluminium->getTotalDivisiGudangIn();
        $res_out     = @$out[$section_ata][$divisi][$gudang];
        $res_in      = @$in[$section_ata][$divisi][$gudang];
        $result      = $res_in -  $res_out;
        $data['qty']       = $result;
        echo json_encode($data);
    }

    public function simpanMutasi()
    {
        $this->fungsi->check_previleges('aluminium');
        $section_ata = $this->input->post('section_ata');
        $divisi      = $this->input->post('divisi');
        $gudang      = $this->input->post('gudang');
        $keranjang   = $this->input->post('keranjang');
        $qty         = $this->input->post('qty');

        $divisi2    = $this->input->post('divisi2');
        $gudang2    = $this->input->post('gudang2');
        $keranjang2 = $this->input->post('keranjang2');
        $qty2       = $this->input->post('qty2');

        $cek_mutasi_tempat_baru = $this->m_aluminium->cekMutasiTempatBaru($section_ata, $divisi2, $gudang2, $keranjang2)->num_rows();
        if ($cek_mutasi_tempat_baru < 1) {
            $qty_tempat_lama = $qty - $qty2;
            $arr_tempat_lama = array(
                'qty' => $qty_tempat_lama,
            );
            $this->m_aluminium->updateQtyTempatLama($section_ata, $divisi, $gudang, $keranjang, $arr_tempat_lama);
            $arr_tempat_baru = array(
                'tgl_proses'  => date('Y-m-d'),
                'section_ata' => $section_ata,
                'id_divisi'   => $divisi2,
                'id_gudang'   => $gudang2,
                'keranjang'   => $keranjang2,
                'qty'         => $qty2,
            );
            $this->db->insert('data_aluminium_in', $arr_tempat_baru);
        } else {
            $qty_tempat_pindahan = $this->m_aluminium->cekMutasiTempatBaru($section_ata, $divisi2, $gudang2, $keranjang2)->row()->qty;
            $qty_tempat_lama     = $qty - $qty2;
            $qty_tempat_baru     = $qty_tempat_pindahan + $qty2;
            $arr_tempat_lama     = array(
                'qty' => $qty_tempat_lama,
            );
            $arr_tempat_baru = array(
                'qty' => $qty_tempat_baru,
            );
            $this->m_aluminium->updateQtyTempatLama($section_ata, $divisi, $gudang, $keranjang, $arr_tempat_lama);
            $this->m_aluminium->updateQtyTempatLama($section_ata, $divisi2, $gudang2, $keranjang2, $arr_tempat_baru);
        }

        $obj = array(
            'created'     => date('Y-m-d H:i:s'),
            'section_ata' => $section_ata,
            'id_divisi'   => $divisi,
            'id_gudang'   => $gudang,
            'keranjang'   => $keranjang,
            'qty'         => $qty,
            'id_divisi2'  => $divisi2,
            'id_gudang2'  => $gudang2,
            'keranjang2'  => $keranjang2,
            'qty2'        => $qty2,
        );
        $this->db->insert('data_aluminium_mutasi', $obj);

        $data['qty'] = $qty_tempat_lama;
        echo json_encode($data);
    }

    public function mutasi_stock_history($section_ata = '')
    {
        $this->fungsi->check_previleges('aluminium');
        $data['section_ata'] = $section_ata;
        $data['mutasi']      = $this->m_aluminium->getMutasiHistory($section_ata);

        $this->load->view('wrh/aluminium/v_aluminium_mutasi_stock_history', $data);
    }

    public function suratjalan($id)
    {
        $this->fungsi->check_previleges('aluminium');
        $data['fppp']  = $this->m_aluminium->getDataFppp($id)->row();
        $no_urut = $this->m_aluminium->getNomorSj($data['fppp']->id_divisi);
        if ($data['fppp']->id_divisi == 1) {
            $div = 'RSD';
        } else if ($data['fppp']->id_divisi == 2) {
            $div = 'ASTRAL';
        } else if ($data['fppp']->id_divisi == 3) {
            $div = 'BRV';
        } else {
            $div = 'HRB';
        }

        $data['no_sj'] = str_pad($no_urut, 3, '0', STR_PAD_LEFT) . '/SEND/' . $div . '/' . date('m') . '/' . date('Y');
        $this->load->view('wrh/aluminium/v_aluminium_surat_jalan', $data);
    }

    public function simpanSj()
    {
        $no_sj         = $this->input->post('no_sj');
        $id_fppp       = $this->input->post('id_fppp');
        $id_divisi     = $this->input->post('id_divisi');
        $alamat_proyek = $this->input->post('alamat_proyek');
        $tgl_kirim     = $this->input->post('tgl_kirim');
        $sopir         = $this->input->post('sopir');
        $no_polisi     = $this->input->post('no_polisi');
        $si            = $this->input->post('si');
        $objt          = array('alamat_proyek'     => $alamat_proyek,);
        $this->m_aluminium->updateAlamatProyek($id_fppp, $objt);
        $obj = array(
            'no_sj'     => $no_sj,
            'id_fppp'   => $id_fppp,
            'id_divisi' => $id_divisi,
            'tgl_kirim' => $tgl_kirim,
            'sopir'     => $sopir,
            'no_polisi' => $no_polisi,
            'si'        => $si,
            'created'   => date('Y-m-d H:i:s'),
        );
        $this->db->insert('data_aluminium_surat_jalan', $obj);
        $data['id'] = $this->db->insert_id();
        $this->fungsi->catat($obj, "Menyimpan surat jalan sbb:", true);
        echo json_encode($data);
    }

    public function cetakSj($id)
    {
        $data = array(
            'id'     => $id,
            'header' => $this->m_aluminium->getHeaderSendCetak($id)->row(),
            'detail' => $this->m_aluminium->getDataDetailSendCetak($id)->result(),
        );
        $this->load->view('wrh/aluminium/v_aluminium_cetak_sj', $data);
    }

    public function cetakSjBon($id_fppp, $id_bon)
    {
        $data = array(
            'id'     => $id_fppp,
            'header' => $this->m_aluminium->getHeaderSendCetakBon($id_fppp, $id_bon)->row(),
            'detail' => $this->m_aluminium->getDataDetailSendCetakBon($id_fppp, $id_bon)->result(),
        );
        $this->load->view('wrh/aluminium/v_aluminium_cetak_sj_bon', $data);
    }
}

/* End of file aluminium.php */
/* Location: ./application/controllers/wrh/aluminium.php */