<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verif_tolak  extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('klg/m_retur');
        $this->load->model('klg/m_invoice');
    }
    function verifikasi($id,$status=2)
    {
        $getRow = $this->m_retur->getRowretur($id);
        $getDetail = $this->m_retur->getDetailretur($id);

        $id_jenis_retur = $getRow->id_jenis_retur;

        if ($id_jenis_retur == 1) {
            $datapermintaan = array(
                'id_brand'       => 1,  
                'no_invoice'     => $getRow->no_retur, 
                'no_po'          => '',
                'project_owner'  => '',
                'id_store'       => $getRow->id_store, 
                'alamat_proyek'  => '', 
                'no_telp'        => '', 
                'tgl_pengiriman' => date('Y-m-d'),
                'date' => date('Y-m-d H:i:s'),
                'timestamp' => date('Y-m-d H:i:s'),
                'lampiran'       => '',         
                'is_retur'       => '2',
                'id_retur'    => $id,       
                );
            $this->m_invoice->insertInvoice($datapermintaan);
            $id_permintaan = $this->db->insert_id();
            foreach ($getDetail->result() as $row) {
                $datadetailpermintaan = array(
                    'id_invoice' => $id_permintaan, 
                    'id_tipe'    => $row->id_tipe_baru, 
                    'id_item'    => $row->id_item_baru,
                    'id_warna'   => $row->id_warna_baru,
                    'bukaan'     => $row->bukaan_baru,
                    'lebar'      => $row->lebar_baru,
                    'tinggi'     => $row->tinggi_baru,
                    'qty'        => $row->qty_baru,
                    'keterangan' => 'RETUR', 
                    'harga'      => '', 
                    'date'       => date('Y-m-d'), 
                );
                $this->m_invoice->insertInvoiceDetail($datadetailpermintaan);

                $datastok = array(
                    'id_produksi' => $this->m_retur->getMaxProduksi(),
                    'id_retur'    => $id,
                    'id_tipe'     => $row->id_tipe, 
                    'id_item'     => $row->id_item,
                    'id_warna'    => $row->id_warna,
                    'bukaan'      => $row->bukaan,
                    'lebar'       => $row->lebar,
                    'tinggi'      => $row->tinggi,
                    'qty'         => $row->qty,
                    'keterangan'  => 'retur pengganti',
                    'inout'       => 1,
                    'is_retur'    => 2,
                );
                $this->m_retur->insertStok($datastok);

                $datawareout = array(
                    'id_store'    => $getRow->id_store,
                    'id_tipe'     => $row->id_tipe, 
                    'id_item'     => $row->id_item,
                    'id_warna'    => $row->id_warna,
                    'bukaan'      => $row->bukaan,
                    'lebar'       => $row->lebar,
                    'tinggi'      => $row->tinggi,
                    'qty_out'     => $row->qty,
                );
                $this->m_retur->insertStokWarehouse($datawareout);
                
            }

        }elseif($id_jenis_retur == 2 || $id_jenis_retur == 4) {
            foreach ($getDetail->result() as $row) {
                $datastok = array(
                        'id_produksi' => $this->m_retur->getMaxProduksi(),
                        'id_retur'    => $id,
                        'id_tipe'     => $row->id_tipe, 
                        'id_item'     => $row->id_item,
                        'id_warna'    => $row->id_warna,
                        'bukaan'      => $row->bukaan,
                        'lebar'       => $row->lebar,
                        'tinggi'      => $row->tinggi,
                        'qty'         => $row->qty,
                        'keterangan'  => 'retur repair',
                        'inout'       => 1,
                        'is_retur'    => 2,
                );
                $this->m_retur->insertStok($datastok);
                if ($id_jenis_retur == 2) {
                $datawareout = array(
                    'id_store'    => $getRow->id_store,
                    'id_tipe'     => $row->id_tipe, 
                    'id_item'     => $row->id_item,
                    'id_warna'    => $row->id_warna,
                    'bukaan'      => $row->bukaan,
                    'lebar'       => $row->lebar,
                    'tinggi'      => $row->tinggi,
                    'qty_out'     => $row->qty,
                );
                $this->m_retur->insertStokWarehouse($datawareout);
                }
            }
        }else {
            foreach ($getDetail->result() as $row) {
                $datastok = array(
                        'id_produksi' => $this->m_retur->getMaxProduksi(),
                        'id_retur'    => $id,
                        'id_tipe'     => $row->id_tipe_baru, 
                        'id_item'     => $row->id_item_baru,
                        'id_warna'    => $row->id_warna_baru,
                        'bukaan'      => $row->bukaan_baru,
                        'lebar'       => $row->lebar_baru,
                        'tinggi'      => $row->tinggi_baru,
                        'qty'         => $row->qty_baru,
                        'keterangan'  => 'retur kanibal',
                        'inout'       => 1,
                        'is_retur'    => 2,
                );
                $this->m_retur->insertStok($datastok);

                $datawareout = array(
                    'id_store'    => $getRow->id_store,
                    'id_tipe'     => $row->id_tipe, 
                    'id_item'     => $row->id_item,
                    'id_warna'    => $row->id_warna,
                    'bukaan'      => $row->bukaan,
                    'lebar'       => $row->lebar,
                    'tinggi'      => $row->tinggi,
                    'qty_out'     => $row->qty,
                );
                $this->m_retur->insertStokWarehouse($datawareout);
            }
        }
        $this->m_retur->editVerifikasi($id,$status);
        echo "Sukses menyetujui Retur";
    }
    function tolak($id,$status=1)
    {
        $this->m_retur->editVerifikasi($id,$status);
        echo "Sukses menolak Retur";
    }
    


}