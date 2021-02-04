<?php
defined('BASEPATH') or exit('No direct script access allowed');

class kaca extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->fungsi->restrict();
        $this->load->model('master/m_kaca');
    }

    public function index()
    {
        $this->fungsi->check_previleges('kaca');
        $data['kaca'] = $this->m_kaca->getData();
        $this->load->view('master/kaca/v_kaca_list', $data);
    }

    public function form($param = '')
    {
        $content   = "<div id='divsubcontent'></div>";
        $header    = "Form Master kaca";
        $subheader = "kaca";
        $buttons[] = button('jQuery.facebox.close()', 'Tutup', 'btn btn-default', 'data-dismiss="modal"');
        echo $this->fungsi->parse_modal($header, $subheader, $content, $buttons, "");
        if ($param == 'base') {
            $this->fungsi->run_js('load_silent("master/kaca/show_addForm/","#divsubcontent")');
        } else {
            $base_kom = $this->uri->segment(5);
            $this->fungsi->run_js('load_silent("master/kaca/show_editForm/' . $base_kom . '","#divsubcontent")');
        }
    }

    public function show_addForm()
    {
        $this->fungsi->check_previleges('kaca');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field'    => 'kaca',
                'label' => 'kaca',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['status'] = '';
            $this->load->view('master/kaca/v_kaca_add', $data);
        } else {
            $datapost = get_post_data(array('kaca'));
            $this->m_kaca->insertData($datapost);
            $this->fungsi->run_js('load_silent("master/kaca","#content")');
            $this->fungsi->message_box("Data Master kaca sukses disimpan...", "success");
            $this->fungsi->catat($datapost, "Menambah Master kaca dengan data sbb:", true);
        }
    }

    public function show_editForm($id = '')
    {
        $this->fungsi->check_previleges('kaca');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field'    => 'id',
                'label' => 'wes mbarke',
                'rules' => ''
            ),
            array(
                'field'    => 'kaca',
                'label' => 'kaca',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['edit'] = $this->db->get_where('master_kaca', array('id' => $id));
            $this->load->view('master/kaca/v_kaca_edit', $data);
        } else {
            $datapost = get_post_data(array('id', 'kaca'));
            $this->m_kaca->updateData($datapost);
            $this->fungsi->run_js('load_silent("master/kaca","#content")');
            $this->fungsi->message_box("Data Master kaca sukses diperbarui...", "success");
            $this->fungsi->catat($datapost, "Mengedit Master kaca dengan data sbb:", true);
        }
    }
}

/* End of file kaca.php */
/* Location: ./application/controllers/master/kaca.php */