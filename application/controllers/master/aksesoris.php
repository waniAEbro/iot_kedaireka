<?php
defined('BASEPATH') or exit('No direct script access allowed');

class aksesoris extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->fungsi->restrict();
        $this->load->model('master/m_aksesoris');
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
        $buttons[] = button('jQuery.facebox.close()', 'Tutup', 'btn btn-default', 'data-dismiss="modal"');
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
                'field'    => 'aksesoris',
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
                'field'    => 'id',
                'label' => 'wes mbarke',
                'rules' => ''
            ),
            array(
                'field'    => 'aksesoris',
                'label' => 'aksesoris',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['edit'] = $this->db->get_where('master_aksesoris', array('id' => $id));
            $this->load->view('master/aksesoris/v_aksesoris_edit', $data);
        } else {
            $datapost = get_post_data(array('id', 'aksesoris'));
            $this->m_aksesoris->updateData($datapost);
            $this->fungsi->run_js('load_silent("master/aksesoris","#content")');
            $this->fungsi->message_box("Data Master aksesoris sukses diperbarui...", "success");
            $this->fungsi->catat($datapost, "Mengedit Master aksesoris dengan data sbb:", true);
        }
    }
}

/* End of file aksesoris.php */
/* Location: ./application/controllers/master/aksesoris.php */