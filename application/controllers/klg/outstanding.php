<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Outstanding extends CI_Controller {

	public function index()
	{
		$this->load->view('klg/outstanding/v_outstanding_list');
	}

}

/* End of file outstanding.php */
/* Location: ./application/controllers/klg/outstanding.php */