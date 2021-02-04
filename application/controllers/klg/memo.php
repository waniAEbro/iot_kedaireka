<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// require '/var/www/html/vendor/autoload.php';
// use Mailgun\Mailgun;

class Memo extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('klg/m_memo');
		$this->load->model('klg/m_invoice');

	}

	public function index()
	{
		$this->fungsi->check_previleges('memo');
		$data['memo'] = $this->m_memo->getData();
		$this->load->view('klg/memo/v_memo_list',$data);
	}

	public function permintaan($id='')
	{
		$this->fungsi->check_previleges('memo');
		$getRowMemo = $this->m_memo->getRowMemo($id);

		$datamemo = array(
			'id_brand'       => 1,  
			'no_invoice'     => $getRowMemo->no_memo, 
			'no_po'          => '',
			'project_owner'  => '',
			'id_store'       => $getRowMemo->id_store, 
			'alamat_proyek'  => $getRowMemo->alamat_project, 
			'no_telp'        => '', 
			'tgl_pengiriman' => $getRowMemo->deadline_pengambilan, 
			'intruction'     => $getRowMemo->alasan, 
			'lampiran'       => '',
			'date'      	 => date('Y-m-d H:i:s'),  
			);
	    $this->m_invoice->insertInvoice($datamemo);
		$id_invoice = $this->db->insert_id();
		$this->fungsi->catat($datamemo,"Menyimpan Permintaan dari memo sbb:",true);

		$getRowMemoDetail = $this->m_memo->getRowMemoDetail($id);

		foreach ($getRowMemoDetail->result() as $key) {
			$datapost = array(
			'id_invoice' => $id_invoice, 
			'id_tipe'    => $key->id_tipe, 
			'id_item'    => $key->id_item, 
			'id_warna'   => $key->id_warna, 
			'bukaan'     => $key->bukaan,
			'lebar'      => $key->lebar, 
			'tinggi'     => $key->tinggi, 
			'qty'        => 1, 
			'keterangan' => $key->keterangan, 
			'harga'      => 0, 
			'date'       => date('Y-m-d H:i:s'), 
		 );
		 
	    $this->m_invoice->insertInvoiceDetail($datapost);
	    $this->fungsi->catat($datapost,"Menyimpan detail Invoice dari memo sbb:",true);
		}


		$this->m_memo->updateStatusMemo($id);
		$this->fungsi->run_js('load_silent("klg/memo","#content")');
		$this->fungsi->message_box("menambahkan ke Permintaan berhasil","success");

	}

	public function formAdd($value='')
	{
		$this->fungsi->check_previleges('memo');
		$data = array(
			'tipe_memo'  => $this->db->get('master_tipe')->result(),
			'nomor_memo' => str_pad($this->m_memo->getmemo(), 3, '0', STR_PAD_LEFT).'/memo'.'/'.date('m').'/'.date('Y'),
			'item'       => $this->db->get('master_item')->result(),
			'warna'      => $this->db->get('master_warna')->result(),
			'alasan'     => $this->db->get('master_alasan')->result(),
			'store'      => $this->db->get('master_store')->result(),
			 );
		$this->load->view('klg/memo/v_memo_add',$data);
	}

	public function formEdit($value='')
	{
		$this->fungsi->check_previleges('memo');
		$data = array(
			'row'       => $this->m_memo->getEdit($value)->row(),
			'detail'    => $this->m_memo->getDataDetailTabel($value),
			'tipe_memo' => $this->db->get('master_tipe')->result(),
			'item'      => $this->db->get('master_item')->result(),
			'warna'     => $this->db->get('master_warna')->result(),
			'alasan'    => $this->db->get('master_alasan')->result(),
			'store'     => $this->db->get('master_store')->result(),
			 );
		$this->load->view('klg/memo/v_memo_edit',$data);
	}

	public function savememo($value='')
	{
		$this->fungsi->check_previleges('memo');
	  	$datapost = array(
			'id_store'             => $this->input->post('id_store'), 
			'no_memo'              => $this->input->post('no_memo'), 
			'nama_project'         => $this->input->post('nama_project'),  
			'alamat_project'       => $this->input->post('alamat_project'),
			'tgl_memo'             => $this->input->post('tgl_memo'),
			'deadline_pengambilan' => $this->input->post('deadline_pengambilan'), 
			'no_fppp'              => $this->input->post('no_fppp'),
			'charge'              => $this->input->post('charge'),
			'alasan'              => $this->input->post('alasan'),
			'lampiran'             => '', 		
			);
	    $this->m_memo->insertmemo($datapost);
	    $data['id'] = $this->db->insert_id();
		$this->fungsi->catat($datapost,"Menyimpan memo sbb:",true);
		$data['msg'] = "memo Disimpan";
		echo json_encode($data);
	}

	public function savememoImage($value='')
	{
		$this->fungsi->check_previleges('memo');
		$upload_folder = get_upload_folder('./files/');

		$config['upload_path']   = $upload_folder;
		$config['allowed_types'] = 'pdf';
		$config['max_size']      = '3072';
		// $config['max_width']     = '1024';
		// $config['max_height']    = '1024';
		$config['encrypt_name']  = true;

	    $this->load->library('upload', $config);
	    $err = "";
	    $msg = "";
	    if ( ! $this->upload->do_upload('lampiran'))
	    {
	      $err = $this->upload->display_errors('<span class="error_string">','</span>');
	    }
	    else
	    {
	      $data = $this->upload->data();
	      
	      	$datapost = array(
		      	'id_store'             => $this->input->post('id_store'), 
				'no_memo'              => $this->input->post('no_memo'), 
				'nama_project'         => $this->input->post('nama_project'),  
				'alamat_project'       => $this->input->post('alamat_project'),
				'tgl_memo'             => $this->input->post('tgl_memo'),
				'deadline_pengambilan' => $this->input->post('deadline_pengambilan'), 
				'no_fppp'              => $this->input->post('no_fppp'),
				'charge'              => $this->input->post('charge'),
				'alasan'              => $this->input->post('alasan'),
				'lampiran'       => substr($upload_folder,2).$data['file_name'],
				);
	        $this->m_memo->insertmemo($datapost);
	        $data['id'] = $this->db->insert_id();
			$this->fungsi->catat($datapost,"Menyimpan memo sbb:",true);
			$data['msg'] = "memo Disimpan";
			echo json_encode($data);
			
	    }
	}

	public function updatememo($value='')
	{
		$this->fungsi->check_previleges('memo');
		$id_memo = $this->input->post('id_memo');
	  	$datapost = array(
			'id_store'             => $this->input->post('id_store'), 
			'no_memo'              => $this->input->post('no_memo'), 
			'nama_project'         => $this->input->post('nama_project'),  
			'alamat_project'       => $this->input->post('alamat_project'),
			'tgl_memo'             => $this->input->post('tgl_memo'),
			'deadline_pengambilan' => $this->input->post('deadline_pengambilan'), 
			'no_fppp'              => $this->input->post('no_fppp'),
			'lampiran'       => '',
			'charge'              => $this->input->post('charge'),
			'alasan'              => $this->input->post('alasan'), 		
			);
	    $this->m_memo->updatememo($id_memo,$datapost);
	    $data['id'] = $this->db->insert_id();
		$this->fungsi->catat($datapost,"Mengupdate memo sbb:",true);
		$data['msg'] = "memo Diupdate";
		echo json_encode($data);
	}

	public function updatememoImage($value='')
	{
		$this->fungsi->check_previleges('memo');
		$upload_folder = get_upload_folder('./files/');

		$config['upload_path']   = $upload_folder;
		$config['allowed_types'] = 'pdf';
		$config['max_size']      = '3072';
		// $config['max_width']     = '1024';
		// $config['max_height']    = '1024';
		$config['encrypt_name']  = true;

	    $this->load->library('upload', $config);
	    $err = "";
	    $msg = "";
	    if ( ! $this->upload->do_upload('lampiran'))
	    {
	      $err = $this->upload->display_errors('<span class="error_string">','</span>');
	    }
	    else
	    {
	      $data = $this->upload->data();
	      $id_memo = $this->input->post('id_memo');
	      	$datapost = array(
		      	'id_store'             => $this->input->post('id_store'), 
				'no_memo'              => $this->input->post('no_memo'), 
				'nama_project'         => $this->input->post('nama_project'),  
				'alamat_project'       => $this->input->post('alamat_project'),
				'tgl_memo'             => $this->input->post('tgl_memo'),
				'deadline_pengambilan' => $this->input->post('deadline_pengambilan'), 
				'no_fppp'              => $this->input->post('no_fppp'),
				'charge'              => $this->input->post('charge'),
				'alasan'              => $this->input->post('alasan'),
				'lampiran'       => substr($upload_folder,2).$data['file_name'],
				);
	        $this->m_memo->updatememo($id_memo,$datapost);
	        $data['id'] = $this->db->insert_id();
			$this->fungsi->catat($datapost,"Mengupdate memo sbb:",true);
			$data['msg'] = "memo Diupdate";
			echo json_encode($data);
			
	    }
	}

	public function savememoDetail($value='')
	{
		$this->fungsi->check_previleges('memo');
	  	$datapost = array(
			'id_memo'          => $this->input->post('id_memo'), 
			'id_tipe'          => $this->input->post('tipe_memo'), 
			'id_item'          => $this->input->post('item'), 
			'id_warna'         => $this->input->post('warna'), 
			'bukaan'           => $this->input->post('bukaan'),
			'lebar'            => $this->input->post('lebar'), 
			'tinggi'           => $this->input->post('tinggi'),
			'ada_di_wo'        => $this->input->post('ada_di_wo'),
			'id_alasan'        => $this->input->post('id_alasan'),
			'charge'           => $this->input->post('charge'),
			'brg_dikembalikan' => $this->input->post('brg_dikembalikan'),
			'keterangan'       => $this->input->post('keterangan'),
			'date'             => date('Y-m-d'), 
 		);
	    $this->m_memo->insertmemoDetail($datapost);
	    $data['id'] = $this->db->insert_id();
		$this->fungsi->catat($datapost,"Menyimpan detail memo sbb:",true);
		$data['msg'] = "memo Disimpan";
		echo json_encode($data);
	}

	public function deleteItem() {
		$this->fungsi->check_previleges('memo');
		$id = $this->input->post('id');
		$data = array('id' => $id, );
		
		$this->m_memo->deleteDetailItem($id);
		$this->fungsi->catat($data,"Menghapus memo Detail dengan data sbb:",true);
		$respon = ['msg' => 'Data Berhasil Dihapus'];
		echo json_encode($respon);
	}

	public function getDetailTabel($value='')
	{
		$this->fungsi->check_previleges('memo');
		$id_sku = $this->input->post('id_sku');
		$data['detail'] = $this->m_memo->getDataDetailTabel($id_sku);
		echo json_encode($data);
	}

















	public function getAlamat()
	{
		$this->fungsi->check_previleges('memo');
		$id = $this->input->post('buyer');
		$currency = $this->m_memo->currencyProdukBuyer($id)->currency;

		if ($currency == '1') {
			$mata_uang = 'IDR';
		} elseif ($currency == '2') {
			$mata_uang = 'USD';
		} elseif ($currency == '3') {
			$mata_uang = 'EUR';
		} else {
			$mata_uang = 'GPB';
		}

		$data['currency'] = $mata_uang;
		$data['alamat'] = $this->m_memo->alamatBuyer($id);

		echo json_encode($data);
	}

	public function getGambar()
	{
		$this->fungsi->check_previleges('memo');
		$id = $this->input->post('produk');
		$currency = $this->m_memo->gambarProduk($id)->nama_currency;
		
		$data['size'] = $this->m_memo->gambarProduk($id)->size;
		$data['grade'] = $this->m_memo->gambarProduk($id)->nama_grade;
		$data['id_mata_uang'] = $currency;
		$data['mata_uang'] = $currency;
		$data['gambar'] = $this->m_memo->gambarProduk($id)->gambar;
		$data['harga'] = $this->m_memo->gambarProduk($id)->harga;
		echo json_encode($data);
	}

	public function getDetailStore()
	{
		$this->fungsi->check_previleges('memo');
		$id = $this->input->post('store');
		
		$data['store'] = $this->m_memo->getRowDetailStore($id)->store;
		$data['no_telp'] = $this->m_memo->getRowDetailStore($id)->no_telp;
		$data['alamat'] = $this->m_memo->getRowDetailStore($id)->alamat;
		echo json_encode($data);
	}

	public function getDetailItem()
	{
		$this->fungsi->check_previleges('memo');
		$id = $this->input->post('item');
		
		$data['gambar'] = $this->m_memo->getRowDetailItem($id)->gambar;
		$data['lebar'] = $this->m_memo->getRowDetailItem($id)->lebar;
		$data['tinggi'] = $this->m_memo->getRowDetailItem($id)->tinggi;
		$data['harga'] = $this->m_memo->getRowDetailItem($id)->harga;
		echo json_encode($data);
	}

	public function getWarnaItem($value='')
	{
		$this->fungsi->check_previleges('memo');
		$id_item = $this->input->post('item');
		$get_data = $this->m_memo->getWarnaItem($id_item);

		// echo $this->db->last_query();
		
		$data = array();

		foreach ($get_data as $val) {
			$data[] = $val;
		}

		echo json_encode($data, JSON_PRETTY_PRINT);
	}

	public function cetak($id) {
		$data = array(
			'id'     => $id, 
			'header' => $this->m_memo->getHeaderCetak($id), 
			'detail' => $this->m_memo->getDataDetailTabel($id),
			);
		$this->load->view('klg/memo/v_cetak',$data);
	}

	public function cetakTabel($value='')
	{
		$data['memo'] = $this->m_memo->getData();
		$this->load->view('klg/memo/v_memo_cetak',$data);
	}


}

/* End of file memo.php */
/* Location: ./application/controllers/klg/memo.php */