<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bom_temp extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->fungsi->restrict();
        $this->load->model('klg/m_fppp');
    }

    public function index()
    {
        $this->fungsi->check_previleges('bom_temp');
        $data['bomtemp']  = $this->m_fppp->getBomTemp();
        $this->load->view('klg/fppp/v_bom_temp', $data);
    }

    public function hapus($id)
    {
        $this->fungsi->check_previleges('bom_temp');
        $data = array('id' => $id,);

        $this->db->where('id', $id);
        $this->db->delete('data_temp');


        $this->fungsi->run_js('load_silent("klg/bom_temp","#content")');
        $this->fungsi->message_box("Menghapus Item", "success");
        $this->fungsi->catat($data, "Menghapus data temp data sbb:", true);
    }
}

/* End of file fppp.php */
/* Location: ./application/controllers/klg/fppp.php */