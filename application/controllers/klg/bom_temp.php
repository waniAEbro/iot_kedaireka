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
}

/* End of file fppp.php */
/* Location: ./application/controllers/klg/fppp.php */