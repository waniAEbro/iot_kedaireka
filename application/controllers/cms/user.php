<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('cms/m_user');
	}

	public function index()
	{
		$this->fungsi->check_previleges('user');
		$data['user'] = $this->m_user->getList();
		$this->load->view('cms/user/v_user_list',$data);
	}


	public function formadd($value='')
	{
		$this->fungsi->check_previleges('user');
		$data['level']  = $this->db->get_where('master_level',array('id !='=>'1'));
		$data['store']  = $this->db->get('master_store');
		$this->load->view('cms/user/v_user_addd',$data);
	}

	public function insert($value='')
	{
		$user = $this->input->post('username');
		$cekuser = $this->m_user->cekuser($user);
		if ($cekuser>0) {
			$data['sts'] = "no";
			$data['msg'] = "username sudah ada!";
		} else {
			$pass_en  = $this->db->query("SELECT PASSWORD('".$this->input->post('password')."') as pass")->row()->pass;
			$datapost = array(
				'nama'     => $this->input->post('nama'), 
				'username' => $this->input->post('username'), 
				'password' => $pass_en, 
				'level'    => $this->input->post('level'), 
				'id_store' => $this->input->post('id_store'), 
				'no_hp'    => $this->input->post('no_hp'), 
				'alamat'   => $this->input->post('alamat'),
			);
			$this->m_user->insertData($datapost);
			$this->fungsi->catat($datapost,"Menambah Master user dengan data sbb:",true);
			$data['sts'] = "yes";
			$data['msg'] = "user Baru Disimpan....";
		}
		echo json_encode($data);
	}


	public function formedit($id='')
	{
		$data['edit'] = $this->db->get_where('cms_user',array('id'=>$id));
		$data['store']  = $this->db->get('master_store');
		$data['level']= $this->db->get_where('master_level',array('id !='=>'1'));
		$this->load->view('cms/user/v_user_editt',$data);
	}

	public function formedituser($id='')
	{
		$data['edit'] = $this->db->get_where('cms_user',array('id'=>$id));
		$data['store']  = $this->db->get('master_store');
		$data['level']= $this->db->get_where('master_level',array('id !='=>'1'));
		$this->load->view('cms/user/v_user_edit_user',$data);
	}

	public function edit($id='')
	{
		$user = $this->input->post('username');
		$userada = $this->m_user->getrowuser($id);
		if ($userada == $this->input->post('username')) {
			if ($this->input->post('password')=='') {
					$datapost = array(
					'id'       => $this->input->post('id'), 
					'nama'     => $this->input->post('nama'), 
					'username' => $this->input->post('username'), 
					'level'    => $this->input->post('level'),
					'no_hp'    => $this->input->post('no_hp'), 
					'alamat'   => $this->input->post('alamat'), 
					);
				} else {
					$pass_en  = $this->db->query("SELECT PASSWORD('".$this->input->post('password')."') as pass")->row()->pass;
					$datapost = array(
					'id'       => $this->input->post('id'),
					'nama'     => $this->input->post('nama'), 
					'username' => $this->input->post('username'), 
					'password' => $pass_en, 
					'level'    => $this->input->post('level'), 
					'no_hp'    => $this->input->post('no_hp'), 
					'alamat'   => $this->input->post('alamat'), 
					);
				}
				$this->m_user->insertData($datapost,false);
				$this->fungsi->catat($datapost,"Mengubah user dengan data sbb:",true);
				$data['sts'] = "yes";
				$data['msg'] = "user Diperbarui....";
		} else {
			
		
			$cekuser = $this->m_user->cekuser($user);
			if ($cekuser>0 ) {
				$data['sts'] = "no";
				$data['msg'] = "username sudah ada!";
			} else {
				if ($this->input->post('password')=='') {
					$datapost = array(
					'id'       => $this->input->post('id'), 
					'nama'     => $this->input->post('nama'), 
					'username' => $this->input->post('username'), 
					'level'    => $this->input->post('level'),
					'no_hp'    => $this->input->post('no_hp'), 
					'alamat'   => $this->input->post('alamat'), 
					);
				} else {
					$pass_en  = $this->db->query("SELECT PASSWORD('".$this->input->post('password')."') as pass")->row()->pass;
					$datapost = array(
					'id'       => $this->input->post('id'),
					'nama'     => $this->input->post('nama'), 
					'username' => $this->input->post('username'), 
					'password' => $pass_en, 
					'level'    => $this->input->post('level'), 
					'no_hp'    => $this->input->post('no_hp'), 
					'alamat'   => $this->input->post('alamat'), 
					);
				}
				$this->m_user->insertData($datapost,false);
				$this->fungsi->catat($datapost,"Mengubah user dengan data sbb:",true);
				$data['sts'] = "yes";
				$data['msg'] = "user Diperbarui....";
			}
		}
		echo json_encode($data);
	}



	
	
	public function delete($id)
	{
		$this->fungsi->check_previleges('user');
		if($id == '' || !is_numeric($id)) die;
		$this->m_user->deleteData($id);
		$this->fungsi->run_js('load_silent("cms/user","#content")');
		$this->fungsi->message_box("Data Master user berhasil dihapus...","notice");
		$this->fungsi->catat("Menghapus laporan dengan id ".$id);
	}

}

/* End of file user.php */
/* Location: ./application/controllers/cms/user.php */