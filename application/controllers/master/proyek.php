<?php
defined('BASEPATH') or exit('No direct script access allowed');

class proyek extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->fungsi->restrict();
        $this->load->model('master/m_proyek');
    }

    public function index()
    {
        $this->fungsi->check_previleges('proyek');
        $data['proyek'] = $this->m_proyek->getData();
        $this->load->view('master/proyek/v_proyek_list', $data);
    }

    public function form($param = '')
    {
        $content   = "<div id='divsubcontent'></div>";
        $header    = "Form Master proyek";
        $subheader = "proyek";
        $buttons[]          = button('', 'Tutup', 'btn btn-default', 'data-dismiss="modal"');
        echo $this->fungsi->parse_modal($header, $subheader, $content, $buttons, "");
        if ($param == 'base') {
            $this->fungsi->run_js('load_silent("master/proyek/show_addForm/","#divsubcontent")');
        } else {
            $base_kom = $this->uri->segment(5);
            $this->fungsi->run_js('load_silent("master/proyek/show_editForm/' . $base_kom . '","#divsubcontent")');
        }
    }

    public function show_addForm()
    {
        $this->fungsi->check_previleges('proyek');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'kode_proyek',
                'label' => 'kode_proyek',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['jenis_item'] = $this->db->get('master_jenis_item');
            $this->load->view('master/proyek/v_proyek_add', $data);
        } else {
            $cek = $this->m_proyek->cekKode($this->input->post('kode_proyek'));
            if ($cek == 0) {
                $datapost = get_post_data(array('kode_proyek', 'nama_proyek'));
                $this->m_proyek->insertData($datapost);
                $this->fungsi->run_js('load_silent("master/proyek","#content")');
                $this->fungsi->message_box("Data Master proyek sukses disimpan...", "success");
                $this->fungsi->catat($datapost, "Menambah Master proyek dengan data sbb:", true);
            } else {
                $this->fungsi->run_js('load_silent("master/proyek","#content")');
                $this->fungsi->message_box("Kode Sudah Ada", "warning");
            }
        }
    }

    public function show_editForm($id = '')
    {
        $this->fungsi->check_previleges('proyek');
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'id',
                'label' => 'wes mbarke',
                'rules' => ''
            ),
            array(
                'field' => 'kode_proyek',
                'label' => 'kode_proyek',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $data['edit'] = $this->db->get_where('master_proyek', array('id' => $id));
            $this->load->view('master/proyek/v_proyek_edit', $data);
        } else {
            $datapost = get_post_data(array('id', 'kode_proyek', 'nama_proyek'));

            $this->m_proyek->updateData($datapost);
            $this->fungsi->run_js('load_silent("master/proyek","#content")');
            $this->fungsi->message_box("Data Master proyek sukses diperbarui...", "success");
            $this->fungsi->catat($datapost, "Mengedit Master proyek dengan data sbb:", true);
        }
    }
}

/* End of file proyek.php */
/* Location: ./application/controllers/master/proyek.php */