<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bom extends CI_Controller {

	public function index()
	{
		$this->load->view('warehouse/bom/v_bom_list');
	}

}

/* End of file bom.php */
/* Location: ./application/controllers/warehose/bom.php */