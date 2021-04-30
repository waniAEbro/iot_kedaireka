<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_aksesoris extends CI_Model
{

    public function getdata()
    {
        $this->db->where('id_jenis_item', 2);
        return $this->db->get('master_item');
    }

    // public function insertaksesoris($value = '')
    // {
    //     $this->db->insert('data_aksesoris', $value);
    // }

    // public function insertaksesorisDetail($value = '')
    // {
    //     $this->db->insert('data_aksesoris_detail', $value);
    // }

    // public function deleteDetailItem($value = '')
    // {
    //     $this->db->where('id', $value);
    //     $this->db->delete('data_aksesoris_detail');
    // }

    public function getDataDetailTabel($item_code = '')
    {
        // $this->db->join('data_aksesoris da', 'da.id = dad.id_aksesoris', 'left');
        // $this->db->where('dad.id_aksesoris', $id);
        // $this->db->select('dad.*');
        // return $this->db->get('data_aksesoris_detail dad')->result();
        $this->db->join('master_divisi md', 'md.id = dai.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = dai.id_gudang', 'left');

        $this->db->join('master_item da', 'da.item_code = dai.item_code', 'left');
        $this->db->where('dai.item_code', $item_code);
        $this->db->select('dai.*,md.divisi,mg.gudang');
        // $this->db->group_by('dai.item_code');
        return $this->db->get('data_aksesoris_in dai')->result();;
    }

    public function getDataStock()
    {
        $this->db->join('master_divisi md', 'md.id = dai.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = dai.id_gudang', 'left');
        $this->db->select('dai.*,md.divisi,mg.gudang');
        $this->db->order_by('dai.id', 'desc');

        return $this->db->get('data_aksesoris_in_history dai');
    }

    public function insertstokin($value = '')
    {
        $this->db->insert('data_aksesoris_in', $value);
    }

    public function insertstokinhistory($value = '')
    {
        $this->db->insert('data_aksesoris_in_history', $value);
    }
    public function insertstokout($value = '')
    {
        $this->db->insert('data_aksesoris_out', $value);
    }

    public function getTotout($item_code)
    {
        $this->db->where('item_code', $item_code);
        $this->db->select('sum(qty) as tot_out');
        return $this->db->get('data_aksesoris_out')->row()->tot_out;
    }

    public function cekQtyIn($item_code, $gudang, $keranjang)
    {
        $this->db->where('item_code', $item_code);
        $this->db->where('id_gudang', $gudang);
        $this->db->where('keranjang', $keranjang);
        return $this->db->get('data_aksesoris_in');
    }

    public function updatestokin($datapost, $qty)
    {
        $object = array('qty' => $qty);
        $this->db->where('item_code', $datapost['item_code']);
        $this->db->where('id_gudang', $datapost['id_gudang']);
        $this->db->where('keranjang', $datapost['keranjang']);
        $this->db->update('data_aksesoris_in', $object);
    }

    public function getRowFppp($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('data_fppp')->row();
    }

    public function getRowAksesorisOut($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('data_aksesoris_out')->row();
    }

    public function cek_fppp_out($id)
    {
        $this->db->where('id_fppp', $id);
        return $this->db->get('data_aksesoris_out')->num_rows();
    }

    public function getBomAksesoris($id)
    {
        $this->db->join('master_item mi', 'mi.item_code = dao.item_code', 'left');
        $this->db->join('master_divisi md', 'md.id = dao.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = dao.id_gudang', 'left');
        $this->db->where('dao.id_fppp', $id);
        $this->db->where('dao.is_manual', 1);
        $this->db->select('dao.*,mi.deskripsi,md.divisi,mg.gudang');
        $this->db->order_by('dao.item_code', 'asc');

        return $this->db->get('data_aksesoris_out dao');
    }

    public function editRowOut($field = '', $value = '', $editid = '')
    {
        $this->db->query("UPDATE data_aksesoris_out SET " . $field . "='" . $value . "' WHERE id=" . $editid);
    }

    public function getTotalIn()
    {
        $this->db->where('MONTH(tgl_proses)', date('m'));
        $res = $this->db->get('data_aksesoris_in');
        $data = array();
        $nilai = 0;
        foreach ($res->result() as $key) {
            if (isset($data[$key->item_code])) {
                $nilai = $data[$key->item_code];
            } else {
                $nilai = 0;
            }
            $data[$key->item_code] = $key->qty + $nilai;
        }
        return $data;
    }

    public function getTotalOut()
    {
        $this->db->where('MONTH(tgl_proses)', date('m'));
        $res = $this->db->get('data_aksesoris_out');
        $data = array();
        $nilai = 0;
        foreach ($res->result() as $key) {
            if (isset($data[$key->item_code])) {
                $nilai = $data[$key->item_code];
            } else {
                $nilai = 0;
            }
            $data[$key->item_code] = $key->qty + $nilai;
        }
        return $data;
    }

    public function getTotalBom()
    {
        // $this->db->where('MONTH(tgl_proses)', date('m'));
        $this->db->join('data_fppp df', 'df.id = dfb.id_fppp', 'left');
        $this->db->where('df.id_status !=', 3);

        $res = $this->db->get('data_fppp_bom_aksesoris dfb');
        $data = array();
        $nilai = 0;
        foreach ($res->result() as $key) {
            if (isset($data[$key->item_code])) {
                $nilai = $data[$key->item_code];
            } else {
                $nilai = 0;
            }
            $data[$key->item_code] = $key->qty + $nilai;
        }
        return $data;
    }

    public function getBomAksesorisManual()
    {
        $this->db->join('master_divisi md', 'md.id = dao.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = dao.id_gudang', 'left');
        $this->db->join('master_item mi', 'mi.item_code = dao.item_code', 'left');
        $this->db->join('data_fppp df', 'df.id = dao.id_fppp', 'left');

        $this->db->where('dao.is_manual', 2);
        $this->db->select('dao.*,mi.deskripsi,md.divisi,mg.gudang,df.no_fppp,df.nama_proyek');
        return $this->db->get('data_aksesoris_out dao');
    }

    public function getOptionAksesoris($id_fppp = '')
    {
        $this->db->where('id_fppp', $id_fppp);
        // $this->db->group_by(array('kode_item', 'kode_tipe'));
        $this->db->group_by('item_code');
        return $this->db->get('data_fppp_bom_aksesoris')->result();
    }

    public function deleteItemBonManual($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('data_aksesoris_out');
    }

    public function getMutasi()
    {
        $this->db->join('master_divisi md', 'md.id = dao.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = dao.id_gudang', 'left');
        $this->db->join('master_item mi', 'mi.item_code = dao.item_code', 'left');
        $this->db->select('dao.*,mi.deskripsi,md.divisi,mg.gudang');
        $this->db->order_by('dao.id', 'desc');

        return $this->db->get('data_aksesoris_in dao');
    }

    public function getItemMutasi()
    {
        $this->db->group_by('dao.item_code');
        $this->db->join('master_item mi', 'mi.item_code = dao.item_code', 'left');
        return $this->db->get('data_aksesoris_in dao');
    }

    public function getDivisiMutasi($item_code)
    {
        $this->db->where('dao.item_code', $item_code);
        $this->db->join('master_divisi md', 'md.id = dao.id_divisi', 'left');
        $this->db->select('md.*');
        $this->db->group_by('dao.id_divisi');
        return $this->db->get('data_aksesoris_in dao')->result();
    }

    public function getGudangMutasi($item_code, $divisi)
    {
        $this->db->where('dao.item_code', $item_code);
        $this->db->where('dao.id_divisi', $divisi);
        $this->db->join('master_gudang mg', 'mg.id = dao.id_gudang', 'left');
        $this->db->select('mg.*');
        $this->db->group_by('dao.id_gudang');
        return $this->db->get('data_aksesoris_in dao')->result();
    }

    public function getKeranjangMutasi($item_code, $divisi, $gudang)
    {
        $this->db->where('dao.item_code', $item_code);
        $this->db->where('dao.id_divisi', $divisi);
        $this->db->where('dao.id_gudang', $gudang);
        $this->db->select('dao.keranjang');
        return $this->db->get('data_aksesoris_in dao')->result();
    }

    public function getQtyMutasi($item_code, $divisi, $gudang, $keranjang)
    {
        $this->db->where('dao.item_code', $item_code);
        $this->db->where('dao.id_divisi', $divisi);
        $this->db->where('dao.id_gudang', $gudang);
        $this->db->where('dao.keranjang', $keranjang);
        return $this->db->get('data_aksesoris_in dao')->row()->qty;
    }

    public function cekMutasiTempatBaru($item_code, $divisi, $gudang, $keranjang)
    {
        $this->db->where('dao.item_code', $item_code);
        $this->db->where('dao.id_divisi', $divisi);
        $this->db->where('dao.id_gudang', $gudang);
        $this->db->where('dao.keranjang', $keranjang);
        return $this->db->get('data_aksesoris_in dao');
    }

    public function updateQtyTempatLama($item_code, $divisi, $gudang, $keranjang, $obj)
    {
        $this->db->where('dao.item_code', $item_code);
        $this->db->where('dao.id_divisi', $divisi);
        $this->db->where('dao.id_gudang', $gudang);
        $this->db->where('dao.keranjang', $keranjang);
        $this->db->update('data_aksesoris_in dao', $obj);
    }

    public function getMutasiHistory($item_code = '')
    {
        $this->db->join('master_divisi md', 'md.id = dao.id_divisi', 'left');
        $this->db->join('master_gudang mg', 'mg.id = dao.id_gudang', 'left');
        $this->db->join('master_item mi', 'mi.item_code = dao.item_code', 'left');

        $this->db->join('master_divisi md2', 'md2.id = dao.id_divisi2', 'left');
        $this->db->join('master_gudang mg2', 'mg2.id = dao.id_gudang2', 'left');
        $this->db->where('dao.item_code', $item_code);

        $this->db->select('dao.*,mi.deskripsi,md.divisi,mg.gudang,md2.divisi as divisi2,mg2.gudang as gudang2');
        $this->db->order_by('dao.id', 'desc');

        return $this->db->get('data_aksesoris_mutasi dao');
    }

    public function getQtyGudang($item_code, $id_divisi, $id_gudang)
    {
        $this->db->where('item_code', $item_code);
        $this->db->where('id_divisi', $id_divisi);
        $this->db->where('id_gudang', $id_gudang);
        $this->db->select('sum(qty) as qty_gudang');
        return $this->db->get('data_aksesoris_in')->row()->qty_gudang;
    }

    public function kunciStockOut($id)
    {
        $object = array('kunci' => 2);
        $this->db->where('id', $id);
        $this->db->update('data_aksesoris_out', $object);
    }

    public function finishStockOut($id)
    {
        $object = array('kunci' => 2);
        $this->db->where('id_fppp', $id);
        $this->db->where('is_manual', 1);
        $this->db->update('data_aksesoris_out', $object);
    }

    public function getfpppaksesoris()
    {
        $this->db->join('data_fppp df', 'df.id = dfb.id_fppp', 'left');
        $this->db->group_by('dfb.id_fppp');

        return $this->db->get('data_fppp_bom_aksesoris dfb');
    }
}

/* End of file m_aksesoris.php */
/* Location: ./application/models/klg/m_aksesoris.php */