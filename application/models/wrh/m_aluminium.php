<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_aluminium extends CI_Model
{

    public function getdata()
    {
        $this->db->where('id_jenis_item', 1);
        return $this->db->get('master_item');
    }

    public function getDataDetailTabel($section_ata = '')
    {
        $this->db->join('master_divisi_stock md', 'md.id = dai.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = dai.id_gudang', 'left');

        $this->db->join('master_item da', 'da.section_ata = dai.section_ata', 'left');
        $this->db->where('dai.section_ata', $section_ata);
        $this->db->select('dai.*,md.divisi,mg.gudang');
        $this->db->group_by('dai.section_ata');
        $this->db->group_by('dai.id_divisi');
        $this->db->group_by('dai.keranjang');

        return $this->db->get('data_aluminium_in dai')->result();;
    }

    public function getTotalDivisiGudangAwalBulan()
    {
        // $this->db->where('MONTH(tgl_proses)', date('m'));
        $res = $this->db->get('data_aluminium_awal_bulan');
        $data = array();
        $nilai = 0;
        foreach ($res->result() as $key) {
            if (isset($data[$key->section_ata][$key->id_divisi][$key->id_gudang][$key->keranjang])) {
                $nilai = $data[$key->section_ata][$key->id_divisi][$key->id_gudang][$key->keranjang];
            } else {
                $nilai = 0;
            }
            $data[$key->section_ata][$key->id_divisi][$key->id_gudang][$key->keranjang] = $key->qty + $nilai;
        }
        return $data;
    }

    public function getTotalDivisiGudangRata()
    {
        // $this->db->where('MONTH(tgl_proses)', date('m'));
        $res = $this->db->get('data_aluminium_awal_bulan');
        $data = array();
        $nilai = 0;
        foreach ($res->result() as $key) {
            if (isset($data[$key->section_ata][$key->id_divisi][$key->id_gudang][$key->keranjang])) {
                $nilai = $data[$key->section_ata][$key->id_divisi][$key->id_gudang][$key->keranjang];
            } else {
                $nilai = 0;
            }
            $data[$key->section_ata][$key->id_divisi][$key->id_gudang][$key->keranjang] = $key->rata_rata + $nilai;
        }
        return $data;
    }

    public function getTotalDivisiGudangMinStock()
    {
        // $this->db->where('MONTH(tgl_proses)', date('m'));
        $res = $this->db->get('data_aluminium_awal_bulan');
        $data = array();
        $nilai = 0;
        foreach ($res->result() as $key) {
            if (isset($data[$key->section_ata][$key->id_divisi][$key->id_gudang][$key->keranjang])) {
                $nilai = $data[$key->section_ata][$key->id_divisi][$key->id_gudang][$key->keranjang];
            } else {
                $nilai = 0;
            }
            $data[$key->section_ata][$key->id_divisi][$key->id_gudang][$key->keranjang] = $key->min_stock + $nilai;
        }
        return $data;
    }

    public function getTotalDivisiGudangIn()
    {
        // $this->db->where('MONTH(tgl_proses)', date('m'));
        $res = $this->db->get('data_aluminium_in');
        $data = array();
        $nilai = 0;
        foreach ($res->result() as $key) {
            if (isset($data[$key->section_ata][$key->id_divisi][$key->id_gudang])) {
                $nilai = $data[$key->section_ata][$key->id_divisi][$key->id_gudang];
            } else {
                $nilai = 0;
            }
            $data[$key->section_ata][$key->id_divisi][$key->id_gudang] = $key->qty + $nilai;
        }
        return $data;
    }

    public function getTotalDivisiGudangOut()
    {
        // $this->db->where('MONTH(tgl_proses)', date('m'));
        $res = $this->db->get('data_aluminium_out');
        $data = array();
        $nilai = 0;
        foreach ($res->result() as $key) {
            if (isset($data[$key->section_ata][$key->id_divisi][$key->id_gudang])) {
                $nilai = $data[$key->section_ata][$key->id_divisi][$key->id_gudang];
            } else {
                $nilai = 0;
            }
            $data[$key->section_ata][$key->id_divisi][$key->id_gudang] = $key->qty + $nilai;
        }
        return $data;
    }



    public function getTotalItemFpppOut()
    {
        // $this->db->where('MONTH(tgl_proses)', date('m'));
        $res = $this->db->get('data_aluminium_out');
        $data = array();
        $nilai = 0;
        foreach ($res->result() as $key) {
            if (isset($data[$key->section_ata][$key->id_fppp])) {
                $nilai = $data[$key->section_ata][$key->id_fppp];
            } else {
                $nilai = 0;
            }
            $data[$key->section_ata][$key->id_fppp] = $key->qty + $nilai;
        }
        return $data;
    }

    public function getDataStock()
    {
        $this->db->join('master_divisi md', 'md.id = dai.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = dai.id_gudang', 'left');
        $this->db->select('dai.*,md.divisi,mg.gudang');
        $this->db->order_by('dai.id', 'desc');

        return $this->db->get('data_aluminium_in dai');
    }

    public function insertstokin($value = '')
    {
        $this->db->insert('data_aluminium_in', $value);
    }
    public function insertstokout($value = '')
    {
        $this->db->insert('data_aluminium_out', $value);
    }

    public function cekQtyIn($section_ata, $gudang, $keranjang)
    {
        $this->db->where('section_ata', $section_ata);
        $this->db->where('id_gudang', $gudang);
        $this->db->where('keranjang', $keranjang);
        return $this->db->get('data_aluminium_in');
    }

    public function updatestokin($datapost, $qty)
    {
        $object = array('qty' => $qty);
        $this->db->where('section_ata', $datapost['section_ata']);
        $this->db->where('id_gudang', $datapost['id_gudang']);
        $this->db->where('keranjang', $datapost['keranjang']);
        $this->db->update('data_aluminium_in', $object);
    }

    public function getRowFppp($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('data_fppp')->row();
    }

    public function getRowaluminiumOut($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('data_aluminium_out')->row();
    }

    public function cek_fppp_out($id)
    {
        $this->db->where('id_fppp', $id);
        return $this->db->get('data_aluminium_out')->num_rows();
    }

    public function getBomaluminium($id)
    {
        $this->db->join('master_item mi', 'mi.section_ata = dao.section_ata', 'left');
        $this->db->join('master_divisi_stock md', 'md.id = dao.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = dao.id_gudang', 'left');
        $this->db->where('dao.id_fppp', $id);
        $this->db->where('dao.is_manual', 1);
        $this->db->select('dao.*,mi.deskripsi,md.divisi,mg.gudang');
        $this->db->order_by('dao.section_ata', 'asc');

        return $this->db->get('data_aluminium_out dao');
    }

    public function editRowOut($field = '', $value = '', $editid = '')
    {
        $this->db->query("UPDATE data_aluminium_out SET " . $field . "='" . $value . "' WHERE id=" . $editid);
    }

    public function getTotalIn()
    {
        $res = $this->db->get('data_aluminium_in');
        $data = array();
        $nilai = 0;
        foreach ($res->result() as $key) {
            if (isset($data[$key->section_ata])) {
                $nilai = $data[$key->section_ata];
            } else {
                $nilai = 0;
            }
            $data[$key->section_ata] = $key->qty + $nilai;
        }
        return $data;
    }

    public function getTotalOut()
    {
        // $this->db->where('MONTH(tgl_proses)', date('m'));
        $res = $this->db->get('data_aluminium_out');
        $data = array();
        $nilai = 0;
        foreach ($res->result() as $key) {
            if (isset($data[$key->section_ata])) {
                $nilai = $data[$key->section_ata];
            } else {
                $nilai = 0;
            }
            $data[$key->section_ata] = $key->qty + $nilai;
        }
        return $data;
    }

    public function getTotalBom()
    {
        // $this->db->where('MONTH(tgl_proses)', date('m'));
        $this->db->join('data_fppp df', 'df.id = dfb.id_fppp', 'left');
        $this->db->where('df.id_status !=', 3);

        $res = $this->db->get('data_fppp_bom_aluminium dfb');
        $data = array();
        $nilai = 0;
        foreach ($res->result() as $key) {
            if (isset($data[$key->section_ata])) {
                $nilai = $data[$key->section_ata];
            } else {
                $nilai = 0;
            }
            $data[$key->section_ata] = $key->qty + $nilai;
        }
        return $data;
    }

    public function getBonManual()
    {
        $this->db->join('data_fppp df', 'df.id = dbo.id_fppp', 'left');
        $this->db->select('dbo.*,df.no_fppp,df.nama_proyek');

        return $this->db->get('data_aluminium_bon_out dbo');
    }

    public function getBomaluminiumManual($id_bon)
    {
        $this->db->join('master_divisi md', 'md.id = dao.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = dao.id_gudang', 'left');
        $this->db->join('master_item mi', 'mi.section_ata = dao.section_ata', 'left');
        $this->db->join('data_fppp df', 'df.id = dao.id_fppp', 'left');

        $this->db->where('dao.is_manual', 2);
        $this->db->where('id_bon', $id_bon);

        $this->db->select('dao.*,mi.deskripsi,md.divisi,mg.gudang,df.no_fppp,df.nama_proyek');
        return $this->db->get('data_aluminium_out dao')->result();
    }

    public function optionGetSectionAllure($section_ata = '')
    {
        $this->db->where('section_ata', $section_ata);
        return $this->db->get('master_item')->result();
    }

    public function optionGetSectionAta($section_allure = '')
    {
        $this->db->where('section_allure', $section_allure);
        return $this->db->get('master_item')->result();
    }

    public function optionGetSectionTemper($section_ata = '', $section_allure = '')
    {
        $this->db->where('section_ata', $section_ata);
        $this->db->where('section_allure', $section_allure);
        return $this->db->get('master_item')->result();
    }

    public function optionGetKodeWarna($section_ata = '', $section_allure = '', $temper = '')
    {
        $this->db->where('section_ata', $section_ata);
        $this->db->where('section_allure', $section_allure);
        $this->db->where('temper', $temper);
        return $this->db->get('master_item')->result();
    }

    public function optionGetUkuran($section_ata = '', $section_allure = '', $temper = '', $kode_warna = '')
    {
        $this->db->where('section_ata', $section_ata);
        $this->db->where('section_allure', $section_allure);
        $this->db->where('temper', $temper);
        $this->db->where('kode_warna', $kode_warna);
        return $this->db->get('master_item')->result();
    }

    public function optionGetNamaProyek($id_fppp = '')
    {
        $this->db->where('id', $id_fppp);
        $this->db->group_by('nama_proyek');
        return $this->db->get('data_fppp')->result();
    }

    public function optionGetNoFppp($nama_proyek = '')
    {
        $this->db->where('nama_proyek', $nama_proyek);
        return $this->db->get('data_fppp')->result();
    }

    public function deleteItemBonManual($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('data_aluminium_out');
    }

    public function getMutasi()
    {
        $this->db->join('master_divisi md', 'md.id = dao.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = dao.id_gudang', 'left');
        $this->db->join('master_item mi', 'mi.section_ata = dao.section_ata', 'left');
        $this->db->select('dao.*,mi.deskripsi,md.divisi,mg.gudang');
        $this->db->order_by('dao.id', 'desc');

        return $this->db->get('data_aluminium_in dao');
    }

    public function getDivisiMutasi($section_ata)
    {
        $this->db->where('dao.section_ata', $section_ata);
        $this->db->join('master_divisi md', 'md.id = dao.id_divisi', 'left');
        $this->db->select('md.*');
        $this->db->group_by('dao.id_divisi');
        return $this->db->get('data_aluminium_in dao')->result();
    }

    public function getGudangMutasi($section_ata, $divisi)
    {
        $this->db->where('dao.section_ata', $section_ata);
        $this->db->where('dao.id_divisi', $divisi);
        $this->db->join('master_gudang mg', 'mg.id = dao.id_gudang', 'left');
        $this->db->select('mg.*');
        $this->db->group_by('dao.id_gudang');
        return $this->db->get('data_aluminium_in dao')->result();
    }

    public function getKeranjangMutasi($section_ata, $divisi, $gudang)
    {
        $this->db->where('dao.section_ata', $section_ata);
        $this->db->where('dao.id_divisi', $divisi);
        $this->db->where('dao.id_gudang', $gudang);
        $this->db->select('dao.keranjang');
        return $this->db->get('data_aluminium_in dao')->result();
    }

    public function getQtyMutasi($section_ata, $divisi, $gudang, $keranjang)
    {
        $this->db->where('dao.section_ata', $section_ata);
        $this->db->where('dao.id_divisi', $divisi);
        $this->db->where('dao.id_gudang', $gudang);
        $this->db->where('dao.keranjang', $keranjang);
        return $this->db->get('data_aluminium_in dao')->row()->qty;
    }

    public function cekMutasiTempatBaru($section_ata, $divisi, $gudang, $keranjang)
    {
        $this->db->where('dao.section_ata', $section_ata);
        $this->db->where('dao.id_divisi', $divisi);
        $this->db->where('dao.id_gudang', $gudang);
        $this->db->where('dao.keranjang', $keranjang);
        return $this->db->get('data_aluminium_in dao');
    }

    public function updateQtyTempatLama($section_ata, $divisi, $gudang, $keranjang, $obj)
    {
        $this->db->where('dao.section_ata', $section_ata);
        $this->db->where('dao.id_divisi', $divisi);
        $this->db->where('dao.id_gudang', $gudang);
        $this->db->where('dao.keranjang', $keranjang);
        $this->db->update('data_aluminium_in dao', $obj);
    }

    public function getMutasiHistory($section_ata = '')
    {
        $this->db->join('master_divisi md', 'md.id = dao.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = dao.id_gudang', 'left');
        $this->db->join('master_item mi', 'mi.section_ata = dao.section_ata', 'left');

        $this->db->join('master_divisi md2', 'md2.id = dao.id_divisi2', 'left');
        $this->db->join('master_gudang mg2', 'mg2.id = dao.id_gudang2', 'left');
        $this->db->where('dao.section_ata', $section_ata);

        $this->db->select('dao.*,mi.deskripsi,md.divisi,mg.gudang,md2.divisi as divisi2,mg2.gudang as gudang2');
        $this->db->order_by('dao.id', 'desc');

        return $this->db->get('data_aluminium_mutasi dao');
    }

    public function getQtyGudang($section_ata, $id_divisi, $id_gudang)
    {
        $this->db->where('section_ata', $section_ata);
        $this->db->where('id_divisi', $id_divisi);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->select('sum(qty) as qty_gudang');
        return $this->db->get('data_aluminium_in')->row()->qty_gudang;
    }

    public function kunciStockOut($id)
    {
        $object = array('kunci' => 2);
        $this->db->where('id', $id);
        $this->db->update('data_aluminium_out', $object);
        $obj = array('wh_aluminium' => 2);
        $this->db->where('id', $id);
        $this->db->update('data_fppp', $obj);
    }

    public function bukakunciStockOut($id)
    {
        $object = array('kunci' => 1);
        $this->db->where('id', $id);
        $this->db->update('data_aluminium_out', $object);
    }

    public function finishStockOut($id)
    {
        $object = array('kunci' => 2);
        $this->db->where('id_fppp', $id);
        $this->db->where('is_manual', 1);
        $this->db->update('data_aluminium_out', $object);
        $obj = array('wh_aluminium' => 3);
        $this->db->where('id', $id);
        $this->db->update('data_fppp', $obj);
    }

    public function getfpppaluminium()
    {
        $this->db->join('data_fppp df', 'df.id = dfb.id_fppp', 'left');
        $this->db->join('data_aluminium_surat_jalan dsj', 'dsj.id_fppp = dfb.id_fppp', 'left');
        $this->db->group_by('dfb.id_fppp');
        $this->db->select('df.*,dsj.no_sj');

        return $this->db->get('data_fppp_bom_aluminium dfb');
    }

    public function getDataFppp($id_fppp)
    {
        $this->db->join('master_divisi md', 'md.id = df.id_divisi', 'left');
        $this->db->where('df.id', $id_fppp);
        $this->db->select('df.*,md.divisi');

        return $this->db->get('data_fppp df');
    }

    public function getNomorSj($id_divisi)
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('id_divisi', $id_divisi);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $hasil = $this->db->get('data_aluminium_surat_jalan');
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

    public function getHeaderSendCetak($id)
    {
        $this->db->join('data_fppp df', 'df.id = dsj.id_fppp', 'left');
        $this->db->join('master_divisi md', 'md.id = df.id_divisi', 'left');
        $this->db->where('dsj.id_fppp', $id);
        return $this->db->get('data_aluminium_surat_jalan dsj');
    }

    public function getDataDetailSendCetak($id)
    {
        $this->db->join('data_fppp df', 'df.id = dao.id_fppp', 'left');
        $this->db->join('master_divisi md', 'md.id = df.id_divisi', 'left');
        $this->db->join('master_item mi', 'mi.section_ata = dao.section_ata', 'left');

        $this->db->where('dao.lapangan', 1);
        $this->db->select('mi.*,dao.qty,df.*,md.divisi');
        $this->db->where('dao.id_fppp', $id);

        return $this->db->get('data_aluminium_out dao');
    }
    public function getHeaderSendCetakBon($id, $id_bon)
    {
        $this->db->join('data_fppp df', 'df.id = dbo.id_fppp', 'left');
        $this->db->join('master_divisi md', 'md.id = df.id_divisi', 'left');
        $this->db->where('dbo.id_fppp', $id);
        $this->db->where('dbo.id', $id_bon);
        return $this->db->get('data_aluminium_bon_out dbo');
    }

    public function getDataDetailSendCetakBon($id, $id_bon)
    {
        $this->db->join('data_fppp df', 'df.id = dao.id_fppp', 'left');
        $this->db->join('master_divisi md', 'md.id = df.id_divisi', 'left');
        $this->db->join('master_item mi', 'mi.section_ata = dao.section_ata', 'left');

        $this->db->where('dao.lapangan', 1);
        $this->db->select('mi.*,dao.qty,df.*,md.divisi');
        $this->db->where('dao.id_fppp', $id);
        $this->db->where('dao.id_bon', $id_bon);

        return $this->db->get('data_aluminium_out dao');
    }
    public function updateAlamatProyek($id_fppp, $data)
    {
        $this->db->where('id', $id_fppp);
        $this->db->update('data_fppp', $data);
    }
    public function getNamaProyekList()
    {
        $this->db->group_by('nama_proyek');
        return $this->db->get('data_fppp');
    }

    public function getNoFormBon()
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $hasil = $this->db->get('data_aluminium_bon_out');
        if ($hasil->num_rows() > 0) {

            $string = $hasil->row()->no_form;
            $arr    = explode("/", $string, 2);
            $first  = $arr[0];
            $no     = $first + 1;
            return $no;
        } else {
            return '1';
        }
    }

    public function getIdBon($id_fppp, $tgl_proses)
    {
        $this->db->where('id_fppp', $id_fppp);
        $this->db->where('tgl_proses', $tgl_proses);
        return $this->db->get('data_aluminium_bon_out');
    }

    public function saveDataBon($object)
    {
        $this->db->insert('data_aluminium_bon_out', $object);
    }
}

/* End of file m_aluminium.php */
/* Location: ./application/models/klg/m_aluminium.php */