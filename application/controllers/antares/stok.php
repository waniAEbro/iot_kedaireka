<?php

class Stok extends CI_Controller {
    public function stok_in_iot() {
        $this->load->model('wrh/m_aksesoris');
        $input_stream = file_get_contents('php://input');
        $post_data = json_decode($input_stream, true);

        $this->db->where('id_jenis_item', "2");
        $this->db->where('id_user', from_session('id'));
        $cek_in_temp = $this->db->get('data_in_temp')->num_rows();
        if ($cek_in_temp < 1) {
            $data_temp = array(
                'id_user'  => 54,
                'id_jenis_item'  => 2,
                'tgl_aktual'     => date('Y-m-d H:i:s'),
                'id_supplier'    => 1,
                'no_surat_jalan' => "",
                'no_pr'          => "",
                'created'        => date('Y-m-d H:i:s'),
            );
            $this->db->insert('data_in_temp', $data_temp);
        }

        $this->db->where("rfid", json_decode($post_data["m2m:sgn"]["m2m:nev"]["m2m:rep"]["m2m:cin"]["con"], true)["tag"]);
        $id_item = $this->db->get("master_item")->row()->id;

        $this->db->insert("data_stock", array(
            'id_item'        => $id_item,
            'inout'          => 1,
            'id_jenis_item'  => 2,
            'qty_in'         => 1,
            'id_supplier'    => 1,
            'no_surat_jalan' => "",
            'no_pr'          => "",
            'id_divisi'      => 39,
            'id_gudang'      => 5,
            'keranjang'      => "",
            'keterangan'     => "",
            'id_penginput'   => 54,
            'created'        => date('Y-m-d H:i:s'),
            'updated'        => date('Y-m-d H:i:s'),
            'aktual'         => date('Y-m-d H:i:s'),
            'in_temp'        => 0,
            "id_seselan"     => 0
        ));
        
        $id = $this->db->insert_id();
        $this->db->where("id", $id);
        $datapost = $this->db->get("data_stock")->row();

        $ip = $_SERVER['REMOTE_ADDR'];
                $waktu = date('Y-m-d H:i:s');
                $this->db->insert('cms_log', array(
                    'ip' => $ip,
                    'mac_address' => $ip,
                    'user' => "antares",
                    'kegiatan' => "stok in rfid",
                    'time' => $waktu
                ));

        $cekDataCounter = $this->m_aksesoris->getDataCounter($datapost->id_item, $datapost->id_divisi, $datapost->id_gudang, $datapost->keranjang)->num_rows();
        if ($cekDataCounter == 0) {
            $simpan = array(
                'id_jenis_item' => 2,
                'id_item'       => $id_item,
                'id_divisi'     => 39,
                'id_gudang'     => 5,
                'keranjang'     => "",
                'qty'           => 1,
                'created'       => date('Y-m-d H:i:s'),
                'itm_code'      => json_decode($post_data["m2m:sgn"]["m2m:nev"]["m2m:rep"]["m2m:cin"]["con"], true)["tag"]
            );
            $this->db->insert('data_counter', $simpan);
        } else {
            $cekQtyCounter = $this->m_aksesoris->getDataCounter($datapost->id_item, $datapost->id_divisi, $datapost->id_gudang, $datapost->keranjang)->row()->qty;
            $qty_jadi      = (int)$datapost['qty_in'] + (int)$cekQtyCounter;
            $this->m_aksesoris->updateDataCounter($datapost->id_item, $datapost->id_divisi, $datapost->id_gudang, $datapost->keranjang, $qty_jadi);
        }
    }
}

?>