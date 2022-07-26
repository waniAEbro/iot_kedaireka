<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_surat_jalan extends CI_Model
{

    public function getData($tgl_awal, $tgl_akhir)
    {
        $this->db->join('data_fppp df', 'df.id = dsj.id_fppp', 'left');
        
        $this->db->where('DATE(dsj.date) >=', $tgl_awal);
        $this->db->where('DATE(dsj.date) <=', $tgl_akhir);
        $this->db->order_by('dsj.id', 'desc');
        $this->db->select('dsj.*,df.no_fppp,df.nama_proyek');
        
        return $this->db->get('data_sj_fppp dsj');
    }

    public function getlistsjproses()
    {
        $this->db->join('data_sj_fppp dsj', 'dsj.id = dsd.id_sj_fppp', 'left');
        $this->db->join('data_fppp_detail dfd', 'dfd.id = dsd.id_fppp_detail', 'left');
        $this->db->join('data_fppp df', 'df.id = dfd.id_fppp', 'left');
        $this->db->where('dsd.id_penginput', from_session('id'));
        $this->db->where('dsd.is_proses', 1);

        $this->db->select('dsd.*,df.no_fppp,df.nama_proyek');

        return $this->db->get('data_sj_fppp_detail dsd');
    }

    public function getRowDetailFppp($id)
    {
        $this->db->where('dfd.id', $id);
        $this->db->join('master_brand mb', 'mb.id = dfd.id_brand', 'left');
        $this->db->join('master_barang mbr', 'mbr.id = dfd.id_item', 'left');
        $this->db->join('master_warna mwa', 'mwa.id = dfd.finish_coating', 'left');
        $this->db->select('dfd.*,mb.brand,mbr.barang,mwa.warna');

        $hasil = $this->db->get('data_fppp_detail dfd')->row();
        return $hasil->brand . '-' . $hasil->warna . '-' . $hasil->kode_opening . '-' . $hasil->kode_unit . '-' . $hasil->barang . '-' . $hasil->glass_thick;
    }

    public function getNoSuratJalan()
    {
        $year          = date('Y');
        $month         = date('m');
        $this->db->where('DATE_FORMAT(date,"%Y")', $year);
        $this->db->where('DATE_FORMAT(date,"%m")', $month);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $hasil = $this->db->get('data_sj_fppp');
        if ($hasil->num_rows() > 0) {

            $string = $hasil->row()->no_sj;
            $arr    = explode("/", $string, 2);
            $first  = $arr[0];
            $no     = $first + 1;
            return $no;
        } else {
            return '1';
        }
    }

    public function getRowSuratJalan($id_sj)
    {
        $this->db->where('id', $id_sj);        
        return $this->db->get('data_sj_fppp');
        
    }

    public function getlistsj($id_sj)
    {
        $this->db->join('data_sj_fppp dsj', 'dsj.id = dsd.id_sj_fppp', 'left');
        $this->db->join('data_fppp_detail dfd', 'dfd.id = dsd.id_fppp_detail', 'left');
        $this->db->join('data_fppp df', 'df.id = dfd.id_fppp', 'left');
        $this->db->where('dsd.id_sj_fppp', $id_sj);
        $this->db->where('dsd.is_proses', 0);
        $this->db->select('dsd.*,df.no_fppp');

        return $this->db->get('data_sj_fppp_detail dsd');
    }

    public function getKodeDivisi($id_fppp)
    {
        $this->db->join('master_divisi md', 'md.id = df.id_divisi', 'left');
        $this->db->where('df.id', $id_fppp);
        return $this->db->get('data_fppp df')->row()->divisi_pendek;
    }

    public function getHeaderCetak($id)
    {
        $this->db->join('data_fppp df', 'df.id = dsf.id_fppp', 'left');
        
        $this->db->where('dsf.id', $id);
        $this->db->select('dsf.*,df.no_fppp,df.nama_proyek');
        
        return $this->db->get('data_sj_fppp dsf');
        
    }

    public function getDataDetailCetak($id)
    {
        $this->db->join('data_fppp_detail did', 'did.id = dsd.id_fppp_detail', 'left');
        $this->db->join('master_brand mb', 'mb.id = did.id_brand', 'left');
		$this->db->join('master_barang mi', 'mi.id = did.id_item', 'left');
		$this->db->join('master_warna mwa', 'mwa.id = did.finish_coating', 'left');
        $this->db->where('dsd.id_sj_fppp', $id);
		$this->db->select('dsd.qty as qty_out,did.*,mb.brand,mi.barang as item,mwa.warna');

        return $this->db->get('data_sj_fppp_detail dsd');
    }

    public function getTotalOut()
    {
        $res  = $this->db->get('data_sj_fppp_detail');
        $data = array();

        foreach ($res->result() as $key) {

            if (!isset($data[$key->id_sj_fppp])) {
                $data[$key->id_sj_fppp] = 0;
            }
            $data[$key->id_sj_fppp] = $data[$key->id_sj_fppp] + $key->qty;
        }
        return $data;
    }
}
