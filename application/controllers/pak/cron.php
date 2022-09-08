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
        // $this->m_aksesoris->cekAdaStockPoint(1);
        // $this->m_aksesoris->cekAdaStockPoint(2);
    }

    public function gas()
    {
        // 		SELECT
		// 	id_item, id_divisi,id_gudang,keranjang, sum(qty_in)-sum(qty_out) as total
		// FROM
		// 	data_stock 
		// WHERE
		// 	created BETWEEN '2021/10/01' and '2021/11/01'
		// 	AND id_jenis_item =2
		// 	GROUP BY id_item, id_divisi,id_gudang,keranjang

		// select * from data_stock where awal_bulan=1 and created BETWEEN '2021/11/01' and '2021/11/02' 
		// and id_jenis_item=2 ORDER BY id_item, id_divisi,id_gudang,keranjang

        $this->db->select('id_item, id_divisi,id_gudang,keranjang, sum(qty_in)-sum(qty_out) as total');
		$this->db->where('id_jenis_item', 2);
		$this->db->where("created BETWEEN '2022/07/01' and '2022/08/01'");
		$this->db->group_by('id_item, id_divisi,id_gudang,keranjang');
		$gg = $this->db->get('data_stock')->result();
		foreach ($gg as $key ) {
            $this->db->where('id_item', $key->id_item);
            $this->db->where('id_divisi', $key->id_divisi);
            $this->db->where('id_gudang', $key->id_gudang);
            $this->db->where('keranjang', $key->keranjang);
            $this->db->where('awal_bulan', 1);
            $this->db->where("created BETWEEN '2022/08/01' and '2022/08/29'");
            $object = array('qty_in'=>$key->total);
            $this->db->update('data_stock', $object);
            
            
        }

        echo "berhasil";
    }

    public function gas_alu()
    {
        
        $this->db->select('id_item,id_gudang,keranjang, sum(qty_in)-sum(qty_out) as total');
		$this->db->where('id_jenis_item', 1);
		$this->db->where("created BETWEEN '2022/07/01' and '2022/08/01'");
		$this->db->group_by('id_item,id_gudang,keranjang');
		$gg = $this->db->get('data_stock')->result();
		foreach ($gg as $key ) {
            $this->db->where('id_item', $key->id_item);
            $this->db->where('id_gudang', $key->id_gudang);
            $this->db->where('keranjang', $key->keranjang);
            $this->db->where('awal_bulan', 1);
            $this->db->where("created BETWEEN '2022/08/01' and '2022/08/29'");
            $object = array('qty_in'=>$key->total);
            $this->db->update('data_stock', $object);
            
            
        }

        echo "berhasil";
    }
}
