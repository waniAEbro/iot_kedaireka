<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_barang extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('master/m_jenis_barang');
	}

	public function index()
	{
		$this->fungsi->check_previleges('jenis_barang');
		$data['jenis_barang'] = $this->m_jenis_barang->getData();
		$this->load->view('master/jenis_barang/v_jenis_barang_list',$data);
	}

	public function form($param='')
	{
		$content   = "<div id='divsubcontent'></div>";
		$header    = "Form Master jenis_barang";
		$subheader = "jenis_barang";
		$buttons[] = button('jQuery.facebox.close()','Tutup','btn btn-default','data-dismiss="modal"');
		echo $this->fungsi->parse_modal($header,$subheader,$content,$buttons,"");
		if($param=='base'){
			$this->fungsi->run_js('load_silent("master/jenis_barang/show_addForm/","#divsubcontent")');	
		}else{
			$base_kom=$this->uri->segment(5);
			$this->fungsi->run_js('load_silent("master/jenis_barang/show_editForm/'.$base_kom.'","#divsubcontent")');	
		}
	}

	public function show_addForm()
	{
		$this->fungsi->check_previleges('jenis_barang');
		$this->load->library('form_validation');
		$config = array(
				array(
					'field'	=> 'jenis_barang',
					'label' => 'jenis_barang',
					'rules' => 'required'
				)
			);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['status']='';
			$this->load->view('master/jenis_barang/v_jenis_barang_add',$data);
		}
		else
		{
			$datapost = get_post_data(array('jenis_barang'));
			$this->m_jenis_barang->insertData($datapost);
			$this->fungsi->run_js('load_silent("master/jenis_barang","#content")');
			$this->fungsi->message_box("Data Master Jenis Barang sukses disimpan...","success");
			$this->fungsi->catat($datapost,"Menambah Master Jenis Barang dengan data sbb:",true);
		}
	}

	public function show_editForm($id='')
	{
		$this->fungsi->check_previleges('jenis_barang');
		$this->load->library('form_validation');
		$config = array(
				array(
					'field'	=> 'id',
					'label' => 'wes mbarke',
					'rules' => ''
				),
				array(
					'field'	=> 'jenis_barang',
					'label' => 'jenis_barang',
					'rules' => 'required'
				)
			);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['edit'] = $this->db->get_where('master_jenis_barang',array('id'=>$id));
			$this->load->view('master/jenis_barang/v_jenis_barang_edit',$data);
		}
		else
		{
			$datapost = get_post_data(array('id','jenis_barang'));
			$this->m_jenis_barang->updateData($datapost);
			$this->fungsi->run_js('load_silent("master/jenis_barang","#content")');
			$this->fungsi->message_box("Data Master Jenis Barang sukses diperbarui...","success");
			$this->fungsi->catat($datapost,"Mengedit Master Jenis Barang dengan data sbb:",true);
		}
	}

}

/* End of file jenis_barang.php */
/* Location: ./application/controllers/master/jenis_barang.php */