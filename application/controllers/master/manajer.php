<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manajer extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('master/m_manajer');
	}

	public function index()
	{
		$this->fungsi->check_previleges('manajer');
		$data['manajer'] = $this->m_manajer->getData();
		$this->load->view('master/manajer/v_manajer_list',$data);
	}

	public function show_editForm($id='')
	{
		$this->fungsi->check_previleges('user');
		$this->load->library('form_validation');
		$config = array(
				array(
					'field'	=> 'id',
					'label' => 'wes mbarke',
					'rules' => ''
				),
				array(
					'field'	=> 'email',
					'label' => 'Kode Komponen',
					'rules' => 'required'
				),
				
			);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['edit'] = $this->db->get_where('cms_user',array('id'=>$id));
			$data['level']=get_options($this->db->query('select id, level from master_level where id>1 AND id<4'),true);
			$this->load->view('master/manajer/v_manajer_edit',$data);
		}
		else
		{
				$id       = $this->input->post('id'); 
			$datapost = array(
				'level'     => $this->input->post('level'),
				'email'     => $this->input->post('email'),
				);
			
		      	
			$this->m_manajer->update($datapost,$id);
			$this->fungsi->catat($datapost,"Mengubah email manajer dengan data sbb:",true);
			$data['msg'] = "email manajer Diperbarui....";
			echo json_encode($data);
		}
	}

}

/* End of file manajer.php */
/* Location: ./application/controllers/master/manajer.php */