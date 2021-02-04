<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class komplain extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('klg/m_komplain');
	}

	public function index()
	{
		$this->fungsi->check_previleges('komplain');
		$data['komplain'] = $this->m_komplain->getData();
		$this->load->view('klg/komplain/v_komplain_list',$data);
	}

	public function form($param='')
	{
		$content   = "<div id='divsubcontent'></div>";
		$header    = "Form Master komplain";
		$subheader = "Komplain";
		$buttons[] = button('jQuery.facebox.close()','Tutup','btn btn-default','data-dismiss="modal"');
		echo $this->fungsi->parse_modal($header,$subheader,$content,$buttons,"");
		if($param=='base'){
			$this->fungsi->run_js('load_silent("klg/komplain/show_addForm/","#divsubcontent")');	
		}else{
			$base_kom=$this->uri->segment(5);
			$this->fungsi->run_js('load_silent("klg/komplain/show_editForm/'.$base_kom.'","#divsubcontent")');	
		}
	}

	public function show_addForm()
	{
		$this->fungsi->check_previleges('komplain');
		$this->load->library('form_validation');
		$config = array(
				array(
					'field'	=> 'komplain',
					'label' => 'komplain',
					'rules' => 'required'
				)
			);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['status']='';
			$this->load->view('klg/komplain/v_komplain_add',$data);
		}
		else
		{
			$datapost = get_post_data(array('kepada','perihal','komplain'));
			$this->m_komplain->insertData($datapost);
			$this->fungsi->run_js('load_silent("klg/komplain","#content")');
			$this->fungsi->message_box("Data Master komplain sukses disimpan...","success");
			$this->fungsi->catat($datapost,"Menambah Master komplain dengan data sbb:",true);
		}
	}

	public function show_editForm($id='')
	{
		$this->fungsi->check_previleges('komplain');
		$this->load->library('form_validation');
		$config = array(
				array(
					'field'	=> 'id',
					'label' => 'wes mbarke',
					'rules' => ''
				),
				array(
					'field'	=> 'komplain',
					'label' => 'komplain',
					'rules' => 'required'
				)
			);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['edit'] = $this->db->get_where('master_komplain',array('id'=>$id));
			$this->load->view('klg/komplain/v_komplain_edit',$data);
		}
		else
		{
			$datapost = get_post_data(array('id','kepada','perihal','komplain'));
			$this->m_komplain->updateData($datapost);
			$this->fungsi->run_js('load_silent("klg/komplain","#content")');
			$this->fungsi->message_box("Data Master komplain sukses diperbarui...","success");
			$this->fungsi->catat($datapost,"Mengedit Master komplain dengan data sbb:",true);
		}
	}

}

/* End of file komplain.php */
/* Location: ./application/controllers/klg/komplain.php */