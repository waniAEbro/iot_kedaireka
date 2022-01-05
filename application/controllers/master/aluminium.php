<?php
defined('BASEPATH') or exit('No direct script access allowed');

class aluminium extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->fungsi->restrict();
        $this->load->model('master/m_aluminium');
        $this->load->model('klg/m_fppp');
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $this->load->library('zend');
    }

    public function index()
    {
        $this->fungsi->check_previleges('aluminium');
        $data['aluminium'] = $this->m_aluminium->getData();
        $this->load->view('master/aluminium/v_aluminium_list', $data);
    }

    public function form($param = '')
    {
        $content   = "<div id='divsubcontent'></div>";
        $header    = "Form Master aluminium";
        $subheader = "aluminium";
        $buttons[]          = button('', 'Tutup', 'btn btn-default', 'data-dismiss="modal"');
        echo $this->fungsi->parse_modal($header, $subheader, $content, $buttons, "");
        if ($param == 'base') {
            $this->fungsi->run_js('load_silent("master/aluminium/show_addForm/","#divsubcontent")');
        } else {
            $base_kom = $this->uri->segment(5);
            $this->fungsi->run_js('load_silent("master/aluminium/show_editForm/' . $base_kom . '","#divsubcontent")');
        }
    }

    public function show_addForm()
    {
        $this->fungsi->check_previleges('aluminium');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'temper',
                'label' => 'temper',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['warna'] = $this->db->get('master_warna');
            $this->load->view('master/aluminium/v_aluminium_add', $data);
        } else {
            // $datapost = get_post_data(array('id_jenis_item', 'section_ata', 'section_allure', 'temper', 'kode_warna', 'ukuran', 'satuan', 'divisi'));
            $datapost = array(
                'id_jenis_item' => $this->input->post('id_jenis_item'),
                'section_ata' => $this->input->post('section_ata'),
                'section_allure' => $this->input->post('section_allure'),
                'temper' => $this->input->post('temper'),
                'kode_warna' => $this->input->post('kode_warna'),
                'ukuran' => $this->input->post('ukuran'),
                'satuan' => $this->input->post('satuan'),
                'divisi' => $this->input->post('divisi'),
                'item_code' => $this->input->post('section_ata') . '-' . $this->input->post('section_allure') . '-' . $this->input->post('temper') . '-' . $this->input->post('kode_warna') . '-' . $this->input->post('ukuran'),
                'created'        => date('Y-m-d H:i:s'),
            );
            $cek = $this->m_aluminium->cekMaster($datapost);
            if ($cek > 0) {
                $this->fungsi->message_box("Data Master aluminium sudah ada!", "warning");
            } else {
                $this->m_aluminium->insertData($datapost);
                $id_item = $this->db->insert_id();
                $id_warna = $this->m_aluminium->getRowIdWarna($this->input->post('kode_warna'));
                $datax = array(
                    'id' => $id_item,
                    'id_warna' => $id_warna,
                );
                $this->m_aluminium->updateData($datax);
                $code = '1' . str_pad($id_item, 10, '0', STR_PAD_LEFT);
                $this->insertbarcode($code, $id_item);
                $this->fungsi->catat($datapost, "Menambah Master aluminium dengan data sbb:", true);
            }
        }
    }

    public function show_editForm($id = '')
    {
        $this->fungsi->check_previleges('aluminium');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'id',
                'label' => 'wes mbarke',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['warna'] = $this->db->get('master_warna');
            $data['edit'] = $this->db->get_where('master_item', array('id' => $id));
            $this->load->view('master/aluminium/v_aluminium_edit', $data);
        } else {
            $datapost = get_post_data(array('id', 'id_jenis_item', 'section_ata', 'section_allure', 'temper', 'kode_warna', 'ukuran', 'satuan', 'divisi'));
            $this->m_aluminium->updateData($datapost);
            $id_warna = $this->m_aluminium->getRowIdWarna($this->input->post('kode_warna'));
            $datax = array(
                'id' => $this->input->post('id'),
                'id_warna' => $id_warna,
            );
            $this->m_aluminium->updateData($datax);
            $this->fungsi->run_js('load_silent("master/aluminium","#content")');
            $this->fungsi->message_box("Data Master aluminium sukses diperbarui...", "success");
            $this->fungsi->catat($datapost, "Mengedit Master aluminium dengan data sbb:", true);
        }
    }

    public function import()
    {
        $data['id'] = '';
        $this->load->view('master/aluminium/v_aluminium_upload', $data);
    }

    public function saveimport()
    {
        $fileName = time();
        //      $upload_folder = get_upload_folder('./excel_files/');

        // $config['upload_path']   = $upload_folder;

        $config['upload_path']   = './files/';      //buat folder dengan nama excel_files di root folder
        $config['file_name']     = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size']      = 20000;

        $this->load->library('upload');
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file'))
            $this->upload->display_errors();

        $media         = $this->upload->data('file');
        $inputFileName = './files/' . $media['file_name'];

        try {
            $inputFileType = IOFactory::identify($inputFileName);
            $objReader     = IOFactory::createReader($inputFileType);
            $objPHPExcel   = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
        }

        $sheet         = $objPHPExcel->getSheet(0);
        $highestRow    = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        for ($row = 2; $row <= $highestRow; $row++) {                  //  Read a row of data into an array
            $rowData = $sheet->rangeToArray(
                'A' . $row . ':' . $highestColumn . $row,
                NULL,
                TRUE,
                FALSE
            );

            $data = array(
                'id_jenis_item'       => 1,
                'section_ata'       => $rowData[0][0],
                'section_allure'    => $rowData[0][1],
                'temper'            => $rowData[0][2],
                'kode_warna'        => $rowData[0][3],
                'deskripsi_warna'   => $rowData[0][4],
                'ukuran'            => $rowData[0][5],
                'satuan'            => $rowData[0][6],
                'stock_akhir_bulan' => $rowData[0][7],
                'created'          => date('Y-m-d H:i:s'),
            );
            $cek_item = $this->m_fppp->cekMasterAluminium($data['section_ata'], $data['section_allure']);
            if ($cek_item < 1) {
                $this->m_fppp->simpanItem($data);
            }
        }
        $data['msg'] = "Data Disimpan....";
        echo json_encode($data);
    }


    public function insertbarcode($code, $id)
    {
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
        $this->m_aluminium->updateData($data);

        $this->fungsi->run_js('load_silent("master/aluminium","#content")');
        $this->fungsi->message_box("Data Master aluminium sukses disimpan...", "success");
    }

    public function cetak_barcode($id)
    {
        $this->db->where('id', $id);
        $data['bcd'] = $this->db->get('master_item')->row();
        $this->load->view('master/aluminium/v_aluminium_cetak_barcode', $data);
    }

    public function cetakExcel()
    {
        $this->fungsi->check_previleges('aluminium');
        $data['aluminium'] = $this->m_aluminium->getData();
        $this->load->view('master/aluminium/v_aluminium_cetak', $data);
    }

    public function deletexxxx($id)
    {
        $this->fungsi->check_previleges('aluminium');
        $this->db->where('id', $id);
        $res = $this->db->get('master_item')->result();
        $obj = array(
            'id_penghapus' => from_session('id'),
            'id_tabel' => $id,
            'tabel' => 'master_item',
            'keterangan' => json_encode($res),
            'created' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('data_delete', $obj);

        sleep(1);
        $data = array('id' => $id,);
        // $this->db->where('id', $id);
        // $this->db->delete('master_item');

        $this->fungsi->catat($data, "Menghapus Master Aluminium dengan data sbb:", true);
        // $this->fungsi->run_js('load_silent("master/aluminium/","#content")');
        $this->fungsi->message_box("Menghapus Master Aluminium", "success");
    }

    public function delete()
    {
        $this->fungsi->check_previleges('aluminium');
        $id   = $this->input->post('id');
        $this->db->where('id', $id);
        $res = $this->db->get('master_item')->result();
        $obj = array(
            'id_penghapus' => from_session('id'),
            'id_tabel' => $id,
            'tabel' => 'master_item',
            'keterangan' => json_encode($res),
            'created' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('data_delete', $obj);

        sleep(1);
        $data = array('id' => $id,);
        $this->db->where('id', $id);
        $this->db->delete('master_item');

        $this->fungsi->catat($data, "Menghapus Master Aluminium dengan data sbb:", true);
        $respon = ['msg' => 'Data Berhasil Dihapus'];
        echo json_encode($respon);
    }
}

/* End of file aluminium.php */
/* Location: ./application/controllers/master/aluminium.php */