<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenis_market extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->fungsi->restrict();
        $this->load->model('master/m_jenis_market');
    }

    public function index()
    {
        $this->fungsi->check_previleges('jenis_market');
        $data['jenis_market'] = $this->m_jenis_market->getData();
        $this->load->view('master/jenis_market/v_jenis_market_list', $data);
    }

    public function form($param = '')
    {
        $content   = "<div id='divsubcontent'></div>";
        $header    = "Form Master Jenis Market";
        $subheader = "";
        $buttons[] = button('', 'Tutup', 'btn btn-default', 'data-dismiss="modal"');
        echo $this->fungsi->parse_modal($header, $subheader, $content, $buttons, "");
        if ($param == 'base') {
            $this->fungsi->run_js('load_silent("master/jenis_market/show_addForm/","#divsubcontent")');
        } else {
            $base_kom = $this->uri->segment(5);
            $this->fungsi->run_js('load_silent("master/jenis_market/show_editForm/' . $base_kom . '","#divsubcontent")');
        }
    }

    public function show_addForm()
    {
        $this->fungsi->check_previleges('jenis_market');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field'    => 'jenis_market',
                'label' => 'jenis_market',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['status'] = '';
            $this->load->view('master/jenis_market/v_jenis_market_add', $data);
        } else {
            $datapost = get_post_data(array('jenis_market'));
            $this->m_jenis_market->insertData($datapost);
            $this->fungsi->run_js('load_silent("master/jenis_market","#content")');
            $this->fungsi->message_box("Data Master jenis_market sukses disimpan...", "success");
            $this->fungsi->catat($datapost, "Menambah Master jenis_market dengan data sbb:", true);
        }
    }

    public function show_editForm($id = '')
    {
        $this->fungsi->check_previleges('jenis_market');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field'    => 'id',
                'label' => 'wes mbarke',
                'rules' => ''
            ),
            array(
                'field'    => 'jenis_market',
                'label' => 'jenis_market',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['edit'] = $this->db->get_where('master_jenis_market', array('id' => $id));
            $this->load->view('master/jenis_market/v_jenis_market_edit', $data);
        } else {
            $datapost = get_post_data(array('id', 'jenis_market'));
            $this->m_jenis_market->updateData($datapost);
            $this->fungsi->run_js('load_silent("master/jenis_market","#content")');
            $this->fungsi->message_box("Data Master jenis_market sukses diperbarui...", "success");
            $this->fungsi->catat($datapost, "Mengedit Master jenis_market dengan data sbb:", true);
        }
    }
}

/* End of file jenis_market.php */
/* Location: ./application/controllers/master/jenis_market.php */