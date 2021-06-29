<?php
defined('BASEPATH') or exit('No direct script access allowed');

class StockPointAksesoris extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('wrh/m_aksesoris');
        $this->load->model('klg/m_fppp');
    }

    public function coba()
    {
        echo "hallo beb";
    }

    public function save()
    {
        $tgl = date('Y-m-d');

        $aksesoris = $this->m_aksesoris->getAksesoris();
        $in = $this->m_aksesoris->getAksesorisStokIn();
        $out = $this->m_aksesoris->getAksesorisStokOut();
        $cek = $this->m_aksesoris->cekStockPoint($tgl);
        if ($cek == 1) {
            foreach ($aksesoris->result() as $key) {
                $stock_in = @$in[$key->item_code][$key->id_divisi][$key->id_gudang];
                $stock_out = @$out[$key->item_code][$key->id_divisi][$key->id_gudang];
                $real_stock = $stock_in - $stock_out;
                $data = array(
                    'tgl' => $tgl,
                    'item_code' => $key->item_code,
                    'id_divisi' => $key->id_divisi,
                    'id_gudang' => $key->id_gudang,
                    'qty' => $real_stock,
                );
                $this->m_aksesoris->saveStockPointAksesoris($data);
            }
        }

        $data['tgl'] = $tgl;
        $data['stock_point'] = $this->m_aksesoris->getStockPoint($tgl);
        $this->load->view('wrh/aksesoris/v_aksesoris_stock_point', $data);
    }
}

/* End of file stock_point.php */
/* Location: ./application/controllers/klg/stock_point.php */