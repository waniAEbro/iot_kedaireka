<?php defined('BASEPATH') or exit('No direct script access allowed');

class Cron extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('wrh/m_aluminium');
        $this->load->model('wrh/m_aksesoris');
    }

    public function cron_stock_point()
    {
        // $this->db->where('qty <', 1);
        // $this->db->delete('data_counter');
        $this->m_aksesoris->cekAdaStockPoint(1);
        $this->m_aksesoris->cekAdaStockPoint(2);
    }
}
