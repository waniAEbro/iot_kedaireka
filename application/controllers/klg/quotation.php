<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quotation extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->fungsi->restrict();
		$this->load->model('klg/m_quotation');
	}

	public function index()
	{
		$this->fungsi->check_previleges('quotation');
		$this->load->view('klg/quotation/v_quotation_list');
	}

	function getLists(){
		$data = $row = array();
        
        $memData = $this->m_quotation->getRows($_POST);
        
        $i = $_POST['start'];
        foreach($memData as $member){
            $i++;
            $data[] = array($i,$member->id, $member->no_quotation,$member->aplikator, $member->nama_proyek, $member->nama_owner, $member->kontak, $member->status_quo);
        }
        
        $output = array(
			"draw"            => $_POST['draw'],
			"recordsTotal"    => $this->m_quotation->countAll(),
			"recordsFiltered" => $this->m_quotation->countFiltered($_POST),
			"data"            => $data,
        );
        
        echo json_encode($output);
    }

	public function formAdd($value='')
	{
		$this->fungsi->check_previleges('quotation');
		$level = from_session('level');
		
		
		$data = array(
			'currency' => $this->m_quotation->getCurrency(),
			'item' => $this->m_quotation->getItem(),
			'tipe' => $this->m_quotation->getTipe(),
			'item_tambahan' => $this->m_quotation->getItemTambahan(),
			'warna' => $this->m_quotation->getWarna(),
			 );
		if ($level == 1) {
			$data['aplikator'] 		= $this->m_quotation->getAplikator();
			$data['no_quotation'] 	= $this->m_quotation->getNoQuotation();
		}
		else {
			$data['aplikator'] 		= from_session('kode_aplikator');
			$data['no_quotation'] 	= str_pad($this->m_quotation->getNoQuotation(), 3, '0', STR_PAD_LEFT).'/ASTRAL'.'/'.$data['aplikator'].'/'.date('m').'/'.date('Y');
		}
		$this->load->view('klg/quotation/v_quotation_add',$data);
	}

	public function insertQuotation($value='')
	{
		$this->fungsi->check_previleges('quotation');
		$level = from_session('level');
		if ($level == '2') {
			$s_q = "2";
		} else {
			$s_q = "1";
		}
		
		$data = array(
			'id_penginput'     => from_session('id'), 
			'kode_aplikator'   => $this->input->post('kode_aplikator'), 
			'no_quotation'     => $this->input->post('no_quotation'), 
			'id_currency'      => $this->input->post('currency'), 
			'nama_proyek'      => $this->input->post('nama_proyek'), 
			'nama_owner'       => $this->input->post('owner'), 
			'kontak'           => $this->input->post('kontak'), 
			'no_quotation_cus' => $this->input->post('no_quotation_cus'), 
			'alamat_proyek'    => $this->input->post('alamat'), 
			'keterangan'       => $this->input->post('keterangan'), 
			'date'             => date('Y-m-d H:i:s'), 
			'status_quotation' => $s_q, 
			);
		$this->m_quotation->insertData($data);
		$data['id'] = $this->db->insert_id();
		$this->fungsi->catat($data,"Menambah Quotation dengan data sbb:",true);
		echo json_encode($data);

	}

	public function updateQuotation($value='')
	{
		$this->fungsi->check_previleges('quotation');
		
		
		$data = array(
			'id_penginput'     => from_session('id'), 
			'kode_aplikator'   => $this->input->post('kode_aplikator'), 
			'no_quotation'     => $this->input->post('no_quotation'), 
			'id_currency'      => $this->input->post('currency'), 
			'nama_proyek'      => $this->input->post('nama_proyek'), 
			'nama_owner'       => $this->input->post('owner'), 
			'kontak'           => $this->input->post('kontak'), 
			'no_quotation_cus' => $this->input->post('no_quotation_cus'), 
			'alamat_proyek'    => $this->input->post('alamat'), 
			'keterangan'       => $this->input->post('keterangan'), 
			'date'             => date('Y-m-d H:i:s'),
			);
		$this->m_quotation->updateData($data,$this->input->post('id'));
		$data['id'] = '';
		$this->fungsi->catat($data,"Mengubah Quotation dengan data sbb:",true);
		echo json_encode($data);

	}

	public function cekKodeGambar($value='')
	{
		$this->fungsi->check_previleges('quotation');

		$id_quotation = $this->input->post('id_quotation');
		$kode_gambar  = str_replace(' ', '', $this->input->post('kode_gambar'));
		$ket_qty      = $this->input->post('ket_qty');
		$ket_dimensi  = $this->input->post('ket_dimensi');
		$keterangan  = $this->input->post('keterangan');

		$cekKodeGambarTersimpan = $this->m_quotation->cekKodeGambarTersimpan($id_quotation,$kode_gambar);
		
		$data_kode_gambar = array(
			'id_quotation' => $id_quotation, 
			'kode_gambar'  => $kode_gambar, 
			'ket_qty'      => $ket_qty, 
			'ket_dimensi'  => $ket_dimensi, 
			'keterangan'   => $keterangan, 
		);
			if ($cekKodeGambarTersimpan == '0') {
				
				$this->m_quotation->insertDataKodeGambar($data_kode_gambar);
				$data['id_kode_gambar'] = $this->db->insert_id();
				$data['status'] = 'o';
			} else {
				$data['id_kode_gambar'] = $cekKodeGambarTersimpan->id;
				$data['kode_gambar']    = $cekKodeGambarTersimpan->kode_gambar;
				$data['ket_qty']        = $cekKodeGambarTersimpan->ket_qty;
				$data['ket_dimensi']    = $cekKodeGambarTersimpan->ket_dimensi;
				$data['keterangan']     = $cekKodeGambarTersimpan->keterangan;
				$data['status'] = 'x';
			}
		echo json_encode($data);
	}

	public function loadKodeGambar($value='')
	{
		$this->fungsi->check_previleges('quotation');
		$id_kode_gambar = $this->input->post('id_kode_gambar');
		$getKodeGambarTersimpan = $this->m_quotation->getKodeGambarTersimpan($id_kode_gambar);
		$data['id_kode_gambar'] = $getKodeGambarTersimpan->id;
		$data['kode_gambar']    = $getKodeGambarTersimpan->kode_gambar;
		$data['ket_qty']        = $getKodeGambarTersimpan->ket_qty;
		$data['ket_dimensi']    = $getKodeGambarTersimpan->ket_dimensi;
		$data['keterangan']     = $getKodeGambarTersimpan->keterangan;
		$data['adjustment']     = $getKodeGambarTersimpan->adjustment;
		$data['diskon']         = $getKodeGambarTersimpan->diskon;
		echo json_encode($data);

	}

	public function getGambar()
	{
		$this->fungsi->check_previleges('quotation');
		$id = $this->input->post('item');		
		$data['gambar'] = $this->m_quotation->getRowItem($id)->gambar;
		echo json_encode($data);
	}

	public function getTipeItem($value='')
	{
		$this->fungsi->check_previleges('quotation');
		$id_item = $this->input->post('item');
		$get_data = $this->m_quotation->getTipeDetail($id_item);

		// echo $this->db->last_query();
		
		$data = array();

		foreach ($get_data as $val) {
			$data[] = $val;
		}

		echo json_encode($data, JSON_PRETTY_PRINT);
	}

	public function getWarnaItem($value='')
	{
		$this->fungsi->check_previleges('quotation');
		$id_item = $this->input->post('item');
		$id_tipe = $this->input->post('tipe');
		$get_data = $this->m_quotation->getWarnaDetail($id_item,$id_tipe);
		$data = array();

		foreach ($get_data as $val) {
			$data[] = $val;
		}

		echo json_encode($data, JSON_PRETTY_PRINT);
	}

	public function insertQuotationDetail($value='')
	{
		$this->fungsi->check_previleges('quotation');

		$harga = $this->m_quotation->get_harga_item($this->input->post('item'),$this->input->post('tipe'),$this->input->post('warna'),$this->input->post('panjang'),$this->input->post('lebar'));
		
		$data = array(
			'id_quotation'   => $this->input->post('id_quotation'), 
			'id_kode_gambar' => $this->input->post('id_kode_gambar'), 
			'lokasi'      	=> $this->input->post('lokasi'), 
			'kode_item'      => $this->input->post('item'), 
			'kode_tipe'      => $this->input->post('tipe'), 
			'daun'           => $this->input->post('daun'), 
			'kode_warna'     => $this->input->post('warna'), 
			'panjang'        => $this->input->post('panjang'), 
			'lebar'          => $this->input->post('lebar'), 
			'harga'          => $harga, 
			'qty'            => $this->input->post('jumlah'),
			);
		$this->m_quotation->insertDataDetail($data);
		$data['id_k_gambar'] = $this->input->post('id_kode_gambar');
		$this->fungsi->catat($data,"Menambah quotation detail dengan data sbb:",true);
		echo json_encode($data);

	}

	public function updateQuotationDetail($value='')
	{
		$this->fungsi->check_previleges('quotation');
		$id = $this->input->post('id');
		$harga = $this->m_quotation->get_harga_item($this->input->post('item'),$this->input->post('tipe'),$this->input->post('warna'),$this->input->post('panjang'),$this->input->post('lebar'));
		
		$data = array(
			
			'lokasi'      	=> $this->input->post('lokasi'), 
			'kode_item'      => $this->input->post('item'), 
			'kode_tipe'      => $this->input->post('tipe'), 
			'daun'           => $this->input->post('daun'), 
			'kode_warna'     => $this->input->post('warna'), 
			'panjang'        => $this->input->post('panjang'), 
			'lebar'          => $this->input->post('lebar'), 
			'harga'          => $harga, 
			'qty'            => $this->input->post('jumlah'),
			);
		$this->m_quotation->updateDataDetail($data,$id);
		$data['id_k_gambar'] = $this->input->post('id_kode_gambar');
		$this->fungsi->catat($data,"Mengubah quotation detail dengan data sbb:",true);
		echo json_encode($data);

	}

	public function getQuoTabel($value='')
	{
		$this->fungsi->check_previleges('quotation');
		$id_kode_gambar = $this->input->post('id_kode_gambar');
		$data['detail'] = $this->m_quotation->getKGdetail($id_kode_gambar)->result();
		echo json_encode($data);
	}

	public function deleteItem() {
		$this->fungsi->check_previleges('quotation');
		$id = $this->input->post('id');
		$data = array('id' => $id, );
		$this->m_quotation->deleteDetailItem($id);
		$this->fungsi->catat($data,"Menghapus quotation Detail dengan data sbb:",true);
		$respon = ['msg' => 'Data Berhasil Dihapus'];
		echo json_encode($respon);
	}

	public function deleteItemTambahan() {
		$this->fungsi->check_previleges('quotation');
		$id = $this->input->post('id');
		$data = array('id' => $id, );
		$this->m_quotation->deleteDetailItemTambahan($id);
		$this->fungsi->catat($data,"Menghapus quotation Detail dengan data sbb:",true);
		$respon = ['msg' => 'Data Berhasil Dihapus'];
		echo json_encode($respon);
	}

	public function editItem($value='')
	{
		$this->fungsi->check_previleges('quotation');
		$id = $this->input->post('id');
		$getData = $this->m_quotation->getRowDetailQuo($id);
		// $this->m_quotation->deleteDetailItemTambahan($id);
		// $this->fungsi->catat($data,"Menghapus quotation Detail dengan data sbb:",true);
		$respon = [
		'id_quotation' => $getData->id_quotation,
		'id_kode_gambar' => $getData->id_kode_gambar,
		'lokasi' => $getData->lokasi,
		'item' => $getData->kode_item,
		'tipe' => $getData->kode_tipe,
		'daun' => $getData->daun,
		'warna' => $getData->kode_warna,
		'panjang' => $getData->panjang,
		'lebar' => $getData->lebar,
		'qty' => $getData->qty,
		'msg' => 'Data Berhasil Dihapus',
		];
		echo json_encode($respon);
	}

	public function insertQuotationDetailTambahan($value='')
	{
		$this->fungsi->check_previleges('quotation');

		$harga = $this->m_quotation->get_harga_item_tambahan($this->input->post('kode_item_tambahan'));
			
		$data = array(
			'id_quotation' => $this->input->post('id_quotation'), 
			'id_quotation_detail' => $this->input->post('id_quotation_detail'), 
			'kode_item_tambahan'  => $this->input->post('kode_item_tambahan'),
			'harga_tambahan'      => $harga, 
			'qty_tambahan'        => $this->input->post('qty_tambahan'),
			);
		$this->m_quotation->insertDataDetailTambahan($data);
		$data['id'] = $this->db->insert_id();
		$this->fungsi->catat($data,"Menambah quotation item tambahan dengan data sbb:",true);
		echo json_encode($data);

	}

	public function getQuoTabelTambahan($value='')
	{
		$this->fungsi->check_previleges('quotation');
		$id_quotation_detail = $this->input->post('id_quotation_detail');
		$data['detail'] = $this->m_quotation->getKGdetailTambahan($id_quotation_detail)->result();
		echo json_encode($data);
	}


	public function getItem($value='')
	{
		$this->fungsi->check_previleges('quotation');
		$id_jenis = $this->input->post('jenis_item');
		$get_data = $this->m_quotation->getItemDetail($id_jenis);
		$data = array();

		foreach ($get_data as $val) {
			$data[] = $val;
		}

		echo json_encode($data, JSON_PRETTY_PRINT);
	}

	public function getKetentuan($value='')
	{
		$this->fungsi->check_previleges('quotation');
		$kode_aplikator = $this->input->post('kode_aplikator');
		$data['ketentuan'] = $this->m_quotation->getRowAplikator($kode_aplikator)->ketentuan;
		echo json_encode($data);
	}

	

	public function getWarnaItemTambahan($value='')
	{
		$this->fungsi->check_previleges('quotation');
		$id_item = $this->input->post('item');
		$get_data = $this->m_quotation->getWarnaDetailTambahan($id_item);
		$data = array();

		foreach ($get_data as $val) {
			$data[] = $val;
		}

		echo json_encode($data, JSON_PRETTY_PRINT);
	}

	public function getPanjangItem($value='')
	{
		$this->fungsi->check_previleges('quotation');
		$id_item = $this->input->post('item');
		$id_tipe = $this->input->post('tipe');
		$id_warna = $this->input->post('warna');
		$get_data = $this->m_quotation->getPanjangDetail($id_item,$id_tipe,$id_warna);
		$data = array();

		foreach ($get_data as $val) {
			$data[] = $val;
		}

		echo json_encode($data, JSON_PRETTY_PRINT);
	}

	public function getLebarItem($value='')
	{
		$this->fungsi->check_previleges('quotation');
		$id_item = $this->input->post('item');
		$id_tipe = $this->input->post('tipe');
		$id_warna = $this->input->post('warna');
		$panjang = $this->input->post('panjang');
		$get_data = $this->m_quotation->getLebarDetail($id_item,$id_tipe,$id_warna,$panjang);
		$data = array();

		foreach ($get_data as $val) {
			$data[] = $val;
		}

		echo json_encode($data, JSON_PRETTY_PRINT);
	}

	public function getHargaItem($value='')
	{
		$this->fungsi->check_previleges('quotation');
		$id_item = $this->input->post('item');
		$id_tipe = $this->input->post('tipe');
		$id_warna = $this->input->post('warna');
		$panjang = $this->input->post('panjang');
		$lebar = $this->input->post('lebar');
		$data['harga'] = $this->m_quotation->getRowHargaItem($id_item,$id_tipe,$id_warna,$panjang,$lebar)->harga;
		$data['mata_uang'] = $this->m_quotation->getRowHargaItem($id_item,$id_tipe,$id_warna,$panjang,$lebar)->nama;
		echo json_encode($data);
	}

	

	

	public function saveDp($value='')
	{
		$this->fungsi->check_previleges('quotation');
		$id = $this->input->post('id_quotation');
		$dp = $this->input->post('dp');
		$data = array(
			'id' => $id, 
			'dp' =>  $dp, 
			);
		$this->m_quotation->saveDownPayment($id,$dp);
		$respon = ['msg' => 'Berhasil Menyimpan DP'];
		$this->fungsi->catat($data,"Menambah DownPayment quotation dengan data sbb:",true);
		echo json_encode($respon);
	}

	public function saveDiskon($value='')
	{
		$this->fungsi->check_previleges('quotation');
		$id          = $this->input->post('id_kode_gambar');
		$kode_gambar = $this->input->post('kode_gambar');
		$ket_qty     = $this->input->post('ket_qty');
		$ket_dimensi = $this->input->post('ket_dimensi');
		$keterangan  = $this->input->post('keterangan');
		$adjustment  = $this->input->post('adjustment');
		$diskon      = $this->input->post('diskon');
		$data = array(
			'id'          => $id,
			'kode_gambar' => $kode_gambar, 
			'ket_qty'     => $ket_qty, 
			'ket_dimensi' => $ket_dimensi, 
			'keterangan'  => $keterangan, 
			'adjustment'  => $adjustment, 
			'diskon'      => $diskon, 
			);
		$this->m_quotation->saveDiskon($id,$data);

		$getKodeGambarTersimpan = $this->m_quotation->getKodeGambarTersimpan($id);
		$respon = [
			'msg'         => 'Berhasil Mengubah Diskon dan Adjustment',
			'kode_gambar' => $getKodeGambarTersimpan->kode_gambar, 
			'ket_qty'     => $getKodeGambarTersimpan->ket_qty, 
			'ket_dimensi' => $getKodeGambarTersimpan->ket_dimensi, 
			'keterangan'  => $getKodeGambarTersimpan->keterangan, 
			'adjustment'  => $getKodeGambarTersimpan->adjustment,
			'diskon'      => $getKodeGambarTersimpan->diskon,
		];
		$this->fungsi->catat($data,"Mengubah Diskon dan Adjustment dengan data sbb:",true);
		echo json_encode($respon);
	}

	public function getDetailQuotation($value='')
	{
		$this->fungsi->check_previleges('quotation');
		$id_quotation = $this->input->post('id_quotation');
		$data['detail'] = $this->m_quotation->getDataDetailQuotation($id_quotation);
		$data['dp'] = $this->m_quotation->getRowQuotation($id_quotation)->dp;
		$data['mata_uang'] = $this->m_quotation->getRowQuotation($id_quotation)->nama;

		echo json_encode($data);
	}

	

	public function cekKodeGambarKet($value='')
	{
		$this->fungsi->check_previleges('quotation');	
		$id_kode_gambar = $this->input->post('id_kode_gambar');
		$keterangan_kg = $this->input->post('keterangan_kg');
		
		$data_kode_gambar = array( 
			'keterangan_kg' => $keterangan_kg, 
		);
		
		$this->m_quotation->updateDataKodeGambar($id_kode_gambar,$data_kode_gambar);
		$data['keterangan_kg']='';
		echo json_encode($data);
	}

	

	public function formEdit($value='')
	{
		$this->fungsi->check_previleges('quotation');
		$level = from_session('level');
		if ($level == 1) {
			$kode_aplikator = 'AP01'; 
		} else {
			$kode_aplikator = 'DK01';
		}
		
		$data = array(
			'currency'      => $this->m_quotation->getCurrency(),
			'item'          => $this->m_quotation->getItem(),
			'no_quotation'  => str_pad($this->m_quotation->getNoQuotation(), 3, '0', STR_PAD_LEFT).'/ASTRAL'.'/'.$kode_aplikator.'/'.date('m').'/'.date('Y'),
			'quotation'     => $this->m_quotation->getEditQuotation($value),
			'id_value'      => $value,
			'item_tambahan' => $this->m_quotation->getItemTambahan(),
			'warna'         => $this->m_quotation->getWarna(),
			 );
		$this->load->view('klg/quotation/v_quotation_edit',$data);
	}

	public function validasi($status='',$id='')
	{
		$this->fungsi->check_previleges('quotation');
		$datapost = array(
			'status' => $status, 
			'id_quotation' => $id, 
			);
		$this->m_quotation->validasi($status,$id);
		$this->fungsi->message_box("Berhasi Validasi","success");
		$this->fungsi->catat($datapost,"Admin Validasi:",true);
		$this->fungsi->run_js('load_silent("klg/quotation","#content")');

	}


	public function editDP($id='')
	{
		$this->fungsi->check_previleges('quotation');
		$no_quotation = $this->m_quotation->getRowQuotation($id)->no_quotation;
		$content   = "<div id='divsubcontent'></div>";
		$header    = "Edit Down Payment Quotation: ".$no_quotation;
		$subheader = $no_quotation;
		$buttons[] = button('','Tutup','btn btn-default','data-dismiss="modal"');
		echo $this->fungsi->parse_modal($header,$subheader,$content,$buttons,"");
		$this->fungsi->run_js('load_silent("klg/quotation/showEditDp/'.$id.'","#divsubcontent")');
	}

	public function showEditDp($id='')
	{
		$this->fungsi->check_previleges('quotation');
		$this->load->library('form_validation');
		$config = array(
				array(
					'field'	=> 'id',
					'label' => 'wes mbarke',
					'rules' => ''
				),
				array(
					'field'	=> 'dp',
					'label' => 'dp',
					'rules' => 'required'
				)
			);
		$this->form_validation->set_rules($config);
		$this->form_validation->set_error_delimiters('<span class="error-span">', '</span>');

		if ($this->form_validation->run() == FALSE)
		{
			$data['edit'] = $this->db->get_where('data_quotation',array('id'=>$id));
			$this->load->view('klg/quotation/v_quotation_dp',$data);
		}
		else
		{
			$datapost = get_post_data(array('id','dp'));
			$this->m_quotation->editDp($datapost);
			$this->fungsi->run_js('load_silent("klg/quotation","#content")');
			$this->fungsi->message_box("DP di perbarui","success");
			$this->fungsi->catat($datapost,"Mengubah DP dg data sbb :",true);
		}
	}
	public function cetak_quotation($id_quotation)//pdf output
	{
		
		$data['quo']=$this->m_quotation->getDetailQuotation($id_quotation)->row();
		$data['det']=$this->m_quotation->getDetailQuotationVers($id_quotation);
		$data['tam']=$this->m_quotation->getDetailQuotationTamb($id_quotation);
		$data['showKG']=$this->m_quotation->getKG($id_quotation)->result();
		$this->load->view('klg/quotation/cetak_quotation',$data);
	}
	public function cetak_quotation2($id_quotation)
	{
		$data['quo']=$this->m_quotation->getDetailQuotation($id_quotation)->row();
		$data['det']=$this->m_quotation->getDetailQuotationVers($id_quotation);
		$data['tam']=$this->m_quotation->getDetailQuotationTamb($id_quotation);
		$data['showKG']=$this->m_quotation->getKG($id_quotation)->result();
		$this->load->view('klg/quotation/cetak_quotation_2',$data);
	}
	public function cetak_quotation3($id_quotation)
	{
		$data['quo']=$this->m_quotation->getDetailQuotation($id_quotation)->row();
		$data['det']=$this->m_quotation->getDetailQuotationVers($id_quotation);
		$data['tam']=$this->m_quotation->getDetailQuotationTamb($id_quotation);
		$data['showKG']=$this->m_quotation->getKG($id_quotation)->result();
		$this->load->view('klg/quotation/cetak_quotation_3',$data);
	}
	public function cetak_exe2($data)
	{
		// print_r($data);
		$this->load->view('klg/quotation/cetak_quotation2',$data);
	}

	public function copy($id_quotation='')
	{
		$this->fungsi->check_previleges('quotation');
		$this->load->view('klg/quotation/v_quotation_list');
	}

	

}

/* End of file quotation.php */
/* Location: ./application/controllers/klg/quotation.php */