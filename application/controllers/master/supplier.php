<?php
defined('BASEPATH') or exit('No direct script access allowed');

class supplier extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->fungsi->restrict();
        $this->load->model('master/m_supplier');
    }

    public function index()
    {
        $this->fungsi->check_previleges('supplier');
        $data['supplier'] = $this->m_supplier->getData();
        $this->load->view('master/supplier/v_supplier_list', $data);
    }

    public function form($param = '')
    {
        $content   = "<div id='divsubcontent'></div>";
        $header    = "Form Master supplier";
        $subheader = "supplier";
        $buttons[]          = button('jQuery.facebox.close()', 'Tutup', 'btn btn-default', 'data-dismiss="modal"');
        echo $this->fungsi->parse_modal($header, $subheader, $content, $buttons, "");
        if ($param == 'base') {
            $this->fungsi->run_js('load_silent("master/supplier/show_addForm/","#divsubcontent")');
        } else {
            $base_kom = $this->uri->segment(5);
            $this->fungsi->run_js('load_silent("master/supplier/show_editForm/' . $base_kom . '","#divsubcontent")');
        }
    }

    public function show_addForm()
    {
        $this->fungsi->check_previleges('supplier');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'supplier',
                'label' => 'supplier',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['status'] = '';
            $data['jenis_item'] = $this->db->get('master_jenis_item');
            $data['kabupaten'] = $this->db->get('kabupaten');
            $this->load->view('master/supplier/v_supplier_add', $data);
        } else {
            $datapost = get_post_data(array('kode', 'supplier', 'alamat'));
            $this->m_supplier->insertData($datapost);
            $this->fungsi->run_js('load_silent("master/supplier","#content")');
            $this->fungsi->message_box("Data Master supplier sukses disimpan...", "success");
            $this->fungsi->catat($datapost, "Menambah Master supplier dengan data sbb:", true);
        }
    }

    public function show_editForm($id = '')
    {
        $this->fungsi->check_previleges('supplier');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'id',
                'label' => 'wes mbarke',
                'rules' => ''
            ),
            array(
                'field' => 'supplier',
                'label' => 'supplier',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['jenis_item'] = $this->db->get('master_jenis_item');
            $data['kabupaten'] = $this->db->get('kabupaten');
            $data['edit'] = $this->db->get_where('master_supplier', array('id' => $id));
            $this->load->view('master/supplier/v_supplier_edit', $data);
        } else {
            $datapost = get_post_data(array('id', 'kode', 'supplier', 'alamat'));

            $this->m_supplier->updateData($datapost);
            $this->fungsi->run_js('load_silent("master/supplier","#content")');
            $this->fungsi->message_box("Data Master supplier sukses diperbarui...", "success");
            $this->fungsi->catat($datapost, "Mengedit Master supplier dengan data sbb:", true);
        }
    }
}

/* End of file supplier.php */
/* Location: ./application/controllers/master/supplier.php */