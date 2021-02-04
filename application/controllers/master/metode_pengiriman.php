<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Metode_pengiriman extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->fungsi->restrict();
        $this->load->model('master/m_metode_pengiriman');
    }

    public function index()
    {
        $this->fungsi->check_previleges('metode_pengiriman');
        $data['metode_pengiriman'] = $this->m_metode_pengiriman->getData();
        $this->load->view('master/metode_pengiriman/v_metode_pengiriman_list', $data);
    }

    public function form($param = '')
    {
        $content   = "<div id='divsubcontent'></div>";
        $header    = "Form Master metode_pengiriman";
        $subheader = "metode_pengiriman";
        $buttons[] = button('jQuery.facebox.close()', 'Tutup', 'btn btn-default', 'data-dismiss="modal"');
        echo $this->fungsi->parse_modal($header, $subheader, $content, $buttons, "");
        if ($param == 'base') {
            $this->fungsi->run_js('load_silent("master/metode_pengiriman/show_addForm/","#divsubcontent")');
        } else {
            $base_kom = $this->uri->segment(5);
            $this->fungsi->run_js('load_silent("master/metode_pengiriman/show_editForm/' . $base_kom . '","#divsubcontent")');
        }
    }

    public function show_addForm()
    {
        $this->fungsi->check_previleges('metode_pengiriman');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field'    => 'metode_pengiriman',
                'label' => 'metode_pengiriman',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['status'] = '';
            $this->load->view('master/metode_pengiriman/v_metode_pengiriman_add', $data);
        } else {
            $datapost = get_post_data(array('metode_pengiriman'));
            $this->m_metode_pengiriman->insertData($datapost);
            $this->fungsi->run_js('load_silent("master/metode_pengiriman","#content")');
            $this->fungsi->message_box("Data Master metode_pengiriman sukses disimpan...", "success");
            $this->fungsi->catat($datapost, "Menambah Master metode_pengiriman dengan data sbb:", true);
        }
    }

    public function show_editForm($id = '')
    {
        $this->fungsi->check_previleges('metode_pengiriman');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field'    => 'id',
                'label' => 'wes mbarke',
                'rules' => ''
            ),
            array(
                'field'    => 'metode_pengiriman',
                'label' => 'metode_pengiriman',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['edit'] = $this->db->get_where('master_metode_pengiriman', array('id' => $id));
            $this->load->view('master/metode_pengiriman/v_metode_pengiriman_edit', $data);
        } else {
            $datapost = get_post_data(array('id', 'metode_pengiriman'));
            $this->m_metode_pengiriman->updateData($datapost);
            $this->fungsi->run_js('load_silent("master/metode_pengiriman","#content")');
            $this->fungsi->message_box("Data Master metode_pengiriman sukses diperbarui...", "success");
            $this->fungsi->catat($datapost, "Mengedit Master metode_pengiriman dengan data sbb:", true);
        }
    }
}

/* End of file metode_pengiriman.php */
/* Location: ./application/controllers/master/metode_pengiriman.php */