<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Divisi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->fungsi->restrict();
        $this->load->model('master/m_divisi');
    }

    public function index()
    {
        $this->fungsi->check_previleges('divisi');
        $data['divisi'] = $this->m_divisi->getData();
        $this->load->view('master/divisi/v_divisi_list', $data);
    }

    public function form($param = '')
    {
        $content   = "<div id='divsubcontent'></div>";
        $header    = "Form Master divisi";
        $subheader = "divisi";
        $buttons[] = button('jQuery.facebox.close()', 'Tutup', 'btn btn-default', 'data-dismiss="modal"');
        echo $this->fungsi->parse_modal($header, $subheader, $content, $buttons, "");
        if ($param == 'base') {
            $this->fungsi->run_js('load_silent("master/divisi/show_addForm/","#divsubcontent")');
        } else {
            $base_kom = $this->uri->segment(5);
            $this->fungsi->run_js('load_silent("master/divisi/show_editForm/' . $base_kom . '","#divsubcontent")');
        }
    }

    public function show_addForm()
    {
        $this->fungsi->check_previleges('divisi');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field'    => 'divisi',
                'label' => 'divisi',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['status'] = '';
            $this->load->view('master/divisi/v_divisi_add', $data);
        } else {
            $datapost = get_post_data(array('divisi'));
            $this->m_divisi->insertData($datapost);
            $this->fungsi->run_js('load_silent("master/divisi","#content")');
            $this->fungsi->message_box("Data Master divisi sukses disimpan...", "success");
            $this->fungsi->catat($datapost, "Menambah Master divisi dengan data sbb:", true);
        }
    }

    public function show_editForm($id = '')
    {
        $this->fungsi->check_previleges('divisi');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field'    => 'id',
                'label' => 'wes mbarke',
                'rules' => ''
            ),
            array(
                'field'    => 'divisi',
                'label' => 'divisi',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['edit'] = $this->db->get_where('master_divisi', array('id' => $id));
            $this->load->view('master/divisi/v_divisi_edit', $data);
        } else {
            $datapost = get_post_data(array('id', 'divisi'));
            $this->m_divisi->updateData($datapost);
            $this->fungsi->run_js('load_silent("master/divisi","#content")');
            $this->fungsi->message_box("Data Master divisi sukses diperbarui...", "success");
            $this->fungsi->catat($datapost, "Mengedit Master divisi dengan data sbb:", true);
        }
    }
}

/* End of file divisi.php */
/* Location: ./application/controllers/master/divisi.php */