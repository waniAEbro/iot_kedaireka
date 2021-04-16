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
        $buttons[]          = button('jQuery.facebox.close()', 'Tutup', 'btn btn-default', 'data-dismiss="modal"');
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
                'field' => 'aluminium',
                'label' => 'item_code',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['status'] = '';
            $this->load->view('master/aluminium/v_aluminium_add', $data);
        } else {
            $datapost = get_post_data(array('item_code', 'deskripsi'));
            $this->m_aluminium->insertData($datapost);
            $this->fungsi->run_js('load_silent("master/aluminium","#content")');
            $this->fungsi->message_box("Data Master aluminium sukses disimpan...", "success");
            $this->fungsi->catat($datapost, "Menambah Master aluminium dengan data sbb:", true);
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
                'rules' => ''
            ),
            array(
                'field' => 'aluminium',
                'label' => 'aluminium',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['edit'] = $this->db->get_where('master_aluminium', array('id' => $id));
            $this->load->view('master/aluminium/v_aluminium_edit', $data);
        } else {
            $datapost = get_post_data(array('id', 'aluminium'));
            $this->m_aluminium->updateData($datapost);
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
}

/* End of file aluminium.php */
/* Location: ./application/controllers/master/aluminium.php */