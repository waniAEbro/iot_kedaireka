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

    public function insertstokin($value = '')
    {
        $this->db->insert('data_aksesoris_in', $value);
    }

    // public function insertstokout($value = '')
    // {
    //     $this->db->insert('data_aksesoris_out', $value);
    // }

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
        return $this->db->get('data_aksesoris_in')->row()->qty;
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

    public function cek_fppp_out($id)
    {
        $this->db->where('id_fppp', $id);
        return $this->db->get('data_aksesoris_out')->num_rows();
    }

    public function getBomAksesoris($id)
    {
        $this->db->join('master_item mi', 'mi.item_code = dao.item_code', 'left');
        $this->db->where('dao.id_fppp', $id);
        $this->db->select('dao.*,mi.deskripsi');
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
}

/* End of file m_aksesoris.php */
/* Location: ./application/models/klg/m_aksesoris.php */