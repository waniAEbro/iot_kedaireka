<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lembaran extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->fungsi->restrict();
        $this->load->model('master/m_lembaran');
    }

    public function index()
    {
        $this->fungsi->check_previleges('lembaran');
        $data['lembaran'] = $this->m_lembaran->getData();
        $this->load->view('master/lembaran/v_lembaran_list', $data);
    }

    public function form($param = '')
    {
        $content   = "<div id='divsubcontent'></div>";
        $header    = "Form Master lembaran";
        $subheader = "lembaran";
        $buttons[] = button('jQuery.facebox.close()', 'Tutup', 'btn btn-default', 'data-dismiss="modal"');
        echo $this->fungsi->parse_modal($header, $subheader, $content, $buttons, "");
        if ($param == 'base') {
            $this->fungsi->run_js('load_silent("master/lembaran/show_addForm/","#divsubcontent")');
        } else {
            $base_kom = $this->uri->segment(5);
            $this->fungsi->run_js('load_silent("master/lembaran/show_editForm/' . $base_kom . '","#divsubcontent")');
        }
    }

    public function show_addForm()
    {
        $this->fungsi->check_previleges('lembaran');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field'    => 'lembaran',
                'label' => 'item_code',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['status'] = '';
            $this->load->view('master/lembaran/v_lembaran_add', $data);
        } else {
            $datapost = get_post_data(array('item_code', 'deskripsi'));
            $this->m_lembaran->insertData($datapost);
            $this->fungsi->run_js('load_silent("master/lembaran","#content")');
            $this->fungsi->message_box("Data Master lembaran sukses disimpan...", "success");
            $this->fungsi->catat($datapost, "Menambah Master lembaran dengan data sbb:", true);
        }
    }

    public function show_editForm($id = '')
    {
        $this->fungsi->check_previleges('lembaran');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field'    => 'id',
                'label' => 'wes mbarke',
                'rules' => ''
            ),
            array(
                'field'    => 'lembaran',
                'label' => 'lembaran',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['edit'] = $this->db->get_where('master_lembaran', array('id' => $id));
            $this->load->view('master/lembaran/v_lembaran_edit', $data);
        } else {
            $datapost = get_post_data(array('id', 'lembaran'));
            $this->m_lembaran->updateData($datapost);
            $this->fungsi->run_js('load_silent("master/lembaran","#content")');
            $this->fungsi->message_box("Data Master lembaran sukses diperbarui...", "success");
            $this->fungsi->catat($datapost, "Mengedit Master lembaran dengan data sbb:", true);
        }
    }
}

/* End of file lembaran.php */
/* Location: ./application/controllers/master/lembaran.php */