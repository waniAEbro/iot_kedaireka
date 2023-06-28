<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gudang extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->fungsi->restrict();
        $this->load->model('master/m_gudang');
    }

    public function index()
    {
        $this->fungsi->check_previleges('gudang');
        $data['gudang'] = $this->m_gudang->getData();
        $this->load->view('master/gudang/v_gudang_list', $data);
    }

    public function form($param = '')
    {
        $content   = "<div id='divsubcontent'></div>";
        $header    = "Form Master gudang";
        $subheader = "gudang";
        $buttons[]          = button('', 'Tutup', 'btn btn-default', 'data-dismiss="modal"');
        echo $this->fungsi->parse_modal($header, $subheader, $content, $buttons, "");
        if ($param == 'base') {
            $this->fungsi->run_js('load_silent("master/gudang/show_addForm/","#divsubcontent")');
        } else {
            $base_kom = $this->uri->segment(5);
            $this->fungsi->run_js('load_silent("master/gudang/show_editForm/' . $base_kom . '","#divsubcontent")');
        }
    }

    public function show_addForm()
    {
        $this->fungsi->check_previleges('gudang');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'gudang',
                'label' => 'gudang',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['jenis_item'] = $this->db->get('master_jenis_item');
            $this->load->view('master/gudang/v_gudang_add', $data);
        } else {
            $datapost = get_post_data(array('id_jenis_item', 'gudang','jenis_aluminium'));
            $this->m_gudang->insertData($datapost);
            $this->fungsi->run_js('load_silent("master/gudang","#content")');
            $this->fungsi->message_box("Data Master gudang sukses disimpan...", "success");
            $this->fungsi->catat($datapost, "Menambah Master gudang dengan data sbb:", true);
        }
    }

    public function show_editForm($id = '')
    {
        $this->fungsi->check_previleges('gudang');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'id',
                'label' => 'wes mbarke',
                'rules' => ''
            ),
            array(
                'field' => 'gudang',
                'label' => 'gudang',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['jenis_item'] = $this->db->get('master_jenis_item');
            $data['edit'] = $this->db->get_where('master_gudang', array('id' => $id));
            $this->load->view('master/gudang/v_gudang_edit', $data);
        } else {
            $datapost = get_post_data(array('id', 'id_jenis_item', 'gudang','jenis_aluminium'));

            $this->m_gudang->updateData($datapost);
            $this->fungsi->run_js('load_silent("master/gudang","#content")');
            $this->fungsi->message_box("Data Master gudang sukses diperbarui...", "success");
            $this->fungsi->catat($datapost, "Mengedit Master gudang dengan data sbb:", true);
        }
    }
}

/* End of file gudang.php */
/* Location: ./application/controllers/master/gudang.php */