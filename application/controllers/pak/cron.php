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

    public function gas($id_jenis_item, $year, $bulan_skrg, $bulan_depan)
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
        $this->db->where('id_jenis_item', $id_jenis_item);
        $this->db->where('DATE_FORMAT(aktual,"%Y")', $year);
        $this->db->where('DATE_FORMAT(aktual,"%m")', $bulan_skrg);
        // $this->db->where("aktual BETWEEN '".$tgl_awal."' and '".$tgl_akhir."'");
        $this->db->group_by('id_item, id_divisi,id_gudang,keranjang');
        $gg = $this->db->get('data_stock')->result();


        foreach ($gg as $key) {
            $this->db->where('id_item', $key->id_item);
            $this->db->where('id_divisi', $key->id_divisi);
            $this->db->where('id_gudang', $key->id_gudang);
            $this->db->where('keranjang', $key->keranjang);
            $this->db->where('awal_bulan', 1);
            $this->db->where('DATE_FORMAT(created,"%Y")', $year);
            $this->db->where('DATE_FORMAT(created,"%m")', $bulan_depan);
            $object = array('qty_in' => $key->total);
            $this->db->update('data_stock', $object);
        }

        echo "berhasil <br> menghitung transaksi bulan " . $bulan_skrg . " tahun " . $year . "<br> mengupdate awal bulan " . $bulan_depan . " tahun " . $year;
    }

    public function gas_alu($year_, $bulan_skrg, $bulan_depan, $tgl_aktual_bulan_depan)
    {

        $this->db->select('id_item,id_gudang,keranjang, sum(qty_in)-sum(qty_out) as total');
        $this->db->where('id_jenis_item', 1);
        $this->db->where('DATE_FORMAT(aktual,"%Y")', $year_);
        $this->db->where('DATE_FORMAT(aktual,"%m")', $bulan_skrg);
        $this->db->group_by('id_item,id_gudang,keranjang');
        $gg = $this->db->get('data_stock')->result();

        $awal_tgl_aktual_depan = $tgl_aktual_bulan_depan;
        $year        = $year_;
        $month       = $bulan_skrg;
        $year_depan  = $year_;
        $month_depan = $bulan_depan;
        foreach ($gg as $key) {
            $this->db->select('sum(qty_in)-sum(qty_out) as total');
            $this->db->where('DATE_FORMAT(aktual,"%Y")', $year);
            $this->db->where('DATE_FORMAT(aktual,"%m")', $month);
            $this->db->where('id_item', $key->id_item);
            $this->db->where('id_gudang', $key->id_gudang);
            $this->db->where('keranjang', $key->keranjang);
            $qty_total = $this->db->get('data_stock')->row()->total;

            $this->db->where('DATE_FORMAT(created,"%Y")', $year_depan);
            $this->db->where('DATE_FORMAT(created,"%m")', $month_depan);
            $this->db->where('awal_bulan', 1);
            $this->db->where('id_item', $key->id_item);
            $this->db->where('id_gudang', $key->id_gudang);
            $this->db->where('keranjang', $key->keranjang);
            $cek_awal_bulan_depan = $this->db->get('data_stock')->num_rows();

            if ($cek_awal_bulan_depan > 0) {
                $obj = array(
                    'id_item'   => $key->id_item,
                    'id_gudang' => $key->id_gudang,
                    'keranjang' => $key->keranjang,
                    'qty_in'    => $qty_total,
                    'updated'   => date('Y-m-d H:i:s'),
                );
                $this->db->where('awal_bulan', 1);
                $this->db->where('id_item', $key->id_item);
                $this->db->where('id_gudang', $key->id_gudang);
                $this->db->where('keranjang', $key->keranjang);
                $this->db->where('DATE_FORMAT(created,"%Y")', $year_depan);
                $this->db->where('DATE_FORMAT(created,"%m")', $month_depan);
                $this->db->update('data_stock', $obj);
            } else {
                $obj2 = array(
                    'awal_bulan'    => 1,
                    'inout'         => 1,
                    'id_jenis_item' => 1,
                    'id_item'       => $key->id_item,
                    'id_gudang' => $key->id_gudang,
                    'keranjang' => $key->keranjang,
                    'qty_in'    => $qty_total,
                    'created'   => $awal_tgl_aktual_depan,
                    'aktual'    => $awal_tgl_aktual_depan,
                );
                $this->db->insert('data_stock', $obj2);
            }

            $this->db->where('id_item', $key->id_item);
            $this->db->where('id_gudang', $key->id_gudang);
            $this->db->where('keranjang', $key->keranjang);
            $this->db->where('id_jenis_item', 1);
            $cek_counter = $this->db->get('data_counter')->num_rows();

            if ($cek_awal_bulan_depan < 1) {
                $simpan = array(
                    'id_jenis_item' => 1,
                    'id_item'       => $key->id_item,
                    'id_gudang'     => $key->id_gudang,
                    'keranjang'     => $key->keranjang,
                    'qty'           => $qty_total,
                    'created'       => date('Y-m-d H:i:s'),
                    'itm_code'      => 'xx',
                );
                $this->db->insert('data_counter', $simpan);
            }

            // $this->db->where('id_item', $key->id_item);
            // $this->db->where('id_gudang', $key->id_gudang);
            // $this->db->where('keranjang', $key->keranjang);
            // $this->db->where('awal_bulan', 1);
            // $this->db->where('DATE_FORMAT(created,"%Y")', $year);
            // $this->db->where('DATE_FORMAT(created,"%m")', $bulan_depan);
            // $object = array('qty_in' => $key->total);
            // $this->db->update('data_stock', $object);
        }

        echo "berhasil <br> menghitung transaksi bulan " . $bulan_skrg . " tahun " . $year . "<br> mengupdate awal bulan " . $bulan_depan . " tahun " . $year;
    }

    public function cekstok($item_code = '', $divisi = '', $gudang = '', $keranjang = '', $tgl = '', $update = '')
    {
        $year        = date('Y', strtotime($tgl));
        $month       = date('m', strtotime($tgl));
        $this->db->select('sum(qty_in)-sum(qty_out) as total,ds.id_item');
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->where('mi.item_code', $item_code);

        $this->db->where('DATE_FORMAT(ds.aktual,"%Y")', $year);
        $this->db->where('DATE_FORMAT(ds.aktual,"%m")', $month);
        if ($divisi != '0') {
            $this->db->where('ds.id_divisi', $divisi);
        }
        if ($gudang != '0') {
            $this->db->where('ds.id_gudang', $gudang);
        }
        $this->db->where('ds.keranjang', $keranjang);
        $dd = $this->db->get('data_stock ds')->row();
        $qty_total = $dd->total;
        $id_item = $dd->id_item;
        echo 'id_item: '.$id_item.'<br> total transaksi: ' . $qty_total . '<br>';

        if ($update == 1) {
            $tgl_depan = date('Y-m-d', strtotime('+1 month', strtotime($tgl)));
            $year_depan        = date('Y', strtotime($tgl_depan));
            $month_depan       = date('m', strtotime($tgl_depan));
            
            $this->db->where('DATE_FORMAT(aktual,"%Y")', $year_depan);
            $this->db->where('DATE_FORMAT(aktual,"%m")', $month_depan);
            $this->db->where('awal_bulan', 1);

            if ($divisi != '0') {
                $this->db->where('id_divisi', $divisi);
            }
            if ($gudang != '0') {
                $this->db->where('id_gudang', $gudang);
            }
            $this->db->where('keranjang', $keranjang);
            $this->db->where('id_item', $id_item);
            $object = array('qty_in' => $qty_total);
            $this->db->update('data_stock', $object);
            echo 'berhasil update awal bulan : '.$tgl_depan;
        }
    }


    public function awal_bulan($id_jenis_item)
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('awal_bulan', 1);
        $this->db->where('id_jenis_item', $id_jenis_item);
        $cek_stock_awal_bulan = $this->db->get('data_stock')->num_rows();

        $this->db->where('id_jenis_item', $id_jenis_item);        
		$item = $this->db->get('data_counter');

		if ($cek_stock_awal_bulan < 1) {
			foreach ($item->result() as $key) {
				$obj = array(
					'awal_bulan' => 1,
					'inout' => 1,
					'id_item' => $key->id_item,
					'id_divisi' => $key->id_divisi,
					'id_gudang' => $key->id_gudang,
					'keranjang' => $key->keranjang,
					'id_jenis_item' => $key->id_jenis_item,
					'qty_in' => $key->qty,
					'created' => date('Y-m-d H:i:s'),
					'aktual' => date('Y-m-d')
				);
				$this->db->insert('data_stock', $obj);
			}
		}
    }
}
