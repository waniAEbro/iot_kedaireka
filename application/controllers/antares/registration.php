<?php

class Registration extends CI_Controller
{
    public function register_rfid()
    {
        $input_stream = file_get_contents('php://input');
        $post_data = json_decode($input_stream, true);

        if ($post_data === null) {
            return;
        } else {
            // $this->db->where('rfid', json_decode($post_data["m2m:sgn"]["m2m:nev"]["m2m:rep"]["m2m:cin"]["con"])["tag"]);
            $this->db->where('rfid', $post_data["tag"]);
            $cek = $this->db->get('master_item')->num_rows();
            if ($cek > 0) {
                return;
            } else {
                $this->db->insert(
                    'master_item',
                    array(
                        "rfid" => $post_data["tag"],
                        "item_code" => $post_data["tag"]
                    )
                );
                $id_item = $this->db->insert_id();
                $code = $post_data["tag"];
                $this->insertbarcode($code, $id_item);
                $ip = $_SERVER['REMOTE_ADDR'];
                $waktu = date('Y-m-d H:i:s');
                $this->db->insert(
                    'cms_log',
                    array(
                        'ip' => $ip,
                        'mac_address' => $ip,
                        'user' => "antares",
                        'kegiatan' => "insert rfid",
                        'time' => $waktu
                    )
                );
            }
        }
    }

    public function insertbarcode($code, $id)
    {
        $this->load->model('master/m_aksesoris');
        $this->load->library('zend');
        $this->zend->load('Zend/Barcode');
        $barcode = $code; //nomor id barcode
        $imageResource = Zend_Barcode::factory('code128', 'image', array('text' => $barcode), array())->draw();
        $imageName = $barcode . '.jpg';
        $imagePath = 'files/'; // penyimpanan file barcode
        imagejpeg($imageResource, $imagePath . $imageName);
        $pathBarcode = $imagePath . $imageName; //Menyimpan path image bardcode kedatabase

        $data = array(
            'id' => $id,
            'barcode' => $barcode,
            'image_barcode' => $pathBarcode
        );
        $this->m_aksesoris->updateData($data);
    }
}

?>