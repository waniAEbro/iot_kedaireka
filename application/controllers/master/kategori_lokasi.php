<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori_lokasi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->fungsi->restrict();
        $this->load->model('master/m_kategori_lokasi');
    }

    public function index()
    {
        $this->fungsi->check_previleges('kategori_lokasi');
        $data['kategori_lokasi'] = $this->m_kategori_lokasi->getData();
        $this->load->view('master/kategori_lokasi/v_kategori_lokasi_list', $data);
    }

    public function form($param = '')
    {
        $content   = "<div id='divsubcontent'></div>";
        $header    = "Form Master Kategori Lokasi";
        $subheader = "";
        $buttons[] = button('', 'Tutup', 'btn btn-default', 'data-dismiss="modal"');
        echo $this->fungsi->parse_modal($header, $subheader, $content, $buttons, "");
        if ($param == 'base') {
            $this->fungsi->run_js('load_silent("master/kategori_lokasi/show_addForm/","#divsubcontent")');
        } else {
            $base_kom = $this->uri->segment(5);
            $this->fungsi->run_js('load_silent("master/kategori_lokasi/show_editForm/' . $base_kom . '","#divsubcontent")');
        }
    }

    public function show_addForm()
    {
        $this->fungsi->check_previleges('kategori_lokasi');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field'    => 'kategori_lokasi',
                'label' => 'kategori_lokasi',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['status'] = '';
            $this->load->view('master/kategori_lokasi/v_kategori_lokasi_add', $data);
        } else {
            $datapost = get_post_data(array('kategori_lokasi'));
            $this->m_kategori_lokasi->insertData($datapost);
            $this->fungsi->run_js('load_silent("master/kategori_lokasi","#content")');
            $this->fungsi->message_box("Data Master kategori_lokasi sukses disimpan...", "success");
            $this->fungsi->catat($datapost, "Menambah Master kategori_lokasi dengan data sbb:", true);
        }
    }

    public function show_editForm($id = '')
    {
        $this->fungsi->check_previleges('kategori_lokasi');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field'    => 'id',
                'label' => 'wes mbarke',
                'rules' => ''
            ),
            array(
                'field'    => 'kategori_lokasi',
                'label' => 'kategori_lokasi',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['edit'] = $this->db->get_where('master_kategori_lokasi', array('id' => $id));
            $this->load->view('master/kategori_lokasi/v_kategori_lokasi_edit', $data);
        } else {
            $datapost = get_post_data(array('id', 'kategori_lokasi'));
            $this->m_kategori_lokasi->updateData($datapost);
            $this->fungsi->run_js('load_silent("master/kategori_lokasi","#content")');
            $this->fungsi->message_box("Data Master kategori_lokasi sukses diperbarui...", "success");
            $this->fungsi->catat($datapost, "Mengedit Master kategori_lokasi dengan data sbb:", true);
        }
    }
}

/* End of file kategori_lokasi.php */
/* Location: ./application/controllers/master/kategori_lokasi.php */