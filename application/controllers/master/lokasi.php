<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lokasi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('master/m_lokasi');
	}

	public function index()
	{
		$this->fungsi->check_previleges('lokasi');
		$data['lokasi'] = $this->m_lokasi->getData();
		$this->load->view('master/lokasi/v_lokasi_list',$data);
	}

	public function form($param='')
	{
		$content   = "<div id='divsubcontent'></div>";
		$header    = "Form Master lokasi";
		$subheader = "lokasi";
		$buttons[] = button('jQuery.facebox.close()','Tutup','btn btn-default','data-dismiss="modal"');
		echo $this->fungsi->parse_modal($header,$subheader,$content,$buttons,"");
		if($param=='base'){
			$this->fungsi->run_js('load_silent("master/lokasi/show_addForm/","#divsubcontent")');	
		}else{
			$base_kom=$this->uri->segment(5);
			$this->fungsi->run_js('load_silent("master/lokasi/show_editForm/'.$base_kom.'","#divsubcontent")');	
		}
	}

	public function show_addForm()
	{
		$this->fungsi->check_previleges('lokasi');
		$this->load->library('form_validation');
		$config = array(
				array(
					'field'	=> 'lokasi',
					'label' => 'lokasi',
					'rules' => 'required'
				)
			);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['status']='';
			$this->load->view('master/lokasi/v_lokasi_add',$data);
		}
		else
		{
			$datapost = get_post_data(array('lokasi'));
			$this->m_lokasi->insertData($datapost);
			$this->fungsi->run_js('load_silent("master/lokasi","#content")');
			$this->fungsi->message_box("Data Master lokasi sukses disimpan...","success");
			$this->fungsi->catat($datapost,"Menambah Master lokasi dengan data sbb:",true);
		}
	}

	public function show_editForm($id='')
	{
		$this->fungsi->check_previleges('lokasi');
		$this->load->library('form_validation');
		$config = array(
				array(
					'field'	=> 'id',
					'label' => 'wes mbarke',
					'rules' => ''
				),
				array(
					'field'	=> 'lokasi',
					'label' => 'lokasi',
					'rules' => 'required'
				)
			);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['edit'] = $this->db->get_where('master_lokasi',array('id'=>$id));
			$this->load->view('master/lokasi/v_lokasi_edit',$data);
		}
		else
		{
			$datapost = get_post_data(array('id','lokasi'));
			$this->m_lokasi->updateData($datapost);
			$this->fungsi->run_js('load_silent("master/lokasi","#content")');
			$this->fungsi->message_box("Data Master lokasi sukses diperbarui...","success");
			$this->fungsi->catat($datapost,"Mengedit Master lokasi dengan data sbb:",true);
		}
	}

}

/* End of file lokasi.php */
/* Location: ./application/controllers/master/lokasi.php */