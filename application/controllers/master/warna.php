<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Warna extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->fungsi->restrict();
        $this->load->model('master/m_warna');
    }

    public function index()
    {
        $this->fungsi->check_previleges('warna');
        $data['warna'] = $this->m_warna->getData();
        $this->load->view('master/warna/v_warna_list', $data);
    }

    public function form($param = '')
    {
        $content   = "<div id='divsubcontent'></div>";
        $header    = "Form Master warna";
        $subheader = "warna";
        $buttons[]          = button('jQuery.facebox.close()', 'Tutup', 'btn btn-default', 'data-dismiss="modal"');
        echo $this->fungsi->parse_modal($header, $subheader, $content, $buttons, "");
        if ($param == 'base') {
            $this->fungsi->run_js('load_silent("master/warna/show_addForm/","#divsubcontent")');
        } else {
            $base_kom = $this->uri->segment(5);
            $this->fungsi->run_js('load_silent("master/warna/show_editForm/' . $base_kom . '","#divsubcontent")');
        }
    }

    public function show_addForm()
    {
        $this->fungsi->check_previleges('warna');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'warna',
                'label' => 'warna',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['status'] = '';
            $data['jenis_item'] = $this->db->get('master_jenis_item');
            $data['kabupaten'] = $this->db->get('kabupaten');
            $this->load->view('master/warna/v_warna_add', $data);
        } else {
            $datapost = get_post_data(array('kode', 'warna'));
            $this->m_warna->insertData($datapost);
            $this->fungsi->run_js('load_silent("master/warna","#content")');
            $this->fungsi->message_box("Data Master warna sukses disimpan...", "success");
            $this->fungsi->catat($datapost, "Menambah Master warna dengan data sbb:", true);
        }
    }

    public function show_editForm($id = '')
    {
        $this->fungsi->check_previleges('warna');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'id',
                'label' => 'wes mbarke',
                'rules' => ''
            ),
            array(
                'field' => 'warna',
                'label' => 'warna',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['jenis_item'] = $this->db->get('master_jenis_item');
            $data['kabupaten'] = $this->db->get('kabupaten');
            $data['edit'] = $this->db->get_where('master_warna', array('id' => $id));
            $this->load->view('master/warna/v_warna_edit', $data);
        } else {
            $datapost = get_post_data(array('id', 'kode', 'warna'));

            $this->m_warna->updateData($datapost);
            $this->fungsi->run_js('load_silent("master/warna","#content")');
            $this->fungsi->message_box("Data Master warna sukses diperbarui...", "success");
            $this->fungsi->catat($datapost, "Mengedit Master warna dengan data sbb:", true);
        }
    }
}

/* End of file warna.php */
/* Location: ./application/controllers/master/warna.php */