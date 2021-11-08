<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Finance extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->fungsi->restrict();
        $this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
        $this->load->model('klg/m_finance');
    }

    public function index()
    {
        $this->fungsi->check_previleges('finance');
        $data['finance']    = $this->m_finance->getData();
        $this->load->view('klg/finance/v_finance_list', $data);
    }
}

/* End of file finance.php */
/* Location: ./application/controllers/klg/finance.php */