<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mapping extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('klg/m_mapping');
	}

	public function index()
	{
		$this->fungsi->check_previleges('mapping');
		$data['mapping'] = $this->m_mapping->getData();
		$this->load->view('klg/mapping/v_mapping_list',$data);
	}

	public function form($param='')
	{
		$content   = "<div id='divsubcontent'></div>";
		$header    = "Form mapping";
		$subheader = "mapping";
		$buttons[] = button('','Tutup','btn btn-default','data-dismiss="modal"');
		echo $this->fungsi->parse_modal($header,$subheader,$content,$buttons,"");
		if($param=='base'){
			$this->fungsi->run_js('load_silent("klg/mapping/show_addForm/","#divsubcontent")');	
		}else{
			$base_kom=$this->uri->segment(5);
			$this->fungsi->run_js('load_silent("klg/mapping/show_editForm/'.$base_kom.'","#divsubcontent")');	
		}
	}

	public function show_addForm()
	{
		$this->fungsi->check_previleges('mapping');
		$this->load->library('form_validation');
		$config = array(
				array(
					'field'	=> 'item',
					'label' => '-',
					'rules' => 'required'
				),
			);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['item'] = $this->db->get('master_item');
			$data['warna'] = $this->db->get('master_warna');
			$this->load->view('klg/mapping/v_mapping_add',$data);
		}
		else
		{
			$datapost = array(
				'id_item' => $this->input->post('item'),
				'id_warna' => $this->input->post('warna'),
				'harga_jabotabek' => $this->input->post('harga_jabotabek'),
				'harga_dalam_pulau' => $this->input->post('harga_dalam_pulau'),
				'harga_luar_pulau' => $this->input->post('harga_luar_pulau'),
				);
			$this->m_mapping->insertData($datapost);
			$this->fungsi->run_js('load_silent("klg/mapping","#content")');
			$this->fungsi->message_box("Data mapping sukses disimpan...","success");
			$this->fungsi->catat($datapost,"Menambah mapping dengan data sbb:",true);
		}
	}

	public function show_editForm($id='')
	{
		$this->fungsi->check_previleges('mapping');
		$this->load->library('form_validation');
		$config = array(
				array(
					'field'	=> 'id',
					'label' => 'wes mbarke',
					'rules' => ''
				),
				array(
					'field'	=> 'item',
					'label' => '-',
					'rules' => 'required'
				),
			);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['edit'] = $this->db->get_where('data_mapping',array('id'=>$id));
			$data['item'] = $this->db->get('master_item');
			$data['warna'] = $this->db->get('master_warna');
			$this->load->view('klg/mapping/v_mapping_edit',$data);
		}
		else
		{
			$datapost = array(
				'id' => $this->input->post('id'),
				'id_item' => $this->input->post('item'),
				'id_warna' => $this->input->post('warna'),
				'harga_jabotabek' => $this->input->post('harga_jabotabek'),
				'harga_dalam_pulau' => $this->input->post('harga_dalam_pulau'),
				'harga_luar_pulau' => $this->input->post('harga_luar_pulau'),
				);
			$this->m_mapping->insertData($datapost,false);
			$this->fungsi->run_js('load_silent("klg/mapping","#content")');
			$this->fungsi->message_box("Data mapping sukses diperbarui...","success");
			$this->fungsi->catat($datapost,"Mengedit mapping dengan data sbb:",true);
		}
	}

	public function delete($id)
	{
		$this->fungsi->check_previleges('mapping');
		if($id == '' || !is_numeric($id)) die;
		$this->m_mapping->deleteData($id);
		$this->fungsi->run_js('load_silent("klg/mapping","#content")');
		$this->fungsi->message_box("Data mapping berhasil dihapus...","notice");
		$this->fungsi->catat("Menghapus laporan dengan id ".$id);
	}

}

/* End of file mapping.php */
/* Location: ./application/controllers/klg/mapping.php */