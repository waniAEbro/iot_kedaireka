<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aksesoris extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->fungsi->restrict();
        $this->load->model('master/m_aksesoris');
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
    }

    public function index()
    {
        $this->fungsi->check_previleges('aksesoris');
        $data['aksesoris'] = $this->m_aksesoris->getData();
        $this->load->view('master/aksesoris/v_aksesoris_list', $data);
    }

    public function form($param = '')
    {
        $content   = "<div id='divsubcontent'></div>";
        $header    = "Form Master aksesoris";
        $subheader = "aksesoris";
        $buttons[]          = button('jQuery.facebox.close()', 'Tutup', 'btn btn-default', 'data-dismiss="modal"');
        echo $this->fungsi->parse_modal($header, $subheader, $content, $buttons, "");
        if ($param == 'base') {
            $this->fungsi->run_js('load_silent("master/aksesoris/show_addForm/","#divsubcontent")');
        } else {
            $base_kom = $this->uri->segment(5);
            $this->fungsi->run_js('load_silent("master/aksesoris/show_editForm/' . $base_kom . '","#divsubcontent")');
        }
    }

    public function show_addForm()
    {
        $this->fungsi->check_previleges('aksesoris');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'aksesoris',
                'label' => 'item_code',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['status'] = '';
            $this->load->view('master/aksesoris/v_aksesoris_add', $data);
        } else {
            $datapost = get_post_data(array('item_code', 'deskripsi'));
            $this->m_aksesoris->insertData($datapost);
            $this->fungsi->run_js('load_silent("master/aksesoris","#content")');
            $this->fungsi->message_box("Data Master aksesoris sukses disimpan...", "success");
            $this->fungsi->catat($datapost, "Menambah Master aksesoris dengan data sbb:", true);
        }
    }

    public function show_editForm($id = '')
    {
        $this->fungsi->check_previleges('aksesoris');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'id',
                'label' => 'wes mbarke',
                'rules' => ''
            ),
            array(
                'field' => 'item_code',
                'label' => 'item_code',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['edit'] = $this->db->get_where('master_item', array('id' => $id));
            $this->load->view('master/aksesoris/v_aksesoris_edit', $data);
        } else {
            $datapost = get_post_data(array('id', 'item_code', 'deskripsi', 'satuan'));
            $this->m_aksesoris->updateData($datapost);
            $this->fungsi->run_js('load_silent("master/aksesoris","#content")');
            $this->fungsi->message_box("Data Master aksesoris sukses diperbarui...", "success");
            $this->fungsi->catat($datapost, "Mengedit Master aksesoris dengan data sbb:", true);
        }
    }

    public function import()
    {
        $data['id'] = '';
        $this->load->view('master/aksesoris/v_aksesoris_upload', $data);
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
                'id_jenis_item'      => 2,
                'item_code'          => $rowData[0][0],
                'deskripsi'          => $rowData[0][1],
                'divisi'             => $rowData[0][2],
                'supplier'           => $rowData[0][3],
                'deskripsi_supplier' => $rowData[0][4],
                'satuan'             => $rowData[0][5],
                'stock_akhir_bulan'  => $rowData[0][6],
                'created'            => date('Y-m-d H:i:s'),
            );
            $cek_item = $this->m_aksesoris->cekMasterAksesoris($data['item_code']);
            if ($cek_item < 1) {
                $this->m_aksesoris->insertData($data);
            } else {
                $this->m_aksesoris->updateItemCode($data);
            }
        }
        $data['msg'] = "Data Disimpan....";
        echo json_encode($data);
    }
}

/* End of file aksesoris.php */
/* Location: ./application/controllers/master/aksesoris.php */