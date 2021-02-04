<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_quotation extends CI_Model {

	function __construct() {
        // Set table name
        $this->table = 'data_quotation di';
        // Set orderable column fields
        $this->column_order = array(null, 'no_quotation','nama_proyek','nama_owner','kontak');
        // Set searchable column fields
        $this->column_search = array('di.no_quotation','map.aplikator','map.kontak');
        // Set default order
        // $this->order = array('nama' => 'asc');
    }

    /*
     * Fetch members data from the database
     * @param $_POST filter data based on the posted parameters
     */
    public function getRows($postData){
        $this->_get_datatables_query($postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
		$query = $this->db->get();
		
        return $query->result();
    }
    
    /*
     * Count all records
     */
    public function countAll(){
    	$level = from_session('level');
		$kode_aplikator = from_session('kode_aplikator');
		if ($level =='4') {
			$this->db->where('di.kode_aplikator', $kode_aplikator);
		}
		$this->db->join('master_status_quo msq', 'msq.id = di.status_quotation', 'left');
		$this->db->select('di.*,msq.keterangan as status_quo');
		$this->db->order_by('di.id', 'desc');

        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    
    /*
     * Count records based on the filter params
     * @param $_POST filter data based on the posted parameters
     */
    public function countFiltered($postData){
        $this->_get_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /*
     * Perform the SQL queries needed for an server-side processing requested
     * @param $_POST filter data based on the posted parameters
     */
    private function _get_datatables_query($postData){
    	$level = from_session('level');
		$kode_aplikator = from_session('kode_aplikator');
		if ($level =='4') {
			$this->db->where('di.kode_aplikator', $kode_aplikator);
		}
		$this->db->join('master_status_quo msq', 'msq.id = di.status_quotation', 'left');
		$this->db->join('master_aplikator map', 'map.kode = di.kode_aplikator', 'left');
		
		$this->db->select('di.*,msq.keterangan as status_quo,map.aplikator');
		$this->db->order_by('di.id', 'desc');

        $this->db->from($this->table);
 
        $i = 0;
        // loop searchable columns 
        foreach($this->column_search as $item){
            // if datatable send POST for search
            if($postData['search']['value']){
                // first loop
                if($i===0){
                    // open bracket
                    // $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                }else{
                    $this->db->or_like($item, $postData['search']['value']);
                }
                
                // last loop
                // if(count($this->column_search) - 1 == $i){
                //     // close bracket
                //     $this->db->group_end();
                // }
            }
            $i++;
        }
         
        if(isset($postData['order'])){
            $this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        }else if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    //------------------------------HILIH KINTIL-----------------------------//

	public function getdata($value='')
	{
		$level = from_session('level');
		$kode_aplikator = from_session('kode_aplikator');
		if ($level =='4') {
			$this->db->where('di.kode_aplikator', $kode_aplikator);
		}
		$this->db->join('master_status_quo msq', 'msq.id = di.status_quotation', 'left');
		$this->db->select('di.*,msq.keterangan as status_quo');
		$this->db->order_by('di.id', 'desc');
		return $this->db->get('data_quotation di');
	}

	public function getNoQuotation($value='')
	{
		$year = date('Y');
		$month = date('m');
		$this->db->where('DATE_FORMAT(date,"%Y")', $year);	
		$this->db->where('DATE_FORMAT(date,"%m")', $month);	
		$hasil = $this->db->get('data_quotation');
        if ($hasil->num_rows()>0) {
            return $hasil->num_rows()+1;
        } else {
            return '1';
        }
	}

	public function getCurrency($value='')
	{
		return $this->db->get('master_currency')->result();
	}

	public function getLokasi($value='')
	{
		return $this->db->get('master_lokasi')->result();
	}

	public function getItem($value='')
	{
		$this->db->where('id_status', 1);
		return $this->db->get('master_item')->result();
	}

	public function getTipe($value='')
	{
		return $this->db->get('master_tipe')->result();
	}

	public function getItemTambahan($value='')
	{
		return $this->db->get('master_item_tambahan')->result();
	}
	public function getWarna($value='')
	{
		return $this->db->get('master_warna')->result();
	}

	public function insertData($value='')
	{
		$this->db->insert('data_quotation', $value);
	}

	public function updateData($value='',$id='')
	{
		$this->db->where('id', $id);
		$this->db->update('data_quotation', $value);
	}

	public function getRowItem($value='')
	{
		$this->db->where('kode', $value);
		return $this->db->get('master_item')->row();
	}

	public function getItemDetail($id_jenis='')
	{
		$this->db->select('kode as id, kode, item');
		$this->db->where('mh.id_jenis', $id_jenis);
		return $this->db->get('master_item mh')->result();
	}

	public function getTipeDetail($kd_item='')
	{
		$this->db->join('master_tipe mt', 'mt.kode = mh.kode_tipe', 'left');
		$this->db->where('mh.kode_item', $kd_item);
		$this->db->select('kode_tipe, kode_item, tipe');
		$this->db->group_by(array('kode_item','kode_tipe'));
		return $this->db->get('master_harga_item mh')->result();
	}

	public function getWarnaDetail($id_item='',$id_tipe='')
	{
		$this->db->join('master_warna mt', 'mt.kode = mh.kode_warna', 'left');
		$this->db->where('mh.kode_item', $id_item);
		$this->db->where('mh.kode_tipe', $id_tipe);
		$this->db->select('mh.kode_warna, mt.kode, mt.warna,mh.kode_item, mh.kode_tipe');
		$this->db->group_by(array('kode_item','kode_tipe','kode_warna'));
		return $this->db->get('master_harga_item mh')->result();
	}

	public function getWarnaDetailTambahan($id_item='',$id_tipe='')
	{
		$this->db->join('master_warna mt', 'mt.kode = mh.kode_warna', 'left');
		$this->db->where('mh.kode_item_tambahan', $id_item);
		$this->db->select('mh.kode_warna, mt.warna');
		$this->db->group_by(array('kode_item_tambahan','kode_warna'));
		return $this->db->get('master_harga_item_tambahan mh')->result();
	}

	public function getPanjangDetail($id_item='',$id_tipe='',$id_warna='')
	{
		$this->db->where('mh.id_item', $id_item);
		$this->db->where('mh.id_tipe', $id_tipe);
		$this->db->where('mh.id_warna', $id_warna);
		$this->db->select('mh.panjang');
		return $this->db->get('master_harga_item mh')->result();
	}

	public function getLebarDetail($id_item='',$id_tipe='',$id_warna='',$panjang='')
	{
		$this->db->where('mh.id_item', $id_item);
		$this->db->where('mh.id_tipe', $id_tipe);
		$this->db->where('mh.id_warna', $id_warna);
		$this->db->where('mh.panjang', $panjang);
		$this->db->select('mh.lebar');
		return $this->db->get('master_harga_item mh')->result();
	}

	public function getRowHargaItem($id_item='',$id_tipe='',$id_warna='',$panjang='',$lebar='')
	{
		$this->db->where('mh.id_item', $id_item);
		$this->db->where('mh.id_tipe', $id_tipe);
		$this->db->where('mh.id_warna', $id_warna);
		$this->db->where('mh.panjang', $panjang);
		$this->db->where('mh.lebar', $lebar);
		$this->db->join('master_currency mc', 'mc.id = mh.id_currency', 'left');
		$this->db->select('mh.harga,mc.nama');
		return $this->db->get('master_harga_item mh')->row();
	}

	public function get_harga_item($item='', $tipe='',$warna='',$panjang='',$lebar='')
	{
		$panjang_r=($panjang % 50 !=0 && $panjang !=0)?$panjang + (50 -  $panjang % 50):$panjang;
		$lebar_r=($lebar % 50 !=0 && $lebar !=0)?$lebar + (50 -  $lebar % 50):$lebar;
			return $this->db->query('select
				*
			from
				master_harga_item a
			where
				a.kode_item = "'.$item.'"
			and a.kode_tipe = "'.$tipe.'"
			and a.kode_warna = "'.$warna.'"
			ORDER BY
				abs(panjang - "'.$panjang_r.'") ,
				abs(lebar - "'.$lebar_r.'") limit 1')->row()->harga;
		
		
	}

	public function get_harga_item_tambahan($item='',$warna='')
	{
		$this->db->where('kode_item_tambahan', $item);
		$this->db->where('kode_warna', $warna);
		$hasil = $this->db->get('master_harga_item_tambahan');
        if ($hasil->num_rows()>0) {
            return $hasil->row()->harga;
        } else {
            return '0';
        }
	}
	public function insertDataDetail($value='')
	{
		$this->db->insert('data_quotation_detail', $value);
	}

	public function updateDataDetail($value='',$id='')
	{
		$this->db->where('id', $id);
		$this->db->update('data_quotation_detail', $value);
	}

	public function insertDataDetailTambahan($value='')
	{
		$this->db->insert('data_quotation_item_tambahan', $value);
	}

	public function deleteDetailItem($id='')
	{
		$this->db->where('id', $id);
		$this->db->delete('data_quotation_detail');
	}

	public function deleteDetailItemTambahan($id='')
	{
		$this->db->where('id', $id);
		$this->db->delete('data_quotation_item_tambahan');
	}

	public function saveDownPayment($id='',$value='')
	{
		$obj = array('dp' => $value, );
		$this->db->where('id', $id);
		$this->db->update('data_quotation', $obj);
	}

	public function saveDiskon($id='',$obj='')
	{
		$this->db->where('id', $id);
		$this->db->update('data_quotation_gambar', $obj);
	}

	public function validasi($status='',$id='')
	{
		$obj = array('status_quotation' => $status, );
		$this->db->where('id', $id);
		$this->db->update('data_quotation', $obj);
	}

	public function editDp($value='')
	{
		$this->db->where('id', $value['id']);
		$this->db->update('data_quotation', $value);
	}


	public function getJumDetail($id='')
	{
		$this->db->where('id_quotation', $id);
		return $this->db->get('data_quotation_detail');
	}

	public function getDataDetailQuotation($value='')
	{
		$this->db->join('master_item ms', 'ms.id = ma.id_item', 'left');
		$this->db->join('master_tipe mp', 'mp.id = ma.id_tipe', 'left');
		$this->db->join('master_warna mw', 'mw.id = ma.id_warna', 'left');
		$this->db->join('data_quotation_gambar dqb', 'dqb.id = ma.id_kode_gambar', 'left');
		$this->db->select('ma.id,dqb.kode_gambar,ml.lokasi,ma.panjang,ma.lebar,ma.qty,ma.harga,ms.keterangan,ms.kode,ms.item,mp.tipe,mw.warna');
		$this->db->where('ma.id_quotation', $value);
		return $this->db->get('data_quotation_detail ma')->result();
	}

	public function getRowQuotation($value='')
	{
		$this->db->where('dq.id', $value);
		$this->db->join('master_currency mc', 'mc.id = dq.id_currency', 'left');
		$this->db->select('dq.*,mc.nama');
		return $this->db->get('data_quotation dq')->row();
	}

	public function getRowDetailQuo($value='')
	{
		$this->db->where('dq.id', $value);
		return $this->db->get('data_quotation_detail dq')->row();
	}

	public function cekKodeGambarTersimpan($id_quotation='',$kode_gambar="")
	{
		$this->db->where('id_quotation', $id_quotation);
		$this->db->like('kode_gambar', $kode_gambar);
		$hasil = $this->db->get('data_quotation_gambar');
        if ($hasil->num_rows()>0) {
            return $hasil->row();
        } else {
            return '0';
        }
	}

	public function getKodeGambarTersimpan($id_kode_gambar="")
	{
		$this->db->where('id', $id_kode_gambar);
		$hasil = $this->db->get('data_quotation_gambar');
        return $hasil->row();
        
	}

	public function insertDataKodeGambar($value='')
	{
		$this->db->insert('data_quotation_gambar', $value);
	}

	public function updateDataKodeGambar($id='',$value='')
	{
		$this->db->where('id', $id);
		$this->db->update('data_quotation_gambar', $value);
	}

	

	

	public function getEditQuotation($value='')
	{
		$this->db->where('id', $value);
		return $this->db->get('data_quotation');
	}
	public function getDetailQuotation($id)
	{	
		$this->db->where('dq.id', $id);
		$this->db->join('master_aplikator mapp', 'mapp.kode = dq.kode_aplikator', 'left');
		
		return $this->db->get('data_quotation dq');
	}
	public function getDetailQuotationVers($id)
	{	
		$this->db->order_by('dqd.id_kode_gambar', 'asc');
		$this->db->join('master_item mi', 'mi.kode = dqd.kode_item', 'left');
		$this->db->join('master_tipe mt', 'mt.kode = dqd.kode_tipe', 'left');
		$this->db->join('master_warna mw', 'mw.kode = dqd.kode_warna', 'left');
		$this->db->join('data_quotation_gambar dqg', 'dqg.id = dqd.id_kode_gambar', 'left');
		$this->db->where('dqd.id_quotation', $id);
		$this->db->select('dqd.*,dqg.kode_gambar,mi.item,mt.tipe,mw.warna,mi.gambar');
		$res= $this->db->get('data_quotation_detail dqd');
		// die($this->db->last_query());
		$arr=array();
		foreach($res->result() as $key){
			$arr[$key->id_kode_gambar][]=$key;
		}
		// print_r($arr);
		// die();
		return $arr;
	}
	function getDetailQuotationTamb($id)
	{
		$this->db->join('master_item_tambahan mi', 'mi.kode = dqd.kode_item_tambahan', 'left');
		$this->db->where('dqd.id_quotation', $id);
		$this->db->select('dqd.*,mi.item,mw.warna');
		$res = $this->db->get('data_quotation_item_tambahan dqd');
		$arr=array();
		foreach($res->result() as $key){
			$arr[$key->id_quotation][$key->id_quotation_detail]=$key;
		}
		return $arr;
	}
	

	public function getEditQuotationDetail($value='')
	{
		$this->db->order_by('dqd.id_kode_gambar', 'asc');
		$this->db->join('master_item mi', 'mi.kode = dqd.kode_item', 'left');
		$this->db->join('master_tipe mt', 'mt.kode = dqd.kode_tipe', 'left');
		$this->db->join('master_warna mw', 'mw.kode = dqd.kode_warna', 'left');
		$this->db->join('data_quotation_gambar dqg', 'dqg.id = dqd.id_kode_gambar', 'left');
		$this->db->where('dqd.id_quotation', $value);
		$this->db->select('dqd.*,dqg.kode_gambar,mi.item,mt.tipe,mw.warna');
		return $this->db->get('data_quotation_detail dqd');
	}

	//==============================

	public function getKG($value='')
	{
		$this->db->where('dqd.id_quotation', $value);
		$this->db->join('data_quotation_gambar dqg', 'dqg.id = dqd.id_kode_gambar', 'left');
		$this->db->select('dqd.*,dqg.diskon,dqg.adjustment,dqg.kode_gambar,dqg.ket_qty,dqg.ket_dimensi');
		$this->db->order_by('dqd.id_kode_gambar', 'asc');
		$this->db->group_by('dqd.id_kode_gambar');
		return $this->db->get('data_quotation_detail dqd');
	}

	public function getKGEdit($value='')
	{
		$this->db->where('dqd.id_quotation', $value);
		$this->db->select('dqd.id_kode_gambar');
		$this->db->order_by('dqd.id_kode_gambar', 'asc');
		$this->db->group_by('dqd.id_kode_gambar');
		return $this->db->get('data_quotation_detail dqd');
	}

	public function getKGEditDetail($id='')
	{
		$this->db->where('id', $id);
		return $this->db->get('data_quotation_gambar');
	}

	public function getKGdetail($value='')
	{
		$this->db->join('master_item mi', 'mi.kode = dqd.kode_item', 'left');
		$this->db->join('master_tipe mt', 'mt.kode = dqd.kode_tipe', 'left');
		$this->db->join('master_warna mw', 'mw.kode = dqd.kode_warna', 'left');
		$this->db->join('data_quotation_gambar dqg', 'dqg.id = dqd.id_kode_gambar', 'left');
		$this->db->where('dqd.id_kode_gambar', $value);
		$this->db->select('dqd.*,dqg.kode_gambar,dqg.ket_qty,dqg.ket_dimensi,dqg.keterangan,dqg.adjustment,dqg.diskon,mi.item,mi.gambar,mt.tipe,mw.warna');
		return $this->db->get('data_quotation_detail dqd');
	}

	public function getKGdetailCetak($value='')
	{
		$this->db->join('master_item mi', 'mi.kode = dqd.kode_item', 'left');
		$this->db->join('master_tipe mt', 'mt.kode = dqd.kode_tipe', 'left');
		$this->db->join('master_warna mw', 'mw.kode = dqd.kode_warna', 'left');
		$this->db->join('data_quotation_gambar dqg', 'dqg.id = dqd.id_kode_gambar', 'left');
		$this->db->join('data_quotation_item_tambahan dqit', 'dqit.id_quotation_detail = dqd.id', 'left');
		$this->db->join('master_item_tambahan mit', 'mit.kode = dqit.kode_item_tambahan', 'left');
		$this->db->where('dqd.id_kode_gambar', $value);
		$this->db->limit('1');
		$this->db->order_by('dqit.id', 'desc');
		$this->db->select('dqd.*,dqg.*,dqit.harga_tambahan,dqit.qty_tambahan,mit.item as item_tambahan,mi.item,mi.gambar,mt.tipe,mw.warna');
		return $this->db->get('data_quotation_detail dqd');
	}

	public function getJustItemCetak($value='')
	{
			
		$this->db->join('master_item mi', 'mi.kode = dqd.kode_item', 'left');
		$this->db->where('dqd.id_kode_gambar', $value);
		$this->db->select('mi.item');
		return $this->db->get('data_quotation_detail dqd');
	}

	public function getRowItemTipe($value='')
	{
		$this->db->join('master_item mi', 'mi.kode = dqd.kode_item', 'left');
		$this->db->where('dqd.id_kode_gambar', $value);
		$this->db->where('dqd.kode_tipe', 'ADD');
		$this->db->select('mi.item,dqd.qty,dqd.harga');
		return $this->db->get('data_quotation_detail dqd');
	}
	// public function getRowHargaTipe($value='')
	// {
	// 	$this->db->join('master_item mi', 'mi.kode = dqd.kode_item', 'left');
	// 	$this->db->where('dqd.id_kode_gambar', $value);
	// 	$this->db->where('dqd.kode_tipe', 'ADD');
	// 	$this->db->select('mi.item,dqd.qty,dqd.harga');
	// 	$hasil = $this->db->get('data_quotation_detail dqd');
 //        if ($hasil->num_rows()>0) {
 //            return $hasil->row()->harga;
 //        } else {
 //            return 0;
 //        }
	// }



	public function getKGdetailTambahan($value='')
	{
		$this->db->join('master_item_tambahan mi', 'mi.kode = dqd.kode_item_tambahan', 'left');
		$this->db->where('dqd.id_quotation_detail', $value);
		$this->db->select('dqd.*,mi.item,mw.warna');
		return $this->db->get('data_quotation_item_tambahan dqd');
	}

	public function getKounKode($value='')
	{
		$this->db->where('id_kode_gambar', $value);
		$this->db->select('COUNT(id_kode_gambar) as koun');
		$this->db->group_by('id_kode_gambar');
		return $this->db->get('data_quotation_detail');
	}

	//=========================

	public function getQuotationDetail($value='')
	{
		$this->db->order_by('dqd.id_kode_gambar', 'asc');
		$this->db->join('master_item mi', 'mi.kode = dqd.kode_item', 'left');
		$this->db->join('master_tipe mt', 'mt.kode = dqd.kode_tipe', 'left');
		$this->db->join('master_warna mw', 'mw.kode = dqd.kode_warna', 'left');
		$this->db->join('data_quotation_gambar dqg', 'dqg.id = dqd.id_kode_gambar', 'left');
		$this->db->where('dqd.id_quotation', $value);
		$this->db->select('dqd.*,dqg.kode_gambar,mi.item,mt.tipe,mw.warna');
		$transaksi=$this->db->get('data_quotation_detail dqd');
		$all = array();
        foreach($transaksi->result() as $row)
        {
            
            // $all[$row->kode_gambar]=>$row();
			
		}
		return $all;
	}
	public function getAplikator($value='')
	{
		
		$this->db->select('mapp.*');
		return $this->db->get('master_aplikator mapp');
	}

	public function getStatusQuotation($value='',$kode='',$dari_tgl='',$sampai_tgl='')
	{
		$level = from_session('level');
		if ($level == '4') {
			$this->db->where('kode_aplikator', $kode);
		}
		if ($kode !='x') {
			$this->db->where('kode_aplikator', $kode);
		}
		if ($dari_tgl !='x') {
			$this->db->where('DATE(date) >=', $dari_tgl);
		}
		if ($sampai_tgl !='x') {
			$this->db->where('DATE(date) <=', $sampai_tgl);
		}
		$this->db->where('status_quotation', $value);
		$this->db->select('COUNT(status_quotation) as jumlah');
		return $this->db->get('data_quotation');
	}

	public function getRowAplikator($kode='')
	{
		$this->db->where('kode', $kode);
		return $this->db->get('master_aplikator')->row();
	}

	
	

}

/* End of file m_quotation.php */
/* Location: ./application/models/klg/m_quotation.php */