<?php


class IOT extends CI_Controller
{

    public function get_data()
    {
        // Ambil data JSON dari permintaan POST
        $input_stream = file_get_contents('php://input');
        $post_data = json_decode($input_stream, true);

        if ($post_data === null) {
            // Gagal menguraikan JSON, tangani kesalahan
            $response = array('message' => 'Gagal menguraikan data JSON');
        } else {
            // Lakukan validasi atau operasi lain sesuai kebutuhan

            // Buat respons data
            $response = array('message' => 'Data berhasil dibuat', 'data' => $post_data);
            $this->db->insert('master_item', array (
                "rfid" => json_decode($post_data["m2m:sgn"]["m2m:nev"]["m2m:rep"]["m2m:cin"]["con"])["tag"]
            ));
        }

        // Atur tipe konten sebagai JSON
        header('Content-Type: application/json');

        // Kembalikan respons JSON
        echo json_encode($response);
    }
}

?>