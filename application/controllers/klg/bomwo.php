<?php
defined('BASEPATH') or exit('No direct script access allowed');

// use Mailgun\Mailgun;

// $whitelist = array(
// 	'127.0.0.1',
// 	'::1'
// );

// if (!in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
// 	require '/var/www/html/alphamax/vendor/autoload.php';
// }
class Bomwo extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->fungsi->restrict();
        $this->load->model('klg/m_bomwo');
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
    }

    public function index()
    {
        $this->fungsi->check_previleges('bomwo');
        $data['bomwo'] = $this->m_bomwo->getData();
        $this->load->view('klg/bomwo/v_bomwo_list', $data);
    }

    public function formAdd()
    {
        $this->fungsi->check_previleges('bomwo');
        $data['divisi']                    = get_options($this->db->get('master_divisi'), 'id', 'divisi');
        $data['fppp']                    = get_options($this->db->get('data_fppp'), 'id', 'no_fppp');
        $this->load->view('klg/bomwo/v_bomwo_add', $data);
    }

    public function savebomwo($value = '')
    {
        $this->fungsi->check_previleges('bomwo');
        $datapost = array(
            'nama_project'              => $this->input->post('nama_project'),
            'id_fppp'          => $this->input->post('id_fppp'),
            'id_divisi'              => $this->input->post('id_divisi'),
            'tgl_deadline'       => $this->input->post('tgl_deadline'),
            'note'                   => $this->input->post('note'),
            'created'                => date('Y-m-d H:i:s'),
            'updated'                => date('Y-m-d H:i:s'),
        );
        $this->m_bomwo->insertbomwo($datapost);
        $data['id'] = $this->db->insert_id();
        $this->fungsi->catat($datapost, "Menyimpan bomwo sbb:", true);
        $data['msg'] = "bomwo Disimpan";
        echo json_encode($data);
    }

    public function savebomwoDetail($value = '')
    {
        $this->fungsi->check_previleges('bomwo');
        $datapost = array(
            'id_bomwo'        => $this->input->post('id_bomwo'),
            'id_brand'       => $this->input->post('id_brand'),
            'kode_opening'   => $this->input->post('kode_opening'),
            'kode_unit'      => $this->input->post('kode_unit'),
            'id_item'        => $this->input->post('id_item'),
            'glass_thick'    => $this->input->post('glass_thick'),
            'finish_coating' => $this->input->post('finish_coating'),
            'qty'            => $this->input->post('qty'),
            'created'        => date('Y-m-d H:i:s'),
        );

        $this->m_bomwo->insertbomwoDetail($datapost);
        $data['id'] = $this->db->insert_id();
        echo json_encode($data);
    }

    public function getDetailTabel($value = '')
    {
        $this->fungsi->check_previleges('bomwo');
        $id_bomwo = $this->input->post('id_bomwo');
        $data['detail'] = $this->m_bomwo->getDataDetailTabel($id_bomwo);
        echo json_encode($data);
    }

    public function upload()
    {
        $fileName = time();

        $config['upload_path'] = './files/'; //buat folder dengan nama excel_files di root folder
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 20000;

        $this->load->library('upload');
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file'))
            $this->upload->display_errors();

        $media = $this->upload->data('file');
        $inputFileName = './files/' . $media['file_name'];

        try {
            $inputFileType = IOFactory::identify($inputFileName);
            $objReader = IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
        }

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        for ($row = 2; $row <= $highestRow; $row++) {                  //  Read a row of data into an array
            $rowData = $sheet->rangeToArray(
                'A' . $row . ':' . $highestColumn . $row,
                NULL,
                TRUE,
                FALSE
            );

            //Sesuaikan sama nama kolom tabel di database
            $data = array(
                "id_bomwo"  => $this->input->post('id_bomwo'),
                "section"  => $rowData[0][0],
                "warna"  => $rowData[0][1],
                "qty"  => $rowData[0][2],
            );

            // $this->db->where('nim', $rowData[0][0]);
            // $hasil = $this->db->get('data_mahasiswa');
            // if ($hasil->num_rows() == 0) {
            $this->db->insert("data_bomwo_detail", $data);
            // }
            //sesuaikan nama dengan nama tabel

        }
        // delete_files($media['file_path']);
        // unlink($media['file_path']);
        $data['msg'] = "BOM Baru Disimpan....";
        echo json_encode($data);
    }
}

/* End of file bomwo.php */
/* Location: ./application/controllers/klg/bomwo.php */