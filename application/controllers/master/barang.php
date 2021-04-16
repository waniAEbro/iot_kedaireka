<?php
defined('BASEPATH') or exit('No direct script access allowed');

class barang extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->fungsi->restrict();
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $this->load->model('master/m_barang');
    }

    public function index()
    {
        $this->fungsi->check_previleges('barang');
        $data['barang'] = $this->m_barang->getData();
        $this->load->view('master/barang/v_barang_list', $data);
    }


    public function show_addForm($value = '')
    {
        $this->fungsi->check_previleges('barang');
        $data['brand'] = $this->m_barang->getBrand();
        $this->load->view('master/barang/v_barang_add', $data);
    }

    public function insert($value = '')
    {
        $this->fungsi->check_previleges('barang');
        $datapost = array(
            'brand'      => $this->input->post('brand'),
            'barang'     => $this->input->post('barang'),
            'keterangan' => $this->input->post('keterangan'),
            'created'    => date('Y-m-d H:i:s'),
        );
        $this->m_barang->insertData($datapost);
        $this->fungsi->catat($datapost, "Menambah Master barang dengan data sbb:", true);
        $data['msg'] = "barang Disimpan!";
        echo json_encode($data);
    }

    public function insertFile()
    {
        $this->fungsi->check_previleges('barang');

        $upload_folder = get_upload_folder('./files/');

        $config['upload_path']   = $upload_folder;
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size']      = '3072';
        $config['encrypt_name']  = true;

        $this->load->library('upload', $config);
        $err = "";
        $msg = "";
        if (!$this->upload->do_upload('ufile')) {
            $err = $this->upload->display_errors('<span class="error_string">', '</span>');
        } else {
            $data = $this->upload->data();
            /***********************/
            // CREATE THUMBNAIL 100x100 - maintain aspect ratio
            /**********************/
            $config['image_library']  = 'gd2';
            $config['source_image']   = $upload_folder . $data['file_name'];
            $config['maintain_ratio'] = TRUE;
            $config['width']          = 100;
            $config['height']         = 100;

            $this->load->library('image_lib', $config);

            if (!$this->image_lib->resize()) {
                $err = $this->image_lib->display_errors('<span class="error_string">', '</span>');
            } else {
                $datapost = array(
                    'brand'      => $this->input->post('brand'),
                    'barang'     => $this->input->post('barang'),
                    'gambar'     => substr($upload_folder, 2) . $data['file_name'],
                    'keterangan' => $this->input->post('keterangan'),
                    'created'    => date('Y-m-d H:i:s'),
                );
                $this->m_barang->insertData($datapost);
                $this->fungsi->catat($datapost, "Menambah Master barang dengan data sbb:", true);
                $data['msg'] = "barang Disimpan!";
                echo json_encode($data);
            }
        }
    }

    public function show_editForm($id = '')
    {
        $this->fungsi->check_previleges('barang');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'id',
                'label' => 'wes mbarke',
                'rules' => ''
            ),
            array(
                'field' => 'barang',
                'label' => 'barang',
                'rules' => 'required'
            ),
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['edit']  = $this->m_barang->getEditbarang($id);
            $data['brand'] = $this->m_barang->getBrand();
            $this->load->view('master/barang/v_barang_edit', $data);
        } else {
            $datapost = get_post_data(array('id', 'brand', 'barang', 'keterangan'));
            $this->m_barang->insertData($datapost, false);
            $this->fungsi->catat($datapost, "Mengedit Master barang dengan data sbb:", true);
            $data['msg'] = "barang Diperbarui!";
            echo json_encode($data);
        }
    }

    public function show_editForm_file($id = '')
    {
        $this->fungsi->check_previleges('barang');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'id',
                'label' => 'wes mbarke',
                'rules' => ''
            ),
            array(
                'field' => 'barang',
                'label' => 'barang',
                'rules' => 'required'
            ),
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {

            $data['edit']  = $this->m_barang->getEditbarang($id);
            $data['brand'] = $this->m_barang->getBrand();
            $this->load->view('master/barang/v_barang_edit', $data);
        } else {
            $upload_folder = get_upload_folder('./files/');

            $config['upload_path']   = $upload_folder;
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size']      = '3072';
            $config['encrypt_name']  = true;

            $this->load->library('upload', $config);
            $err = "";
            $msg = "";
            if (!$this->upload->do_upload('ufile')) {
                $err = $this->upload->display_errors('<span class="error_string">', '</span>');
            } else {
                $data = $this->upload->data();
                /***********************/
                // CREATE THUMBNAIL 100x100 - maintain aspect ratio
                /**********************/
                $config['image_library']  = 'gd2';
                $config['source_image']   = $upload_folder . $data['file_name'];
                $config['maintain_ratio'] = TRUE;
                $config['width']          = 100;
                $config['height']         = 100;

                $this->load->library('image_lib', $config);

                if (!$this->image_lib->resize()) {
                    $err = $this->image_lib->display_errors('<span class="error_string">', '</span>');
                } else {
                    $datapost = array(
                        'id'         => $this->input->post('id'),
                        'brand'      => $this->input->post('brand'),
                        'barang'     => $this->input->post('barang'),
                        'gambar'     => substr($upload_folder, 2) . $data['file_name'],
                        'keterangan' => $this->input->post('keterangan'),
                    );
                    $this->m_barang->insertData($datapost, false);
                    $this->fungsi->catat($datapost, "Mengupdate Master barang dengan data sbb:", true);
                    $data['msg'] = "barang Baru Disimpan!";
                    echo json_encode($data);
                }
            }
        }
    }

    public function delete($id)
    {
        $this->fungsi->check_previleges('barang');
        if ($id == '' || !is_numeric($id)) die;
        $this->m_barang->deleteData($id);
        $this->fungsi->run_js('load_silent("master/barang","#content")');
        $this->fungsi->message_box("Data Master barang berhasil dihapus...", "success");
        $this->fungsi->catat("Menghapus laporan dengan id " . $id);
    }

    public function import()
    {
        $data['id'] = '';
        $this->load->view('master/barang/v_barang_upload', $data);
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
                'brand'      => $rowData[0][0],
                'barang'     => $rowData[0][1],
                'keterangan' => $rowData[0][2],
                'created'    => date('Y-m-d H:i:s'),
            );
            $this->db->insert("master_barang", $data);
        }
        $data['msg'] = "Data Disimpan....";
        echo json_encode($data);
    }


    public function modal($id = '')
    {
        $content   = "<div id='divsubcontent'></div>";
        $header    = "Detail Product";
        $subheader = "";
        $buttons[]          = button('', 'Tutup', 'btn btn-default', 'data-dismiss="modal"');
        echo $this->fungsi->parse_modal($header, $subheader, $content, $buttons, "");
        $this->fungsi->run_js('load_silent("master/barang/detailModal/' . $id . '","#divsubcontent")');
    }

    public function detailModal($id)
    {
        $barang = $this->m_barang->getRowbarang($id)->row();
        $data   = array(
            'barang' => $barang,
        );
        $this->load->view('master/barang/v_modal', $data);
    }
}

/* End of file barang.php */
/* Location: ./application/controllers/master/barang.php */