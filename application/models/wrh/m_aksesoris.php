<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_aksesoris extends CI_Model
{

    public function getdata()
    {
        $this->db->where('mi.id_jenis_item', 2);
        $this->db->select('mi.*');

        return $this->db->get('master_item mi');
    }

    public function cekStockAwalBulan()
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('awal_bulan', 1);

        return $this->db->get('data_stock');
    }

    public function getlistStock()
    {
        $this->db->join('master_divisi_stock md', 'md.id = da.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = da.id_gudang', 'left');
        $this->db->group_by('da.id_divisi');
        $this->db->group_by('da.id_gudang');
        $this->db->group_by('da.keranjang');
        $this->db->select('da.*');

        return $this->db->get('data_stock da');
    }

    public function getStockBulanSebelum($id, $id_divisi, $id_gudang, $keranjang)
    {
        $hit_tgl = date('Y-m-d', strtotime(date('Y-m-d') . '- 1 month'));

        $year = date('Y', strtotime($hit_tgl));
        $month = date('m', strtotime($hit_tgl));
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('id_divisi', $id_divisi);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->select('sum(qty_in) as stock_in');
        $this->db->where('inout', 1);
        $this->db->where('id_item', $id);
        $res_in = $this->db->get('data_stock');
        $stock_in = ($res_in->num_rows() < 1) ? 0 : $res_in->row()->stock_in;

        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('id_divisi', $id_divisi);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->select('sum(qty_out) as stock_out');
        $this->db->where('inout', 2);
        $this->db->where('id_item', $id);
        $res_out = $this->db->get('data_stock');
        $stock_out = ($res_out->num_rows() < 1) ? 0 : $res_out->row()->stock_out;

        return $stock_in - $stock_out;
    }

    public function getStockAwalBulan()
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('awal_bulan', 1);

        $res = $this->db->get('data_stock');
        $data = array();
        $nilai = 0;
        foreach ($res->result() as $key) {
            if (isset($data[$key->id_item])) {
                $nilai = $data[$key->id_item];
            } else {
                $nilai = 0;
            }
            $data[$key->id_item] = $key->qty_in + $nilai;
        }
        return $data;
    }

    public function getTotalBOM()
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);

        $res = $this->db->get('data_stock');
        $data = array();
        $nilai = 0;
        foreach ($res->result() as $key) {
            if (isset($data[$key->id_item])) {
                $nilai = $data[$key->id_item];
            } else {
                $nilai = 0;
            }
            $data[$key->id_item] = $key->qty_bom + $nilai;
        }
        return $data;
    }

    public function getTotalInPerBulan()
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('inout', 1);
        $this->db->where('awal_bulan', 0);

        $res = $this->db->get('data_stock');
        $data = array();
        $nilai = 0;
        foreach ($res->result() as $key) {
            if (isset($data[$key->id_item])) {
                $nilai = $data[$key->id_item];
            } else {
                $nilai = 0;
            }
            $data[$key->id_item] = $key->qty_in + $nilai;
        }
        return $data;
    }

    public function getTotalOutPerBulan()
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('inout', 2);

        $res = $this->db->get('data_stock');
        $data = array();
        $nilai = 0;
        foreach ($res->result() as $key) {
            if (isset($data[$key->id_item])) {
                $nilai = $data[$key->id_item];
            } else {
                $nilai = 0;
            }
            $data[$key->id_item] = $key->qty_out + $nilai;
        }
        return $data;
    }

    public function getDataDetailTabel($id_item = '')
    {
        $this->db->join('master_divisi_stock md', 'md.id = da.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = da.id_gudang', 'left');
        $this->db->where('da.inout', 1);
        $this->db->where('da.id_item', $id_item);
        $this->db->where('da.id_surat_jalan', 0);
        // $this->db->group_by('da.id_divisi');
        // $this->db->group_by('da.id_gudang');
        // $this->db->group_by('da.keranjang');
        $this->db->group_by(array('da.id_divisi', 'da.id_gudang', 'da.keranjang'));

        $this->db->select('da.*,mg.gudang,md.divisi');

        return $this->db->get('data_stock da')->result();
    }

    public function getAwalBulanDetailTabel($id, $id_divisi, $id_gudang, $keranjang)
    {
        // $hit_tgl = date('Y-m-d', strtotime(date('Y-m-d') . '- 1 month'));

        // $year = date('Y', strtotime($hit_tgl));
        // $month = date('m', strtotime($hit_tgl));
        $year = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('id_item', $id);
        $this->db->where('id_divisi', $id_divisi);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->where('awal_bulan', 1);

        $res = $this->db->get('data_stock');
        $stock = ($res->num_rows() < 1) ? 0 : $res->row()->qty_in;

        return $stock;
    }

    public function getQtyInDetailTabelMonth($id, $id_divisi, $id_gudang, $keranjang)
    {
        $year = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('id_item', $id);
        $this->db->where('id_divisi', $id_divisi);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->select('sum(qty_in) as stock_in');
        $this->db->where('inout', 1);
        $this->db->where('awal_bulan', 0);
        $res = $this->db->get('data_stock');
        $stock = ($res->num_rows() < 1) ? 0 : $res->row()->stock_in;
        return $stock;
    }
    public function getQtyInDetailTabel($id, $id_divisi, $id_gudang, $keranjang)
    {
        $year = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('id_item', $id);
        $this->db->where('id_divisi', $id_divisi);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->select('sum(qty_in) as stock_in');
        $this->db->where('inout', 1);
        $res = $this->db->get('data_stock');
        $stock = ($res->num_rows() < 1) ? 0 : $res->row()->stock_in;
        return $stock;
    }

    public function getQtyOutDetailTabel($id, $id_divisi, $id_gudang, $keranjang)
    {
        $year = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->where('id_item', $id);
        $this->db->where('id_divisi', $id_divisi);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->where('keranjang', $keranjang);
        $this->db->select('sum(qty_out) as stock_out');
        $this->db->where('inout', 2);

        $res = $this->db->get('data_stock');
        $stock = ($res->num_rows() < 1) ? 0 : $res->row()->stock_out;
        return $stock;
    }


    public function getDataStock()
    {
        $this->db->join('master_divisi_stock md', 'md.id = da.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = da.id_gudang', 'left');
        $this->db->join('master_item mi', 'mi.id = da.id_item', 'left');
        $this->db->where('da.awal_bulan', 0);
        $this->db->where('da.inout', 1);
        $this->db->where('mi.id_jenis_item', 2);

        $this->db->order_by('da.id', 'desc');

        return $this->db->get('data_stock da');
    }

    public function insertstokin($value = '')
    {
        $this->db->insert('data_stock', $value);
    }

    public function getSuratJalan($tipe, $iji)
    {
        if ($tipe == 1) {
            $this->db->join('data_fppp df', 'df.id = dsj.id_fppp', 'left');
            $this->db->select('dsj.*,df.no_fppp,df.nama_proyek,df.deadline_pengiriman,df.deadline_workshop');
        } else {
            $this->db->select('dsj.*');
        }


        $this->db->order_by('dsj.id', 'desc');
        $this->db->where('dsj.tipe', $tipe);
        $this->db->where('dsj.id_jenis_item', $iji);

        return $this->db->get('data_surat_jalan dsj');
    }

    public function getNoSuratJalan()
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(created,"%m")', $month);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $this->db->where('id_jenis_item', 2);

        $hasil = $this->db->get('data_surat_jalan');
        if ($hasil->num_rows() > 0) {

            $string = $hasil->row()->no_surat_jalan;
            $arr    = explode("/", $string, 2);
            $first  = $arr[0];
            $no     = $first + 1;
            return $no;
        } else {
            return '1';
        }
    }

    public function getRowFppp($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('data_fppp')->row();
    }

    public function getBomFppp($id_fppp)
    {
        $this->db->where('dfb.id_fppp', $id_fppp);
        $this->db->where('dfb.id_jenis_item', 2);

        return $this->db->get('data_fppp_bom dfb');
    }

    public function getRowSj($id)
    {
        return $this->db->get('data_surat_jalan');
    }

    public function getBomSJ($id_sj)
    {
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->join('master_divisi_stock mds', 'mds.id = ds.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = ds.id_gudang', 'left');

        $this->db->where('ds.id_surat_jalan', $id_sj);
        $this->db->where('ds.id_jenis_item', 2);
        $this->db->select('ds.*,ds.id as id_stock,mi.*,mds.divisi,mg.gudang');

        $this->db->order_by('ds.id', 'asc');

        return $this->db->get('data_stock ds');
    }

    public function getQtyOutFppp($id_fppp, $id_item)
    {
        $this->db->where('id_fppp', $id_fppp);
        $this->db->where('inout', 2);
        $this->db->where('id_item', $id_item);
        $this->db->select('sum(qty_out) as tot_out');

        return $this->db->get('data_stock')->row()->tot_out;
    }

    public function getQtyBOMFppp($id_fppp, $id_item)
    {
        $this->db->where('id_fppp', $id_fppp);
        $this->db->where('id_item', $id_item);

        return $this->db->get('data_fppp_bom')->row()->qty;
    }

    public function kuncidetailbom($id_detail)
    {
        $object = array('kunci' => 2,);
        $this->db->where('id', $id_detail);
        $this->db->update('data_stock', $object);
    }

    public function bukakuncidetailbom($id_detail)
    {
        $object = array('kunci' => 1,);
        $this->db->where('id', $id_detail);
        $this->db->update('data_stock', $object);
    }

    public function getListItemBonManual($id_sj)
    {
        $this->db->join('data_fppp df', 'df.id = ds.id_fppp', 'left');
        $this->db->join('master_divisi_stock mds', 'mds.id = ds.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = ds.id_gudang', 'left');
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');

        $this->db->where('ds.id_surat_jalan', $id_sj);
        $this->db->select('ds.id as id_stock,ds.*,df.no_fppp,df.nama_proyek,mds.divisi as divisi_stock,mg.gudang,mi.*');

        return $this->db->get('data_stock ds');
    }

    public function finishdetailbom($id_sj)
    {
        $object = array('kunci' => 1,);
        $this->db->where('id_surat_jalan', $id_sj);
        $this->db->update('data_stock', $object);
    }

    public function editRowOut($field = '', $value = '', $editid = '')
    {
        $this->db->query("UPDATE data_stock SET " . $field . "='" . $value . "' WHERE id=" . $editid);
    }

    public function editQtyOut($editid, $data)
    {
        $this->db->where('id', $editid);
        $this->db->update('data_stock', $data);
    }

    public function editStatusInOut($id)
    {
        $object = array('inout' => 2,);
        $this->db->where('id', $id);
        $this->db->update('data_stock', $object);
    }

    public function getGudangDivisi($id_item, $id_divisi)
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(ds.created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(ds.created,"%m")', $month);
        $this->db->where('ds.id_item', $id_item);
        $this->db->where('ds.id_divisi', $id_divisi);
        $this->db->join('master_gudang mg', 'mg.id = ds.id_gudang', 'left');
        $this->db->select('mg.*');
        $this->db->group_by('ds.id_gudang');

        return $this->db->get('data_stock ds')->result();
    }

    public function getKeranjangGudang($id_item, $id_divisi, $id_gudang)
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(ds.created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(ds.created,"%m")', $month);
        $this->db->where('ds.id_item', $id_item);
        $this->db->where('ds.id_divisi', $id_divisi);
        $this->db->where('ds.id_gudang', $id_gudang);
        $this->db->select('ds.keranjang');
        $this->db->group_by('ds.keranjang');

        return $this->db->get('data_stock ds')->result();
    }

    public function getMutasiHistory($id = '')
    {
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->join('master_divisi md', 'md.id = ds.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = ds.id_gudang', 'left');
        $this->db->where('ds.mutasi', 1);
        $this->db->where('ds.id_item', $id);
        $this->db->order_by('ds.id', 'desc');

        return $this->db->get('data_stock ds');
    }

    public function getDivisiBom()
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(ds.created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(ds.created,"%m")', $month);

        $this->db->join('master_divisi_stock mds', 'mds.id = ds.id_divisi', 'left');
        $this->db->where('mds.id_jenis_item', 2);
        $this->db->where('ds.id_surat_jalan', 0);
        $this->db->group_by('ds.id_divisi');
        $this->db->select('mds.*');
        return $this->db->get('data_stock ds');
    }

    public function getGudangBom()
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(ds.created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(ds.created,"%m")', $month);
        $this->db->join('master_gudang mg', 'mg.id = ds.id_gudang', 'left');
        $this->db->where('mg.id_jenis_item', 2);
        $this->db->where('ds.id_surat_jalan', 0);
        $this->db->group_by('ds.id_gudang');
        $this->db->select('mg.*');
        return $this->db->get('data_stock ds');
    }

    public function getKeranjangBom()
    {
        $year  = date('Y');
        $month = date('m');
        $this->db->where('DATE_FORMAT(ds.created,"%Y")', $year);
        $this->db->where('DATE_FORMAT(ds.created,"%m")', $month);
        $this->db->where('ds.id_surat_jalan', 0);
        $this->db->group_by('ds.keranjang');
        $this->db->select('ds.keranjang');
        return $this->db->get('data_stock ds');
    }

    public function getHeaderSendCetak($id)
    {
        $this->db->join('data_fppp df', 'df.id = dsj.id_fppp', 'left');
        $this->db->where('dsj.id', $id);
        $this->db->select('dsj.*,df.no_fppp,df.applicant,df.nama_proyek');

        return $this->db->get('data_surat_jalan dsj');
    }

    public function getDataDetailSendCetak($id)
    {
        $this->db->join('master_item mi', 'mi.id = ds.id_item', 'left');
        $this->db->where('ds.inout', 2);
        $this->db->where('ds.lapangan', 1);
        $this->db->where('ds.id_surat_jalan', $id);
        return $this->db->get('data_stock ds');
    }

    public function deleteItemBonManual($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('data_stock');
    }
}

/* End of file m_aksesoris.php */
/* Location: ./application/models/klg/m_aksesoris.php */