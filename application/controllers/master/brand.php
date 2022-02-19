<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Brand extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->fungsi->restrict();
        $this->load->model('master/m_brand');
    }

    public function index()
    {
        $this->fungsi->check_previleges('brand');
        $data['brand'] = $this->m_brand->getData();
        $this->load->view('master/brand/v_brand_list', $data);
    }

    public function form($param = '')
    {
        $content   = "<div id='divsubcontent'></div>";
        $header    = "Form Master brand";
        $subheader = "brand";
        $buttons[]          = button('jQuery.facebox.close()', 'Tutup', 'btn btn-default', 'data-dismiss="modal"');
        echo $this->fungsi->parse_modal($header, $subheader, $content, $buttons, "");
        if ($param == 'base') {
            $this->fungsi->run_js('load_silent("master/brand/show_addForm/","#divsubcontent")');
        } else {
            $base_kom = $this->uri->segment(5);
            $this->fungsi->run_js('load_silent("master/brand/show_editForm/' . $base_kom . '","#divsubcontent")');
        }
    }

    public function show_addForm()
    {
        $this->fungsi->check_previleges('brand');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'brand',
                'label' => 'brand',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['status'] = '';
            $data['jenis_item'] = $this->db->get('master_jenis_item');
            $data['kabupaten'] = $this->db->get('kabupaten');
            $this->load->view('master/brand/v_brand_add', $data);
        } else {
            $datapost = get_post_data(array('brand'));
            $this->m_brand->insertData($datapost);
            $this->fungsi->run_js('load_silent("master/brand","#content")');
            $this->fungsi->message_box("Data Master brand sukses disimpan...", "success");
            $this->fungsi->catat($datapost, "Menambah Master brand dengan data sbb:", true);
        }
    }

    public function show_editForm($id = '')
    {
        $this->fungsi->check_previleges('brand');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'id',
                'label' => 'wes mbarke',
                'rules' => ''
            ),
            array(
                'field' => 'brand',
                'label' => 'brand',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['jenis_item'] = $this->db->get('master_jenis_item');
            $data['kabupaten'] = $this->db->get('kabupaten');
            $data['edit'] = $this->db->get_where('master_brand', array('id' => $id));
            $this->load->view('master/brand/v_brand_edit', $data);
        } else {
            $datapost = get_post_data(array('id', 'brand'));

            $this->m_brand->updateData($datapost);
            $this->fungsi->run_js('load_silent("master/brand","#content")');
            $this->fungsi->message_box("Data Master brand sukses diperbarui...", "success");
            $this->fungsi->catat($datapost, "Mengedit Master brand dengan data sbb:", true);
        }
    }
}

/* End of file brand.php */
/* Location: ./application/controllers/master/brand.php */